<?php

namespace App\Livewire\CoordinatePresets;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Livewire\CoordinatePresets\ListCoordinatePreset;
use App\Repositories\CoordinatePresets\CoordinatePresetRepositoryInterface;

class CrudCoordinatePreset extends Component
{
    protected $coordinatePresetRepos;

    public $coordinate_preset;
    public $action;
    public $name;
    public $department;
    public $school;
    public $class;
    public $semester;
    public $subject;
    public $starting_row;

    public function boot(CoordinatePresetRepositoryInterface $coordinatePresetRepos) {
        $this->coordinatePresetRepos = $coordinatePresetRepos;
    }

    public function rules() {
        return [
            'name' => ['required'],
            'department' => ['required','regex:/^[A-Z]{1}[0-9]+$/'],
            'school' => ['required','regex:/^[A-Z]{1}[0-9]+$/'],
            'class' => ['required','regex:/^[A-Z]{1}[0-9]+$/'],
            'semester' => ['required','regex:/^[A-Z]{1}[0-9]+$/'],
            'subject' => ['required','regex:/^[A-Z]{1}[0-9]+$/'],
            'starting_row' => ['required','gt:0'],
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Chưa nhập tên.',
            'department.required' => 'Chưa nhập vị trí',
            'department.regex' => 'Vị trí không hợp lệ',
            'school.required' => 'Chưa nhập vị trí',
            'school.regex' => 'Vị trí không hợp lệ',
            'class.required' => 'Chưa nhập vị trí',
            'class.regex' => 'Vị trí không hợp lệ',
            'semester.required' => 'Chưa nhập vị trí',
            'semester.regex' => 'Vị trí không hợp lệ',
            'subject.required' => 'Chưa nhập vị trí',
            'subject.regex' => 'Vị trí không hợp lệ',
            'starting_row.required' => 'Chưa nhập vị trí',
            'starting_row.gt' => 'Vui lòng nhập lớn hơn 0',
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

        $this->coordinate_preset = $this->coordinatePresetRepos->find(abs($id));

        if ($this->action != 'delete') {
            $this->resetErrorBag();
            $this->getData();
        };
    }

    public function getData() {
        $this->name = $this->coordinate_preset->name ?? '';
        $this->department = $this->coordinate_preset->department ?? '';
        $this->school = $this->coordinate_preset->school ?? '';
        $this->class = $this->coordinate_preset->class ?? '';
        $this->semester = $this->coordinate_preset->semester ?? '';
        $this->subject = $this->coordinate_preset->subject ?? '';
        $this->starting_row = $this->coordinate_preset->starting_row ?? 1;
    }

    public function create() {
        $params = $this->validate();
        $coordinate_preset = $this->coordinatePresetRepos->create($params);
        $this->postCrud('Thêm mới thành công');
    }

    public function update() {
        $params = $this->validate();
        $this->coordinate_preset->update($params);
        $this->postCrud('Cập nhật thành công');
    }

    public function delete() {
        $this->coordinate_preset->delete();
        $this->reset('coordinate_preset');
        $this->postCrud('Đã xóa');
    }

    public function postCrud($message = '') {
        $this->dispatch('refresh')->to(ListCoordinatePreset::class);
        $this->dispatch('closeCrudCoordinatePresetModal');
        $this->dispatch('show-message', 
            type: 'success', 
            message: $message,
        );
    }

    public function render()
    {
        return view('admin.sections.coordinate-presets.livewire.crud-coordinate-preset');
    }
}
