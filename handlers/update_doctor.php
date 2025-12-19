<?php
require_once '../Classes/Client.php';

$img = null;
if (!empty($_FILES['img']['name'])) {
    $img = time().'_'.$_FILES['img']['name'];
    move_uploaded_file($_FILES['img']['tmp_name'], "../Uploads/Admin/$img");
}

$doc = new Users();
$doc->updateDoctor(
    $_POST['id'],
    $_POST['first_name'],
    $_POST['last_name'],
    $_POST['specialty'],
    $_POST['phone'],
    $img
);

echo json_encode(['success'=>true]);
