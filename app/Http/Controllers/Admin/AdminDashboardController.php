<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ComputersExport;
use App\Http\Controllers\Controller;
use App\Models\Computer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use App\Models\Campu;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\ModelNotFoundException; //Import exception.
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
    $globalDesktopPcCount = Computer::countPc(1);   //DE ESCRITORIO
    $globalTurneroPcCount = Computer::countPc(2);   //TURNERO
    $globalLaptopPcCount  = Computer::countPc(3);   //PORTATIL
    $globalRaspberryPcCount = Computer::countPc(4); //RASPBERRY
    $globalAllInOnePcCount = Computer::countPc(5);  //ALL IN ONE

    if ($request->ajax()) {
      $pcs = DB::table('view_all_pcs')->orderByDesc('FechaCreacion')->get();
      //dd($pcs);

      $datatables = DataTables::of($pcs);
      $datatables->editColumn('FechaCreacion', function ($pcs) {
        return $pcs->FechaCreacion ? with(new Carbon($pcs->FechaCreacion))
          ->format('d/m/Y h:i A')    : '';
      });

      $datatables->addColumn('EstadoPC', function ($pcs) {
        return $pcs->EstadoPc;
      });

      $datatables->editColumn('EstadoPC', function ($pcs) {
        $status = "<span class='badge badge-pill" . " " . $pcs->ColorEstado . " btn-block'>
                            $pcs->EstadoPc</span>";
        return Str::title($status);
      });

      $datatables->rawColumns(['EstadoPC']);
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

  public function exportComputers()
  {
    return $this->excel->download(new ComputersExport, "computers.xlsx");
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
