<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if (!isset($_GET['id'])) {
    header("Location: my_bookings.php");
    exit();
}

$request_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$req = $conn->query("
    SELECT tr.*, t.origin, t.destination, t.seats_available, t.trip_ID
    FROM triprequest tr
    JOIN trip t ON tr.trip_ID = t.trip_ID
    WHERE tr.request_ID='$request_id' AND tr.user_ID='$user_id'
")->fetch_assoc();

if (!$req || $req['status'] != 'Pending') {
    header("Location: my_bookings.php");
    exit();
}

$max_seats = $req['seats_available'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Request - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <a href="my_bookings.php" class="btn-back">← Back to My Bookings</a>

    <div class="trip-form-card">
        <div class="trip-form-title">✏️ Edit Your Request</div>

        <div class="profile-section">
            <div class="trip-locations">📍 <?php echo htmlspecialchars($req['origin']); ?> → <?php echo htmlspecialchars($req['destination']); ?></div>
        </div>

        <form action="process_edit_request.php" method="POST">
            <input type="hidden" name="request_id" value="<?php echo $req['request_ID']; ?>">

            <div class="form-group">
                <label>Pickup Point</label>
                <input type="text" name="pickup_point" value="<?php echo htmlspecialchars($req['pickup_point']); ?>" required>
            </div>

            <div class="form-group">
                <label>Dropoff Point</label>
                <input type="text" name="dropoff_point" value="<?php echo htmlspecialchars($req['dropoff_point']); ?>" required>
            </div>

            <div class="form-group">
                <label>Seats Needed</label>
                <div class="option-selector-group" style="grid-template-columns:repeat(<?php echo min($max_seats,4); ?>,1fr);">
                    <?php for ($i = 1; $i <= $max_seats && $i <= 4; $i++): ?>
                        <div class="selector-item <?php echo $i == $req['seats_requested'] ? 'selected' : ''; ?>" onclick="selectSeatsRequested(this, <?php echo $i; ?>)">
                            <?php echo $i; ?> Seat<?php echo $i > 1 ? 's' : ''; ?>
                        </div>
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="seats_requested" id="seats_requested" value="<?php echo $req['seats_requested']; ?>">
            </div>

            <div class="form-group">
                <label>Note to Driver (optional)</label>
                <textarea name="passenger_note" rows="3"><?php echo htmlspecialchars($req['passenger_note'] ?? ''); ?></textarea>
            </div>

            <div class="trip-form-actions">
                <a href="my_bookings.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Request</button>
            </div>
        </form>

        <form action="process_cancel_request.php" method="POST" class="cancel-request-form">
            <input type="hidden" name="request_id" value="<?php echo $req['request_ID']; ?>">
            <button type="submit" class="btn btn-danger btn-full" onclick="return confirm('Cancel this ride request?');">🗑 Cancel Request</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script src="../assets/js/join_trips.js"></script>
</body>
</html>