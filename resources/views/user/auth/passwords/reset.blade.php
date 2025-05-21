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

</head>

<body class="antialiased">
<main class="flex min-h-screen justify-center items-center">
    <form
        method="POST"
        action="{{ route('member.auth.password.update') }}"
        class="w-[40%] mt-10 bg-white "
    >
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <h2 class="text-2xl font-semibold text-center mb-6">Reset Your Password</h2>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
                type="email"
                name="email"
                required
                placeholder="you@example.com"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-300"
            >
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
            <input
                type="password"
                name="password"
                required
                placeholder="Enter new password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-300"
            >
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input
                type="password"
                name="password_confirmation"
                required
                placeholder="Confirm new password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-300"
            >
        </div>

        <button
            type="submit"
            class="w-full bg-primary-300 text-white py-3 rounded-lg hover:bg-primary-400 transition duration-200 font-medium"
        >
            Reset Password
        </button>
    </form>
</main>

</body>
</html>




