<?php include('../../includes/header.php'); ?>

<section class="pt-4 pb-10 bg-[#E6F5FF]">
    <div class="max-w-6xl mx-auto px-4">

        <div class="flex flex-col md:flex-row items-center md:justify-between p-4 bg-white rounded-lg shadow-md max-w-3xl mx-auto mt-6">


            <div class="flex items-center space-x-3 mb-4 md:mb-0">
                <img src="../../assets/images/logo.jpeg" alt="DentalCare Logo" class="w-12 h-12 rounded-full object-cover border-2 border-sky-400" />
                <span class="text-sky-600 font-bold text-lg select-none">DentalCare</span>
            </div>


            <div class="flex flex-col md:flex-row items-center md:space-x-4 space-y-2 md:space-y-0">
                <div class="flex space-x-2 md:space-x-4">
                    <a href="#" class="btn btn-sm btn-ghost bg-sky-200 text-sky-600 normal-case">Home</a>
                    <a href="#" class="btn btn-sm btn-ghost normal-case text-gray-600 hover:bg-gray-100">Appointments</a>
                    <a href="#" class="btn btn-sm btn-ghost normal-case text-gray-600 hover:bg-gray-100">Patients</a>
                </div>

                <button class="btn btn-sm btn-primary normal-case flex items-center space-x-2 mt-2 md:mt-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-7H3v7a2 2 0 002 2z" />
                    </svg>
                    <span>Book Appointment</span>
                </button>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img
                                alt="Tailwind CSS Navbar component"
                                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                        </div>
                    </div>
                    <ul
                        tabindex="-1"
                        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                        <li>
                            <a class="justify-between">
                                Profile
                                <span class="badge">New</span>
                            </a>
                        </li>
                        <li><a>Settings</a></li>
                        <li><a>Logout</a></li>
                    </ul>

                </div>
            </div>

        </div>
        <div class="text-center mt-10">
            <h1 class="text-4xl font-bold text-gray-800 mt-6"> Your Smile, Our <span class="text-sky-600">Priority</span> </h1>
            <p class="text-gray-600 mt-2 max-w-md mx-auto"> Professional dental care with state-of-the-art facilities and experienced practitioners. </p>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-10">
        <div class="stat bg-base-100 shadow rounded-box">
            <div class="stat-value text-3xl text-sky-600">0</div>
            <div class="stat-title">Total Patients</div>
        </div>

        <div class="stat bg-base-100 shadow rounded-box">
            <div class="stat-value text-3xl text-sky-600">0</div>
            <div class="stat-title">Scheduled</div>
        </div>

        <div class="stat bg-base-100 shadow rounded-box">
            <div class="stat-value text-3xl text-sky-600">0</div>
            <div class="stat-title">Completed</div>
        </div>

        <div class="stat bg-base-100 shadow rounded-box">
            <div class="stat-value text-3xl text-sky-600">0</div>
            <div class="stat-title">Cancelled</div>
        </div>
    </div>
    </div>
</section>


<section class="py-10 bg-[#E6F5FF]">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-6">Our Services</h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">


            <div class="card bg-base-100 shadow-md p-5">
                <div class="flex items-center gap-3">
                    <div class="bg-sky-200 p-3 rounded-lg">
                        <img src="/mnt/data/44ce4fb9-34b3-43d3-a31b-1b3a9ca61022.png" class="w-8" />
                    </div>
                    <h3 class="text-lg font-semibold">General Checkup</h3>
                </div>
                <p class="text-gray-600 mt-2">
                    Comprehensive dental examination and oral health assessment.
                </p>
            </div>

            <div class="card bg-base-100 shadow-md p-5">
                <div class="flex items-center gap-3">
                    <div class="bg-sky-200 p-3 rounded-lg">
                        <img src="/mnt/data/44ce4fb9-34b3-43d3-a31b-1b3a9ca61022.png" class="w-8" />
                    </div>
                    <h3 class="text-lg font-semibold">Teeth Cleaning</h3>
                </div>
                <p class="text-gray-600 mt-2">
                    Professional cleaning to maintain optimal oral hygiene.
                </p>
            </div>

            <div class="card bg-base-100 shadow-md p-5">
                <div class="flex items-center gap-3">
                    <div class="bg-sky-200 p-3 rounded-lg">
                        <img src="/mnt/data/44ce4fb9-34c4f22f9ad2c5ff2e26d971e207c62-01.jpg" class="w-8" />
                    </div>
                    <h3 class="text-lg font-semibold">Root Canal</h3>
                </div>
                <p class="text-gray-500 mt-2">
                    Advanced endodontic treatment for infected teeth.
                </p>
            </div>

            <div class="card bg-base-100 shadow-md p-5">
                <div class="flex items-center gap-3">
                    <div class="bg-sky-200 p-3 rounded-lg">
                        <img src="/mnt/data/44ce4fb9-34c4f22f9ad2c5ff2e26d971e207c62-01.jpg" class="w-8" />
                    </div>
                    <h3 class="text-lg font-semibold">Brace Installment</h3>
                </div>
                <p class="text-gray-500 mt-2">
                    Advanced endodontic treatment for teeth alignment.
                </p>
            </div>

        </div>
    </div>
</section>

<dialog id="my_modal_1" class="modal">
    <div class="modal-box">


        <div id="signin_section">
            <h3 class="font-bold text-xl mb-3">Sign In</h3>

            <form id="signinForm" class="space-y-3">
                <input type="text" placeholder="Email" id="login_email" class="input input-bordered w-full" required />
                <input type="password" placeholder="Password" id="login_password" class="input input-bordered w-full" required />

                <p class="text-sm">
                    Don't have an account?
                    <span class="text-sky-600 cursor-pointer" onclick="swapForm('signup')">Create one</span>
                </p>

                <div class="modal-action">
                    <button type="submit" class="btn bg-sky-600 text-white">Sign In</button>
                    <button type="button" class="btn" onclick="my_modal_1.close()">Close</button>
                </div>
            </form>
        </div>


        <div id="signup_section" class="hidden">
            <h3 class="font-bold text-xl mb-3">Create Account</h3>

            <form id="signupForm" class="space-y-3">
                <input type="text" placeholder="Email" id="email" class="input input-bordered w-full" required />
                <input type="password" placeholder="Password" id="password" class="input input-bordered w-full" required />

                <p class="text-sm">
                    Already have an account?
                    <span class="text-sky-600 cursor-pointer" onclick="swapForm('signin')">Sign in</span>
                </p>

                <div class="modal-action">
                    <button type="submit" class="btn bg-sky-600 text-white">Sign Up</button>
                    <button type="button" class="btn" onclick="my_modal_1.close()">Close</button>
                </div>
            </form>
        </div>

    </div>
</dialog>


<?php include('../../includes/footer.php'); ?>