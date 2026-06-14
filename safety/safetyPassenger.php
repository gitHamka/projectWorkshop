<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Safety - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/safety.css">
</head>
<body>

<?php
session_start();
include '../includes/header.php';
?>

<div class="container">
    <a href="../index.php" class="btn-back">← BACK</a>

    <!--  protect you -->
    <h2 class="safety-section-title">How we protect you</h2>
    <div class="safety-card-grid">
        <div class="safety-card">
            <h4>Choose your driver</h4>
            <p>You have the power to select who drives you based on ratings and gender preference.</p>
        </div>
        <div class="safety-card">
            <h4>Verified drivers</h4>
            <p>All drivers go through background checks when they register in the app. We check their driver's license, ID, and any other required documents.</p>
        </div>
        <div class="safety-card">
            <h4>Protecting your privacy</h4>
            <p>We don't share your phone number if you call or message the driver in our app.</p>
        </div>
    </div>

    <!--  stay safe -->
    <h2 class="safety-section-title">How to stay safe</h2>
    <div class="safety-stage-tabs">
        <span class="safety-stage-tab">Before the carpool</span>
        <span class="safety-stage-tab">During the carpool</span>
        <span class="safety-stage-tab">After the carpool</span>
    </div>
    <div class="safety-card-grid">
        <div class="safety-card">
            <h4>Specify your pickup point</h4>
            <p>Add details to your pickup location or select on the map - it helps drivers find you faster.</p>
        </div>
        <div class="safety-card">
            <h4>Seatbelt safety</h4>
            <p>Always buckle up, no matter where you are seated, even on the shortest rides.</p>
        </div>
        <div class="safety-card">
            <h4>Rate the ride</h4>
            <p>Your feedback helps us improve, and drivers rely on it for their reputation.</p>
        </div>
    </div>

    <!--  incident reported -->
    <h2 class="safety-section-title">If an incident is reported</h2>
    <div class="incident-box">
        <p>After an incident is reported, we temporarily block the accounts involved.<br>
        We investigate, contact the authorities if needed, and offer support.</p>
    </div>

    <div style="text-align:center; margin-top:28px;">
        <a href="../index.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
