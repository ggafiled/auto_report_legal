<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Services\Exports\LegalTasksExport;
use App\Models\Task;
use Maatwebsite\Excel\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    return (new LegalTasksExport)->download('legal_report.xlsx');
});

Route::get('/report', function () {
    return Task::with('category', 'assigned_to')
    ->select(['id', 'title', 'description','created_at', 'last_updated', 'category', 'assigned_to', 'addonstatus'])
    ->where('created_at', '>=', '2021-11-11')
    ->where('created_at', '<=', '2021-11-13')
    ->get()
    ->toArray();
});
