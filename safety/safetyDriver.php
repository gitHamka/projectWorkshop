<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Safety - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/safety.css">
</head>
<body>

<?php
session_start();
include '../includes/header.php';
?>

<div class="container">
    <a href="../dashboard/dashboard.php" class="btn-back">← BACK</a>

    <!-- What every driver needs to know -->
    <h2 class="safety-section-title">What every driver needs to know</h2>
    <div class="safety-card-grid">
        <div class="safety-card">
            <h4>General Conduct</h4>
            <p>Don't bring along any extra passengers and avoid asking for extra money or tips. Treat your passengers with care and respect, and prioritise safe driving at all time.</p>
        </div>
        <div class="safety-card">
            <h4 class="title-amber">Fatigue is a red flag</h4>
            <p>Driving while tired is very risky. If you feel unwell or fatigued, please don't accept orders.</p>
        </div>
        <div class="safety-card">
            <h4>Maintain your vehicle</h4>
            <p>Before each ride, quickly check your car to ensure it's clean and well-ventilated. Always remember to refuel before accepting a ride request.</p>
        </div>
    </div>

    <!-- How to stay safe -->
    <h2 class="safety-section-title">How to stay safe</h2>
    <div class="safety-stage-tabs">
        <span class="safety-stage-tab">Before the carpool</span>
        <span class="safety-stage-tab">During the carpool</span>
        <span class="safety-stage-tab">After the carpool</span>
    </div>
    <div class="safety-card-grid">
        <div class="safety-card">
            <h4>Picking up the right passenger</h4>
            <p>Before starting the ride, make sure you pick up the right passenger. This keeps everyone safe and prevents mix-ups.</p>
        </div>
        <div class="safety-card">
            <h4>Follow the rules</h4>
            <p>Always follow the rules of the road and watch out for pedestrians. Everyone's safety is important.</p>
        </div>
        <div class="safety-card">
            <h4>Check for forgotten items</h4>
            <p>After each ride, check your vehicle for forgotten belongings. Your passengers will be very appreciative!</p>
        </div>
    </div>

    <!-- If an incident is reported -->
    <h2 class="safety-section-title">If an incident is reported</h2>
    <div class="incident-box">
        <p>After an incident is reported, we temporarily block the accounts involved.<br>
        We investigate, contact the authorities if needed, and offer support.</p>
    </div>

    <div style="text-align:center; margin-top:28px;">
        <a href="../dashboard/dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
