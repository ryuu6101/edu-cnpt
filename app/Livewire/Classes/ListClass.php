<?php

namespace App\Livewire\Classes;

use Livewire\Component;
use App\Repositories\Schools\SchoolRepositoryInterface;
use App\Repositories\ClassRooms\ClassRoomRepositoryInterface;

class ListClass extends Component
{
    protected $schoolRepos;
    protected $classRoomRepos;

    public $school;
    public $params = [];
    public $list_grades = [];

    protected $listeners = [
        'search',
        'refresh' => '$refresh',
    ];

    public function boot(
        SchoolRepositoryInterface $schoolRepos,
        ClassRoomRepositoryInterface $classRoomRepos,
    ) {
        $this->schoolRepos = $schoolRepos;
        $this->classRoomRepos = $classRoomRepos;
    }

    public function mount($school_id) {
        $grade_by_level = [
            1 => [1,2,3,4,5],
            2 => [6,7,8,9],
            3 => [10,11,12],
        ];
        $this->school = $this->schoolRepos->find($school_id);
        $this->list_grades = $grade_by_level[$this->school->level];
        $this->params = ['school_id' => $school_id];
    }

    public function search($params) {
        $this->params = $params;
        $this->resetPage();
    }

    public function render()
    {
        // $classes = $this->classRoomRepos->filter($this->params)->sortBy('name');
        $classes = $this->school->classes->sortBy('name');

        return view('admin.sections.classes.livewire.list-class')->with([
            'classes' => $classes,
        ]);
    }
}
