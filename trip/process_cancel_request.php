<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $request_id = intval($_POST['request_id']);

    $req = $conn->query("SELECT * FROM triprequest WHERE request_ID='$request_id' AND user_ID='$user_id'")->fetch_assoc();

    if (!$req) {
        header("Location: my_bookings.php");
        exit();
    }

    if ($req['status'] == 'Pending') {
        $conn->query("UPDATE triprequest SET status='Cancelled', response_time=NOW() WHERE request_ID='$request_id'");
    } elseif ($req['status'] == 'Confirmed') {
        $conn->query("UPDATE triprequest SET status='Cancelled', response_time=NOW() WHERE request_ID='$request_id'");
        $conn->query("UPDATE trip SET seats_available = seats_available + " . intval($req['seats_requested']) . " WHERE trip_ID='" . intval($req['trip_ID']) . "'");
    }

    header("Location: my_bookings.php?msg=cancelled");
    exit();
}

header("Location: my_bookings.php");
exit();
?>