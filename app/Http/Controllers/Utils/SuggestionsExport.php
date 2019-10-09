<?php

namespace App\Http\Controllers\Utils;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;
use App\Job;

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

Sheet::macro('setWidth', function (Sheet $sheet, string $column, int $width) {
    $sheet->getDelegate()->getColumnDimension($column)->setWidth($width);
});

Sheet::macro('setHeight', function (Sheet $sheet, string $row, int $height) {
    $sheet->getDelegate()->getRowDimension($row)->setRowHeight($height);
});

class SuggestionsExport implements FromCollection, Responsable, WithMapping, WithEvents, WithTitle
{
    use Exportable;

    private $job;

    public function __construct($id){
        $this->job = Job::findOrFail($id);
    }

    public function collection()
    {
        return $this->job->suggestions;
    }

    public function title(): string
    {
        return 'Job Suggestions';
    }

    public function map($suggestion): array
    {
        return [
            $suggestion->profile()->user->name,
            $suggestion->profile()->user->username,
            $suggestion->profile()->user->email,
            $suggestion->profile()->user->getPhoneNumber(),
            $suggestion->profile()->user->gender,
            $suggestion->profile()->user->getCountry() . ', ' . $suggestion->profile()->user->town,
            ($suggestion->profile()->user->data != null) ? $suggestion->profile()->user->data->linked_in : "-",
            ($suggestion->profile()->user->data != null) ? $suggestion->profile()->user->data->github : "-",
            $suggestion->profile()->cv_document
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class  => function(BeforeSheet $event) {
                $event->sheet->append(["JOB SUGGESTIONS"]);
                $event->sheet->append(["NAME", "USERNAME", "EMAIL", "PHONE NUMBER", "GENDER", "LOCATION", "LINKED IN", "GITHUB", "CV"]);
            },
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->styleCells(
                    'A1:I1',
                    [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '00000000'],
                            ],
                        ],
                        'font' => array(
                            'name'      =>  'Century Gothic',
                            'size'      =>  17,
                            'bold'      =>  true
                        ),
                        'alignment' => [
                            'horizontal'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'textRotation' => 0,
                            'wrapText'     => TRUE,
                            'indent'       => 2
                        ]
                    ]
                );
                $event->sheet->styleCells(
                    'A2:I2',
                    [
                        'font' => array(
                            'name'      =>  'Century Gothic',
                            'size'      =>  12,
                            'bold'      =>  true
                        ),
                        'alignment' => [
                            'horizontal'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'textRotation' => 0
                        ]
                    ]
                );
                $event->sheet->styleCells(
                    'A3:I200',
                    [
                        'font' => array(
                            'name'      =>  'Century Gothic',
                            'size'      =>  11
                        ),
                        'alignment' => [
                            'horizontal'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                            'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'textRotation' => 0,
                        ]
                    ]
                );
                $event->sheet->setWidth('A', 23);
                $event->sheet->setWidth('B', 17);
                $event->sheet->setWidth('C', 31);
                $event->sheet->setWidth('D', 31);
                $event->sheet->setWidth('E', 16);
                $event->sheet->setWidth('F', 34);
                $event->sheet->setWidth('G', 35);
                $event->sheet->setWidth('H', 35);
                $event->sheet->setWidth('I', 34);
                $event->sheet->setHeight('1', 60);
                $event->sheet->setHeight('2', 27);
            },
        ];
    }
}