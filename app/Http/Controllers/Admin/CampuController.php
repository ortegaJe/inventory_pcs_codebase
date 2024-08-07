<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AllCampuByRegionalExport;
use App\Exports\CampuByRegionalExport;
use App\Exports\CampusExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCampuRequest;
use App\Models\Campu;
use App\Models\CampuUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Str;

class CampuController extends Controller
{
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    // Método privado para construir la consulta base de campus
    private function baseCampuQuery()
    {
        return Campu::leftJoin('regional', 'regional.id', 'campus.regional_id')
            ->select(
                'campus.id as campu_id',
                'campus.name as campu_name',
                'regional.name as regional',
                DB::raw("CASE WHEN DATEDIFF(CURDATE(), campus.created_at) <= 3 THEN 'Nuevo' ELSE 'Antiguo' END AS new_campu")
            )
            ->where('campus.is_active', true)
            ->orderBy('campus.name', 'asc');
    }

    public function index()
    {
        $regionals = DB::table('regional')->orderBy('name')->get();
        $campus = $this->baseCampuQuery()->count();
        return view('admin.sedes.index',compact('regionals', 'campus'));
    }

    // Método público para obtener todos los campus
    public function getCampus()
    {
        $campus = $this->baseCampuQuery()->get();
        return response()->json($campus);
    }

    // Método público para obtener campus por regional
    public function campuByRegional($id)
    {
        $regionals = $this->baseCampuQuery()
            ->addSelect(
                'users.name',
                'users.last_name'
            )
            ->leftJoin('campu_users', 'campu_users.campu_id', 'campus.id')
            ->leftJoin('users', 'users.id', 'campu_users.user_id')
            ->where('campus.regional_id', $id)
            ->orderBy('campus.name', 'asc')
            ->get();

        return response()->json($regionals);
    }

    public function getRegionals()
    {
        $data = [];

        $regionals = DB::table('regional')->orderBy('name', 'asc')->get(['name','id']);
        $allOption = (object) ['id' => 0, 'name' => 'TODAS'];
        $regionals->prepend($allOption);

        $data['regionals'] = $regionals;

        if ($regionals->isEmpty()) {
            return response()->json(['message' => 'No se encontraron regionales para seleccionar'], 404);
        }

        return response()->json($data);
    }

    public function autoCompleteSearch(Request $request)
    {
        $query = $request->get('search');

        $filterResult = Campu::where('name', 'LIKE', '%' . $query . '%')->where('is_active', true)->get();

        return response()->json($filterResult);
    }

    public function exportCampu($campuId, $campu)
    {
        $rand = Str::upper(Str::random(12));

        //$exceptColumn = $campuId->except('CampuID');

        return $this->excel->download(
            new CampusExport($campuId,$campu),
            "export_inventory_" . Str::slug($campu) . "_devices_" . $rand . ".xlsx"
        );
    }

    public function exportCampuByRegional(Request $request)
    {
        $regional = $request->post('regional');
        //error_log(__LINE__ . __METHOD__ . ' regional --->' .$regional);
        $regional_name = DB::table('regional')->where('id', $regional)->pluck('name')->first();
        return $this->excel->download(new CampuByRegionalExport($regional, $regional_name),"export.xlsx");
    }

    public function exportAllCampuByRegional()
    {
        return $this->excel->download(new AllCampuByRegionalExport,"export.xlsx");
    }

    public function assingUserCampu(Request $request, $id)
    {
        $userId = $request->get('list_users');
        $campuId = Campu::findOrFail($id);

        $update = array('user_id' => $userId, 'is_principal' => false, 'is_active' => true, 'updated_at' => now('America/Bogota'));
        DB::table('campu_users')->where('campu_id', $campuId->id)->update($update);
        return back()->with('assigned', '');
    }

    public function removeUserCampu(Request $request)
    {
        $campu = null;
        $userCampuRemoved = [];
        $userId = $request->post('userId');
        $campuId = session('campu_id'); // Recupera el ID de la sesión

            if (!$campuId) {
                return response()->json(['error' => 'No se encontró el ID de la sede.'], 404);
            }

        $ts = now('America/Bogota')->toDateTimeString();
        //error_log(__LINE__ . __METHOD__ . ' user_id --->' . $userId);
        try {

            $userCampuRemoved[] = DB::table('campus as c')
                ->select(
                    'c.id as SedeID',
                    'c.name as NombreSede',
                    'u.id as UserID',
                    DB::raw("CONCAT(UPPER(u.name),' ',UPPER(u.last_name)) as NombreCompletoTecnico")
                )
                ->leftJoin('campu_users as cu', 'cu.campu_id', 'c.id')
                ->leftJoin('users as u', 'u.id', 'cu.user_id')
                ->where('cu.campu_id', $campuId)
                ->get();

            $update = array('is_active' => false, 'updated_at' => $ts);
            DB::table('campu_users')->where('user_id', $userId)->update($update);

        } catch (ModelNotFoundException $e) {
            // Handle the error.
            return $e;
        }

        return response()->json([
            'message' => 'Ya no se encuentra asignado a la sede',
            'result' => $userCampuRemoved[0],
        ]);
    }

