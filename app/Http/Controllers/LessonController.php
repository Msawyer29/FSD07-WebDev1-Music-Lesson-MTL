<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = [];

        $lessonsData = Lesson::with(['student', 'teacher'])->get();

        foreach ($lessonsData as $lesson) {
            $lessons[] = [
                'title' => $lesson->student->first_name . ' ' . $lesson->student->last_name . ' (' . $lesson->teacher->first_name . ' ' . $lesson->teacher->last_name . ')',
                'start' => $lesson->startDateTime,
                'end' => $lesson->endDateTime,
            ];
        }

        $teachers = User::where('role', 'teacher')->get();
        $students = User::where('role', 'student')->get();

        return view('calendar', compact('lessons', 'teachers', 'students'));
    }

    public function store(Request $request)
    {
        $lesson = new Lesson();
        $lesson->startDateTime = $request->query('date'); // populated from calendar page when student clicks book now
        $lesson->teacherId = $request->input('teacherId');
        $lesson->studentId = Auth::user()->id; // studentId is populated from the currently logged in user
        $lesson->lessonType = $request->input('lessonType');
        $lesson->status = $request->input('status');
        $lesson->paymentConfirmation = $request->input('paymentConfirmation') ? true : false;
        $lesson->bookingTS = now(); // Store the current timestamp as the booking timestamp
        $lesson->save();

        return redirect()->route('calendar.index')->with('success', 'Lesson booked successfully!');
    }

    const LESSON_TYPES = ['guitar', 'bass', 'piano', 'vocal'];
    
    public function create(Request $request)
    {
        $teachers = User::where('role', 'teacher')->get();
        $lessonTypes = self::LESSON_TYPES;

        return view('booklesson', compact('teachers', 'lessonTypes'));
    }
}
