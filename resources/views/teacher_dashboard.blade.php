<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<x-app-layout>
    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Teacher Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12 custom-wrapper">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __('Hello ') }}{{ Auth::user()->firstname }},{{ __(" you're logged in as a ") }}{{ Auth::user()->role }}{{ __('.') }}
                        {{ __('On your dashboard calendar, booked lessons appear ') }}<span style="font-weight: bold; color: #4299e1;">{{ __('blue') }}</span>{{ __(' while canceled lessons are in ') }}<span style="font-weight: bold; color: #f56565;">{{ __('red') }}</span>{{ __('.') }}
                    </div>                    
                </div>
            </div>
        </div>

        <div class="dashboard-calendar-container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card dashboard-card">
                        <div class="card-header">Lesson Calendar</div>

                        <div class="card-body dashboard-calendar" style="padding-bottom: 2rem;">
                            <div id="teacher-dashboard-calendar"></div>
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
    var calendarEl = document.getElementById('teacher-dashboard-calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
        initialView: 'dayGridMonth',
        height: 'auto',
        contentHeight: 'auto',
        eventClassNames: function(arg) {
            //By including the 'status' field in the events array in teacherDashboard function in CalendarController, you can now access it in the JavaScript 
            if (arg.event.extendedProps.status === 'cancelled') { 
                return ['cancelled-event'];
            } else if (arg.event.extendedProps.past) {
                return ['past-event'];
            } else {
                return ['booked-event'];
            }
        },
        events: {!! isset($teacherEvents) ? json_encode($teacherEvents) : '[]' !!}
    });

    calendar.render();
});
        </script>
    @endsection
</x-app-layout>
