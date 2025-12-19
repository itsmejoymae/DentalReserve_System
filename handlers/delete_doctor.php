<?php
require_once '../Classes/Client.php';
$doc = new Users();

$doc->deleteDoctor($_POST['id']);

echo json_encode(['success'=>true]);
