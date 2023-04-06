<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        // Get the authenticated student's ID
        $studentId = Auth::id();

        // Get the booked lessons for the student
        $bookedLessons = Lesson::where('studentId', Auth::id())
            ->where('status', 'booked')
            ->where('startDateTime', '>=', Carbon::now())
            ->orderBy('startDateTime')
            ->get();

        // Add the teacher name to each lesson
        foreach ($bookedLessons as $lesson) {
            $lesson->teacherName = $lesson->teacher->firstname . ' ' . $lesson->teacher->lastname;
        }

        // Transform the lessons into an array of events for the calendar
        $events = $bookedLessons->map(function ($lesson) {
            return [
                'title' => $lesson->lessonType . ' lesson - ' . $lesson->teacherName,
                'start' => $lesson->startDateTime,
                'end' => $lesson->endDateTime,
                'backgroundColor' => 'blue',
                'borderColor' => 'black',
                'textColor' => 'white'
            ];
        })->toArray();

        return view('dashboard', compact('events'));
    }
    
    // /lessonmanager routes for populating the paid and unpaid lesson tables for student (I should relocate)
    public function unpaidLessons()
    {
        $studentId = Auth::id();

        $unpaidLessons = Lesson::where('studentId', $studentId)
            ->where('paymentConfirmation', 0)
            ->get();

        $paidLessons = Lesson::where('studentId', $studentId)
            ->where('paymentConfirmation', 1)
            ->get();

        return view('lessonmanager', compact('unpaidLessons', 'paidLessons'));
    }

    // teacher_dashboard Populate Teacher Dashboard Calendar
    public function teacherDashboard()
    {
        // Get authenticated teacherID
        $teacherId = auth()->user()->id;

        // Get all booked lessons for the teacher
        $bookedLessons = Lesson::where('teacherId', Auth::id())
            ->where('status', '!=', 'pending')
            ->orderBy('startDateTime')
            ->get();

        // Add the student name to each lesson
        foreach ($bookedLessons as $lesson) {
            $lesson->studentName = $lesson->student->firstname . ' ' . $lesson->student->lastname;
        }

        // Get the current date and time
        $currentDateTime = Carbon::now();

        // Transform the lessons into an array of events for the teacher calendar
        $teacherEvents = $bookedLessons->map(function ($lesson) {
            return [
                'title' => $lesson->lessonType . ' lesson - ' . $lesson->studentName,
                'start' => $lesson->startDateTime,
                'end' => $lesson->endDateTime,
                'backgroundColor' => 'blue',
                'borderColor' => 'black',
                'textColor' => 'white',
                'status' => $lesson->status,
                'past' => Carbon::parse($lesson->startDateTime)->isPast()
            ];
        })->toArray();

        return view('teacher_dashboard', compact('teacherEvents'));
    }
}
