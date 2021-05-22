<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tiny Bank</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-36 sm:pt-0">
    @if (Route::has('login'))
        <div class="fixed top-0 right-0 px-6 py-4 block">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center items-center pt-8 sm:pt-0">
            {{--                <div class="block h-10 w-auto fill-current text-gray-600">--}}
            <div style="color: #ff9037" class="text-center xs:text-5xl sm:text-6xl font-semibold">
                tin<span style="color: #ff4b37">Y</span>
            </div>
            <div class="mx-2">
                @include('components.big-logo')
            </div>
            {{--                </div>--}}
            <div style="color: #ff9037" class="text-center xs:text-5xl sm:text-6xl font-semibold">
                <span style="color: #ff4b37">B</span>ank
            </div>
        </div>


        <div class="mt-16 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
            <div class="mt-2 text-gray-600 text-justify dark:text-gray-400 text-sm">
                With this bank simulator, you can open accounts in multiple currencies and perform money transactions
                with automatic currency conversion. Also, it is possible to create an investment account and start
                trading stocks. If you were lucky in stock exchange and had to pay the capital gains tax, "tinY Bank"
                has got you covered! Application features full-scale two-factor authentication powered by Laravel
                Jetstream.
            </div>
        </div>
    </div>
</div>
</body>
</html>
