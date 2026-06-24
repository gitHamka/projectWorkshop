<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

if (!isset($_GET['id'])) {
    header("Location: driver_trips.php");
    exit();
}

$trip_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$res  = $conn->query("SELECT * FROM trip WHERE trip_ID='$trip_id' AND user_ID='$user_id'");
$trip = $res ? $res->fetch_assoc() : null;

if (!$trip) {
    header("Location: driver_trips.php?error=not_found");
    exit();
}

// format datetime
$departure_local = date('Y-m-d\TH:i', strtotime($trip['departure']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trip - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <a href="driver_trips.php" class="btn-back">← Back to My Trips</a>

    <div class="trip-form-card">
        <div class="trip-form-title">Edit Trip</div>
        <p class="trip-form-desc">Changes will apply to all pending requests for this trip.</p>

        <form action="update_trip.php" method="POST">
            <input type="hidden" name="trip_id" value="<?php echo $trip['trip_ID']; ?>">

            <div class="trip-location-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label>Pickup Location</label>
                    <input type="text" name="origin" value="<?php echo htmlspecialchars($trip['origin']); ?>" required>
                </div>
                <div class="trip-location-swap">⇄</div>
                <div class="form-group" style="margin-bottom:0;">
                    <label>Dropoff Location</label>
                    <input type="text" name="destination" value="<?php echo htmlspecialchars($trip['destination']); ?>" required>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:16px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label>Date & Time of Departure</label>
                    <input type="datetime-local" name="departure" value="<?php echo $departure_local; ?>" required>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label>Estimated Cost Share (RM)</label>
                    <input type="number" name="price" step="0.10" min="0.50" value="<?php echo htmlspecialchars($trip['price']); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Available Seats (excluding driver)</label>
                <div class="option-selector-group">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <div class="selector-item <?php echo $trip['seats_available'] == $i ? 'selected' : ''; ?>"
                             onclick="selectSeats(this, <?php echo $i; ?>)">
                            <?php echo $i; ?> Seat<?php echo $i > 1 ? 's' : ''; ?>
                        </div>
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="seats_available" id="seats_available" value="<?php echo htmlspecialchars($trip['seats_available']); ?>">
            </div>

            <div class="form-group">
                <label>Gender Preference</label>
                <div class="gender-selector-group">
                    <div class="selector-item <?php echo $trip['gender_preference'] == 'Mixed' ? 'selected' : ''; ?>"
                         onclick="selectGender(this, 'Mixed')">Mixed</div>
                    <div class="selector-item <?php echo $trip['gender_preference'] == 'Female' ? 'selected' : ''; ?>"
                         onclick="selectGender(this, 'Female')">Female Only</div>
                    <div class="selector-item <?php echo $trip['gender_preference'] == 'Male' ? 'selected' : ''; ?>"
                         onclick="selectGender(this, 'Male')">Male Only</div>
                </div>
                <input type="hidden" name="gender_preference" id="gender_preference" value="<?php echo htmlspecialchars($trip['gender_preference']); ?>">
            </div>

            <div class="form-group">
                <label>Trip Status</label>
                <div class="option-selector-group">
                    <?php foreach (['Active', 'Completed', 'Cancelled'] as $status): ?>
                        <div class="selector-item <?php echo $trip['status'] == $status ? 'selected' : ''; ?>"
                             onclick="selectStatus(this, '<?php echo $status; ?>')">
                            <?php echo $status; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="status" id="status" value="<?php echo htmlspecialchars($trip['status']); ?>">
            </div>

            <div class="trip-form-actions">
                <a href="driver_trips.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script src="../assets/js/edit_trip.js"></script>
</body>
</html>