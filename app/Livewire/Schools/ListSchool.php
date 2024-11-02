<?php

namespace App\Livewire\Schools;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Schools\SchoolRepositoryInterface;

class ListSchool extends Component
{
    use WithPagination;

    protected $schoolRepos;

    public $params = [];
    public $paginate = 5;
    public $education_level = [
        1 => 'Tiểu học',
        2 => 'THCS',
        3 => 'THPT',
    ];

    protected $listeners = [
        'search',
        'refresh' => '$refresh',
    ];

    public function boot(SchoolRepositoryInterface $schoolRepos) {
        $this->schoolRepos = $schoolRepos;
    }

    public function updatedPaginate() {
        $this->resetPage();
    }

    public function search($params) {
        $this->params = $params;
        $this->resetPage();
    }

    public function render()
    {
        $schools = $this->schoolRepos->filter($this->params, $this->paginate);

        return view('admin.sections.schools.livewire.list-school')->with([
            'schools' => $schools,
        ]);
    }
}
