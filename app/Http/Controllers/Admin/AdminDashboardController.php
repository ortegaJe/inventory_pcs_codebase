<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Helpers\Helper;

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

                return DataTables::of($pcs)
                            ->addColumn('action', function ($pcs) {
                           $btn = '<button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="">
                                        <i class="fa fa-pencil"></i>
                                    </button>';
                           $btn = $btn.'<button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="">
                                            <i class="fa fa-times"></i>
                                        </button>';        
                            return $btn;            
                        })
                        ->rawColumns(['action' => 'action'])
                        ->make(true);
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
        $rams = DB::table('rams')->select('id', 'ram')->get();
        $hdds = DB::table('hdds')->select('id', 'size','type')->get();
        $brands = DB::table('brands')->select('id', 'name')->get();
        $campus = DB::table('campus')->select('id', 'description')->get();
        //$campus = Campu::select('id', 'description')->get();
        //dd($campus);
        //$campu = Campu::select('id', 'description')->where('id','MAC')->get();
        /*$slug = Str::slug('VIVA 1A IPS MACARENA', '-');
        dd($slug);*/

        $data = 
        [
            'types' => $types,
            'operating_systems' => $operating_systems,
            'rams' => $rams,
            'hdds' => $hdds,
            'brands' => $brands,
            'campus' => $campus
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

        $generatorID = Helper::IDGenerator(new Computer,'inv_code',4,'INVPC');

        $str_ip1=Str::random(3);
        $str_ip2=Str::random(3);
        $ip_chain = '192.168.'.$str_ip1.'.'.$str_ip2;

        $str=Str::random(5);
        $pc_name_chain = 'V1AMAC-'.$str;

        $pc = new Computer();
        $pc->inv_code = $generatorID;
        $pc->type_id = $request['tipos-pc-select2'];
        $pc->brand_id = $request['marca-pc-select2'];
        $pc->model = $request['modelo-pc'];
        $pc->serial = $request['serial-pc'];
        $pc->serial_monitor = $request['serial-monitor-pc'];
        $pc->os_id = $request['os-pc-select2'];
        $pc->ram_slot_0_id = $request['val-select2-ram0'];
        $pc->ram_slot_1_id = $request['val-select2-ram1'];
        $pc->hdd_id = $request['val-select2-hdd'];
        $pc->cpu = $request['cpu'];
        $pc->ip = $ip_chain;
        $pc->mac = $request['mac'];
        $pc->anydesk = $request['anydesk'];
        $pc->pc_name = $pc_name_chain;
        $pc->campu_id = $request['val-select2-campus'];
        $pc->location = $request['location'];
        $pc->observation = $request['observation'];
        $pc->created_at = now();
        //dd($pc);
        $pc->save();

        return redirect()->route('admin.pcs.index')
            ->with('pc_created','Nuevo equipo fué añadido al inventario'
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
