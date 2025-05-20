@extends('layouts.show', ['routeDirect' => 'member.home'])

@section('content')
    <section class="grid grid-cols-4 gap-16">
        <div class="col-span-1 flex flex-col text-font/60  border-r">
            <a href="#" class="pb-6 w-fit border-b  text-font border-font/40">User Profile</a>
            <a href="#" class="py-6 w-fit border-b border-transparent">Book Borrowing</a>
            <a href="#" class="py-6 w-fit border-b border-transparent">Book Likes</a>
            <a href="#" class="py-6 w-fit border-b border-transparent">Room Booking</a>
            <a href="#" class="py-6 w-fit border-b border-transparent">Account Setting</a>
        </div>

        <form action="{{route('member.profile.editProfile')}}" method="post" class="col-span-3 flex flex-col gap-14 " id="myForm" onsubmit="handleSubmit(event)"    >
            @csrf

            <div>
                <h1 class="text-2xl mb-10">Personal Information</h1>
                <div class="grid grid-cols-2 gap-10">
                    <div class="flex  col-span-2">
                        <label for="avatarInput" class="relative">
                            <div class="w-40 h-40 lg:w-52 lg:h-52 rounded-full overflow-hidden bg-bgWidget cursor-pointer">
                                <img id="avatarPreview" src="{{$member->profile->photoProfile->file_url}}" alt="."
                                     class="w-full h-full object-cover">

                                <div class="absolute bottom-0 right-0 transform p-3 rounded-full bg-primary-300 -translate-x-6 -translate-y-1">
                                    <x-heroicon-o-camera class="h-6 w-6 text-white"/>
                                </div>
                            </div>
                        </label>
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden">
                    </div>
                    <div class="grid grid-cols-2 col-span-2 gap-5">
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">First Name</label>
                            <input
                                type="text"
                                name="first_name"
                                placeholder="Enter your last name"
                                value="{{ $member->profile->first_name }}"
                                class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                            >
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Last Name</label>
                            <input
                                type="text"
                                name="last_name"
                                placeholder="Enter your last name"
                                value="{{ $member->profile->last_name }}"
                                class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                            >
                        </div>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <label for="" class="mb-2 text-sm lg:text-base">Address</label>
                        <input
                            type="text"
                            name="address"
                            placeholder="Enter your address"
                            value="{{ $member->profile->address }}"
                            class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                        >
                    </div>
                    <div class="grid grid-cols-2 col-span-2 gap-5">
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Province</label>
                            <input
                                type="text"
                                name="province"
                                placeholder="Enter your province"
                                value="{{ $member->profile->province}}"
                                class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                            >
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">City</label>
                            <input
                                type="text"
                                name="city"
                                placeholder="Enter your city"
                                value="{{ $member->profile->city }}"
                                class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                            >
                        </div>
                    </div>
                    <div class="grid grid-cols-2 col-span-2 gap-5">
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Birthday</label>
                            <input
                                type="date"
                                name="birthday"
                                placeholder="Enter your city"
                                value="{{ $member->profile->birthday }}"
                                class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none text-font/30"
                            >
                        </div>
                        <div class="flex flex-col">
                            <label for="gender" class="mb-2 text-sm lg:text-base">Gender</label>
                            <select
                                name="gender"
                                id="gender"
                                class="w-full px-4 lg:px-6 py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none text-font/30 placeholder:text-font/30"
                            >
                                <option class="text-font" value="" disabled {{ old('gender', $member->profile->gender) ? '' : 'selected' }}>
                                    Select your gender
                                </option>
                                <option class="text-font" value="male" {{ old('gender', $member->profile->gender) === 'male' ? 'selected' : '' }}>
                                    Male
                                </option>
                                <option class="text-font" value="female" {{ old('gender', $member->profile->gender) === 'female' ? 'selected' : '' }}>
                                    Female
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="text-2xl mb-10">Contact Information</h2>
                <div class="grid grid-cols-2 gap-5">
                    <div class="flex flex-col ">
                        <label for="" class="mb-2 text-sm lg:text-base">Email</label>
                        <input
                            type="text"
                            name="email"
                            value="{{ $member->email }}"
                            placeholder="Enter your email"
                            class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                        >
                    </div>
                    <div class="flex flex-col ">
                        <label for="" class="mb-2 text-sm lg:text-base">Phone Number</label>
                        <input
                            type="text"
                            name="phone"
                            value="{{ $member->profile->phone }}"
                            placeholder="Enter your phone number"
                            class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                        >
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <button
                    id="submitButton"
                    type="submit"
                    class="px-6 text-end py-3 w-fit rounded-lg bg-primary-300 text-white font-normal flex items-center gap-2"
                >
                    <span id="submitText">Save</span>
                    <span id="loadingSpinner" class="hidden animate-spin border-2 border-white border-t-transparent rounded-full w-5 h-5"></span>
                </button>
            </div>
        </form>
    </section>

    <script>
        function handleSubmit(event) {
            const btn = document.getElementById('submitButton');
            const text = document.getElementById('submitText');
            const spinner = document.getElementById('loadingSpinner');

            text.classList.add('hidden');
            spinner.classList.remove('hidden');
            btn.disabled = true;
        }
    </script>
@endsection
