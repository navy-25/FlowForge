<?php

use App\Http\Controllers\Api\WorkflowController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->middleware('throttle:60,1')->group(function () {
    Route::prefix('workflows')->name('workflows.')->group(function () {
        Route::get('/stress-test', [WorkflowController::class, 'stressTest']);
        Route::get('/', [WorkflowController::class, 'index']);
        Route::post('/', [WorkflowController::class, 'store']);
        Route::post('{id}/run', [WorkflowController::class, 'run']);
    });
});
