<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ComputersExport;
use App\Exports\DevicesExport;
use App\Http\Controllers\Controller;
use App\Models\Computer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use App\Models\AdminSignature;
use App\Models\Campu;
use App\Models\Device;
use App\Models\TypeDevice;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\ModelNotFoundException; //Import exception.
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class AdminDashboardController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  private $excel;

  public function __construct(Excel $excel)
  {
    $this->excel = $excel;
  }

  public function index(Request $request)
  {
    $globalDesktopCount = TypeDevice::countTypeDevice(TypeDevice::DESKTOP_PC_ID);
    $globalTurneroCount = TypeDevice::countTypeDevice(TypeDevice::TURNERO_PC_ID);
    $globalLaptopCount  = TypeDevice::countTypeDevice(TypeDevice::LAPTOP_PC_ID);
    $globalRaspberryCount = TypeDevice::countTypeDevice(TypeDevice::RASPBERRY_PI_ID);
    $globalAllInOneCount = TypeDevice::countTypeDevice(TypeDevice::ALL_IN_ONE_PC_ID);
    $globalIpPhoneCount = TypeDevice::countTypeDevice(TypeDevice::IP_PHONE_ID);

    if ($request->ajax()) {
      $devices = DB::table('view_all_devices_admin')
        //->where('Sede', '<>', 'VIVA 1A CASA MATRIZ')
        ->orderByDesc('FechaCreacion')
        ->get();

      $datatables = DataTables::of($devices);
      $datatables->addColumn('EstadoPC', function ($devices) {
        return $devices->EstadoPc;
      });

      $datatables->rawColumns(['EstadoPC']);
      return $datatables->make(true);
    }

    $data =
      [
        'globalDesktopCount' => $globalDesktopCount,
        'globalTurneroCount' => $globalTurneroCount,
        'globalLaptopCount' => $globalLaptopCount,
        'globalRaspberryCount' => $globalRaspberryCount,
        'globalAllInOneCount' => $globalAllInOneCount,
        'globalIpPhoneCount' => $globalIpPhoneCount,
      ];

    return view('admin.index')->with($data);
  }

  public function getCampusFewerDevices(Request $request)
  {
    if ($request->ajax()) {
      $campus = DB::table('campus as c')
        ->leftJoin('campu_users as cu', 'cu.campu_id', 'c.id')
        ->leftJoin('users as u', 'u.id', 'cu.user_id')
        ->leftJoin('devices as d', 'd.campu_id', 'c.id')
        ->select(
          DB::raw("CASE WHEN u.id IS NULL THEN
                          'Sin técnico asignado'
                              ELSE CONCAT(u.name, ' ', u.last_name) 
                                END AS nombre_tecnico"),
          DB::raw("CASE WHEN u.phone_number IS NULL THEN
                          ' '
                              ELSE u.phone_number 
                                END AS telefono"),
          'c.id as sede_id',
          'u.id as user_id',
          'c.name as nombre_sede',
          DB::raw("COUNT(d.campu_id) AS numero_equipos"),
          DB::raw("CASE WHEN COUNT(d.campu_id) = 0 THEN 'badge-danger'
                          WHEN COUNT(d.campu_id) <= 4 THEN 'badge-warning'    
                            ELSE 'badge-success' 
                              END AS color"),
        )
        ->groupByRaw('c.id, c.name, u.id, u.name, u.last_name, u.phone_number')
        //->havingRaw('numero_equipos <= 4')
        ->orderByRaw('numero_equipos')
        ->get();

      $datatables = DataTables::of($campus);
      $datatables->addColumn('nombre_tecnico', function ($campus) {
        //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($campus->EstadoPC, true));
        return $campus->nombre_tecnico;
      });
      $datatables->addColumn('numero_equipos', function ($campus) {
        //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($campus->EstadoPC, true));
        return $campus->numero_equipos;
      });
      $datatables->rawColumns(['nombre_tecnico', 'numero_equipos']);
      return $datatables->make(true);
    }
  }

  public function getStock(Request $request)
  {
    if ($request->ajax()) {

      $devices = DB::table('view_all_devices')
        ->where('TecnicoID', Auth::id(2))
        ->where('EstadoPc', 'stock')
        ->get();

      $datatables = DataTables::of($devices);
      $datatables->addColumn('EstadoPC', function ($devices) {
        //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($devices->EstadoPC, true));
        return $devices->EstadoPc;
      });

      $datatables->addColumn('action', function ($devices) {
        //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($devices->DeviceID, true));
        $btn = "<a type='button' class='btn btn-sm btn-secondary' id='btn-edit' 
                            href = '" . route('user.inventory.desktop.edit', $devices->DeviceID) . "'>
                                <i class='fa fa-pencil'></i>
                        </a>";
        $btn = $btn . "<button type='button' class='btn btn-sm btn-secondary' data-id='$devices->DeviceID' id='btn-delete'>
                                    <i class='fa fa-times'></i>";
        return $btn;
      });
      $datatables->rawColumns(['action', 'EstadoPC']);
      return $datatables->make(true);
    }

    return view('user.inventory.stock.index');
  }

  public function createAdminSignature()
  {
    return view('admin.firmas.create');
  }

  public function storeAdminSignature(Request $request)
  {
    $request->validate([
      'imagen-firma' => 'required|image|max:1024'
    ]);

    $file = $request->file('imagen-firma')->store('public');

    $url = Storage::url($file);
    /*return $file;
    //obtenemos el nombre del archivo
    $nombre =  time() . "_" . $file->getClientOriginalName();
    return $nombre;
    //indicamos que queremos guardar un nuevo archivo en el disco local
    Storage::disk('local')->put($nombre,  File::get($file));

    $signature = new AdminSignature();
    $signature->nombre_archivo = $nombre;
    $signature->save();*/

    $signature = new AdminSignature();
    $signature->nombre_archivo = $url;
    $signature->save();

    return back();
  }

  public function exportComputers()
  {
    $rand = Str::upper(Str::random(12));

    return $this->excel->download(new DevicesExport, "export_inventory_devices_" . $rand . ".xlsx");
  }

  public function maintenanceView($id)
  {
    $campus = Campu::findOrFail($id);

    return view('admin.op_maintenance', compact('campus'));
  }

  public function comingSoonView($id)
  {
    $campus = Campu::findOrFail($id);

    return view('admin.op_coming_soon', compact('campus'));
  }

  public function errorView()
  {
    return view('admin.op_error_400');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

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
  }
}
