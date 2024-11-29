<?php

namespace App\Imports;

use App\Models\School;
use App\Models\Semester;
use App\Models\ClassRoom;
use App\Models\Department;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class VneduHeaderImport implements ToCollection, WithMultipleSheets
{
    public $department;
    public $school;
    public $class;
    public $semester;
    public $ErrorMessage = '';

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $subject_semester_school_year = explode(' - ', $collection[2][0]);
        $grade_and_class = explode(' - ', $collection[3][0]);

        $department_name = trim($collection[0][0]);
        $school_name = trim(str_replace(' TRƯỜNG', '', $collection[1][0]));
        $class_name = trim(str_replace('Lớp', '', $grade_and_class[1]));
        $grade = trim(str_replace('Khối', '', $grade_and_class[0]));
        $semester = trim($subject_semester_school_year[2]);
        $school_year = trim(str_replace('NĂM HỌC', '', $subject_semester_school_year[3]));

        if (in_array($grade, [1,2,3,4,5])) $level = 1;
        elseif (in_array($grade, [6,7,8,9])) $level = 2;
        elseif (in_array($grade, [10,11,12])) $level = 3;

        $this->department = Department::firstOrCreate([
            'name' => $department_name,
        ]);
        $this->school = School::firstOrCreate([
            'name' => $school_name,
            'department_id' => $this->department->id,
            'level' => $level ?? 0,
        ]);
        $this->class = ClassRoom::firstOrcreate([
            'name' => $class_name,
            'grade' => $grade,
            'school_id' => $this->school->id,
        ]);
        $this->semester = Semester::firstOrCreate([
            'school_year' => $school_year,
            'semester' => $semester,
        ]);
    }

    public function sheets(): array
    {
        return [0 => $this];
    }
}
