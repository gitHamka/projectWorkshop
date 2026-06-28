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

$departure_local = date('Y-m-d\TH:i', strtotime($trip['departure']));

$known_locations = [
    "FTMK / FAIX","FTKE","FTKEK","FTKIP","FTKM","PBB","Perpustakaan","Canselori",
    "Dewan Canselor","PKU","Pusat Sukan / Stadium","Masjid / Tasik 1 & 2",
    "Pusat Persatuan Pelajar","KK Satria","KK Lestari","KK Al-Jazari","Cafe 1","Cafe 2",
    "Cafe Satria","Cafe Lestari","FTKMP","FTKIP (Teknologi)","FPTT","Melaka Sentral",
    "Mydin MITC","Aeon Ayer Keroh","MITC","Ayer Keroh Heights","Bukit Beruang","Durian Tunggal"
];

$origin_is_known = in_array($trip['origin'], $known_locations);
$dest_is_known   = in_array($trip['destination'], $known_locations);

$origin_select_value = $origin_is_known ? $trip['origin'] : 'Lain-Lain';
$origin_other_value  = $origin_is_known ? '' : $trip['origin'];

$dest_select_value = $dest_is_known ? $trip['destination'] : 'Lain-Lain';
$dest_other_value  = $dest_is_known ? '' : $trip['destination'];
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
                    <select name="origin" id="origin" required onchange="handleLocationChange(this, 'origin_other')">
                        <option value="">-- Select Pickup --</option>
                        <optgroup label="🏫 Kampus Induk">
                            <option value="FTMK / FAIX" <?php echo $origin_select_value=='FTMK / FAIX'?'selected':''; ?>>FTMK / FAIX</option>
                            <option value="FTKE" <?php echo $origin_select_value=='FTKE'?'selected':''; ?>>FTKE</option>
                            <option value="FTKEK" <?php echo $origin_select_value=='FTKEK'?'selected':''; ?>>FTKEK</option>
                            <option value="FTKIP" <?php echo $origin_select_value=='FTKIP'?'selected':''; ?>>FTKIP</option>
                            <option value="FTKM" <?php echo $origin_select_value=='FTKM'?'selected':''; ?>>FTKM</option>
                            <option value="PBB" <?php echo $origin_select_value=='PBB'?'selected':''; ?>>PBB</option>
                            <option value="Perpustakaan" <?php echo $origin_select_value=='Perpustakaan'?'selected':''; ?>>Perpustakaan</option>
                            <option value="Canselori" <?php echo $origin_select_value=='Canselori'?'selected':''; ?>>Canselori</option>
                            <option value="Dewan Canselor" <?php echo $origin_select_value=='Dewan Canselor'?'selected':''; ?>>Dewan Canselor</option>
                            <option value="PKU" <?php echo $origin_select_value=='PKU'?'selected':''; ?>>PKU</option>
                            <option value="Pusat Sukan / Stadium" <?php echo $origin_select_value=='Pusat Sukan / Stadium'?'selected':''; ?>>Pusat Sukan / Stadium</option>
                            <option value="Masjid / Tasik 1 & 2" <?php echo $origin_select_value=='Masjid / Tasik 1 & 2'?'selected':''; ?>>Masjid / Tasik 1 &amp; 2</option>
                            <option value="Pusat Persatuan Pelajar" <?php echo $origin_select_value=='Pusat Persatuan Pelajar'?'selected':''; ?>>Pusat Persatuan Pelajar</option>
                            <option value="KK Satria" <?php echo $origin_select_value=='KK Satria'?'selected':''; ?>>KK Satria</option>
                            <option value="KK Lestari" <?php echo $origin_select_value=='KK Lestari'?'selected':''; ?>>KK Lestari</option>
                            <option value="KK Al-Jazari" <?php echo $origin_select_value=='KK Al-Jazari'?'selected':''; ?>>KK Al-Jazari</option>
                            <option value="Cafe 1" <?php echo $origin_select_value=='Cafe 1'?'selected':''; ?>>Cafe 1</option>
                            <option value="Cafe 2" <?php echo $origin_select_value=='Cafe 2'?'selected':''; ?>>Cafe 2</option>
                            <option value="Cafe Satria" <?php echo $origin_select_value=='Cafe Satria'?'selected':''; ?>>Cafe Satria</option>
                            <option value="Cafe Lestari" <?php echo $origin_select_value=='Cafe Lestari'?'selected':''; ?>>Cafe Lestari</option>
                        </optgroup>
                        <optgroup label="🏭 Kampus Teknologi">
                            <option value="FTKMP" <?php echo $origin_select_value=='FTKMP'?'selected':''; ?>>FTKMP</option>
                            <option value="FTKIP (Teknologi)" <?php echo $origin_select_value=='FTKIP (Teknologi)'?'selected':''; ?>>FTKIP (Teknologi)</option>
                            <option value="FPTT" <?php echo $origin_select_value=='FPTT'?'selected':''; ?>>FPTT</option>
                        </optgroup>
                        <optgroup label="🏙️ Off-Campus">
                            <option value="Melaka Sentral" <?php echo $origin_select_value=='Melaka Sentral'?'selected':''; ?>>Melaka Sentral</option>
                            <option value="Mydin MITC" <?php echo $origin_select_value=='Mydin MITC'?'selected':''; ?>>Mydin MITC</option>
                            <option value="Aeon Ayer Keroh" <?php echo $origin_select_value=='Aeon Ayer Keroh'?'selected':''; ?>>Aeon Ayer Keroh</option>
                            <option value="MITC" <?php echo $origin_select_value=='MITC'?'selected':''; ?>>MITC</option>
                            <option value="Ayer Keroh Heights" <?php echo $origin_select_value=='Ayer Keroh Heights'?'selected':''; ?>>Ayer Keroh Heights</option>
                            <option value="Bukit Beruang" <?php echo $origin_select_value=='Bukit Beruang'?'selected':''; ?>>Bukit Beruang</option>
                            <option value="Durian Tunggal" <?php echo $origin_select_value=='Durian Tunggal'?'selected':''; ?>>Durian Tunggal</option>
                        </optgroup>
                        <optgroup label="🏠 Lain-Lain">
                            <option value="Lain-Lain" <?php echo $origin_select_value=='Lain-Lain'?'selected':''; ?>>Lain-Lain (Hometown)</option>
                        </optgroup>
                    </select>
                    <input type="text" name="origin_other" id="origin_other"
                           placeholder="e.g. Seremban, Nilai, Tampin..."
                           value="<?php echo htmlspecialchars($origin_other_value); ?>"
                           style="<?php echo $origin_select_value=='Lain-Lain'?'':'display:none;'; ?> margin-top:8px;">
                </div>
                <div class="trip-location-swap">⇄</div>
                <div class="form-group" style="margin-bottom:0;">
                    <label>Dropoff Location</label>
                    <select name="destination" id="destination" required onchange="handleLocationChange(this, 'destination_other')">
                        <option value="">-- Select Dropoff --</option>
                        <optgroup label="🏫 Kampus Induk">
                            <option value="FTMK / FAIX" <?php echo $dest_select_value=='FTMK / FAIX'?'selected':''; ?>>FTMK / FAIX</option>
                            <option value="FTKE" <?php echo $dest_select_value=='FTKE'?'selected':''; ?>>FTKE</option>
                            <option value="FTKEK" <?php echo $dest_select_value=='FTKEK'?'selected':''; ?>>FTKEK</option>
                            <option value="FTKIP" <?php echo $dest_select_value=='FTKIP'?'selected':''; ?>>FTKIP</option>
                            <option value="FTKM" <?php echo $dest_select_value=='FTKM'?'selected':''; ?>>FTKM</option>
                            <option value="PBB" <?php echo $dest_select_value=='PBB'?'selected':''; ?>>PBB</option>
                            <option value="Perpustakaan" <?php echo $dest_select_value=='Perpustakaan'?'selected':''; ?>>Perpustakaan</option>
                            <option value="Canselori" <?php echo $dest_select_value=='Canselori'?'selected':''; ?>>Canselori</option>
                            <option value="Dewan Canselor" <?php echo $dest_select_value=='Dewan Canselor'?'selected':''; ?>>Dewan Canselor</option>
                            <option value="PKU" <?php echo $dest_select_value=='PKU'?'selected':''; ?>>PKU</option>
                            <option value="Pusat Sukan / Stadium" <?php echo $dest_select_value=='Pusat Sukan / Stadium'?'selected':''; ?>>Pusat Sukan / Stadium</option>
                            <option value="Masjid / Tasik 1 & 2" <?php echo $dest_select_value=='Masjid / Tasik 1 & 2'?'selected':''; ?>>Masjid / Tasik 1 &amp; 2</option>
                            <option value="Pusat Persatuan Pelajar" <?php echo $dest_select_value=='Pusat Persatuan Pelajar'?'selected':''; ?>>Pusat Persatuan Pelajar</option>
                            <option value="KK Satria" <?php echo $dest_select_value=='KK Satria'?'selected':''; ?>>KK Satria</option>
                            <option value="KK Lestari" <?php echo $dest_select_value=='KK Lestari'?'selected':''; ?>>KK Lestari</option>
                            <option value="KK Al-Jazari" <?php echo $dest_select_value=='KK Al-Jazari'?'selected':''; ?>>KK Al-Jazari</option>
                            <option value="Cafe 1" <?php echo $dest_select_value=='Cafe 1'?'selected':''; ?>>Cafe 1</option>
                            <option value="Cafe 2" <?php echo $dest_select_value=='Cafe 2'?'selected':''; ?>>Cafe 2</option>
                            <option value="Cafe Satria" <?php echo $dest_select_value=='Cafe Satria'?'selected':''; ?>>Cafe Satria</option>
                            <option value="Cafe Lestari" <?php echo $dest_select_value=='Cafe Lestari'?'selected':''; ?>>Cafe Lestari</option>
                        </optgroup>
                        <optgroup label="🏭 Kampus Teknologi">
                            <option value="FTKMP" <?php echo $dest_select_value=='FTKMP'?'selected':''; ?>>FTKMP</option>
                            <option value="FTKIP (Teknologi)" <?php echo $dest_select_value=='FTKIP (Teknologi)'?'selected':''; ?>>FTKIP (Teknologi)</option>
                            <option value="FPTT" <?php echo $dest_select_value=='FPTT'?'selected':''; ?>>FPTT</option>
                        </optgroup>
                        <optgroup label="🏙️ Off-Campus">
                            <option value="Melaka Sentral" <?php echo $dest_select_value=='Melaka Sentral'?'selected':''; ?>>Melaka Sentral</option>
                            <option value="Mydin MITC" <?php echo $dest_select_value=='Mydin MITC'?'selected':''; ?>>Mydin MITC</option>
                            <option value="Aeon Ayer Keroh" <?php echo $dest_select_value=='Aeon Ayer Keroh'?'selected':''; ?>>Aeon Ayer Keroh</option>
                            <option value="MITC" <?php echo $dest_select_value=='MITC'?'selected':''; ?>>MITC</option>
                            <option value="Ayer Keroh Heights" <?php echo $dest_select_value=='Ayer Keroh Heights'?'selected':''; ?>>Ayer Keroh Heights</option>
                            <option value="Bukit Beruang" <?php echo $dest_select_value=='Bukit Beruang'?'selected':''; ?>>Bukit Beruang</option>
                            <option value="Durian Tunggal" <?php echo $dest_select_value=='Durian Tunggal'?'selected':''; ?>>Durian Tunggal</option>
                        </optgroup>
                        <optgroup label="🏠 Lain-Lain">
                            <option value="Lain-Lain" <?php echo $dest_select_value=='Lain-Lain'?'selected':''; ?>>Lain-Lain (Hometown)</option>
                        </optgroup>
                    </select>
                    <input type="text" name="destination_other" id="destination_other"
                           placeholder="e.g. Seremban, Nilai, Tampin..."
                           value="<?php echo htmlspecialchars($dest_other_value); ?>"
                           style="<?php echo $dest_select_value=='Lain-Lain'?'':'display:none;'; ?> margin-top:8px;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:16px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label>Date & Time of Departure</label>
                    <input type="datetime-local" name="departure" value="<?php echo $departure_local; ?>" required>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label>Distance (km) — auto-filled, edit if needed</label>
                    <input type="number" name="distance_km" id="distance_km" step="0.1" min="0.1" value="<?php echo htmlspecialchars($trip['distance_km']); ?>" required oninput="updatePricePreview()">
                </div>
            </div>

            <div class="form-group">
                <label>Estimated Cost (RM)</label>
                <input type="text" id="price_preview" readonly value="RM <?php echo number_format($trip['price'], 2); ?>">
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
<script>updatePricePreview();</script>
</body>
</html>