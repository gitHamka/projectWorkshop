<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM user WHERE user_id='$user_id'")->fetch_assoc();

$vehicle_res = $conn->query("SELECT * FROM vehicle WHERE user_ID='$user_id' LIMIT 1");
$vehicle = $vehicle_res ? $vehicle_res->fetch_assoc() : null;

$redirect = $_GET['redirect'] ?? 'profile';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile - GreenRide</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
<div class="auth-container">
    <h2>Update Profile Info</h2>

    <div id="form-alert" class="alert-box alert-error" style="display:none;"></div>

    <form action="update_profile.php" method="POST" id="editProfileForm">
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
        </div>
        <div class="form-group">
            <label>Gender</label>
            <select name="gender">
                <option value="Female" <?php if($user['gender']=='Female') echo 'selected'; ?>>Female</option>
                <option value="Male" <?php if($user['gender']=='Male') echo 'selected'; ?>>Male</option>
            </select>
        </div>
        <div class="form-group">
            <label>Default Role Preference</label>
            <select name="role" id="roleSelect">
                <option value="Passenger" <?php if($user['role']=='Passenger') echo 'selected'; ?>>Passenger</option>
                <option value="Driver" <?php if($user['role']=='Driver') echo 'selected'; ?>>Driver</option>
            </select>
        </div>

        <hr class="form-divider">
        <h3 id="vehicleHeading">Vehicle Information <span class="field-hint">(required for Drivers only)</span></h3>

        <div class="form-group">
            <label>Car Model</label>
            <input type="text" name="car_model" id="car_model" value="<?php echo htmlspecialchars($vehicle['model'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label>Plate Number</label>
            <input type="text" name="plate_number" id="plate_number" value="<?php echo htmlspecialchars($vehicle['plate_number'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label>Color</label>
            <input type="text" name="color" id="color" value="<?php echo htmlspecialchars($vehicle['color'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label>Seats Capacity</label>
            <input type="number" name="capacity" id="capacity" min="1" max="8" value="<?php echo htmlspecialchars($vehicle['capacity'] ?? '4'); ?>">
        </div>

        <button type="submit" class="btn btn-primary btn-full">Save Changes</button>
    </form>
</div>

<script src="../assets/js/edit_profile.js"></script>
</body>
</html>