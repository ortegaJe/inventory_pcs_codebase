<?php

namespace App\Exports;

use App\Models\Computer;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ComputersExport implements FromCollection, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    private $fileName = "computers.xlsx";

    public function collection()
    {
        $pcs = DB::table('view_exports_all_pcs')->orderByDesc('FechaCreacion')->get();

        return $pcs;
    }
}
