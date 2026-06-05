<?php require_once '../config/session_check.php'; check_login(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post a Ride - GreenRide</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
<div class="auth-container">
    <h2>Post a Trip Route </h2>
    <form action="process_post_trip.php" method="POST">
        <div class="form-group"><label>Pickup Location</label><input type="text" name="pickup" id="pickup" placeholder="e.g., FTMK" required></div> 
        <div class="form-group"><label>Dropoff Location</label><input type="text" name="dropoff" id="dropoff" placeholder="e.g., Kolej Lestari" required></div> 
        <div class="form-group"><label>Date</label><input type="date" name="trip_date" required></div> 
        <div class="form-group"><label>Time</label><input type="time" name="trip_time" required></div> 
        <div class="form-group">
            <label>Available Seats (excluding driver)</label> 
            <select name="available_seats">
                <option value="1">1 Seat</option><option value="2">2 Seats</option> 
                <option value="3">3 Seats</option><option value="4">4 Seats</option> 
            </select>
        </div>
        <div class="form-group">
            <label>Gender Preference Mode</label> 
            <select name="gender_preference">
                <option value="Mixed">Mixed</option> 
                <option value="Female Only">Female Only</option> 
                <option value="Male Only">Male Only</option> 
            </select>
        </div>
        <div class="form-group"><label>Estimated Cost Share (RM)</label><input type="text" name="cost_share" value="1.50" required></div> 
        <div class="form-group"><label>Notes (optional)</label><input type="text" name="notes" placeholder="e.g., No luggage, AC on"></div> 
        
        <button type="submit" class="btn btn-primary" style="width:100%;">Post Active Ride</button>
    </form>
</div>
</body>
</html>