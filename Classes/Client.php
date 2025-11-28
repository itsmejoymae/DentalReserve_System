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
            return 3; // email already exists
        }

        $stmt = $this->connect()->prepare('INSERT INTO user (username, password, date) VALUES (?,?, NOW())');
        $stmt->bind_param('ss', $email, $hashed_password);
        $result = $stmt->execute();

        if ($result) {
            return 1; // inserted successfully
        } else {
            return 2; // database error
        }
    }

    public function signin($email, $password)
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

                $redirect = ($_SESSION['id'] === 1) ? '../public/admin/home.php' : '../public/client/home.php';
                return $redirect;
            } else {
                return 9;
            }
        } else {
            return 8;
        }
    }

    public function appointment($userId, $date, $time, $app_type)
    {
        $stmt = $this->connect()->prepare(
            "INSERT INTO appointment (user_id, date, time, app_type) VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param("isss", $userId, $date, $time, $app_type);

        if ($stmt->execute()) {
            return 1;
        } else {
            return 2;
        }
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

    public function getProfile($userId)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM patient WHERE user_id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateProfile($userId, $firstname, $lastname, $phone, $address)
    {
        $profile = $this->getProfile($userId);

        if ($profile) {
            $stmt = $this->connect()->prepare("UPDATE patient SET first_name = ?, last_name = ?, phone = ?, address = ? WHERE user_id = ?");
            $stmt->bind_param('ssssi', $firstname, $lastname, $phone, $address, $userId);
        } else {
            $stmt = $this->connect()->prepare("INSERT INTO patient (user_id, first_name, last_name, phone, address) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('issss', $userId, $firstname, $lastname, $phone, $address);
        }

        if ($stmt->execute()) {
            return 1;
        } else {
            return 2;
        }
    }
}
