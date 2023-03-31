<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LessonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('Role-test', [UserController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // STUDENT DASHBOARD
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('student')->name('dashboard');

    // TEACHER DASHBOARD
    Route::get('/teacher_dashboard', function () {
        return view('teacher_dashboard');
    })->middleware('teacher')->name('teacher_dashboard');

    // ADMIN DASHBOARD
    Route::get('/admin_dashboard', function () {
        return view('admin_dashboard');
    })->middleware('admin')->name('admin_dashboard');
});

Route::get('/about', function () {
    return view('about');
});

// CALENDAR PAGE
Route::get('/calendar', [LessonController::class, 'index'])->middleware(['auth'])->name('calendar');

// BOOK LESSON FORM SUBMISSION
Route::get('/booklesson', [LessonController::class, 'create'])->middleware('auth')->name('booklesson');
Route::post('/booklesson', [LessonController::class, 'store'])->middleware('auth')->name('lessons.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
