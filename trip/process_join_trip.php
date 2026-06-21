<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $trip_id = intval($_POST['trip_id']);
    $pickup_point = $conn->real_escape_string($_POST['pickup_point']);
    $dropoff_point = $conn->real_escape_string($_POST['dropoff_point']);
    $seats_requested = intval($_POST['seats_requested']);
    $passenger_note = $conn->real_escape_string($_POST['passenger_note']);

    $trip = $conn->query("SELECT * FROM trip WHERE trip_ID='$trip_id'")->fetch_assoc();

    if (!$trip || $trip['status'] != 'Active' || $trip['seats_available'] < $seats_requested) {
        header("Location: explore_trips.php?error=no_seats");
        exit();
    }

    $sql = "INSERT INTO triprequest (trip_ID, user_ID, seats_requested, pickup_point, dropoff_point, status, request_time, passenger_note, booking_ID)
        VALUES ('$trip_id', '$user_id', '$seats_requested', '$pickup_point', '$dropoff_point', 'Pending', NOW(), '$passenger_note', NULL)";
        
    if ($conn->query($sql) === TRUE) {
        header("Location: my_bookings.php?msg=requested");
    } else {
        header("Location: explore_trips.php?error=request_failed");
    }
    exit();
}

header("Location: explore_trips.php");
exit();
?>