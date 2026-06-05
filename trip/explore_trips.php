<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Explore Active Trips</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
</head>
<body>
<div class="container">
    <h2>All Active Campus Carpooling Requests</h2>
    <div class="trip-grid">
        <?php
        $res = $conn->query("SELECT t.*, u.name FROM trips t JOIN users u ON t.driver_id=u.id WHERE t.status='Active' AND t.available_seats > 0");
        while($row = $res->fetch_assoc()) {
            echo "<div class='trip-card'>";
            echo "<div class='trip-route'>".$row['pickup']." - ".$row['dropoff']."</div>";
            echo "<p>Driver Account: ".$row['name']."</p>";
            echo "<p>Target Schedule Time: ".$row['trip_date']." @ ".$row['trip_time']."</p>";
            echo "<p>Budget Share: <strong>RM ".$row['cost_share']."</strong></p>";
            echo "<a href='join_trips.php?id=".$row['id']."' class='btn btn-primary'>Join & Book Seat</a>";
            echo "</div>";
        }
        ?>
    </div>
</div>
</body>
</html>