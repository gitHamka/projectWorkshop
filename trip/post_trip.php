<?php
require_once '../config/session_check.php';
require_once '../config/database.php';
check_login();

// fetch users vehicle, trip table FK)
$user_id = $_SESSION['user_id'];
$vehicle_res = $conn->query("SELECT vehicle_ID FROM vehicle WHERE user_ID='$user_id' LIMIT 1");
$vehicle = $vehicle_res ? $vehicle_res->fetch_assoc() : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Ride - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <a href="../dashboard/dashboard.php" class="btn-back">← Back to Dashboard</a>

    <?php if (!$vehicle): ?>
    <div class="trip-form-card">
        <div class="trip-form-title"> Post a Trip</div>
        <div class="trip-form-desc" style="margin-top:16px;">
            You need to register a vehicle before posting a trip.<br>
            Please update your profile to add your vehicle details.
        </div>
        <div style="text-align:center; margin-top:16px;">
            <a href="../profile/edit_profile.php?redirect=post_trip" class="btn btn-primary">Go to Profile</a>        </div>
    </div>
    <?php else: ?>
    <div class="trip-form-card">
        <div class="trip-form-title">🚗 Post a Trip</div>
        <p class="trip-form-desc"> As a driver, you can post your trip and passengers will join you. Passengers will pay the cost you set.</p>

        <form action="process_post_trip.php" method="POST">
            <input type="hidden" name="vehicle_id" value="<?php echo $vehicle['vehicle_ID']; ?>">

            <div class="trip-location-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label>Pickup Location</label>
                    <input type="text" name="origin" placeholder="e.g., FTMK" required>
                </div>
                <div class="trip-location-swap">⇄</div>
                <div class="form-group" style="margin-bottom:0;">
                    <label>Dropoff Location</label>
                    <input type="text" name="destination" placeholder="e.g., Kolej Lestari" required>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:16px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label>Date & Time of Departure</label>
                    <input type="datetime-local" name="departure" required>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label>Estimated Cost Share (RM)</label>
                    <input type="number" name="price" step="0.10" min="0.50" value="1.50" required>
                </div>
            </div>

            <div class="form-group">
                <label>Available Seats (excluding driver)</label>
                <div class="option-selector-group">
                    <div class="selector-item selected" onclick="selectSeats(this, 1)">1 Seat</div>
                    <div class="selector-item" onclick="selectSeats(this, 2)">2 Seats</div>
                    <div class="selector-item" onclick="selectSeats(this, 3)">3 Seats</div>
                    <div class="selector-item" onclick="selectSeats(this, 4)">4 Seats</div>
                </div>
                <input type="hidden" name="seats_available" id="seats_available" value="1">
            </div>

            <div class="form-group">
                <label>Gender Preference</label>
                <div class="gender-selector-group">
                    <div class="selector-item selected" onclick="selectGender(this, 'Mixed')">Mixed</div>
                    <div class="selector-item" onclick="selectGender(this, 'Female')">Female Only</div>
                    <div class="selector-item" onclick="selectGender(this, 'Male')">Male Only</div>
                </div>
                <input type="hidden" name="gender_preference" id="gender_preference" value="Mixed">
            </div>

            <div class="trip-form-actions">
                <a href="../dashboard/dashboard.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Publish Trip</button>
            </div>
        </form>
    </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>

<script>
function selectSeats(el, val) {
    document.querySelectorAll('.option-selector-group .selector-item').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('seats_available').value = val;
}
function selectGender(el, val) {
    document.querySelectorAll('.gender-selector-group .selector-item').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('gender_preference').value = val;
}
</script>
</body>
</html>
