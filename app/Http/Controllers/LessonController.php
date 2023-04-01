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
        $lesson->startDateTime = $request->input('startDateTime'); // Get the startDateTime from calendar page when student clicks book now
        $lesson->teacherId = $request->input('teacherId');
        $lesson->studentId = Auth::user()->id; // studentId is populated from the currently logged in user
        $lesson->lessonType = $request->input('lessonType');
        $lesson->status = 'booked'; // Set the status to 'booked' when creating a new lesson
        $lesson->paymentConfirmation = false;
        $lesson->bookingTS = now(); // Store the current timestamp as the booking timestamp
        $lesson->save();

        // Redirect back to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Lesson booked successfully!');
    }

    const LESSON_TYPES = ['guitar', 'bass', 'piano', 'vocal'];

    public function create(Request $request)
    {
        $teachers = User::where('role', 'teacher')->get();
        $lessonTypes = self::LESSON_TYPES;

        $lessons = Lesson::all(); // Fetch all lessons from the database

        return view('booklesson', compact('teachers', 'lessonTypes', 'lessons'));
    }
}
