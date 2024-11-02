<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Schools\SchoolRepositoryInterface;
use App\Repositories\ClassRooms\ClassRoomRepositoryInterface;

class SectionController extends Controller
{
    protected $schoolRepos;
    protected $classRoomRepos;

    public function __construct(
        SchoolRepositoryInterface $schoolRepos,
        ClassRoomRepositoryInterface $classRoomRepos,
    ) {
        $this->schoolRepos = $schoolRepos;
        $this->classRoomRepos = $classRoomRepos;
    }

    public function dashboard() {
        $menu = [
            'sidebar' => 'dashboard',
            'breadcrumb' => 'Trang chủ',
        ];

        return view('admin.sections.dashboard.index')->with(['menu' => $menu]);
    }

    public function schools() {
        $menu = [
            'sidebar' => 'schools',
            'breadcrumb' => 'Trường học',
        ];

        return view('admin.sections.schools.index')->with(['menu' => $menu]);
    }

    public function classes(Request $request) {
        $menu = [
            'sidebar' => 'schools',
            'breadcrumb' => 'Trường học',
        ];

        $school_id = $request->input('school_id');
        $school = $this->schoolRepos->find($school_id);
        if (!$school) return abort(404);

        return view('admin.sections.classes.index')->with([
            'school_id' => $school_id,
            'school' => $school,
            'menu' => $menu,
        ]);
    }

    public function students(Request $request) {
        $menu = [
            'sidebar' => 'schools',
            'breadcrumb' => 'Trường học',
        ];

        $class_id = $request->input('class_id');
        $class = $this->classRoomRepos->find($class_id);
        if (!$class) return abort(404);

        return view('admin.sections.students.index')->with([
            'class_id' => $class_id,
            'class' => $class,
            'menu' => $menu,
        ]);
    }

    public function subjects() {
        $menu = [
            'sidebar' => 'subjects',
            'breadcrumb' => 'Môn học',
        ];

        return view('admin.sections.subjects.index')->with(['menu' => $menu]);
    }

    public function vnedu_files() {
        $menu = [
            'sidebar' => 'vnedu-files',
            'breadcrumb' => 'Bảng điểm',
        ];

        return view('admin.sections.vnedu-files.index')->with(['menu' => $menu]);
    }

    public function scoreboard(Request $request) {
        $menu = [
            'sidebar' => 'vnedu-files',
            'breadcrumb' => 'Bảng điểm',
        ];

        return view('admin.sections.scoreboard.index')->with([
            'vnedu_file_id' => $request->input('file_id'),
            'menu' => $menu]
        );
    }
}
