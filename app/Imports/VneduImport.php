<?php

namespace App\Imports;

use Exception;
use App\Models\Student;
use App\Models\Subject;
use App\Models\VneduFile;
use App\Models\Scoreboard;

use App\Models\VneduSheet;
use App\Models\VneduSubject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class VneduImport implements ToCollection, WithEvents, WithChunkReading
{
    public $class_id;
    public $semester_id;

    public $VneduFile;
    public $CurrentSheetIndex = 0;
    public $CurrentSheetName = '';
    public $ErrorMessage = '';

    public function __construct($params){
        $this->VneduFile = VneduFile::firstOrCreate($params);
        $this->class_id = $params['class_id'];
        $this->semester_id = $params['semester_id'];
    }

    public function collection(Collection $collection)
    {
        $subject_semester_school_year = explode(' - ', $collection[2][0]);
        $grade_and_class = explode(' - ', $collection[3][0]);
        
        $grade = trim(str_replace('Khối', '', $grade_and_class[0]));
        $subject_name = mb_ucfirst(trim(str_replace('MÔN', '', $subject_semester_school_year[1])), 'UTF-8', true);
        // $subject = Subject::where('name', $subject_name)->where('grade', $grade)->first();
        
        $vnedu_subject = VneduSubject::firstOrCreate([
            'name' => $subject_name,
            'grade' => $grade,
        ]);

        VneduSheet::updateOrCreate([
            'vnedu_file_id' => $this->VneduFile->id,
            'vnedu_subject_id' => $vnedu_subject->id,
        ],[
            'sheet_name' => $this->CurrentSheetName,
            'sheet_index' => $this->CurrentSheetIndex,
        ]);

        for ($stt = 7; true; $stt++) {
            if (!($row = $collection[$stt] ?? false)) break;
            if (!is_numeric($row[0])) break;

            $index = $row[0];
            $student_code = $row[1];
            $student_name = $row[2].' '.$row[3];

            if (empty($student_name)) continue;

            $student = Student::updateOrCreate([
                'fullname' => $student_name,
                'student_code' => $student_code,
                'class_id' => $this->class_id,
            ],[
                'index' => $index,
            ]);

            $scoreboard = Scoreboard::updateOrCreate([
                'semester_id' => $this->semester_id,
                'class_id' => $this->class_id,
                'student_id' => $student->id,
                'vnedu_subject_id' => $vnedu_subject->id,
            ]);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->CurrentSheetName = $event->getSheet()->getTitle();
                $this->CurrentSheetIndex++;
            }
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
