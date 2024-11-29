<?php

namespace App\Imports;

use App\Models\Student;
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
        $student_ids = [];

        for ($stt = 7; true; $stt++) {
            if (!($row = $collection[$stt] ?? false)) break;
            if (!is_numeric($row[0])) break;

            $index = $row[0];
            $student_code = $row[1];
            $student_name = $row[2];

            if (empty($student_name)) continue;

            $deleted_student = Student::onlyTrashed()
                                ->where('class_id', $this->class->id)
                                ->where('student_code', $student_code)->first();
            if ($deleted_student) {
                $student = $deleted_student;
                $student->restore();
                $student->update([
                    'fullname' => $student_name,
                    'index' => $index,
                ]);
            } else {
                $student = Student::updateOrCreate([
                    'fullname' => $student_name,
                    'student_code' => $student_code,
                    'class_id' => $this->class->id,
                ],[
                    'index' => $index,
                ]);
            }

            $student_ids[] = $student->id;
        }

        Student::where('class_id', $this->class->id)->whereNotIn('id', $student_ids)->delete();
    }

    public function sheets(): array
    {
        return [0 => $this];
    }
}
