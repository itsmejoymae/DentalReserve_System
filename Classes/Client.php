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

    // Set appointment
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
        return 3; 
    }
    $check->close();

    $stmt = $this->connect()->prepare( 
        "INSERT INTO appointment 
        (user_id, doctor_id, room, app_date, app_time, app_type, status, date_created)
        VALUES (?, NULL, NULL, ?, ?, ?, 'Pending', NOW())"
    );

    if(!$stmt) return 2; 

    $stmt->bind_param("isss", $userId, $date, $time, $app_type);
    $result = $stmt->execute();
    $stmt->close();

    return $result ? 1 : 2;
    }

    // Fetch profile
    public function getProfile($user_id)
    {
    $stmt = $this->connect()->prepare("SELECT * FROM patients WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result ?: [];
    }

    // Update profile
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


    // Display appointment
    public function displayAppointment($user_id)
    {
    $sql = "
        SELECT
            a.id,
            COALESCE(p.first_name, 'Unknown') AS first_name,
            COALESCE(p.middle_name, '') AS middle_name,
            COALESCE(p.last_name, 'Patient') AS last_name,
            COALESCE(p.address, '—') AS address,
            COALESCE(p.contact, '—') AS contact,
            COALESCE(p.img, '-') AS img,

            COALESCE(
                CONCAT(d.first_name, ' ', d.last_name),
                'Not Assigned'
            ) AS doctor_name,

            COALESCE(a.room, 'Not Assigned') AS room,
            a.status,
            a.app_type,
            a.app_date,
            a.app_time,
            a.date_created

        FROM appointment a
        LEFT JOIN patients p ON a.user_id = p.user_id
        LEFT JOIN doctor d ON a.doctor_id = d.id
        WHERE a.user_id = ?
        ORDER BY a.date_created DESC
    ";

    $stmt = $this->connect()->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Update appointment
    public function updateAppointment($app_id, $date, $time)
    {
    $sql = "
        UPDATE appointment
        SET app_date = ?, app_time = ?, status = 'Pending'
        WHERE id = ?
    ";

    $stmt = $this->connect()->prepare($sql);
    $stmt->bind_param("ssi", $date, $time, $app_id);
    return $stmt->execute();
    }

    // Delete appointment
    public function deleteAppointment($app_id)
    {
    $sql = "DELETE FROM appointment WHERE id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bind_param("i", $app_id);
    return $stmt->execute();
    }

    // Display all doctors
     public function getAllDoctors() {
        $sql = "SELECT * FROM doctor ORDER BY last_name ASC";
        return $this->connect()->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    // VIEW Specific Doctor
    public function getDoctorById($id)
{
    $sql = "SELECT * FROM doctor WHERE id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

    // Add doctor
    public function addDoctor($fn, $ln, $sp, $ph, $img) {
        $stmt = $this->connect()->prepare(
            "INSERT INTO doctor (first_name,last_name,specialty,phone,img)
             VALUES (?,?,?,?,?)"
        );
        $stmt->bind_param("sssss", $fn, $ln, $sp, $ph, $img);
        return $stmt->execute();
    }

    // Update doctor
    public function updateDoctor($id, $fn, $ln, $sp, $ph, $img=null) {
        if ($img) {
            $stmt = $this->connect()->prepare(
                "UPDATE doctor SET first_name=?, last_name=?, specialty=?, phone=?, img=? WHERE id=?"
            );
            $stmt->bind_param("sssssi", $fn, $ln, $sp, $ph, $img, $id);
        } else {
            $stmt = $this->connect()->prepare(
                "UPDATE doctor SET first_name=?, last_name=?, specialty=?, phone=? WHERE id=?"
            );
            $stmt->bind_param("ssssi", $fn, $ln, $sp, $ph, $id);
        }
        return $stmt->execute();
    }

    //Delete doctor
    public function deleteDoctor($id) {
        $stmt = $this->connect()->prepare("DELETE FROM doctor WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }


    // Disply all appointments with patient and doctor
    public function getAllAppointments() {
        $sql = "SELECT a.id, a.user_id, a.doctor_id, a.room, a.app_date, a.app_time, a.app_type, a.status,
                   p.first_name AS patient_first, p.last_name AS patient_last, p.img AS patient_img,
                   d.first_name AS doctor_first, d.last_name AS doctor_last
            FROM appointment a
            LEFT JOIN patients p ON a.user_id = p.user_id
            LEFT JOIN doctor d ON a.doctor_id = d.id
            ORDER BY a.app_date DESC, a.app_time DESC";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Approve appointment, Assign doctor, room, and update status
    public function approveAppointment($id, $doctor_id, $room) {
        $sql = "UPDATE appointment SET doctor_id=?, room=?, status='Approved' WHERE id=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bind_param("isi", $doctor_id, $room, $id);
        return $stmt->execute();
    }

    //Display Appointment Counts
    public function countAppointmentsByStatus($status) {
    $sql = "SELECT COUNT(*) as cnt FROM appointment WHERE status = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bind_param('s', $status);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['cnt'] ?? 0;
    }

    // Count Appointments
    public function countAppointments() {
    $sql = "SELECT COUNT(*) as cnt FROM appointment";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['cnt'] ?? 0;
    }

    //Count doctors
    public function countDoctors() {
    $sql = "SELECT COUNT(*) as cnt FROM doctor";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['cnt'] ?? 0;
    }
}