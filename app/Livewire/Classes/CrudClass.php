<?php

namespace App\Livewire\Classes;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Livewire\Classes\ListClass;
use App\Repositories\Schools\SchoolRepositoryInterface;
use App\Repositories\ClassRooms\ClassRoomRepositoryInterface;

class CrudClass extends Component
{
    protected $schoolRepos;
    protected $classRoomRepos;

    public $class;
    public $action;
    public $name;
    public $school_id;
    public $list_grades;
    public $grade;

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
        $school = $this->schoolRepos->find($school_id);
        $this->school_id = $school_id;
        $this->list_grades = $grade_by_level[$school->level];
        $this->grade = $this->list_grades[0];
    }

    public function rules() {
        return [
            'name' => [
                'required',
                Rule::unique('classes')->where('school_id', $this->school_id)->ignore($this->class->id ?? 0),
            ],
            'school_id' => ['nullable'],
            'grade' => ['nullable'],
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Chưa nhập tên lớp học.',
            'name.unique' => 'Lớp học này đã tồn tại.',
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

        $this->class = $this->classRoomRepos->find(abs($id));

        if ($this->action != 'delete') {
            $this->resetErrorBag();
            $this->getData();
        };
    }

    public function getData() {
        $this->name = $this->class->name ?? '';
        $this->grade = $this->class->grade ?? $this->list_grades[0];
    }

    public function create() {
        $params = $this->validate();
        $class = $this->classRoomRepos->create($params);
        $this->postCrud('Đã thêm lớp học');
    }

    public function update() {
        $params = $this->validate();
        $this->class->update($params);
        $this->postCrud('Đã cập nhật lớp học');
    }

    public function delete() {
        $this->class->delete();
        $this->reset('class');
        $this->postCrud('Đã xóa lớp học');
    }

    public function postCrud($message = '') {
        $this->dispatch('refresh')->to(ListClass::class);
        $this->dispatch('closeCrudClassModal');
        $this->dispatch('show-message', 
            type: 'success', 
            message: $message,
        );
    }

    public function render()
    {
        return view('admin.sections.classes.livewire.crud-class');
    }
}
