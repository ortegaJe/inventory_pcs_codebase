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

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $global_pc_count = Computer::count();
        //dd($global_pc_count);

        if ($request->ajax()) {
            $pcs = DB::table('view_all_pcs')->get();
            //dd($pcs);

            $datatables = DataTables::of($pcs);
            $datatables->editColumn('FechaCreacion', function ($pcs) {
                return $pcs->FechaCreacion ? with(new Carbon($pcs->FechaCreacion))
                    ->format('d-m-Y h:i A')    : '';
            });
            $datatables->addColumn('EstadoPC', function ($pcs) {
                return $pcs->EstadoPC;
            });
            $datatables->editColumn('EstadoPC', function ($pcs) {

                if ($pcs->EstadoPC = 'rendimiento optimo') {
                    return '<span class="badge badge-pill badge-success">' . $pcs->EstadoPC . '</span>';
                } else if ($pcs->EstadoPC = 'rendimiento bajo') {
                    return '<span class="badge badge-pill badge-warning">' . $pcs->EstadoPC . '</span>';
                } else if ($pcs->EstadoPC = 'hurtado') {
                    return '<span class="badge badge-pill badge-orange">' . $pcs->EstadoPC . '</span>';
                } else if ($pcs->EstadoPC = 'dado de baja') {
                    return '<span class="badge badge-pill badge-secondary">' . $pcs->EstadoPC . '</span>';
                }
            });
            $datatables->addColumn('action', function ($pcs) {
                $btn = '<button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="">
                                        <i class="fa fa-pencil"></i>
                                    </button>';
                $btn = $btn . '<button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="">
                                            <i class="fa fa-times"></i>
                                        </button>';
                return $btn;
            });
            $datatables->rawColumns(['action', 'EstadoPC']);
            return $datatables->make(true);
        }

        $data =
            [
                'global_pc_count' => $global_pc_count,
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
        $types = DB::table('types')->select('id', 'name')->get();
        $operating_systems = DB::table('operating_systems')->select('id', 'name', 'version', 'architecture')->get();
        $SlotOneRams = DB::table('slot_one_rams')->select('id', 'ram')->get();
        $SlotTwoRams = DB::table('slot_two_rams')->select('id', 'ram')->get();
        $hdds = DB::table('hdds')->select('id', 'size', 'type')->get();
        $brands = DB::table('brands')->select('id', 'name')->get();
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
                'types' => $types,
                'operating_systems' => $operating_systems,
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
    public function store(Request $request, Faker $faker)
    {

        $generatorID = Helper::IDGenerator(new Computer, 'inv_code', 5, 'PC');

        $str = Str::random(5);
        $pc_name_chain = 'V1AMAC-' . $str;

        $pc = new Computer();
        $pc->inv_code =  $generatorID;
        $pc->type_id = $request['tipos-pc-select2'];
        $pc->brand_id = $request['marca-pc-select2'];
        $pc->model = $request['modelo-pc'];
        $pc->serial = $request['serial-pc'];
        $pc->serial_monitor = $request['serial-monitor-pc'];
        $pc->os_id = $request['os-pc-select2'];
        $pc->slot_one_ram_id = $request['val-select2-ram0'];
        $pc->slot_two_ram_id = $request['val-select2-ram1'];
        $pc->hdd_id = $request['val-select2-hdd'];
        $pc->cpu = $request['cpu'];
        $pc->ip = $request['ip'];
        $pc->mac = $request['mac'];
        $pc->anydesk = $request['anydesk'];
        $pc->pc_name = $pc_name_chain;
        $pc->campu_id = $request['val-select2-campus'];
        $pc->location = $request['location'];
        $pc->observation = $request['observation'];
        $pc->rowuuid = $faker->uuid;
        $pc->created_at = now();
        //dd($pc);
        $pc->save();

        return redirect()->route('admin.pcs.index', 200)
            ->with(
                'pc_created',
                'Nuevo equipo fué añadido al inventario'
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
        //
    }
}
