<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $driver_id = $_SESSION['user_id'];
    $pickup = $conn->real_escape_string($_POST['pickup']);
    $dropoff = $conn->real_escape_string($_POST['dropoff']);
    $trip_date = $conn->real_escape_string($_POST['trip_date']);
    $trip_time = $conn->real_escape_string($_POST['trip_time']);
    $available_seats = intval($_POST['available_seats']);
    $gender_preference = $conn->real_escape_string($_POST['gender_preference']);
    $cost_share = floatval($_POST['cost_share']);
    $notes = $conn->real_escape_string($_POST['notes']);

    $sql = "INSERT INTO trips (driver_id, pickup, dropoff, trip_date, trip_time, available_seats, gender_preference, cost_share, notes) 
            VALUES ('$driver_id', '$pickup', '$dropoff', '$trip_date', '$trip_time', '$available_seats', '$gender_preference', '$cost_share', '$notes')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../dashboard/dashboard.php?msg=trip_posted");
    }
}
?>