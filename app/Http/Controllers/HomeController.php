<?php

namespace App\Http\Controllers;

use App\Models\TypeDevice;
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
            ->pluck('total', 'os_name');

        //return $opSystems;

        $name = $opSystems->keys();
        $data = $opSystems->values();
        //return [$labels, $data];

        return view('dashboard', compact('name','data'));
    }

     public function validateSign()
    {
        $users = DB::table('users as u')
        ->leftJoin('campu_users as cu', 'cu.user_id', 'u.id')
        ->leftJoin('campus as c', 'c.id', 'cu.campu_id')
        ->where('cu.user_id', Auth::id())
        ->select('u.id as user_id', 
                 'u.sign as user_sign',
                 'c.id as campu_id', 
                 'c.name as campus',
                 'c.abreviature',
                 'c.admin_name', 
                 'c.admin_last_name', 
                 'c.admin_sign'
        )->get();

        return $users;
    }

    public function getCategoryDevice()
    {
        $options = TypeDevice::pluck('name', 'id')->toArray();
        return response()->json($options);
    }
}
