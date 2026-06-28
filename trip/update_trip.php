<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trip_id     = intval($_POST['trip_id']);
    $user_id     = $_SESSION['user_id'];

    $origin = $_POST['origin'] === 'Lain-Lain'
        ? $conn->real_escape_string(trim($_POST['origin_other']))
        : $conn->real_escape_string($_POST['origin']);

    $destination = $_POST['destination'] === 'Lain-Lain'
        ? $conn->real_escape_string(trim($_POST['destination_other']))
        : $conn->real_escape_string($_POST['destination']);

    $departure   = $conn->real_escape_string(str_replace('T', ' ', $_POST['departure']) . ':00');
    $seats       = intval($_POST['seats_available']);
    $gender      = $conn->real_escape_string($_POST['gender_preference']);
    $status      = $conn->real_escape_string($_POST['status']);

    $rate_per_km = 0.50;
    $distance_km = floatval($_POST['distance_km']);
    $price = max(0.50, round($distance_km * $rate_per_km, 2));

    $conn->query("UPDATE trip
                  SET origin='$origin', 
                      destination='$destination', 
                      departure='$departure', 
                      distance_km='$distance_km',
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