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
    public $coordinates;
    public $ErrorMessage = '';

    public function __construct($coordinates) {
        $this->coordinates = $coordinates;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $arr_index = $this->getArrayIndex($this->coordinates['department_cell']);
        $department_cell = $collection[$arr_index['row']][$arr_index['column']];
        if ($department_cell == '') {
            $this->ErrorMessage = 'Không tìm thấy Bộ GD ở ô '.$this->coordinates['department_cell'];
            return;
        }
        $department_name = trim($department_cell);

        $arr_index = $this->getArrayIndex($this->coordinates['school_cell']);
        $school_cell = $collection[$arr_index['row']][$arr_index['column']];
        if ($school_cell == '') {
            $this->ErrorMessage = 'Không tìm thấy Trường ở ô '.$this->coordinates['school_cell'];
            return;
        }
        $school_name = trim(str_replace('Trường:', '', $school_cell));

        $arr_index = $this->getArrayIndex($this->coordinates['class_cell']);
        $class_cell = $collection[$arr_index['row']][$arr_index['column']];
        if ($class_cell == '') {
            $this->ErrorMessage = 'Không tìm thấy Lớp ở ô '.$this->coordinates['class_cell'];
            return;
        }
        $class_name = trim(str_replace('Lớp:', '', ($class_cell)));
        $grade = explode('/', $class_name)[0];

        $arr_index = $this->getArrayIndex($this->coordinates['semester_cell']);
        $semester_cell = $collection[$arr_index['row']][$arr_index['column']];
        if ($semester_cell == '') {
            $this->ErrorMessage = 'Không tìm thấy Năm học - Học kỳ ở ô '.$this->coordinates['semester_cell'];
            return;
        }
        $school_year_and_semester = explode(' - ', $semester_cell, 2);
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

    public function getArrayIndex($coordinate) {
        $column = ord(substr($coordinate, 0, 1)) - 65;
        $row = substr($coordinate, 1) - 1;
        
        return [
            'row' => $row,
            'column' => $column,
        ];
    }

    public function sheets(): array
    {
        return [0 => $this];
    }
}
