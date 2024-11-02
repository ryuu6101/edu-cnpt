<?php

namespace App\Livewire\Scoreboards;

use App\Models\Student;
use Livewire\Component;
use App\Models\Semester;
use App\Models\ClassRoom;
use App\Models\VneduFile;
use App\Models\Scoreboard;
use App\Models\VneduSubject;
use App\Models\SemesterRecord;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Semesters\SemesterRepositoryInterface;
use App\Repositories\VneduFiles\VneduFileRepositoryInterface;
use App\Repositories\Scoreboards\ScoreboardRepositoryInterface;

class ScoreboardDetail extends Component
{
    protected $vneduFileRepos;
    protected $scoreboardRepos;
    protected $semesterRepos;

    public $vnedu_file;
    public $semester;
    public $edit_record;
    public $edit_student;
    public $edit_record_id;
    public $edit_student_fields;
    public $edit_record_fields;
    public $allow_export = true;

    public function boot(
        VneduFileRepositoryInterface $vneduFileRepos,
        ScoreboardRepositoryInterface $scoreboardRepos,
        SemesterRepositoryInterface $semesterRepos,
    ) {
        $this->vneduFileRepos = $vneduFileRepos;
        $this->scoreboardRepos = $scoreboardRepos;
        $this->semesterRepos = $semesterRepos;
    }

    public function mount($vnedu_file_id) {
        $this->vnedu_file = $this->vneduFileRepos->find($vnedu_file_id);
        $this->semester = $this->semesterRepos->find($this->vnedu_file->semester_id);
    }

    public function editRecord($record_id) {
        $this->edit_record = $this->scoreboardRepos->find($record_id);
        $this->edit_student = $this->edit_record->student;
        $this->edit_record_id = $record_id;
        $this->edit_student_fields = [
            'fullname' => $this->edit_student->fullname,
            'student_code' => $this->edit_student->student_code,
        ];
        $this->edit_record_fields = [
            'tx1' => $this->edit_record->tx1,
            'tx2' => $this->edit_record->tx2,
            'tx3' => $this->edit_record->tx3,
            'tx4' => $this->edit_record->tx4,
        ];
    }

    public function updateRecord() {
        $this->edit_student->update($this->edit_student_fields);
        $this->edit_record->update($this->edit_record_fields);
        $this->reset('edit_record_id');
    }

    public function render()
    {
        $vnedu_sheets = $this->vnedu_file->vnedu_sheets;
        $scoreboards = $this->semester->records->where('class_id', $this->vnedu_file->class_id);

        return view('admin.sections.scoreboard.livewire.scoreboard-detail')->with([
            'vnedu_sheets' => $vnedu_sheets,
            'scoreboards' => $scoreboards,
        ]);
    }
}
