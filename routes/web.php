<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('auth/login');
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

    Route::resource('settings-categories', CategoryController::class);
    Route::resource('show-categories', CategoryController::class)->only(['index', 'show'])->names([
        'index' => 'categories.show.index',  // Use a custom name to avoid conflicts
        'show' => 'categories.show.show',    // For the show method
    ]);

});


Route::get('/admin/register', [AdminRegisterController::class, 'showRegistrationForm'])
    ->name('admin.register');

Route::post('/admin/register', [AdminRegisterController::class, 'register']);
