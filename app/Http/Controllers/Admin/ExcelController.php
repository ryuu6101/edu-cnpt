<?php

namespace App\Http\Controllers\Admin;

use Excel;
use Exception;
use App\Imports\VneduImport;
use Illuminate\Http\Request;
use App\Exports\RecordExport;
use App\Imports\HeaderImport;
use App\Imports\StudentImport;
use App\Imports\ScoreboardImport;
use App\Imports\VneduHeaderImport;
use App\Imports\VneduStudentImport;
use App\Http\Controllers\Controller;

class ExcelController extends Controller
{
    public function excelImport(Request $request) {
        $coordinates = $request->input();
        unset($coordinates['_token']);
        unset($coordinates['_method']);
        // dd($coordinates);
        $file = $request->file('excel');
        if (!$file) {
            return back()->with('noty', [
                'type' => 'error',
                'message' => 'Đã xảy ra lỗi!',
            ])->withErrors(['excel-input' => 'Chưa chọn file']);
        }

        $header_import = new HeaderImport($coordinates);
        Excel::import($header_import, $file);

        if ($header_import->ErrorMessage != '') {
            return back()->with('noty', [
                'type' => 'error',
                'message' => 'Đã xảy ra lỗi!',
            ])->withErrors(['excel-input' => $header_import->ErrorMessage]);
        }

        $student_import = new StudentImport($header_import->class, $coordinates);
        Excel::import($student_import, $file);

        if ($student_import->ErrorMessage != '') {
            return back()->with('noty', [
                'type' => 'error',
                'message' => 'Đã xảy ra lỗi!',
            ])->withErrors(['excel-input' => $student_import->ErrorMessage]);
        }

        $params = [
            'department' => $header_import->department,
            'school' => $header_import->school,
            'class' => $header_import->class,
            'semester' => $header_import->semester,
        ];
        $import = new ScoreboardImport($params, $coordinates);
        Excel::import($import, $file);

        if (isset($import->ErrorMessage) && $import->ErrorMessage != '') {
            return back()->with('noty', [
                'type' => 'error',
                'message' => 'Đã xảy ra lỗi!',
            ])->withErrors(['excel-input' => $import->ErrorMessage]);
        }

        return back()->with('noty', [
            'type' => 'success',
            'message' => 'Import thành công',
        ]);
    }

    public function vneduImport(Request $request) {
        $file = $request->file('excel');
        if (!$file) {
            return back()->with('noty', [
                'type' => 'error',
                'message' => 'Đã xảy ra lỗi!',
            ])->withErrors(['excel-input' => 'Chưa chọn file']);
        }

        $vnedu_header_import = new VneduHeaderImport();
        Excel::import($vnedu_header_import, $file);

        if ($vnedu_header_import->ErrorMessage != '') {
            return back()->with('noty', [
                'type' => 'error',
                'message' => 'Đã xảy ra lỗi!',
            ])->withErrors(['excel-input' => $vnedu_header_import->ErrorMessage]);
        }

        $vnedu_student_import = new VneduStudentImport($vnedu_header_import->class);
        Excel::import($vnedu_student_import, $file);

        if ($vnedu_student_import->ErrorMessage != '') {
            return back()->with('noty', [
                'type' => 'error',
                'message' => 'Đã xảy ra lỗi!',
            ])->with('student_error', [
                'students' => $vnedu_student_import->students,
                'vnedu_students' => $vnedu_student_import->vnedu_students,
            ])->withErrors(['excel-input' => $vnedu_student_import->ErrorMessage]);
        }

        $filename = basename($file->getClientOriginalName(), '.xls');
        $import = new VneduImport([
            'file_name' => $filename,
            'semester_id' => $vnedu_header_import->semester->id,
            'school_id' => $vnedu_header_import->school->id,
            'class_id' => $vnedu_header_import->class->id,
        ]);
        Excel::import($import, $file);

        if (isset($import->ErrorMessage) && $import->ErrorMessage != '') {
            return back()->with('noty', [
                'type' => 'error',
                'message' => 'Đã xảy ra lỗi!',
            ])->withErrors(['excel-input' => $import->ErrorMessage]);
        }

        return back()->with('noty', [
            'type' => 'success',
            'message' => 'Import thành công',
        ]);
    }

    public function excelExport(Request $request) {
        $number_of_column = $request->input('number_of_column');
        $vnedu_file_id = $request->input('file_id');
        $vnedu_file = \App\Models\VneduFile::find($vnedu_file_id);

        $export = new RecordExport($vnedu_file, $number_of_column);
        return Excel::download($export, $vnedu_file->file_name.'.xls');
    }
}
