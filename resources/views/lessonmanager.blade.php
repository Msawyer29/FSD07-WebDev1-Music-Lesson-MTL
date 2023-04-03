<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<x-app-layout>
    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('Lesson Manager') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                        <span>
                            {{ __('Hello ') }}{{ Auth::user()->firstname }},{{ __(' here you can modify, cancel and manage payments for your lessons.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Unpaid Lessons</div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Lesson Id</th>
                                            <th>Lesson Date</th>
                                            <th>Teacher</th>
                                            <th>Lesson Type</th>
                                            <th>Date Booked</th>
                                            <th>Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($unpaidLessons as $lesson)
                                            <tr>
                                                <td>{{ $lesson->id }}</td>
                                                <td>{{ $lesson->startDateTime }}</td>
                                                <td>{{ $lesson->teacher->firstname }} {{ $lesson->teacher->lastname }}</td>
                                                <td>{{ $lesson->lessonType }}</td>
                                                <td>{{ $lesson->bookingTS }}</td>
                                                <td>
                                                    <form action="{{ route('payment.initiate', ['lessonId' => $lesson->id]) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="lessonId" value="{{ $lesson->id }}">
                                                        <button type="submit" class="btn btn-primary">Pay Now</button>
                                                    </form>
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
    @endsection
</x-app-layout>
