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
    $globalDesktopPcCount = DB::table('computers')->select('type_id')->where('type_id', 1)->count();
    $globalTurneroPcCount = DB::table('computers')->select('type_id')->where('type_id', 2)->count();
    $globalLaptopPcCount = DB::table('computers')->select('type_id')->where('type_id', 3)->count();
    $globalRaspberryPcCount = DB::table('computers')->select('type_id')->where('type_id', 4)->count();
    $globalAllInOnePcCount = DB::table('computers')->select('type_id')->where('type_id', 5)->count();

    if ($request->ajax()) {
      $pcs = DB::table('view_all_pcs')->get();
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
        $string = $pcs->EstadoPC;
        $arrayString = explode(",", $string);
        $arrayRenderHtmlStatus = "<span class='badge badge-pill badge-primary btn-block'>$arrayString[0]</span>";
        //$arrayRenderHtmlStatus = $arrayRenderHtmlStatus . "<span class='badge badge-pill badge-primary btn-block mt-2'>$arrayString[1]</span>";
        return Str::title($arrayRenderHtmlStatus);
      });

      $datatables->addColumn('action', function ($pcs) {
        //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pcs->ComputerID, true));
        $btn = "<button type='button' class='btn btn-sm btn-secondary' data-toggle='tooltip' title='Edit'>
                                                    <i class='fa fa-pencil'></i>";
        $btn = $btn . "<button class='btn btn-sm btn-secondary js-tooltip-enabled' data-id='$pcs->PcID' id='btn-delete'>
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

    $SlotOneRams = DB::table('slot_one_rams')->select('id', 'ram')->where('id', '<>', [22])->get();

    $SlotTwoRams = DB::table('slot_two_rams')->select('id', 'ram')->where('id', '<>', [22])->get();

    $storages = DB::table('storages')->select('id', 'size', 'type')->where('id', '<>', [29])->get();

    $brands = DB::table('brands')->select('id', 'name')->where('id', '<>', [4])->get();

    $campus = DB::table('campus')->select('id', 'description')->get();

    //$campus = Campu::select('id', 'description')->get();
    //dd($campus);
    //$campu = Campu::select('id', 'description')->where('id','MAC')->get();
    /*$slug = Str::slug('VIVA 1A IPS MACARENA', '-');
        dd($slug);*/

    $data =
      [
        'operatingSystems' => $operatingSystems,
        'SlotOneRams' => $SlotOneRams,
        'SlotTwoRams' => $SlotTwoRams,
        'storages' => $storages,
        'brands' => $brands,
        'campus' => $campus,
      ];

    return view('admin.create')->with($data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  public function store(Request $request)
  {
    $generatorID = Helper::IDGenerator(new Computer, 'inventory_code_number', 8, 'PC');
    $arrayToString = implode(',', $request->input('estado-pc'));

    $rules = [
      'marca-pc-select2' => 'not_in:0',
      'marca-pc-select2' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 5])
      ],
      'modelo-pc' => 'nullable|max:100|regex:/^[0-9a-zA-Z- ()]+$/i',
      'serial-pc' => 'required|max:24|unique:computers,serial|regex:/^[0-9a-zA-Z-]+$/i',
      'activo-fijo-pc' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i',
      'serial-monitor-pc' => 'nullable|max:24|unique:computers,serial_monitor|regex:/^[0-9a-zA-Z-]+$/i',
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
        'required',
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21])
      ],
      'val-select2-storage' => [
        'required',
        'numeric',
        Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28])
      ],
      'ip' => 'nullable|ipv4|unique:computers,ip',
      'mac' => 'nullable|max:17|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/|unique:computers,mac',
      'anydesk' => 'nullable|max:24|regex:/^[0-9a-zA-Z- @]+$/i|unique:computers,anydesk',
      'pc-name' => 'nullable|max:20|regex:/^[0-9a-zA-Z-]+$/i|unique:computers,pc_name',

      'location' => 'nullable|max:56|regex:/^[0-9a-zA-Z- ]+$/i',
      'observation' => 'nullable|max:255|regex:/^[0-9a-zA-Z- ,.;:@¿?!¡]+$/i'
    ];

    $messages = [
      'marca-pc-select2.not_in:0' => 'Esta no es una marca de computador valida',
      'marca-pc-select2.required' => 'Seleccione una marca de computador',
      'marca-pc-select2.in' => 'Seleccione una marca de computador valida en la lista',
      'modelo-pc.regex' => 'Símbolo(s)no permitido en el campo modelo',
      'serial-pc.required' => 'Campo serial es requerido',
      'serial-pc.regex' => 'Símbolo(s)no permitido en el campo serial',
      'serial-pc.unique' => 'Ya existe un equipo registrado con este serial',
      'activo-fijo-pc.required' => 'Campo serial es requerido',
      'activo-fijo-pc.regex' => 'Símbolo(s)no permitido en el campo serial',
      'serial-monitor-pc.regex' => 'Símbolo(s)no permitido en el campo serial',
      'serial-monitor-pc.unique' => 'Ya existe un monitor registrado con este serial',
      'os-pc-select2.required' => 'Seleccione un sistema operativo',
      'os-pc-select2.in' => 'Seleccione un sistema operativo valido en la lista',
      'val-select2-ram0.required' => 'Seleccione una memoria ram',
      'val-select2-ram0.in' => 'Seleccione una memoria ram valida en la lista',
      'val-select2-ram1.required' => 'Seleccione una memoria ram',
      'val-select2-ram1.in' => 'Seleccione una memoria ram valida en la lista',
      'val-select2-storage.required' => 'Seleccione un disco duro',
      'val-select2-storage.in' => 'Seleccione un disco duro valido en la lista',
      'ip.ipv4' => 'Direccion IP no valida',
      'ip.max' => 'Direccion IP no valida',
      'ip.unique' => 'Ya existe un equipo con esta IP registrado',
      'mac.regex' => 'Símbolo(s) no permitido en el campo MAC',
      'mac.max' => 'Direccion MAC no valida',
      'anydesk.max' => 'Solo se permite 24 caracteres para el campo anydesk',
      'anydesk.regex' => 'Símbolo(s) no permitido en el campo anydesk',
      'anydesk.unique' => 'Ya existe un equipo registrado con este anydesk',
      'pc-name.max' => 'Solo se permite 20 caracteres para el campo nombre de equipo',
      'pc-name.regex' => 'Símbolo(s) no permitido en el campo nombre de equipo',
      'pc-name.unique' => 'Ya existe un equipo registrado con este nombre',
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
          'Se ha producido un error:'
        )->with(
          'typealert',
          'danger'
        );
    else :
      $pc = new Computer();
      $pc->inventory_code_number =  $generatorID;
      $pc->type_id = Computer::DESKTOP_PC_ID; //ID equipo de escritorio
      $pc->brand_id = e($request->input('marca-pc-select2'));
      $pc->os_id = e($request->input('os-pc-select2'));
      $pc->model = e($request->input('modelo-pc'));
      $pc->serial = e($request->input('serial-pc'));
      //$pc->inventory_active_code = e($request->input('activo-fijo-pc'));
      $pc->serial_monitor = e($request->input('serial-monitor-pc'));
      $pc->slot_one_ram_id = e($request->input('val-select2-ram0'));
      $pc->slot_two_ram_id = e($request->input('val-select2-ram1'));
      $pc->storage_id = e($request->input('val-select2-storage'));
      $pc->cpu = e($request->input('cpu'));
      $pc->statu_id = $arrayToString;
      $pc->ip = e($request->input('ip'));
      $pc->mac = e($request->input('mac'));
      $pc->anydesk = e($request->input('anydesk'));
      $pc->pc_name = e($request->input('pc-name'));
      $pc->campu_id = e($request->input('val-select2-campus'));
      $pc->location = e($request->input('location'));
      $pc->observation = e($request->input('observation'));
      $pc->rowguid = Uuid::uuid();
      $pc->created_at = now('America/Bogota');

      if ($pc->save()) :
        return redirect('admin.pcs.index', 201)
          ->withErrors($validator)
          ->with('pc_created', 'Nuevo equipo añadido al inventario!');
      endif;
    endif;
  }

  /*public function store(Request $request)
  {

    $generatorID = Helper::IDGenerator(new Computer, 'inventory_code_number', 8, 'PC');
    $str = Str::random(5);
    $pc_name_chain = 'V1AMAC-' . $str;
    $arrayToString = implode(',', $request->input('estado-pc'));

    $pc = new Computer();
    $pc->inventory_code_number =  $generatorID;
    $pc->type_id = Computer::DESKTOP_PC_ID; //ID equipo de escritorio
    $pc->brand_id = $request['marca-pc-select2'];
    $pc->model = $request['modelo-pc'];
    $pc->serial = $request['serial-pc'];
    $pc->serial_monitor = $request['serial-monitor-pc'];
    $pc->os_id = $request['os-pc-select2'];
    $pc->slot_one_ram_id = $request['val-select2-ram0'];
    $pc->slot_two_ram_id = $request['val-select2-ram1'];
    $pc->storage_id = $request['val-select2-storage'];
    $pc->cpu = $request['cpu'];
    $pc->statu_id = $arrayToString;
    $pc->ip = $request['ip'];
    $pc->mac = $request['mac'];
    $pc->anydesk = $request['anydesk'];
    $pc->pc_name = $pc_name_chain;
    $pc->campu_id = $request['val-select2-campus'];
    $pc->location = $request['location'];
    $pc->observation = $request['observation'];
    $pc->rowguid = Uuid::uuid();
    $pc->created_at = now('America/Bogota');
    dd($pc);
    //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pc, true));
    //$pc->save();

    return redirect()->route('admin.pcs.index', 200)
      ->with(
        'pc_created',
        'Nuevo equipo añadido al inventario!'
      );
  }*/

  public function createAllInOne()
  {

    $operatingSystems = DB::table('operating_systems')
      ->select('id', 'name', 'version', 'architecture')
      ->whereIn('id', [1, 2, 3, 4, 5, 6])
      ->get();

    $SlotOneRams = DB::table('slot_one_rams')->select('id', 'ram')->where('id', '<>', [22])->get();

    $SlotTwoRams = DB::table('slot_two_rams')->select('id', 'ram')->where('id', '<>', [22])->get();

    $storages = DB::table('storages')->select('id', 'size', 'type')->where('id', '<>', [29])->get();

    $brands = DB::table('brands')->select('id', 'name')->where('id', '<>', [4])->get();

    $campus = DB::table('campus')->select('id', 'description')->get();
    //$status = DB::table('status_computers')->select('id', 'name')->where('id', '<>', 4)->get();

    $secondSegmentIp = rand(1, 254);
    $thirdSegmentIp = rand(1, 254);
    $ip = '192.168.' . $secondSegmentIp . '.' . $thirdSegmentIp;

    $macAdress = Str::upper(Str::random(3)) . '.' .
      Str::upper(Str::random(3)) . '.' .
      Str::upper(Str::random(3)) . '.' .
      Str::upper(Str::random(3));

    //$campus = Campu::select('id', 'description')->get();
    //dd($campus);
    //$campu = Campu::select('id', 'description')->where('id','MAC')->get();
    /*$slug = Str::slug('VIVA 1A IPS MACARENA', '-');
        dd($slug);*/

    $data =
      [
        'operatingSystems' => $operatingSystems,
        'SlotOneRams' => $SlotOneRams,
        'SlotTwoRams' => $SlotTwoRams,
        'storages' => $storages,
        'brands' => $brands,
        'campus' => $campus,
        'ip' => $ip,
        'macAdress' => $macAdress,
        //'status' => $status
      ];

    return view('admin.forms.create_all_in_one')->with($data);
  }

  public function storeAllInOne(Request $request)
  {

    $generatorID = Helper::IDGenerator(new Computer, 'inventory_code_number', 8, 'PC');
    $str = Str::random(5);
    $pc_name_chain = 'V1AMAC-' . $str;
    $arrayToString = implode(',', $request->input('estado-pc'));

    $pc = new Computer();
    $pc->inventory_code_number =  $generatorID;
    $pc->type_id = Computer::ALL_IN_ONE_PC_ID; //ID equipo all in one
    $pc->brand_id = $request['marca-pc-select2'];
    $pc->model = $request['modelo-pc'];
    $pc->serial = $request['serial-pc'];
    $pc->os_id = $request['os-pc-select2'];
    $pc->slot_one_ram_id = $request['val-select2-ram0'];
    $pc->slot_two_ram_id = $request['val-select2-ram1'];
    $pc->storage_id = $request['val-select2-storage'];
    $pc->cpu = $request['cpu'];
    $pc->statu_id = $arrayToString;
    $pc->ip = $request['ip'];
    $pc->mac = $request['mac'];
    $pc->anydesk = $request['anydesk'];
    $pc->pc_name = $pc_name_chain;
    $pc->campu_id = $request['val-select2-campus'];
    $pc->location = $request['location'];
    $pc->observation = $request['observation'];
    $pc->rowguid = Uuid::uuid();
    $pc->created_at = now();
    //dd($pc);
    //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pc, true));
    $pc->save();

    return redirect()->route('admin.pcs.index', 200)
      ->with(
        'pc_created',
        'Nuevo equipo añadido al inventario!'
      );
  }

  public function createTurnero()
  {

    $operatingSystems = DB::table('operating_systems')
      ->select('id', 'name', 'version', 'architecture')
      ->whereIn('id', [1, 2, 3, 4, 5, 6])
      ->get();

    $SlotOneRams = DB::table('slot_one_rams')->select('id', 'ram')->where('id', '<>', [22])->get();

    $SlotTwoRams = DB::table('slot_two_rams')->select('id', 'ram')->where('id', '<>', [22])->get();

    $storages = DB::table('storages')->select('id', 'size', 'type')->where('id', '<>', [29])->get();

    $brands = DB::table('brands')->select('id', 'name')->where('id', '<>', [4])->get();

    $campus = DB::table('campus')->select('id', 'description')->get();
    //$status = DB::table('status_computers')->select('id', 'name')->where('id', '<>', 4)->get();

    $secondSegmentIp = rand(1, 254);
    $thirdSegmentIp = rand(1, 254);
    $ip = '192.168.' . $secondSegmentIp . '.' . $thirdSegmentIp;

    $macAdress = Str::upper(Str::random(3)) . '.' .
      Str::upper(Str::random(3)) . '.' .
      Str::upper(Str::random(3)) . '.' .
      Str::upper(Str::random(3));

    //$campus = Campu::select('id', 'description')->get();
    //dd($campus);
    //$campu = Campu::select('id', 'description')->where('id','MAC')->get();
    /*$slug = Str::slug('VIVA 1A IPS MACARENA', '-');
        dd($slug);*/

    $data =
      [
        'operatingSystems' => $operatingSystems,
        'SlotOneRams' => $SlotOneRams,
        'SlotTwoRams' => $SlotTwoRams,
        'storages' => $storages,
        'brands' => $brands,
        'campus' => $campus,
        'ip' => $ip,
        'macAdress' => $macAdress,
        //'status' => $status
      ];

    return view('admin.forms.create_turnero')->with($data);
  }

  public function storeTurnero(Request $request)
  {

    $generatorID = Helper::IDGenerator(new Computer, 'inventory_code_number', 8, 'PC');
    $str = Str::random(5);
    $pc_name_chain = 'V1AMAC-' . $str;
    $arrayToString = implode(',', $request->input('estado-pc'));

    $pc = new Computer();
    $pc->inventory_code_number =  $generatorID;
    $pc->type_id = Computer::TURNERO_PC_ID; //ID equipo turnero
    $pc->brand_id = $request['marca-pc-select2'];
    $pc->model = $request['modelo-pc'];
    $pc->serial = $request['serial-pc'];
    $pc->serial_monitor = $request['serial-monitor-pc'];
    $pc->os_id = $request['os-pc-select2'];
    $pc->slot_one_ram_id = $request['val-select2-ram0'];
    $pc->slot_two_ram_id = $request['val-select2-ram1'];
    $pc->storage_id = $request['val-select2-storage'];
    $pc->cpu = $request['cpu'];
    $pc->statu_id = $arrayToString;
    $pc->ip = $request['ip'];
    $pc->mac = $request['mac'];
    $pc->anydesk = $request['anydesk'];
    $pc->pc_name = $pc_name_chain;
    $pc->campu_id = $request['val-select2-campus'];
    $pc->location = $request['location'];
    $pc->observation = $request['observation'];
    $pc->rowguid = Uuid::uuid();
    $pc->created_at = now();
    //dd($pc);
    //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pc, true));
    $pc->save();

    return redirect()->route('admin.pcs.index', 200)
      ->with(
        'pc_created',
        'Nuevo equipo añadido al inventario!'
      );
  }

  public function createRaspberry()
  {

    $operatingSystems = DB::table('operating_systems')
      ->select('id', 'name', 'version', 'architecture')
      ->whereIn('id', [7, 8])
      ->get();

    $SlotOneRams = DB::table('slot_one_rams')->select('id', 'ram')->whereIn('id', [22])->get();

    $SlotTwoRams = DB::table('slot_two_rams')->select('id', 'ram')->whereIn('id', [22])->get();

    $storages = DB::table('storages')->select('id', 'size', 'type')->whereIn('id', [29])->get();

    $brands = DB::table('brands')->select('id', 'name')->where('id', '=', [4])->get();

    $campus = DB::table('campus')->select('id', 'description')->get();
    //$status = DB::table('status_computers')->select('id', 'name')->where('id', '<>', 4)->get();

    $secondSegmentIp = rand(1, 254);
    $thirdSegmentIp = rand(1, 254);
    $ip = '192.168.' . $secondSegmentIp . '.' . $thirdSegmentIp;

    $macAdress = Str::upper(Str::random(3)) . '.' .
      Str::upper(Str::random(3)) . '.' .
      Str::upper(Str::random(3)) . '.' .
      Str::upper(Str::random(3));

    //$campus = Campu::select('id', 'description')->get();
    //dd($campus);
    //$campu = Campu::select('id', 'description')->where('id','MAC')->get();
    /*$slug = Str::slug('VIVA 1A IPS MACARENA', '-');
        dd($slug);*/

    $data =
      [
        'operatingSystems' => $operatingSystems,
        'SlotOneRams' => $SlotOneRams,
        'SlotTwoRams' => $SlotTwoRams,
        'storages' => $storages,
        'brands' => $brands,
        'campus' => $campus,
        'ip' => $ip,
        'macAdress' => $macAdress,
        //'status' => $status
      ];

    return view('admin.forms.create_raspberry')->with($data);
  }

  public function storeRaspberry(Request $request)
  {

    $generatorID = Helper::IDGenerator(new Computer, 'inventory_code_number', 8, 'PC');
    $str = Str::random(5);
    $pc_name_chain = 'V1AMAC-' . $str;
    $arrayToString = implode(',', $request->input('estado-pc'));

    $pc = new Computer();
    $pc->inventory_code_number =  $generatorID;
    $pc->type_id = Computer::RASPBERRY_PI_ID; //ID equipo raspberry
    $pc->brand_id = $request['marca-pc-select2'];
    $pc->model = $request['modelo-pc'];
    $pc->serial = $request['serial-pc'];
    $pc->os_id = $request['os-pc-select2'];
    $pc->slot_one_ram_id = $request['val-select2-ram0'];
    $pc->slot_two_ram_id = $request['val-select2-ram1'];
    $pc->storage_id = $request['val-select2-storage'];
    $pc->cpu = $request['cpu'];
    $pc->statu_id = $arrayToString;
    $pc->ip = $request['ip'];
    $pc->mac = $request['mac'];
    $pc->anydesk = $request['anydesk'];
    $pc->pc_name = $pc_name_chain;
    $pc->campu_id = $request['val-select2-campus'];
    $pc->location = $request['location'];
    $pc->observation = $request['observation'];
    $pc->rowguid = Uuid::uuid();
    $pc->created_at = now();
    //dd($pc);
    //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pc, true));
    $pc->save();

    return redirect()->route('admin.pcs.index', 200)
      ->with(
        'pc_created',
        'Nuevo equipo añadido al inventario!'
      );
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
    //
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
      $data = array('deleted_at' => $ts, 'is_active' => false, 'statu_id' => 'eliminado');
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
