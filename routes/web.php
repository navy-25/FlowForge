<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('admin.dashboard');

Route::get('/users', function () {
    return view('pages.users');
})->name('admin.users');

Route::get('/workflow', function () {
    return view('pages.workflow');
})->name('admin.workflow');

Route::get('/history', function () {
    return view('pages.history');
})->name('admin.history');
