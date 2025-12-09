<?php
include('../Classes/Client.php');
$clients = new Users();


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    if ($password == '' && $email == '') {
        $response = array(
            'error' => "Email and Password is empty!"
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
    } else {

        $signin = $clients->login($email, $password);

        if ($signin === 1) {
            $response = array(
                'error' => "Database error!",
            );
        } else if ($signin === 2) {
            $response = array(
                'error' => "user not found",
            );
        } else {
            $response = array(
                'redirect' => $signin
            );
        }
    }

    echo json_encode($response);
    exit;
}