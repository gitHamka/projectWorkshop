<?php require_once '../config/session_check.php'; check_login(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Emergency SOS Campus Portal</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/safety.css">
</head>
<body>
<div class="container" style="text-align:center;">
    <h1 style="color:red;">EMERGENCY SOS SYSTEM</h1>
    <p>Pressing the button below instantly transmits security coords to campus administration control rooms.</p>
    <button class="sos-btn" id="sosTrigger">TRIGGER SOS</button>
    <div id="statusMessage" style="margin-top:20px; font-weight:bold; color:green;"></div>
    <br><br>
    <a href="../dashboard/dashboard.php" class="btn btn-primary">Cancel & Turn Back</a>
</div>

<script>
document.getElementById('sosTrigger').addEventListener('click', () => {
    navigator.geolocation.getCurrentPosition((position) => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        
        fetch('../safety/send_sos.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `lat=${lat}&lng=${lng}`
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('statusMessage').innerText = "SOS Dispatched! Coordinates sent securely. Campus security notified.";
        });
    }, () => {
        // return if loc tracking block active
        fetch('../safety/send_sos.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `lat=UNKNOWN&lng=UNKNOWN`
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('statusMessage').innerText = "SOS Broadcasted without GPS context metadata.";
        });
    });
});
</script>
</body>
</html>