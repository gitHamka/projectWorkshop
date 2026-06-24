<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $request_id = intval($_POST['request_id']);
    $action = $_POST['action'];

    $req = $conn->query("
        SELECT tr.*, t.user_ID AS driver_id, t.seats_available, t.trip_ID
        FROM triprequest tr
        JOIN trip t ON tr.trip_ID = t.trip_ID
        WHERE tr.request_ID='$request_id'
    ")->fetch_assoc();

    if (!$req || $req['driver_id'] != $user_id || $req['status'] != 'Pending') {
        header("Location: driver_trips.php");
        exit();
    }

    if ($action == 'approve') {
        $seats_requested = (int)$req['seats_requested'];
        $trip_id = (int)$req['trip_ID'];

        // Atomic guard: only deduct if enough seats remain at the moment of update.
        // Prevents overbooking if two approvals happen at nearly the same time.
        $conn->query("UPDATE trip SET seats_available = seats_available - $seats_requested
                      WHERE trip_ID='$trip_id' AND seats_available >= $seats_requested");

        if ($conn->affected_rows === 0) {
            header("Location: manage_request.php?trip_id=" . $trip_id . "&error=no_seats");
            exit();
        }

        $conn->query("UPDATE triprequest SET status='Confirmed', response_time=NOW() WHERE request_ID='$request_id'");

        header("Location: manage_request.php?trip_id=" . $trip_id . "&msg=approved");
    } else {
        $conn->query("UPDATE triprequest SET status='Rejected', response_time=NOW() WHERE request_ID='$request_id'");
        header("Location: manage_request.php?trip_id=" . $req['trip_ID'] . "&msg=rejected");
    }
    exit();
}

header("Location: driver_trips.php");
exit();
?>