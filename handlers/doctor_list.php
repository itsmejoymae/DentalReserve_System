<?php
require_once '../Classes/Client.php';
$doc = new Users();

echo json_encode([
    'data' => $doc->getAllDoctors()
]);
