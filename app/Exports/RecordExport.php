<?php

namespace App\Exports;

use App\Models\Semester;
use App\Models\ClassRoom;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RecordExport implements WithMultipleSheets
{
    protected $vnedu_file;

    public function __construct($vnedu_file) {
        $this->vnedu_file = $vnedu_file;
    }

    public function sheets():array {
        $sheets = [];

        $semester = $this->vnedu_file->semester;
        $vnedu_sheets = $this->vnedu_file->vnedu_sheets->sortBy('sheet_index');
        foreach ($vnedu_sheets as $key => $sheet) {
            if (!isset($sheet->vnedu_subject->subject->id)) continue;
            $sheets[] = new RecordSheetExport($this->vnedu_file->class_id, $semester->id, $sheet->vnedu_subject->subject->id, $sheet->sheet_name);
        }

        return $sheets;
    }
}
