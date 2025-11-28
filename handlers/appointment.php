<?php
session_start();
include('../Classes/Client.php');
$clients = new Users();


if (isset($_POST['appointment'])) {

    $user_Id  = $_SESSION['id']; // more secure
    $date     = $_POST['date'];
    $time     = $_POST['time'];
    $app_type = $_POST['app_type'];


    if ($date == '' && $time == '') {
        $response = array(
            'error' => "date and time is empty!",
        );
    } else if ($app_type == "") {
        $response = array(
            'error' => "Appointment type is empty",
        );
    } else {

        $appointment = $clients->appointment($user_Id, $date, $time, $app_type);

        if ($appointment === 1) {
            $response = array(
                'succes' => "Your Appointment Schedule is been SUCCESSFULLY save, 
                Waiting for the Admin to Approve Schedule",
            );
        } else if ($appointment === 2) {
            $response = array(
                'error' => "Please Try Again",
            );
        } else {
            $response = array(
                'error' => "Sorry, Feels like there is a problem in our system.",
            );
        }
    }

    echo json_encode($response);
    exit;
}
