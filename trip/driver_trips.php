<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

$user_id = $_SESSION['user_id'];

$res = $conn->query("
    SELECT t.*, 
           (SELECT COUNT(*) FROM triprequest tr WHERE tr.trip_ID = t.trip_ID AND tr.status NOT IN ('Cancelled','Rejected')) AS total_requests,
           (SELECT COUNT(*) FROM triprequest tr WHERE tr.trip_ID = t.trip_ID AND tr.status = 'Cancelled') AS cancelled_count
    FROM trip t
    WHERE t.user_ID = '$user_id'
    ORDER BY t.departure DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Offered Trips - GreenRide Campus</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/trip.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <a href="../dashboard/dashboard.php" class="btn-back">← Back to Dashboard</a>
    <h2 class="page-heading">🚗 My Offered Trips</h2>
    <p class="page-subtext">All rides you have posted as a driver.</p>

    <?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
    <div class="alert-box alert-success">Trip updated successfully.</div>
    <?php endif; ?>

    <div class="trip-grid">
        <?php if ($res && $res->num_rows > 0):
            while ($row = $res->fetch_assoc()):
                $trip_id  = $row['trip_ID'];
                $origin   = htmlspecialchars($row['origin']);
                $dest     = htmlspecialchars($row['destination']);
                $depart   = date('D, d M Y  •  h:i A', strtotime($row['departure']));
                $seats    = $row['seats_available'];
                $price    = number_format($row['price'], 2);
                $status   = htmlspecialchars($row['status']);
                $requests = $row['total_requests'];
                $cancelled = $row['cancelled_count'];
                $pref     = htmlspecialchars($row['gender_preference'] ?? 'Mixed');
                $badge_class = 'badge-mixed';
                if ($pref === 'Female') $badge_class = 'badge-female';
                elseif ($pref === 'Male') $badge_class = 'badge-male';

                $status_class = 'status-default';
                if ($status == 'Active')    $status_class = 'status-active';
                if ($status == 'Completed') $status_class = 'status-completed';
                if ($status == 'Cancelled') $status_class = 'status-cancelled';
        ?>
        <div class="trip-card">
            <div class="trip-info-block">
                <div class="trip-locations">📍 <?php echo $origin; ?> → <?php echo $dest; ?></div>
                <div class="trip-meta-row">
                    <span>🗓 <?php echo $depart; ?></span>
                    <span class="badge-seats <?php echo $seats == 0 ? 'seats-full' : ''; ?>">💺 <?php echo $seats; ?> seat<?php echo $seats != 1 ? 's' : ''; ?> left</span>                    <span class="trip-pref-badge <?php echo $badge_class; ?>"><?php echo $pref; ?></span>
                    <span class="request-count">👥 <?php echo $requests; ?> request<?php echo $requests != 1 ? 's' : ''; ?></span>
                    <?php if ($cancelled > 0): ?>
                        <span class="badge-status badge-cancelled">⚠️ <?php echo $cancelled; ?> cancelled</span>
                        <?php endif; ?>
                        
                    <span class="status-badge <?php echo $status_class; ?>"><?php echo $status; ?></span>
</div>
            </div>
            <div class="trip-price-section">
                <div class="trip-cost">RM <?php echo $price; ?></div>
                <a href="manage_request.php?trip_id=<?php echo $trip_id; ?>" class="btn btn-secondary btn-sm">
                    👥 Requests (<?php echo $requests; ?>)
                </a>
                <?php if ($status == 'Active'): ?>
                <a href="edit_trip.php?id=<?php echo $trip_id; ?>" class="btn btn-primary btn-sm">Edit</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; else: ?>
        <div class="empty-state">
            <div class="empty-state-icon">🚗</div>
            <p>You haven't posted any trips yet.</p>
            <p class="empty-state-link"><a href="post_trip.php">Post a ride →</a></p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>