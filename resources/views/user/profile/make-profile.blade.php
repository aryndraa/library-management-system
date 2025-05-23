@extends('layouts.auth')

@section('content')
    <section class="max-h-[110vh]">
        <div
            class="min-h-[25vh] lg:min-h-[55vh] m-0 lg:m-5 lg:py-6 p-5 lg:px-8 bg-black-300 col-span-2 lg:rounded-xl bg-cover bg-right bg-blend-overlay bg-black/20"
            style="background-image: url('https://images.unsplash.com/photo-1528297506728-9533d2ac3fa4?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')"

        >
            <x-logo/>
        </div>
        <div class="px-5 lg:mx-32 py-6 lg:py-12 place lg:px-16 rounded-xl lg:transform -translate-y-12 lg:-translate-y-64 bg-white">
            <div class="flex items-center gap-2 lg:gap-4 mb-10">
                <hr class="w-8 lg:w-12 ">
                <h2 class="text-sm lg:text-lg leading-1 ">Make Your Profile</h2>
            </div>

            <form action="/member/make-profile" method="post" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-5 lg:gap-8 ">
                @csrf
                <div class="grid lg:grid-rows-4  gap-5 lg:gap-0">
                    <div class="flex flex-col lg:items-center mb-4 lg:mb-8 lg:row-span-2 w-fit">
                        <label for="avatarInput" class="relative">
                            <div class="size-40 lg:w-52 lg:h-52 rounded-full overflow-hidden bg-bgWidget cursor-pointer ">
                                <img id="avatarPreview" src="https://via.placeholder.com/150" alt="."
                                     class="w-full h-full object-cover">

                                <div class="absolute bottom-0 right-0 transform p-2 lg:p-3 rounded-full bg-primary-300  lg:-translate-x-6 -translate-y-1">
                                    <x-heroicon-o-camera class="size-6 text-white"/>
                                </div>
                            </div>
                        </label>
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden">
                    </div>
                    <div class="grid lg:grid-cols-2 gap-5 lg:gap-5">
                        <div class="flex flex-col">
                            <label for="first_name" class="mb-2 text-sm lg:text-base">First Name <span class="text-red-500 text-base">*</span></label>
                            <input
                                type="text"
                                name="first_name"
                                placeholder="Enter your first name"
                                required
                                class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                            >
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Last Name <span class="text-red-500 text-base">*</span></label>
                            <input
                                type="text"
                                name="last_name"
                                placeholder="Enter your last name"
                                required
                                class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                            >
                        </div>
                    </div>
                    <div class="flex flex-col col-span-full">
                        <label for="" class="mb-2 text-sm lg:text-base">Phone Number <span class="text-red-500 text-base">*</span></label>
                        <input
                            type="text"
                            required
                            name="phone"
                            placeholder="Enter your phone number"
                            class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                        >
                    </div>
                </div>

                <div class="grid grid-rows-4">
                    <div class="flex flex-col mb-5">
                        <label for="" class="mb-2 text-sm lg:text-base">Address</label>
                        <input
                            type="text"
                            name="address"
                            placeholder="Enter your address"
                            class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                        >
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Province</label>
                            <input
                                type="text"
                                name="province"
                                placeholder="Enter your province"
                                class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                            >
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">City</label>
                            <input
                                type="text"
                                name="city"
                                placeholder="Enter your city"
                                class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30"
                            >
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Birthday</label>
                            <input
                                type="date"
                                name="birthday"
                                placeholder="Enter your city"
                                class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none text-font/30"
                            >
                        </div>
                        <div class="flex flex-col">
                            <label for="gender" class="mb-2 text-sm lg:text-base">Gender</label>
                            <select name="gender" id="gender"
                                    class="w-full px-4 lg:px-6 py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none text-font/30 placeholder:text-font/30">
                                <option class="text-font" value="" disabled selected>Select your gender</option>
                                <option class="text-font" value="male">Male</option>
                                <option class="text-font" value="female">Female</option>
                                <option class="text-font" value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <button type="submit" class="flex h-fit  flex-col  col-span-full w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-primary-300 text-white font-medium rounded-lg focus:outline-none placeholder:text-font/30">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        const input = document.getElementById('avatarInput');
        const preview = document.getElementById('avatarPreview');

        input.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        });
    </script>
@endsection
