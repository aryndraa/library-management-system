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
        <section class="grid grid-cols-1 lg:grid-cols-4 ">
            <div
                class="min-h-[25vh]  lg:min-h-[94vh] m-2 lg:m-5 py-6 px-5 lg:px-8 bg-black-300 col-span-2 rounded-xl bg-cover bg-center bg-blend-overlay bg-black/30"
                style="background-image: url('https://images.unsplash.com/photo-1510172951991-856a654063f9?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGJvb2t8ZW58MHx8MHx8fDA%3D')"

            >
                <x-logo/>
            </div>
            <div class="col-span-2 px-5   py-6 lg:ml-20 lg:mr-32  lg:min-h-[94vh]  flex items-center">
                <div class="w-full ">
{{--                    <div class="mb-4 text-xl text-center">--}}
{{--                        <h1>Create Your Account</h1>--}}
{{--                    </div>--}}

                    <div class="mb-8  lg:block">
                        <div class="flex items-center gap-2 lg:gap-4 mb-2">
                            <hr class="w-8 lg:w-12 ">
                            <h2 class="text-sm lg:text-lg leading-1 ">Become A Member</h2>
                        </div>
                        <h1 class="text-xl lg:text-2xl leading-[30px] lg:leading-[44px]">Welcome to Perpusku, let’s create <br> your member account</h1>
                    </div>

                    <div>
                        <div class="flex flex-col gap-5 lg:gap-6 mb-12">
                            <div class="flex flex-col">
                                <label for="" class="mb-2 text-sm lg:text-base">Email</label>
                                <input type="email" placeholder="youremail@gmail.com" class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30">
                            </div>
                            <div class="flex flex-col">
                                <label for="" class="mb-2 text-sm lg:text-base">Password</label>
                                <input type="password" placeholder="••••••••" class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30">
                            </div>
                            <div class="flex flex-col">
                                <label for="" class="mb-2 text-sm lg:text-base">Confirm Password</label>
                                <input type="password" placeholder="••••••••" class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30">
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 lg:flex-row justify-between lg:items-end">
                            <div>
                                <p class="text-xs lg:text-sm lg:mb-1">Already Have Account?</p>
                                <a href="#" class="text-lg lg:text-xl text-primary-300">Login Account</a>
                            </div>
                            <button class="font-normal rounded-lg px-6 py-4 lg:py-2 bg-bgWidget">Continue</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
