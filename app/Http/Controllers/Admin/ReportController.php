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
        $this->generatorID = Helper::IDGenerator(new Report, 'inventory_report', 12, 'REPO');
        $this->report = new Report();
        $this->report_remove = new ReportRemove();
    }

    public function getDevice()
    {
        return view('report.index');
    }

    public function reportModule()
    {
        $devices = DB::table('view_all_devices')
            ->where('TecnicoID', Auth::id())
            ->get();

        return view('report.create', compact('devices'));
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

        return $pdf->stream('formato-solictud-de-baja-de-equipos');
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
                "CALL SP_insertReport (?,?,?,?,?,?,?,?)", //32
                [
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
