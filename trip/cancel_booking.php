<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if (isset($_GET['id'])) {
    $booking_id = intval($_GET['id']);
    
    $booking = $conn->query("SELECT * FROM bookings WHERE id='$booking_id'")->fetch_assoc();
    if ($booking) {
        $trip_id = $booking['trip_id'];
        $conn->query("UPDATE bookings SET status='Cancelled' WHERE id='$booking_id'");
        $conn->query("UPDATE trips SET available_seats = available_seats + 1 WHERE id='$trip_id'");
    }
    header("Location: my_bookings.php?msg=cancelled");
}
?>