<?php

namespace App\Http\Controllers\Admin;

use Excel;
use Exception;
use App\Imports\VneduImport;
use Illuminate\Http\Request;
use App\Exports\RecordExport;
use App\Imports\ScoreboardImport;
use App\Http\Controllers\Controller;

class ExcelController extends Controller
{
    public function excelImport(Request $request) {
        $file = $request->file('excel');
        if (!$file) {
            return back()->with('noty', [
                'type' => 'error',
                'message' => 'Chưa chọn file excel',
            ]);
        }

        $extension = $file->getClientOriginalExtension();
        if ($extension == 'xlsx') {
            $import = new ScoreboardImport();
        } else {
            $filename = basename($file->getClientOriginalName(), '.xls');
            $import = new VneduImport($filename);
        }
        Excel::import($import, $file);

        if (isset($import->ErrorMessage) && $import->ErrorMessage != '') {
            return back()->with('noty', [
                'type' => 'error',
                'message' => $import->ErrorMessage,
            ]);
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
