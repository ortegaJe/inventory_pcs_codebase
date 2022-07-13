<?php

namespace App\Http\Controllers\User\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\TypeDevice;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class GarbageController extends Controller
{
    public function index()
    {

        $deletedDevices = Device::restoreDevice(Auth::id());
        return $deletedDevices;

        $data =
            [
                'deletedDevices' => $deletedDevices,
            ];

        return view('user.inventory.desktop.index')->with($data);
    }

    public function restoreDevice($id)
    {
        $devices = null;
        $deviceTemp = [];
        //error_log(__LINE__ . __METHOD__ . ' pc --->' .$id);
        try {
            $devices = Device::findOrFail($id);

            $deviceTemp[] = DB::table('devices')->where('id', $id)->get();

            $ts = now('America/Bogota')->toDateTimeString();
            //$softDeletePc = array('deleted_at' => $ts, 'is_active' => false, 'statu_id' => 4);
            $softDeleteDevice = array('is_active' => true, 'statu_id' => 1);
            $devices = DB::table('devices')->where('id', $id)->update($softDeleteDevice);
            error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($devices, true));
            /* 
            $deleteStatu = array('statu_id' => 4, 'device_id' => $id, 'date_log' => $ts);
            $devices = DB::table('statu_devices')->where('device_id', $id)->insert($deleteStatu);
            error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($devices, true));

            $deviceLogDelete = array('device_id' => $id, 'user_id' => Auth::id(), 'deleted_at' => $ts);
            $devices = DB::table('device_log')->where('device_id', $id)->insert($deviceLogDelete); */
        } catch (ModelNotFoundException $e) {
            // Handle the error.
        }

        return response()->json([
            'message' => 'Equipo recuperado del inventario exitosamente!',
            'result' => $deviceTemp[0]
        ]);
    }
}
