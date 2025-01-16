<?php

namespace App\Exports;

use App\Models\Semester;
use App\Models\ClassRoom;
use App\Models\VneduFile;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RecordExport implements WithMultipleSheets
{
    protected $vnedu_file;
    protected $number_of_column;

    public function __construct($vnedu_file, $number_of_column) {
        $this->vnedu_file = $vnedu_file;
        $this->number_of_column = $number_of_column;
    }

    public function sheets():array {
        $sheets = [];

        $vnedu_sheets = $this->vnedu_file->vnedu_sheets->sortBy('sheet_index');
        foreach ($vnedu_sheets as $key => $sheet) {
            $sheets[] = new RecordSheetExport($this->vnedu_file, $sheet, $this->number_of_column);
        }

        return $sheets;
    }
}
