<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $trip_id = (int)$_POST['trip_id'];
    $num_passengers = (int)$_POST['num_passengers'];

    // Check if trip exists and has available seats
    $check_query = "SELECT available_seats, current_passengers FROM trips WHERE id = ? AND driver_id != ?";
    $check_stmt = $connection->prepare($check_query);
    $check_stmt->bind_param('ii', $trip_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $trip = $check_result->fetch_assoc();
        $available = $trip['available_seats'] - $trip['current_passengers'];

        if ($num_passengers <= $available) {
            // Create booking
            $booking_query = "INSERT INTO bookings (trip_id, passenger_id, num_passengers, status, created_at) VALUES (?, ?, ?, 'pending', NOW())";
            $booking_stmt = $connection->prepare($booking_query);
            $booking_stmt->bind_param('iii', $trip_id, $user_id, $num_passengers);
            
            if ($booking_stmt->execute()) {
                header('Location: my_bookings.php?success=Request sent successfully');
                exit();
            } else {
                $error = "Error creating booking: " . $connection->error;
            }
            $booking_stmt->close();
        } else {
            $error = "Not enough seats available";
        }
    } else {
        $error = "Trip not found or unauthorized";
    }
    $check_stmt->close();
} else {
    header('Location: explore_trips.php');
    exit();
}
?>