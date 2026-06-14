<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gender Preference Guide - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/safety.css">
</head>
<body>

<?php
session_start();
include '../includes/header.php';
?>

<div class="container">
    <a href="javascript:history.back()" class="btn-back">← Return Home</a>

    <div class="safety-card-grid" style="grid-template-columns:1fr; max-width:700px; margin:0 auto;">
        <div class="safety-card">
            <h4 class="title-amber">Female Only</h4>
            <p>Only female passengers can join this ride. Recommended for female students who prefer riding with the same gender for safety and comfort.</p>
        </div>
        <div class="safety-card">
            <h4 class="title-amber">Male Only</h4>
            <p>Only male passengers can join this ride.</p>
        </div>
        <div class="safety-card">
            <h4 class="title-amber">Mixed</h4>
            <p>All genders are welcome. This is the default option for users who are comfortable riding with anyone.</p>
        </div>
        <div class="safety-card">
            <h4 class="title-amber">Why Gender Preference?</h4>
            <p>We prioritize your safety and comfort. You can set your preference in your Profile settings. This feature helps ensure a more comfortable and secure ride experience, especially for users who prefer traveling with the same gender. It also promotes trust and confidence when sharing rides with others.</p>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
