<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Subject;

use App\Models\VneduFile;
use App\Models\Scoreboard;
use App\Models\VneduSubject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ScoreboardImport implements ToCollection, WithChunkReading, WithEvents
{
    public $class;
    public $semester;
    public $coordinates;

    public $CurrentSheetIndex = 0;
    public $CurrentSheetName = '';
    public $ErrorMessage = '';
    public $ErrorReports = [];

    public function __construct($vnedu_file_id, $coordinates) {
        $vnedu_file = VneduFile::find($vnedu_file_id);
        $this->class = $vnedu_file->class;
        $this->semester = $vnedu_file->semester;
        $this->coordinates = $coordinates;
    }

    public function collection(Collection $collection)
    {
        if ($this->ErrorMessage != '') return;

        $arr_index = $this->getArrayIndex($this->coordinates['subject_cell']);
        $subject_cell = $collection[$arr_index['row']][$arr_index['column']];
        if ($subject_cell == '') {
            $this->ErrorMessage = 'Không tìm thấy Môn học ở ô '.$this->coordinates['subject_cell'];
            return;
        }
        $subject_and_teacher = explode(' - ', $subject_cell, 2);

        $subject_name = mb_ucfirst(trim(str_replace('Môn học:', '', $subject_and_teacher[0])), 'UTF-8', true);
        $subject_name_striped = strip_vn($subject_name);
        $subject_name_slug = str_replace(' ', '_', mb_strtolower($subject_name_striped, 'UTF-8'));

        $vnedu_subject = VneduSubject::where('grade', $this->class->grade)
                                ->where('optional_name', $subject_name)
                                ->orWhere('name', $subject_name)->first();

        if (!$vnedu_subject) {
            $this->ErrorReports[$this->CurrentSheetName][] = "Không tìm thấy môn học {$subject_name}";
            return;
        }

        for ($stt = $this->coordinates['starting_row'] - 1; true; $stt++) {
            if (!($row = $collection[$stt] ?? false)) break;
            if (!is_numeric($row[0])) break;

            $index = $row[0];
            $id_code = $row[1];
            $student_name = $row[2];
            $tx1 = $row[5];
            $tx2 = $row[6];
            $tx3 = $row[7];
            $tx4 = $row[8];
            $tx5 = $row[9];
            $DDGgk = $row[10];
            $DDGck = $row[11];

            if (empty($student_name)) continue;

            $student = $this->class->students->where('fullname', $student_name)->first();
            if (!$student) {
                $this->ErrorReports[$this->CurrentSheetName][] = "Không tìm thấy học sinh {$student_name}";
                continue;
            }

            $scoreboard = Scoreboard::updateOrCreate([
                'semester_id' => $this->semester->id,
                'class_id' => $this->class->id,
                'student_id' => $student->id,
                'vnedu_subject_id' => $vnedu_subject->id,
            ],[
                'tx1' => $tx1,
                'tx2' => $tx2,
                'tx3' => $tx3,
                'tx4' => $tx4,
                'tx5' => $tx5,
                'ddggk' => $DDGgk,
                'ddgck' => $DDGck,
            ]);
        }
    }

    public function getArrayIndex($coordinate) {
        $column = ord(substr($coordinate, 0, 1)) - 65;
        $row = substr($coordinate, 1) - 1;
        
        return [
            'row' => $row,
            'column' => $column,
        ];
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