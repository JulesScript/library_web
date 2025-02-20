<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    // If the user is authenticated, redirect to the dashboard
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    // Otherwise, show the login page
    return view('auth.login'); 
})->name('home');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // ✅ Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::get('/settings', function () {
            return view('settings');
        })->name('settings');

        Route::resource('settings-categories', CategoryController::class);
        Route::resource('settings-courses', CoursesController::class);
        Route::resource('settings-researches', ResearchController::class)->names('settings.researches');
    });

    // ✅ Normal users can see research files but can't manage them
    Route::get('/researches', [ResearchController::class, 'index'])->name('researches.index');

    // ✅ Public access for categories and courses (view-only)
    Route::resource('show-categories', CategoryController::class)->only(['index', 'show'])->names([
        'index' => 'categories.show.index',  
        'show' => 'categories.show.show',    
    ]);

    Route::resource('show-courses', CoursesController::class)->only(['index', 'show'])->names([
        'index' => 'courses.show.index',  
        'show' => 'courses.show.show',    
    ]);

    // ✅ Course filtering for all users
    Route::get('/courses/filter', [CoursesController::class, 'filterCourses'])->name('courses.filter');
    
});


Route::get('/admin/register', [AdminRegisterController::class, 'showRegistrationForm'])
    ->name('admin.register');

Route::post('/admin/register', [AdminRegisterController::class, 'register']);
