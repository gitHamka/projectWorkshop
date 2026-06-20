<?php
require_once dirname(__DIR__) . '/config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($conn) || $conn === null) {
        die("Database connection variable is missing or uninitialized.");
    }

    $name          = $conn->real_escape_string($_POST['name']);
    $email         = $conn->real_escape_string($_POST['email']);
    $password      = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $matric_number = $conn->real_escape_string($_POST['matric_id']);
    $phone_number  = $conn->real_escape_string($_POST['phone']);

    // tak collect gender & role kat signup
    $gender = '';
    $role   = 'Passenger';

    $sql = "INSERT INTO user (name, email, password, phone_number, role, matric_number, gender)
            VALUES ('$name', '$email', '$password', '$phone_number', '$role', '$matric_number', '$gender')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php?msg=signup_success");
        exit();
    } else {
        echo "Registration error: " . $conn->error;
    }
}
?>