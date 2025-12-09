<?php
session_start();
include ('../../Classes/Client.php');
include 'header.php';

$client = new Users();
$profile = $client->getProfile($_SESSION['id']);
?>

<div class="container mx-auto px-6 mt-6">
    <h3 class="font-bold text-xl mb-3">Profile</h3>

    <!-- View Section -->
    <div class="text-center mb-4">
        <img src="../../Uploads/Client/<?php echo htmlspecialchars($profile['img'] ?? 'default.jpg'); ?>" 
             id="view_img" class="w-24 h-24 rounded-full mx-auto mb-2" />
    </div>

    <div class="space-y-2 max-w-md mx-auto">
        <p><strong>First Name:</strong> <input type="text" readonly id="first_name_view" class="input input-bordered w-full" value="<?php echo htmlspecialchars($profile['first_name'] ?? ''); ?>"></p>
        <p><strong>Middle Name:</strong> <input type="text" readonly id="middle_name_view" class="input input-bordered w-full" value="<?php echo htmlspecialchars($profile['middle_name'] ?? ''); ?>"></p>
        <p><strong>Last Name:</strong> <input type="text" readonly id="last_name_view" class="input input-bordered w-full" value="<?php echo htmlspecialchars($profile['last_name'] ?? ''); ?>"></p>
        <p><strong>Gender:</strong> <input type="text" readonly id="gender_view" class="input input-bordered w-full" value="<?php echo htmlspecialchars($profile['gender'] ?? ''); ?>"></p>
        <p><strong>Phone:</strong> <input type="text" readonly id="contact_view" class="input input-bordered w-full" value="<?php echo htmlspecialchars($profile['contact'] ?? ''); ?>"></p>
        <p><strong>Address:</strong> <input type="text" readonly id="address_view" class="input input-bordered w-full" value="<?php echo htmlspecialchars($profile['address'] ?? ''); ?>"></p>
    </div>

    <div class="flex justify-between mt-4 max-w-md mx-auto">
        <button class="btn bg-sky-600 text-white" onclick="prof_modal.showModal()">Edit</button>
        <a href="home.php" class="btn bg-sky-600 text-white">Back</a>
    </div>
</div>

<!-- Edit Modal -->
<dialog id="prof_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-xl mb-3">Edit Profile</h3>

        <form id="updateProfileForm" enctype="multipart/form-data" class="space-y-3">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">

            <div class="text-center mb-4">
                <label class="font-semibold">Profile Image</label>
                <img src="../../Uploads/Client/<?php echo htmlspecialchars($profile['img'] ?? 'default.jpg'); ?>" 
                     id="profile_img_preview" class="w-24 h-24 rounded-full mx-auto mb-2" />
                <input type="file" name="profile_img" id="profile_img_input" class="input input-bordered w-full" />
            </div>

            <label>First Name</label>
            <input type="text" name="first_name" id="first_name" class="input input-bordered w-full">

            <label>Middle Name</label>
            <input type="text" name="middle_name" id="middle_name" class="input input-bordered w-full">

            <label>Last Name</label>
            <input type="text" name="last_name" id="last_name" class="input input-bordered w-full">

            <label>Gender</label>
            <select name="gender" id="gender" class="select select-bordered w-full">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label>Phone</label>
            <input type="text" name="contact" id="contact" class="input input-bordered w-full">

            <label>Address</label>
            <input type="text" name="address" id="address" class="input input-bordered w-full">

            <button type="submit" class="btn btn-success w-full">Save</button>
        </form>

        <div class="modal-action mt-2">
            <button class="btn bg-gray-400" onclick="prof_modal.close()">Close</button>
        </div>
    </div>
</dialog>


<?php include('footer.php'); ?>