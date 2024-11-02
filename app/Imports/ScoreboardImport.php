<?php

namespace App\Imports;

use App\Models\School;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\ClassRoom;
use App\Models\Scoreboard;
use App\Models\Department;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ScoreboardImport implements ToCollection, WithHeadingRow, WithEvents
{
    public $sheetNames;
    public $sheetData;
	
    public function __construct(){
        $this->sheetNames = [];
        $this->sheetData = [];
    }

    public function collection(Collection $collection)
    {
        $this->sheetData[] = $collection;

        $school_year_and_semester = explode(' - ', $collection[1][5], 2);
        $subject_and_teacher = explode(' - ', $collection[2][5], 2);
        
        $department_name = trim($collection[0][0]);
        $class_name = trim(str_replace('Lớp:', '', ($collection[2][0])));
        $grade = explode('/', $class_name)[0];
        $school_name = trim(str_replace('Trường:', '', $collection[1][0]));
        $school_year = trim(str_replace('Năm học:', '', $school_year_and_semester[0]));
        // $semester = trim(str_replace('Học kỳ:', '', $school_year_and_semester[1]));
        $semester_number = strlen(trim(str_replace('Học kỳ:', '', $school_year_and_semester[1])));
        $semester = 'Học kỳ '.$semester_number;
        $subject_name = mb_ucfirst(trim(str_replace('Môn học:', '', $subject_and_teacher[0])), 'UTF-8', true);
        $subject_name_striped = strip_vn($subject_name);
        $subject_name_slug = str_replace(' ', '_', mb_strtolower($subject_name_striped, 'UTF-8'));

        $lowcase_school_name = strtolower($school_name);
        if (str_contains($lowcase_school_name, 'tiểu học')) $level = 1;
        elseif (str_contains($lowcase_school_name, 'thcs')) $level = 2;
        elseif (str_contains($lowcase_school_name, 'thpt')) $level = 3;
        
        $subject = Subject::firstOrCreate([
            'name' => $subject_name,
            'grade' => $grade,
        ]);
        $department = Department::firstOrCreate([
            'name' => $department_name,
        ]);
        $school = School::firstOrCreate([
            'name' => $school_name,
            'department_id' => $department->id,
            'level' => $level ?? 1,
        ]);
        $class = ClassRoom::firstOrcreate([
            'name' => $class_name,
            'grade' => $grade,
            'school_id' => $school->id,
        ]);
        $semester = Semester::firstOrCreate([
            'school_year' => $school_year,
            'semester' => $semester,
        ]);

        $class->subjects()->syncWithoutDetaching([$subject->id]);

        $records = $collection->take(6 - $collection->count());

        foreach ($records as $key => $record) {
            $student_name = $record[2];
            $tx1 = $record[5];
            $tx2 = $record[6];
            $tx3 = $record[7];
            $tx4 = $record[8];

            if (empty($student_name)) continue;

            $student = Student::firstOrCreate([
                'fullname' => $student_name,
                'class_id' => $class->id,
            ]);

            $semester_record = Scoreboard::updateOrCreate([
                'semester_id' => $semester->id,
                'department_id' => $department->id,
                'school_id' => $school->id,
                'class_id' => $class->id,
                'student_id' => $student->id,
                'subject_id' => $subject->id,
            ],[
                'tx1' => $tx1,
                'tx2' => $tx2,
                'tx3' => $tx3,
                'tx4' => $tx4,
            ]);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->sheetNames[] = $event->getSheet()->getTitle();
            } 
        ];
    }

}