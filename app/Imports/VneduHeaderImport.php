<?php

namespace App\Imports;

use App\Models\School;
use App\Models\Semester;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class VneduHeaderImport implements ToCollection, WithMultipleSheets
{
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

        $school_name = trim(str_replace(' TRƯỜNG', '', $collection[1][0]));
        $class_name = trim(str_replace('Lớp', '', $grade_and_class[1]));
        // $semester = trim(str_replace('HỌC KỲ', '', $subject_semester_school_year[2]));
        $semester = trim($subject_semester_school_year[2]);
        $school_year = trim(str_replace('NĂM HỌC', '', $subject_semester_school_year[3]));

        $this->school = School::where('export_name', $school_name)->orWhere('name', $school_name)->first();
        if (!$this->school) {
            $this->ErrorMessage = "Không tìm thấy {$school_name}";
            return;
        }
        $this->class = $this->school->classes->where('name', $class_name)->first();
        if (!$this->class) {
            $this->ErrorMessage = "Không tìm thấy lớp {$class_name}";
            return;
        }
        $this->semester = Semester::where('school_year', $school_year)->where('semester', $semester)->first();
        if (!$this->semester) {
            $this->ErrorMessage = "Không tìm thấy {$semester} ({$school_year})";
            return;
        }
    }

    public function sheets(): array
    {
        return [0 => $this];
    }
}
