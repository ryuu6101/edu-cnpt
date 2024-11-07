<?php

namespace App\Imports;

use Exception;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\VneduFile;
use App\Models\VneduSheet;
use App\Models\VneduSubject;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class VneduImport implements ToCollection, WithEvents, WithChunkReading
{
    public $FileName;
    public $VneduFile;
    public $CurrentSheetIndex = 0;
    public $CurrentSheetName = '';
    public $ErrorMessage = '';

    public function __construct($filename){
        $this->FileName = $filename;
    }

    public function collection(Collection $collection)
    {
        if ($this->ErrorMessage != '') return;

        $subject_semester_school_year = explode(' - ', $collection[2][0]);
        $grade_and_class = explode(' - ', $collection[3][0]);

        if ($this->CurrentSheetIndex <= 1) {
            $school_name = trim(str_replace(' TRƯỜNG', '', $collection[1][0]));
            $class_name = trim(str_replace('Lớp', '', $grade_and_class[1]));
            // $semester = trim(str_replace('HỌC KỲ', '', $subject_semester_school_year[2]));
            $semester = trim($subject_semester_school_year[2]);
            $school_year = trim(str_replace('NĂM HỌC', '', $subject_semester_school_year[3]));
    
            $school = School::where('export_name', $school_name)->orWhere('name', $school_name)->first();
            if (!$school) {
                $this->ErrorMessage = nl2br("Đã xảy ra lỗi! \n Không tìm thấy {$school_name}");
                return;
            }
            $class = $school->classes->where('name', $class_name)->first();
            if (!$class) {
                $this->ErrorMessage = nl2br("Đã xảy ra lỗi! \n Không tìm thấy lớp {$class_name}");
                return;
            }
            $semester = Semester::where('school_year', $school_year)->where('semester', $semester)->first();
            if (!$semester) {
                $this->ErrorMessage = nl2br("Đã xảy ra lỗi! \n Không tìm thấy {$semester} ({$school_year})");
                return;
            }

            $this->VneduFile = VneduFile::firstOrCreate([
                'file_name' => $this->FileName,
                'semester_id' => $semester->id,
                'school_id' => $school->id,
                'class_id' => $class->id,
            ]);
        }
        
        $grade = trim(str_replace('Khối', '', $grade_and_class[0]));
        $subject_name = mb_ucfirst(trim(str_replace('MÔN', '', $subject_semester_school_year[1])), 'UTF-8', true);
        $subject = Subject::where('name', $subject_name)->where('grade', $grade)->first();
        
        $vnedu_subject = VneduSubject::firstOrCreate([
            'name' => $subject_name,
            'grade' => $grade,
        ],[
            'subject_id' => $subject->id ?? null,
        ]);

        VneduSheet::updateOrCreate([
            'vnedu_file_id' => $this->VneduFile->id,
            'vnedu_subject_id' => $vnedu_subject->id,
        ],[
            'sheet_name' => $this->CurrentSheetName,
            'sheet_index' => $this->CurrentSheetIndex,
        ]);

        if ($this->CurrentSheetIndex > 1) return;

        $records = $collection->slice(7, $class->students->count());
        foreach ($records as $key => $record) {
            $student_code = trim($record[1]);
            $student_name = trim($record[2]).' '.trim($record[3]);

            $student = $class->students->where('fullname', $student_name)->first();
            if ($student) {
                $student->update(['student_code' => $student_code]);
            } else {
                Student::create([
                    'fullname' => $student_name,
                    'student_code' => $student_code,
                    'class_id' => $class->id,
                    'is_error' => true,
                ]);
            }
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
