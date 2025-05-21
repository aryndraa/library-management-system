@extends('layouts.app')

@section('content')
    <section
        class="min-h-[105vh] w-full flex items-end relative py-28    "
    >
        <div class="min-h-[105vh] lg:min-h-[105vh]  absolute inset-0 z-[-1]">
            <img
                src="https://images.unsplash.com/photo-1533090161767-e6ffed986c88?q=80&w=2938&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt=""
                class="h-[105vh] z-[-2] w-full absolute object-cover"
            >
            <div class="min-h-[105vh] lg:max-h-[105vh] absolute z-[-1] bg-gradient-to-b from-black/20 via-black/10 to-black/20 inset-0"></div>
        </div>

        <div class="mx-20 text-white">
            <h1 class="text-[80px] leading-[1.2] font-medium mb-12">Your gateway to <br> world of knowledge</h1>
            <div class="flex items-start gap-2 lg:gap-4 ">
                <hr class="w-8 lg:w-24 ">
                <div>
                    <p class="text-xl leading-[0] mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </p>
                    <p class="text-xl ">eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                </div>
            </div>
        </div>
    </section>
    <section class="px-32 py-24 rounded-t-[32px] transform -translate-y-8 bg-white">
        <div class="grid grid-cols-5 gap-16 place-items-center">
            <img src="{{ asset('images/logoipsum/Logo.svg') }}" alt="">
            <img src="{{ asset('images/logoipsum/Logo-1.svg') }}" alt="">
            <img src="{{ asset('images/logoipsum/Logo-2.svg') }}" alt="">
            <img src="{{ asset('images/logoipsum/Logo-3.svg') }}" alt="">
            <img src="{{ asset('images/logoipsum/Logo-4.svg') }}" alt="">
        </div>
    </section>
    <section class="px-32  pb-24">
        <div class="grid grid-cols-3 gap-8">
            <x-card.count-card/>
            <x-card.count-card/>
            <x-card.count-card/>
        </div>
    </section>
@endsection
