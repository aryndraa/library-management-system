@extends('layouts.show', ['routeDirect' => 'member.home'])

@section('content')
    <section class="grid grid-cols-4 gap-16">
        <x-navigation.sidebar/>

        <div class="col-span-2">
            <h2 class="text-2xl mb-8">Account Setting</h2>
            <div class="mb-8 p-6 rounded-xl  bg-bgWidget ">
                <h2 class="text-lg mb-2">Reset Password</h2>
                <form
                    method="POST"
                    action="{{ route('member.auth.password.email') }}"
                    x-data="{ loading: false }"
                    @submit.prevent="loading = true; $el.submit()"
                >
                    @csrf
                    <input
                        type="email"
                        name="email"
                        required
                        placeholder="Enter your email address"
                        class="w-full px-4 lg:px-6  py-3 mb-6 border-none focus:ring-0 bg-white rounded-lg focus:outline-none placeholder:text-font/30"
                    >

                    <button
                        type="submit"
                        class="w-full bg-primary-300 py-3 text-white font-normal rounded-xl flex justify-center items-center gap-2"
                        :disabled="loading"
                        :class="loading ? 'bg-primary-200 cursor-not-allowed' : ''"
                    >
                        <svg
                            x-show="loading"
                            class="animate-spin h-4 w-4 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span x-text="loading ? 'Sending...' : 'Send Reset Link'"></span>
                    </button>
                </form>
            </div>
            <div>
                <form action="{{ route('member.auth.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="bg-bgWidget rounded-xl text-lg w-full py-3">Log out</button>
                </form>
            </div>
        </div>
    </section>
@endsection
