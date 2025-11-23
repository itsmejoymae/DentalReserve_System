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

                $redirect = ($_SESSION['id'] === 35) ? '../public/admin/home.php' : '../public/client/home.php';
                return $redirect;
            } else {
                return 9; // wrong password
            }
        } else {
            return 8; // user not found
        }
    }
}
