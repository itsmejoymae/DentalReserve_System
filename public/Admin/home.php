<?php
session_start();
include('header.php');
?>

<div class="sticky top-0 z-50 flex justify-center pt-4 backdrop-blur-md bg-white/30">
    <nav class="bg-white/90 backdrop-blur shadow-lg rounded-2xl px-6 py-2 flex items-center justify-between w-[95%] max-w-6xl border border-white/50">
        <div class="flex items-center gap-3">
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-sky-400 rounded-full blur opacity-30 group-hover:opacity-60 transition duration-300"></div>
                <img src='../../pages/images/Web_logo.jpeg' class="relative w-11 h-11 rounded-full object-cover border-2 border-white">
            </div>
            <div class="flex flex-col">
                <span class="text-lg font-black tracking-tight text-sky-700 leading-tight uppercase">Dr. B</span>
                <span class="text-[10px] uppercase tracking-widest text-gray-500 font-bold">Dental Clinic</span>
            </div>
        </div>

        <div class="hidden md:flex items-center bg-gray-100/50 rounded-xl p-1 px-2 border border-gray-100">
            <a href="" class="px-4 py-2 text-sm font-semibold text-sky-600 bg-white shadow-sm rounded-lg">Home</a>
            <a href="appointment_list.php" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-sky-600 transition-colors">Appointments</a>
            <a href="doctors_list.php" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-sky-600 transition-colors">Doctors</a>
        </div>

        <div class="flex items-center gap-4">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="avatar transition hover:ring-2 ring-sky-300 ring-offset-2 rounded-full cursor-pointer">
                    <div class="w-10 rounded-full ring-1 ring-gray-200">
                        <img id="profile_image" src="../../Uploads/Admin/<?php echo htmlspecialchars($profile['img'] ?? 'default.jpg'); ?>" />
                    </div>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-white rounded-xl z-[100] mt-4 w-52 p-2 shadow-2xl border border-gray-50">
                    <li class="menu-title text-gray-400 uppercase text-[10px]">Account</li>
                    <li><a href="#" id="logoutLink" class="text-red-500 rounded-lg font-bold">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<section class="relative pt-20 pb-16 px-6 bg-gray-50 overflow-hidden">
  <div class="max-w-7xl mx-auto perspective-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

    <div class="card-3d bg-gradient-to-br from-emerald-500 to-teal-600 p-0.5 rounded-3xl shadow-xl">
        <div class="bg-white h-full w-full rounded-[22px] p-6 card-inner border-b-4 border-emerald-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-400 uppercase text-[10px] font-black tracking-[0.15em]">Approved</h3>
                    <p id="approvedCount" class="text-4xl font-black text-gray-900 mt-1">0</p>
                </div>
                <div class="bg-emerald-500 text-white p-3 rounded-2xl shadow-lg shadow-emerald-200 glass-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card-3d bg-gradient-to-br from-amber-400 to-orange-500 p-0.5 rounded-3xl shadow-xl">
        <div class="bg-white h-full w-full rounded-[22px] p-6 card-inner border-b-4 border-amber-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-400 uppercase text-[10px] font-black tracking-[0.15em]">Pending</h3>
                    <p id="pendingCount" class="text-4xl font-black text-gray-900 mt-1">0</p>
                </div>
                <div class="bg-amber-500 text-white p-3 rounded-2xl shadow-lg shadow-amber-200 glass-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div onclick="window.location.href='doctors_list.php'" class="card-3d bg-gradient-to-br from-sky-500 to-blue-600 p-0.5 rounded-3xl shadow-xl cursor-pointer">
        <div class="bg-white h-full w-full rounded-[22px] p-6 card-inner border-b-4 border-sky-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-400 uppercase text-[10px] font-black tracking-[0.15em]">Doctors</h3>
                    <p id="doctorCount" class="text-4xl font-black text-gray-900 mt-1">0</p>
                </div>
                <div class="bg-sky-500 text-white p-3 rounded-2xl shadow-lg shadow-sky-200 glass-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div onclick="window.location.href='appointment_list.php'" class="card-3d bg-gradient-to-br from-violet-500 to-indigo-600 p-0.5 rounded-3xl shadow-xl cursor-pointer">
        <div class="bg-white h-full w-full rounded-[22px] p-6 card-inner border-b-4 border-indigo-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-400 uppercase text-[10px] font-black tracking-[0.15em]">Total Visits</h3>
                    <p id="totalAppointments" class="text-4xl font-black text-gray-900 mt-1">0</p>
                </div>
                <div class="bg-violet-500 text-white p-3 rounded-2xl shadow-lg shadow-violet-200 glass-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

  </div>
</section>

<section class="max-w-7xl mx-auto mt-10 px-6 mb-20">
    <div class="flex items-center gap-4 mb-10">
        <div class="w-2 h-10 bg-sky-500 rounded-full"></div>
        <h2 class="text-4xl font-black text-gray-900 tracking-tight">Our Services</h2>
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
            <div class="mt-6 flex items-center text-<?php echo $s[3]; ?>-600 font-bold text-xs uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">
                Learn More 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>