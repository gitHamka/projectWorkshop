<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if (!isset($_GET['trip_id'])) {
    header("Location: driver_trips.php");
    exit();
}

$trip_id = intval($_GET['trip_id']);
$user_id = $_SESSION['user_id'];

$trip = $conn->query("SELECT * FROM trip WHERE trip_ID='$trip_id' AND user_ID='$user_id'")->fetch_assoc();

if (!$trip) {
    header("Location: driver_trips.php?error=not_found");
    exit();
}

$requests = $conn->query("
    SELECT tr.*, u.name AS passenger_name, u.phone_number
    FROM triprequest tr
    JOIN user u ON tr.user_ID = u.user_ID
    WHERE tr.trip_ID='$trip_id'
    ORDER BY 
        CASE WHEN tr.status = 'Cancelled' THEN 0 ELSE 1 END,
        tr.request_time ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Requests - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <a href="driver_trips.php" class="btn-back">← Back to My Trips</a>

    <h2 class="page-heading">📋 Requests for this Ride</h2>
    <p class="page-subtext">
        <?php echo htmlspecialchars($trip['origin']); ?> → <?php echo htmlspecialchars($trip['destination']); ?>
        &nbsp;|&nbsp; 💺 <?php echo $trip['seats_available']; ?> seat<?php echo $trip['seats_available'] != 1 ? 's' : ''; ?> left
    </p>

    <?php
    $cancelled_count = $conn->query("SELECT COUNT(*) AS cnt FROM triprequest WHERE trip_ID='$trip_id' AND status='Cancelled'")->fetch_assoc()['cnt'];
    ?>
    <div id="form-alert-success" class="alert-box alert-success" style="display:none;"></div>
    <?php if ($cancelled_count > 0): ?>
    <div class="alert-box alert-error">
        ⚠️ <?php echo $cancelled_count; ?> passenger<?php echo $cancelled_count > 1 ? 's have' : ' has'; ?> cancelled their booking for this ride.
    </div>
    <?php endif; ?>

    <div class="trip-grid">
        <?php if ($requests && $requests->num_rows > 0): ?>
            <?php while ($req = $requests->fetch_assoc()): ?>
                <div class="trip-card">
                    <div class="trip-info-block">
                        <div class="trip-locations">👤 <?php echo htmlspecialchars($req['passenger_name']); ?></div>
                        <div class="trip-meta-row">
                            <span>📍 <?php echo htmlspecialchars($req['pickup_point']); ?> → <?php echo htmlspecialchars($req['dropoff_point']); ?></span>
                            <span class="badge-seats">💺 <?php echo $req['seats_requested']; ?> seat<?php echo $req['seats_requested'] != 1 ? 's' : ''; ?></span>
                            <span>📞 <?php echo htmlspecialchars($req['phone_number']); ?></span>
                        </div>
                        <?php if (!empty($req['passenger_note'])): ?>
                        <div class="trip-time">📝 "<?php echo htmlspecialchars($req['passenger_note']); ?>"</div>
                        <?php endif; ?>
                    </div>
                    <div class="trip-price-section">
                        <?php if ($req['status'] == 'Pending'): ?>
                            <div class="request-actions">
                                <form action="process_booking_response.php" method="POST" class="inline-form">
                                    <input type="hidden" name="request_id" value="<?php echo $req['request_ID']; ?>">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-primary btn-sm">Approve</button>
                                </form>
                                <form action="process_booking_response.php" method="POST" class="inline-form">
                                    <input type="hidden" name="request_id" value="<?php echo $req['request_ID']; ?>">
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            </div>
                        <?php else: ?>
                            <span class="badge-status badge-<?php echo strtolower($req['status']); ?>"><?php echo htmlspecialchars($req['status']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
        <div class="empty-state">
            <p>No requests yet for this ride.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
<script src="../assets/js/manage_request.js"></script>

</body>
</html>