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

    public function getDevicesList(Request $request)
    {
        $deletedDevices = Device::restoreDevice(Auth::id());
        return DataTables::of($deletedDevices)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<button type="button" class="btn btn-sm btn-secondary" data-id="' . $row['id'] . '" id="restore_device_btn">
                                        <i class="fa fa-undo"></i>';
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="device_checkbox" data-id="' . $row['id'] . '"><label></label>';
            })
            ->editColumn('is_deleted', function ($row) {
                return '<span class="badge badge-pill' . ' ' . $row->color . ' ' . 'btn-block">' . $row->is_deleted . '</span>';
                //return Str::title($status);
            })

            ->rawColumns(['actions', 'is_deleted', 'checkbox'])
            ->make(true);
    }

    public function retoreDevice(Request $request)
    {
        $device_id = null;
        $deviceTemp = [];
        $ts = now('America/Bogota')->toDateTimeString();

        $device_id = $request->device_id;

        $restoreDevice = array('is_active' => true, 'updated_at' => $ts);
        $query = Device::where('id', $device_id)->update($restoreDevice);

        $deviceTemp[] = Device::where('id', $device_id)->get();

        $deviceLogRestore = array('device_id' => $device_id, 'user_id' => Auth::id(), 'updated_at' => $ts);
        $query = DB::table('device_log')->where('device_id', $device_id)->insert($deviceLogRestore);


        if ($query) {
            return response()->json([
                'code' => 1,
                'msg' => 'Device has been restore',
                'result' => $deviceTemp[0]
            ]);
        } else {
            return response()->json([
                'code' => 0,
                'msg' => 'Something went wrong'
            ]);
        }
    }

    public function restoreSelectedDevices(Request $request)
    {
        $devices_id = null;
        $deviceTemp = [];
        $ts = now('America/Bogota')->toDateTimeString();

        $devices_id = $request->devices_id;

        $restoreDevices = array('is_active' => true, 'updated_at' => $ts);
        $query = Device::whereIn('id', $devices_id)->update($restoreDevices);

        $deviceTemp[] = Device::whereIn('id', $devices_id)->get();

        //$deviceLogRestore = array('device_id' => $devices_id, 'user_id' => Auth::id(), 'updated_at' => $ts);
        //$query = DB::table('device_log')->whereIn('device_id', $devices_id)->insert($deviceLogRestore);

        if ($query) {
            return response()->json([
                'code' => 1,
                'msg' => 'Devices has been restore',
                'result' => $deviceTemp[0]
            ]);
        } else {
            return response()->json([
                'code' => 0,
                'msg' => 'Something went wrong'
            ]);
        }
    }
}
