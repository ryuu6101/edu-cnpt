<?php

namespace App\Exports;

use App\Models\Semester;
use App\Models\ClassRoom;
use App\Models\VneduFile;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RecordExport implements WithMultipleSheets
{
    protected $vnedu_file;

    public function __construct($vnedu_file) {
        $this->vnedu_file = $vnedu_file;
    }

    public function sheets():array {
        $sheets = [];

        $vnedu_sheets = $this->vnedu_file->vnedu_sheets->sortBy('sheet_index');
        foreach ($vnedu_sheets as $key => $sheet) {
            $sheets[] = new RecordSheetExport($this->vnedu_file, $sheet);
        }

        return $sheets;
    }
}
