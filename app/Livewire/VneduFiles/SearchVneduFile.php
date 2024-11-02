<?php

namespace App\Livewire\VneduFiles;

use App\Models\School;
use Livewire\Component;
use App\Models\Semester;
use App\Models\ClassRoom;
use App\Livewire\VneduFiles\ListVneduFile;
use App\Repositories\Schools\SchoolRepositoryInterface;
use App\Repositories\Semesters\SemesterRepositoryInterface;

class SearchVneduFile extends Component
{
    protected $schoolRepos;
    protected $semesterRepos;

    public $list_schools, $school_id;
    public $list_grades, $grade;
    public $list_classes, $class_id;
    public $list_semesters, $semester_id;

    public function boot(
        SchoolRepositoryInterface $schoolRepos,
        SemesterRepositoryInterface $semesterRepos,
    ) {
        $this->schoolRepos = $schoolRepos;
        $this->semesterRepos = $semesterRepos;
    }

    public function mount() {
        $this->list_schools = $this->schoolRepos->getAll()->sortBy('name');
        $this->school_id = '';
        $this->list_semesters = $this->semesterRepos->getAll()->sortBy('name')->sortBy('school_year');
        $this->semester_id = $this->list_semester[0] ?? '';
    }

    public function updatedSchoolId() {
        $school = $this->schoolRepos->find($this->school_id);
        if ($school) {
            $this->list_grades = [
                1 => [1,2,3,4,5],
                2 => [6,7,8,9],
                3 => [10,11,12],
            ][$school->level];

            if (!in_array($this->grade, $this->list_grades)) {
                $this->grade = $this->list_grades[0] ?? '';
            }
        } else {
            $this->reset('list_grades', 'grade');
        }
        
        $this->updatedGrade();
    }

    public function updatedGrade() {
        $school = $this->schoolRepos->find($this->school_id);
        if ($school) {
            $this->list_classes = $school->classes->where('grade', $this->grade)->sortBy('name');
            $this->class_id = $this->list_classes->first()->id ?? 0;
        } else {
            $this->reset('list_classes', 'class_id');
        }
    }

    public function search() {
        $params = [
            'school_id' => $this->school_id,
            'class_id' => $this->class_id,
            'semester_id' => $this->semester,
        ];

        $this->dispatch('search', params: $params)->to(ListVneduFile::class);
    }
    
    public function render()
    {
        return view('admin.sections.vnedu-files.livewire.search-vnedu-file');
    }
}
