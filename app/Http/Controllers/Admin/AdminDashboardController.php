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
use Faker\Generator as Faker;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\ModelNotFoundException; //Import exception.

class AdminDashboardController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $globalPcCount = DB::table('computers')->select('type_id')->where('type_id', 1)->count(); //globalDesktopPcCount
    $globalAllInOnePcCount = DB::table('computers')->select('type_id')->where('type_id', 5)->count();
    $globalTurneroPcCount = DB::table('computers')->select('type_id')->where('type_id', 2)->count();
    $globalRaspberryPcCount = Computer::where('id')->count();
    //dd($globalPcCount);
    //dd($globalAllInOnePcCount);
    //dd($globalRaspberryPcCount);

    if ($request->ajax()) {
      $pcs = DB::table('view_all_pcs')->get();
      //dd($pcs);

      $datatables = DataTables::of($pcs);
      $datatables->editColumn('FechaCreacion', function ($pcs) {
        return $pcs->FechaCreacion ? with(new Carbon($pcs->FechaCreacion))
          ->format('d-m-Y h:i A')    : '';
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
        $btn = $btn . "<button class='btn btn-sm btn-secondary js-tooltip-enabled' data-id='$pcs->ComputerID' id='btn-delete'>
                                        <i class='fa fa-times'></i>";
        return $btn;
      });
      $datatables->rawColumns(['action', 'EstadoPC']);
      return $datatables->make(true);
    }

    $data =
      [
        'globalPcCount' => $globalPcCount,
        'globalAllInOnePcCount' => $globalAllInOnePcCount,
        'globalTurneroPcCount' => $globalTurneroPcCount,
        'globalRaspberryPcCount' => $globalRaspberryPcCount
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

    $hdds = DB::table('hdds')->select('id', 'size', 'type')->where('id', '<>', [29])->get();

    $brands = DB::table('brands')->select('id', 'name')->where('id', '<>', [4])->get();

    $campus = DB::table('campus')->select('id', 'description')->get();

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
        'hdds' => $hdds,
        'brands' => $brands,
        'campus' => $campus,
        'ip' => $ip,
        'macAdress' => $macAdress,
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
    $pc->hdd_id = $request['val-select2-hdd'];
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

  public function createAllInOne()
  {

    $operatingSystems = DB::table('operating_systems')
      ->select('id', 'name', 'version', 'architecture')
      ->whereIn('id', [1, 2, 3, 4, 5, 6])
      ->get();

    $SlotOneRams = DB::table('slot_one_rams')->select('id', 'ram')->where('id', '<>', [22])->get();

    $SlotTwoRams = DB::table('slot_two_rams')->select('id', 'ram')->where('id', '<>', [22])->get();

    $hdds = DB::table('hdds')->select('id', 'size', 'type')->where('id', '<>', [29])->get();

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
        'hdds' => $hdds,
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
    $pc->hdd_id = $request['val-select2-hdd'];
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

    $hdds = DB::table('hdds')->select('id', 'size', 'type')->where('id', '<>', [29])->get();

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
        'hdds' => $hdds,
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
    $pc->hdd_id = $request['val-select2-hdd'];
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

    $hdds = DB::table('hdds')->select('id', 'size', 'type')->whereIn('id', [29])->get();

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
        'hdds' => $hdds,
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
    $pc->hdd_id = $request['val-select2-hdd'];
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
      $pcTemp[] = DB::select("SELECT * FROM computers WHERE id = $id", [1]);
      $pcs = DB::delete("DELETE FROM computers WHERE id = $id", [1]);
      error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($pcs, true));
    } catch (ModelNotFoundException $e) {
      // Handle the error.
    }

    return response()->json([
      'message' => 'Equipo borrado del inventario exitosamente!',
      'result' => $pcTemp[0]
    ]);
  }
}
