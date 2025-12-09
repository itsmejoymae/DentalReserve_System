<?php
session_start();
include ('../Classes/Client.php');

if(isset($_POST['view'], $_POST['user_id'])){
    $user_id = (int)$_POST['user_id'];
    $users = new Users();
    $profile = $users->getProfile($user_id);

    if($profile){
        echo json_encode(['success'=>true, 'data'=>$profile]);
    } else {
        echo json_encode(['success'=>false, 'error'=>'Profile not found']);
    }
    exit;
}

echo json_encode(['success'=>false, 'error'=>'Invalid request']);
exit;
