<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trip_id     = intval($_POST['trip_id']);
    $user_id     = $_SESSION['user_id'];
    $origin      = $conn->real_escape_string($_POST['origin']);
    $destination = $conn->real_escape_string($_POST['destination']);
    $departure   = $conn->real_escape_string(str_replace('T', ' ', $_POST['departure']) . ':00');
    $price       = $conn->real_escape_string($_POST['price']);
    $seats       = intval($_POST['seats_available']);
    $gender      = $conn->real_escape_string($_POST['gender_preference']);
    $status      = $conn->real_escape_string($_POST['status']);

    $conn->query("UPDATE trip
                  SET origin='$origin', 
                      destination='$destination', 
                      departure='$departure', 
                      price='$price',
                      seats_available='$seats',
                      gender_preference='$gender',
                      status='$status'
                  WHERE trip_ID='$trip_id' AND user_ID='$user_id'");

    header("Location: driver_trips.php?update=success");
    exit();
}

header("Location: profile.php?updated=1");
exit();
?>