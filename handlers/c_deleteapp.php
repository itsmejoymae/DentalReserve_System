<?php
require_once("../Classes/Client.php");
session_start();

if (!isset($_POST['id'])) {
    echo json_encode(["success" => false]);
    exit;
}

$client = new Users();
$delete = $client->deleteAppointment((int)$_POST['id']);

echo json_encode(["success" => $delete]);

