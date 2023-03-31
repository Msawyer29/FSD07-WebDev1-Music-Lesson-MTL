<style>
    #calendar {
        max-width: 800px;
        margin: 0 auto;
        border: 2px solid #ddd;
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        margin-bottom: 50px;
        padding: 20px;
    }

    #calendar-container {
        background-color: gray-800;
        border-radius: 10px;
        padding: 20px;
    }

    .fc-time-grid-event {
        background-color: #a6d8f5;
    }

    #book-now-button {
        display: block;
        margin: 0 auto;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        padding: 10px 20px;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lesson Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in as Student!") }}
                </div>
            </div>
        </div>
    </div>

    <div id="calendar-container">
        <div id="calendar"></div>
        <button id="book-now-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('Book Now') }}
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.5/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                initialView: 'timeGridWeek',
                slotMinTime: '08:00:00',
                slotMaxTime: '17:00:00',
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
                    var selectedEvents = calendar.getEvents();

                    // remove any previously selected events
                    selectedEvents.forEach(function(selectedEvent) {
                        selectedEvent.remove();
                    });

                    // add the new event
                    var newEvent = {
                        id: info.start.toISOString(),
                        start: info.start,
                        end: info.end,
                        backgroundColor: 'blue',
                        textColor: 'white'
                    };
                    calendar.addEvent(newEvent);

                    // enable the book-now button
                    document.getElementById('book-now-button').disabled = false;
                    document.getElementById('book-now-button').classList.remove('disabled');
                },
                events: @json($lessons),
            });

            calendar.render();

            document.getElementById('book-now-button').addEventListener('click', function() {
                var selectedEvents = calendar.getEvents();

                if (selectedEvents.length > 0) {
                    var selectedEvent = selectedEvents[0];

                    window.location.href = "{{ route('booklesson') }}" + "?date=" + selectedEvent.start
                        .toISOString();
                }
            });
        });
    </script>
</x-app-layout>
