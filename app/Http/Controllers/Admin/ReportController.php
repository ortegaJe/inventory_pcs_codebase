<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use App\Models\Campu;
use App\Models\ReportDelivery;
use App\Models\Device;
use App\Models\DeviceMaintenance;
use App\Models\Report;
use App\Models\ReportDeliverie;
use App\Models\ReportRemove;
use App\Models\ReportMaintenance;
use App\Models\User;
use Faker\Provider\Uuid;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class ReportController extends Controller
{
    private $generatorID;

    public function __construct()
    {
        $this->generatorID = Helper::IDGenerator(new Report, 'report_code_number', 12, 'REPO');
        $this->report = new Report();
        $this->report_remove = new ReportRemove();
        $this->report_delivery = new ReportDelivery();
        $this->report_maintenance = new ReportMaintenance();
    }

    public function index()
    {
        return view('report.index');
    }

    public function indexReportRemove(Request $request)
    {
        $user_id = Auth::id();

        $serial_number = $request->get('search');

        $devices = Device::leftJoin('campus as c', 'c.id', 'devices.campu_id')
            ->leftJoin('campu_users as cu', 'cu.campu_id', 'devices.campu_id')
            ->leftJoin('users as u', 'u.id', 'cu.user_id')
            ->leftJoin('status as s', 's.id', 'devices.statu_id')
            ->select(
                'devices.inventory_code_number',
                'devices.serial_number',
                'devices.ip',
                'devices.mac',
                'cu.campu_id',
                'c.name as sede',
                's.name as estado',
                's.id as statu_id',
                'devices.rowguid',
                'devices.id as device_id'
            )
            ->where('cu.user_id', $user_id)
            ->where('devices.is_active', true)
            ->whereIn('devices.statu_id', [2, 3, 5, 6, 7])
            ->searchRemove($serial_number)
            ->orderByDesc('devices.created_at')
            ->paginate(10);
        return view('report.removes.index', compact('devices'));
    }

    public function createReportRemove($device, $uuid)
    {
        $user_id = Auth::id();
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
                'r.rowguid',
                DB::raw("UPPER(rn.name) repo_name"),
                'd.serial_number as serial_number',
                DB::raw("DATE_FORMAT(r.created_at, '%c/%e/%Y - %r') date_created")
            )
            ->where('r.user_id', $user_id)
            ->where('r.device_id', $device->id)
            ->where('r.report_name_id', Report::REPORT_REMOVE_NAME_ID)
            ->orderByDesc('r.created_at')
            ->get();

        //return response()->json($report_removes);

        $data = [
            'device' => $device,
            'technician_solutions' => $technician_solutions,
            'report_removes' => $report_removes
        ];

        return view('report.removes.show')->with($data);
    }

    public function storeReportRemove(Request $request)
    {
        $user_id = Auth::id();
        $device_id = e($request->input('device-id'));
        $tec_solutions = e($request->input('val-select2-tec-solutions'));
        $diagnostic = e($request->input('diagnostic'));
        $observation = e($request->input('observation'));

        $rules = [
            'val-select2-tec-solutions' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3, 4, 5, 6])
            ],

            'diagnostic' => 'required',
            'observation' => 'nullable'
        ];

        $messages = [
            'val-select2-tec-solutions.required' => 'Es requerido una solucion técnica',
            'val-select2-tec-solutions.in' => 'Seleccione una opción valida en la lista',
            'diagnostic.required' => 'Es requerido un diagnóstico',
        ];

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
                "CALL SP_insertReportRemove (?,?,?,?,?,?,?,?,?)",
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
                ->with('report_created', 'Reporte ' . $this->report->report_code_number . '');
            try {
            } catch (\Throwable $e) {
                DB::rollback();
                return back()->with('info_error', '');
                throw $e;
            }
        endif;
    }

    public function reportRemoveGenerated($id, $uuid)
    {
        $report = Report::findOrFail($id);
        $user_id = Auth::id();

        $generated_report_remove = DB::table('view_report_removes')
            ->where('RepoID', $id)
            ->where('TecnicoID', $user_id)
            ->get();

        /*         $boss_tic = User::select(DB::raw("UPPER(CONCAT(name,' ',middle_name,' ',last_name,' ',second_last_name)) AS BossTic"), 'sign')
            ->where('id', 37)
            ->first(); */

        $boss_tic = User::select(DB::raw("UPPER(CONCAT(name,' ',middle_name,' ',last_name,' ',second_last_name)) AS BossTic"), 'sign')
            ->where('id', 1)
            ->first();

        //return response()->json($generated_report_remove);

        $pdf = PDF::loadView(
            'report.removes.pdf',
            [
                'generated_report_remove' => $generated_report_remove,
                'boss_tic' => $boss_tic,
            ]
        );

        //$tiempo_creacion = now()->toDateString();
        $nombre_carpeta = 'pdf/de_baja/';
        $nombre_archivo = $report->report_code_number;
        $extension = '.pdf';
        $archivo = $nombre_archivo . $extension;

        Storage::put($nombre_carpeta . '/' . $archivo, $pdf->output());
        return $pdf->stream($nombre_archivo . $extension);
    }

    public function indexReportMaintenance(Request $request)
    {
        $user_id = Auth::id();
        $serial_number = $request->get('search');

        $campu_users = Campu::leftJoin('campu_users as cu', 'cu.campu_id', 'campus.id')
            ->leftJoin('users as u', 'u.id', 'cu.user_id')
            ->leftJoin('devices as d', 'd.campu_id', 'campus.id')
            ->leftJoin('reports as r', 'r.device_id', 'd.id')
            ->select(
                'cu.campu_id',
                'campus.name',
            )
            ->where('cu.user_id', $user_id)
            ->where('r.report_name_id', Report::REPORT_MAINTENANCE_NAME_ID,)
            ->distinct('campus.name')
            ->get();

        //return $campu_users;

        $devices = Report::rightJoin('report_maintenances as rm', 'rm.report_id', 'reports.id')
            ->rightJoin('devices as d', 'd.id', 'reports.device_id')
            ->rightJoin('type_devices as td', 'td.id', 'd.type_device_id')
            ->rightJoin('campus as c', 'c.id', 'd.campu_id')
            ->rightJoin('campu_users as cu', 'cu.campu_id', 'd.campu_id')
            ->rightJoin('calendar_maintenances as cm', 'cm.campu_id', 'c.id')
            ->rightJoin('users as u', 'u.id', 'cu.user_id')
            ->rightJoin('status as s', 's.id', 'd.statu_id')
            ->select(
                'd.id as device_id',
                'd.inventory_code_number',
                'd.serial_number',
                'd.ip',
                DB::raw("REPLACE(d.mac, '-', ':') as mac"),
                'cu.campu_id',
                'c.name as sede',
                's.name as estado',
                's.id as statu_id',
                'cm.maintenance_01_month as first_semester_month',
                'cm.maintenance_02_month as second_semester_month',
                DB::raw("CASE WHEN rm.report_id IS NULL THEN 0 
                            ELSE 1 
                                END AS mto_flag"),
                DB::raw("CASE WHEN rm.report_id IS NULL THEN 'Pendiente' 
                            ELSE 'Realizado' 
                                END AS mto_statu"),
                DB::raw("MONTHNAME(CONCAT(YEAR(CURRENT_DATE()),'-',cm.maintenance_01_month,'-',DAY(CURRENT_DATE()))) as MesPrimerSemestre"),
                DB::raw("MONTHNAME(CONCAT(YEAR(CURRENT_DATE()),'-',cm.maintenance_02_month,'-',DAY(CURRENT_DATE()))) as MesSegundoSemestre"),
                'rm.maintenance_01_date',
                'reports.id as repo_id',
                'reports.report_code_number',
                'reports.rowguid as report_rowguid',
                'd.rowguid as device_rowguid',
            )
            ->where('cu.user_id', $user_id)
            ->where('d.is_active', true)
            ->whereIn('d.statu_id', [1, 2, 3, 5, 6, 7, 8])
            ->whereIn('td.id', [1, 2, 3, 5]) // excepcion id de los tipos de dispositivos
            ->search($serial_number)
            ->orderByDesc('rm.report_id')
            ->paginate(10);

        //return $devices;

        return view('report.maintenances.index', compact('devices', 'campu_users'));
    }

    public function downloadMtoCampu(Request $request)
    {
        $user_id = Auth::id();
        $campu_id = $request->get('campus');
        //consulta si no existe el id de la sede en la table reportes enviar un modal
        //con la alerta de que no existen reportes para esa sede

        $request->validate([
            'campus' => 'required',
        ]);

        if ($campu_id == 0) {
            $generated_report_maintenance = DB::table('view_report_maintenances')
                ->where('RepoNameID', Report::REPORT_MAINTENANCE_NAME_ID)
                ->where('TecnicoID', $user_id)
                ->get();
        } else {
            $generated_report_maintenance = DB::table('view_report_maintenances')
                ->where('RepoNameID', Report::REPORT_MAINTENANCE_NAME_ID)
                ->where('TecnicoID', $user_id)
                ->where('SedeID', $campu_id)
                ->get();
        }

        //return $generated_report_maintenance;

        $pdf = PDF::loadView(
            'report.maintenances.pdf',
            [
                'generated_report_maintenance' => $generated_report_maintenance,
            ]
        );

        /*         //$tiempo_creacion = now()->toDateString();
        $month_number = now()->isoformat('M');
        if ($month_mto->FechaMto01Realizado == $month_number) {
            $nombre_carpeta = 'pdf/mantenimientos/primer_semestre/' . Str::slug($month_mto->SedeEquipo) . '/';
            $nombre_archivo = $report->report_code_number;
            $extension = '.pdf';
            $archivo = $nombre_archivo . $extension;
            Storage::put($nombre_carpeta . '/' . $archivo, $pdf->output());
        } elseif ($month_mto->FechaMto02Realizado == $month_number) {
            $nombre_carpeta = 'pdf/mantenimientos/segundo_semestre/';
            $nombre_archivo = $report->report_code_number;
            $extension = '.pdf';
            $archivo = $nombre_archivo . $extension;
            Storage::put($nombre_carpeta . '/' . $archivo, $pdf->output());
        } */

        return $pdf->stream(Str::uuid() . '-' . time() . '.pdf');
    }

    public function createReportMaintenance($device_id, $device_rowguid)
    {
        $user_id = Auth::id();
        $device = Device::findOrFail($device_id);

        $count_report = DB::table('devices as d')
            ->leftJoin('campus as c', 'c.id', 'd.campu_id')
            ->leftJoin('calendar_maintenances as cm', 'cm.campu_id', 'c.id')
            ->leftJoin('reports as r', 'r.device_id', 'd.id')
            ->leftJoin('report_names as rn', 'rn.id', 'r.report_name_id')
            ->leftJoin('report_maintenances as rm', 'rm.report_id', 'r.id')
            ->select(
                DB::raw("COUNT(r.device_id) as count_report_mto"),
                //DB::raw("LOWER(c.name) as campu"),
                'rn.id as report_name_id',
                //'rn.name as report_name',
                'r.device_id as device_id',
                'cm.maintenance_01_month as semester_first_month_mto',
                'cm.maintenance_02_month as semester_second_month_mto',
                'rm.maintenance_02_date'
            )
            ->where('d.id', $device->id)
            //->where('r.report_name_id', Report::REPORT_MAINTENANCE_NAME_ID)
            ->groupBy(['rn.id', 'd.id', 'r.device_id', 'cm.maintenance_01_month', 'cm.maintenance_02_month', 'maintenance_02_date'])
            ->first();

        //return $count_report;

        $report_maintenances = DB::table('reports as r')
            ->leftJoin('report_names as rn', 'rn.id', 'r.report_name_id')
            ->leftJoin('report_maintenances as rm', 'rm.report_id', 'r.id')
            ->leftJoin('devices as d', 'd.id', 'r.device_id')
            ->leftJoin('campus as c', 'c.id', 'd.campu_id')
            ->leftJoin('calendar_maintenances as cm', 'cm.campu_id', 'c.id')
            ->select(
                'r.report_code_number',
                'r.id as repo_id',
                'r.rowguid as report_rowguid',
                'd.rowguid as device_rowguid',
                DB::raw("UPPER(rn.name) repo_name"),
                'd.serial_number as serial_number',
                'c.name as campu',
                DB::raw("DATE_FORMAT(r.created_at, '%c/%e/%Y - %r') as date_created"),
                DB::raw("DATE_FORMAT(rm.maintenance_01_date, '%c') as FechaMto01Realizado"),
                DB::raw("DATE_FORMAT(rm.maintenance_02_date, '%c') as FechaMto02Realizado"),
                'cm.maintenance_02_month',
                'rm.maintenance_02_date'
            )
            ->where('r.user_id', $user_id)
            ->where('r.device_id', $device->id)
            ->where('r.report_name_id', Report::REPORT_MAINTENANCE_NAME_ID)
            ->orderByDesc('r.created_at')
            ->take(1)
            ->get();

        $data = [
            'device' => $device,
            'report_maintenances' => $report_maintenances,
            'count_report' => $count_report,
        ];

        return view('report.maintenances.create')->with($data);
    }

    public function storeReportMaintenance(Request $request)
    {
        $user_id = Auth::id();
        $device_id = $request->device_id;
        $campu_id = $request->campu_id;
        $description = $request->description;

        $found_campu_calendar_mto_id = Device::where('devices.id', $device_id)
            ->leftJoin('calendar_maintenances', 'calendar_maintenances.campu_id', 'devices.campu_id')
            ->where('devices.campu_id', $campu_id)
            ->select(
                'devices.serial_number',
                'calendar_maintenances.id as CalendarMtoID',
                'calendar_maintenances.maintenance_01_month',
                'calendar_maintenances.maintenance_02_month'
            )->first();

        $month_number = now()->isoformat('M');

        $rules = [
            'description' => 'required',
        ];

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
            if ($found_campu_calendar_mto_id->maintenance_01_month == $month_number) {
                $this->report->report_code_number = $this->generatorID;
                $this->report->report_name_id = Report::REPORT_MAINTENANCE_NAME_ID;
                $this->report->device_id = $device_id;
                $this->report->user_id = $user_id;
                $this->report->rowguid = Uuid::uuid();
                $this->report->created_at = now('America/Bogota');

                $this->report->save();

                $this->report_maintenance->report_id = $this->report->id;
                $this->report_maintenance->maintenance_01_date = now('America/Bogota');
                $this->report_maintenance->maintenance_01_observation = $description;
                $this->report_maintenance->calendar_maintenance_id = $found_campu_calendar_mto_id->CalendarMtoID;

                $this->report_maintenance->save();
            } elseif ($found_campu_calendar_mto_id->maintenance_02_month == $month_number) {
                $last_report_mto = Report::where('reports.device_id', $device_id)
                    ->where('user_id', $user_id)
                    ->where('reports.report_name_id', Report::REPORT_MAINTENANCE_NAME_ID)
                    ->orderByDesc('reports.created_at')
                    ->first();

                if (empty($last_report_mto->id)) {
                    return redirect()->route('inventory.error', 404);
                }

                $update = array('maintenance_02_date' => now('America/Bogota'), 'maintenance_02_observation' => $description);
                DB::table('report_maintenances')
                    ->where('report_id', $last_report_mto->id)
                    ->update($update);
            } else {
                return redirect()->route('inventory.error', 404);
            }

            //return response()->json(array('success' => true, $this->report, 'report', 'report_maintenances' =>  $this->report_maintenance, 'last_insert_id' => $this->report_maintenance->report_id), 200);

            return back()->withErrors($validator)
                ->with('report_created', '');
        endif;
    }

    public function reportMaintenanceGenerated($report_id, $uuid)
    {
        $report = Report::findOrFail($report_id);
        $user_id = Auth::id();

        $month_mto = DB::table('view_report_maintenances')
            ->where('RepoID', $report->id)
            ->where('TecnicoID', $user_id)
            ->orderByDesc('FechaCreacionReporte')
            ->select(
                DB::raw("DATE_FORMAT(FechaMto01Realizado, '%c') as FechaMto01Realizado"),
                DB::raw("DATE_FORMAT(FechaMto02Realizado, '%c') as FechaMto02Realizado"),
                'SedeEquipo',
            )->first();

        $generated_report_maintenance = DB::table('view_report_maintenances')
            ->where('RepoID', $report->id)
            ->where('TecnicoID', $user_id)
            ->orderByDesc('FechaCreacionReporte')
            ->get();

        $pdf = PDF::loadView(
            'report.maintenances.pdf',
            [
                'report' => $report,
                'generated_report_maintenance' => $generated_report_maintenance,
            ]
        );

        //$tiempo_creacion = now()->toDateString();
        $month_number = now()->isoformat('M');
        if ($month_mto->FechaMto01Realizado == $month_number) {
            $nombre_carpeta = 'pdf/mantenimientos/primer-semestre/' . Str::slug($month_mto->SedeEquipo) . '/';
            $nombre_archivo = $report->report_code_number;
            $extension = '.pdf';
            $archivo = $nombre_archivo . $extension;
            Storage::put($nombre_carpeta . '/' . $archivo, $pdf->output());
        }
        if ($month_mto->FechaMto02Realizado == $month_number) {
            $nombre_carpeta = 'pdf/mantenimientos/segundo-semestre/' . Str::slug($month_mto->SedeEquipo) . '/';
            $nombre_archivo = $report->report_code_number;
            $extension = '.pdf';
            $archivo = $nombre_archivo . $extension;
            Storage::put($nombre_carpeta . '/' . $archivo, $pdf->output());
        }

        return $pdf->stream($report->report_code_number . '.pdf');
    }

    public function indexReportDelivery(Request $request)
    {
        $user_id = Auth::id();
        $serialNumber = $request->get('search');

        $devices = Device::leftJoin('campus as c', 'c.id', 'devices.campu_id')
            ->leftJoin('campu_users as cu', 'cu.campu_id', 'devices.campu_id')
            ->leftJoin('users as u', 'u.id', 'cu.user_id')
            ->leftJoin('status as s', 's.id', 'devices.statu_id')
            ->select(
                'devices.inventory_code_number',
                'devices.serial_number',
                'devices.ip',
                'devices.mac',
                'cu.campu_id',
                'c.name as sede',
                's.name as estado',
                's.id as statu_id',
                'devices.rowguid',
                'devices.id as device_id'
            )
            ->where('cu.user_id', $user_id)
            ->where('devices.is_active', true)
            ->whereIn('devices.statu_id', [1, 2, 3, 5, 6, 7, 8])
            ->search($serialNumber)
            ->orderByDesc('devices.created_at')
            ->paginate(10);

        //return response()->json($devices);

        return view('report.delivery.index', compact('devices'));
    }

    public function createReportDelivery($device_id, $rowguid)
    {
        $user_id = Auth::id();

        $device = Device::findOrFail($device_id);

        //return $device;

        $reportDeliveries = DB::table('reports as r')
            ->leftJoin('report_deliveries as rd', 'rd.report_id', 'r.id')
            ->leftJoin('report_names as rn', 'rn.id', 'r.report_name_id')
            //->leftJoin('file_upload_reports as fpu', 'fpu.report_id', 'r.id')
            ->leftJoin('devices as d', 'd.id', 'r.device_id')
            ->leftJoin('campus as c', 'c.id', 'd.campu_id')
            ->select(
                DB::raw("COUNT(rd.report_id) as count_report"),
                DB::raw("CASE WHEN rn.name='acta de entrega' THEN UPPER(rn.name)
                            ELSE rn.name
                                END AS report_name"),
                DB::raw("UPPER(CONCAT(rd.name, ' ', rd.last_name)) as custodian_name"),
                'r.report_code_number',
                'r.id as repo_id',
                'd.id as id_device',
                'd.serial_number as serial_number',
                DB::raw("DATE_FORMAT(r.created_at, '%c/%e/%Y - %r') date_created"),
                'r.rowguid',
                'c.name as campu',
                'c.slug as campu_slug',
                //'rd.is_borrowed',
                //'fpu.file_name',
                //'fpu.file_path'
            )
            //->where('r.user_id', $user_id)
            ->where('r.device_id', $device->id)
            ->whereRaw('rn.name = "acta de entrega"')
            ->groupBy('id_device', 'report_name', 'rd.name', 'rd.last_name', 'report_code_number', 'repo_id', 'rowguid', 'serial_number', 'date_created', 'campu', 'campu_slug', 'file_name', 'file_path')
            ->orderByDesc('r.created_at')
            ->get();

        //return $reportDeliveries;

        $fileUploadReports = DB::table('file_upload_reports as fpu')
            ->leftJoin('report_deliveries as rd', 'rd.report_id', 'fpu.report_id')
            ->leftJoin('reports as r', 'r.id', 'rd.report_id')
            ->leftJoin('devices as d', 'd.id', 'r.device_id')
            ->leftJoin('report_names as rn', 'rn.id', 'r.report_name_id')
            ->select(
                //DB::raw("COUNT(rd.report_id) as count_report"),
                DB::raw("CASE WHEN rn.name='acta de entrega' THEN UPPER(rn.name)
                            ELSE rn.name
                                END AS report_name"),
                DB::raw("UPPER(CONCAT(rd.name, ' ', rd.last_name)) as custodian_name"),
                'r.report_code_number',
                'r.id as repo_id',
                'd.id as id_device',
                'd.serial_number as serial_number',
                DB::raw("DATE_FORMAT(r.created_at, '%c/%e/%Y - %r') date_created"),
                'fpu.file_name',
                'fpu.file_path',
                DB::raw("DATE_FORMAT(fpu.upload_date, '%c/%e/%Y - %r') upload_date"),
            )
            //->where('r.user_id', $user_id)
            ->where('r.device_id', $device->id)
            //->whereRaw('rn.name = "acta de entrega"')
            //->groupBy('id_device', 'report_name', 'report_code_number', 'repo_id', 'serial_number', 'date_created', 'campu', 'file_name', 'file_path', 'upload_date')
            ->orderByDesc('fpu.upload_date')
            ->get();

        //return $fileUploadReports;

        $data = [
            'device' => $device,
            'reportDeliveries' => $reportDeliveries,
            'fileUploadReports' => $fileUploadReports,
        ];

        return view('report.delivery.show')->with($data);
    }

    public function storeReportDelivery(Request $request)
    {
        $user_id = Auth::id();
        $device_id = $request->device_id;

        $rules = [
            'name' => 'required',
            'last_name' => 'required',
            //'second_last_name' => 'required',
            'position' => 'required',
            'keyboard' => 'required_with:serial_keyboard,filled',
            'serial_keyboard' => 'required_with:keyboard,filled',
            'mouse' => 'required_with:serial_mouse',
            'serial_mouse' => 'required_with:mouse',
            'power_charger' => 'required_with:serial_power_charger',
            'serial_power_charger' => 'required_with:power_charger'
        ];

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
                "CALL SP_insertReportDelivery (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", //18
                [
                    $this->report->report_code_number = $this->generatorID,
                    $this->report->report_name_id = Report::REPORT_DELIVERY_NAME_ID,
                    $this->report->device_id = $device_id,
                    $this->report->user_id = $user_id,
                    $this->report->rowguid = Uuid::uuid(),
                    $this->report->created_at = now('America/Bogota'),

                    $this->report_delivery->name = $request->name,
                    $this->report_delivery->middle_name = $request->middle_name,
                    $this->report_delivery->last_name = $request->last_name,
                    $this->report_delivery->second_last_name = $request->second_last_name,
                    $this->report_delivery->position = $request->position,
                    //$this->report_delivery->is_borrowed = $request->has('is_borrowed'),
                    $this->report_delivery->has_wifi = $request->has('wifi'),
                    $this->report_delivery->has_keyboard = $request->has('keyboard'),
                    $this->report_delivery->has_mouse = $request->has('mouse'),
                    $this->report_delivery->has_cover = $request->has('cover'),
                    $this->report_delivery->has_briefcase = $request->has('briefcase'),
                    $this->report_delivery->has_power_charger = $request->has('power_charger'),
                    $this->report_delivery->has_padlock = $request->has('padlock'),
                    $this->report_delivery->serial_keyboard = $request->serial_keyboard,
                    $this->report_delivery->serial_mouse = $request->serial_mouse,
                    $this->report_delivery->serial_power_charger = $request->serial_power_charger,
                    $this->report_delivery->other_accesories = $request->other_accesories,
                ]
            );
            DB::commit();
            return back()->withErrors($validator)
                ->with('report_created', 'Reporte ' . $this->report->report_code_number . '');
            try {
            } catch (\Throwable $e) {
                DB::rollback();
                return back()->with('info_error', '');
                throw $e;
            }
        endif;
    }

    public function reportDeliveryGenerated($id, $uuid)
    {
        $report = Report::findOrFail($id);

        $campu = Report::leftJoin('devices as d', 'd.id', 'reports.device_id')
            ->leftJoin('campus as c', 'c.id', 'd.campu_id')
            ->select('c.slug')
            ->findOrFail($id);

        $userId = Auth::id();

        $reportDelivery = DB::table('view_report_deliveries')
            ->where('RepoID', $report->id)
            ->where('TecnicoID', $userId)
            ->get();

        //return $reportDelivery;

        $pdf = PDF::loadView(
            'report.delivery.pdf',
            [
                'reportDelivery' => $reportDelivery,
            ]
        );

        //$tiempo_creacion = now()->toDateString();
        $nombre_carpeta = 'pdf/acta_de_entrega/' . $campu->slug . '/';
        //$nombre_archivo = Hash::make($report->report_code_number);
        $nombre_archivo = $report->report_code_number;
        $extension = '.pdf';
        $archivo = $nombre_archivo . $extension;

        //$data = array('report_id' => $report->id, 'file_name' => $nombre_archivo . '.pdf', 'file_path' => $nombre_carpeta, 'upload_date' => now('America/Bogota'));
        //DB::table('file_upload_reports')->insert($data);

        Storage::put($nombre_carpeta . '/' . $archivo, $pdf->output());

        return $pdf->stream($nombre_archivo . $extension);
    }

    public function uploadFileReportDeliverySigned(Request $req, $report_id, $deviceId)
    {
        $repo_id = Report::findOrFail($report_id);

        $IdDevice = Device::findOrFail($deviceId);

        $repo = Report::select(
            'reports.id as repo_id',
            'reports.report_code_number',
            'd.serial_number',
            'c.name as campu',
            'reports.rowguid'
        )
            ->leftJoin('report_deliveries as rd', 'rd.report_id', 'reports.id')
            ->leftJoin('devices as d', 'd.id', 'reports.device_id')
            ->leftJoin('campus as c', 'c.id', 'd.campu_id')
            ->leftJoin('campu_users as cu', 'cu.campu_id', 'c.id')
            ->leftJoin('users as u', 'u.id', 'cu.user_id')
            ->where('reports.device_id', $IdDevice->id)
            ->where('cu.user_id', Auth::id())
            //->where('reports.id', $repoId->id)
            ->orderByDesc('reports.created_at')
            ->first();

        //return $repo;

        $req->validate([
            'file_upload' => 'required|mimes:jpg,png,pdf|max:2048'
        ]);

        if ($req->file()) {
            $campu_slug = Str::slug($repo->campu);
            //$FileExt = $req->file_upload->getClientOriginalExtension();
            $fileName = $req->file_upload->hashName();
            //$fileName = $fake->uuid($req->file_upload->getClientOriginalName());
            $filePath = $req->file('file_upload')->storeAs('pdf/acta_de_entrega_firmados/' . $campu_slug, $fileName, 'public');

            $data = array('report_id' => $repo->repo_id, 'file_name' => $fileName, 'file_path' => $filePath, 'upload_date' => now('America/Bogota'));
            DB::table('file_upload_reports')->insert($data);

            return back()
                ->with('upload_success', '')
                ->with('file', $fileName);
        }
    }

    public function pdfReportResumes(Request $request, $id)
    {
        //$exists = Storage::disk('public')->exists("REPO000000000018.pdf");
        //return response()->json($exists);

        $report = Report::findOrFail($id);
        //return response()->json($report);

        $nombre_carpeta = $report->report_code_number;
        //return response()->json($nombre_carpeta);

        /*if (Storage::disk('public')->exists("/$request->file")) {
            $path = Storage::disk('public')->path("/$request->file");
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type' => mime_content_type($path)
            ]);
        }
        return redirect('/404');*/

        //dd($report->id);
        //eturn response()->download('./storage/app/public/' . $report->report_code_number . '.pdf');
        if (Storage::disk('public')->exists($report->report_code_number . '.pdf')) {
            return Storage::download('public/' . $report->report_code_number . '.pdf');
        }
        return view('admin.op_error_400');
    }

    public function indexSign()
    {
        $user_id = User::where('id', Auth::id())->pluck('id');

        $campu_administrators = DB::table('campus as c')
            ->leftJoin('campu_users as cu', 'cu.campu_id', 'c.id')
            ->leftJoin('users as u', 'u.id', 'cu.user_id')
            ->where('cu.user_id', $user_id)
            ->select(
                'cu.campu_id as SedeID',
                'c.name as NombreSede',
                'c.abreviature as AbreviadoSede',
                'c.slug',
                'c.address as DireccionSede',
                'c.phone as TelefonoSede',
                DB::raw("CONCAT(c.admin_name,' ',c.admin_last_name) AS NombreApellidoAdmin"),
                'c.admin_sign as FirmaAdmin'
            )->get();

        //return $campu_administrators;

        return view('report.signs.index', compact('campu_administrators'));
    }

    public function editSign($id, $slug)
    {
        $campu_administrators = Campu::findOrFail($id);

        return view('report.signs.edit', compact('campu_administrators'));
    }

    public function updateSign(Request $request, $id)
    {
        $campu_admin_id = Campu::where('id', $id)->pluck('id');

        $request->validate([
            'admin_name' => 'required',
            'admin_last_name' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'sign' => 'image',
        ]);

        $address         = $request->get('address');
        $phone           = $request->get('phone');
        $admin_name      = $request->get('admin_name');
        $admin_last_name = $request->get('admin_last_name');

        if ($validator->fails()) {

            return back()->with('fail_upload_sign', '');
        } else if ($request->hasFile('sign')) {

            /*             $admin_sign = Campu::select('admin_sign')->where('id', $campu_admin_id)->pluck('admin_sign');

            Storage::delete($admin_sign);

            if (Storage::exists('firma_administradores/' . $admin_sign)) {
                Storage::delete('firma_administradores/' . $admin_sign);
            } else {
                dd('File does not exists.');
            } */
            $admin = Campu::where('id', $campu_admin_id)
                ->select('slug', DB::raw("CONCAT(admin_name,' ',admin_last_name) AS NombreApellidoAdmin"))
                ->first();

            $file_sign = $request->file('sign')->store('firma_administradores/' . $admin->slug . '/' . Str::slug($admin->NombreApellidoAdmin));

            $update = array(
                'address'         => $address,
                'phone'           => $phone,
                'admin_name'      => $admin_name,
                'admin_last_name' => $admin_last_name,
                'admin_sign'      => $file_sign
            );

            Campu::where('id', $campu_admin_id)->update($update);
        }

        return redirect()->route('sign.index')->with('success_upload_sign', '');
    }
}
