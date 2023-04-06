<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
        $lesson->status = 'booked'; // Set the status to 'booked' when book a new lesson is
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

    public function getBookedSlots($teacherId)
    {
        $bookedLessons = Lesson::where('teacherId', $teacherId)->get();

        $bookedSlots = [];

        foreach ($bookedLessons as $lesson) {
            // $start = Carbon::parse($lesson->startDateTime); // booked time slot temp fix to properly display "9:00 - 10:00" otherwise start time duplicates
            $end = Carbon::parse($lesson->endDateTime);
            $bookedSlots[] = [
                'title' => $end->format('g:i'), // booked time slot temp fix, can not include start time in title or it duplicates
                'start' => $lesson->startDateTime,
                'end' => $lesson->endDateTime,
                'backgroundColor' => 'red',
                'textColor' => 'white',
                'editable' => false,
            ];
        }

        return response()->json($bookedSlots);
    }

    public function checkLessonConflict(Request $request)
    {
        $studentId = $request->input('studentId');
        $startDateTime = $request->input('startDateTime');

        $conflictingLesson = Lesson::where('studentId', $studentId)
            ->where('startDateTime', $startDateTime)
            ->with('teacher')
            ->first();

        if ($conflictingLesson) {
            return response()->json([
                'conflict' => true,
                'lesson' => $conflictingLesson,
                'teacher_firstname' => $conflictingLesson->teacher->firstname,
                'teacher_lastname' => $conflictingLesson->teacher->lastname
            ]);
        } else {
            return response()->json([
                'conflict' => false
            ]);
        }
    }

    public function teacherLessonManager()
    {
        // Fetch unpaid lessons for the teacher
        $unpaidLessons = Lesson::where('teacherId', Auth::id())
            ->where('status', 'booked')
            ->where('paymentConfirmation', 0)
            ->orderBy('startDateTime')
            ->get();
    
        // Fetch paid lessons for the teacher
        $paidLessons = Lesson::where('teacherId', Auth::id())
            ->where('status', 'booked')
            ->where('paymentConfirmation', 1)
            ->orderBy('startDateTime')
            ->get();
    
        // Add the student name to each unpaid and paid lesson
        foreach ($unpaidLessons as $lesson) {
            $lesson->studentName = $lesson->student->firstname . ' ' . $lesson->student->lastname;
        }
        foreach ($paidLessons as $lesson) {
            $lesson->studentName = $lesson->student->firstname . ' ' . $lesson->student->lastname;
        }
    
        // Fetch the canceled lessons for the teacher
        $canceledLessons = Lesson::where('teacherId', Auth::id())
            ->where('status', 'cancelled')
            ->orderBy('startDateTime')
            ->get();
    
        // Add the student name to each canceled lesson
        foreach ($canceledLessons as $lesson) {
            $lesson->studentName = $lesson->student->firstname . ' ' . $lesson->student->lastname;
        }
    
        return view('teacher_lessonmanager', compact('unpaidLessons', 'paidLessons', 'canceledLessons'));
    }


    // Teacher can delete unpaid lessons if they are not older than currentDateTime
    public function cancelLesson(Request $request, $lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);

        // Check if the authenticated user is the teacher for the lesson
        if (Auth::id() !== $lesson->teacherId) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to cancel this lesson.']);
        }

        // Update the lesson status to 'cancelled' and log the cancellation timestamp
        $lesson->status = 'cancelled';
        $lesson->cancelTS = Carbon::now(); // Add this line to log the cancellation timestamp
        $lesson->save();

        return redirect()->back()->with('success', 'Lesson has been canceled successfully.');
    }
}