<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Subject;

use App\Models\Scoreboard;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ScoreboardImport implements ToCollection, WithChunkReading
{
    public $department;
    public $school;
    public $class;
    public $semester;
    public $coordinates;
    public $ErrorMessage = '';

    public function __construct($params, $coordinates) {
        $this->department = $params['department'];
        $this->school = $params['school'];
        $this->class = $params['class'];
        $this->semester = $params['semester'];
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

        $subject = Subject::firstOrCreate([
            'name' => $subject_name,
            'grade' => $this->class->grade,
        ]);

        // $this->class->subjects()->syncWithoutDetaching([$subject->id]);

        $records = $collection->take($this->coordinates['starting_row'] - 1 - $collection->count());

        foreach ($records as $key => $record) {
            $index = $record[0];
            $id_code = $record[1];
            $student_name = $record[2];
            $tx1 = $record[5];
            $tx2 = $record[6];
            $tx3 = $record[7];
            $tx4 = $record[8];
            $tx5 = $record[9];
            $DDGgk = $record[10];
            $DDGck = $record[11];

            if (empty($student_name)) continue;

            // $student = Student::updateOrCreate([
            //     'fullname' => $student_name,
            //     'id_code' => $id_code,
            //     'class_id' => $this->class->id,
            // ],[
            //     'index' => $index,
            // ]);

            $student = $this->class->students->where('id_code', $id_code)->first();
            if (!$student) continue;

            $scoreboard = Scoreboard::updateOrCreate([
                'semester_id' => $this->semester->id,
                'department_id' => $this->department->id,
                'school_id' => $this->school->id,
                'class_id' => $this->class->id,
                'student_id' => $student->id,
                'subject_id' => $subject->id,
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

    public function chunkSize(): int
    {
        return 1000;
    }
}