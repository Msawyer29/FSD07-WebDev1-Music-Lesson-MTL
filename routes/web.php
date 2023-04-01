<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CalendarController;

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
    Route::get('/dashboard', [CalendarController::class, 'index'])->middleware('student')->name('dashboard');

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

// Render the lesson booking form
Route::get('/booklesson', [LessonController::class, 'create'])->middleware('auth')->name('booklesson');

// Process the lesson booking form submission
Route::post('/booklesson', [LessonController::class, 'store'])->middleware('auth')->name('booklesson.store');

Route::post('/lessons', [LessonController::class, 'store'])->middleware('auth')->name('lessons.store');

// After successful submission, redirect to dashboard
Route::get('/booklesson/success', function () {
    return redirect()->route('dashboard');
})->middleware('auth')->name('booklesson.success');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
