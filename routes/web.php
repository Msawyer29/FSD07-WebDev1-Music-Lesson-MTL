<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MessagesController;

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

//---------- BOOK LESSON ROUTES ----------//
// Render the lesson booking form
Route::get('/booklesson', [LessonController::class, 'create'])->middleware('auth')->name('booklesson');

// Process the lesson booking form submission
Route::post('/booklesson', [LessonController::class, 'store'])->middleware('auth')->name('booklesson.store');

Route::post('/lessons', [LessonController::class, 'store'])->middleware('auth')->name('lessons.store');

// After successful submission, redirect to dashboard
Route::get('/booklesson/success', function () {
    return redirect()->route('dashboard');
})->middleware('auth')->name('booklesson.success');

// Route for AJAX request to fetch the booked slots for the selected teacher and render them on the calendar
Route::get('/booklesson/get-booked-slots/{teacherId}', [LessonController::class, 'getBookedSlots']);

//Route to check for lesson conflict when student books lesson (check if lesson exists with other teacher at that time)
Route::post('/booklesson/check-lesson-conflict', [LessonController::class, 'checkLessonConflict'])->name('booklesson.check-lesson-conflict');

//---------- LESSON MANAGER ROUTES ----------//
// Route to populate Unpaid Lessons table with all lessons where paymentConfirmation field = 0
Route::get('/lessonmanager', [CalendarController::class, 'unpaidLessons'])->name('lessonmanager');

//---------- LESSON PAYMENT ROUTES ----------//
Route::post('/payment-initiate/{lessonId}', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
Route::post('/payment-process', [PaymentController::class, 'processPayment'])->name('payment.process');
//Route::get('/lessonmanager', [PaymentController::class, 'success'])->name('lessonmanager');

//----------MESSENGER--------------------//
Route::group(['middleware' => 'auth', 'prefix' => 'messages', 'as' => 'messages'], function () {
Route::get('/', [MessagesController::class, 'index']);
Route::get('/create', [MessagesController::class, 'create'])->name('.create');
Route::post('/', [MessagesController::class, 'store'])->name('.store');
Route::get('/{thread}', [MessagesController::class, 'show'])->name('.show');
Route::put('/{thread}', [MessagesController::class, 'update'])->name('.update');
Route::delete('/{thread}', [MessagesController::class, 'destroy'])->name('.destroy');
});

//-------------PROFILE---------------//
Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
