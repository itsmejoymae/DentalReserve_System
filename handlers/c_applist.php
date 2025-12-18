<?php
require_once("../Classes/Client.php");
session_start();


if (!isset($_SESSION['id'])) {
    echo json_encode([
        "success" => false,
        "message" => "No session"
    ]);
    exit;
}

$user_id = (int) $_SESSION['id'];

$client = new Users();
$data = $client->displayAppointment($user_id);

echo json_encode([
    "success" => true,
    "data" => $data
]);
