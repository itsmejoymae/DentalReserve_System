<?php include 'header.php'; ?>

<div class="bg-gray-50 min-h-screen p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dental Doctors</h1>
                <p class="text-gray-500 mt-1">Manage credentials and contact info for all Doctors.</p>
            </div>
            <div class="flex gap-2">
                <a href="../../public/Admin/home.php" class="btn btn-ghost border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Dashboard
                </a>
                <button id="addBtn" class="btn btn-primary shadow-md bg-indigo-600 border-none hover:bg-indigo-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Add Doctor
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                <span class="text-sm font-semibold text-gray-600">Active Records</span>
                <div class="relative">
                    <input type="text" placeholder="Search staff..." class="input input-sm input-bordered w-64 pl-8" />
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-2.5 top-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="text-gray-400 uppercase text-xs tracking-widest">
                            <th class="bg-white py-4">Doctor</th>
                            <th class="bg-white py-4">Specialty</th>
                            <th class="bg-white py-4">Phone</th>
                            <th class="bg-white py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="doctor_body" class="divide-y divide-gray-50">
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<dialog id="doctorModal" class="modal backdrop-blur-sm">
    <div class="modal-box max-w-md border border-gray-100 shadow-2xl p-0 overflow-hidden">
        <div class="bg-indigo-600 p-6 text-white">
            <h3 id="modalTitle" class="text-xl font-bold"></h3>
            <p class="text-indigo-100 text-sm opacity-80">Please ensure all information is accurate.</p>
        </div>
        
        <form id="doctorForm" enctype="multipart/form-data" class="p-6 space-y-5">
            <input type="hidden" name="id" id="doc_id">

            <div class="flex items-center gap-6 pb-2">
                <div class="avatar">
                    <div class="w-20 rounded-2xl ring ring-indigo-50 ring-offset-2 shadow-inner bg-gray-100">
                        <img id="imgPrev" src="../../Uploads/Admin/default.jpg" />
                    </div>
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Profile Picture</label>
                    <input type="file" name="img" id="doc_img" class="file-input file-input-bordered file-input-xs w-full">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-gray-600">First Name</span></label>
                    <input name="first_name" id="fn" class="input input-bordered focus:border-indigo-500 w-full" placeholder="John" required>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-gray-600">Last Name</span></label>
                    <input name="last_name" id="ln" class="input input-bordered focus:border-indigo-500 w-full" placeholder="Doe" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-gray-600">Specialty</span></label>
                    <input name="specialty" id="sp" class="input input-bordered focus:border-indigo-500 w-full" placeholder="Cardiology">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-gray-600">Phone</span></label>
                    <input name="phone" id="ph" class="input input-bordered focus:border-indigo-500 w-full" placeholder="09123456789">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                <button type="button" class="btn btn-ghost text-black-400" onclick="doctorModal.close()">Dismiss</button>
                <button id="saveBtn" class="btn btn-primary bg-indigo-600 hover:bg-indigo-700 border-none px-8">Save Record</button>
            </div>
        </form>
    </div>
</dialog>

<script>
let mode = 'add';

function loadDoctors() {
    $.getJSON('../../handlers/doctor_list.php', r => {
        let h = '';
        if(r.data.length === 0) {
            h = `<tr><td colspan="4" class="text-center py-12 text-gray-400">No doctors found in the database.</td></tr>`;
        } else {
            r.data.forEach(d => {
                h += `
                <tr class="hover:bg-indigo-50/30 transition-all group">
                    <td class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="avatar shadow-sm">
                                <div class="mask mask-squircle w-11 h-11">
                                    <img src="../../Uploads/Admin/${d.img || 'default.jpg'}" />
                                </div>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">Dr. ${d.first_name} ${d.last_name}</div>
                                <div class="text-[10px] uppercase tracking-tighter text-gray-400 font-bold">Verified Practitioner</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="badge badge-outline border-gray-200 text-gray-600 font-medium px-3 py-3">${d.specialty}</div>
                    </td>
                    <td><span class="text-sm text-gray-500 font-medium italic">${d.phone}</span></td>
                    <td class="text-center">
                        <div class="join bg-white border border-gray-100 shadow-sm opacity-80 group-hover:opacity-100 transition-opacity"> 
                            <button onclick="view(${d.id})" class="btn btn-ghost btn-xs join-item hover:text-indigo-600">View</button>
                            <button onclick="edit(${d.id})" class="btn btn-ghost btn-xs join-item border-x border-gray-50 hover:text-blue-600">Edit</button>
                            <button onclick="del(${d.id})" class="btn btn-ghost btn-xs join-item text-red-400 hover:text-red-600">Delete</button>
                        </div>
                    </td>
                </tr>`;
            });
        }
        $('#doctor_body').html(h);
    });
}

// REST OF SCRIPT REMAINS THE SAME AS REQUESTED TO ENSURE NO BREAKAGE
function view(id) {
    mode = 'view';
    $.getJSON('../../handlers/view_doctor.php?id=' + id, d => {
        fill(d);
        $('#modalTitle').text('Doctor Profile');
        $('#doctorForm input').prop('disabled', true);
        $('#saveBtn').hide();
        doctorModal.showModal();
    });
}

function edit(id) {
    mode = 'edit';
    $.getJSON('../../handlers/view_doctor.php?id=' + id, d => {
        fill(d);
        $('#modalTitle').text('Edit Record');
        $('#doctorForm input').prop('disabled', false);
        $('#saveBtn').show();
        doctorModal.showModal();
    });
}

function fill(d) {
    $('#doc_id').val(d.id);
    $('#fn').val(d.first_name);
    $('#ln').val(d.last_name);
    $('#sp').val(d.specialty);
    $('#ph').val(d.phone);
    $('#imgPrev').attr('src', '../../Uploads/Admin/' + (d.img || 'default.jpg'));
}

$('#addBtn').click(() => {
    mode = 'add';
    $('#modalTitle').text('New Registration');
    $('#doctorForm')[0].reset();
    $('#doc_id').val('');
    $('#imgPrev').attr('src', '../../Uploads/Admin/default.jpg');
    $('#doctorForm input').prop('disabled', false);
    $('#saveBtn').show();
    doctorModal.showModal();
});

$('#doctorForm').submit(e => {
    e.preventDefault();
    let url = mode === 'edit' ? '../../handlers/update_doctor.php' : '../../handlers/add_doctor.php';
    $.ajax({
        url,
        method: 'POST',
        data: new FormData(e.target),
        processData: false,
        contentType: false,
        success: () => {
            doctorModal.close();
            loadDoctors();
        }
    });
});

function del(id) {
    if (confirm('Permanently remove this doctor record?'))
        $.post('../../handlers/delete_doctor.php', { id }, loadDoctors);
}

$("#doc_img").change(function() {
    if (this.files && this.files[0]) {
        let reader = new FileReader();
        reader.onload = e => $('#imgPrev').attr('src', e.target.result);
        reader.readAsDataURL(this.files[0]);
    }
});

loadDoctors();
</script>