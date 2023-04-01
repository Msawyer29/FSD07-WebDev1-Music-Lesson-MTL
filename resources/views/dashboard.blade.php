<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
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

    @section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Booked Lessons</div>

                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                    initialView: 'dayGridMonth',
                    height: 'auto',
                    contentHeight: 'auto',
                    events: {!! isset($events) ? json_encode($events) : '[]' !!},
                });

                calendar.render();
            });
        </script>
    @endsection

</x-app-layout>