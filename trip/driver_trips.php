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
    <title>My Offered Carpools</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
</head>
<body>
<header>
    <div class="logo-container">GREENRIDE CAMPUS HUB</div>
    <nav><a href="../dashboard/dashboard.php">Dashboard</a><a href="../auth/logout.php">Logout</a></nav>
</header>
<div class="container">
    <h2>Your Tracked Operational Driver Logs</h2>
    <div class="trip-grid">
        <?php
        $res = $conn->query("SELECT * FROM trips WHERE driver_id='$user_id' ORDER BY id DESC");
        
        if ($res && $res->num_rows == 0) {
            echo "<p>No offered trips found.</p>";
        } else {
            while($row = $res->fetch_assoc()) {
                $trip_id = $row['id'];
                $pickup = htmlspecialchars($row['pickup']);
                $dropoff = htmlspecialchars($row['dropoff']);
                $status = htmlspecialchars($row['status']);
                $trip_date = htmlspecialchars($row['trip_date']);
                $seats = htmlspecialchars($row['available_seats']);
                
                echo "<div class='trip-card'>";
                echo "<div class='trip-info-block'>";
                echo "<div class='trip-locations'>$pickup to $dropoff [$status]</div>";
                echo "<div class='trip-meta-row'><span>Date: $trip_date</span><span>Remaining Seats: $seats</span></div>";
                echo "</div>";
                echo "<div class='trip-price-section'>";
                echo "<a href='edit_trip.php?id=$trip_id' class='btn btn-primary'>Edit</a>";
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