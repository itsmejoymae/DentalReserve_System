<?php
require_once '../Classes/Client.php';
$client = new Users();

// Fetch all appointments
$appointments = $client->getAllAppointments();

// Return as JSON
echo json_encode(['data' => $appointments]);
