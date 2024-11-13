<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RecordSheetExport implements FromArray, WithTitle, WithEvents
{
    protected $vnedu_file;
    protected $sheet;

    public function __construct($vnedu_file, $sheet) {
        $this->vnedu_file = $vnedu_file;
        $this->sheet = $sheet;
    }

    public function array(): array
    {
        $class = $this->vnedu_file->class;
        $semester = $this->vnedu_file->semester;
        $vnedu_subject = $this->sheet->vnedu_subject;
        
        $heading_arr = [
            [mb_strtoupper($class->school->department->name, 'UTF-8')],
            [mb_strtoupper($class->school->name, 'UTF-8')],
            [mb_strtoupper("Bảng điểm chi tiết - Môn {$vnedu_subject->name} - {$semester->semester} - Năm học {$semester->school_year}", 'UTF-8')],
            ["Khối {$class->grade} - Lớp ".str_replace('_', '/', $class->name)],
            [''],
            ['STT', 'Mã học sinh', 'Họ và tên', '', 'ĐĐGtx', '', '', '', '', 'ĐĐGgk', 'ĐĐGck', 'ĐTBmhk', 'Nhận xét'],
            ['', '', '', '', 'TX1', 'TX2', 'TX3', 'TX4', 'TX5'],
        ];

        $record_arr = [];
        $stt = 1;
        $list_records = $semester->records->where('class_id', $class->id)->where('subject_id', $vnedu_subject->subject->id ?? 0);
        if ($list_records->count() > 0) {
            foreach ($list_records as $key => $record) {
                if (!$record->student) continue;
                $student_name = $record->student->fullname;
                $student_code = $record->student->student_code;
                $splited_name = get_first_and_last_name($student_name);
    
                $record_arr[] = [
                    $stt++,
                    $student_code,
                    $splited_name['first'], 
                    $splited_name['last'],
                    $record->tx1,
                    $record->tx2,
                    $record->tx3,
                    $record->tx4,
                    $record->tx5,
                    $record->ddggk,
                    $record->ddgck,
                ];
            }
        } else {
            $list_students = $class->students;
            foreach ($list_students as $key => $student) {
                $student_name = $student->fullname;
                $student_code = $student->student_code;
                $splited_name = get_first_and_last_name($student_name);
    
                $record_arr[] = [
                    $stt++,
                    $student_code,
                    $splited_name['first'], 
                    $splited_name['last'],
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                ];
            }
        }

        return array_merge($heading_arr, $record_arr);
    }

    public function title(): string {
        return $this->sheet->sheet_name;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $last_row = $sheet->getHighestRow();

                $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
                $sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);
                $sheet->mergeCells('A1:L1');
                $sheet->mergeCells('A2:L2');
                $sheet->mergeCells('A3:L3');
                $sheet->mergeCells('A4:J4');
                $sheet->mergeCells('A6:A7');
                $sheet->mergeCells('B6:B7');
                $sheet->mergeCells('C6:D7');
                $sheet->mergeCells('E6:I6');
                $sheet->mergeCells('J6:J7');
                $sheet->mergeCells('K6:K7');
                $sheet->mergeCells('L6:L7');
                $sheet->mergeCells('M6:M7');
                $sheet->getStyle('A3:A4')->getFont()->setBold(true);
                $sheet->getStyle('A6:M6')->getFont()->setBold(true);
                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(12);
                $sheet->getColumnDimension('C')->setWidth(22);
                $sheet->getColumnDimension('D')->setWidth(8);
                $sheet->getColumnDimension('M')->setWidth(13);
                $sheet->getRowDimension('1')->setRowHeight(17.25);
                $sheet->getRowDimension('2')->setRowHeight(17.25);
                $sheet->getRowDimension('3')->setRowHeight(20);
                $sheet->getRowDimension('6')->setRowHeight(30);
                $sheet->getStyle('A1:A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A6:M7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A8:B'.$last_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E8:L'.$last_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:A3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A6:M6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A6:M'.$last_row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B8:D'.$last_row)->getBorders()->getVertical()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
                $sheet->getStyle('E8:I'.$last_row)->getBorders()->getVertical()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
                for ($row = 8; $row < $last_row; $row+=5) {
                    $end_row = ($row + 4) < $last_row ? ($row + 4) : $last_row;
                    $sheet->getStyle("A{$row}:M{$end_row}")->getBorders()->getHorizontal()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
                }

                $sheet->getStyle('A1');
                $sheet->getParent()->setActiveSheetIndex(0);
            },
        ];
    }
}
