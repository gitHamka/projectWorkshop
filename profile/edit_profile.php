<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id='$user_id'")->fetch_assoc();
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
    <form action="update_profile.php" method="POST">
        <div class="form-group"><label>Full Name</label><input type="text" name="name" value="<?php echo $user['name']; ?>" required></div>
        <div class="form-group"><label>Phone Number</label><input type="text" name="phone" value="<?php echo $user['phone']; ?>" required></div>
        <div class="form-group">
            <label>Default Role Preference</label>
            <select name="role">
                <option value="Passenger" <?php if($user['role']=='Passenger') echo 'selected'; ?>>Passenger</option>
                <option value="Driver" <?php if($user['role']=='Driver') echo 'selected'; ?>>Driver</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Save Changes</button>
    </form>
</div>
</body>
</html>