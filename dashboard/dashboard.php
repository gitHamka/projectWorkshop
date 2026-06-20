<?php
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/config/session_check.php';
check_login();

global $conn;
$user_id   = $_SESSION['user_id'];
$view_role = isset($_GET['view']) ? $_GET['view'] : ($_SESSION['user_role'] ?? 'Passenger');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
    <script src="../assets/js/dashboard.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container dashboard-layout">
    <div class="sidebar">
        <a href="../index.php" class="btn-back">← Back to Home</a>
        <h3><center>Navigation Menu</center></h3>
        <a href="../profile/profile.php" class="sidebar-btn btn-prof">My Profile</a>
        <?php if ($view_role == 'Driver'): ?>
            <a href="../trip/post_trip.php" class="sidebar-btn btn-req">Post a Ride</a>
            <a href="../trip/driver_trips.php" class="sidebar-btn btn-edit">My Posted Rides</a>
        <?php else: ?>
            <a href="../trip/explore_trips.php" class="sidebar-btn btn-req">Request a Ride</a>
            <a href="../trip/my_bookings.php" class="sidebar-btn btn-edit">My Bookings</a>
        <?php endif; ?>
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
                $trips = $conn->query("SELECT * FROM trip WHERE user_ID='$user_id' ORDER BY trip_ID DESC");
                if ($trips && $trips->num_rows > 0) {
                    while ($row = $trips->fetch_assoc()) {
                        $id      = $row['trip_ID'];
                        $origin  = htmlspecialchars($row['origin']);
                        $dest    = htmlspecialchars($row['destination']);
                        $depart  = date('d M Y, h:i A', strtotime($row['departure']));
                        $seats   = $row['seats_available'];
                        $pref    = htmlspecialchars($row['gender_preference'] ?? 'Mixed');
                        $status  = htmlspecialchars($row['status']);
                        echo "<div class='trip-card'>";
                        echo "<div class='trip-info-block'>";
                        echo "<div class='trip-locations'>📍 $origin → $dest</div>";
                        echo "<div class='trip-meta-row'><span>🗓 $depart</span><span class='badge-seats'>💺 $seats seats left</span><span>$pref</span><span>$status</span></div>";
                        echo "</div>";
                        echo "<div class='trip-price-section'>";
                        echo "<a href='../trip/edit_trip.php?id=$id' class='btn btn-primary'>Edit Ride</a>";
                        echo "</div></div>";
                    }
                } else {
                    echo "<p style='color:var(--text-muted); padding:20px;'>No trips posted yet. <a href='../trip/post_trip.php' style='color:var(--accent-green);'>Post one now →</a></p>";
                }
            } else {
                $trips = $conn->query("SELECT t.*, u.name AS driver_name FROM trip t JOIN user u ON t.user_ID = u.user_ID WHERE t.status='Active' AND t.seats_available > 0 AND t.user_ID != '$user_id' ORDER BY t.departure ASC LIMIT 10");
                if ($trips && $trips->num_rows > 0) {
                    while ($row = $trips->fetch_assoc()) {
                        $id     = $row['trip_ID'];
                        $origin = htmlspecialchars($row['origin']);
                        $dest   = htmlspecialchars($row['destination']);
                        $driver = htmlspecialchars($row['driver_name']);
                        $price  = number_format($row['price'], 2);
                        $pref   = htmlspecialchars($row['gender_preference'] ?? 'Mixed');
                        $depart = date('d M Y, h:i A', strtotime($row['departure']));
                        echo "<div class='trip-card'>";
                        echo "<div class='trip-info-block'>";
                        echo "<div class='trip-locations'>📍 $origin → $dest</div>";
                        echo "<div class='trip-meta-row'><span>🗓 $depart</span><span class='badge-driver-name'>👤 $driver</span><span>$pref</span></div>";
                        echo "</div>";
                        echo "<div class='trip-price-section'>";
                        echo "<div class='trip-cost'>RM $price</div>";
                        echo "<a href='../trip/join_trips.php?id=$id' class='btn btn-primary'>Join Ride</a>";
                        echo "</div></div>";
                    }
                } else {
                    echo "<p style='color:var(--text-muted); padding:20px;'>No active rides available. Check back soon!</p>";
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
