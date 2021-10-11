<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use App\Models\Device;
use App\Models\Report;
use App\Models\ReportRemove;
use Faker\Provider\Uuid;
use Barryvdh\DomPDF\Facade as PDF;

class ReportController extends Controller
{

    private $generatorID;

    public function __construct()
    {
        $this->generatorID = Helper::IDGenerator(new Report, 'report_code_number', 12, 'REPO');
        $this->report = new Report();
        $this->report_remove = new ReportRemove();
    }

    public function getDevice()
    {
        return view('report.index');
    }

    public function reportModule(Request $request)
    {
        $user_id = Auth::id();

        $serial_number = $request->get('search');

        $devices = Device::leftJoin('status as s', 's.id', 'devices.statu_id')
        ->leftJoin('statu_devices as sd', 'sd.statu_id', 's.id')
        ->leftJoin('campus as c', 'c.id', 'devices.campu_id')
        ->leftJoin('campu_users as cu', 'cu.id', 'devices.campu_id')
        ->leftJoin('users as u', 'u.id','cu.user_id')
        ->select(
            'devices.inventory_code_number',
            'devices.serial_number',
            'devices.ip',
            'devices.mac',
            'c.name as sede',
            's.name as estado',
            's.id as statu_id',
            'devices.rowguid',
            'devices.id as device_id'
        )
        ->search($serial_number)
        ->where('u.id', $user_id)
        ->whereIn('devices.statu_id', [1,2,3,5,6,7,8,9,10])
        ->where('devices.is_active', true)
        ->get();

        //return response()->json($devices);

        $search_serial_number = Device::select('serial_number')
        ->where('is_active', true)
        ->search($serial_number);

        /*$devices = DB::table('view_all_devices')
            ->where('TecnicoID', Auth::id())
            ->get();*/

        return view('report.create', compact('devices','search_serial_number'));
    }

    public function reportRemove($device, $id, $serial)
    {
        $device = Device::findOrFail($device);

        $technician_solutions = DB::table('technician_solutions')
            ->select('id', 'name')
            ->get();

        $report_removes = DB::table('reports as r')
            ->leftJoin('report_names as rn', 'rn.id', 'r.report_name_id')
            ->leftJoin('report_removes as rr', 'rr.report_id', 'r.id')
            ->leftJoin('devices as d', 'd.id', 'r.device_id')
            ->select(
               'report_code_number',
                'r.id as repo_id',
                DB::raw("UPPER(rn.name) repo_name"),
                'd.serial_number as serial_number',
                DB::raw("DATE_FORMAT(r.created_at, '%c/%e/%Y - %r') date_created")
            )
            ->where('r.user_id', Auth::id())
            ->where('r.device_id', $device->id)
            ->get();

        //return response()->json($report_removes);

        $data = [
            'device' => $device,
            'technician_solutions' => $technician_solutions,
            'report_removes' => $report_removes
        ];

        return view('report.show')->with($data);
    }

    public function reportRemoveGenerated($id)
    {
        Report::findOrFail($id);

        $generated_report_remove = DB::table('view_report_removes')
            ->where('RepoID', $id)
            ->get();

        $pdf = PDF::loadView(
            'report.removes.pdf',
            [
                'generated_report_remove' => $generated_report_remove
            ]
        );

        return $pdf->stream('formato-solictud-de-baja-de-equipos.pdf');
    }

    public function reportRemoveStore(Request $request)
    {
        $user_id = Auth::id();
        $device_id = e($request->input('device-id'));
        $tec_solutions = e($request->input('val-select2-tec-solutions'));
        $diagnostic = e($request->input('diagnostic'));
        $observation = e($request->input('observation'));

        $rules = [];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)
                ->withInput()
                ->with(
                    'message',
                    'Revisar campos! :-('
                )->with(
                    'modal',
                    'error'
                );
        else :
            DB::beginTransaction();

            DB::insert(
                "CALL SP_insertReport (?,?,?,?,?,?,?,?,?)",
                [
                    $this->report->report_code_number = $this->generatorID,
                    $this->report->report_name_id = Report::REPORT_REMOVE_NAME_ID,
                    $this->report->device_id = $device_id,
                    $this->report->user_id = $user_id,
                    $this->report->rowguid = Uuid::uuid(),
                    $this->report->created_at = now('America/Bogota'),

                    $this->report_remove->technician_solution_id = $tec_solutions,
                    $this->report_remove->diagnostic = $diagnostic,
                    $this->report_remove->observation = $observation,
                ]
            );
            DB::commit();
            return back()->withErrors($validator)
                ->with('report_created', 'Reporte realizado con exito!');
        endif;
        try {
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('info_error', '');
            throw $e;
        }
    }

    public function reportResumeStore($device, $id, $serial)
    {
        $device = Device::findOrFail($device);

        $technician_solutions = DB::table('technician_solutions')
            ->select('id', 'name')
            ->get();

        $report_names = DB::table('report_names')
            ->select('name')
            ->get();

        //VISTA DE LOS REPORTES

        return view('report.show', compact('device', 'report_names', 'technician_solutions'));
    }
}
