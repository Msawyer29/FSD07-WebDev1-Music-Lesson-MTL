<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Book a Lesson') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Hello ') }}{{ Auth::user()->firstname }},{{ __(" you're logged in as a ") }}{{ Auth::user()->role }}{{ __('.') }}
                </div>
            </div>
        </div>
    </div>

    <form id="lesson-form" method="POST" action="{{ route('lessons.store') }}">
        @csrf
        <div id="lesson-form-container">
            <input type="hidden" name="startDateTime" value="">
            <label for="teacherName">Teacher:</label>
            <select id="teacherName" name="teacherId" required>
                <option value="">Select a teacher</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->firstname . ' ' . $teacher->lastname }}</option>
                @endforeach
            </select>
            <input type="hidden" id="studentId" name="studentId" value="{{ Auth::user()->id }}">
            <label for="lessonType">Lesson Type:</label>
            <select id="lessonType" name="lessonType" required>
                <option value="">Select a lesson type</option>
                @foreach ($lessonTypes as $lessonType)
                    <option value="{{ $lessonType }}">{{ ucfirst($lessonType) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" id="book-now-button">Book Now</button>
        </div>
    </form>

    <div id="calendar-container">
        <div id="calendar"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.5/index.global.min.js"></script>
    <script>
        function formatDate(date) {
            const dateFormatter = new Intl.DateTimeFormat('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false,
            });
            const parts = dateFormatter.formatToParts(date);
            const formattedDate =
                `${parts[4].value}-${parts[0].value}-${parts[2].value}T${parts[6].value}:${parts[8].value}:${parts[10].value}`;
            return formattedDate;
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var lessonForm = document.getElementById('lesson-form');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                initialView: 'timeGridWeek',
                slotMinTime: '09:00:00',
                slotMaxTime: '18:00:00',
                slotLabelInterval: '01:00:00',
                slotDuration: '01:00:00',
                slotLabelFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                },
                allDaySlot: false,
                height: 'auto',
                contentHeight: 'auto',
                selectable: true,
                unselectAuto: false,
                select: function(info) {
                    var startDateTimeInput = document.getElementsByName('startDateTime')[0];
                    var selectedEvents = calendar.getEvents();

                    // remove any previously selected events
                    selectedEvents.forEach(function(selectedEvent) {
                        selectedEvent.remove();
                    });

                    // add the new event
                    var newEvent = {
                        id: formatDate(info.start),
                        start: info.start,
                        end: info.end,
                        backgroundColor: 'blue',
                        textColor: 'white'
                    };
                    calendar.addEvent(newEvent);

                    // set the startDateTime input value to the selected date and time
                    startDateTimeInput.value = formatDate(info.start);


                    // Log the value to the console for debugging purposes
                    console.log('startDateTime value:', startDateTimeInput.value);

                    // enable the book-now button
                    var bookNowBtn = document.getElementById('book-now-button');
                    bookNowBtn.disabled = false;
                    bookNowBtn.classList.remove('disabled');
                },
            });

            calendar.render();

            // Add a submit event listener to the lesson form
            lessonForm.addEventListener('submit', function(event) {
                var startDateTimeInput = document.getElementsByName('startDateTime')[0];

                // Log the startDateTime value to the console for debugging purposes
                console.log('Form submitted with startDateTime value:', startDateTimeInput.value);

                // If the startDateTime value is empty, prevent form submission and display an alert
                if (!startDateTimeInput.value) {
                    event.preventDefault();
                    alert('Please select a time slot before submitting the form.');
                }
            });
        });
    </script>
</x-app-layout>