    public function create()
    {        
        return view('admin.sedes.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'abreviature' => 'required|unique:campus,abreviature',
            'name'        => 'required|unique:campus,name',
            'regional'    => 'required|not_in:0'
        ]);

        $campu = new Campu();
        $campu->abreviature = $request->abreviature;
        $campu->name        = $request->name;
        $campu->slug        = Str::slug($request->name);
        $campu->address     = $request->address;
        $campu->phone       = $request->phone;
        $campu->regional_id = $request->regional;
        $campu->profile_id  = 2;
        $campu->created_at  = now('America/Bogota');

        $campu->save();

        return redirect()->route('admin.inventory.campus.index', $campu)
            ->with('success', 'Sede ' . $campu->name);
    }

    public function show($id)
    {
        $campus = Campu::leftJoin('regional', 'regional.id','campus.regional_id')
                    ->select('campus.id',
                             'campus.name',
                             'campus.abreviature',
                             'campus.slug',
                             'campus.address',
                             'regional.id as regional_id',
                             'regional.name as regional'
                             )->findOrFail($id);

        session(['campu_id' => $id]);

        $userLists = User::all();

        $typeDevices = DB::table('devices as d')
            ->leftJoin('type_devices as td', 'td.id', 'd.type_device_id')
            ->leftJoin('components as c', 'c.device_id', 'd.id')
            ->select(
                DB::raw("COUNT(d.type_device_id) AS numberTypeDevice"),
                'td.name as nameTypeDevice',
                'd.campu_id as SedeId'
            )
            ->where('d.campu_id', $id)
            ->groupBy('d.type_device_id', 'td.name', 'd.campu_id')
            ->get();
        //return response()->json($typeDevices);

        $campusCount = DB::table('devices')
            ->select('campu_id')
            ->where('campu_id', $id)
            ->count();

        $data =
            [
                'campus' => $campus,
                'typeDevices' => $typeDevices,
                'campusCount' => $campusCount,
                'userLists' => $userLists,
            ];

        return view('admin.sedes.show')->with($data);
    }

    public function userCardCampu()
    {
        $campuId = session('campu_id'); // Recupera el ID de la sesión

        if (!$campuId) {
            return response()->json(['error' => 'No se encontró el ID de la sede.'], 404);
        }

        $userCardData = [];

        $getIdUserByCampus = DB::table('campu_users')
            ->select('user_id')
            ->where('campu_id', $campuId)
            ->first();

        $campuCount = DB::table('campu_users')
            ->select(DB::raw("COUNT(user_id) AS NumberCampus"))
            //->where('campu_id', $campuId)
            ->where('is_active', true)
            ->where('user_id', ($getIdUserByCampus) ? $getIdUserByCampus->user_id : 0)
            ->count();

                $userCardData['campuCount'] = $campuCount;

        $campuUser = DB::table('campus AS C')
            ->select(
                'C.id AS SedeID',
                'U.id AS UserID',
                'C.name AS NombreSede',
                DB::raw("CONCAT(U.name,' ',
                U.last_name) AS NombreCompletoTecnico"),
                'P.name AS CargoTecnico',
                'U.email AS EmailTecnico'
            )
            ->leftJoin('campu_users AS CU', 'CU.campu_id', 'C.id')
            ->leftJoin('users AS U', 'U.id', 'CU.user_id')
            ->leftJoin('profile_users AS PU', 'PU.user_id', 'U.id')
            ->leftJoin('profiles AS P', 'P.id', 'PU.profile_id')
            ->where('CU.campu_id', $campuId)
            ->where('U.is_active', 1)
            ->where('CU.is_active', 1)
            ->get();

                $userCardData['campuUser'] = $campuUser;

            return response()->json($userCardData);
    }

    public function edit($id)
    {
        return view('admin.sedes.edit', compact('campu'));
    }

    public function update(Request $request, $id)
    {
        $campu = Campu::findOrFail($id);

        $this->validate(
            request(),
            ['abreviature' => ['required', 'max:4', 'unique:campus,abreviature,' . $id]],
            ['name' => ['required', 'unique:campus,name,' . $id]],
            //['address' => ['required', 'unique:campus,address,' . $id]],
            //['phone' => ['required', 'unique:campus,phone,' . $id]],
            ['slug' => ['required', 'unique:campus,slug,' . $id]]
        );

        $campu->abreviature = $request->get('abreviature');
        $campu->name = $request->get('name');
        $campu->address = $request->get('address');
        $campu->phone = $request->get('phone');
        $campu->slug = $request->get('slug');
        $campu->updated_at = now('America/Bogota');

        $campu->save();


        return back()->with('info', 'Sede ' . $campu->name . ' actualizada con exito!');
    }

    public function destroy($id)
    {
        //
    }
}
