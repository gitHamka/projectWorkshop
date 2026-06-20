<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

$user_id = $_SESSION['user_id'];

$requests = $conn->query("
    SELECT tr.*, t.origin, t.destination, t.departure, t.price, u.name AS driver_name
    FROM triprequest tr
    JOIN trip t ON tr.trip_ID = t.trip_ID
    JOIN user u ON t.user_ID = u.user_ID
    WHERE tr.user_ID='$user_id'
    ORDER BY tr.request_time DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <a href="../dashboard/dashboard.php" class="btn-back">← Back to Dashboard</a>
    <h2 class="page-heading">🎫 My Bookings</h2>
    <p class="page-subtext">Rides you've requested to join.</p>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'requested'): ?>
    <div class="alert-success">✅ Request sent! Waiting for driver approval.</div>
    <?php endif; ?>
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'already_requested'): ?>
    <div class="alert-info">ℹ️ You've already requested this ride.</div>
    <?php endif; ?>

    <div class="trip-grid">
        <?php if ($requests && $requests->num_rows > 0): ?>
            <?php while ($req = $requests->fetch_assoc()): ?>
                <div class="trip-card">
                    <div class="trip-info-block">
                        <div class="trip-locations">📍 <?php echo htmlspecialchars($req['origin']); ?> → <?php echo htmlspecialchars($req['destination']); ?></div>
                        <div class="trip-meta-row">
                            <span>🗓 <?php echo date('D, d M Y  •  h:i A', strtotime($req['departure'])); ?></span>
                            <span class="badge-driver-name">👤 <?php echo htmlspecialchars($req['driver_name']); ?></span>
                            <span class="badge-status badge-<?php echo strtolower($req['status']); ?>"><?php echo htmlspecialchars($req['status']); ?></span>
                        </div>
                    </div>
                    <div class="trip-price-section">
                        <div class="trip-cost">RM <?php echo number_format($req['price'] * $req['seats_requested'], 2); ?></div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
        <div class="empty-state">
            <p>No bookings yet.</p>
            <p class="empty-state-link"><a href="explore_trips.php">Find a ride →</a></p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>