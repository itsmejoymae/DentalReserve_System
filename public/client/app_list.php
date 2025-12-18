<?php
session_start();
include('../../Classes/Client.php');
include('header.php');

$client = new Users();
$user_id = $_SESSION['id'] ?? 0;
$profile = $client->getProfile($user_id); // Fetch client profile for picture
?>

<div class="min-h-screen bg-gray-50/50 pb-20">
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">Appointment History</h1>
                <p class="text-sm text-gray-500">Track, reschedule, or cancel your clinic visits.</p>
            </div>
            <a href="../../public/client/home.php" class="btn btn-ghost hover:bg-sky-50 text-sky-600 rounded-xl">
                Dashboard
            </a>
        </div>
    </div>

    <!-- Search / Filter -->
    <div class="max-w-7xl mx-auto px-6 mt-8">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    🔍
                </span>
                <input type="text" id="searchInput" placeholder="Search by doctor or date..." 
                       class="input input-bordered w-full pl-10 bg-gray-50 border-none focus:ring-2 ring-sky-500 rounded-xl">
            </div>

            <div class="flex gap-2 w-full md:w-auto">
                <select id="statusFilter" class="select select-bordered bg-gray-50 border-none rounded-xl w-full">
                    <option value="all">All Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Appointment Table -->
    <div class="max-w-7xl mx-auto px-6 mt-6">
        <div class="hidden lg:block overflow-hidden bg-white rounded-3xl shadow-sm border border-gray-100">
            <table class="table w-full">
                <thead class="bg-gray-50/50 text-gray-400 uppercase text-[10px] tracking-widest">
                    <tr>
                        <th class="py-4 pl-6">Patient</th>
                        <th>Doctor & Room</th>
                        <th>Schedule</th>
                        <th>Appontment Type</th>
                        <th>Status</th>
                        <th class="text-center pl-6">Actions</th>
                    </tr>
                </thead>
                <tbody id="app_body" class="divide-y divide-gray-50">
                </tbody>
            </table>
        </div>

  
        <div id="app_cards_mobile" class="lg:hidden grid grid-cols-1 gap-4"></div>
    </div>
</div>

<dialog id="app_modal" class="modal">
  <div class="modal-box p-4 max-w-xl mx-auto">
    <h3 class="font-bold text-xl mb-4 text-center">Reschedule Appointment</h3>

    <form id="appointment" class="space-y-4">
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

      <!-- Save -->
      <button type="button" id="save_appointment" class="btn btn-primary w-full mt-4">Reschedule</button>
    </form>

    <div class="modal-action justify-center">
      <button class="btn" onclick="document.getElementById('app_modal').close()">Close</button>
    </div>
  </div>
</dialog>

