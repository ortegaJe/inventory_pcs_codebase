<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $opSystems = DB::table('devices as d')
            ->leftJoin('components as c', 'c.device_id', 'd.id')
            ->leftJoin('operating_systems as os', 'os.id', 'c.os_id')
            ->select(
                DB::raw("COUNT(c.os_id) as total"),
                DB::raw("CONCAT(os.name, ' ', os.version, ' ', os.architecture) AS os_name")
            )
            ->whereIn('d.type_device_id', [1, 2, 3, 5])
            ->groupBy('os_name', 'c.os_id')
            ->orderByDesc('total')
            ->get();

        //return $opSystems;

        $dataPoints = [];

        foreach ($opSystems as $opSystem) {

            $dataPoints[] = [
                'name'    => $opSystem->os_name,
                'y'       => (int)$opSystem->total
            ];
        }

        $data['chart_data'] = json_encode(array($dataPoints));
        return view('dashboard', $data);
    }
}
