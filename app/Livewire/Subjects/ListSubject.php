<?php

namespace App\Livewire\Subjects;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Subjects\SubjectRepositoryInterface;

class ListSubject extends Component
{
    use WithPagination;

    protected $subjectRepos;

    public $paginate = 20;
    public $params = [
        'name' => '',
        'grade' => 1,
    ];

    protected $listeners = [
        'search',
        'refresh' => '$refresh',
    ];

    public function boot(SubjectRepositoryInterface $subjectRepos) {
        $this->subjectRepos = $subjectRepos;
    }

    public function mount() {
        $this->params['grade'] = $this->subjectRepos->getAll()->min('grade');
    }

    public function updatedPaginate() {
        $this->resetPage();
    }

    public function render()
    {
        $subjects = $this->subjectRepos->filter($this->params, $this->paginate);

        return view('admin.sections.subjects.livewire.list-subject')->with([
            'subjects' => $subjects,
        ]);
    }
}
