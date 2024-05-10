<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campu;
use App\Models\Report;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MaintenanceController extends Controller
{
    public function getCampusMto()
    {
        $userID = Auth::user()->id;

        $data = [];

        $campus = Campu::join('campu_users as b', 'b.campu_id', 'campus.id')
        ->where('b.user_id', $userID)
            ->where('campus.is_active', true)
                ->get(['campus.name', 'campus.id']);

                    $data['campus'] = $campus;

        $years = Campu::join('campu_users as b', 'b.campu_id', 'campus.id')
        ->join('users as c', 'c.id', 'b.user_id')
            ->join('reports as d', 'd.user_id', 'c.id')
                ->join('report_maintenances as e', 'e.report_id', 'd.id')
                    ->where('c.id', $userID)
                        ->where('campus.is_active', true)
                            ->select(DB::raw("YEAR(e.maintenance_01_date) as year"))
                                ->groupBy('year')
                                    ->get(['year']);

                    $data['years'] = $years;

        if ($campus->isEmpty()) 
        {
            return response()->json(['message' => 'No se encontraron registros para esta sede'], 404);
        }

        return response()->json($data);
    }

    public function downloadPdf(Request $request)
{
    $userID = Auth::user()->id;
    $campus = $request->post('campus');
    $year = $request->post('year');

    // Retrieve the Blob data from the database
    $document = DB::table('view_report_maintenances')
    ->where('RepoNameID', Report::REPORT_MAINTENANCE_NAME_ID)
    ->where('TecnicoID', $userID)
    ->where('SedeID', $campus)
    ->whereYear('FechaMto01Realizado', $year)
    ->orderBy('FechaMto01Realizado')
    ->get();

    // Load the Blob data into Dompdf
    $pdf = PDF::loadView('report.maintenances.pdf', ['document' => $document]);

    // Render the PDF
    //$pdf->render();

    // Generate a unique filename for the PDF file
    $filename = uniqid() . '.pdf';

    // Store the PDF file in the storage directory
    Storage::disk('public')->put($filename, $pdf->output());

    // Return the PDF file as a downloadable response
    return response()->download(storage_path('app/public/' . $filename));
}

    public function downloadMto(Request $request)
    {
        $userID = Auth::user()->id;
        $campus = $request->post('campus');
        $year = $request->post('year');

        //error_log(__LINE__ . __METHOD__ . ' sede, año --->' . var_export($campus,$year, true));

        $mto = [];
        
        $mto = DB::table('view_report_maintenances')
                ->where('RepoNameID', Report::REPORT_MAINTENANCE_NAME_ID)
                ->where('TecnicoID', $userID)
                ->where('SedeID', $campus)
                ->whereYear('FechaMto01Realizado', $year)
                ->orderBy('FechaMto01Realizado')
                ->get();

        //error_log(__LINE__ . __METHOD__ . ' result --->' . var_export($mto, true));

        //return response()->json($mto);

         if ($mto->isEmpty()) 
         {
            return response()->json(['message' => 'No se encontró información de mantenimientos para esta sede'], 404);
         }
         
             $pdf = PDF::loadView(
                 'report.maintenances.pdf',
                 [
                     'mto' => $mto,
                 ]
             );

        return $pdf->download('mto.pdf');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
