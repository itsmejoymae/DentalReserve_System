<?php
require_once('Connection.php');

class Users extends Dbh
{

    public function signup($email, $hashed_password)
    {
        $search = $this->connect()->prepare('SELECT username FROM user WHERE username = ?');
        $search->bind_param('s', $email);
        $search->execute();
        $search->store_result();
        if ($search->num_rows > 0) {
            return 2;
        }

        $stmt = $this->connect()->prepare('INSERT INTO user (username, password, date) VALUES (?,?,NOW())');
        $stmt->bind_param('ss', $email, $hashed_password);
        $result = $stmt->execute();

        if ($result) {
            return 1;
        } else {
            return 3;
        }
    }

    public function login($email, $password)
    {
        session_start();
        $stmt = $this->connect()->prepare("SELECT id, username, password FROM user WHERE username = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                $redirect = ($_SESSION['id'] === 3) ? '../public/admin/home.php' : '../public/client/home.php';
                return $redirect;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }

    public function set_appointment($userId, $date, $time, $app_type)
    {
    $check = $this->connect()->prepare(
        "SELECT id FROM appointment WHERE user_id=? AND app_date=? AND app_time=?"
    );
    $check->bind_param("iss", $userId, $date, $time);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
        $check->close();
        return 3; // Duplicate appointment
    }
    $check->close();

    $stmt = $this->connect()->prepare( 
        "INSERT INTO appointment 
        (user_id, doctor_id, room, app_date, app_time, app_type, status, date_created)
        VALUES (?, NULL, NULL, ?, ?, ?, 'pending', NOW())"
    );

    if(!$stmt) return 2; 

    $stmt->bind_param("isss", $userId, $date, $time, $app_type);
    $result = $stmt->execute();
    $stmt->close();

    return $result ? 1 : 2;
    }

    public function getAppointmentCount($userId)
    {
        $stmt = $this->connect()->prepare("SELECT COUNT(*) as count FROM appointment WHERE user_id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }



    public function getProfile($user_id)
    {
    $stmt = $this->connect()->prepare("SELECT * FROM patients WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result ?: [];
    }

    public function updateProfile($user_id, $first, $middle, $last, $gender, $address, $contact, $img = null)
    {
    // Get old image
    $stmt = $this->connect()->prepare("SELECT img FROM patients WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $old = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $final_img = $img ?: $old['img'];

    $stmt = $this->connect()->prepare("
        UPDATE patients 
        SET first_name=?, middle_name=?, last_name=?, gender=?, address=?, contact=?, img=?
        WHERE user_id=?
    ");
    $stmt->bind_param("sssssssi", $first, $middle, $last, $gender, $address, $contact, $final_img, $user_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result ? 1 : 2;
    }


    
}