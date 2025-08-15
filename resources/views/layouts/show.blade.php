@props([
    'routeDirect',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/css/app.css')
    <title>{{ config('app.name') }}</title>

    {{--  font  --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">


    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @vite(['resources/css/app.css','resources/js/app.js' ])

    @livewireStyles
</head>

<body class="antialiased px-5 lg:px-32 2xl:mx-80 py-8 lg:py-12">
    <header class="mb-8 lg:mb-14">
        <a href="{{route($routeDirect)}}" class="text-xl flex items-center gap-2.5">
            <span><x-heroicon-o-arrow-left class="w-6 h-6"/></span>
            Back
        </a>
    </header>

    <main>
        <livewire:select-library />
        @yield('content')
    </main>

    @livewireScripts
</body>
</html>

