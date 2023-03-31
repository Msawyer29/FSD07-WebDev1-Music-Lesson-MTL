<?php

namespace App\Http\Controllers;

use App\Models\Lesson;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = [];

        $lessonsData = Lesson::with(['student', 'teacher'])->get();

        foreach ($lessonsData as $lesson) {
            // Retrieve the related teacher and student models
            $teacher = $lesson->teacher;
            $student = $lesson->student;

            $lessons[] = [
                'title' => $student->name . ' (' . $teacher->name . ')',
                'start' => $lesson->startDateTime,
                'end' => $lesson->endDateTime,
            ];
        }

        return view('calendar', compact('lessons'));
    }
}