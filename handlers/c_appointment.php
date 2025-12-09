<?php
session_start();
include('../Classes/Client.php');
$clients = new Users();

if(isset($_POST['appointment'])) {

    $user_Id  = $_SESSION['id'];
    $date     = $_POST['date'] ?? '';
    $time     = $_POST['time'] ?? '';
    $app_type = $_POST['app_type'] ?? '';

    if ($date == '' && $time == '' && $app_type == '') {
        $response = ['error' => "Date, Time and Appointment type are required!"];
    } else if($date == '' && $app_type == '') {
        $response = ['error' => "Date and Appointment type are required!"];
    } else if($time == '' && $app_type == '') {
        $response = ['error' => "Time and Appointment type are required!"];
    } else if($date == '' && $time == '') {
        $response = ['error' => "Date and time are required!"];
    } elseif($date == '') {
        $response = ['error' => "Date is required!"];
    } elseif($time == '') {
        $response = ['error' => "Time is required!"];
    }elseif($app_type == '') {
        $response = ['error' => "Appointment type is required!"];
    } else {
        $appointment = $clients->set_appointment($user_Id, $date, $time, $app_type);

       if($appointment === 1){
            $response = ['success' => "Your appointment has been successfully scheduled. Waiting for admin approval."];
        }elseif($appointment === 2){
            $response = ['error' => "Failed to save appointment. Please try again."];
        }elseif($appointment === 3){
            $response = ['error' => "You already have an appointment scheduled at this date and time."];
        }else {
            $response = ['error' => "Unexpected error occurred."];
        }
    }
    echo json_encode($response);
    exit;
}
