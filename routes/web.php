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
<<<<<<< HEAD
            ->select(['id', 'title', 'description','created_at', 'last_updated', 'category', 'status','assigned_to', 'addonstatus'])
=======
            ->select(['id', 'title', 'description','created_at', 'last_updated', 'category', 'assigned_to', 'addonstatus'])
>>>>>>> 8d4a358bd4c503b99b95d77a021fca5169814748
            ->where('created_at', '>=', Carbon::now()->subYears(1)->toDateString())
            ->where('created_at', '<=', Carbon::now()->toDateString())
            ->where('category', '=', 0)
            ->first();
<<<<<<< HEAD
    return [$legal_task, !is_null($legal_task->ref_category)];
=======
    return $legal_task;
>>>>>>> 8d4a358bd4c503b99b95d77a021fca5169814748
});
