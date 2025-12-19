<?php
require_once '../Classes/Client.php';

$client = new Users();


$approved = $client->countAppointmentsByStatus('Approved');

$pending = $client->countAppointmentsByStatus('Pending');


$total = $client->countAppointments();


$doctors = $client->countDoctors();

echo json_encode([
    'approved' => $approved,
    'pending' => $pending,
    'total' => $total,
    'doctors' => $doctors
]);
