<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class MiTablaExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $arregloDatos;

    public function __construct(array $arregloDatos)
    {
        $this->arregloDatos = $arregloDatos;
    }

    public function array(): array
    {
        return $this->arregloDatos;
    }

    public function headings(): array
    {
        // Encabezados de tu hoja de Excel
        return [
            'Día', 'Nombre de Asignatura', 'Grupo', 'Alumnos', 'Aula', 'Plan de Estudios', 'Hora', 'Asistencia', 'Observación'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Centrar todas las celdas
                $event->sheet->getStyle('A1:I1000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:I1000')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                // Establecer color de fondo y centrar encabezado
                $event->sheet->getStyle('A1:I1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '000000'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFFF00'], // Color de fondo
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Autoajusta el ancho de las columnas
                $columns = range('A', 'I');
                foreach ($columns as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
