<?php

namespace App\Http\Controllers\User\Inventory;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Computer;
use App\Models\Device;
use Illuminate\Support\Str;
use App\Models\TypeDevice;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PhoneIpController extends Controller
{
    private $generatorID;

    public function __construct()
    {
        $this->generatorID = Helper::IDGenerator(new Device, 'inventory_code_number', 8, 'TEL');
        $this->device = new Device();
    }


    public function index(Request $request)
    {
        $globalDesktopPcCount = TypeDevice::countPc(1, Auth::id());   //DE ESCRITORIO
        //$globalTurneroPcCount = Device::countPc(2);   //TURNERO
        $globalLaptopPcCount  = TypeDevice::countPc(3, Auth::id());   //PORTATIL
        //$globalRaspberryPcCount = Device::countPc(4); //RASPBERRY
        //$globalAllInOnePcCount = Device::countPc(5);  //ALL IN ONE

        if ($request->ajax()) {

            $devices = DB::table('view_all_devices')
                ->where('TipoPc', TypeDevice::EQUIPOS_TELEFONOS_IP)
                ->where('TecnicoID', Auth::id())
                ->get();

            $datatables = DataTables::of($devices);
            /*$datatables->editColumn('FechaCreacion', function ($devices) {
                return $devices->FechaCreacion ? with(new Carbon($devices->FechaCreacion))
                    ->format('d/m/Y') : '';
            });*/
            $datatables->addColumn('EstadoPC', function ($devices) {
                //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($devices->EstadoPC, true));

                return $devices->EstadoPc;
            });

            $datatables->editColumn('EstadoPC', function ($devices) {
                $status = "<span class='badge badge-pill" . " " . $devices->ColorEstado . " btn-block'>
                            $devices->EstadoPc</span>";
                return Str::title($status);
            });

            $datatables->addColumn('action', function ($devices) {
                //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($devices->DeviceID, true));
                $btn = "<a type='button' class='btn btn-sm btn-secondary' id='btn-edit' 
                   href = '" . route('user.inventory.phones.edit', $devices->DeviceID) . "'>
                  <i class='fa fa-pencil'></i>
                </a>";
                $btn = $btn . "<button type='button' class='btn btn-sm btn-secondary' data-id='$devices->DeviceID' id='btn-delete'>
                                        <i class='fa fa-times'></i>";
                return $btn;
            });
            $datatables->rawColumns(['action', 'EstadoPC']);
            return $datatables->make(true);
        }

        $data =
            [
                'globalDesktopPcCount' => $globalDesktopPcCount,
                //'globalTurneroPcCount' => $globalTurneroPcCount,
                'globalLaptopPcCount' => $globalLaptopPcCount,
                //'globalRaspberryPcCount' => $globalRaspberryPcCount,
                //'globalAllInOnePcCount' => $globalAllInOnePcCount,
            ];

        return view('user.inventory.ip_phone.index')->with($data);
    }

    public function create()
    {
        $brands = DB::table('brands')
            ->select('id', 'name')
            ->whereIn('id', [6])
            ->get();

        $campus = DB::table('campus as c')
            ->join('campu_users as cu', 'cu.campu_id', 'c.id')
            ->join('users as u', 'u.id', 'cu.user_id')
            ->where('cu.user_id', Auth::id())
            ->distinct('c.name')
            ->select('c.name', 'c.id')
            ->get();

        $status = DB::table('status')
            ->select('id', 'name')
            ->where('id', '<>', [4])
            ->where('id', '<>', [9])
            ->where('id', '<>', [10])
            ->get();

        $statusAssignments = DB::table('status')
            ->select('id', 'name')
            ->whereIn('id', [9, 10])
            ->get();

        $domainNames = Device::DOMAIN_NAME;

        $data =
            [
                'brands' => $brands,
                'campus' => $campus,
                'status' => $status,
                'domainNames' => $domainNames,
                'statusAssignments' => $statusAssignments
            ];

        return view('user.inventory.ip_phone.create')->with($data);
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        $rules = [

            //'marca-pc-select2' => 'not_in:0',
            'marca-pc-select2' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3, 6])
            ],
            'modelo-pc' => 'nullable|max:100|regex:/^[0-9a-zA-Z- ()]+$/i',
            'serial-pc' => 'required|unique:devices,serial_number|max:24|regex:/^[0-9a-zA-Z-]+$/i',
            'activo-fijo-pc' => 'nullable|max:15|regex:/^[0-9a-zA-Z-]+$/i',
            'val-select2-status' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3, 5, 6, 7, 8])
            ],
            'ip' => 'nullable|ipv4',
            'mac' => 'nullable|max:17|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
            'pc-domain-name' => 'required',
            'pc-name' => 'required|unique:devices,device_name|max:20|regex:/^[0-9a-zA-Z-]+$/i',
            'val-select2-campus' => 'required|numeric',
            'location' => 'required|nullable|max:56|regex:/^[0-9a-zA-Z- ]+$/i',
            'custodian-assignment-date' => 'required_with:custodian-name,filled|max:10|date',
            'custodian-name' => 'required_with:custodian-assignment-date,filled|max:56|regex:/^[0-9a-zA-Z- .]+$/i',
            'val-select2-status-assignment' => 'required_with:custodian-name,filled|numeric',
            'observation' => 'nullable|max:255',
        ];

        $messages = [
            'marca-pc-select2.required' => 'Seleccione una marca de computador',
            'marca-pc-select2.in' => 'Seleccione una marca de computador valida en la lista',
            'modelo-pc.regex' => 'Símbolo(s) no permitido en el campo modelo',
            'serial-pc.required' => 'Campo serial es requerido',
            'serial-pc.regex' => 'Símbolo(s) no permitido en el campo serial',
            'serial-pc.unique' => 'Ya existe un equipo registrado con este serial',
            'activo-fijo-pc.regex' => 'Símbolo(s) no permitido en el campo serial',
            'activo-fijo-pc.unique' => 'Ya existe un monitor registrado con este número activo fijo',
            'activo-fijo-pc.max' => 'Solo se permite 24 caracteres para el activo fijo',
            'val-select2-status.required' => 'Seleccione un estado del equipo',
            'val-select2-status.in' => 'Seleccione un estado válido en la lista',
            'ip.required' => 'Es requirida un dirección IP del equipo',
            'ip.ipv4' => 'Direccion IP no valida',
            'ip.max' => 'Direccion IP no valida',
            'ip.unique' => 'Ya existe un equipo con esta IP registrado',
            'mac.required' => 'Es requirida un dirección MAC del equipo',
            'mac.regex' => 'Símbolo(s) no permitido en el campo MAC',
            'mac.max' => 'Direccion MAC no valida',
            'mac.unique' => 'Ya existe un equipo con esta MAC registrado',
            'pc-domain-name.required' => 'Seleccionar dominio del equipo',
            'pc-name.required' => 'Es requerido un nombre de equipo',
            'pc-name.max' => 'Solo se permite 20 caracteres para el campo nombre de equipo',
            'pc-name.regex' => 'Símbolo(s) no permitido en el campo nombre de equipo',
            'pc-name.unique' => 'Ya existe un equipo registrado con este nombre',
            'val-select2-campus.required' => 'Seleccione la sede del equipo',
            'custodian-assignment-date.required_with' => 'El campo fecha de asignación del custodio es obligatorio cuando el nombre del custodio está presente o llenado',
            'custodian-assignment-date.date' => 'Este no es un formato de fecha permitido',
            'custodian-assignment-date.max' => 'Solo esta permitido 10 caracteres para la fecha',
            'custodian-name.required_with'  => 'El campo nombre del custodio es obligatorio cuando la fecha de asignación del custodio está presente o llenado',
            'custodian-name.max' => 'Solo esta permitido 56 caracteres para la el nombre del custodio',
            'custodian-name.regex' => 'Símbolo(s) no permitido en el campo nombre del custodio',
            'val-select2-status-assignment' => 'El campo concepto es obligatorio cuando el nombre del custodio está presente o llenado',
            'location.required' => 'Es requirida la ubicación del equipo',
            'location.max' => 'Solo se permite 56 caracteres para el campo ubicación',
            'location.regex' => 'Símbolo(s) no permitido en el campo ubicación',
            'observation.max' => 'Solo se permite 255 caracteres para el campo observación',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)
                ->withInput()
                ->with(
                    'message',
                    'Revisar campos! :-('
                )->with(
                    'modal',
                    'error'
                );
        else :
            DB::beginTransaction();

            DB::insert(
                "CALL SP_insertDevice (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", //32
                [
                    $this->device->inventory_code_number = $this->generatorID, //30
                    $this->device->fixed_asset_number = e($request->input('activo-fijo-pc')),
                    $this->device->type_device_id = TypeDevice::IP_PHONE_ID,
                    $this->device->brand_id = e($request->input('marca-pc-select2')),
                    $this->device->model = e(Str::upper($request->input('modelo-pc'))),
                    $this->device->serial_number = e(Str::upper($request->input('serial-pc'))),
                    $this->device->ip = e($request->input('ip')),
                    $this->device->mac = e($request->input('mac')),
                    $this->device->nat = null,
                    $this->device->domain_name = e($request->input('pc-domain-name')),
                    $this->device->device_name = e($request->input('pc-name')),
                    $this->device->anydesk = null,
                    $this->device->device_image = null,
                    $this->device->campu_id = e($request->input('val-select2-campus')),
                    $this->device->location = e($request->input('location')),
                    $this->status_id = e($request->input('val-select2-status')),
                    $this->device->custodian_assignment_date = e($request->input('custodian-assignment-date')),
                    $this->device->custodian_name = e($request->input('custodian-name')),
                    $this->device->assignment_statu_id = e($request->input('val-select2-status-assignment')),
                    $this->device->observation = e($request->input('observation')),
                    $this->device->rowguid = Uuid::uuid(),
                    $this->device->created_at = now('America/Bogota')->toDateTimeString(),

                    $this->monitor_serial_number = null,
                    $this->slot_one_ram_id = null,
                    $this->slot_two_ram_id = null,
                    $this->first_storage_id = null,
                    $this->second_storage_id = null,
                    $this->processor_id = null,
                    $this->os_id = null,
                    $this->handset = e($request->input('handset')),
                    $this->power_adapter = e($request->input('power-adapter')),

                    $userId,
                ]
            );
            DB::commit();
            return redirect()->route('user.inventory.phones.index')
                ->withErrors($validator)
                ->with('pc_created', 'Nuevo equipo añadido al inventario! ' . $this->device->inventory_code_number . '');
        endif;
        try {
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('info_error', '');
            throw $e;
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        Device::findOrFail($id);

        $deviceComponents = Device::join('components', 'components.device_id', 'devices.id')
            ->where('device_id', $id)
            ->first();
        //return response()->json($deviceComponents);

        $brands = DB::table('brands')
            ->select('id', 'name')
            ->whereIn('id', [6])
            ->get();

        $campus = DB::table('campus as c')
            ->join('campu_users as cu', 'cu.campu_id', 'c.id')
            ->join('users as u', 'u.id', 'cu.user_id')
            ->where('cu.user_id', Auth::id())
            ->distinct('c.name')
            ->select('c.name', 'c.id')
            ->get();

        $status = DB::table('status as S')
            ->where('S.id', '<>', [4])
            ->where('S.id', '<>', [9])
            ->where('S.id', '<>', [10])
            ->select('S.id', 'S.name')
            ->get();

        $statusAssignments = DB::table('status')
            ->select('id', 'name')
            ->whereIn('id', [9, 10])
            ->get();

        $domainNames = Device::DOMAIN_NAME;

        $data =
            [
                'deviceComponents' => $deviceComponents,
                'brands' => $brands,
                'campus' => $campus,
                'status' => $status,
                'domainNames' => $domainNames,
                'statusAssignments' => $statusAssignments,
            ];

        return view('user.inventory.ip_phone.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
