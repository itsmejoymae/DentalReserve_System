<?php
session_start();
include('../../Classes/Client.php');
include('header.php');

$client = new Users();
$user_id = $_SESSION['id'] ?? 0;
$profile = $client->getProfile($user_id);
?>

<div class="min-h-screen bg-slate-50/50 pb-20">
    <div class="bg-white border-b border-gray-100 px-6 py-8 mb-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">My Appointments</h1>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                    Manage your upcoming clinic visits and schedules
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="../../public/client/home.php" class="btn btn-outline border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-600 rounded-2xl normal-case font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 mb-8">
        <div class="bg-white/80 backdrop-blur-md p-3 rounded-2xl shadow-sm border border-white flex flex-col md:flex-row gap-3">
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" id="searchInput" placeholder="Search by doctor or date..." 
                       class="input input-bordered w-full pl-12 bg-slate-50/50 border-none focus:ring-2 ring-sky-500 rounded-xl transition-all">
            </div>
            <select id="statusFilter" class="select select-bordered bg-slate-50/50 border-none rounded-xl font-semibold text-slate-600">
                <option value="all">All Status</option>
                <option value="Pending">🕒 Pending</option>
                <option value="Approved">✅ Approved</option>
            </select>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6">
        <div class="hidden lg:block overflow-hidden bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100">
            <table class="table w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 text-[11px] uppercase tracking-[0.15em] font-black">
                        <th class="py-5 pl-10">Patient Information</th>
                        <th>Practitioner Details</th>
                        <th>Schedule</th>
                        <th>Category</th>
                        <th>Current Status</th>
                        <th class="text-center pr-10">Management</th>
                    </tr>
                </thead>
                <tbody id="app_body" class="divide-y divide-slate-50">
                    </tbody>
            </table>
        </div>

        <div id="app_cards_mobile" class="lg:hidden space-y-4">
            </div>
    </div>
</div>

