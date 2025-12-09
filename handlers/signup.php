<?php
include('../Classes/Client.php');
$clients = new Users();

if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    if ($password == '' && $email == '') {
        $response = array(
            'error' => "Email and Password is empty!",
        );
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = array(
            'error' => "Email is not valid!",
        );
    } else if ($email == '') {
        $response = array(
            'error' => "Email is empty!",
        );
    } else if ($password == '') {
        $response = array(
            'error' => "Password is empty!",
        );
    } else if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $response = array(
            'error' => "Password must be at least 8 characters long, include at least one uppercase letter and one number.",
        );
    } else if ($first == '' && $middle == '' && $last == '') {
        $response = array(
            'error' => "First Name, Middle Name, Last Name is Empty!",
        );
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert = $clients->signup($email, $hashed_password, $first, $middle, $last, $phone);
        if ($insert === 1) {
            $response = array(
                'success' => "Successfully Created an account!",
            );
        } else if ($insert === 2) {
            $response = array(
                'error' => "Email already exist",
            );
        } else if ($insert === 3) {
            $response = array(
                'error' => "Sorry, Failed to insert Data",
            );
        } else {
            $response = array(
                'error' => "Database error",
            );
        }
    }

    echo json_encode($response);
    exit;
}