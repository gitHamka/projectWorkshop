<?php
require_once '../config/database.php';
require_once '../config/session_check.php';
check_login();

$user_id = $_SESSION['user_id'];

// fetch trips driver post
$res = $conn->query("
    SELECT t.*, 
           (SELECT COUNT(*) FROM triprequest tr WHERE tr.trip_ID = t.trip_ID AND tr.status != 'Cancelled') AS total_requests
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
    <h2 style="font-size:22px; font-weight:800; color:var(--dark-green); margin-bottom:6px;">🚗 My Offered Trips</h2>
    <p style="color:var(--text-muted); font-size:14px; margin-bottom:24px;">All rides you have posted as a driver.</p>

    <?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
    <div style="background:#E8F5E9; border:1.5px solid #A5D6A7; border-radius:12px; padding:12px 18px; color:#1B5E20; font-weight:600; font-size:14px; margin-bottom:20px;">
         Trip updated successfully.
    </div>
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
                $pref     = htmlspecialchars($row['gender_preference'] ?? 'Mixed');
                $badge_class = 'badge-mixed';
                if ($pref === 'Female') $badge_class = 'badge-female';
                elseif ($pref === 'Male') $badge_class = 'badge-male';

                $status_color = '#546E7A'; $status_bg = '#ECEFF1';
                if ($status == 'Active')    { $status_color = '#1B5E20'; $status_bg = '#E8F5E9'; }
                if ($status == 'Completed') { $status_color = '#1565C0'; $status_bg = '#E3F2FD'; }
                if ($status == 'Cancelled') { $status_color = '#B71C1C'; $status_bg = '#FFEBEE'; }
        ?>
        <div class="trip-card">
            <div class="trip-info-block">
                <div class="trip-locations"> <?php echo $origin; ?> → <?php echo $dest; ?></div>
                <div class="trip-meta-row">
                    <span>🗓 <?php echo $depart; ?></span>
                    <span class="badge-seats">💺 <?php echo $seats; ?> seat<?php echo $seats != 1 ? 's' : ''; ?> left</span>
                    <span class="trip-pref-badge <?php echo $badge_class; ?>"><?php echo $pref; ?></span>
                    <span style="font-size:12px; color:var(--text-muted);">👥 <?php echo $requests; ?> request<?php echo $requests != 1 ? 's' : ''; ?></span>
                    <span style="background:<?php echo $status_bg; ?>; color:<?php echo $status_color; ?>; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;"><?php echo $status; ?></span>
                </div>
            </div>
            <div class="trip-price-section">
                <div class="trip-cost">RM <?php echo $price; ?></div>
                <a href="manage_requests.php?trip_id=<?php echo $trip_id; ?>" class="btn btn-secondary btn-sm">
                    👥 Requests (<?php echo $requests; ?>)
                </a>
                <?php if ($status == 'Active'): ?>
                <a href="edit_trip.php?id=<?php echo $trip_id; ?>" class="btn btn-primary" style="font-size:13px; padding:8px 18px;">Edit</a>
                
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; else: ?>
        <div style="text-align:center; padding:60px 20px; color:var(--text-muted);">
            <div style="font-size:48px; margin-bottom:12px;"></div>
            <p style="font-size:16px; font-weight:600;">You haven't posted any trips yet.</p>
            <p style="font-size:13px; margin-top:6px;"><a href="post_trip.php" style="color:var(--accent-green); font-weight:700;">Post a ride →</a></p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
