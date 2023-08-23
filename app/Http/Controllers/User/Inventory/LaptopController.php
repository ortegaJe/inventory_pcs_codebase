<?php

namespace App\Http\Controllers\User\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use App\Http\Requests\StoreDevice;
use App\Models\Component;
use App\Models\TypeDevice;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\ModelNotFoundException; //Import exception.
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class LaptopController extends Controller
{
    private $generatorID;

    public function __construct()
    {
        $this->generatorID = Helper::IDGenerator(new Device, 'inventory_code_number', 8, 'PC');
        $this->device = new Device();
        $this->component = new Component();
    }

    public function index(Request $request)
    {
        $globalDesktopCount     = TypeDevice::countTypeDeviceUser(TypeDevice::DESKTOP_PC_ID, Auth::id());
        $globalTurneroCount     = TypeDevice::countTypeDeviceUser(TypeDevice::TURNERO_PC_ID, Auth::id());
        $globalLaptopCount      = TypeDevice::countTypeDeviceUser(TypeDevice::LAPTOP_PC_ID, Auth::id());
        $globalRaspberryCount   = TypeDevice::countTypeDeviceUser(TypeDevice::RASPBERRY_PI_ID, Auth::id());
        $globalAllInOneCount    = TypeDevice::countTypeDeviceUser(TypeDevice::ALL_IN_ONE_PC_ID, Auth::id());
        $globalIpPhoneCount     = TypeDevice::countTypeDeviceUser(TypeDevice::IP_PHONE_ID, Auth::id());
        $globalMiniPcSatCount   = TypeDevice::countTypeDeviceUser(TypeDevice::MINIPC_SAT_ID, Auth::id());
        $deviceType             = TypeDevice::select('name as type_name')->where('id', TypeDevice::LAPTOP_PC_ID)->first();

        if ($request->ajax()) {

            $devices = DB::table('view_all_devices')
                ->where('TipoPc', TypeDevice::EQUIPOS_PORTATILES)
                ->where('TecnicoID', Auth::id())
                ->get();
            //dd($devices);
            $datatables = DataTables::of($devices);
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
                   href = '" . route('user.inventory.laptop.edit', $devices->DeviceID) . "'>
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
                'deviceType' => $deviceType,
                'globalDesktopCount' => $globalDesktopCount,
                'globalTurneroCount' => $globalTurneroCount,
                'globalLaptopCount' => $globalLaptopCount,
                'globalRaspberryCount' => $globalRaspberryCount,
                'globalAllInOneCount' => $globalAllInOneCount,
                'globalIpPhoneCount' => $globalIpPhoneCount,
                'globalMiniPcSatCount'  => $globalMiniPcSatCount,
            ];

        return view('user.inventory.laptop.index')->with($data);
    }

    public function create()
    {
        $brands = DB::table('brands')
            ->select('id', 'name')
            ->where('id', '<>', [4])
            ->where('id', '<>', [5])
            ->where('id', '<>', [6])
            ->where('id', '<>', [7])
            ->get();

        $operatingSystems = DB::table('operating_systems')
            ->select('id', 'name', 'version', 'architecture')
            ->whereIn('id', [1, 2, 3, 4, 5, 6, 11])
            ->get();

        $memoryRams = DB::table('memory_rams')
            ->select('id', 'size', 'storage_unit', 'type', 'format')
            ->whereIn('id', [1, 3, 4, 7, 9, 11, 13, 15, 17, 19, 20])
            ->get();

        $processors = DB::table('processors')
            ->select('id', 'brand', 'generation', 'velocity')
            ->where('id', '<>', [32])
            ->where('id', '<>', [36])
            ->get();

        $termTypeLaptopStorageSsd = 'ssd';
        $termTypeLaptopStorageNvme = 'pcie nvme';
        $termTypeLaptopStorage = 'portatil';
        $storages = DB::table('storages')
            ->select('id', 'size', 'storage_unit', 'type')
            ->where('type', 'LIKE', '%' . $termTypeLaptopStorage . '%')
            ->orWhere('type', 'LIKE', '%' . $termTypeLaptopStorageSsd . '%')
            ->orWhere('type', 'LIKE', '%' . $termTypeLaptopStorageNvme . '%')
            ->orWhere('id', [1])
            ->orWhere('id', [30])
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

        $data = [
            'operatingSystems' => $operatingSystems,
            'memoryRams' => $memoryRams,
            'storages' => $storages,
            'processors' => $processors,
            'brands' => $brands,
            'campus' => $campus,
            'status' => $status,
            'domainNames' => $domainNames,
            'statusAssignments' => $statusAssignments
        ];

        return view('user.inventory.laptop.create')->with($data);
    }

    public function store(StoreDevice $request)
    {
        $userId = Auth::id();

        $validator = Validator::make($request->all(), $rules = [], $messages = []);
        if ($validator->fails()) :
            return back()->withErrors($validator)
                ->withInput()
                ->with(
                    'message',
                    'Upsss! Se encontraron campos con errores, por favor revisar'
                )->with(
                    'typealert',
                    'danger'
                );
        else :
            DB::beginTransaction();

            DB::insert(
                "CALL SP_insertDevice (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", //32
                [
                    $this->device->inventory_code_number = $this->generatorID, //32
                    $this->device->fixed_asset_number = e($request->input('activo_fijo')),
                    $this->device->type_device_id = TypeDevice::LAPTOP_PC_ID, //ID equipo de portatil
                    $this->device->brand_id = e($request->input('brand')),
                    $this->device->model = e(Str::upper($request->input('model'))),
                    $this->device->serial_number = e(Str::upper($request->input('serial'))),
                    $this->device->ip = e($request->input('ip')),
                    $this->device->mac = e($request->input('mac')),
                    $this->device->nat = null,
                    $this->device->domain_name = e($request->input('domain_name')),
                    $this->device->device_name = e($request->input('device_name')),
                    $this->device->anydesk = e(trim($request->input('anydesk'))),
                    $this->device->device_image = null,
                    $this->device->campu_id = e($request->input('campu')),
                    $this->device->location = e($request->input('location')),
                    $this->device->statu_id = e($request->input('statu')),
                    $this->device->custodian_assignment_date = e($request->input('custodian_date')),
                    $this->device->custodian_name = e($request->input('custodian_name')),
                    $this->device->assignment_statu_id = e($request->input('statu_assignment')),
                    $this->device->observation = e($request->input('observation')),
                    $this->device->rowguid = Uuid::uuid(),
                    $this->device->created_at = now('America/Bogota')->toDateTimeString(),
                    $this->device->is_stock = $request->has('stock'),

                    $this->component->monitor_serial_number = null,
                    $this->component->slot_one_ram_id = e($request->input('ram0')),
                    $this->component->slot_two_ram_id = e($request->input('ram1')),
                    $this->component->first_storage_id = e($request->input('hdd0')),
                    $this->component->second_storage_id = e($request->input('hdd1')),
                    $this->component->processor_id = e($request->input('processor')),
                    $this->component->os_id = e($request->input('os')),
                    $this->component->handset = null,
                    $this->component->power_adapter = null,

                    $userId,
                ]
            );
            DB::commit();
            return redirect()->route('user.inventory.laptop.index')
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

    public function edit($id)
    {
        $device = Device::findOrFail($id);

        $deviceComponents = Device::join('components', 'components.device_id', 'devices.id')
            ->where('device_id', $device->id)
            ->first();
        //return response()->json($deviceComponents);

        $brands = DB::table('brands')
            ->select('id', 'name')
            ->where('id', '<>', [4])
            ->where('id', '<>', [5])
            ->where('id', '<>', [6])
            ->where('id', '<>', [7])
            ->get();

        $operatingSystems = DB::table('operating_systems')
            ->select('id', 'name', 'version', 'architecture')
            ->whereIn('id', [1, 2, 3, 4, 5, 6, 11])
            ->get();

        $memoryRams = DB::table('memory_rams')
            ->select('id', 'size', 'storage_unit', 'type', 'format')
            ->whereIn('id', [1, 3, 4, 7, 9, 11, 13, 15, 17, 19, 20])
            ->get();

        $processors = DB::table('processors')
            ->select('id', 'brand', 'generation', 'velocity')
            ->where('id', '<>', [32])
            ->where('id', '<>', [36])
            ->get();

        $termTypeLaptopStorageSsd = 'ssd';
        $termTypeLaptopStorageNvme = 'pcie nvme';
        $termTypeLaptopStorage = 'portatil';
        $storages = DB::table('storages')
            ->select('id', 'size', 'storage_unit', 'type')
            ->where('type', 'LIKE', '%' . $termTypeLaptopStorage . '%')
            ->orWhere('type', 'LIKE', '%' . $termTypeLaptopStorageSsd . '%')
            ->orWhere('type', 'LIKE', '%' . $termTypeLaptopStorageNvme . '%')
            ->orWhere('id', [1])
            ->orWhere('id', [30])
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
            ->select('S.id as StatusID', 'S.name as NameStatus')
            ->get();

        $statusAssignments = DB::table('status')
            ->select('id', 'name')
            ->whereIn('id', [9, 10])
            ->get();

        $statuStock = Device::where('devices.id', $device->id)
            ->select(
                'devices.id',
                DB::raw("CASE WHEN devices.is_stock = true THEN 1 ELSE 0 END as is_stock")
            )
            ->first();

        $domainNames = Device::DOMAIN_NAME;

        $data =
            [
                'statuStock' => $statuStock,
                'deviceComponents' => $deviceComponents,
                'operatingSystems' => $operatingSystems,
                'memoryRams' => $memoryRams,
                'storages' => $storages,
                'brands' => $brands,
                'processors' => $processors,
                'campus' => $campus,
                'status' => $status,
                'domainNames' => $domainNames,
                'statusAssignments' => $statusAssignments
            ];

        return view('user.inventory.laptop.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);
        $component = Component::select('device_id')->where('device_id', $device->id)->first();
        $userId = Auth::id();

        /*$this->validate(
            request(),
            //['serial-pc' => ['required', 'max:24', 'unique:Devices,serial_number', 'regex:/^[0-9a-zA-Z-]+$/i' . $id]],
            //['activo-fijo-pc' => ['nullable', 'max:15', 'unique:Devices,inventory_active_code', 'regex:/^[0-9a-zA-Z-]+$/i' . $id]],
            //['serial-monitor-pc' => ['nullable', 'max:24', 'unique:Devices,monitor_serial_number', 'regex:/^[0-9a-zA-Z-]+$/i' . $id]],
            ['ip' => ['nullable', 'ipv4,' . $id]],
            //['mac' => ['nullable|max:17', 'regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', 'unique:Devices', 'mac' . $id]],
            //['anydesk' => ['nullable', 'max:24', 'regex:/^[0-9a-zA-Z- @]+$/i', 'unique:Devices,anydesk' . $id]],
            ['device-name' => ['nullable', 'max:20', 'regex:/^[0-9a-zA-Z-]+$/i', 'unique:devices,device_name,' . $id]]

        );*/

        $rules = [
            'marca-pc-select2' => 'not_in:0',
            'marca-pc-select2' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3, 6])
            ],
            'modelo-pc' => 'nullable|max:100|regex:/^[0-9a-zA-Z- ()]+$/i',
            'os-pc-select2' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3, 4, 5, 6, 11])
            ],
            'val-select2-ram0' => [
                'required',
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19])
            ],
            'val-select2-ram1' => [
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19])
            ],
            'val-select2-first-storage' => [
                'required',
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30])
            ],
            'val-select2-second-storage' => [
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30])
            ],
            'val-select2-status' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3, 5, 6, 7, 8])
            ],
            'pc-domain-name' => 'required|max:20|regex:/^[0-9a-zA-Z-.]+$/i',
            //'pc-name' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i|unique:devices,device_name',
            'location' => 'nullable|max:56|regex:/^[0-9a-zA-Z- ]+$/i',
            'custodian-assignment-date' => 'required_with:custodian-name,filled|max:10|date',
            'custodian-name' => 'required_with:custodian-assignment-date,filled|max:56|regex:/^[0-9a-zA-Z- .]+$/i',
            'observation' => 'nullable|max:255',
        ];

        $messages = [
            'marca-pc-select2.not_in:0' => 'Esta no es una marca de computador valida',
            'marca-pc-select2.required' => 'Seleccione una marca de computador',
            'marca-pc-select2.in' => 'Seleccione una marca de computador valida en la lista',
            'modelo-pc.regex' => 'Símbolo(s) no permitido en el campo modelo',
            'serial-pc.required' => 'Campo serial es requerido',
            'serial-pc.regex' => 'Símbolo(s) no permitido en el campo serial',
            'serial-pc.unique' => 'Ya existe un equipo registrado con este serial',
            'activo-fijo-pc.regex' => 'Símbolo(s) no permitido en el campo serial',
            'activo-fijo-pc.unique' => 'Símbolo(s) no permitido en el campo activo fijo',
            'activo-fijo-pc.max' => 'Solo se permite 24 caracteres para el activo fijo',
            'serial-monitor-pc.regex' => 'Símbolo(s) no permitido en el campo serial',
            'serial-monitor-pc.unique' => 'Ya existe un monitor registrado con este serial',
            'os-pc-select2.required' => 'Seleccione un sistema operativo',
            'os-pc-select2.in' => 'Seleccione un sistema operativo válido en la lista',
            'val-select2-ram0.required' => 'Seleccione una memoria ram',
            'val-select2-ram0.in' => 'Seleccione una memoria ram valida en la lista',
            'val-select2-ram1.in' => 'Seleccione una memoria ram valida en la lista',
            'val-select2-first-storage.required' => 'Seleccione un disco duro',
            'val-select2-first-storage.in' => 'Seleccione un disco duro válido en la lista',
            'val-select2-second-storage.in' => 'Seleccione un disco duro válido en la lista',
            'val-select2-status.required' => 'Seleccione un estado del equipo',
            'val-select2-status.in' => 'Seleccione un estado válido en la lista',
            'ip.ipv4' => 'Direccion IP no valida',
            'ip.max' => 'Direccion IP no valida',
            'ip.unique' => 'Ya existe un equipo con esta IP registrado',
            'mac.regex' => 'Símbolo(s) no permitido en el campo MAC',
            'mac.max' => 'Direccion MAC no valida',
            'mac.unique' => 'Ya existe un equipo con esta MAC registrado',
            'pc-domain-name.required' => 'Un nombre de dominio es requerido',
            'pc-domain-name.max' => 'Solo se permite 20 caracteres para el nombre de dominio',
            'pc-domain-name.regex' => 'Símbolo(s) no permitido en el en el dombre de dominio',
            'anydesk.max' => 'Solo se permite 24 caracteres para el campo anydesk',
            'anydesk.regex' => 'Símbolo(s) no permitido en el campo anydesk',
            'anydesk.unique' => 'Ya existe un equipo registrado con este anydesk',
            'pc-name.max' => 'Solo se permite 20 caracteres para el campo nombre de equipo',
            'pc-name.regex' => 'Símbolo(s) no permitido en el campo nombre de equipo',
            'pc-name.unique' => 'Ya existe un equipo registrado con este nombre',
            'custodian-assignment-date.required_with' => 'El campo fecha de asignación del custodio es obligatorio cuando el nombre del custodio está presente o llenado',
            'custodian-assignment-date.date' => 'Este no es un formato de fecha permitido',
            'custodian-assignment-date.max' => 'Solo esta permitido 10 caracteres para la fecha',
            'custodian-name.required_with'  => 'El campo nombre del custodio es obligatorio cuando la fecha de asignación del custodio está presente o llenado',
            'custodian-name.max' => 'Solo esta permitido 56 caracteres para la el nombre del custodio',
            'custodian-name.regex' => 'Símbolo(s) no permitido en el campo nombre del custodio',
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
                    'Upsss! Se encontraron campos con errores, por favor revisar'
                )->with(
                    'typealert',
                    'danger'
                );
        else :
            DB::beginTransaction();

            DB::update(
                "CALL SP_updateDevice (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", //30
                [
                    $device->fixed_asset_number = $request->get('activo-fijo-pc'),
                    $device->brand_id = $request->get('marca-pc-select2'),
                    $device->model = $request->get('modelo-pc'),
                    $device->serial_number = $request->get('serial-pc'),
                    $device->ip = $request->get('ip'),
                    $device->mac = $request->get('mac'),
                    $device->nat = null,
                    $device->domain_name = $request->get('pc-domain-name'),
                    $device->device_name = $request->get('pc-name'),
                    $device->anydesk = trim($request->get('anydesk')),
                    $device->device_image = null,
                    $device->campu_id = $request->get('val-select2-campus'),
                    $device->location = $request->get('location'),
                    $device->status_id = $request->get('val-select2-status'),
                    $device->is_stock = $request->has('stock'),
                    $device->custodian_assignment_date = $request->get('custodian-assignment-date'),
                    $device->custodian_name = $request->get('custodian-name'),
                    $device->assignment_statu_id = e($request->input('val-select2-status-assignment')),
                    $device->observation = $request->get('observation'),
                    $device->updated_at = now('America/Bogota'),

                    $component->monitor_serial_number = null,
                    $component->slot_one_ram_id = $request->get('val-select2-ram0'),
                    $component->slot_two_ram_id = $request->get('val-select2-ram1'),
                    $component->first_storage_id = $request->get('val-select2-first-storage'),
                    $component->second_storage_id = $request->get('val-select2-second-storage'),
                    $component->processor_id = $request->get('val-select2-cpu'),
                    $component->os_id = $request->get('os-pc-select2'),
                    $component->handset = null,
                    $component->power_adapter = null,

                    $userId,
                    $device->id,
                ]
            );
            DB::commit();
            return redirect()->route('user.inventory.laptop.index')
                ->withErrors($validator)
                ->with('pc_updated', 'Equipo actualizado en el inventario!');
        endif;
        try {
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('info_error', '');
            throw $e;
        }
    }

    public function destroy($id)
    {
        $devices = null;
        $deviceTemp = [];
        //error_log(__LINE__ . __METHOD__ . ' pc --->' .$id);
        try {
            $devices = Device::findOrFail($id);

            $deviceTemp[] = DB::table('devices')->where('id', $id)->get();

            $ts = now('America/Bogota')->toDateTimeString();
            //$softDeletePc = array('deleted_at' => $ts, 'is_active' => false, 'statu_id' => 4);
            $softDeleteDevice = array('is_active' => false);
            $devices = DB::table('devices')->where('id', $id)->update($softDeleteDevice);
            error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($devices, true));

            $statu_id = DB::table('devices')->select('statu_id')->where('id', $id)->first();

            $deleteStatu = array('statu_id' => $statu_id->statu_id, 'device_id' => $id, 'date_log' => $ts);
            $devices = DB::table('statu_devices')->where('device_id', $id)->insert($deleteStatu);
            error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($devices, true));

            $deviceLogDelete = array('device_id' => $id, 'user_id' => Auth::id(), 'deleted_at' => $ts);
            $devices = DB::table('device_log')->where('device_id', $id)->insert($deviceLogDelete);
        } catch (ModelNotFoundException $e) {
            // Handle the error.
        }

        return response()->json([
            'message' => 'Equipo eliminado del inventario exitosamente!',
            'result' => $deviceTemp[0]
        ]);
    }
}
