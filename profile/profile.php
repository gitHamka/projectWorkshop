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
    <title>My Profile - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
<div class="container">
    <div class="card profile-card">
        <div class="profile-img">👤</div>
        <h2><?php echo $user['name']; ?></h2>
        <p><strong>Email Address:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Matric/Staff Identifier:</strong> <?php echo $user['matric_id']; ?></p>
        <p><strong>Gender:</strong> <?php echo $user['gender']; ?></p>
        <p><strong>Phone Connection:</strong> <?php echo $user['phone']; ?></p>
        <p><strong>System Workspace Default Role:</strong> <?php echo $user['role']; ?></p>
        <br>
        <a href="edit_profile.php" class="btn btn-primary">Edit Account Info</a>
        <a href="remove_account.php" class="btn btn-danger" onclick="return confirm('Completely remove account?');">Remove Account</a>
        <br><br>
        <a href="../dashboard/dashboard.php">Back to Dashboard</a>
    </div>
</div>
</body>
</html>