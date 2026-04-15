<?php

use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->middleware('throttle:60,1')->group(function () {
    Route::prefix('/users')->name('users.')->controller(UsersController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});
