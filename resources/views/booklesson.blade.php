<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<x-app-layout>
    @yield('content')

    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('Book a Lesson') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __('Hello ') }}{{ Auth::user()->firstname }}, you can book a lesson anytime 9-5, Monday-Friday!
                        Please select a teacher to view their availability. Unavailable time slots are marked in red.
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
    @endsection

    @yield('scripts')
    @section('scripts')
        <!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.5/index.global.min.js"></script>
        <script>
            function checkLessonConflict(teacherId, studentId, startDateTime, callback) {
                $.ajax({
                    url: `/booklesson/check-lesson-conflict`,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'teacherId': teacherId,
                        'studentId': studentId,
                        'startDateTime': startDateTime
                    },
                    success: function(data) {
                        if (data.conflict) {
                            let teacherFirstName = data.lesson.teacher.firstname;
                            let teacherLastName = data.lesson.teacher.lastname;

                            // Display the error message with the teacher's name
                            alert(
                                `You cannot book a lesson in that time slot, you have a lesson booked at that time with the teacher (${teacherFirstName} ${teacherLastName}).`);
                        } else {
                            // Proceed with the booking process if there is no conflict
                            callback();
                        }
                    },
                    error: function(error) {
                        console.error('Error checking lesson conflict:', error);
                    }
                });
            }

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

            // Declare the calendar and lessonForm variables outside the event listener
            var calendar;
            var lessonForm;

            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                lessonForm = document.getElementById('lesson-form');
                calendar = new FullCalendar.Calendar(calendarEl, {
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
                        // Check if the selected date is in the past
                        if (info.start < new Date()) {
                            alert("You cannot book a lesson in the past.");
                            return;
                        }

                        var startDateTimeInput = document.getElementsByName('startDateTime')[0];
                        var selectedEvents = calendar.getEvents();

                        // remove only the previously selected events (with a blue background)
                        selectedEvents.forEach(function(selectedEvent) {
                            if (selectedEvent.backgroundColor === 'blue') {
                                selectedEvent.remove();
                            }
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
                    selectAllow: function(selectInfo) {
                        var currentDate = new Date();
                        var selectedDate = selectInfo.start;

                        // Check if the selected date is a weekend
                        if (selectedDate.getDay() === 0 || selectedDate.getDay() === 6) {
                            return false;
                        }

                        // Check if the selected date is in the past
                        if (selectedDate < currentDate) {
                            return false;
                        }

                        return true;
                    }
                });

                calendar.render();

                // Add a submit event listener to the lesson form, checks for lesson conflict and makes sure timeslot is selected
                lessonForm.addEventListener('submit', function(event) {
                    event.preventDefault();

                    var teacherId = document.getElementById('teacherName').value;
                    var studentId = document.getElementById('studentId').value;
                    var startDateTimeInput = document.getElementsByName('startDateTime')[0];
                    var startDateTime = startDateTimeInput.value;

                    if (!startDateTime) {
                        alert('Please select a time slot before submitting the form.');
                        return;
                    }

                    checkLessonConflict(teacherId, studentId, startDateTime, function(conflict, lesson) {
                        if (conflict) {
                            alert('You cannot book a lesson in that time slot, you have a lesson booked at that time with the teacher (' +
                                lesson.teacher.first_name + ' ' + lesson.teacher.last_name + ').');
                        } else {
                            lessonForm.submit();
                        }
                    });
                });

            });

            // updatedBookedSlots shows selected Teacher's booked slots in red
            function updateBookedSlots(teacherId, calendar) {
                // Clear the previous events from the calendar
                calendar.getEvents().forEach(event => event.remove());

                // If a teacher is selected, fetch the booked slots and render them on the calendar
                if (teacherId) {
                    $.ajax({
                        url: `/booklesson/get-booked-slots/${teacherId}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            data.forEach(function(slot) {
                                calendar.addEvent(slot);
                            });
                        },
                        error: function(error) {
                            console.error('Error fetching booked slots:', error);
                        }
                    });
                }
            }

            // Add a change event listener for the teacherName select element
            $('#teacherName').on('change', function() {
                updateBookedSlots($(this).val(), calendar);
            });
        </script>
    @endsection
</x-app-layout>