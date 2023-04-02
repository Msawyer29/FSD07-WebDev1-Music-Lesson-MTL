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
}
