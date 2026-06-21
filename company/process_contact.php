<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $allowedDomain = 'student.utem.edu.my';
    $emailParts = explode('@', $email);
    $emailDomain = $emailParts[1] ?? '';

    if (strlen($name) < 3 || empty($email) || $emailDomain !== $allowedDomain || empty($message)) {
        header("Location: contact_us.php?error=invalid_input");
        exit();
    }

    $conn->query("INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')");
    header("Location: contact_us.php?msg=sent");
    exit();
}

header("Location: contact_us.php");
exit();
?>