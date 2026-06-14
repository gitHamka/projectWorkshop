<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php
session_start();
include '../includes/header.php';
?>

<div class="container">
    <a href="javascript:history.back()" class="btn-back">← BACK</a>

    <div class="card" style="max-width:700px; margin:0 auto; text-align:center;">
        <h2 class="page-title">About Us</h2>

        <div class="about-content-box">
            <p>GreenRide Campus is a UTeM student-led carpooling platform that helps drivers with empty seats connect with passengers who need a ride. This reduces traffic on campus, saves fuel costs, and lowers pollution.</p>
            <br>
            <p>Our system lets users register safely, post and search for trips, book seats (which automatically reduces available seats), view trip history, and choose a gender preference (female only, male only, or mixed) to make rides feel safer and more comfortable for everyone.</p>
            <br>
            <p>We aim to make campus travel more efficient, greener, and welcoming for all students and staff.</p>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
