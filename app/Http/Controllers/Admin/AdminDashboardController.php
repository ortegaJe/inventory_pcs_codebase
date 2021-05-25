<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\ModelNotFoundException; //Import exception.
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AdminDashboardController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $globalDesktopPcCount = Computer::countPc(1);   //DE ESCRITORIO
    $globalTurneroPcCount = Computer::countPc(2);   //TURNERO
    $globalLaptopPcCount  = Computer::countPc(3);   //PORTATIL
    $globalRaspberryPcCount = Computer::countPc(4); //RASPBERRY
    $globalAllInOnePcCount = Computer::countPc(5);  //ALL IN ONE


    if ($request->ajax()) {
      $pcs = DB::table('view_all_pcs_desktop')->get();
      //dd($pcs);

      $datatables = DataTables::of($pcs);
      $datatables->editColumn('FechaCreacion', function ($pcs) {
        return $pcs->FechaCreacion ? with(new Carbon($pcs->FechaCreacion))
          ->format('d/m/Y h:i A')    : '';
      });
      $datatables->addColumn('EstadoPC', function ($pcs) {
        //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pcs->EstadoPC, true));

        return $pcs->EstadoPC;
      });

      $datatables->editColumn('EstadoPC', function ($pcs) {
        $status = "<span class='badge badge-pill badge-primary btn-block'>$pcs->EstadoPC</span>";
        return Str::title($status);
      });

      $datatables->addColumn('action', function ($pcs) {
        //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pcs->ComputerID, true));
        $btn = "<a type='button' class='btn btn-sm btn-secondary' id='btn-edit' 
                   href = '" . route('admin.pcs.edit', $pcs->PcID) . "'>
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

    return view('admin.index')->with($data);
  }

  public function indexAio(Request $request)
  {

    if ($request->ajax()) {
      $pcs = DB::table('view_all_pcs_aio')->get();
      //dd($pcs);

      $datatables = DataTables::of($pcs);
      $datatables->editColumn('FechaCreacion', function ($pcs) {
        return $pcs->FechaCreacion ? with(new Carbon($pcs->FechaCreacion))
          ->format('d/m/Y h:i A')    : '';
      });
      $datatables->addColumn('EstadoPC', function ($pcs) {
        //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pcs->EstadoPC, true));

        return $pcs->EstadoPC;
      });

      $datatables->editColumn('EstadoPC', function ($pcs) {
        $status = "<span class='badge badge-pill badge-primary btn-block'>$pcs->EstadoPC</span>";
        return Str::title($status);
      });

      $datatables->addColumn('action', function ($pcs) {
        //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pcs->ComputerID, true));
        $btn = "<a type='button' class='btn btn-sm btn-secondary' id='btn-edit' 
                   href = '" . route('admin.pcs.edit', $pcs->PcID) . "'>
                  <i class='fa fa-pencil'></i>
                </a>";
        $btn = $btn . "<button type='button' class='btn btn-sm btn-secondary' data-id='$pcs->PcID' id='btn-delete'>
                                        <i class='fa fa-times'></i>";
        return $btn;
      });
      $datatables->rawColumns(['action', 'EstadoPC']);
      return $datatables->make(true);
    }

    return view('admin.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {

    $operatingSystems = DB::table('operating_systems')
      ->select('id', 'name', 'version', 'architecture')
      ->whereIn('id', [1, 2, 3, 4, 5, 6])
      ->get();

    $memoryRams = DB::table('memory_rams')->select('id', 'size', 'storage_unit', 'type', 'format')->where('id', '<>', [22])->get();
    $processors = DB::table('processors')->select('id', 'brand', 'generation', 'velocity')->get();
    $storages = DB::table('storages')->select('id', 'size', 'storage_unit', 'type')->where('id', '<>', [29])->get();

    $brands = DB::table('brands')
      ->select('id', 'name')
      ->where('id', '<>', [4])
      ->where('id', '<>', [5])
      ->get();

    $campus = DB::table('campus')->select('id', 'description')->get();

    $status = DB::table('status')
      ->select('id', 'name')
      ->where('id', '<>', [4])
      ->where('id', '<>', [9])
      ->where('id', '<>', [10])
      ->get();

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
        'status' => $status
      ];

    return view('admin.create.create_desktop')->with($data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function queryStorages()
  {
    $q = DB::table('first_storages')->pluck('id');

    foreach ($q as $query) {
      echo $query, ",";
    }

    return $query;
  }

  public function store(Request $request)
  {
    $generatorID = Helper::IDGenerator(new Computer, 'inventory_code_number', 8, 'PC');
    $pcImage = 'lenovo-desktop.png';
    //$queryStorages = $this->queryStorages();

    $rules = [
      'marca-pc-select2' => 'not_in:0',
      'marca-pc-select2' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3])
      ],
      'modelo-pc' => 'nullable|max:100|regex:/^[0-9a-zA-Z- ()]+$/i',
      'serial-pc' => 'required|max:24|unique:computers,serial_number|regex:/^[0-9a-zA-Z-]+$/i',
      'activo-fijo-pc' => 'nullable|max:15|regex:/^[0-9a-zA-Z-]+$/i',
      'serial-monitor-pc' => 'nullable|max:24|unique:computers,monitor_serial_number|regex:/^[0-9a-zA-Z-]+$/i',
      'os-pc-select2' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6])
      ],
      'val-select2-ram0' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 23])
      ],
      'val-select2-ram1' => [
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 23])
      ],
      'val-select2-first-storage' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30])
      ],
      'val-select2-second-storage' => [
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30])
      ],
      'val-select2-status' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 5, 6, 7, 8])
      ],
      'ip' => 'nullable|ipv4|unique:computers,ip',
      'mac' => 'nullable|max:17|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/|unique:computers,mac',
      'pc-domain-name' => 'required|max:20|regex:/^[0-9a-zA-Z-.]+$/i',
      'anydesk' => 'nullable|max:24|regex:/^[0-9a-zA-Z- @]+$/i|unique:computers,anydesk',
      'pc-name' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i|unique:computers,pc_name',

      'location' => 'nullable|max:56|regex:/^[0-9a-zA-Z- ]+$/i',
      'custodian-assignment-date' => 'required_with:custodian-name,filled|max:10|date',
      'custodian-name' => 'required_with:custodian-assignment-date,filled|max:56|regex:/^[0-9a-zA-Z- .]+$/i',
      'observation' => 'nullable|max:255|regex:/^[0-9a-zA-Z- ,.;:@¿?!¡]+$/i',
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
      'observation.regex' => 'Símbolo(s) no permitido en el campo observación',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) :
      return back()->withErrors($validator)
        ->withInput()
        ->with(
          'message',
          'Revisar los campos con errores'
        )->with(
          'typealert',
          'danger'
        );
    else :
      $pc = new Computer();
      $pc->inventory_code_number =  $generatorID;
      $pc->inventory_active_code = e($request->input('activo-fijo-pc'));
      $pc->type_device_id = Computer::DESKTOP_PC_ID; //ID equipo de escritorio
      $pc->brand_id = e($request->input('marca-pc-select2'));
      $pc->os_id = e($request->input('os-pc-select2'));
      $pc->model = e($request->input('modelo-pc'));
      $pc->serial_number = e($request->input('serial-pc'));
      $pc->monitor_serial_number = e($request->input('serial-monitor-pc'));
      $pc->slot_one_ram_id = e($request->input('val-select2-ram0'));
      $pc->slot_two_ram_id = e($request->input('val-select2-ram1'));
      $pc->first_storage_id = e($request->input('val-select2-first-storage'));
      $pc->second_storage_id = e($request->input('val-select2-second-storage'));
      $pc->processor_id = e($request->input('val-select2-cpu'));
      $pc->statu_id = e($request->input('val-select2-status'));
      $pc->ip = e($request->input('ip'));
      $pc->mac = e($request->input('mac'));
      $pc->pc_name_domain = e($request->input('pc-name-domain'));
      $pc->anydesk = e($request->input('anydesk'));
      $pc->pc_image = $pcImage;
      $pc->pc_name = e($request->input('pc-name'));
      $pc->campu_id = e($request->input('val-select2-campus'));
      $pc->location = e($request->input('location'));
      $pc->custodian_assignment_date = e($request->input('custodian-assignment-date'));
      $pc->custodian_name = e($request->input('custodian-name'));
      $pc->observation = e($request->input('observation'));
      $pc->rowguid = Uuid::uuid();
      $pc->created_at = now('America/Bogota');

      if ($pc->save()) :
        return redirect()->route('admin.pcs.index')
          ->withErrors($validator)
          ->with('pc_created', 'Nuevo equipo añadido al inventario!');
      endif;
    endif;
  }

  public function createAllInOne()
  {

    $operatingSystems = DB::table('operating_systems')
      ->select('id', 'name', 'version', 'architecture')
      ->whereIn('id', [1, 2, 3, 4, 5, 6])
      ->get();

    $termTypeLaptopRam = 'so-dimm';
    $slotOneRams = DB::table('slot_one_rams')
      ->select('id', 'ram')
      ->where('ram', 'LIKE', '%' . $termTypeLaptopRam . '%')
      ->orWhere('ram', 'NO APLICA')
      ->get();

    //dd($slotOneRams);

    $slotTwoRams = DB::table('slot_two_rams')
      ->select('id', 'ram')
      ->where('ram', 'LIKE', '%' . $termTypeLaptopRam . '%')
      ->orWhere('ram', 'NO APLICA')
      ->get();

    $termTypeLaptopStorageSsd = 'ssd';
    $termTypeLaptopStorageNvme = 'pcie nvme';
    $termTypeLaptopStorage = 'portatil';
    $firstStorages = DB::table('first_storages')
      ->select('id', 'size', 'storage_unit', 'type')
      ->where('type', 'LIKE', '%' . $termTypeLaptopStorage . '%')
      ->orWhere('type', 'LIKE', '%' . $termTypeLaptopStorageSsd . '%')
      ->orWhere('type', 'LIKE', '%' . $termTypeLaptopStorageNvme . '%')
      ->orWhere('storage_unit', 'NO APLICA')
      ->orWhere('storage_unit', 'DISPONIBLE')
      ->get();

    $secondStorages = DB::table('second_storages')
      ->select('id', 'size', 'storage_unit', 'type')
      ->where('type', 'LIKE', '%' . $termTypeLaptopStorage . '%')
      ->orWhere('type', 'LIKE', '%' . $termTypeLaptopStorageSsd . '%')
      ->orWhere('type', 'LIKE', '%' . $termTypeLaptopStorageNvme . '%')
      ->orWhere('storage_unit', 'NO APLICA')
      ->orWhere('storage_unit', 'DISPONIBLE')
      ->get();

    $brands = DB::table('brands')
      ->select('id', 'name')
      ->where('id', '<>', [4])
      ->where('id', '<>', [5])
      ->get();

    $campus = DB::table('campus')->select('id', 'description')->get();

    $status = DB::table('status')
      ->select('id', 'name')
      ->where('id', '<>', [4])
      ->where('id', '<>', [9])
      ->where('id', '<>', [10])
      ->get();

    $data = [
      'operatingSystems' => $operatingSystems,
      'slotOneRams' => $slotOneRams,
      'slotTwoRams' => $slotTwoRams,
      'firstStorages' => $firstStorages,
      'secondStorages' => $secondStorages,
      'brands' => $brands,
      'campus' => $campus,
      'status' => $status
    ];

    return view('admin.create.create_all_in_one')->with($data);
  }

  public function storeAllInOne(Request $request)
  {

    $generatorID = Helper::IDGenerator(new Computer, 'inventory_code_number', 8, 'PC');
    $pcImage = 'lenovo-all-in-one.png';

    $rules = [
      'marca-pc-select2' => 'not_in:0',
      'marca-pc-select2' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3])
      ],
      'modelo-pc' => 'nullable|max:100|regex:/^[0-9a-zA-Z- ()]+$/i',
      'serial-pc' => 'required|max:24|unique:computers,serial_number|regex:/^[0-9a-zA-Z-]+$/i',
      'activo-fijo-pc' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i',
      'os-pc-select2' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6])
      ],
      'val-select2-ram0' => [
        'required',
        'numeric',
        Rule::in([3, 5, 6, 8, 10, 12, 14, 16, 18, 20])
      ],
      'val-select2-ram1' => [
        'numeric',
        Rule::in([3, 5, 6, 8, 10, 12, 14, 16, 18, 20])
      ],
      'val-select2-first-storage' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30])
      ],
      'val-select2-second-storage' => [
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30])
      ],
      'val-select2-status' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 5, 6, 7, 8])
      ],
      'ip' => 'nullable|ipv4|unique:computers,ip',
      'mac' => 'nullable|max:17|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/|unique:computers,mac',
      'anydesk' => 'nullable|max:24|regex:/^[0-9a-zA-Z- @]+$/i|unique:computers,anydesk',
      'pc-domain-name' => 'required|max:20|regex:/^[0-9a-zA-Z-.]+$/i',
      'pc-name' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i|unique:computers,pc_name',

      'location' => 'nullable|max:56|regex:/^[0-9a-zA-Z- ]+$/i',
      'custodian-assignment-date' => 'required_with:custodian-name,filled|max:10|date',
      'custodian-name' => 'required_with:custodian-assignment-date,filled|max:56|regex:/^[0-9a-zA-Z- .]+$/i',
      'observation' => 'nullable|max:255|regex:/^[0-9a-zA-Z- ,.;:@¿?!¡]+$/i',
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
      'anydesk.max' => 'Solo se permite 24 caracteres para el campo anydesk',
      'anydesk.regex' => 'Símbolo(s) no permitido en el campo anydesk',
      'anydesk.unique' => 'Ya existe un equipo registrado con este anydesk',
      'pc-domain-name.required' => 'Un nombre de dominio es requerido',
      'pc-domain-name.max' => 'Solo se permite 20 caracteres para el nombre de dominio',
      'pc-domain-name.regex' => 'Símbolo(s) no permitido en el en el dombre de dominio',
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
      'observation.regex' => 'Símbolo(s) no permitido en el campo observación',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) :
      return back()->withErrors($validator)
        ->withInput()
        ->with(
          'message',
          'Revisar los campos con errores'
        )->with(
          'typealert',
          'danger'
        );
    else :
      $pc = new Computer();
      $pc->inventory_code_number =  $generatorID;
      $pc->inventory_active_code = e($request->input('activo-fijo-pc'));
      $pc->type_device_id = Computer::ALL_IN_ONE_PC_ID;
      $pc->brand_id = e($request->input('marca-pc-select2'));
      $pc->os_id = e($request->input('os-pc-select2'));
      $pc->model = e($request->input('modelo-pc'));
      $pc->serial_number = e($request->input('serial-pc'));
      $pc->slot_one_ram_id = e($request->input('val-select2-ram0'));
      $pc->slot_two_ram_id = e($request->input('val-select2-ram1'));
      $pc->first_storage_id = e($request->input('val-select2-first-storage'));
      $pc->second_storage_id = e($request->input('val-select2-second-storage'));
      $pc->cpu = e($request->input('cpu'));
      $pc->statu_id = e($request->input('val-select2-status'));
      $pc->ip = e($request->input('ip'));
      $pc->mac = e($request->input('mac'));
      $pc->anydesk = e($request->input('anydesk'));
      $pc->pc_name_domain = e($request->input('pc-name-domain'));
      $pc->pc_name = e($request->input('pc-name'));
      $pc->pc_image = $pcImage;
      $pc->campu_id = e($request->input('val-select2-campus'));
      $pc->location = e($request->input('location'));
      $pc->custodian_assignment_date = e($request->input('custodian-assignment-date'));
      $pc->custodian_name = e($request->input('custodian-name'));
      $pc->observation = e($request->input('observation'));
      $pc->rowguid = Uuid::uuid();
      $pc->created_at = now('America/Bogota');

      if ($pc->save()) :
        return redirect()->route('admin.pcs.index')
          ->withErrors($validator)
          ->with('pc_created', 'Nuevo equipo añadido al inventario!');
      endif;
    endif;
  }

  public function createTurnero()
  {

    $operatingSystems = DB::table('operating_systems')
      ->select('id', 'name', 'version', 'architecture')
      ->whereIn('id', [1, 2, 3, 4, 5, 6])
      ->get();

    $slotOneRams = DB::table('slot_two_rams')->select('id', 'ram')->where('id', '<>', [22])->get();

    $slotTwoRams = DB::table('slot_two_rams')->select('id', 'ram')->where('id', '<>', [22])->get();

    $firstStorages = DB::table('first_storages')->select('id', 'size', 'storage_unit', 'type')->where('id', '<>', [29])->get();

    $secondStorages = DB::table('second_storages')->select('id', 'size', 'storage_unit', 'type')->where('id', '<>', [29])->get();

    $brands = DB::table('brands')->select('id', 'name')->where('id', '<>', [4])->get();

    $campus = DB::table('campus')->select('id', 'description')->get();

    $status = DB::table('status')->select('id', 'name')->where('id', '<>', [4])->where('id', '<>', [9])->where('id', '<>', [10])->get();

    $data = [
      'operatingSystems' => $operatingSystems,
      'slotOneRams' => $slotOneRams,
      'slotTwoRams' => $slotTwoRams,
      'firstStorages' => $firstStorages,
      'secondStorages' => $secondStorages,
      'brands' => $brands,
      'campus' => $campus,
      'status' => $status
    ];

    return view('admin.create.create_turnero')->with($data);
  }

  public function storeTurnero(Request $request)
  {

    $generatorID = Helper::IDGenerator(new Computer, 'inventory_code_number', 8, 'PC');
    $pcImage = 'atril-turnero.png';

    $rules = [
      'marca-pc-select2' => 'not_in:0',
      'marca-pc-select2' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 5])
      ],
      'modelo-pc' => 'nullable|max:100|regex:/^[0-9a-zA-Z- ()]+$/i',
      'serial-pc' => 'required|max:24|unique:computers,serial_number|regex:/^[0-9a-zA-Z-]+$/i',
      'activo-fijo-pc' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i',
      'os-pc-select2' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6])
      ],
      'val-select2-ram0' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21])
      ],
      'val-select2-ram1' => [
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21])
      ],
      'val-select2-first-storage' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30])
      ],
      'val-select2-second-storage' => [
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30])
      ],
      'val-select2-status' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 5, 6, 7, 8])
      ],
      'ip' => 'nullable|ipv4|unique:computers,ip',
      'mac' => 'nullable|max:17|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/|unique:computers,mac',
      'anydesk' => 'nullable|max:24|regex:/^[0-9a-zA-Z- @]+$/i|unique:computers,anydesk',
      'pc-domain-name' => 'required|max:20|regex:/^[0-9a-zA-Z-.]+$/i',
      'pc-name' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i|unique:computers,pc_name',

      'location' => 'nullable|max:56|regex:/^[0-9a-zA-Z- ]+$/i',
      'custodian-assignment-date' => 'required_with:custodian-name,filled|max:10|date',
      'custodian-name' => 'required_with:custodian-assignment-date,filled|max:56|regex:/^[0-9a-zA-Z- .]+$/i',
      'observation' => 'nullable|max:255|regex:/^[0-9a-zA-Z- ,.;:@¿?!¡]+$/i',
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
      'anydesk.max' => 'Solo se permite 24 caracteres para el campo anydesk',
      'anydesk.regex' => 'Símbolo(s) no permitido en el campo anydesk',
      'anydesk.unique' => 'Ya existe un equipo registrado con este anydesk',
      'pc-domain-name.required' => 'Un nombre de dominio es requerido',
      'pc-domain-name.max' => 'Solo se permite 20 caracteres para el nombre de dominio',
      'pc-domain-name.regex' => 'Símbolo(s) no permitido en el en el dombre de dominio',
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
      'observation.regex' => 'Símbolo(s) no permitido en el campo observación',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) :
      return back()->withErrors($validator)
        ->withInput()
        ->with(
          'message',
          'Revisar los campos con errores'
        )->with(
          'typealert',
          'danger'
        );
    else :
      $pc = new Computer();
      $pc->inventory_code_number =  $generatorID;
      $pc->inventory_active_code = e($request->input('activo-fijo-pc'));
      $pc->type_device_id = Computer::TURNERO_PC_ID;
      $pc->brand_id = e($request->input('marca-pc-select2'));
      $pc->os_id = e($request->input('os-pc-select2'));
      $pc->model = e($request->input('modelo-pc'));
      $pc->serial_number = e($request->input('serial-pc'));
      $pc->monitor_serial_number = e($request->input('serial-monitor-pc'));
      $pc->slot_one_ram_id = e($request->input('val-select2-ram0'));
      $pc->slot_two_ram_id = e($request->input('val-select2-ram1'));
      $pc->first_storage_id = e($request->input('val-select2-first-storage'));
      $pc->second_storage_id = e($request->input('val-select2-second-storage'));
      $pc->cpu = e($request->input('cpu'));
      $pc->statu_id = e($request->input('val-select2-status'));
      $pc->ip = e($request->input('ip'));
      $pc->mac = e($request->input('mac'));
      $pc->anydesk = e($request->input('anydesk'));
      $pc->pc_name_domain = e($request->input('pc-name-domain'));
      $pc->pc_name = e($request->input('pc-name'));
      $pc->pc_image = $pcImage;
      $pc->campu_id = e($request->input('val-select2-campus'));
      $pc->location = e($request->input('location'));
      $pc->custodian_assignment_date = e($request->input('custodian-assignment-date'));
      $pc->custodian_name = e($request->input('custodian-name'));
      $pc->observation = e($request->input('observation'));
      $pc->rowguid = Uuid::uuid();
      $pc->created_at = now('America/Bogota');

      if ($pc->save()) :
        return redirect()->route('admin.pcs.index')
          ->withErrors($validator)
          ->with('pc_created', 'Nuevo equipo añadido al inventario!');
      endif;
    endif;
  }

  public function createRaspberry()
  {

    $operatingSystems = DB::table('operating_systems')
      ->select('id', 'name', 'version', 'architecture')
      ->whereIn('id', [7, 8])
      ->get();

    $slotOneRams = DB::table('slot_one_rams')
      ->select('id', 'ram')
      ->whereIn('id', [22])
      ->orWhere('ram', 'NO APLICA')
      ->get();

    $firstStorages = DB::table('first_storages')
      ->select('id', 'size', 'storage_unit', 'type')
      ->whereIn('id', [29])
      ->orWhere('storage_unit', 'NO APLICA')
      ->get();

    $brands = DB::table('brands')->select('id', 'name')->where('id', '=', [4])->get();

    $campus = DB::table('campus')->select('id', 'description')->get();

    $status = DB::table('status')
      ->select('id', 'name')
      ->where('id', '<>', [4])
      ->where('id', '<>', [9])
      ->where('id', '<>', [10])
      ->get();

    $data =
      [
        'operatingSystems' => $operatingSystems,
        'slotOneRams' => $slotOneRams,
        'firstStorages' => $firstStorages,
        'brands' => $brands,
        'campus' => $campus,
        'status' => $status
      ];

    return view('admin.create.create_raspberry')->with($data);
  }

  public function storeRaspberry(Request $request)
  {

    $generatorID = Helper::IDGenerator(new Computer, 'inventory_code_number', 8, 'PC');
    $pcImage = 'raspberry-pi.png';

    $rules = [
      'modelo-pc' => 'nullable|max:100|regex:/^[0-9a-zA-Z- ()]+$/i',
      'serial-pc' => 'required|max:24|unique:computers,serial_number|regex:/^[0-9a-zA-Z-]+$/i',
      'activo-fijo-pc' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i',
      'os-pc-select2' => [
        'required',
        'numeric',
        Rule::in([7, 8])
      ],
      'val-select2-ram0' => [
        'required',
        'numeric',
        Rule::in([1, 22])
      ],
      'val-select2-first-storage' => [
        'required',
        'numeric',
        Rule::in([1, 29, 30])
      ],
      'val-select2-status' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 5, 6, 7, 8, 9, 10])
      ],
      'ip' => 'nullable|ipv4|unique:computers,ip',
      'mac' => 'nullable|max:17|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/|unique:computers,mac',
      'anydesk' => 'nullable|max:24|regex:/^[0-9a-zA-Z- @]+$/i|unique:computers,anydesk',
      'pc-domain-name' => 'required|max:20|regex:/^[0-9a-zA-Z-.]+$/i',
      'pc-name' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i|unique:computers,pc_name',

      'location' => 'nullable|max:56|regex:/^[0-9a-zA-Z- ]+$/i',
      'custodian-assignment-date' => 'required_with:custodian-name,filled|max:10|date',
      'custodian-name' => 'required_with:custodian-assignment-date,filled|max:56|regex:/^[0-9a-zA-Z- .]+$/i',
      'observation' => 'nullable|max:255|regex:/^[0-9a-zA-Z- ,.;:@¿?!¡]+$/i',
    ];

    $messages = [
      'modelo-pc.regex' => 'Símbolo(s) no permitido en el campo modelo',
      'serial-pc.required' => 'Campo serial es requerido',
      'serial-pc.regex' => 'Símbolo(s) no permitido en el campo serial',
      'serial-pc.unique' => 'Ya existe un equipo registrado con este serial',
      'activo-fijo-pc.regex' => 'Símbolo(s) no permitido en el campo serial',
      'os-pc-select2.required' => 'Seleccione un sistema operativo',
      'os-pc-select2.in' => 'Seleccione un sistema operativo válido en la lista',
      'val-select2-ram0.required' => 'Seleccione una memoria ram',
      'val-select2-ram0.in' => 'Seleccione una memoria ram valida en la lista',
      'val-select2-first-storage.required' => 'Seleccione un disco duro',
      'val-select2-first-storage.in' => 'Seleccione un disco duro válido en la lista',
      'val-select2-status.required' => 'Seleccione un estado del equipo',
      'val-select2-status.in' => 'Seleccione un estado válido en la lista',
      'ip.ipv4' => 'Direccion IP no valida',
      'ip.max' => 'Direccion IP no valida',
      'ip.unique' => 'Ya existe un equipo con esta IP registrado',
      'mac.regex' => 'Símbolo(s) no permitido en el campo MAC',
      'mac.max' => 'Direccion MAC no valida',
      'mac.unique' => 'Ya existe un equipo con esta MAC registrado',
      'anydesk.max' => 'Solo se permite 24 caracteres para el campo anydesk',
      'anydesk.regex' => 'Símbolo(s) no permitido en el campo anydesk',
      'anydesk.unique' => 'Ya existe un equipo registrado con este anydesk',
      'pc-domain-name.required' => 'Un nombre de dominio es requerido',
      'pc-domain-name.max' => 'Solo se permite 20 caracteres para el nombre de dominio',
      'pc-domain-name.regex' => 'Símbolo(s) no permitido en el en el dombre de dominio',
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
      'observation.regex' => 'Símbolo(s) no permitido en el campo observación',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) :
      return back()->withErrors($validator)
        ->withInput()
        ->with(
          'message',
          'Revisar los campos con errores'
        )->with(
          'typealert',
          'danger'
        );
    else :
      $pc = new Computer();
      $pc->inventory_code_number =  $generatorID;
      $pc->inventory_active_code = e($request->input('activo-fijo-pc'));
      $pc->type_device_id = Computer::RASPBERRY_PI_ID; //ID equipo de escritorio
      $pc->brand_id = e($request->input('marca-pc-select2'));
      $pc->os_id = e($request->input('os-pc-select2'));
      $pc->model = e($request->input('modelo-pc'));
      $pc->serial_number = e($request->input('serial-pc'));
      $pc->slot_one_ram_id = e($request->input('val-select2-ram0'));
      $pc->first_storage_id = e($request->input('val-select2-first-storage'));
      $pc->cpu = e($request->input('cpu'));
      $pc->statu_id = e($request->input('val-select2-status'));
      $pc->ip = e($request->input('ip'));
      $pc->mac = e($request->input('mac'));
      $pc->anydesk = e($request->input('anydesk'));
      $pc->pc_name_domain = e($request->input('pc-name-domain'));
      $pc->pc_image = $pcImage;
      $pc->pc_name = e($request->input('pc-name'));
      $pc->campu_id = e($request->input('val-select2-campus'));
      $pc->location = e($request->input('location'));
      $pc->custodian_assignment_date = e($request->input('custodian-assignment-date'));
      $pc->custodian_name = e($request->input('custodian-name'));
      $pc->observation = e($request->input('observation'));
      $pc->rowguid = Uuid::uuid();
      $pc->created_at = now('America/Bogota');

      if ($pc->save()) :
        return redirect()->route('admin.pcs.index')
          ->withErrors($validator)
          ->with('pc_created', 'Nuevo equipo añadido al inventario!');
      endif;
    endif;
  }

  public function createLaptop()
  {

    $operatingSystems = DB::table('operating_systems')
      ->select('id', 'name', 'version', 'architecture')
      ->whereIn('id', [1, 2, 3, 4, 5, 6])
      ->get();

    $termTypeLaptopRam = 'so-dimm';
    $slotOneRams = DB::table('slot_one_rams')
      ->select('id', 'ram')
      ->where('ram', 'LIKE', '%' . $termTypeLaptopRam . '%')
      ->orWhere('ram', 'NO APLICA')
      ->get();

    $slotTwoRams = DB::table('slot_two_rams')
      ->select('id', 'ram')
      ->where('ram', 'LIKE', '%' . $termTypeLaptopRam . '%')
      ->orWhere('ram', 'NO APLICA')
      ->get();

    $termTypeLaptopStorageSsd = 'ssd';
    $termTypeLaptopStorageNvme = 'pcie nvme';
    $termTypeLaptopStorage = 'portatil';
    $firstStorages = DB::table('first_storages')
      ->select('id', 'size', 'storage_unit', 'type')
      ->where('type', 'LIKE', '%' . $termTypeLaptopStorage . '%')
      ->orWhere('type', 'LIKE', '%' . $termTypeLaptopStorageSsd . '%')
      ->orWhere('type', 'LIKE', '%' . $termTypeLaptopStorageNvme . '%')
      ->orWhere('storage_unit', 'NO APLICA')
      ->orWhere('storage_unit', 'DISPONIBLE')
      ->get();

    $secondStorages = DB::table('second_storages')
      ->select('id', 'size', 'storage_unit', 'type')
      ->where('type', 'LIKE', '%' . $termTypeLaptopStorage . '%')
      ->orWhere('type', 'LIKE', '%' . $termTypeLaptopStorageSsd . '%')
      ->orWhere('type', 'LIKE', '%' . $termTypeLaptopStorageNvme . '%')
      ->orWhere('storage_unit', 'NO APLICA')
      ->orWhere('storage_unit', 'DISPONIBLE')
      ->get();

    $brands = DB::table('brands')
      ->select('id', 'name')
      ->where('id', '<>', [4])
      ->where('id', '<>', [5])
      ->get();

    $campus = DB::table('campus')->select('id', 'description')->get();

    $status = DB::table('status')
      ->select('id', 'name')
      ->where('id', '<>', [4])
      ->where('id', '<>', [9])
      ->where('id', '<>', [10])
      ->get();

    $data = [
      'operatingSystems' => $operatingSystems,
      'slotOneRams' => $slotOneRams,
      'slotTwoRams' => $slotTwoRams,
      'firstStorages' => $firstStorages,
      'secondStorages' => $secondStorages,
      'brands' => $brands,
      'campus' => $campus,
      'status' => $status
    ];

    return view('admin.create.create_laptop')->with($data);
  }

  public function storeLaptop(Request $request)
  {

    $generatorID = Helper::IDGenerator(new Computer, 'inventory_code_number', 8, 'PC');
    $pcImage = 'laptop-lenovo.png';

    $rules = [
      'marca-pc-select2' => 'not_in:0',
      'marca-pc-select2' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 5])
      ],
      'modelo-pc' => 'nullable|max:100|regex:/^[0-9a-zA-Z- ()]+$/i',
      'serial-pc' => 'required|max:24|unique:computers,serial_number|regex:/^[0-9a-zA-Z-]+$/i',
      'activo-fijo-pc' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i',
      'os-pc-select2' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6])
      ],
      'val-select2-ram0' => [
        'required',
        'numeric',
        Rule::in([1, 3, 5, 6, 8, 10, 12, 14, 16, 18, 20])
      ],
      'val-select2-ram1' => [
        'numeric',
        Rule::in([1, 3, 5, 6, 8, 10, 12, 14, 16, 18, 20])
      ],
      'val-select2-first-storage' => [
        'required',
        'numeric',
        Rule::in([1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23, 30])
      ],
      'val-select2-second-storage' => [
        'numeric',
        Rule::in([1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23, 30])
      ],
      'val-select2-status' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 5, 6, 7, 8])
      ],
      'ip' => 'nullable|ipv4|unique:computers,ip',
      'mac' => 'nullable|max:17|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/|unique:computers,mac',
      'anydesk' => 'nullable|max:24|regex:/^[0-9a-zA-Z- @]+$/i|unique:computers,anydesk',
      'pc-domain-name' => 'required|max:20|regex:/^[0-9a-zA-Z-.]+$/i',
      'pc-name' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i|unique:computers,pc_name',

      'location' => 'nullable|max:56|regex:/^[0-9a-zA-Z- ]+$/i',
      'custodian-assignment-date' => 'required_with:custodian-name,filled|max:10|date',
      'custodian-name' => 'required_with:custodian-assignment-date,filled|max:56|regex:/^[0-9a-zA-Z- .]+$/i',
      'observation' => 'nullable|max:255|regex:/^[0-9a-zA-Z- ,.;:@¿?!¡]+$/i',
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
      'anydesk.max' => 'Solo se permite 24 caracteres para el campo anydesk',
      'anydesk.regex' => 'Símbolo(s) no permitido en el campo anydesk',
      'anydesk.unique' => 'Ya existe un equipo registrado con este anydesk',
      'pc-domain-name.required' => 'Un nombre de dominio es requerido',
      'pc-domain-name.max' => 'Solo se permite 20 caracteres para el nombre de dominio',
      'pc-domain-name.regex' => 'Símbolo(s) no permitido en el en el dombre de dominio',
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
      'observation.regex' => 'Símbolo(s) no permitido en el campo observación',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) :
      return back()->withErrors($validator)
        ->withInput()
        ->with(
          'message',
          'Revisar los campos con errores'
        )->with(
          'typealert',
          'danger'
        );
    else :
      $pc = new Computer();
      $pc->inventory_code_number =  $generatorID;
      $pc->inventory_active_code = e($request->input('activo-fijo-pc'));
      $pc->type_device_id = Computer::LAPTOP_PC_ID;
      $pc->brand_id = e($request->input('marca-pc-select2'));
      $pc->os_id = e($request->input('os-pc-select2'));
      $pc->model = e($request->input('modelo-pc'));
      $pc->serial_number = e($request->input('serial-pc'));
      $pc->slot_one_ram_id = e($request->input('val-select2-ram0'));
      $pc->slot_two_ram_id = e($request->input('val-select2-ram1'));
      $pc->first_storage_id = e($request->input('val-select2-first-storage'));
      $pc->second_storage_id = e($request->input('val-select2-second-storage'));
      $pc->cpu = e($request->input('cpu'));
      $pc->statu_id = e($request->input('val-select2-status'));
      $pc->ip = e($request->input('ip'));
      $pc->mac = e($request->input('mac'));
      $pc->anydesk = e($request->input('anydesk'));
      $pc->pc_name_domain = e($request->input('pc-name-domain'));
      $pc->pc_image = $pcImage;
      $pc->pc_name = e($request->input('pc-name'));
      $pc->campu_id = e($request->input('val-select2-campus'));
      $pc->location = e($request->input('location'));
      $pc->custodian_assignment_date = e($request->input('custodian-assignment-date'));
      $pc->custodian_name = e($request->input('custodian-name'));
      $pc->observation = e($request->input('observation'));
      $pc->rowguid = Uuid::uuid();
      $pc->created_at = now('America/Bogota');

      if ($pc->save()) :
        return redirect()->route('admin.pcs.index')
          ->withErrors($validator)
          ->with('pc_created', 'Nuevo equipo añadido al inventario!');
      endif;
    endif;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $operatingSystems = DB::table('operating_systems')
      ->select('id', 'name', 'version', 'architecture')
      ->whereIn('id', [1, 2, 3, 4, 5, 6])
      ->get();

    $slotOneRams = DB::table('slot_one_rams')->select('id', 'ram')->where('id', '<>', [22])->get();

    $slotTwoRams = DB::table('slot_two_rams')->select('id', 'ram')->where('id', '<>', [22])->get();

    $firstStorages = DB::table('first_storages')->select('id', 'size', 'storage_unit', 'type')->where('id', '<>', [29])->get();

    $secondStorages = DB::table('second_storages')->select('id', 'size', 'storage_unit', 'type')->where('id', '<>', [29])->get();

    $brands = DB::table('brands')
      ->select('id', 'name')
      ->where('id', '<>', [4])
      ->where('id', '<>', [5])
      ->get();

    $campus = DB::table('campus')->select('id', 'description')->get();

    $status = DB::table('status')
      ->select('id', 'name')
      ->where('id', '<>', [4])
      ->where('id', '<>', [9])
      ->where('id', '<>', [10])
      ->get();

    $data =
      [
        'pcs' => Computer::findOrFail($id),
        'operatingSystems' => $operatingSystems,
        'slotOneRams' => $slotOneRams,
        'slotTwoRams' => $slotTwoRams,
        'firstStorages' => $firstStorages,
        'secondStorages' => $secondStorages,
        'brands' => $brands,
        'campus' => $campus,
        'status' => $status
      ];

    return view('admin.edit.edit_desktop')->with($data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
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
      $data = array('deleted_at' => $ts, 'is_active' => false, 'statu_id' => 4);
      $pcs = DB::table('computers')->where('id', $id)->update($data);
      error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pcs, true));
    } catch (ModelNotFoundException $e) {
      // Handle the error.
    }

    return response()->json([
      'message' => 'Equipo eliminado del inventario exitosamente!',
      'result' => $pcTemp[0]
    ]);
  }
}
