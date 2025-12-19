<?php
require_once '../Classes/Client.php';
$client = new Users();

// Get POST data
$id = $_POST['id'] ?? 0;
$doctor_id = $_POST['doctor_id'] ?? 0;
$room = $_POST['room'] ?? '';

if($id && $doctor_id && $room){
    $success = $client->approveAppointment($id, $doctor_id, $room);
    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false, 'message' => 'Missing fields']);
}
