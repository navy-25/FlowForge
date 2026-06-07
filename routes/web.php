<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/users', function () {
    return view('pages.users');
})->name('admin.users');

Route::name('admin.')->group(function () {
    Route::prefix('/dashboard')->name('dashboard.')->controller(MonitorController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
    Route::prefix('/workflow')->name('workflow.')->controller(WorkflowController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::post('{id}/run', 'run')->name('run');
    });
    Route::prefix('/history')->name('history.')->controller(HistoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});
