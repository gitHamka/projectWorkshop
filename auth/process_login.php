<?php
require_once dirname(__DIR__) . '/config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($conn) || $conn === null) {
        die("Database connection variable is missing or uninitialized.");
    }

    $matric_number = $conn->real_escape_string($_POST['matric_number']);
    $password      = $_POST['password'];

    $result = $conn->query("SELECT * FROM user WHERE matric_number='$matric_number'");
    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['user_ID'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            header("Location: ../index.php");
            exit();
        }
    }
    header("Location: login.php?error=invalid_credentials");
    exit();
}
?>
