<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $lat = isset($_POST['lat']) ? $conn->real_escape_string($_POST['lat']) : '0.0';
    $lng = isset($_POST['lng']) ? $conn->real_escape_string($_POST['lng']) : '0.0';

    $conn->query("INSERT INTO sos_alerts (user_id, latitude, longitude) VALUES ('$user_id', '$lat', '$lng')");
    echo json_encode(['status' => 'SOS_TRIGGERED_EMERGENCY_DISPATCHED']);
    exit();
}
?>