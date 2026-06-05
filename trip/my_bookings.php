<?php
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/config/session_check.php';
check_login();

global $conn;
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Confirmed Bookings</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
</head>
<body>
<header>
    <div class="logo-container">GREENRIDE CAMPUS HUB</div>
    <nav><a href="../dashboard/dashboard.php">Dashboard</a><a href="../auth/logout.php">Logout</a></nav>
</header>
<div class="container">
    <h2>Your Reserved Passenger Rides</h2>
    <div class="trip-grid">
        <?php
        $res = $conn->query("SELECT b.id as booking_id, t.*, u.name as driver_name FROM bookings b JOIN trips t ON b.trip_id=t.id JOIN users u ON t.driver_id=u.id WHERE b.passenger_id='$user_id' AND b.status='Confirmed' ORDER BY b.id DESC");
        
        if ($res && $res->num_rows == 0) {
            echo "<p>No active ride pooling bookings found.</p>";
        } else {
            while($row = $res->fetch_assoc()) {
                $booking_id = $row['booking_id'];
                $pickup = htmlspecialchars($row['pickup']);
                $dropoff = htmlspecialchars($row['dropoff']);
                $driver_name = htmlspecialchars($row['driver_name']);
                $trip_date = htmlspecialchars($row['trip_date']);
                $trip_time = htmlspecialchars($row['trip_time']);
                $cost = htmlspecialchars($row['cost_share']);
                
                echo "<div class='trip-card'>";
                echo "<div class='trip-info-block'>";
                echo "<div class='trip-locations'>$pickup to $dropoff</div>";
                echo "<p>Driver: $driver_name</p>";
                echo "<div class='trip-meta-row'><span>Date: $trip_date</span><span>Time: $trip_time</span></div>";
                echo "</div>";
                echo "<div class='trip-price-section'>";
                echo "<div class='trip-cost'>RM $cost</div>";
                echo "<a href='cancel_booking.php?id=$booking_id' class='btn btn-danger'>Cancel</a>";
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
    </div>
</div>
<footer>
    <div class="footer-bottom">
        @2026 GREENRIDE CAMPUS - the OGs
    </div>
</footer>
</body>
</html>