@extends('layouts.auth')

@section('content')
    <section class="max-h-[110vh]">
        <div
            class="min-h-[25vh]  lg:min-h-[55vh] m-2 lg:m-5 lg:py-6 p-5 lg:px-8 bg-black-300 col-span-2 rounded-xl bg-cover bg-right bg-blend-overlay bg-black/20"
            style="background-image: url('https://images.unsplash.com/photo-1528297506728-9533d2ac3fa4?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')"

        >
            <x-logo/>
        </div>
        <div class="mx-5 lg:mx-32 py-4 lg:py-12 lg:px-16 rounded-xl lg:transform lg:-translate-y-64 bg-white">
            <div class="flex items-center gap-2 lg:gap-4 mb-10">
                <hr class="w-8 lg:w-12 ">
                <h2 class="text-sm lg:text-lg leading-1 ">Make Your Profile</h2>
            </div>

            <form action="#" class="grid md:grid-cols-2 gap-8">
                <div class="grid grid-rows-4">
                    <div class="flex flex-col items-center mb-8 row-span-2">
                        <label for="avatarInput">
                            <div class="w-52 h-52 rounded-full overflow-hidden bg-bgWidget cursor-pointer">
                                <img id="avatarPreview" src="https://via.placeholder.com/150" alt="."
                                     class="w-full h-full object-cover">
                            </div>
                        </label>
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden">
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">First Name</label>
                            <input type="text" placeholder="Enter your first name" class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30">
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Last Name</label>
                            <input type="text" placeholder="Enter your last name" class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30">
                        </div>
                    </div>
                    <div class="flex flex-col col-span-full">
                        <label for="" class="mb-2 text-sm lg:text-base">Phone Number</label>
                        <input type="text" placeholder="Enter your phone number" class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30">
                    </div>
                </div>

                <div class="grid grid-rows-4">
                    <div class="flex flex-col mb-5">
                        <label for="" class="mb-2 text-sm lg:text-base">Address</label>
                        <input type="text" placeholder="Enter your address" class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30">
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Province</label>
                            <input type="text" placeholder="Enter your province" class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30">
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">City</label>
                            <input type="text" placeholder="Enter your city" class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none placeholder:text-font/30">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div class="flex flex-col">
                            <label for="" class="mb-2 text-sm lg:text-base">Birthday</label>
                            <input type="date" placeholder="Enter your city" class="w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-bgWidget rounded-lg focus:outline-none text-font/30">
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
                        <button class="flex h-fit  flex-col  col-span-full w-full px-4 lg:px-6  py-3 border-none focus:ring-0 bg-primary-300 text-white font-medium rounded-lg focus:outline-none placeholder:text-font/30">
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
