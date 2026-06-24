<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();
$current_user = $_SESSION['user_id'];

check_login();
$current_user = $_SESSION['user_id'];
$f_pickup = trim($_GET['pickup'] ?? '');
$f_dest   = trim($_GET['destination'] ?? '');
$f_date   = trim($_GET['date'] ?? '');
$f_driver = trim($_GET['driver'] ?? '');

$sql = "
    SELECT t.*, u.name AS driver_name, u.gender AS driver_gender
    FROM trip t
    JOIN user u ON t.user_ID = u.user_ID
    WHERE t.status = 'Active' AND t.seats_available > 0
";

if ($f_pickup !== '') {
    $sql .= " AND t.origin LIKE '%" . $conn->real_escape_string($f_pickup) . "%'";
}
if ($f_dest !== '') {
    $sql .= " AND t.destination LIKE '%" . $conn->real_escape_string($f_dest) . "%'";
}
if ($f_date !== '') {
    $sql .= " AND DATE(t.departure) = '" . $conn->real_escape_string($f_date) . "'";
}
if ($f_driver !== '') {
    $sql .= " AND u.name LIKE '%" . $conn->real_escape_string($f_driver) . "%'";
}

$sql .= " ORDER BY t.departure ASC";

$res = $conn->query($sql);
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

    <form method="GET" action="explore_trips.php" class="search-filter-form">
        <div class="search-filter-row">
            <div class="form-group" style="margin-bottom:0;">
                <label>Pickup Location</label>
                <input type="text" name="pickup" placeholder="e.g. FTMK" value="<?php echo htmlspecialchars($f_pickup); ?>">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Destination</label>
                <input type="text" name="destination" placeholder="e.g. Mydin" value="<?php echo htmlspecialchars($f_dest); ?>">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Date</label>
                <input type="date" name="date" value="<?php echo htmlspecialchars($f_date); ?>">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Driver Name</label>
                <input type="text" name="driver" placeholder="Optional" value="<?php echo htmlspecialchars($f_driver); ?>">
            </div>
        </div>
        <div class="search-filter-actions">
            <button type="submit" class="btn btn-primary">🔍 Search</button>
            <a href="explore_trips.php" class="btn btn-secondary">Clear Filters</a>
        </div>
    </form>

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
                    <span class="badge-seats <?php echo $seats == 0 ? 'seats-full' : ''; ?>">💺 <?php echo $seats; ?> seat<?php echo $seats != 1 ? 's' : ''; ?> left</span>                    <span class="badge-driver-name">👤 <?php echo $driver; ?></span>
                    <span class="trip-pref-badge <?php echo $badge_class; ?>"><?php echo $pref; ?></span>
                </div>
            </div>
            <div class="trip-price-section">
                <div class="trip-cost">RM <?php echo $price; ?></div>
                <a href="join_trips.php?id=<?php echo $trip_id; ?>" class="btn btn-primary">Join Ride</a>
            </div>
        </div>
<?php endwhile; else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">🚗</div>
                <?php if ($f_pickup || $f_dest || $f_date || $f_driver): ?>
                    <p>No rides match your search filters.</p>
                    <p class="empty-state-link"><a href="explore_trips.php">Clear filters</a> and try again.</p>
                <?php else: ?>
                    <p>No active rides available right now.</p>
                    <p class="empty-state-link">Check back soon, or ask a friend who drives to post a ride!</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>