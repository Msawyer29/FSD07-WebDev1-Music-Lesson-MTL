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
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Calendar') }}
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.5/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                events: @json($lessons),
            });
            calendar.render();
        });
    </script>
</x-app-layout>