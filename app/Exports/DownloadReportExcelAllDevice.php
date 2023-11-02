<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class DownloadReportExcelAllDevice implements 
        FromCollection,
        ShouldAutoSize,
        WithColumnWidths,
        WithHeadings,
        WithEvents,
        WithCustomStartCell
{
    use Exportable;

    private $dataCollection; // Propiedad para almacenar la colección de datos

    public function __construct(int $userId)
    {
        $this->userId   = $userId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $export = DB::table('view_all_devices')
                    ->select(DB::raw('@rownum := @rownum + 1 AS RowNumber'), // Columna de conteo incremental
                            'CodigoInventario',
                            'ActivoFijo',
                            'Marca',
                            'Modelo',
                            'Serial',
                            'SerialMonitor',
                            'TipoPc',
                            'RanuraRamUno',
                            'RanuraRamDos',
                            'PrimerUnidadAlmacenamiento',
                            'SegundaUnidadAlmacenamiento',
                            'Cpu',
                            'Sede',
                            'Ip',
                            'Mac',
                            'NombreDominio',
                            'Os',
                            'Anydesk',
                            'NombreEquipo',
                            'NombreCustodio',
                            'FechaDeAsignacion',
                            'Ubicacion',
                            'Observacion',
                            DB::raw("CASE WHEN EstadoPc = 'STOCK' THEN EstadoPc2 ELSE EstadoPc END AS EstadoPc"),
                            'FechaCreacion',
                        )
                    ->crossJoin(DB::raw('(SELECT @rownum := 0) AS rownum')) // Inicializa la variable de conteo
                    ->where('TecnicoID', $this->userId)
                    ->orderByDesc('FechaCreacion')
                    ->get();

                    $this->dataCollection = $export; // Almacena la colección de datos en la propiedad
        
                    return $export;
    }

    public function headings(): array
    {
        return [
            '#',
            'CODIGO INVENTARIO',
            'ACTIVO FIJO',
            'MARCA',
            'MODELO',
            'SERIAL',
            'SERIAL MONITOR',
            'TIPO',
            'MEMORIA RAM SLOT 01',
            'MEMORIA RAM SLOT 02',
            'DISCO DURO 01',
            'DISCO DURO 02',
            'PROCESADOR',
            'SEDE',
            'IP',
            'MAC',
            'DOMINIO',
            'SISTEMA OPERATIVO',
            'ANYDESK',
            'NOMBRE EQUIPO',
            'CUSTODIO',
            'FECHA DE ASIGNACION',
            'UBICACIÓN',
            'OBSERVACIÓN',
            'ESTADO',
            'FECHA DE CREACIÓN',
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
                $event->sheet->setAutoFilter('B3:AA3');
                $event->sheet->mergeCells('B1:C1');
                $event->sheet->getCell('B1')->setValue("Generado: ");
                $event->sheet->mergeCells('D1:AA1');
                $time = Carbon::now('America/Bogota')->format('d/m/Y h:i A');
                $event->sheet->setCellValue('D1', ($time));
                $event->sheet->getStyle('D1')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
                $event->sheet->mergeCells('B2:AA2');
                $event->sheet->getStyle('B2:AA2')
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
                $event->sheet->getCell('B2')->setValue("INVENTARIO DE EQUIPOS REGISTRADOS SEDE");
                $event->sheet->getStyle('B2:AA2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 18,
                    ],
                ]);
                $event->sheet->getStyle('B3:AA3')->applyFromArray([
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
                $event->sheet->getStyle('B4:AA'.$endRow)->applyFromArray([
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
