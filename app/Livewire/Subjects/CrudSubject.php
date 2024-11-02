<?php

namespace App\Livewire\Subjects;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Livewire\Subjects\ListSubject;
use App\Repositories\Subjects\SubjectRepositoryInterface;
use App\Repositories\VneduSubjects\VneduSubjectRepositoryInterface;

class CrudSubject extends Component
{
    protected $subjectRepos;
    protected $vneduSubjectRepos;

    public $grade;
    public $subject;
    public $action;
    public $name;
    public $use_digit_point;
    public $list_vnedu_subjects;
    public $current_vnedu_subject;
    public $vnedu_subject_id;

    protected $listeners = ['switchGrade'];

    public function boot(
        SubjectRepositoryInterface $subjectRepos,
        VneduSubjectRepositoryInterface $vneduSubjectRepos,
    ) {
        $this->subjectRepos = $subjectRepos;
        $this->vneduSubjectRepos = $vneduSubjectRepos;
    }

    public function rules() {
        return [
            'name' => [
                'required',
                Rule::unique('subjects')->where('grade', $this->grade)->ignore($this->subject->id ?? 0),
            ],
            'vnedu_subject_id' => ['required', 'gt:0'],
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Chưa nhập tên môn học.',
            'name.unique' => 'Tên môn học đã tồn tại.',
            'vnedu_subject_id.required' => 'Chưa nhập tên môn học.',
            'vnedu_subject_id.gt' => 'Chưa nhập tên môn học.',
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

        $this->subject = $this->subjectRepos->find(abs($id));

        if ($this->action != 'delete') {
            $this->resetErrorBag();
            $this->getData();
        };
    }

    public function getData() {
        $this->name = $this->subject->name ?? '';
        $this->use_digit_point = $this->subject->use_digit_point ?? true;
        $this->grade = $this->subject->grade ?? 1;

        // $this->list_vnedu_subjects = $this->vneduSubjectRepos->getUnsyncedSubjects($this->grade);
        $this->list_vnedu_subjects = $this->vneduSubjectRepos->getByGrade($this->grade);
        $this->current_vnedu_subject = $this->subject->vnedu_subject ?? null;
        $this->vnedu_subject_id = $this->subject->vnedu_subject->id ?? null;
    }

    public function getParams() {
        return [
            'name' => trim($this->name),
            'use_digit_point' => $this->use_digit_point,
        ];
    }

    public function create() {
        $this->validate();

        $subject = Subject::create($this->getParams());
        $class_ids = ClassRoom::where('grade', $this->grade)->get()->modelKeys();

        $this->postCrud('Đã thêm môn học');
    }

    public function update() {
        $this->validate();

        $this->subject->update($this->getParams());
        if ($this->subject->vnedu_subject) {
            $this->subject->vnedu_subject->update(['subject_id' => null]);
        }
        $this->vneduSubjectRepos->find($this->vnedu_subject_id)->update(['subject_id' => $this->subject->id]);

        $this->postCrud('Đã cập nhật môn học');
    }

    public function delete() {
        $this->subject->delete();
        $this->reset('subject');
        $this->postCrud('Đã xóa môn học');
    }

    public function postCrud($message = '') {
        $this->dispatch('refresh')->to(ListSubject::class);
        $this->dispatch('closeCrudSubjectModal');
        $this->dispatch('show-message', 
            type: 'success', 
            message: $message,
        );
    }

    public function render()
    {
        return view('admin.sections.subjects.livewire.crud-subject');
    }
}
