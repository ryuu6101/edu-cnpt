<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Schools\SchoolRepositoryInterface;
use App\Repositories\ClassRooms\ClassRoomRepositoryInterface;
use App\Repositories\VneduFiles\VneduFileRepositoryInterface;

class SectionController extends Controller
{
    protected $schoolRepos;
    protected $classRoomRepos;
    protected $vneduFileRepos;

    public function __construct(
        SchoolRepositoryInterface $schoolRepos,
        ClassRoomRepositoryInterface $classRoomRepos,
        VneduFileRepositoryInterface $vneduFileRepos,
    ) {
        $this->schoolRepos = $schoolRepos;
        $this->classRoomRepos = $classRoomRepos;
        $this->vneduFileRepos = $vneduFileRepos;
    }

    public function dashboard() {
        $menu = [
            'sidebar' => 'dashboard',
            'breadcrumb' => 'Trang chủ',
        ];

        return view('admin.sections.dashboard.index')->with(['menu' => $menu]);
    }

    public function excel_import() {
        $menu = [
            'sidebar' => 'dashboard',
            'breadcrumb' => 'Trang chủ',
        ];

        return view('admin.sections.excel-import.index')->with(['menu' => $menu]);
    }

    public function vnedu_import() {
        $menu = [
            'sidebar' => 'dashboard',
            'breadcrumb' => 'Trang chủ',
        ];

        return view('admin.sections.vnedu-import.index')->with(['menu' => $menu]);
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

        return view('admin.sections.vnedu-subjects.index')->with(['menu' => $menu]);
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

        $vnedu_file_id = $request->input('file_id');
        $vnedu_file = $this->vneduFileRepos->find($vnedu_file_id);
        if (!$vnedu_file) return abort(404);

        return view('admin.sections.scoreboard.index')->with([
            'vnedu_file_id' => $vnedu_file_id,
            'menu' => $menu
        ]);
    }

    public function scoreboard_import(Request $request) {
        $menu = [
            'sidebar' => 'vnedu-files',
            'breadcrumb' => 'Bảng điểm',
        ];

        $vnedu_file_id = $request->input('file_id');
        $vnedu_file = $this->vneduFileRepos->find($vnedu_file_id);
        if (!$vnedu_file) return abort(404);

        return view('admin.sections.scoreboard-import.index')->with([
            'vnedu_file_id' => $vnedu_file_id,
            'menu' => $menu
        ]);
    }

    public function coordinate_presets() {
        $menu = [
            'sidebar' => 'dashboard',
            'breadcrumb' => 'Trang chủ',
        ];

        return view('admin.sections.coordinate-presets.index')->with(['menu' => $menu]);
    }
}
