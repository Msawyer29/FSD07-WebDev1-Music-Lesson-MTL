@php
    use Carbon\Carbon;
@endphp

<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<x-app-layout>
    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('Teacher Lesson Manager') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-center items-center flex-col">
                        <span class="text-center">
                            {{ __('Hello ') }}{{ Auth::user()->firstname }},{{ __(' in your lesson manager you can view unpaid lessons, view paid lessons, and cancel unpaid lessons.') }}
                        </span>
                        @if (session('success'))
                            <div class="mt-4 text-green-700 font-bold text-center">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header unpaid-lessons-header">Unpaid Lessons</div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-wrapper">
                                    <table class="table table-bordered table-striped lesson-manager-table">
                                        <thead>
                                            <tr>
                                                <th>Lesson Id</th>
                                                <th>Lesson Date & Time</th>
                                                <th>Student</th>
                                                <th>Lesson Type</th>
                                                <th>Date & Time Booked</th>
                                                <th>Cancel</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($unpaidLessons as $lesson)
                                                <tr>
                                                    <td>{{ $lesson->id }}</td>
                                                    <td>{{ Carbon::parse($lesson->startDateTime)->format('F j, Y, g:i a') }}
                                                    </td>
                                                    <td>{{ $lesson->student->firstname }} {{ $lesson->student->lastname }}
                                                    </td>
                                                    <td>{{ $lesson->lessonType }}</td>
                                                    <td>{{ Carbon::parse($lesson->bookingTS)->format('F j, Y, g:i a') }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if (Carbon::now()->isBefore($lesson->startDateTime))
                                                            <form
                                                                action="{{ route('teacher.cancel_lesson', ['lessonId' => $lesson->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="lessonId"
                                                                    value="{{ $lesson->id }}">
                                                                <button type="submit" class="cancel-button">Cancel</button>
                                                            </form>
                                                        @else
                                                            <span class="text-red-600">Cannot cancel past lessons</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header paid-lessons-header">Paid Lessons</div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-wrapper">
                                    <table class="table table-bordered table-striped lesson-manager-table">
                                        <thead>
                                            <tr>
                                                <th>Lesson Id</th>
                                                <th>Lesson Date & Time</th>
                                                <th>Student</th>
                                                <th>Lesson Type</th>
                                                <th>Date & Time Booked</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($paidLessons as $lesson)
                                                <tr>
                                                    <td>{{ $lesson->id }}</td>
                                                    <td>{{ Carbon::parse($lesson->startDateTime)->format('F j, Y, g:i a') }}
                                                    </td>
                                                    <td>{{ $lesson->student->firstname }} {{ $lesson->student->lastname }}
                                                    </td>
                                                    <td>{{ $lesson->lessonType }}</td>
                                                    <td>{{ Carbon::parse($lesson->bookingTS)->format('F j, Y, g:i a') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header canceled-lessons-header">Canceled Lessons</div>
                
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-wrapper">
                                    <table class="table table-bordered table-striped lesson-manager-table">
                                        <thead>
                                            <tr>
                                                <th>Lesson Id</th>
                                                <th>Lesson Date & Time</th>
                                                <th>Student</th>
                                                <th>Lesson Type</th>
                                                <th>Date & Time Canceled</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($canceledLessons as $lesson)
                                                <tr>
                                                    <td>{{ $lesson->id }}</td>
                                                    <td>{{ Carbon::parse($lesson->startDateTime)->format('F j, Y, g:i a') }}
                                                    </td>
                                                    <td>{{ $lesson->student->firstname }} {{ $lesson->student->lastname }}
                                                    </td>
                                                    <td>{{ $lesson->lessonType }}</td>
                                                    <td>{{ Carbon::parse($lesson->cancelTS)->format('F j, Y, g:i a') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