<dialog id="app_modal" class="modal modal-bottom sm:modal-middle backdrop-blur-md">
    <div class="modal-box p-0 max-w-md rounded-[2rem] overflow-hidden shadow-2xl border border-white/20 max-h-[90vh] flex flex-col">
        
        <div class="bg-sky-600 px-6 py-4 text-white shrink-0">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-black text-xl tracking-tight">Reschedule</h3>
                    <p class="text-sky-100 text-[10px] opacity-90">Pick a new date and time</p>
                </div>
                <button class="btn btn-xs btn-circle btn-ghost text-white" onclick="app_modal.close()">✕</button>
            </div>
        </div>

        <form id="appointment" class="p-6 overflow-y-auto space-y-6 bg-white custom-scrollbar">
            <input type="hidden" id="selected_date" name="date" />
            <input type="hidden" id="selected_time" name="time" />

            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-sky-100 text-sky-600 text-[10px] flex items-center justify-center">1</span>
                        Select Date
                    </h4>
                    <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-lg">
                        <button type="button" id="prevMonth" class="btn btn-ghost btn-xs px-1 min-h-0 h-6">❮</button>
                        <span id="currentMonth" class="font-black text-[9px] text-slate-600 min-w-[70px] text-center uppercase"></span>
                        <button type="button" id="nextMonth" class="btn btn-ghost btn-xs px-1 min-h-0 h-6">❯</button>
                    </div>
                </div>
                
                <div class="bg-slate-50 p-2 rounded-2xl">
                    <div id="calendar_container" class="grid grid-cols-7 gap-1 text-center text-[9px] font-bold">
                        </div>
                </div>
            </div>

            <div class="space-y-3">
                <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-sky-100 text-sky-600 text-[10px] flex items-center justify-center">2</span>
                    Select Time
                </h4>
                <div id="time_slots" class="grid grid-cols-3 gap-2">
                    </div>
            </div>

            <div id="selection_summary" class="hidden">
                <div class="bg-sky-50 border border-sky-100 rounded-xl p-3 flex items-center justify-between">
                    <div class="text-[11px]">
                        <p class="text-sky-400 font-bold uppercase tracking-tighter">Selected Slot</p>
                        <p class="font-black text-sky-700"><span id="summary_date"></span> @ <span id="summary_time"></span></p>
                    </div>
                    <span class="text-lg">🗓️</span>
                </div>
            </div>
        </form>

        <div class="p-4 bg-white border-t border-slate-50 shrink-0">
            <button type="button" id="save_appointment" class="btn btn-primary w-full rounded-xl h-12 shadow-lg border-none bg-sky-600 hover:bg-sky-700 font-black text-sm">
                Confirm Changes
            </button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop bg-slate-900/40"><button>close</button></form>
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

    function renderData(data) {
        let tableHtml = '';
        let mobileHtml = '';

        if (data.length === 0) {
            const emptyState = `
                <div class="py-20 flex flex-col items-center justify-center opacity-40">
                    <span class="text-6xl mb-4">🗓️</span>
                    <p class="font-bold text-slate-400">No scheduled appointments found.</p>
                </div>`;
            $('#app_body').html('<tr><td colspan="6">' + emptyState + '</td></tr>');
            $('#app_cards_mobile').html(emptyState);
            return;
        }

        data.forEach(ap => {
            const isPending = ap.status === 'Pending';
            const statusClass = isPending ? 'bg-orange-50 text-orange-600 border-orange-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100';
            const statusDot = isPending ? 'bg-orange-400 animate-pulse' : 'bg-emerald-400';

            tableHtml += `
                <tr class="hover:bg-slate-50/80 transition-all group">
                    <td class="py-6 pl-10">
                        <div class="flex items-center gap-4">
                            <div class="avatar shadow-sm ring-2 ring-white rounded-full">
                                <div class="w-12 h-12 rounded-full">
                                    <img src="../../Uploads/Client/${ap.img ?? 'default.jpg'}" />
                                </div>
                            </div>
                            <div>
                                <div class="font-black text-slate-800">${ap.first_name} ${ap.last_name}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="font-bold text-sky-600 flex items-center gap-2">
                            <span class="text-xs">🩺</span> Dr. ${ap.doctor_name}
                        </div>
                        <div class="text-[10px] text-slate-400 uppercase font-extrabold mt-0.5 tracking-tighter">Room: ${ap.room}</div>
                    </td>
                    <td>
                        <div class="text-sm font-black text-slate-700">${ap.app_date}</div>
                        <div class="text-[10px] text-slate-400 font-bold">${ap.app_time}</div>
                    </td>
                    <td>
                        <span class="px-3 py-1 bg-slate-100 rounded-lg text-slate-600 font-bold text-[10px] uppercase">${ap.app_type}</span>
                    </td>
                    <td>
                        <span class="badge ${statusClass} border flex items-center gap-2 px-4 py-3 font-black text-[10px]">
                            <span class="w-1.5 h-1.5 rounded-full ${statusDot}"></span>
                            ${ap.status.toUpperCase()}
                        </span>
                    </td>
                    <td class="text-center pr-10">
                        <div class="join shadow-sm rounded-xl overflow-hidden border border-slate-100">
                            <button class="editBtn btn btn-ghost btn-sm join-item text-sky-600 hover:bg-sky-50" data-id="${ap.id}">Reschedule</button>
                            <button class="deleteBtn btn btn-ghost btn-sm join-item text-rose-400 hover:bg-rose-50" data-id="${ap.id}">Cancel</button>
                        </div>
                    </td>
                </tr>`;

            mobileHtml += `
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group active:scale-[0.98] transition-all">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-3">
                             <div class="avatar">
                                <div class="w-10 h-10 rounded-full ring-2 ring-slate-50">
                                    <img src="../../Uploads/Client/${ap.img ?? 'default.jpg'}" />
                                </div>
                            </div>
                            <span class="badge ${statusClass} border text-[9px] font-black px-3 py-2 uppercase tracking-widest">${ap.status}</span>
                        </div>
                        <div class="text-right">
                             <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">${ap.app_type}</div>
                             <div class="text-sm font-black text-slate-800">${ap.app_date}</div>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-black text-slate-800">Dr. ${ap.doctor_name}</h4>
                        <p class="text-xs text-slate-400 font-bold">Room ${ap.room} • ${ap.app_time}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <button class="editBtn btn btn-sky-50 border-none text-sky-600 btn-sm rounded-xl font-black text-[10px]" data-id="${ap.id}">RESCHEDULE</button>
                        <button class="deleteBtn btn btn-rose-50 border-none text-rose-400 btn-sm rounded-xl font-black text-[10px]" data-id="${ap.id}">CANCEL VISIT</button>
                    </div>
                </div>`;
        });

        $('#app_body').html(tableHtml);
        $('#app_cards_mobile').html(mobileHtml);
    }

    
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

    $(document).on('click', '.deleteBtn', function() {
        const id = $(this).data('id');
        if (confirm('Cancel this appointment?')) {
            $.post('../../handlers/c_deleteapp.php', { id }, function(res) {
                if (res.success) { alert('Appointment cancelled successfully!'); loadAppointments(); }
            }, 'json');
        }
    });

    $(document).on('click', '.editBtn', function() {
        currentAppId = $(this).data('id');
        $('#selected_date').val('');
        $('#selected_time').val('');
        $('#time_slots').empty();
        $('#calendar_container [data-date]').removeClass('bg-sky-600 text-white shadow-lg');
        app_modal.showModal();
    });

    $('#save_appointment').on('click', function() {
        const date = $('#selected_date').val();
        const time = $('#selected_time').val();
        if (!date || !time) { alert('Please select a date and time.'); return; }
        $.ajax({
            url: '../../handlers/c_updateapp.php',
            method: 'POST',
            data: { id: currentAppId, date, time },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    alert('Appointment rescheduled successfully!');
                    app_modal.close();
                    loadAppointments();
                }
            }
        });
    });

    function renderCalendar(month = currentMonth, year = currentYear) {
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDay = new Date(year, month, 1).getDay();
        $('#currentMonth').text(new Intl.DateTimeFormat('en-US', { month: 'short', year: 'numeric'}).format(new Date(year, month)));
        let calendarHtml = '';

        const weekdays = ['S','M','T','W','T','F','S'];
        weekdays.forEach(day => calendarHtml += `<div class="py-2 text-slate-300 font-bold">${day}</div>`);

        for (let i=0; i<firstDay; i++) calendarHtml += '<div></div>';
        for (let d=1; d<=daysInMonth; d++){
            const dateObj = new Date(year, month, d);
            const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            const isPast = dateObj < new Date(today.setHours(0,0,0,0));
            const disabled = isPast ? 'opacity-20 cursor-not-allowed text-slate-300' : 'cursor-pointer hover:bg-sky-50 text-slate-700 hover:text-sky-600';
            calendarHtml += `<div class="p-3 border-none rounded-xl transition-all ${disabled}" data-date="${dateStr}" data-day="${dateObj.getDay()}">${d}</div>`;
        }
        $('#calendar_container').html(calendarHtml);
    }

    function renderTimeSlots(dateStr){
        const day = new Date(dateStr).getDay();
        const slots = (day === 6 || day === 0) ? weekendSlots : businessDaySlots;
        let html = '';
        slots.forEach(time => html += `<button type="button" class="time-slot btn btn-outline btn-sm rounded-xl font-bold border-slate-100 text-slate-600 hover:bg-sky-600 hover:border-sky-600 mb-1" data-time="${time}">${time}</button>`);
        $('#time_slots').html(html);
        $('#selected_time').val('');
    }

    renderCalendar();

    $('#prevMonth').click(function(e){ e.preventDefault(); currentMonth--; if(currentMonth<0){currentMonth=11; currentYear--;} renderCalendar(currentMonth,currentYear); });
    $('#nextMonth').click(function(e){ e.preventDefault(); currentMonth++; if(currentMonth>11){currentMonth=0; currentYear++;} renderCalendar(currentMonth,currentYear); });

    $('#calendar_container').on('click', '[data-date]', function () {
    if ($(this).hasClass('opacity-20')) return;
    $('#calendar_container [data-date]').removeClass('bg-sky-600 text-white shadow-lg shadow-sky-100');
    $(this).addClass('bg-sky-600 text-white shadow-lg shadow-sky-100');
    selectedDate = $(this).data('date');
    $('#selected_date').val(selectedDate);
    
    
    $('#summary_date').text(new Date(selectedDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }));
    $('#selection_summary').removeClass('hidden');

    renderTimeSlots(selectedDate);
    });

    $('#time_slots').on('click', '.time-slot', function () {
    $('#time_slots .time-slot').removeClass('bg-sky-600 text-white border-sky-600 shadow-md').addClass('btn-outline border-slate-100 text-slate-600');
    $(this).removeClass('btn-outline border-slate-100').addClass('bg-sky-600 text-white border-sky-600 shadow-md');
    
    const selectedTime = $(this).data('time');
    $('#selected_time').val(selectedTime);

    
    $('#summary_time').text(selectedTime);
    });

    loadAppointments();
});
</script>