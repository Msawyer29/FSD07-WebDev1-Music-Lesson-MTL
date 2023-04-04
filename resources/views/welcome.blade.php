@extends('layouts.layout')
@section('header')

@endsection
@section('content')

<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            @auth
            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex items-center">
                <img src="{{ asset('images/musiclessonmtl_logo.jpg') }}" alt="My Logo" class="mr-4">
                <div class="flex-grow mt-6 p-6 ml-6 border-l-4 border-gray-800">
                    <p class="text-lg leading-relaxed text-gray-700">Welcome to Music Lesson MTL,<br> established in 2023, our mission is to help you achieve your musical goals in a fun and encouraging setting. Our qualified teachers tailor their lessons based on the interests and goals of each student.</p>
                </div>

            </div>

            <div class="mt-16">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <a href="http://musiclessonmtl.fsd07.com/" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div style="text-align: center;">
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            <h1 class="mt-6 text-xl banner text-gray-900 dark:text-white">
                                Learning Music Like<br>
                                <br>You<br>
                                <br>Learn A Language:<br>
                                <br>Naturally!<br><br>
                            </h1>
                            <h2>(Victor Wooten)<h2>
                                    </p>
                                    <img style="display: inline-block;" src="{{ asset('images/mmusic.gif') }}" alt="My Logo" class="-mt-px mr-1 w-5 h-5 ">
                        </div>
                    </a>
                    <a href="http://musiclessonmtl.fsd07.com/" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <img src="{{ asset('images/music.jpeg') }}" alt="piano">
                    </a>
                </div>

                <div class="flex-grow mt-4 p-4 ml-2">
                    <p>Welcome to Music Lesson MTL, established in 2023, our mission is to help you achieve your musical goals in a fun and encouraging setting. Our qualified teachers tailor their lessons based on the interests and goals of each student.</p>
                </div>
                <div class="flex-grow mt-4 p-4 ml-2">
                    <p>We offer private lessons from our downtown studio Monday - Friday, 9 - 5, book a lesson and start your journey today!</P>


                </div>

            </div>
            @endsection