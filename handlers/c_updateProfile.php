<?php
session_start();
include ('../Classes/Client.php');


if(isset($_POST['c_update'])){

    $user_id = (int)$_POST['user_id'];
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $gender = trim($_POST['gender']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $img_name = null;

    // Handle file upload
    if(isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === 0){
        $ext = strtolower(pathinfo($_FILES['profile_img']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if(!in_array($ext, $allowed)){
            echo json_encode(['error'=>'Invalid image type']); exit;
        }

        $img_name = uniqid('client_') . '.' . $ext;
       $upload_dir = __DIR__ . '/../Uploads/Client/'; // relative to handlers folder

        if(!is_dir($upload_dir)){
             mkdir($upload_dir, 0755, true);
        }

        if(!move_uploaded_file($_FILES['profile_img']['tmp_name'], $upload_dir . $img_name)){
            echo json_encode(['error'=>'Failed to upload image. Path: '.$upload_dir.$img_name]);
        exit;
        }

    }

    $users = new Users();
    $result = $users->updateProfile($user_id, $first_name, $middle_name, $last_name, $gender, $address, $contact, $img_name);

    if($result == 1){
        echo json_encode(['success'=>'Profile updated successfully']);
    } else {
        echo json_encode(['error'=>'Failed to update profile']);
    }

    exit;
}
echo json_encode(['error'=>'Invalid request']);
exit;
