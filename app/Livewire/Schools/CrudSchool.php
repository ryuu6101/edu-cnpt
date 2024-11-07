<?php

namespace App\Livewire\Schools;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Livewire\Schools\ListSchool;
use App\Repositories\Schools\SchoolRepositoryInterface;
use App\Repositories\Departments\DepartmentRepositoryInterface;

class CrudSchool extends Component
{
    protected $departmentRepos;
    protected $schoolRepos;

    public $school;
    public $action;
    public $name;
    public $export_name;
    public $list_departments;
    public $department_id;
    public $level;

    public function boot(
        DepartmentRepositoryInterface $departmentRepos,
        SchoolRepositoryInterface $schoolRepos,
    ) {
        $this->departmentRepos = $departmentRepos;
        $this->schoolRepos = $schoolRepos;
    }

    public function mount() {
        $this->list_departments = $this->departmentRepos->getAll();
        $this->department_id = $this->list_departments->first()->id ?? '';
    }

    public function rules() {
        return [
            'name' => [
                'required',
                Rule::unique('schools')->where('department_id', $this->department_id)->ignore($this->school->id ?? 0),
            ],
            'export_name' => ['nullable'],
            'department_id' => ['nullable'],
            'level' => ['nullable'],
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Chưa nhập tên trường học.',
            'name.unique' => 'Trường học này đã tồn tại.',
        ];
    }

    public function modalSetup($id) {
        if ($id > 0) {
            $this->action = 'update';
        } elseif ($id < 0) {
            $this->action = 'delete';
        } else {
            $this->action = 'create';
        }

        $this->school = $this->schoolRepos->find(abs($id));

        if ($this->action != 'delete') {
            $this->resetErrorBag();
            $this->getData();
        };
    }

    public function getData() {
        $this->name = $this->school->name ?? '';
        $this->export_name = $this->school->export_name ?? '';
        $this->department_id = $this->school->department_id ?? $this->list_departments->first()->id ?? 0;
        $this->level = $this->school->level ?? 1;
    }

    // public function updatedName() {
    //     if ($this->action != 'create') return;
    //     $this->export_name = $this->name;
    // }

    public function create() {
        $params = $this->validate();
        $school = $this->schoolRepos->create($params);
        $this->postCrud('Đã thêm trường học');
    }

    public function update() {
        $params = $this->validate();
        $this->school->update($params);
        $this->postCrud('Đã cập nhật trường học');
    }

    public function delete() {
        $this->school->delete();
        $this->reset('school');
        $this->postCrud('Đã xóa trường học');
    }

    public function postCrud($message = '') {
        $this->dispatch('refresh')->to(ListSchool::class);
        $this->dispatch('closeCrudSchoolModal');
        $this->dispatch('show-message', 
            type: 'success', 
            message: $message,
        );
    }

    public function render()
    {
        return view('admin.sections.schools.livewire.crud-school');
    }
}
