<?php
session_start();
include('../Classes/Client.php');
$clients = new Users();

if (isset($_POST['update_profile'])) {

    $user_Id   = $_SESSION['id'];
    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $phone     = $_POST['phone'];
    $address   = $_POST['address'];

    if (empty($firstname) || empty($lastname) || empty($phone) || empty($address)) {
        $response = array(
            'error' => "All fields are required!",
        );
    } else {
        $result = $clients->updateProfile($user_Id, $firstname, $lastname, $phone, $address);

        if ($result === 1) {
            $response = array(
                'success' => "Profile updated successfully!",
            );
        } else {
            $response = array(
                'error' => "Failed to update profile. Please try again.",
            );
        }
    }

    echo json_encode($response);
    exit;
}
