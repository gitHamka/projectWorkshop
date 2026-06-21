<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

$current_user = $_SESSION['user_id'];

// fetch active trips w avail seats, join w user name
$res = $conn->query("
    SELECT t.*, u.name AS driver_name, u.gender AS driver_gender
    FROM trip t
    JOIN user u ON t.user_ID = u.user_ID
    WHERE t.status = 'Active' AND t.seats_available > 0
    ORDER BY t.departure ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Rides - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <a href="../dashboard/dashboard.php" class="btn-back">← Back to Dashboard</a>
    <h2 class="page-heading"> Explore Available Rides</h2>
    <p class="page-subtext">Find a ride that matches your schedule and route.</p>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'no_seats'): ?>
    <div class="alert-box alert-error">
        Sorry, that trip no longer has available seats.
    </div>
    <?php endif; ?>

    <div class="trip-grid">
        <?php if ($res && $res->num_rows > 0):
            while ($row = $res->fetch_assoc()):
                $trip_id   = $row['trip_ID'];
                $origin    = htmlspecialchars($row['origin']);
                $dest      = htmlspecialchars($row['destination']);
                $driver    = htmlspecialchars($row['driver_name']);
                $departure = date('D, d M Y  •  h:i A', strtotime($row['departure']));
                $seats     = $row['seats_available'];
                $price     = number_format($row['price'], 2);
                $pref      = htmlspecialchars($row['gender_preference'] ?? 'Mixed');
                $badge_class = 'badge-mixed';
                if ($pref === 'Female') $badge_class = 'badge-female';
                elseif ($pref === 'Male') $badge_class = 'badge-male';

                // skip own trips
                if ($row['user_ID'] == $current_user) continue;
        ?>
        <div class="trip-card">
            <div class="trip-info-block">
                <div class="trip-locations">📍 <?php echo $origin; ?> → <?php echo $dest; ?></div>
                <div class="trip-meta-row">
                    <span>🗓 <?php echo $departure; ?></span>
                    <span class="badge-seats">💺 <?php echo $seats; ?> seat<?php echo $seats > 1 ? 's' : ''; ?> left</span>
                    <span class="badge-driver-name">👤 <?php echo $driver; ?></span>
                    <span class="trip-pref-badge <?php echo $badge_class; ?>"><?php echo $pref; ?></span>
                </div>
            </div>
            <div class="trip-price-section">
                <div class="trip-cost">RM <?php echo $price; ?></div>
                <a href="join_trips.php?id=<?php echo $trip_id; ?>" class="btn btn-primary">Join Ride</a>
            </div>
        </div>
<<<<<<< HEAD
<?php endwhile; else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">🚗</div>
                <p>No active rides available right now.</p>
                <p class="empty-state-link">Check back soon, or ask a friend who drives to post a ride!</p>
            </div>
            <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>