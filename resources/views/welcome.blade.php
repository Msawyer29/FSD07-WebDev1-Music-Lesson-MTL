@extends('layouts.layout')
@section('header')
@endsection
@section('content')

    <body class="antialiased">
        <div
            class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                            in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex items-center">
                    <img src="{{ asset('images/musiclessonmtl_logo.jpg') }}" alt="My Logo" class="mr-4">
                    <div class="flex-grow mt-6 p-6 ml-6 border-l-4 border-gray-800">
                        <p class="text-xl leading-relaxed text-gray-700"><strong>Welcome to Music Lesson MTL,<br>Established
                                in 2023, our mission is to help students achieve their musical goals in a fun and
                                encouraging setting. <br>Whether you are a student or teacher, booking music lessons has
                                never been easier.</strong></p>
                    </div>
                </div>

                <div class="mt-16">
                    <p style="text-align:center; margin: 40px; font-size: large; font-weight: bold; font-style: italic;">
                        With our self-serve calendar, customized lesson scheduling is only a few clicks away!
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 mb-10">
                        <a href="http://musiclessonmtl.fsd07.com/"
                            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                            style="background-image: url('{{ asset('images/music.jpeg') }}'); background-size: cover; border: 22px solid white;">
                            <div style="text-align: center; text-color: white;">
                                <p class="mt-4 text-white text-m leading-relaxed">
                                    <h1 class="mt-6 text-xl banner" style="color: white;">
                                        Learning Music <br>Like<br>
                                        <br>You<br>
                                        <br>Learn A Language: <br>
                                        <br>Naturally!<br><br>
                                    </h1>                                    
                                </p>
                                <h2 style="color: white; margin-top: -10px;">(Victor Wooten)</h2>
                            </div>
                        </a>
                        <a href="http://musiclessonmtl.fsd07.com/"
                            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <img src="{{ asset('images/welcome-calendar.png') }}" alt="welcome-calendar">
                        </a>
                    </div>                      
                </div>

                <div class="flex-grow mx-auto mt-20 p-4 text-center">
                    <p class="mx-auto">Our qualified teachers tailor their lessons based on the interests and goals of
                        each student. <br>
                        Before booking a lesson, students can get to know our teachers by using our built-in messaging
                        system.</p>
                </div>

                <div class="flex-grow mx-auto mt-6 p-4 text-center">
                    <p class="mx-auto">We offer private lessons from our downtown studio Monday - Friday, 9 - 5. Book a
                        lesson and start
                        your new musical journey today!</p>
                        <img style="display: inline-block; margin-top: 10px;" src="{{ asset('images/mmusic.gif') }}"
                        alt="My Logo" class="-mt-px mr-1 w-5 h-5">
                </div>

            @endsection