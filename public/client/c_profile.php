<?php
session_start();
include ('../../Classes/Client.php');
include 'header.php';

$client = new Users();
$profile = $client->getProfile($_SESSION['id']);
?>

<div class="min-h-screen bg-gray-50/50 pb-20">
    <div class="max-w-2xl mx-auto px-6 pt-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-gray-900">My Profile</h1>
                <p class="text-gray-500 text-sm">Manage your personal information and contact details.</p>
            </div>
            <a href="home.php" class="btn btn-ghost btn-sm text-sky-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-24 bg-gradient-to-r from-sky-400 to-blue-500"></div>
            <div class="px-8 pb-8">
                <div class="relative -mt-12 mb-6 text-center sm:text-left sm:flex sm:items-end sm:gap-6">
                    <div class="inline-block relative">
                        <img src="../../Uploads/Client/<?php echo htmlspecialchars($profile['img'] ?? 'default.jpg'); ?>" 
                             id="view_img" class="w-32 h-32 rounded-3xl object-cover border-4 border-white shadow-md bg-white" />
                    </div>
                    <div class="mt-4 sm:mb-2">
                        <h2 class="text-2xl font-bold text-gray-900">
                            <?php echo htmlspecialchars($profile['first_name'] . ' ' . $profile['last_name']); ?>
                        </h2>
                        <span class="badge badge-sky-100 text-sky-600 font-bold px-4 py-3">Patient</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Full Name</p>
                        <p class="text-gray-700 font-medium">
                            <?php echo htmlspecialchars($profile['first_name'] . ' ' . $profile['middle_name'] . ' ' . $profile['last_name']); ?>
                        </p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Gender</p>
                        <p class="text-gray-700 font-medium"><?php echo htmlspecialchars($profile['gender'] ?? 'Not Specified'); ?></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Phone Number</p>
                        <p class="text-gray-700 font-medium"><?php echo htmlspecialchars($profile['contact'] ?? 'None'); ?></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Home Address</p>
                        <p class="text-gray-700 font-medium"><?php echo htmlspecialchars($profile['address'] ?? 'No address provided'); ?></p>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-gray-50">
                    <button class="btn btn-primary w-full sm:w-auto px-10 rounded-xl shadow-lg shadow-sky-100" 
                            onclick="prof_modal.showModal()">
                        Edit Profile Details
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<dialog id="prof_modal" class="modal">
    <div class="modal-box p-0 max-w-lg bg-white rounded-3xl overflow-hidden flex flex-col max-h-[90vh]">
        <div class="bg-gray-900 p-6 text-white shrink-0">
            <h3 class="text-xl font-bold">Edit Profile</h3>
            <p class="text-gray-400 text-xs">Update your personal information below.</p>
        </div>

        <form id="updateProfileForm" enctype="multipart/form-data" class="p-8 space-y-5 overflow-y-auto">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">

            <div class="flex flex-col items-center mb-6">
                <div class="relative group">
                    <img src="../../Uploads/Client/<?php echo htmlspecialchars($profile['img'] ?? 'default.jpg'); ?>" 
                         id="profile_img_preview" class="w-24 h-24 rounded-2xl object-cover ring-4 ring-gray-50" />
                    <label for="profile_img_input" class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                        <span class="text-white text-[10px] font-bold uppercase">Change</span> 
                    </label>
                </div>
                <input type="file" name="profile_img" id="profile_img_input" class="hidden" onchange="previewImage(this)"/>
                <p class="text-[10px] text-gray-400 mt-2">Recommended: Square JPEG or PNG</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-bold text-gray-600">First Name</span></label>
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($profile['first_name']); ?>" class="input input-bordered w-full focus:ring-2 ring-sky-500" />
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-bold text-gray-600">Last Name</span></label>
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($profile['last_name']); ?>" class="input input-bordered w-full focus:ring-2 ring-sky-500" />
                </div>
            </div>

            <div class="form-control w-full">
                <label class="label"><span class="label-text font-bold text-gray-600">Middle Name</span></label>
                <input type="text" name="middle_name" value="<?php echo htmlspecialchars($profile['middle_name']); ?>" class="input input-bordered w-full focus:ring-2 ring-sky-500" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-bold text-gray-600">Gender</span></label>
                    <select name="gender" class="select select-bordered w-full">
                        <option <?php echo $profile['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option <?php echo $profile['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-bold text-gray-600">Phone</span></label>
                    <input type="text" name="contact" value="<?php echo htmlspecialchars($profile['contact']); ?>" class="input input-bordered w-full" />
                </div>
            </div>

            <div class="form-control w-full">
                <label class="label"><span class="label-text font-bold text-gray-600">Address</span></label>
                <textarea name="address" class="textarea textarea-bordered h-20"><?php echo htmlspecialchars($profile['address']); ?></textarea>
            </div>
        </form>

        <div class="p-6 bg-gray-50 border-t border-gray-100 flex gap-3 shrink-0">
            <button type="button" class="btn btn-ghost flex-1 rounded-xl" onclick="prof_modal.close()">Cancel</button>
            <button type="submit" form="updateProfileForm" class="btn btn-primary flex-1 rounded-xl shadow-lg shadow-sky-100">Save Changes</button>
        </div>
    </div>
</dialog>

<script>
    // Preview for image upload
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile_img_preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php include 'footer.php'; ?>