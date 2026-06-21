<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $request_id = intval($_POST['request_id']);
    $pickup_point = $conn->real_escape_string($_POST['pickup_point']);
    $dropoff_point = $conn->real_escape_string($_POST['dropoff_point']);
    $seats_requested = intval($_POST['seats_requested']);
    $passenger_note = $conn->real_escape_string($_POST['passenger_note']);

    $req = $conn->query("
        SELECT tr.*, t.seats_available
        FROM triprequest tr
        JOIN trip t ON tr.trip_ID = t.trip_ID
        WHERE tr.request_ID='$request_id' AND tr.user_ID='$user_id'
    ")->fetch_assoc();

    if (!$req || $req['status'] != 'Pending') {
        header("Location: my_bookings.php");
        exit();
    }

    if ($seats_requested > $req['seats_available']) {
        header("Location: edit_request.php?id=$request_id&error=too_many_seats");
        exit();
    }

    $conn->query("
        UPDATE triprequest 
        SET pickup_point='$pickup_point', dropoff_point='$dropoff_point', seats_requested='$seats_requested', passenger_note='$passenger_note'
        WHERE request_ID='$request_id'
    ");

    header("Location: my_bookings.php?msg=updated");
    exit();
}

header("Location: my_bookings.php");
exit();
?>