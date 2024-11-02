<?php

namespace App\Livewire\Schools;

use Livewire\Component;
use App\Livewire\Schools\ListSchool;
use App\Repositories\Departments\DepartmentRepositoryInterface;

class SearchSchool extends Component
{
    protected $departmentRepos;

    public $list_departments;
    public $params = [
        'name' => '',
        'department_id' => '',
        'level' => '',
    ];

    public function boot(DepartmentRepositoryInterface $departmentRepos) {
        $this->departmentRepos = $departmentRepos;
    }

    public function mount() {
        $this->list_departments = $this->departmentRepos->getAll();
    }

    public function search() {
        $this->dispatch('search', params: $this->params)->to(ListSchool::class);
    }

    public function resetInput() {
        $this->reset('params');
        $this->dispatch('search', params: [])->to(ListSchool::class);
    }

    public function render()
    {
        return view('admin.sections.schools.livewire.search-school');
    }
}
