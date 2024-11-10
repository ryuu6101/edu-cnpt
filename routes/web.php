<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ExcelController;
use App\Http\Controllers\Admin\SectionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'login')->name('login');

Route::middleware('guest')->group(function() {
    Route::get('login', [LoginController::class, 'index'])->name('login.index');
    Route::post('login', [LoginController::class, 'authenticate'])->name('login.auth');
});

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('admin')->group(function () {
        Route::redirect('/', 'admin/dashboard', 301)->name('admin');
        Route::get('dashboard', [SectionController::class, 'dashboard'])->name('dashboard.index');
        Route::post('excel/import', [ExcelController::class, 'excelImport'])->name('excel.import');
        Route::get('excel/export', [ExcelController::class, 'excelExport'])->name('excel.export');

        Route::get('schools', [SectionController::class, 'schools'])->name('schools.index');
        Route::get('classes', [SectionController::class, 'classes'])->name('classes.index');
        Route::get('students', [SectionController::class, 'students'])->name('students.index');
        Route::get('subjects', [SectionController::class, 'subjects'])->name('subjects.index');
        Route::get('vnedu-files', [SectionController::class, 'vnedu_files'])->name('vnedu-files.index');
        Route::get('scoreboard', [SectionController::class, 'scoreboard'])->name('scoreboard.index');
    });
});
