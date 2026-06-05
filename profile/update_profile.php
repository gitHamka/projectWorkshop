<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "UPDATE users SET name='$name', phone='$phone', role='$role' WHERE id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;
        header("Location: profile.php?update=success");
    }
}
?>