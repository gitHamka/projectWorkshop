<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trip_id = intval($_POST['trip_id']);
    $pickup = $conn->real_escape_string($_POST['pickup']);
    $dropoff = $conn->real_escape_string($_POST['dropoff']);
    $trip_date = $conn->real_escape_string($_POST['trip_date']);
    $trip_time = $conn->real_escape_string($_POST['trip_time']);

    $conn->query("UPDATE trips SET pickup='$pickup', dropoff='$dropoff', trip_date='$trip_date', trip_time='$trip_time' WHERE id='$trip_id'");
    header("Location: driver_trips.php?update=success");
}
?>