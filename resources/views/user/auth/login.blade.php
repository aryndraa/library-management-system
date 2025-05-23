@extends('layouts.auth')

@section('content')
    <section class="flex flex-col-reverse  lg:grid lg:grid-cols-4 ">
        <div class="col-span-2 px-5  py-6 lg:ml-20 lg:mr-32  lg:min-h-[94vh]  flex items-center rounded-t-xl transform -translate-y-6 lg:translate-y-0 bg-white">
            <div class="w-full ">
                <div class="mb-8  lg:block">
                    <div class="flex items-center gap-2 lg:gap-4 mb-2">
                        <hr class="w-8 lg:w-12 ">
                        <h2 class="text-sm lg:text-lg leading-1 ">Welcome Back!</h2>
                    </div>
                    <h1 class="text-xl lg:text-2xl leading-[30px] lg:leading-[44px]">Please enter your details to log in <br/> your account </h1>
                </div>

                <form
                    action="/member/login"
                    method="post"
                    x-data="{ loading: false }"
                    @submit.prevent="loading = true; $nextTick(() => $el.submit())"
                >
                    @csrf
                    <div class="flex flex-col gap-5 lg:gap-6 mb-12">
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Email</label>
                            <input
                                type="email"
                                name="email"
                                placeholder="youremail@gmail.com"
                                class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                            >
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Password</label>
                            <input
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                            >
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 lg:flex-row justify-between lg:items-end">
                        <div>
                            <p class="text-xs lg:text-sm lg:mb-1">Don’t Have Account?</p>
                            <a href="{{route('member.auth.register')}}" class="text-lg lg:text-xl text-primary-300">Create Account</a>
                        </div>
                        <button
                            type="submit"
                            class="font-normal rounded-lg px-6 py-4 lg:py-2 bg-bgWidget flex items-center justify-center gap-2"
                            :disabled="loading"
                        >
                            <template x-if="!loading">
                                <span>Log In</span>
                            </template>
                            <template x-if="loading">
                                <span class="flex items-center">
                                    <svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Loading...
                                </span>
                            </template>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div
            class="min-h-[25vh] lg:min-h-[94vh] m-0 lg:m-5 lg:py-6 p-5 lg:px-8 bg-black-300 col-span-2 lg:rounded-xl bg-cover bg-center bg-blend-overlay bg-black/20"
            style="background-image: url('https://images.unsplash.com/photo-1526827826797-7b05204a22ef?q=80&w=3087&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')"

        >
            <x-logo/>
        </div>
    </section>
@endsection
