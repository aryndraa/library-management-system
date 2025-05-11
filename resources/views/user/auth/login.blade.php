@extends('layouts.auth')

@section('content')
    <section class="grid grid-cols-1 lg:grid-cols-4 ">
        <div class="col-span-2 px-5  py-6 lg:ml-20 lg:mr-32  lg:min-h-[94vh]  flex items-center">
            <div class="w-full ">
                <div class="mb-8  lg:block">
                    <div class="flex items-center gap-2 lg:gap-4 mb-2">
                        <hr class="w-8 lg:w-12 ">
                        <h2 class="text-sm lg:text-lg leading-1 ">Welcome Back!</h2>
                    </div>
                    <h1 class="text-xl lg:text-2xl leading-[30px] lg:leading-[44px]">Please enter your details to log in <br/> your account </h1>
                </div>

                <form>
                    <div class="flex flex-col gap-5 lg:gap-6 mb-12">
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Email</label>
                            <input type="email" placeholder="youremail@gmail.com" class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30">
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Password</label>
                            <input type="password" placeholder="••••••••" class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30">
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 lg:flex-row justify-between lg:items-end">
                        <div>
                            <p class="text-xs lg:text-sm lg:mb-1">Don’t Have Account?</p>
                            <a href="{{route('member.auth.register')}}" class="text-lg lg:text-xl text-primary-300">Create Account</a>
                        </div>
                        <a href="{{route('member.auth.make-profile')}}" class="font-normal rounded-lg px-6 py-4 lg:py-2 bg-bgWidget">Log In</a>
                    </div>
                </form>
            </div>
        </div>
        <div
            class="min-h-[25vh]  lg:min-h-[94vh] m-2 lg:m-5 lg:py-6 p-5 lg:px-8 bg-black-300 col-span-2 rounded-xl bg-cover bg-center bg-blend-overlay bg-black/20"
            style="background-image: url('https://images.unsplash.com/photo-1526827826797-7b05204a22ef?q=80&w=3087&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')"

        >
            <x-logo/>
        </div>
    </section>
@endsection
