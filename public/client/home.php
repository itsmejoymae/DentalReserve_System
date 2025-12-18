<?php
session_start();
include('header.php');
?>

<div class="sticky top-0 z-50 flex justify-center pt-4 backdrop-blur-md bg-white/30">
    <nav class="bg-white/90 backdrop-blur shadow-md rounded-2xl px-6 py-2 flex items-center justify-between w-[95%] max-w-6xl border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-sky-400 rounded-full blur opacity-30 group-hover:opacity-60 transition duration-300"></div>
                <img src='../../pages/images/Web_logo.jpeg' class="relative w-11 h-11 rounded-full object-cover border-2 border-white">
            </div>
            <div class="flex flex-col">
                <span class="text-lg font-black tracking-tight text-sky-700 leading-tight">DR. B</span>
                <span class="text-[10px] uppercase tracking-widest text-gray-500 font-bold">Dental Clinic</span>
            </div>
        </div>

        <div class="hidden md:flex items-center bg-gray-50 rounded-xl p-1 px-2 border border-gray-100">
            <a href="" class="px-4 py-2 text-sm font-semibold text-sky-600 bg-white shadow-sm rounded-lg">Home</a>
            <a href="app_list.php" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-sky-600 transition-colors">Appointment List</a>
        </div>

        <div class="flex items-center gap-4">
            <button class="btn btn-primary btn-sm rounded-lg shadow-sky-200 shadow-lg border-none hover:scale-105 transition-transform"
                    onclick="document.getElementById('app_modal').showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden sm:inline">Book Now</span>
            </button>

            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="avatar transition hover:ring-2 ring-sky-300 ring-offset-2 rounded-full">
                    <div class="w-10 rounded-full ring-1 ring-gray-200">
                        <img id="profile_image" src="../../Uploads/Client/<?php echo htmlspecialchars($profile['img'] ?? 'default.jpg'); ?>" />
                    </div>
                </div>
                <ul tabindex="-1" class="menu menu-sm dropdown-content bg-white rounded-xl z-50 mt-4 w-52 p-2 shadow-xl border border-gray-50">
                    <li class="menu-title text-gray-400 uppercase text-[10px]">Account</li>
                    <li><a href="c_profile.php" class="rounded-lg">Profile Settings</a></li>
                    <li><a href="../../handlers/logout.php" class="text-red-500 rounded-lg">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<section class="relative overflow-hidden pt-20 pb-16 px-6">
    <div class="max-w-4xl mx-auto text-center relative z-10">
        <span class="bg-sky-50 text-sky-600 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-4 inline-block">Professional Dental Care</span>
        <h1 class="text-5xl md:text-6xl font-black text-gray-900 leading-tight">
            Your Smile, Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-600 to-blue-500">Priority</span>
        </h1>
        <p class="mt-6 text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed">
            Experience world-class dental services with state-of-the-art facilities and a team of compassionate practitioners.
        </p>
    </div>
</section>

<section class="max-w-6xl mx-auto mt-10 px-6 mb-20">
    <div class="flex items-end justify-between mb-10">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Our Services</h2>
            <div class="h-1.5 w-12 bg-sky-500 rounded-full mt-2"></div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php 
        $services = [
            ['General Checkup', 'Comprehensive oral examination to ensure overall health.', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['Teeth Cleaning', 'Professional cleaning to remove plaque and brighten your smile.', 'M13 10V3L4 14h7v7l9-11h-7z'],
            ['Tooth Extraction', 'Safe removal of problematic teeth to maintain oral health.', 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.628.291a2 2 0 01-1.646 0l-.628-.291a6 6 0 00-3.86-.517l-2.387.477a2 2 0 00-1.022.547l-.34.34a2 2 0 000 2.829l1.245 1.245a2 2 0 002.829 0l3.427-3.427v-3.427l-3.427-3.427a2 2 0 00-2.829 0l-1.245 1.245a2 2 0 000 2.829l.34.34z'],
            ['Root Canal', 'Relieve pain and save your natural teeth from infection.', 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
            ['Orthodontics', 'Correction of misaligned teeth for a perfect functional bite.', 'M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 011 1V4z']
        ];
        foreach($services as $s): ?>
        <div class="group bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
            <div class="w-12 h-12 bg-sky-50 rounded-2xl flex items-center justify-center text-sky-600 mb-6 group-hover:bg-sky-500 group-hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $s[2]; ?>" />
                </svg>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-3"><?php echo $s[0]; ?></h3>
            <p class="text-gray-500 text-sm leading-relaxed"><?php echo $s[1]; ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<dialog id="app_modal" class="modal">
    <div class="modal-box p-0 max-w-xl bg-white rounded-3xl overflow-hidden flex flex-col max-h-[95vh]">
        <div class="bg-sky-600 p-5 text-white text-center shrink-0">
            <h3 class="text-xl font-bold">Book an Appointment</h3>
            <p class="text-sky-100 text-xs opacity-80">All fields are required</p>
        </div>
        
        <form id="appointment" class="p-6 space-y-6 overflow-y-auto custom-scrollbar">
            <input type="hidden" id="user_id" value="<?php echo $_SESSION['id']; ?>" />
            <input type="hidden" id="selected_date" name="date" />
            <input type="hidden" id="selected_time" name="time" />

            <div>
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-bold text-sm text-gray-700 uppercase tracking-wide">1. Select Date</h4>
                    <div class="flex gap-1">
                        <button type="button" id="prevMonth" class="btn btn-xs btn-ghost text-sky-600">&lt;</button>
                        <span id="currentMonth" class="text-xs font-bold w-24 text-center self-center"></span>
                        <button type="button" id="nextMonth" class="btn btn-xs btn-ghost text-sky-600">&gt;</button>
                    </div>
                </div>
                <div id="calendar_container" class="grid grid-cols-7 gap-1 text-center text-[10px] font-semibold text-gray-400 bg-gray-50 p-2 rounded-xl">
                    </div>
            </div>

            <div>
                <h4 class="font-bold text-sm text-gray-700 mb-2 uppercase tracking-wide">2. Select Time</h4>
                <div id="time_slots" class="grid grid-cols-4 gap-1.5">
                    </div>
            </div>

            <div>
                <h4 class="font-bold text-sm text-gray-700 mb-2 uppercase tracking-wide">3. Treatment</h4>
                <select id="app_type" class="select select-sm select-bordered w-full bg-white border-gray-300">
                    <option disabled selected>Pick a service</option>
                    <option value="General Checkup">General Checkup</option>
                    <option value="Teeth Cleaning">Teeth Cleaning</option>
                    <option value="Tooth Extraction">Tooth Extraction</option>
                    <option value="Root Canal Treatment">Root Canal Treatment</option>
                    <option value="Braces Installment / Adjustment">Braces Installment / Adjustment</option>
                </select>
            </div>
        </form>

        <div class="p-4 border-t border-gray-100 bg-gray-50 flex flex-col gap-2 shrink-0">
            <button type="button" id="save_appointment" class="btn btn-primary w-full h-12 rounded-xl shadow-md shadow-sky-100">
                Confirm Booking
            </button>
            <button type="button" class="btn btn-ghost btn-xs text-black-400" onclick="app_modal.close()">
                Close
            </button>
        </div>
    </div>
</dialog>

<style>
  
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #bae6fd;
        border-radius: 10px;
    }
</style>

<?php include('footer.php'); ?>