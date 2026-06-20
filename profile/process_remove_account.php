<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $password = $_POST['confirm_password'];

    // verify pass
    $query = "SELECT password FROM users WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // delete user bookings first
            $delete_bookings = "DELETE FROM bookings WHERE passenger_id = ? OR trip_id IN (SELECT id FROM trips WHERE driver_id = ?)";
            $delete_bookings_stmt = $connection->prepare($delete_bookings);
            $delete_bookings_stmt->bind_param('ii', $user_id, $user_id);
            $delete_bookings_stmt->execute();

            // delete user trips
            $delete_trips = "DELETE FROM trips WHERE driver_id = ?";
            $delete_trips_stmt = $connection->prepare($delete_trips);
            $delete_trips_stmt->bind_param('i', $user_id);
            $delete_trips_stmt->execute();

            // delete user account
            $delete_user = "DELETE FROM users WHERE id = ?";
            $delete_user_stmt = $connection->prepare($delete_user);
            $delete_user_stmt->bind_param('i', $user_id);
            
            if ($delete_user_stmt->execute()) {
                session_destroy();
                header('Location: ../auth/login.php?message=Account deleted successfully');
                exit();
            }
            $delete_user_stmt->close();
        } else {
            header('Location: remove_account.php?error=Invalid password');
            exit();
        }
    }
    $stmt->close();
} else {
    header('Location: profile.php');
    exit();
}
?>