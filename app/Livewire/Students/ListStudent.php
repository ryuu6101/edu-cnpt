<?php

namespace App\Livewire\Students;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Students\StudentRepositoryInterface;
use App\Repositories\ClassRooms\ClassRoomRepositoryInterface;

class ListStudent extends Component
{
    use WithPagination;

    protected $classRoomRepos;
    protected $studentRepos;

    public $class;
    public $class_id;
    public $paginate = 50;

    protected $listeners = [
        'search',
        'refresh' => '$refresh',
    ];

    public function boot(
        ClassRoomRepositoryInterface $classRoomRepos,
        StudentRepositoryInterface $studentRepos,
    ) {
        $this->classRoomRepos = $classRoomRepos;
        $this->studentRepos = $studentRepos;
    }

    public function mount($class_id) {
        $this->class_id = $class_id;
        $this->class = $this->classRoomRepos->find($class_id);
    }

    public function updatedPaginate() {
        $this->resetPage();
    }

    public function deleteErrorStudent($id = null) {
        if (isset($id) && $id > 0) $this->studentRepos->delete($id);
        else $this->class->students()->where('is_error', true)->delete();
        $this->dispatch('show-message', 
            type: 'success',
            message: 'Đã xóa học sinh bị nhập lỗi',
        );
    }

    public function addStudentToList($id = null) {
        if (isset($id) && $id > 0) $this->studentRepos->find($id)->update(['is_error' => false]);
        else $this->class->students()->where('is_error', true)->update(['is_error' => false]);
        $this->dispatch('show-message', 
            type: 'success',
            message: 'Đã thêm học sinh vào danh sách',
        );
    }

    public function render()
    {
        $students = $this->class->students()->paginate($this->paginate);
        $error_students = $this->class->error_students;

        return view('admin.sections.students.livewire.list-student')->with([
            'students' => $students,
            'error_students' => $error_students,
        ]);
    }
}
