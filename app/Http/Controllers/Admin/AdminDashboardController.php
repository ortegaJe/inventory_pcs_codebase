<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Computer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

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
                    $pcs = DB::table('view_admin_pcs')->get();
                        //dd($pcs);

                return DataTables::of($pcs)
                            ->addColumn('action', function ($pcs) {
                           $btn = '<button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit" aria-describedby="">
                                        <i class="fa fa-pencil"></i>
                                    </button>';
                           $btn = $btn.'<button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Delete">
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
        $rams = DB::table('rams')->select('id', 'ram')->get();
        $hdds = DB::table('hdds')->select('id', 'size','type')->get();
        $brands = DB::table('brands')->select('id', 'name')->get();
        $campus = DB::table('campus')->select('id', 'description')->get();

        $data = [
            'types' => $types,
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
        $str=Str::random(4);
        $inv_code_chain = 'INVPC-'.$str;

        $str_ip1=Str::random(3);
        $str_ip2=Str::random(3);
        $ip_chain = '192.168.'.$str_ip1.'.'.$str_ip2;

        $str=Str::random(5);
        $pc_name_chain = 'V1AMAC-'.$str;

        $pc = new Computer();
        $pc->inv_code = $inv_code_chain;
        $pc->type_id = $request['select-tipos-pc'];
        $pc->brand = $request['marca'];
        $pc->model = $request['modelo'];
        $pc->serial = $request['serial-equipo'];
        $pc->serial_monitor = $request['serial-monitor'];
        $pc->os = $request['os'];
        $pc->ram_slot_0_id = $request['val-select2-ram0'];
        $pc->ram_slot_1_id = $request['val-select2-ram1'];
        $pc->hdd_id = $request['val-select2-hdd'];
        $pc->cpu = $request['cpu'];
        $pc->ip = $ip_chain;
        $pc->mac = $request['mac'];
        $pc->anydesk = $request['anydesk'];
        $pc->pc_name = $pc_name_chain;
        $pc->campus_id = $request['val-select2-campus'];
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
