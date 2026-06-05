<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

$user_id = $_SESSION['user_id'];
$conn->query("DELETE FROM users WHERE id='$user_id'");

session_destroy();
header("Location: ../auth/signup.php?msg=account_removed");
exit();
?>