<?php
require_once("../Classes/Client.php");
session_start();

if (!isset($_POST['id'], $_POST['date'], $_POST['time'])) {
    echo json_encode(["success" => false, "error" => "Invalid input"]);
    exit;
}

$client = new Users();
$update = $client->updateAppointment(
    (int)$_POST['id'],
    $_POST['date'],
    $_POST['time']
);

echo json_encode(["success" => $update]);

