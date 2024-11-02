<?php

namespace App\Http\Controllers\Admin;

use Excel;
use App\Imports\VneduImport;
use Illuminate\Http\Request;
use App\Exports\RecordExport;
use App\Imports\ScoreboardImport;
use App\Http\Controllers\Controller;

class ExcelController extends Controller
{
    public function excelImport(Request $request) {
        $file = $request->file('excel');
        $extension = $file->getClientOriginalExtension();
        if ($extension == 'xlsx') {
            $import = new ScoreboardImport();
        } else {
            $vnedu_file = \App\Models\VneduFile::firstOrCreate(['file_name' => basename($file->getClientOriginalName(), '.xls')]);
            $import = new VneduImport($vnedu_file);
        }
        Excel::import($import, $file);

        return back();
    }

    public function excelExport(Request $request) {
        $vnedu_file_id = $request->input('file_id');
        $vnedu_file = \App\Models\VneduFile::find($vnedu_file_id);

        $export = new RecordExport($vnedu_file);
        return Excel::download($export, $vnedu_file->file_name.'.xls');
    }
}
