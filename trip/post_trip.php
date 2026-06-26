<?php
require_once '../config/session_check.php';
require_once '../config/database.php';
check_login();

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
        <div class="trip-form-title">Post a Trip</div>
        <div class="trip-form-desc" style="margin-top:16px;">
            You need to register a vehicle before posting a trip.<br>
            Please update your profile to add your vehicle details.
        </div>
        <div style="text-align:center; margin-top:16px;">
            <a href="../profile/edit_profile.php?redirect=post_trip" class="btn btn-primary">Go to Profile</a>
        </div>
    </div>
    <?php else: ?>
    <div class="trip-form-card">
        <div class="trip-form-title">🚗 Post a Trip</div>
        <p class="trip-form-desc">As a driver, you can post your trip and passengers will join you. Passengers will pay the cost you set.</p>

        <form action="process_post_trip.php" method="POST">
            <input type="hidden" name="vehicle_id" value="<?php echo $vehicle['vehicle_ID']; ?>">

            <div class="trip-location-row">

                <!-- pickup -->
                <div class="form-group" style="margin-bottom:0;">
                    <label>Pickup Location</label>
                    <select name="origin" id="origin" required>
                        <option value="">-- Select Pickup --</option>
                        <optgroup label="🏫 Kampus Induk">
                            <option value="FTMK / FAIX">FTMK / FAIX</option>
                            <option value="FTKE">FTKE</option>
                            <option value="FTKEK">FTKEK</option>
                            <option value="FTKIP">FTKIP</option>
                            <option value="FTKM">FTKM</option>
                            <option value="PBB">PBB</option>
                            <option value="Perpustakaan">Perpustakaan</option>
                            <option value="Canselori">Canselori</option>
                            <option value="Dewan Canselor">Dewan Canselor</option>
                            <option value="PKU">PKU</option>
                            <option value="Pusat Sukan / Stadium">Pusat Sukan / Stadium</option>
                            <option value="Masjid / Tasik 1 & 2">Masjid / Tasik 1 &amp; 2</option>
                            <option value="Pusat Persatuan Pelajar">Pusat Persatuan Pelajar</option>
                            <option value="KK Satria">KK Satria</option>
                            <option value="KK Lestari">KK Lestari</option>
                            <option value="KK Al-Jazari">KK Al-Jazari</option>
                            <option value="Cafe 1">Cafe 1</option>
                            <option value="Cafe 2">Cafe 2</option>
                            <option value="Cafe Satria">Cafe Satria</option>
                            <option value="Cafe Lestari">Cafe Lestari</option>
                        </optgroup>
                        <optgroup label="🏭 Kampus Teknologi">
                            <option value="FTKMP">FTKMP</option>
                            <option value="FTKIP (Teknologi)">FTKIP (Teknologi)</option>
                            <option value="FPTT">FPTT</option>
                        </optgroup>
                        <optgroup label="🏙️ Off-Campus">
                            <option value="Melaka Sentral">Melaka Sentral</option>
                            <option value="Mydin MITC">Mydin MITC</option>
                            <option value="Aeon Ayer Keroh">Aeon Ayer Keroh</option>
                            <option value="MITC">MITC</option>
                            <option value="Ayer Keroh Heights">Ayer Keroh Heights</option>
                            <option value="Bukit Beruang">Bukit Beruang</option>
                            <option value="Durian Tunggal">Durian Tunggal</option>
                        </optgroup>
                        <optgroup label="🏠 Lain-Lain">
                            <option value="Lain-Lain">Lain-Lain (Hometown)</option>
                        </optgroup>
                    </select>
                    <input type="text" name="origin_other" id="origin_other"
                           placeholder="e.g. Seremban, Nilai, Tampin..."
                           style="display:none; margin-top:8px;">
                </div>

                <div class="trip-location-swap">⇄</div>

                <!-- dropoff -->
                <div class="form-group" style="margin-bottom:0;">
                    <label>Dropoff Location</label>
                    <select name="destination" id="destination" required>
                        <option value="">-- Select Dropoff --</option>
                        <optgroup label="🏫 Kampus Induk">
                            <option value="FTMK / FAIX">FTMK / FAIX</option>
                            <option value="FTKE">FTKE</option>
                            <option value="FTKEK">FTKEK</option>
                            <option value="FTKIP">FTKIP</option>
                            <option value="FTKM">FTKM</option>
                            <option value="PBB">PBB</option>
                            <option value="Perpustakaan">Perpustakaan</option>
                            <option value="Canselori">Canselori</option>
                            <option value="Dewan Canselor">Dewan Canselor</option>
                            <option value="PKU">PKU</option>
                            <option value="Pusat Sukan / Stadium">Pusat Sukan / Stadium</option>
                            <option value="Masjid / Tasik 1 & 2">Masjid / Tasik 1 &amp; 2</option>
                            <option value="Pusat Persatuan Pelajar">Pusat Persatuan Pelajar</option>
                            <option value="KK Satria">KK Satria</option>
                            <option value="KK Lestari">KK Lestari</option>
                            <option value="KK Al-Jazari">KK Al-Jazari</option>
                            <option value="Cafe 1">Cafe 1</option>
                            <option value="Cafe 2">Cafe 2</option>
                            <option value="Cafe Satria">Cafe Satria</option>
                            <option value="Cafe Lestari">Cafe Lestari</option>
                        </optgroup>
                        <optgroup label="🏭 Kampus Teknologi">
                            <option value="FTKMP">FTKMP</option>
                            <option value="FTKIP (Teknologi)">FTKIP (Teknologi)</option>
                            <option value="FPTT">FPTT</option>
                        </optgroup>
                        <optgroup label="🏙️ Off-Campus">
                            <option value="Melaka Sentral">Melaka Sentral</option>
                            <option value="Mydin MITC">Mydin MITC</option>
                            <option value="Aeon Ayer Keroh">Aeon Ayer Keroh</option>
                            <option value="MITC">MITC</option>
                            <option value="Ayer Keroh Heights">Ayer Keroh Heights</option>
                            <option value="Bukit Beruang">Bukit Beruang</option>
                            <option value="Durian Tunggal">Durian Tunggal</option>
                        </optgroup>
                        <optgroup label="🏠 Lain-Lain">
                            <option value="Lain-Lain">Lain-Lain (Hometown)</option>
                        </optgroup>
                    </select>
                    <input type="text" name="destination_other" id="destination_other"
                           placeholder="e.g. Seremban, Nilai, Tampin..."
                           style="display:none; margin-top:8px;">
                </div>

            </div>

            <!-- departure + price -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:16px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label>Date & Time of Departure</label>
                    <input type="datetime-local" name="departure" id="departure" required>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label>Estimated Cost Share (RM)</label>
                    <input type="number" name="price" id="price" step="0.10" min="0.50" value="1.50" required>
                </div>
            </div>

            <!-- seats -->
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

            <!--gender pref -->
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

// lainlain toggle origin
document.getElementById('origin').addEventListener('change', function() {
    const other = document.getElementById('origin_other');
    if (this.value === 'Lain-Lain') {
        other.style.display = 'block';
        other.required = true;
    } else {
        other.style.display = 'none';
        other.required = false;
        other.value = '';
    }
});

// lainlain toggle desti
document.getElementById('destination').addEventListener('change', function() {
    const other = document.getElementById('destination_other');
    if (this.value === 'Lain-Lain') {
        other.style.display = 'block';
        other.required = true;
    } else {
        other.style.display = 'none';
        other.required = false;
        other.value = '';
    }
});
</script>
</body>
</html>