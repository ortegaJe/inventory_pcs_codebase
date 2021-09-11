<?php

namespace App\Http\Controllers\User\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use App\Models\Device;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\ModelNotFoundException; //Import exception.
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class DesktopController extends Controller
{
    private $generatorID;

    public function __construct()
    {
        $this->generatorID = Helper::IDGenerator(new Device, 'inventory_code_number', 8, 'PC');
        $this->pc = new Device();
    }

    public function index(Request $request)
    {
        $globalDesktopPcCount = Device::countPc(1);   //DE ESCRITORIO
        $globalTurneroPcCount = Device::countPc(2);   //TURNERO
        $globalLaptopPcCount  = Device::countPc(3);   //PORTATIL
        $globalRaspberryPcCount = Device::countPc(4); //RASPBERRY
        $globalAllInOnePcCount = Device::countPc(5);  //ALL IN ONE

        if ($request->ajax()) {

            $pcs = DB::table('view_all_pcs')
                ->where('TipoPc', Device::EQUIPOS_ESCRITORIOS)
                ->where('TecnicoID', Auth::id())
                ->get();
            //dd($pcs);
            $datatables = DataTables::of($pcs);
            /*$datatables->editColumn('FechaCreacion', function ($pcs) {
                return $pcs->FechaCreacion ? with(new Carbon($pcs->FechaCreacion))
                    ->format('d/m/Y') : '';
            });*/
            $datatables->addColumn('EstadoPC', function ($pcs) {
                //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pcs->EstadoPC, true));

                return $pcs->EstadoPc;
            });

            $datatables->editColumn('EstadoPC', function ($pcs) {
                $status = "<span class='badge badge-pill" . " " . $pcs->ColorEstado . " btn-block'>
                            $pcs->EstadoPc</span>";
                return Str::title($status);
            });

            $datatables->addColumn('action', function ($pcs) {
                //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pcs->ComputerID, true));
                $btn = "<a type='button' class='btn btn-sm btn-secondary' id='btn-edit' 
                   href = '" . route('user.inventory.desktop.edit', $pcs->PcID) . "'>
                  <i class='fa fa-pencil'></i>
                </a>";
                $btn = $btn . "<button type='button' class='btn btn-sm btn-secondary' data-id='$pcs->PcID' id='btn-delete'>
                                        <i class='fa fa-times'></i>";
                return $btn;
            });
            $datatables->rawColumns(['action', 'EstadoPC']);
            return $datatables->make(true);
        }

        $data =
            [
                'globalDesktopPcCount' => $globalDesktopPcCount,
                'globalTurneroPcCount' => $globalTurneroPcCount,
                'globalLaptopPcCount' => $globalLaptopPcCount,
                'globalRaspberryPcCount' => $globalRaspberryPcCount,
                'globalAllInOnePcCount' => $globalAllInOnePcCount,
            ];

        return view('user.inventory.desktop.index')->with($data);
    }

    public function create()
    {

        $brands = DB::table('brands')
            ->select('id', 'name')
            ->where('id', '<>', [4])
            ->where('id', '<>', [5])
            ->get();

        $operatingSystems = DB::table('operating_systems')
            ->select('id', 'name', 'version', 'architecture')
            ->whereIn('id', [1, 2, 3, 4, 5, 6])
            ->get();

        $memoryRams = DB::table('memory_rams')
            ->select('id', 'size', 'storage_unit', 'type', 'format')
            ->where('id', '<>', [6])
            ->where('id', '<>', [21])
            ->get();

        $processors = DB::table('processors')
            ->select('id', 'brand', 'generation', 'velocity')
            ->where('id', '<>', [32])
            ->where('id', '<>', [36])
            ->get();

        $storages = DB::table('storages')
            ->select('id', 'size', 'storage_unit', 'type')
            ->where('id', '<>', [29])
            ->get();

        $campus = DB::select('SELECT DISTINCT(C.name),C.id FROM campus C
                                INNER JOIN campu_users CU ON CU.campu_id = C.id
                                INNER JOIN users U ON U.id = CU.user_id
                                WHERE U.id=' . Auth::id() . '', [1]);

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

        //$campus = Campu::select('id', 'description')->get();
        //dd($campus);
        //$campu = Campu::select('id', 'description')->where('id','MAC')->get();
        /*$slug = Str::slug('VIVA 1A IPS MACARENA', '-');
        dd($slug);*/

        $data =
            [
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

        return view('user.inventory.desktop.create')->with($data);
    }

    public function store(Request $request)
    {
        //$pc = new Computer();
        $statusId = e($request->input('val-select2-status'));
        $isActive = true;
        $userId = Auth::id();

        $rules = [
            //'marca-pc-select2' => 'not_in:0',
            'marca-pc-select2' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3])
            ],
            'modelo-pc' => 'nullable|max:100|regex:/^[0-9a-zA-Z- ()]+$/i',
            'serial-pc' => 'required|unique:computers,serial_number|max:24|regex:/^[0-9a-zA-Z-]+$/i',
            'activo-fijo-pc' => 'nullable|max:15|regex:/^[0-9a-zA-Z-]+$/i',
            'serial-monitor-pc' => 'nullable|max:24|regex:/^[0-9a-zA-Z-]+$/i',
            'os-pc-select2' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3, 4, 5, 6])
            ],
            'val-select2-ram0' => [
                'required',
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21])
            ],
            'val-select2-ram1' => [
                'required',
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21])
            ],
            'val-select2-first-storage' => [
                'required',
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30])
            ],
            'val-select2-second-storage' => [
                'required',
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30])
            ],
            'val-select2-cpu' => [
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 33, 34])
            ],
            'val-select2-status' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3, 5, 6, 7, 8])
            ],
            'ip' => 'required|ipv4|unique:computers,ip',
            'mac' => 'required|unique:computers,mac|max:17|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
            'pc-domain-name' => 'required',
            'anydesk' => 'nullable|max:24|regex:/^[0-9a-zA-Z- @]+$/i',
            //'anydesk' => 'sometimes|unique:computers,anydesk|max:24|regex:/^[0-9a-zA-Z- @]+$/i',
            'pc-name' => 'required|unique:computers,pc_name|max:20|regex:/^[0-9a-zA-Z-]+$/i',
            'val-select2-campus' => 'required|numeric',
            'location' => 'required|nullable|max:56|regex:/^[0-9a-zA-Z- ]+$/i',
            'custodian-assignment-date' => 'required_with:custodian-name,filled|max:10|date',
            'custodian-name' => 'required_with:custodian-assignment-date,filled|max:56|regex:/^[0-9a-zA-Z- .]+$/i',
            'val-select2-status-assignment' => 'required_with:custodian-name,filled|numeric',
            'observation' => 'nullable|max:255',
        ];

        $messages = [
            //'marca-pc-select2.not_in:0' => 'Esta no es una marca de computador valida',
            'marca-pc-select2.required' => 'Seleccione una marca de computador',
            'marca-pc-select2.in' => 'Seleccione una marca de computador valida en la lista',
            'modelo-pc.regex' => 'Símbolo(s) no permitido en el campo modelo',
            'serial-pc.required' => 'Campo serial es requerido',
            'serial-pc.regex' => 'Símbolo(s) no permitido en el campo serial',
            'serial-pc.unique' => 'Ya existe un equipo registrado con este serial',
            'activo-fijo-pc.regex' => 'Símbolo(s) no permitido en el campo serial',
            'activo-fijo-pc.unique' => 'Ya existe un monitor registrado con este número activo fijo',
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
            'val-select2-cpu.required' => 'Seleccione un procesador',
            'val-select2-cpu.in' => 'Seleccione un procesador válido en la lista',
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
            'anydesk.max' => 'Solo se permite 24 caracteres para el campo anydesk',
            'anydesk.regex' => 'Símbolo(s) no permitido en el campo anydesk',
            'anydesk.unique' => 'Ya existe un equipo registrado con este anydesk',
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
                    'Upsss! Se encontraron campos con errores, por favor revisar'
                )->with(
                    'typealert',
                    'danger'
                );
        else :
            DB::beginTransaction();

            DB::insert(
                "CALL SP_insertPc (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", //31
                [
                    $this->pc->inventory_code_number = $this->generatorID, //31
                    $this->pc->inventory_active_code = e($request->input('activo-fijo-pc')),
                    $this->pc->brand_id = e($request->input('marca-pc-select2')),
                    $this->pc->model = e($request->input('modelo-pc')),
                    $this->pc->serial_number = e($request->input('serial-pc')),
                    $this->pc->monitor_serial_number = e($request->input('serial-monitor-pc')),
                    $this->pc->type_device_id = Computer::DESKTOP_PC_ID, //ID equipo de escritorio
                    $this->pc->slot_one_ram_id = e($request->input('val-select2-ram0')),
                    $this->pc->slot_two_ram_id = e($request->input('val-select2-ram1')),
                    $this->pc->first_storage_id = e($request->input('val-select2-first-storage')),
                    $this->pc->second_storage_id = e($request->input('val-select2-second-storage')),
                    $this->pc->processor_id = e($request->input('val-select2-cpu')),
                    $this->pc->ip = e($request->input('ip')),
                    $this->pc->mac = e($request->input('mac')),
                    $this->pc->nat = null,
                    $this->pc->pc_name = e($request->input('pc-name')),
                    $this->pc->anydesk = trim(e($request->input('anydesk'))),
                    $this->pc->pc_image = null,
                    $this->pc->campu_id = e($request->input('val-select2-campus')),
                    $this->pc->location = e($request->input('location')),
                    $this->pc->custodian_assignment_date = e($request->input('custodian-assignment-date')),
                    $this->pc->custodian_name = e($request->input('custodian-name')),
                    $this->pc->assignment_statu_id = e($request->input('val-select2-status-assignment')),
                    $this->pc->observation = e($request->input('observation')),
                    $this->pc->rowguid = Uuid::uuid(),
                    $this->pc->pc_name_domain = e($request->input('pc-domain-name')),
                    $this->pc->created_at = now('America/Bogota')->toDateTimeString(),
                    $this->pc->os_id = e($request->input('os-pc-select2')),

                    $statusId,
                    $isActive,
                    $userId,
                ]
            );
            DB::commit();
            return redirect()->route('user.inventory.desktop.index')
                ->withErrors($validator)
                ->with('pc_created', 'Nuevo equipo añadido al inventario! ' . $this->pc->inventory_code_number . '');
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
        $brands = DB::table('brands')
            ->select('id', 'name')
            ->where('id', '<>', [4])
            ->where('id', '<>', [5])
            ->get();

        $operatingSystems = DB::table('operating_systems')
            ->select('id', 'name', 'version', 'architecture')
            ->whereIn('id', [1, 2, 3, 4, 5, 6])
            ->get();

        $memoryRams = DB::table('memory_rams')
            ->select('id', 'size', 'storage_unit', 'type', 'format')
            ->where('id', '<>', [6])
            ->where('id', '<>', [21])
            ->get();

        $processors = DB::table('processors')
            ->select('id', 'brand', 'generation', 'velocity')
            ->where('id', '<>', [32])
            ->where('id', '<>', [36])
            ->get();

        $storages = DB::table('storages')
            ->select('id', 'size', 'storage_unit', 'type')
            ->where('id', '<>', [29])
            ->get();

        $campus = DB::select('SELECT DISTINCT(C.name),C.id FROM campus C
                                INNER JOIN campu_users CU ON CU.campu_id = C.id
                                INNER JOIN users U ON U.id = CU.user_id
                                WHERE U.id=' . Auth::id() . '', [1]);

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

        $domainNames = Computer::DOMAIN_NAME;

        $data =
            [
                'pcs' => Computer::findOrFail($id),
                'operatingSystems' => $operatingSystems,
                'memoryRams' => $memoryRams,
                'storages' => $storages,
                'brands' => $brands,
                'processors' => $processors,
                'campus' => $campus,
                'status' => $status,
                'domainNames' => $domainNames,
                'statusAssignments' => $statusAssignments,
            ];

        return view('user.inventory.desktop.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $pcImage = 'lenovo-desktop.png';
        $pc = Computer::findOrFail($id);
        $statuId = $request->get('val-select2-status');
        $pcId = $id;
        $userId = Auth::id();

        $this->validate(
            request(),
            //['serial-pc' => ['required', 'max:24', 'unique:computers,serial_number', 'regex:/^[0-9a-zA-Z-]+$/i' . $id]],
            //['activo-fijo-pc' => ['nullable', 'max:15', 'unique:computers,inventory_active_code', 'regex:/^[0-9a-zA-Z-]+$/i' . $id]],
            //['serial-monitor-pc' => ['nullable', 'max:24', 'unique:computers,monitor_serial_number', 'regex:/^[0-9a-zA-Z-]+$/i' . $id]],
            //['ip' => ['nullable', 'ipv4', 'unique:computers,ip' . $id]],
            //['mac' => ['nullable|max:17', 'regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', 'unique:computers', 'mac' . $id]],
            //['anydesk' => ['nullable', 'max:24', 'regex:/^[0-9a-zA-Z- @]+$/i', 'unique:computers,anydesk' . $id]],
            ['pc-name' => ['max:20', 'regex:/^[0-9a-zA-Z-]+$/i', 'unique:computers,pc_name,' . $id]]

        );

        $rules = [
            'marca-pc-select2' => 'not_in:0',
            'marca-pc-select2' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3])
            ],
            'modelo-pc' => 'nullable|max:100|regex:/^[0-9a-zA-Z- ()]+$/i',
            'os-pc-select2' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3, 4, 5, 6])
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
            'pc-name' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i',
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
            DB::update(
                "CALL SP_updatePc (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", //29
                [
                    $pc->inventory_active_code = $request->get('activo-fijo-pc'),
                    $pc->brand_id = $request->get('marca-pc-select2'),
                    $pc->model = $request->get('modelo-pc'),
                    $pc->serial_number = $request->get('serial-pc'),
                    $pc->monitor_serial_number = $request->get('serial-monitor-pc'),
                    $pc->type_device_id = Computer::DESKTOP_PC_ID, //ID equipo de escritorio
                    $pc->slot_one_ram_id = $request->get('val-select2-ram0'),
                    $pc->slot_two_ram_id = $request->get('val-select2-ram1'),
                    $pc->first_storage_id = $request->get('val-select2-first-storage'),
                    $pc->second_storage_id = $request->get('val-select2-second-storage'),
                    $pc->processor_id = $request->get('val-select2-cpu'),
                    $pc->ip = $request->get('ip'),
                    $pc->mac = $request->get('mac'),
                    $pc->nat = null,
                    $pc->pc_name = $request->get('pc-name'),
                    $pc->anydesk = trim($request->get('anydesk')),
                    $pc->pc_image = null,
                    $pc->campu_id = $request->get('val-select2-campus'),
                    $pc->location = $request->get('location'),
                    $pc->custodian_assignment_date = $request->get('custodian-assignment-date'),
                    $pc->custodian_name = $request->get('custodian-name'),
                    $pc->assignment_statu_id = e($request->input('val-select2-status-assignment')),
                    $pc->observation = $request->get('observation'),
                    $pc->pc_name_domain = $request->get('pc-domain-name'),
                    $pc->updated_at = now('America/Bogota'),
                    $pc->os_id = $request->get('os-pc-select2'),

                    $statuId,
                    $pcId,
                    $userId,
                ]
            );
            return redirect()->route('user.inventory.desktop.index')
                ->withErrors($validator)
                ->with('pc_updated', 'Equipo actualizado en el inventario!');
        endif;
    }

    public function destroy($id)
    {
        $pcs = null;
        $pcTemp = [];
        //error_log(__LINE__ . __METHOD__ . ' pc --->' .$id);
        try {
            $pcs = Computer::findOrFail($id);
            $pcTemp[] = DB::table('computers')->where('id', $id)->get();
            //("SELECT * FROM computers WHERE id = $id", [1]);
            $ts = now('America/Bogota')->toDateTimeString();
            //$softDeletePc = array('deleted_at' => $ts, 'is_active' => false, 'statu_id' => 4);
            $softDeletePc = array('is_active' => false, 'statu_id' => 4);
            $pcs = DB::table('computers')->where('id', $id)->update($softDeletePc);
            error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pcs, true));

            $dateLogDeletePc = array('statu_id' => 4, 'pc_id' => $id, 'date_log' => $ts);
            $pcs = DB::table('statu_computers')->where('pc_id', $id)->insert($dateLogDeletePc);
            error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pcs, true));

            $pcLogDelete = array('pc_id' => $id, 'user_id' => Auth::id(), 'deleted_at' => $ts);
            $pcs = DB::table('computer_log')->where('pc_id', $id)->insert($pcLogDelete);
        } catch (ModelNotFoundException $e) {
            // Handle the error.
        }

        return response()->json([
            'message' => 'Equipo eliminado del inventario exitosamente!',
            'result' => $pcTemp[0]
        ]);
    }
}