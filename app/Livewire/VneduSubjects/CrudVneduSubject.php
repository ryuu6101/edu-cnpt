<?php

namespace App\Livewire\VneduSubjects;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Livewire\VneduSubjects\ListVneduSubject;
use App\Repositories\VneduSubjects\VneduSubjectRepositoryInterface;

class CrudVneduSubject extends Component
{
    protected $vneduSubjectRepos;

    public $grade;
    public $vnedu_subject;
    public $action;
    public $name;
    public $optional_name;
    public $use_rating_point;

    protected $listeners = ['switchGrade'];

    public function boot(VneduSubjectRepositoryInterface $vneduSubjectRepos) {
        $this->vneduSubjectRepos = $vneduSubjectRepos;
    }

    public function rules() {
        return [
            'name' => [
                'required',
                Rule::unique('vnedu_subjects')->where('grade', $this->grade)->ignore($this->vnedu_subject->id ?? 0),
            ],
            'optional_name' => ['nullable'],
            'use_rating_point' => ['nullable'],
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Chưa nhập tên môn học.',
            'name.unique' => 'Tên môn học đã tồn tại.',
        ];
    }

    public function switchGrade($grade) {
        $this->grade = $grade;
    }

    public function modalSetup($id) {
        if ($id > 0) {
            $this->action = 'update';
        } elseif ($id < 0) {
            $this->action = 'delete';
        } else {
            $this->action = 'create';
        }

        $this->vnedu_subject = $this->vneduSubjectRepos->find(abs($id));

        if ($this->action != 'delete') {
            $this->resetErrorBag();
            $this->getData();
        };
    }

    public function getData() {
        $this->name = $this->vnedu_subject->name ?? '';
        $this->optional_name = $this->vnedu_subject->optional_name ?? '';
        $this->use_rating_point = $this->vnedu_subject->use_rating_point ?? 0;
        $this->grade = $this->vnedu_subject->grade ?? 1;
    }

    public function create() {
        $params = $this->validate();
        $vnedu_subject = Subject::create($params);
        $this->postCrud('Đã thêm môn học');
    }

    public function update() {
        $params = $this->validate();
        $this->vnedu_subject->update($params);
        $this->postCrud('Đã cập nhật môn học');
    }

    public function delete() {
        $this->vnedu_subject->delete();
        $this->reset('vnedu_subject');
        $this->postCrud('Đã xóa môn học');
    }

    public function postCrud($message = '') {
        $this->dispatch('refresh')->to(ListVneduSubject::class);
        $this->dispatch('closeCrudVneduSubjectModal');
        $this->dispatch('show-message', 
            type: 'success', 
            message: $message,
        );
    }

    public function render()
    {
        return view('admin.sections.vnedu-subjects.livewire.crud-vnedu-subject');
    }
}
