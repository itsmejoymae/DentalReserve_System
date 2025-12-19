<?php include 'header.php'; ?>

<div class="bg-gray-50 min-h-screen p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Appointment Records</h1>
                <p class="text-gray-500 mt-1">Manage the appointments of the customers.</p>
            </div>
            <div class="flex gap-2">
                <a href="../../public/Admin/home.php" class="btn btn-ghost border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Dashboard
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                <span class="text-sm font-semibold text-gray-600">Active Records</span>
                <select id="statusFilter" class="input input-sm input-bordered w-48">
                    <option value="all">All Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>
                </select>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="text-gray-400 uppercase text-xs tracking-widest">
                            <th class="bg-white py-4">Patient</th>
                            <th class="bg-white py-4">Doctor Assigned</th>
                            <th class="bg-white py-4">Room Assigned</th>
                            <th class="bg-white py-4">Appointment Type</th>
                            <th class="bg-white py-4">Date / Time</th>
                            <th class="bg-white py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="appointment_body" class="divide-y divide-gray-50"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<dialog id="assignedModal" class="modal backdrop-blur-sm">
    <div class="modal-box max-w-md border border-gray-100 shadow-2xl p-0 overflow-hidden">
        <div class="bg-indigo-600 p-6 text-white">
            <h3 id="modalTitle" class="text-xl font-bold">Assign Doctor & Room</h3>
            <p class="text-indigo-100 text-sm opacity-80">Select a doctor and enter the room number.</p>
        </div>
        
        <form id="assignedForm" class="p-6 space-y-4">
            <input type="hidden" id="appt_id" name="id">

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Doctor</label>
                <select id="doctorSelect" name="doctor_id" class="input input-bordered w-full"></select>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Room</label>
                <input type="text" id="roomInput" name="room" class="input input-bordered w-full" placeholder="Enter room number">
            </div>

            <button type="submit" class="btn btn-primary w-full">Approve</button>
        </form>

        <button class="btn mt-2" onclick="assignedModal.close()">Close</button>
    </div>
</dialog>

<script>
$(function(){

    let appointments = [];
    let doctors = [];

    // Load doctors for select dropdown
    function loadDoctors() {
        $.getJSON('../../handlers/doctor_list.php', res=>{
            doctors = res.data || [];
            let options = '<option value="">Select doctor</option>';
            doctors.forEach(d=>{
                options += `<option value="${d.id}">Dr. ${d.first_name} ${d.last_name} (${d.specialty})</option>`;
            });
            $('#doctorSelect').html(options);
        });
    }

    // Load appointments
    function loadAppointments() {
        $.getJSON('../../handlers/appointment_list.php', res=>{
            appointments = res.data || [];
            renderAppointments(appointments);
        });
    }

    // Render table
    function renderAppointments(data) {
        let html = '';
        const filter = $('#statusFilter').val();

        const filtered = data.filter(a=> filter==='all' || a.status===filter);

        if(!filtered.length){
            html = `<tr><td colspan="6" class="text-center py-4">No appointments found</td></tr>`;
        } else {
            filtered.forEach(a=>{
                html += `
                <tr>
                    <td class="flex items-center gap-2">
                        <img src="../../Uploads/Client/${a.patient_img||'default.jpg'}" class="w-10 h-10 rounded-full">
                        ${a.patient_first} ${a.patient_last}
                    </td>
                    <td>${a.doctor_first? `Dr. ${a.doctor_first} ${a.doctor_last}` : '-'}</td>
                    <td>${a.room||'-'}</td>
                    <td>${a.app_type}</td>
                    <td>${a.app_date} ${a.app_time}</td>
                    <td class="text-center">
                        ${a.status==='Pending' ? `<button onclick="openAssign(${a.id})" class="btn btn-xs btn-info">Approve</button>` : '<span class="badge bg-green-200 text-green-800">Approved</span>'}
                    </td>
                </tr>`;
            });
        }

        $('#appointment_body').html(html);
    }

    // Filter by status
    $('#statusFilter').on('change', function(){
        renderAppointments(appointments);
    });

    // Open assign modal
    window.openAssign = function(id){
        const appt = appointments.find(a=>a.id==id);
        if(!appt) return;

        $('#appt_id').val(appt.id);
        $('#roomInput').val(appt.room||'');
        $('#doctorSelect').val(appt.doctor_id||'');
        assignedModal.showModal();
    }

    // Handle approve submit
    $('#assignedForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:'../../handlers/appointment_approve.php',
            method:'POST',
            data: $(this).serialize(),
            success: function(){
                assignedModal.close();
                loadAppointments();
            }
        });
    });

    // Initial load
    loadDoctors();
    loadAppointments();

});
</script>
