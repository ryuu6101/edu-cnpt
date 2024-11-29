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
        $coordinates = $request->validate([
            'subject_cell' => ['required', 'regex:/^[A-Z]{1}[0-9]+$/'],
            'starting_row' => ['required', 'gt:0'],
        ],[
            'subject_cell.required' => 'Chưa nhập vị trí',
            'subject_cell.regex' => 'Vị trí không hợp lệ',
            'starting_row.required' => 'Chưa nhập vị trí',
            'starting_row.gt' => 'Vui lòng nhập giá trị > 0',
        ]);
        $vnedu_file_id = $request->input('vnedu_file_id');
        $file = $request->file('excel');
        // dd($coordinates, $request->input(), $file);
        if (!$file) {
            return back()->with('noty', [
                'type' => 'error',
                'message' => 'Đã xảy ra lỗi!',
            ])->withErrors(['excel-input' => 'Chưa chọn file']);
        }

        $import = new ScoreboardImport($vnedu_file_id, $coordinates);
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
        ])->with('error_reports', $import->ErrorReports);
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

        // $vnedu_student_import = new VneduStudentImport($vnedu_header_import->class);
        // Excel::import($vnedu_student_import, $file);

        // if ($vnedu_student_import->ErrorMessage != '') {
        //     return back()->with('noty', [
        //         'type' => 'error',
        //         'message' => 'Đã xảy ra lỗi!',
        //     ])->with('student_error', [
        //         'students' => $vnedu_student_import->students,
        //         'vnedu_students' => $vnedu_student_import->vnedu_students,
        //     ])->withErrors(['excel-input' => $vnedu_student_import->ErrorMessage]);
        // }

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
        $vnedu_file_id = $request->input('file_id');
        $vnedu_file = \App\Models\VneduFile::find($vnedu_file_id);

        $export = new RecordExport($vnedu_file);
        return Excel::download($export, $vnedu_file->file_name.'.xls');
    }
}
