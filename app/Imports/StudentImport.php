<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StudentImport implements ToCollection, WithMultipleSheets
{
    public $class;

    public function __construct($class) {
        $this->class = $class;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $records = $collection->take(6 - $collection->count());
        $student_ids = [];

        foreach ($records as $key => $record) {
            $index = $record[0];
            $id_code = $record[1];
            $student_name = $record[2];

            if (empty($student_name)) continue;

            $deleted_student = Student::onlyTrashed()
                                ->where('class_id', $this->class->id)
                                ->where('id_code', $id_code)->first();
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
                    'id_code' => $id_code,
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
