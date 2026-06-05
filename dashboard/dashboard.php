<?php
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/config/session_check.php';
check_login();

global $conn;
$user_id = $_SESSION['user_id'];
$view_role = isset($_GET['view']) ? $_GET['view'] : $_SESSION['user_role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
    <script src="../assets/js/dashboard.js"></script>
</head>
<body>
<header>
    <div class="logo-container">GREENRIDE CAMPUS HUB</div>
    <div>Logged in as: <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></div>
</header>
<div class="container dashboard-layout">
    <div class="sidebar">
        <h3>Navigation Menu</h3>
        <a href="dashboard.php" class="sidebar-btn btn-prof">Refresh Feed</a>
        <a href="../profile/profile.php" class="sidebar-btn btn-prof">My Profile</a>
        <?php if ($view_role == 'Driver'): ?>
            <a href="../trip/post_trip.php" class="sidebar-btn btn-req">Post a Ride</a>
            <a href="../trip/driver_trips.php" class="sidebar-btn btn-edit">My Posted Rides</a>
        <?php else: ?>
            <a href="../trip/explore_trips.php" class="sidebar-btn btn-req">Find a Ride</a>
            <a href="../trip/my_bookings.php" class="sidebar-btn btn-edit">My Bookings</a>
        <?php endif; ?>
        <a href="../safety/safetyPassenger.php" class="sidebar-btn btn-prof">Passenger Safety</a>
        <a href="../safety/safetyDriver.php" class="sidebar-btn btn-prof">Driver Safety</a>
        <a href="../safety/gender_preference_guide.php" class="sidebar-btn btn-prof">Gender Guide</a>
        <a href="../company/about_us.php" class="sidebar-btn btn-prof">About Us</a>
        <a href="../safety/sos.php" class="sidebar-btn btn-cancel" style="font-weight:bold;">EMERGENCY SOS</a>
        <a href="../auth/logout.php" class="sidebar-btn btn-cancel" style="margin-top:20px; background:#eee; color:#333;">Logout</a>
    </div>

    <div>
        <div class="card">
            <h2>Toggle Account View Perspective</h2>
            <div class="role-toggle-bar">
                <button class="role-toggle-btn <?php echo ($view_role == 'Passenger') ? 'active-passenger' : ''; ?>" onclick="switchDashboardRole('Passenger')">View as PASSENGER</button>
                <button class="role-toggle-btn <?php echo ($view_role == 'Driver') ? 'active-driver' : ''; ?>" onclick="switchDashboardRole('Driver')">View as DRIVER</button>
            </div>
        </div>

        <div class="map-container" style="display: flex; align-items: center; justify-content: center; font-weight: bold; color: #1B5E20;">
            [ Interactive UTeM Campus Route Map Simulation Area ]
        </div>

        <h2>Available Feed Actions Summary</h2>
        <div class="trip-grid">
            <?php
            if ($view_role == 'Driver') {
                $trips = $conn->query("SELECT * FROM trips WHERE driver_id='$user_id' ORDER BY id DESC");
                while($row = $trips->fetch_assoc()) {
                    $id = $row['id'];
                    $pickup = htmlspecialchars($row['pickup']);
                    $dropoff = htmlspecialchars($row['dropoff']);
                    $date = htmlspecialchars($row['trip_date']);
                    $time = htmlspecialchars($row['trip_time']);
                    $seats = htmlspecialchars($row['available_seats']);
                    $pref = htmlspecialchars($row['gender_preference']);
                    
                    echo "<div class='trip-card'>";
                    echo "<div class='trip-info-block'>";
                    echo "<div class='trip-locations'>$pickup to $dropoff</div>";
                    echo "<div class='trip-meta-row'><span>Date: $date</span><span>Time: $time</span></div>";
                    echo "<p>Seats Left: $seats | Preference: $pref</p>";
                    echo "</div>";
                    echo "<div class='trip-price-section'>";
                    echo "<a href='../trip/edit_trip.php?id=$id' class='btn btn-primary'>Edit Ride</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                $trips = $conn->query("SELECT t.*, u.name as driver_name FROM trips t JOIN users u ON t.driver_id=u.id WHERE t.status='Active' AND t.available_seats > 0 ORDER BY t.id DESC");
                while($row = $trips->fetch_assoc()) {
                    $id = $row['id'];
                    $pickup = htmlspecialchars($row['pickup']);
                    $dropoff = htmlspecialchars($row['dropoff']);
                    $driver = htmlspecialchars($row['driver_name']);
                    $cost = htmlspecialchars($row['cost_share']);
                    $pref = htmlspecialchars($row['gender_preference']);
                    
                    echo "<div class='trip-card'>";
                    echo "<div class='trip-info-block'>";
                    echo "<div class='trip-locations'>$pickup to $dropoff</div>";
                    echo "<p>Driver: $driver | Preference Rules: $pref</p>";
                    echo "</div>";
                    echo "<div class='trip-price-section'>";
                    echo "<div class='trip-cost'>RM $cost</div>";
                    echo "<a href='../trip/join_trips.php?id=$id' class='btn btn-primary'>Join Ride</a>";
                    echo "</div>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
</div>
<footer>
    <div class="footer-content">
        <div class="footer