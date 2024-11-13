<?php

namespace App\Imports;

use App\Models\School;
use App\Models\Semester;
use App\Models\ClassRoom;
use App\Models\Department;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class HeaderImport implements ToCollection, WithMultipleSheets
{
    public $department;
    public $school;
    public $class;
    public $semester;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $school_year_and_semester = explode(' - ', $collection[2][5], 2);
        
        $department_name = trim($collection[1][0]);
        $class_name = trim(str_replace('Lớp:', '', ($collection[3][0])));
        $grade = explode('/', $class_name)[0];
        $school_name = trim(str_replace('Trường:', '', $collection[2][0]));
        $school_year = trim(str_replace('Năm học:', '', $school_year_and_semester[0]));
        $semester_number = strlen(trim(str_replace('Học kỳ:', '', $school_year_and_semester[1])));
        $semester = 'Học kỳ '.$semester_number;

        if (in_array($grade, [1,2,3,4,5])) $level = 1;
        elseif (in_array($grade, [6,7,8,9])) $level = 2;
        elseif (in_array($grade, [10,11,12])) $level = 3;

        $this->department = Department::firstOrCreate([
            'name' => $department_name,
        ]);
        $this->school = School::firstOrCreate([
            'name' => $school_name,
            'department_id' => $this->department->id,
            'level' => $level ?? 1,
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
