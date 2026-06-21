<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
</head>
<body>

<?php
session_start();
include '../includes/header.php';
?>

<div class="container">
    <a href="javascript:history.back()" class="btn-back">← BACK</a>

    <div class="trip-form-card">
        <h2 class="trip-form-title">Contact Us</h2>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'sent'): ?>
            <div class="alert-box alert-success">Your feedback has been sent. Thank you!</div>        
            <?php endif; ?>

        <form action="process_contact.php" method="POST" id="contactForm">
            <div id="form-alert" class="alert-box alert-error" style="display:none;"></div>
            <div class="form-group">
                <label>Your Name</label>
                <input type="text" name="name" id="name" required>
                <div class="field-error" id="err-name"></div>
            </div>
            <div class="form-group">
                <label>UTeM Email</label>
                <input type="email" name="email" id="email" required>
                <div class="field-error" id="err-email"></div>
            </div>
            <div class="form-group">
                <label>Send Your Feedback</label>
                <textarea name="message" id="message" rows="5" required></textarea>
                <div class="field-error" id="err-message"></div>
            </div>
            <div class="trip-form-actions">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="javascript:history.back()" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="../assets/js/contact.js"></script>

<?php include '../includes/footer.php'; ?>
</body>
</html>