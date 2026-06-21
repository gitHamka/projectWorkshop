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
$capacity     = intval($_POST['capacity'] ?? 4);

// update user info
$conn->query("UPDATE user SET name='$name', phone_number='$phone', role='$role', gender='$gender' WHERE user_id='$user_id'");

// only if user fill vehicle fields 
if (!empty($car_model) && !empty($plate_number) && !empty($color)) {
    $existing = $conn->query("SELECT vehicle_ID FROM vehicle WHERE user_ID='$user_id' LIMIT 1")->fetch_assoc();

    try {
        if ($existing) {
            $conn->query("UPDATE vehicle SET model='$car_model', plate_number='$plate_number', color='$color', capacity='$capacity' WHERE user_ID='$user_id'");
        } else {
            $conn->query("INSERT INTO vehicle (user_ID, model, plate_number, color, capacity) VALUES ('$user_id', '$car_model', '$plate_number', '$color', '$capacity')");
        }
    } catch (mysqli_sql_exception $e) {
        if (str_contains($e->getMessage(), 'Duplicate entry')) {
            $redirect = $_POST['redirect'] ?? 'profile';
            $target = ($redirect == 'post_trip') ? '../trip/post_trip.php' : 'edit_profile.php';
            header("Location: edit_profile.php?error=duplicate_plate");
            exit();
        } else {
            throw $e;
        }
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