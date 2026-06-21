<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

$user_id = $_SESSION['user_id'];

// Active bookings: trip not yet completed/cancelled, request not cancelled/rejected
$active_requests = $conn->query("
    SELECT tr.*, t.origin, t.destination, t.departure, t.price, t.status AS trip_status, u.name AS driver_name
    FROM triprequest tr
    JOIN trip t ON tr.trip_ID = t.trip_ID
    JOIN user u ON t.user_ID = u.user_ID
    WHERE tr.user_ID='$user_id'
      AND t.status NOT IN ('Completed')
    ORDER BY tr.request_time DESC
");

// History: only trips that are Completed (task requirement: history shows Completed only)
$history_requests = $conn->query("
    SELECT tr.*, t.origin, t.destination, t.departure, t.price, t.status AS trip_status, u.name AS driver_name
    FROM triprequest tr
    JOIN trip t ON tr.trip_ID = t.trip_ID
    JOIN user u ON t.user_ID = u.user_ID
    WHERE tr.user_ID='$user_id'
      AND t.status = 'Completed'
    ORDER BY t.departure DESC
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

    <div id="form-alert-success" class="alert-box alert-success" style="display:none;"></div>
    <div id="form-alert-info" class="alert-box alert-info" style="display:none;"></div>

    <div class="booking-tabs">
        <button class="tab-btn active" onclick="showTab('active', this)">Active Bookings</button>
        <button class="tab-btn" onclick="showTab('history', this)">History</button>
    </div>

    <div id="tab-active" class="trip-grid">
        <?php if ($active_requests && $active_requests->num_rows > 0): ?>
            <?php while ($req = $active_requests->fetch_assoc()): ?>
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
                        <?php if ($req['status'] == 'Pending'): ?>
                            <a href="edit_request.php?id=<?php echo $req['request_ID']; ?>" class="btn btn-secondary btn-sm">Edit</a>
                            <?php endif; ?>
                            <?php if (in_array($req['status'], ['Pending', 'Confirmed'])): ?>
                                <form action="process_cancel_request.php" method="POST" class="inline-form">
                                    <input type="hidden" name="request_id" value="<?php echo $req['request_ID']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Cancel this ride request?');">Cancel</button>
                                </form>
                                <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
        <div class="empty-state">
            <p>No active bookings.</p>
            <p class="empty-state-link"><a href="explore_trips.php">Find a ride →</a></p>
        </div>
        <?php endif; ?>
    </div>

    <div id="tab-history" class="trip-grid" style="display:none;">
        <?php if ($history_requests && $history_requests->num_rows > 0): ?>
            <?php while ($req = $history_requests->fetch_assoc()): ?>
                <div class="trip-card">
                    <div class="trip-info-block">
                        <div class="trip-locations">📍 <?php echo htmlspecialchars($req['origin']); ?> → <?php echo htmlspecialchars($req['destination']); ?></div>
                        <div class="trip-meta-row">
                            <span>🗓 <?php echo date('D, d M Y  •  h:i A', strtotime($req['departure'])); ?></span>
                            <span class="badge-driver-name">👤 <?php echo htmlspecialchars($req['driver_name']); ?></span>
                            <span class="badge-status badge-completed">Completed</span>
                        </div>
                    </div>
                    <div class="trip-price-section">
                        <div class="trip-cost">RM <?php echo number_format($req['price'] * $req['seats_requested'], 2); ?></div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
        <div class="empty-state">
            <p>No completed rides yet.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script src="../assets/js/my_bookings.js"></script>
</body>
</html>