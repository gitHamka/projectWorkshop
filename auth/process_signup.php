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

    // check duplicate matric num
    $existing_matric = $conn->query("SELECT user_ID FROM user WHERE matric_number='$matric_number' LIMIT 1")->fetch_assoc();
    if ($existing_matric) {
        header("Location: signup.php?error=duplicate_matric");
        exit();
    }

    // check duplicate email
    $existing_email = $conn->query("SELECT user_ID FROM user WHERE email='$email' LIMIT 1")->fetch_assoc();
    if ($existing_email) {
        header("Location: signup.php?error=duplicate_email");
        exit();
    }

    $sql = "INSERT INTO user (name, email, password, phone_number, role, matric_number, gender)
            VALUES ('$name', '$email', '$password', '$phone_number', '$role', '$matric_number', '$gender')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php?msg=signup_success");
        exit();
    } else {
        header("Location: signup.php?error=signup_failed");
        exit();
    }
}
?>