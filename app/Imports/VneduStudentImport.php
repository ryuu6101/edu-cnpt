<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class VneduStudentImport implements ToCollection, WithMultipleSheets
{
    public $class;
    public $students = [];
    public $vnedu_students = [];
    public $student_diff = [];
    public $ErrorMessage = '';

    public function __construct($class) {
        $this->class = $class;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $this->students = $this->class->students->pluck('fullname')->toArray();

        $student_codes = [];
        for ($stt = 7; true; $stt++) {
            $row = $collection[$stt];
            if (!is_numeric($row[0])) break;

            $student_code = trim($row[1]);
            $student_name = trim($row[2]).' '.trim($row[3]);

            $this->vnedu_students[] = $student_name;
            $student_codes[$student_name] = $student_code;
        }

        // dd(array_diff($this->students, $this->vnedu_students));
        if (($this->student_diff = array_diff($this->students, $this->vnedu_students)) != []) {
            $this->ErrorMessage = "Danh sách học sinh không đồng nhất";
            return;
        }

        foreach ($this->class->students as $key => $student) {
            $student->update(['student_code' => $student_codes[$student->fullname]]);
        }
    }

    public function sheets(): array
    {
        return [0 => $this];
    }
}
