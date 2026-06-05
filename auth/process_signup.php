<?php
// Securely resolve absolute path to configuration file
require_once dirname(__DIR__) . '/config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($conn) || $conn === null) {
        die("Database connection variable is missing or uninitialized.");
    }

    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $matric_id = $conn->real_escape_string($_POST['matric_id']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "INSERT INTO users (name, email, password, matric_id, gender, phone, role) VALUES ('$name', '$email', '$password', '$matric_id', '$gender', '$phone', '$role')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: login.php?msg=signup_success");
        exit();
    } else {
        echo "Registration error context: " . $conn->error;
    }
}
?>