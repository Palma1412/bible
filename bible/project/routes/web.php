<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/moonshine/report/generate', [\App\Http\Controllers\ReportController::class, 'generate'])
    ->name('moonshine.report.generate');
Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
