<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

$user_id = $_SESSION['user_id'];

$name   = $conn->real_escape_string($_POST['name']);
$phone  = $conn->real_escape_string($_POST['phone']);
$role   = $conn->real_escape_string($_POST['role']);
$gender = $conn->real_escape_string($_POST['gender']);

$car_model    = $conn->real_escape_string($_POST['car_model']);
$plate_number = $conn->real_escape_string($_POST['plate_number']);
$color        = $conn->real_escape_string($_POST['color']);

// update user info
$conn->query("UPDATE user SET name='$name', phone_number='$phone', role='$role', gender='$gender' WHERE user_id='$user_id'");

// only if user fill vehicle fields 
if (!empty($car_model) && !empty($plate_number) && !empty($color)) {
    $existing = $conn->query("SELECT vehicle_ID FROM vehicle WHERE user_ID='$user_id' LIMIT 1")->fetch_assoc();

    if ($existing) {
        $conn->query("UPDATE vehicle SET model='$car_model', plate_number='$plate_number', color='$color' WHERE user_ID='$user_id'");
    } else {
        $conn->query("INSERT INTO vehicle (user_ID, model, plate_number, color) VALUES ('$user_id', '$car_model', '$plate_number', '$color')");
    }
}

$redirect = $_POST['redirect'] ?? 'profile';

switch ($redirect) {
    case 'post_trip':
        header("Location: ../trip/post_trip.php");
        break;
    default:
        header("Location: profile.php?updated=1");
        break;
}
exit();
?>