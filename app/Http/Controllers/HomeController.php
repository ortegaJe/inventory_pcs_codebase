<?php

namespace App\Http\Controllers;

use App\Models\Device;
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
                DB::raw("CONCAT(SUBSTRING(os.name, -7, 3),' ',
                         REPLACE(LEFT(os.version, 3), 'P', ''),' ',
                         LEFT(SUBSTRING_INDEX(os.version, ' ', -1), 3),' ',
                         os.architecture) AS os_name"),
            )
            ->where('d.is_active', true)
            ->where('d.statu_id', [1,2,8])
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

    public function autoCompleteSerialSearch(Request $request)
    {
        $query = $request->get('search');

        $filterResult = Device::where('serial_number', 'LIKE', '%' . $query . '%')
                            ->where('is_active', true)
                            ->pluck('serial_number');

        return response()->json($filterResult);
    }

    public function SearchDevice()
    {
        $devices = Device::join('campus as a', 'a.id', 'devices.campu_id')
                    ->join('type_devices as b', 'b.id', 'devices.type_device_id')
                    ->join('status as c', 'c.id', 'devices.statu_id')
                    ->join('brands as d', 'd.id', 'devices.brand_id')
                    //->where('devices.is_active', true)
                    ->get([
                        'b.name as type',
                        'd.name as brand',
                        'devices.serial_number',
                        'a.name as campu',
                        'c.name as status',
                        DB::raw("DATE_FORMAT(devices.created_at, '%d-%m-%Y') as date_created"),
                        ]);

        return response()->json($devices);
    }
}
