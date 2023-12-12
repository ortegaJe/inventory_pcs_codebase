<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class AllCampuByRegionalExport implements 
    FromCollection,
    ShouldAutoSize,
    //ShouldAutoSize,
    WithColumnWidths,
    WithHeadings,
    WithEvents,
    WithCustomStartCell
{
    use Exportable;

    private $dataCollection;

    public function collection()
    {
        $export = DB::table('regional')
                    ->select(DB::raw('@rownum := @rownum + 1 AS RowNumber'), // Columna de conteo incremental
                    'regional.name as regional_name',
                    'campus.abreviature',
                    'campus.name',
                    'campus.address',
                    'campus.phone',
                    DB::raw('UPPER(CONCAT(campus.admin_name," ", campus.admin_last_name)) as admin'),
                    DB::raw('UPPER(CONCAT(users.name," ", users.last_name)) as tec'),
                    'users.phone_number',
                    'campus.created_at',
                    'campus.is_active'
                    )
                    ->crossJoin(DB::raw('(SELECT @rownum := 0) AS rownum')) // Inicializa la variable de conteo
                    ->leftJoin('campus', 'campus.regional_id', 'regional.id')
                    ->leftJoin('campu_users', 'campu_users.campu_id', 'campus.id')
                    ->leftJoin('users', 'users.id', 'campu_users.user_id')
                    //->where('campus.regional_id', $this->RegionalId)
                    //->orderBy('RowNumber', 'asc')
                    ->get();

                    $this->dataCollection = $export; // Almacena la colección de datos en la propiedad
        
                    return $export;
    }

    public function headings(): array
    {
        return [
            '#',
            'REGIONAL',
            'ABREVIATURA',
            'NOMBRE',
            'DIRECCIÓN',
            'TELEFONOS',
            'ADMINISTRADOR DE SEDE',
            'TÉCNICO EN SISTEMAS ASIGNADO',
            'CELULAR',
            'FECHA DE CREACIÓN',
            'ACTIVO',
        ];
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $rowCount = $this->dataCollection->count(); // Obtener el número de registros
                $endRow = 4 + $rowCount; // Calcular la última fila
                $event->sheet->getStyle('A1:AA'.$endRow)->getFont()->setName('Nunito');
                $event->sheet->insertNewColumnBefore('A', 1);
                $event->sheet->getRowDimension('2')->setRowHeight(30);
                $event->sheet->getRowDimension('3')->setRowHeight(25);
                $event->sheet->setAutoFilter('B3:J3');
                $event->sheet->mergeCells('B1:C1');
                $event->sheet->getCell('B1')->setValue("Generado: ");
                $event->sheet->mergeCells('D1:AA1');
                $time = Carbon::now('America/Bogota')->format('d/m/Y h:i A');
                $event->sheet->setCellValue('D1', ($time));
                $event->sheet->getStyle('D1')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
                $event->sheet->getStyle('J3')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
                $event->sheet->mergeCells('B2:AA2');
                $event->sheet->getStyle('B2:AA2')
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
                $event->sheet->getCell('B2')->setValue("INVENTARIO DE SEDES POR REGIONAL REGISTRADAS");
                $event->sheet->getStyle('B2:AA2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 18,
                    ],
                ]);
                $event->sheet->getStyle('B3:L3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 10,
                        "color" => ["rgb" => "FFFFFF"]
                    ],
                    "fill" => [
                        "fillType" => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        "startColor" => ["rgb" => "636E72"]
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '#7f8c8d'],
                        ],
                    ]
                ]);
                $event->sheet->getStyle('B4:L'.$endRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '#7f8c8d'],
                        ],
                    ],
                    'font' => [
                        'size' => 9,
                    ],
                ]);
            }
        ];
    }
}
