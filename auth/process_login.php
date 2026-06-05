<?php
// Securely resolve absolute path to configuration file
require_once dirname(__DIR__) . '/config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure database connection object exists before using it
    if (!isset($conn) || $conn === null) {
        die("Database connection variable is missing or uninitialized.");
    }

    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            header("Location: ../dashboard/dashboard.php");
            exit();
        }
    }
    header("Location: login.php?error=invalid_credentials");
    exit();
}
?>