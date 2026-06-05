<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

$trip_id = intval($_GET['id']);
$trip = $conn->query("SELECT * FROM trips WHERE id='$trip_id'")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Trip Parameters</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
<div class="auth-container">
    [cite_start]<h2>Modify Active Route Info [cite: 105]</h2>
    <form action="update_trip.php" method="POST">
        <input type="hidden" name="trip_id" value="<?php echo $trip['id']; ?>">
        <div class="form-group"><label>Pickup Location</label><input type="text" name="pickup" value="<?php echo $trip['pickup']; ?>" required></div> 
        <div class="form-group"><label>Dropoff Location</label><input type="text" name="dropoff" value="<?php echo $trip['dropoff']; ?>" required></div> 
        <div class="form-group"><label>Trip Date</label><input type="date" name="trip_date" value="<?php echo $trip['trip_date']; ?>" required></div> 
        <div class="form-group"><label>Trip Time</label><input type="time" name="trip_time" value="<?php echo $trip['trip_time']; ?>" required></div> 
        <button type="submit" class="btn btn-primary" style="width:100%;">Save Changes</button> 
    </form>
</div>
</body>
</html>