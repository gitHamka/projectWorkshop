<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if (!isset($_GET['id'])) {
    header("Location: explore_trips.php");
    exit();
}

$trip_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$res = $conn->query("
    SELECT t.*, u.name AS driver_name
    FROM trip t
    JOIN user u ON t.user_ID = u.user_ID
    WHERE t.trip_ID='$trip_id'
");
$trip = $res ? $res->fetch_assoc() : null;

if (!$trip) {
    header("Location: explore_trips.php?error=not_found");
    exit();
}

if ($trip['status'] != 'Active' || $trip['seats_available'] <= 0) {
    header("Location: explore_trips.php?error=no_seats");
    exit();
}

if ($trip['user_ID'] == $user_id) {
    header("Location: explore_trips.php");
    exit();
}

$existing = $conn->query("
    SELECT request_ID FROM triprequest 
    WHERE trip_ID='$trip_id' AND user_ID='$user_id' AND status IN ('Pending','Confirmed')
    LIMIT 1
")->fetch_assoc();

if ($existing) {
    header("Location: my_bookings.php?msg=already_requested");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Ride - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <a href="explore_trips.php" class="btn-back">← Back to Explore</a>

    <div class="trip-form-card">
        <div class="trip-form-title">🙋 Request to Join Ride</div>

        <div class="profile-section">
            <div class="trip-locations">📍 <?php echo htmlspecialchars($trip['origin']); ?> → <?php echo htmlspecialchars($trip['destination']); ?></div>
            <div class="trip-meta-row" style="margin-top:8px;">
                <span>🗓 <?php echo date('D, d M Y  •  h:i A', strtotime($trip['departure'])); ?></span>
                <span class="badge-seats">💺 <?php echo $trip['seats_available']; ?> seat<?php echo $trip['seats_available'] > 1 ? 's' : ''; ?> left</span>
                <span class="badge-driver-name">👤 <?php echo htmlspecialchars($trip['driver_name']); ?></span>
            </div>
            <div class="trip-cost" style="margin-top:10px;">RM <?php echo number_format($trip['price'], 2); ?> per seat</div>
        </div>

        <p class="trip-form-desc">Your request will be sent to the driver for approval. Seats are only reserved once confirmed.</p>

        <form action="process_join_trip.php" method="POST">
            <input type="hidden" name="trip_id" value="<?php echo $trip['trip_ID']; ?>">

            <div class="form-group">
                <label>Pickup Point</label>
                <input type="text" name="pickup_point" value="<?php echo htmlspecialchars($trip['origin']); ?>" required>
            </div>

            <div class="form-group">
                <label>Dropoff Point</label>
                <input type="text" name="dropoff_point" value="<?php echo htmlspecialchars($trip['destination']); ?>" required>
            </div>

            <div class="form-group">
                <label>Seats Needed</label>
                <div class="option-selector-group" style="grid-template-columns:repeat(<?php echo min($trip['seats_available'],4); ?>,1fr);">
                    <?php for ($i = 1; $i <= $trip['seats_available'] && $i <= 4; $i++): ?>
                        <div class="selector-item <?php echo $i == 1 ? 'selected' : ''; ?>" onclick="selectSeatsRequested(this, <?php echo $i; ?>)">
                            <?php echo $i; ?> Seat<?php echo $i > 1 ? 's' : ''; ?>
                        </div>
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="seats_requested" id="seats_requested" value="1">
            </div>

            <div class="form-group">
                <label>Note to Driver (optional)</label>
                <textarea name="passenger_note" rows="3" placeholder="e.g. I'll be near the main entrance"></textarea>
            </div>

            <div class="trip-form-actions">
                <a href="explore_trips.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Send Request</button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script src="../assets/js/join_trips.js"></script>
</body>
</html>