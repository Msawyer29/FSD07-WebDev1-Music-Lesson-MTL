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
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div>
                            <span>
                                {{ __('Hello ') }}{{ Auth::user()->firstname }},{{ __(" you're logged in as a ") }}{{ Auth::user()->role }}{{ __('.') }}
                                {{ __('On your dashboard calendar, booked lessons appear ') }}<span style="font-weight: bold; color: #4299e1;">{{ __('blue') }}</span>{{ __(' while canceled lessons are in ') }}<span style="font-weight: bold; color: #f56565;">{{ __('red') }}</span>{{ __('.') }}
                            </span>
                        </div>
                        @if (session('success'))
                            <div class="mt-4 text-green-700">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>        

        <div class="dashboard-calendar-container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card dashboard-card">
                        <div class="card-header">Lesson Calendar</div>

                        <div class="card-body dashboard-calendar">
                            <div id="dashboard-calendar"></div>
                            <div class="text-center mt-3">
                                <a href="{{ route('booklesson') }}"
                                    class="btn dashboard-book-a-lesson-btn make-a-payment-button ml-3">Book a Lesson</a>
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
                    eventClassNames: function(arg) {
                        if (arg.event.extendedProps.status === 'cancelled') {
                            return ['cancelled-event'];
                        } else if (arg.event.extendedProps.past) {
                            return ['past-event'];
                        } else {
                            return ['booked-event'];
                        }
                    },
                    events: {!! isset($events) ? json_encode($events) : '[]' !!}
                });

                calendar.render();
            });
        </script>
    @endsection
</x-app-layout>
