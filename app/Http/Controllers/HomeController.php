<?php

namespace App\Http\Controllers;

use App\Models\Device;
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
        return view('dashboard');
    }

    public function search(Request $request)
    {

        if ($request->ajax()) {
            DB::statement(DB::raw('set @rownum=0'));
            $data = Device::select([
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'devices.id',
                'devices.serial_number',
                'c.name as campu',
                DB::raw("CONCAT(u.name, ' ', u.last_name) as tec_full_name"),
            ])
                ->leftJoin('campus as c', 'c.id', 'devices.campu_id')
                ->leftJoin('campu_users as cu', 'cu.campu_id', 'c.id')
                ->leftJoin('users as u', 'u.id', 'cu.user_id')
                ->where('devices.serial_number', 'like', '%' . $request->search . '%')->get();
            //->orwhere('title', 'like', '%' . $request->search . '%')
            //->orwhere('description', 'like', '%' . $request->search . '%')->get();

            $output = '';
            if (count($data) > 0) {

                $output = '
            <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">SERIAL</th>
                <th scope="col">SERIAL MONITOR</th>
                <th scope="col">SEDE</th>
                <th scope="col">TECNICO</th>
                <th scope="col">ACCIONES</th>
            </tr>
            </thead>
            <tbody>';

                foreach ($data as $row) {
                    $output .= '
                    <tr>
                    <th scope="row">' . $row->rownum . '</th>
                    <td>' . $row->serial_number . '</td>
                    <td></td>
                    <td>' . $row->campu . '</td>
                    <td>' . $row->tec_full_name . '</td>
                    <td>
                    <button type="button"
                        class="btn btn-alt-info mr-5 mb-5"
                        data-toggle="modal"
                        data-target="#detail-modal"
                        id="detail-btn"
                        data-id=' . $row->id . '>
                        <i class="fa fa-eye mr-5"></i>
                        Detail
                    </button>
                    </td>
                    </tr>
                    ';
                }
                $output .= '
                </tbody>
                </table>';
            } else {
                $output .= 'No results';
            }

            return $output;
        }
    }

    public function detailDevice($id)
    {
        $data = Device::select([
            'devices.id',
            'td.name as type_device',
            'b.name as brand',
            'devices.model',
            'devices.serial_number',
            'comp.monitor_serial_number',
            DB::raw("CASE WHEN comp.slot_one_ram_id = 1 THEN 'NO APLICA'
                          WHEN comp.slot_one_ram_id = 19 THEN 'NO DISPONIBLE'
                          WHEN comp.slot_one_ram_id = 20 THEN 'DISPONIBLE' 
                        ELSE CONCAT(ram0.size, ' ', ram0.storage_unit, ' ', ram0.type, ' ', ram0.format)
                            END as ram0"),
            DB::raw("CASE WHEN comp.slot_two_ram_id = 1 THEN 'NO APLICA'
                          WHEN comp.slot_two_ram_id = 19 THEN 'NO DISPONIBLE'
                          WHEN comp.slot_two_ram_id = 20 THEN 'DISPONIBLE'
                        ELSE CONCAT(ram1.size, ' ', ram1.storage_unit, ' ', ram1.type, ' ', ram1.format)
                            END as ram1"),
            'c.name as campu',
            DB::raw("CONCAT(u.name, ' ', u.last_name) as tec_full_name"),
        ])
            ->leftJoin('campus as c', 'c.id', 'devices.campu_id')
            ->leftJoin('campu_users as cu', 'cu.campu_id', 'c.id')
            ->leftJoin('users as u', 'u.id', 'cu.user_id')
            ->leftJoin('type_devices as td', 'td.id', 'devices.type_device_id')
            ->leftJoin('brands as b', 'b.id', 'devices.brand_id')
            ->leftJoin('components as comp', 'comp.device_id', 'devices.id')
            ->leftJoin('memory_rams as ram0', 'ram0.id', 'comp.slot_one_ram_id')
            ->leftJoin('memory_rams as ram1', 'ram1.id', 'comp.slot_two_ram_id')
            ->where('devices.id', $id)
            ->get();

        return $data;
    }
}
