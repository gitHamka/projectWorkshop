<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM user WHERE user_id='$user_id'")->fetch_assoc();

$vehicle = $conn->query("SELECT * FROM vehicle WHERE user_id='$user_id' LIMIT 1")->fetch_assoc();

$triphistory = $conn->query("
    SELECT * FROM trip
    WHERE user_id='$user_id'
    ORDER BY departure DESC 
    LIMIT 5
");
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

<?php include '../includes/header.php'; ?>

<div class="container">

    <a href="../dashboard/dashboard.php" class="btn-back">← BACK</a>

    <h1 class="page-title">My Profile</h1>

    <div class="profile-card-layout">

        <!-- avatar -->
        <div class="profile-avatar-wrapper">
            <div class="profile-img">👤</div>
            <div class="profile-name"><?php echo htmlspecialchars($user['name']); ?></div>
            <div class="profile-matric"><?php echo htmlspecialchars($user['role'] ?? 'Member'); ?></div>
            <div class="profile-stars">
                <?php
                $rating = $user['rating'] ?? 4;
                echo str_repeat('★', (int)round($rating)) . str_repeat('☆', 5 - (int)round($rating));
                ?>
            </div>
        </div>

        <?php if (empty($user['gender'])): ?>
            <div class="alert-info">
                Your profile is missing some details. <a href="edit_profile.php">Complete your profile</a> for a better experience.
            </div>
        <?php endif; ?>

        <!-- personal info -->
        <div class="profile-section">
            <h3>Personal Information</h3>

            <div class="profile-field">
                <label>Full Name</label>
                <span class="field-value"><?php echo htmlspecialchars($user['name']); ?></span>
            </div>

            <div class="profile-field">
                <label>Matric / Staff</label>
                <span class="field-value"><?php echo htmlspecialchars($user['matric_number'] ?? ''); ?></span>
            </div>

            <div class="profile-field">
                <label>Email</label>
                <span class="field-value"><?php echo htmlspecialchars($user['email']); ?></span>
            </div>

            <div class="profile-field">
                <label>Phone Number</label>
                <span class="field-value"><?php echo htmlspecialchars($user['phone_number'] ?? ''); ?></span>
            </div>

            <div class="profile-field">
                <label>Gender</label>
                <span class="field-value"><?php echo htmlspecialchars($user['gender'] ?? ''); ?></span>
            </div>
        </div>

        <!-- gender pref -->
         <div class="profile-section">
            <h3>Carpool Gender Preference</h3>
            
            <form action="update_gender_pref.php" method="POST">
                <div class="gender-pref-options">
            <label>
                <input type="radio" name="gender_pref" value="female_only"
                    <?php echo ($user['gender_pref'] ?? '') === 'female_only' ? 'checked' : ''; ?>>
                Female Only
            </label>
            <label>
                <input type="radio" name="gender_pref" value="male_only"
                    <?php echo ($user['gender_pref'] ?? '') === 'male_only' ? 'checked' : ''; ?>>
                Male Only
            </label>
            <label>
                <input type="radio" name="gender_pref" value="mixed"
                    <?php echo ($user['gender_pref'] ?? '') === 'mixed' ? 'checked' : ''; ?>>
                Mixed
            </label>
          </div>

        <!-- trip history -->
        <div class="profile-section">
    <h3>Trip History</h3>
    <p class="section-subtitle">Your recent rides as driver and passenger</p>

  <?php if ($triphistory && $triphistory->num_rows > 0): ?>
    <?php while ($trip = $triphistory->fetch_assoc()): ?>
        <div class="trip-history-item">
            <div>
                <div class="trip-route">
                    <?php echo htmlspecialchars($trip['origin'] . ' - ' . $trip['destination']); ?>
                    <span class="badge-status badge-<?php echo strtolower($trip['status']); ?>">
                        <?php echo htmlspecialchars($trip['status']); ?>
                    </span>
                </div>
                <div class="trip-time">
                    <?php echo date('M j, g:i A', strtotime($trip['departure'])); ?>
                </div>
            </div>
            <div class="trip-amount">
                RM <?php echo number_format($trip['price'], 2); ?>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No trip history yet.</p>
<?php endif; ?>


</div>
        <!-- sos -->
        <div class="sos-section">
            <h3>SOS Emergency</h3>
            <a href="../safety/sos.php" class="btn-sos-big">Tap for Emergency SOS</a>
        </div>

        <!-- action footer -->
        <div class="profile-action-footer">
            <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            <a href="remove_account.php" class="btn btn-danger"
               onclick="return confirm('Completely remove account?');">Remove Account</a>
        </div>

    </div>
</div>

<?php if (isset($_GET['updated'])): ?>
<div class="alert-success">
    Profile updated successfully!
</div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>

</body>
</html>