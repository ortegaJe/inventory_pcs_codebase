<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCampuRequest;
use App\Models\Campu;
use App\Models\CampuUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CampuController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->get('search');

        $campus = Campu::orderBy('id', 'desc')
            ->name($name)
            ->paginate(6);

        return view('admin.sedes.index', compact('campus'));
    }

    public function autoCompleteSearch(Request $request)
    {
        $query = $request->get('search');

        $filterResult = Campu::where('name', 'LIKE', '%' . $query . '%')->get();

        return response()->json($filterResult);
    }

    public function assingUserCampu(Request $request)
    {
        $campuUser = new CampuUser();

        $campuUser->user_id = $request->get('val-select2-lista-tecnicos');
        $campuUser->campu_id = $request->get('campu-id');
        $campuUser->is_principal = false;
        //$campuUser->updated_at = now('America/Bogota');

        $campuUser->save();


        return back()->with('info', 'actualizado con exito!');
    }

    public function create()
    {
        return view('admin.sedes.create');
    }

    public function assingUserCampu(Request $request)
    {
        $campuUser = new CampuUser();

        $campuUser->user_id = $request->get('val-select2-lista-tecnicos');
        $campuUser->campu_id = $request->get('campu-id');
        $campuUser->is_principal = false;
        //$campuUser->updated_at = now('America/Bogota');

        $campuUser->save();


        return back()->with('info', 'actualizado con exito!');
    }

    public function store(Request $request)
    {
        $campu = new Campu();

        $request->validate([
            'abreviature' => 'required|unique:campus,abreviature',
            'name' => 'required|unique:campus,name',
        ]);

        $campu->abreviature = e($request->input('abreviature'));
        $campu->name = e($request->input('name'));
        $campu->slug = e($request->input('slug'));
        $campu->address = e($request->input('address'));
        $campu->phone = e($request->input('phone'));
        $campu->created_at = now('America/Bogota');

        $campu->save();

        return redirect()->route('admin.inventory.campus.index', $campu)
            ->with('info', 'Sede ' . $campu->name . ' creada exitosamente!');
    }

    public function show($id)
    {
        $campus = Campu::findOrFail($id);
        $userLists = User::all();

        $userLists = User::all();

        $typeDevices = DB::table('computers as pc')
            ->leftJoin('type_devices as td', 'td.id', 'pc.type_device_id')
            ->select(
                DB::raw("COUNT(pc.type_device_id) AS numberTypeDevice"),
                'td.name as nameTypeDevice',
                'pc.campu_id as SedeId'
            )
            ->where('pc.campu_id', $id)
            ->groupBy('pc.type_device_id', 'td.name', 'pc.campu_id')
            ->get();
        //dd($typeDevices);

        $campusCount = DB::table('computers')
            ->select('campu_id')
            ->where('campu_id', $id)
            ->count();

        $getIdUserByCampus = DB::table('campu_users')
            ->select('user_id')
            ->where('campu_id', $id)
            ->first();

        $campuAssignedCount = DB::table('campu_users')
            ->select(DB::raw("campu_id,user_id,COUNT(user_id) AS NumberCampus"))
            ->where('campu_id', $id)
            ->orWhere('user_id', ($getIdUserByCampus) ? $getIdUserByCampus->user_id : 0)
            ->count();

        //dd($campuAssignedCount);

        $campuAssigned = DB::table('campus AS C')
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
            ->join('user_profiles AS UP', 'UP.id', 'U.id')
            ->join('profiles AS P', 'P.id', 'UP.profile_id')
            ->where('CU.campu_id', $id)
            ->where('U.is_active', 1)
            ->get();

        $data =
            [
                'campus' => $campus,
                'typeDevices' => $typeDevices,
                'campusCount' => $campusCount,
                'campuAssigned' => $campuAssigned,
                'campuAssignedCount' => $campuAssignedCount,
                'userLists' => $userLists,
            ];

        return view('admin.sedes.show')->with($data);
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
