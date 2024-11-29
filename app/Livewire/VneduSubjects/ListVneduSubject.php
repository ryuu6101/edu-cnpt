<?php

namespace App\Livewire\VneduSubjects;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\VneduSubjects\VneduSubjectRepositoryInterface;

class ListVneduSubject extends Component
{
    use WithPagination;

    protected $vneduSubjectRepos;

    public $paginate = 20;
    public $params = [
        'name' => '',
        'grade' => 1,
    ];

    protected $listeners = [
        'search',
        'refresh' => '$refresh',
    ];

    public function boot(VneduSubjectRepositoryInterface $vneduSubjectRepos) {
        $this->vneduSubjectRepos = $vneduSubjectRepos;
    }

    public function mount() {
        $this->params['grade'] = $this->vneduSubjectRepos->getAll()->min('grade');
    }

    public function updatedPaginate() {
        $this->resetPage();
    }

    public function render()
    {
        $vnedu_subjects = $this->vneduSubjectRepos->filter($this->params, $this->paginate);

        return view('admin.sections.vnedu-subjects.livewire.list-vnedu-subject')->with([
            'vnedu_subjects' => $vnedu_subjects,
        ]);
    }
}
