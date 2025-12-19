<?php
require_once '../Classes/Client.php';

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Missing ID']);
    exit;
}

$doc = new Users();
$doctor = $doc->getDoctorById($_GET['id']);

echo json_encode($doctor);