<script>
$(function() {
    let allAppointments = [];
    let currentAppId = null;

    const today = new Date();
    let selectedDate = null;
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();

    const businessDaySlots = ['09:00 AM','10:00 AM','11:00 AM','01:00 PM','02:00 PM','03:00 PM','04:00 PM'];
    const weekendSlots = ['09:00 AM','10:00 AM','11:00 AM','01:00 PM','02:00 PM'];

    // 1️⃣ LOAD APPOINTMENTS
    function loadAppointments() {
        $.ajax({
            url: '../../handlers/c_applist.php',
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    allAppointments = res.data;
                    renderData(allAppointments);
                }
            }
        });
    }

    // 2️⃣ RENDER TABLE AND MOBILE CARDS
    function renderData(data) {
        let tableHtml = '';
        let mobileHtml = '';

        if (data.length === 0) {
            $('#app_body').html('<tr><td colspan="5" class="py-20 text-center text-gray-400 italic">No appointments found.</td></tr>');
            $('#app_cards_mobile').html('<div class="text-center py-10 text-gray-400">No appointments found.</div>');
            return;
        }

       data.forEach(ap => {
    let statusClass = ap.status === 'Pending' ? 'bg-orange-50 text-orange-600' : 'bg-green-50 text-green-600';

    tableHtml += `
        <tr class="hover:bg-gray-50/50 transition-colors">
            <td class="py-5 pl-6 flex items-center gap-2">
                <img src="../../Uploads/Client/${ap.img ?? 'default.jpg'}" class="w-8 h-8 rounded-full">
                ${ap.first_name} ${ap.last_name}
            </td>
            <td>
                <div class="font-bold text-gray-800 italic">Dr. ${ap.doctor_name}</div>
                <div class="text-[10px] text-gray-400 uppercase font-bold tracking-tight">Room: ${ap.room}</div>
            </td>
            <td>
                <div class="text-sm font-semibold text-gray-700">${ap.app_date}</div>
                <div class="text-xs text-gray-400">${ap.app_time}</div>
            </td>
            <td>
                <div class="text-sm font-semibold text-gray-700">${ap.app_type}</div>
            </td>
            <td><span class="badge ${statusClass} border-none font-bold text-[10px] px-3">${ap.status}</span></td>
            <td class="text-center pr-6">
                <div class="flex justify-center gap-2">
                    <button class="editBtn btn btn-sm btn-ghost text-sky-600 hover:bg-sky-50" data-id="${ap.id}">Reschedule</button>
                    <button class="deleteBtn btn btn-sm btn-ghost text-red-400 hover:bg-red-50" data-id="${ap.id}">Cancel</button>
                </div>
            </td>
        </tr>`;

    mobileHtml += `
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <span class="badge ${statusClass} border-none text-[10px] font-bold uppercase">${ap.status}</span>
                <div class="text-right text-xs font-bold text-gray-800">${ap.app_date}</div>
                <div class="text-right text-xs font-bold text-gray-800">${ap.app_type}</div>
            </div>
            <div class="font-bold text-gray-900">Dr. ${ap.doctor_name}</div>
            <p class="text-xs text-gray-400 mb-4">Room ${ap.room} • ${ap.app_time}</p>
            <div class="flex justify-center gap-3">
                <button class="editBtn btn btn-sky-50 border-none text-sky-600 btn-sm rounded-xl" data-id="${ap.id}">Reschedule</button>
                <button class="deleteBtn btn btn-ghost text-red-400 btn-sm rounded-xl" data-id="${ap.id}">Cancel</button>
            </div>
        </div>`;
});

        $('#app_body').html(tableHtml);
        $('#app_cards_mobile').html(mobileHtml);
    }

    // 3️⃣ SEARCH AND FILTER
    $('#searchInput, #statusFilter').on('input change', function() {
        const search = $('#searchInput').val().toLowerCase();
        const status = $('#statusFilter').val();

        const filtered = allAppointments.filter(ap => {
            const matchSearch = ap.doctor_name.toLowerCase().includes(search) || ap.app_date.includes(search);
            const matchStatus = (status === 'all' || ap.status === status);
            return matchSearch && matchStatus;
        });
        renderData(filtered);
    });

    // 4️⃣ CANCEL APPOINTMENT
    $(document).on('click', '.deleteBtn', function() {
        const id = $(this).data('id');
        if (confirm('Cancel this appointment?')) {
            $.post('../../handlers/c_deleteapp.php', { id }, function(res) {
                if (res.success) {
                    alert('Appointment cancelled successfully!');
                    loadAppointments();
                } else {
                    alert('Failed to cancel appointment.');
                }
            }, 'json');
        }
    });

    // 5️⃣ RESCHEDULE BUTTON
    $(document).on('click', '.editBtn', function() {
        currentAppId = $(this).data('id');
        $('#selected_date').val('');
        $('#selected_time').val('');
        $('#time_slots').empty();
        $('#calendar_container [data-date]').removeClass('bg-sky-500 text-white');

        document.getElementById('app_modal').showModal();
    });

    // 6️⃣ RESCHEDULE SAVE
    $('#save_appointment').on('click', function() {
        const date = $('#selected_date').val();
        const time = $('#selected_time').val();

        if (!date || !time) {
            alert('Please select a date and time.');
            return;
        }

        $.ajax({
            url: '../../handlers/c_updateapp.php',
            method: 'POST',
            data: { id: currentAppId, date, time },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    alert('Appointment rescheduled successfully!');
                    document.getElementById('app_modal').close();
                    loadAppointments();
                } else {
                    alert('Failed to reschedule.');
                }
            }
        });
    });

    // 7️⃣ CALENDAR + TIME SLOT LOGIC
    function renderCalendar(month = currentMonth, year = currentYear) {
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDay = new Date(year, month, 1).getDay();
        $('#currentMonth').text(new Intl.DateTimeFormat('en-US', { month: 'long', year: 'numeric'}).format(new Date(year, month)));
        let calendarHtml = '';

        const weekdays = ['Su','Mo','Tu','We','Th','Fr','Sa'];
        weekdays.forEach(day => calendarHtml += `<div class="font-medium">${day}</div>`);

        for (let i=0; i<firstDay; i++) calendarHtml += '<div></div>';
        for (let d=1; d<=daysInMonth; d++){
            const dateObj = new Date(year, month, d);
            const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            const disabled = dateObj < new Date(today.setHours(0,0,0,0)) ? 'opacity-40 cursor-not-allowed' : 'cursor-pointer hover:bg-sky-200';
            calendarHtml += `<div class="p-2 border rounded ${disabled}" data-date="${dateStr}" data-day="${dateObj.getDay()}">${d}</div>`;
        }
        $('#calendar_container').html(calendarHtml);
    }

    function renderTimeSlots(dateStr){
        const day = new Date(dateStr).getDay();
        const slots = (day === 6 || day === 5) ? weekendSlots : businessDaySlots;
        let html = '';
        slots.forEach(time => html += `<button type="button" class="time-slot btn btn-outline btn-sm w-full mb-1" data-time="${time}">${time}</button>`);
        $('#time_slots').html(html);
        $('#selected_time').val('');
    }

    renderCalendar();

    $('#prevMonth').click(function(e){ e.preventDefault(); currentMonth--; if(currentMonth<0){currentMonth=11; currentYear--;} renderCalendar(currentMonth,currentYear); });
    $('#nextMonth').click(function(e){ e.preventDefault(); currentMonth++; if(currentMonth>11){currentMonth=0; currentYear++;} renderCalendar(currentMonth,currentYear); });

    $('#calendar_container').on('click', '[data-date]', function () {
        if ($(this).hasClass('opacity-40')) return;
        $('#calendar_container [data-date]').removeClass('bg-sky-500 text-white');
        $(this).addClass('bg-sky-500 text-white');
        selectedDate = $(this).data('date');
        $('#selected_date').val(selectedDate);
        renderTimeSlots(selectedDate);
    });

    $('#time_slots').on('click', '.time-slot', function () {
        $('#time_slots .time-slot').removeClass('btn-primary').addClass('btn-outline');
        $(this).removeClass('btn-outline').addClass('btn-primary');
        $('#selected_time').val($(this).data('time'));
    });

    loadAppointments();
});
</script>
