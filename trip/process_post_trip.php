<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id  = $_SESSION['user_id'];
    $vehicle_id     = intval($_POST['vehicle_id']);
    $origin         = $conn->real_escape_string($_POST['origin']);
    $destination    = $conn->real_escape_string($_POST['destination']);
    $departure      = $conn->real_escape_string(str_replace('T', ' ', $_POST['departure']) . ':00');
    $seats_available = intval($_POST['seats_available']);
    $gender_preference = $conn->real_escape_string($_POST['gender_preference']);
    $price          = floatval($_POST['price']);
    $sql = "INSERT INTO trip (origin, destination, departure, seats_available, price, status, gender_preference, vehicle_ID, user_ID)
            VALUES ('$origin', '$destination', '$departure', '$seats_available', '$price', 'Active', '$gender_preference', '$vehicle_id', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../dashboard/dashboard.php?msg=trip_posted");
    } else {
        header("Location: post_trip.php?error=1");
    }
    exit();
}
header("Location: post_trip.php");
exit();
?>