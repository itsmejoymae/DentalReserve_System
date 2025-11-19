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
            return 3; //true
        }

        $stmt = $this->connect()->prepare('INSERT INTO user (username, pass, date) VALUES (?,?, NOW())');

        $stmt->bind_param('ss', $email, $hashed_password);
        $result = $stmt->execute();

        if ($result) {
            return 1; //true
        } else {
            return 2; //error
        }

        return $result;
    }

}
