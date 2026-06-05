<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if (isset($_GET['id'])) {
    $trip_id = intval($_GET['id']);
    $passenger_id = $_SESSION['user_id'];

    // Verify availability check boundary rules
    $trip = $conn->query("SELECT * FROM trips WHERE id='$trip_id'")->fetch_assoc();
    if ($trip && $trip['available_seats'] > 0) {
        $conn->query("INSERT INTO bookings (trip_id, passenger_id) VALUES ('$trip_id', '$passenger_id')");
        $conn->query("UPDATE trips SET available_seats = available_seats - 1 WHERE id='$trip_id'"); [cite: 1, 16]
        header("Location: my_bookings.php?booking=confirmed");
    } else {
        header("Location: explore_trips.php?error=no_seats");
    }
}
?>