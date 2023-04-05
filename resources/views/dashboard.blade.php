<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<x-app-layout>
    @section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                    <span>
                        {{ __('Hello ') }}{{ Auth::user()->firstname }},{{ __(" you're logged in as a ") }}{{ Auth::user()->role }}{{ __('.') }}
                    </span>
                    @if (session('success'))
                        <span class="text-green-700">
                            {{ session('success') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

        <div class="dashboard-calendar-container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card dashboard-card">
                        <div class="card-header">Your Booked Lessons</div>

                        <div class="card-body dashboard-calendar">
                            <div id="dashboard-calendar"></div>
                            <div class="text-center mt-3">
                                <a href="{{ route('booklesson') }}" class="btn dashboard-book-a-lesson-btn make-a-payment-button ml-3">Book a Lesson</a>
                                <a href="{{ route('lessonmanager') }}" class="btn make-a-payment-button">Make a Payment</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.5/index.global.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('dashboard-calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                    initialView: 'dayGridMonth',
                    height: 'auto',
                    contentHeight: 'auto',
                    events: {!! isset($events) ? json_encode($events) : '[]' !!}
                });

                calendar.render();
            });
        </script>
    @endsection
</x-app-layout>
