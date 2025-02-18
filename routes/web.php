<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');

    Route::resource('categories', CategoryController::class);
});


Route::get('/admin/register', [AdminRegisterController::class, 'showRegistrationForm'])
    ->name('admin.register');

Route::post('/admin/register', [AdminRegisterController::class, 'register']);
