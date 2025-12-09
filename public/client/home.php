<?php
session_start();
include('header.php');
?>

<div class="flex justify-center pt-6">
    <nav class="bg-white shadow-lg rounded-2xl px-6 py-3 flex items-center w-[90%] max-w-6xl">
        <div class="flex items-center gap-3 flex-1">
            <div class="bg-sky-500 text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                <img src='../../pages/images/Web_logo.jpeg'
                     class="w-10 h-10 rounded-full">
            </div>
            <span class="text-xl font-bold text-sky-600">DR.B DentalClinic</span>
        </div>

        <div class="flex flex-col md:flex-row items-center md:space-x-4 space-y-2 md:space-y-0">
            <div class="flex space-x-2 md:space-x-4">
                <a href="" class="btn btn-sm btn-ghost bg-sky-200 text-sky-600 normal-case">Home</a>
                <a href="app_list.php" class="btn btn-sm btn-ghost normal-case text-gray-600 hover:bg-gray-100">Appointment</a>
            </div>

            <button class="btn btn-sm btn-primary flex items-center space-x-2 mt-2 md:mt-0"
                    onclick="document.getElementById('app_modal').showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-7H3v7a2 2 0 002 2z"/>
                </svg>
                <span>Book Appointment</span>
            </button>

            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img id="profile_image" src="../../Uploads/Client/<?php echo htmlspecialchars($profile['img'] ?? 'default.jpg'); ?>" alt="Profile_Image"/>
                    </div>
                </div>
                <ul tabindex="-1" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    <li><a href="c_profile.php">Profile</a></li>
                    <li><a>Settings</a></li>
                    <li><a href="../../handlers/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<section class="text-center mt-20">
    <h1 class="text-4xl font-bold">
        Your Smile, Our <span class="text-sky-600">Priority</span>
    </h1>
    <p class="mt-3 text-gray-600">Professional dental care facilities and experienced practitioners.</p>
</section>

<section class="max-w-6xl mx-auto mt-20 px-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Our Services</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold text-lg">General Checkup</h3>
            <p class="text-sm text-gray-600 mt-1">Comprehensive oral examination to ensure overall dental health.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold text-lg">Teeth Cleaning</h3>
            <p class="text-sm text-gray-600 mt-1">Professional cleaning to remove plaque, tartar, and stains for a brighter smile.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold text-lg">Tooth Extraction</h3>
            <p class="text-sm text-gray-600 mt-1">Safe removal of decayed or problematic teeth to maintain oral health.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold text-lg">Root Canal Treatment</h3>
            <p class="text-sm text-gray-600 mt-1">Treatment of infected tooth pulp to relieve pain and save the tooth.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold text-lg">Brace Installment / Orthodontics</h3>
            <p class="text-sm text-gray-600 mt-1">Correction of misaligned teeth for improved bite and aesthetics.</p>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto mt-20 px-6 pb-20">
    <h2 class="text-2xl font-bold text-center mb-6">Our Doctors</h2>
    <div id="doctors" class="carousel mt-6"></div>
</section>

<dialog id="app_modal" class="modal">
  <div class="modal-box p-4 max-w-xl mx-auto">
    <h3 class="font-bold text-xl mb-4 text-center">Book Appointment</h3>

    <form id="appointment" class="space-y-4">
      <input type="hidden" id="user_id" value="<?php echo $_SESSION['id']; ?>" />
      <input type="hidden" id="selected_date" name="date" />
      <input type="hidden" id="selected_time" name="time" />

      <!-- Calendar -->
      <div class="flex flex-col items-center">
        <h4 class="font-medium mb-2 text-center">Select Date</h4>
        <div class="flex justify-between items-center mb-2 w-s max-w-s">
          <button type="button" id="prevMonth" class="btn btn-sm">&lt;</button>
          <span id="currentMonth" class="font-medium text-sm"></span>
          <button type="button" id="nextMonth" class="btn btn-sm">&gt;</button>
        </div>
        <div id="calendar_container" class="grid grid-cols-7 gap-1 text-center w-full max-w-xs"></div>
      </div>

      <!-- Time Slots -->
      <div>
        <h4 class="font-medium mt-4 mb-2 text-center">Select Time</h4>
        <div id="time_slots" class="grid grid-cols-4 gap-2"></div>
      </div>

      <!-- Services -->
      <div>
        <h4 class="font-medium mt-4 mb-2 text-center">Select Service</h4>
        <select id="app_type" class="select select-bordered w-full">
          <option disabled selected>Select Service</option>
          <option value="general_checkup">General Checkup</option>
          <option value="teeth_cleaning">Teeth Cleaning</option>
          <option value="root_canal">Root Canal</option>
          <option value="braces">Braces Installment / Adjustment</option>
        </select>
      </div>

      <!-- Submit -->
      <button type="button" id="save_appointment" class="btn btn-primary w-full mt-4">Set Appointment</button>
    </form>

    <div class="modal-action justify-center">
      <button class="btn" onclick="app_modal.close()">Close</button>
    </div>
  </div>
</dialog>


<?php include('footer.php'); ?>
<script>
</script>