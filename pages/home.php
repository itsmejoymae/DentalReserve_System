<?php include('../includes/header.php'); ?>


<div class="flex justify-center pt-6">
    <nav class="bg-white shadow-lg rounded-2xl px-6 py-3 flex items-center w-[90%] max-w-6xl">
        <div class="flex items-center gap-3 flex-1">
            <div class="bg-sky-500 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                <img src='images/Web_logo.jpeg'
                    class="bg-sky-500 text-white w-10 h-10 flex items-center justify-center rounded-full">
            </div>
            <span class=" text-xl font-bold text-sky-600">DR.B DentalClinic</span>
        </div>

        <div class="flex items-center gap-4">
            <button id="openSign" onclick="modal.showModal()"
                class="btn bg-sky-600 hover:bg-sky-700 text-white rounded-lg">
                Sign In / Sign Up
            </button>
        </div>
    </nav>
</div>


<section class="text-center mt-20">
    <h1 class="text-4xl font-bold">
        Your Smile, Our <span class="text-sky-600">Priority</span>
    </h1>
    <p class="mt-3 text-gray-600">
        Professional dental care facilities and experienced practitioners.
    </p>
</section>


<section class="max-w-6xl mx-auto mt-20 px-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Our Services</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold text-lg">Teeth Cleaning</h3>
            <p class="text-sm text-gray-600 mt-1">Brighten and protect your smile.</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold text-lg">Tooth Extraction</h3>
            <p class="text-sm text-gray-600 mt-1">Safe and painless removal.</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold text-lg">Orthodontics</h3>
            <p class="text-sm text-gray-600 mt-1">Perfect alignment for confidence.</p>
        </div>
    </div>
</section>


<section class="max-w-6xl mx-auto mt-20 px-6 pb-20">
    <h2 class="text-2xl font-bold text-center mb-6">Our Doctors</h2>
    <div id="doctors" class="carousel mt-6"></div>
</section>


<dialog id="modal" class="modal">
    <div class="modal-box bg-white p-6 rounded-2xl w-96 shadow-lg">

        <div id="loginPanel">
            <h3 class="font-bold text-xl text-sky-600 mb-2">Sign In</h3>

            <form id="signinForm">
                <input type="text" placeholder="Email" id="login_email" class="input input-bordered w-full mt-2" />
                <input type="password" id="login_password" placeholder="Email"
                    class="input input-bordered w-full mt-2" />
                <div class="mt-4 flex flex-col gap-3">
                    <p class="text-sm">
                        Don't have an account?
                        <span class="text-sky-600 cursor-pointer font-semibold" onclick="swapForm('signup')">
                            Create one
                        </span>
                    </p>

                    <div class="modal-action">
                        <button type="submit" class="btn bg-sky-600 hover:bg-sky-700 text-white">
                            Log In
                        </button>
                        <button type="button" class="btn bg-sky-600 hover:bg-sky-700 text-white"
                            onclick="swapForm('signup')">
                            Sign Up
                        </button>
                        <button type="button" class="btn btn-outline" onclick="modal.close()">
                            Close
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div id="signupPanel" class="hidden">
            <h4 class="text-xl font-bold text-sky-600">Sign Up</h4>
            <form id="signupForm">
                <input type="text" placeholder="Email" id="email" class="input input-bordered w-full mt-2" />
                <input type="password" placeholder="Password" id="password" class="input input-bordered w-full mt-2" />
            
                <div class="mt-4 flex flex-col gap-3">
                    <p class="text-sm">
                        Already have an account?
                        <span class="text-sky-600 cursor-pointer font-semibold" onclick="swapForm('login')">
                            Sign in
                        </span>
                    </p>

                    <div class="modal-action">
                        <button type="submit" class="btn bg-sky-600 hover:bg-sky-700 text-white">
                            Register
                        </button>
                        <button type="button" class="btn bg-sky-600 hover:bg-sky-700 text-white"
                            onclick="swapForm('login')">
                            Sign In
                        </button>
                        <button type="button" class="btn btn-outline" onclick="modal.close()">
                            Close
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</dialog>

<?php include('../includes/footer.php'); ?>