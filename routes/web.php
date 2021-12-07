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
    $legal_task = Task::with('ref_category', 'ref_assigned_to', 'ref_status')
    ->select(['id', 'title', 'description','created_at', 'last_updated', 'category', 'assigned_to', 'status','addonstatus'])
    ->whereIn('status', [3,4])
    ->whereRaw('NOT (created_at > SUBDATE(CURRENT_DATE(),INTERVAL 1 YEAR) AND created_at <= CURRENT_DATE())')
    ->paginate(100);
    return $legal_task;
});
