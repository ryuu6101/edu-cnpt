<?php

namespace App\Imports;

use Exception;
use App\Models\Subject;
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
    public $VneduFile;
    public $CurrentSheetIndex = 0;
    public $CurrentSheetName = '';
    public $ErrorMessage = '';

    public function __construct($params){
        $this->VneduFile = VneduFile::firstOrCreate($params);
    }

    public function collection(Collection $collection)
    {
        if ($this->ErrorMessage != '') return;

        $subject_semester_school_year = explode(' - ', $collection[2][0]);
        $grade_and_class = explode(' - ', $collection[3][0]);
        
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
