<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
$user_name    = $_SESSION['user_name'] ?? '';

require_once 'config/database.php';
$trips_result = $conn->query("
    SELECT t.origin, t.destination, t.departure, t.seats_available, t.price, t.gender_preference,
           u.name AS driver_name
    FROM trip t
    JOIN user u ON t.user_ID = u.user_ID
    WHERE t.status = 'Active'
    AND t.seats_available > 0
    ORDER BY t.departure ASC
    LIMIT 3
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenRide Campus - UTeM Carpooling Hub</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>

<!-- ======== navbar ========= -->
<header>
    <div class="logo-container">
    <img src="assets/images/logo.png" alt="GreenRide Campus Logo">
    GREENRIDE CAMPUS
</div>
    <nav>
        <?php if ($is_logged_in): ?>
            <span style="color:#fff; font-weight:600; margin-right:12px;">Hi, <?php echo htmlspecialchars($user_name); ?>!</span>
            <a href="dashboard/dashboard.php" class="btn btn-primary">Go to Dashboard</a>
            <a href="auth/logout.php" class="btn btn-outline" style="margin-left:8px;">Logout</a>
        <?php else: ?>
            <a href="auth/login.php" class="btn btn-outline">Login</a>
            <a href="auth/signup.php" class="btn btn-primary">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>

<!-- ======== hero ========= -->
<section class="hero-section">
    <div class="hero-content">
        <h1>
            <span class="hero-green">Go</span><span class="hero-white"> together,</span><br>
            <span class="hero-green">Save</span><span class="hero-white"> forever</span>
        </h1>
        <?php if ($is_logged_in): ?>
            <a href="dashboard/dashboard.php" class="btn-hero">GO TO DASHBOARD ➔</a>
        <?php else: ?>
            <a href="auth/signup.php" class="btn-hero">GET STARTED ➔</a>
        <?php endif; ?>
    </div>
</section>

<!-- ======== how it works ========= -->
<section class="section-how">
    <h2 class="section-title">How GreenRide Campus Works</h2>

    <div class="how-steps-row">
        <div class="how-step-card">
            <h4>Post or search</h4>
            <p>Drivers share trip details. Passengers find rides to faculties or colleges.</p>
        </div>
        <span class="how-arrow">➔</span>
        <div class="how-step-card">
            <h4>Choose gender preference</h4>
            <p>Filter by female-only, male-only, or mixed for comfort and safety.</p>
        </div>
        <span class="how-arrow">➔</span>
        <div class="how-step-card">
            <h4>Join &amp; share cost</h4>
            <p>Book a seat, split fuel costs, and reduce traffic on campus.</p>
        </div>
    </div>

    <div class="how-benefits-row">
        <div class="benefit-card">
            <h4>Save up to 70%</h4>
            <p>Share fuel and toll costs with fellow students.</p>
        </div>
        <div class="benefit-card">
            <h4>Green Campus</h4>
            <p>Less cars, lower CO2 emissions, greener UTeM.</p>
        </div>
        <div class="benefit-card">
            <h4>No more waiting</h4>
            <p>Reliable rides available on your schedule.</p>
        </div>
    </div>
</section>

<!-- ======== available trip ========= -->
<section class="section-trips">
    <h2 class="section-title">Available Trips</h2>
    <p class="section-subtitle">Just for guests to see – login to join</p>

    <?php if ($trips_result && $trips_result->num_rows > 0): ?>
        <?php while ($trip = $trips_result->fetch_assoc()): ?>
            <?php
                $departure_dt = new DateTime($trip['departure']);
                $today        = new DateTime('today');
                $tomorrow     = new DateTime('tomorrow');
                if ($departure_dt->format('Y-m-d') === $today->format('Y-m-d')) {
                    $day_label = 'Today ' . $departure_dt->format('g:i A');
                } elseif ($departure_dt->format('Y-m-d') === $tomorrow->format('Y-m-d')) {
                    $day_label = 'Tomorrow ' . $departure_dt->format('g:i A');
                } else {
                    $day_label = $departure_dt->format('d M g:i A');
                }
                $pref_class = 'badge-mixed';
                if ($trip['gender_preference'] === 'Female Only') $pref_class = 'badge-female';
                if ($trip['gender_preference'] === 'Male Only')   $pref_class = 'badge-male';
            ?>
            <div class="preview-trip-card">
                <div class="preview-trip-left">
                    <span class="preview-trip-route">
                        <?php echo htmlspecialchars($trip['origin']); ?> –
                        <?php echo htmlspecialchars($trip['destination']); ?>
                    </span>
                    <span class="preview-trip-time"><?php echo $day_label; ?></span>
                </div>
                <div class="preview-trip-right">
                    <?php if ($trip['gender_preference']): ?>
                        <span class="trip-pref-badge <?php echo $pref_class; ?>">
                            <?php echo htmlspecialchars($trip['gender_preference']); ?>
                        </span>
                    <?php endif; ?>
                    <span class="preview-trip-seats">
                        <?php echo $trip['seats_available']; ?> seats left
                    </span>
                    <span class="preview-trip-cost">
                        RM <?php echo number_format($trip['price'], 2); ?>
                    </span>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="trips-empty">
            No active trips available right now. Be the first to post one!
        </div>
    <?php endif; ?>

    <div class="section-cta">
        <?php if ($is_logged_in): ?>
            <a href="trip/explore_trips.php" class="btn-hero">EXPLORE ALL RIDES ➔</a>
        <?php else: ?>
            <a href="auth/login.php" class="btn-hero">LOGIN TO JOIN ➔</a>
        <?php endif; ?>
    </div>
</section>

<!-- ======== safety ========= -->
<section class="section-safety">
    <h2 class="section-title">Your Safety Is Our Priority</h2>
    <p class="section-subtitle">At GreenRide Campus, we prioritize YOUR SAFETY and comfort</p>

    <div class="safety-grid">
        <div class="safety-feature-card">
            <div class="safety-icon">👥</div>
            <div>
                <h4>Gender Preference</h4>
                <p>Users can choose to ride only with the same gender (Female only/Male only/Mixed)</p>
            </div>
        </div>
        <div class="safety-feature-card">
            <div class="safety-icon">✅</div>
            <div>
                <h4>Verified Users</h4>
                <p>Every account is verified using UTeM Matric/Staff ID. Only UTeM community members can use the system.</p>
            </div>
        </div>
        <div class="safety-feature-card">
            <div class="safety-icon">⭐</div>
            <div>
                <h4>Ride History &amp; Ratings</h4>
                <p>All rides are recorded. Rate and review after each trip to ensure accountability and trust.</p>
            </div>
        </div>
        <div class="safety-feature-card">
            <div class="safety-icon">📍</div>
            <div>
                <h4>Real-Time Tracking</h4>
                <p>Share live location with friends or family during rides for extra peace of mind (Coming soon).</p>
            </div>
        </div>
    </div>

    <div class="safety-alert-box">
        If you ever feel uncomfortable, you can cancel the trip anytime through the system.<br>
        Reports can also be submitted to the admin.
    </div>

    <div class="section-cta">
        <a href="safety/gender_preference_guide.php" class="btn-hero btn-hero-sm">
            Learn More About GENDER PREFERENCES
        </a>
    </div>
</section>

<!-- ======== faq ========= -->
<section class="section-faq">
    <h2 class="section-title">Frequently Asked Questions</h2>

    <div class="faq-list">

        <div class="faq-item">
            <div class="faq-question">
                Is GreenRide Campus safe?
                <button class="faq-toggle">+</button>
            </div>
            <div class="faq-answer">
                Yes, GreenRide Campus is safe. All users are verified using UTeM Matric or Staff ID, 
                so only the UTeM community can use the system. You can also choose gender preferences and rate drivers 
                or passengers after each trip to ensure accountability
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                Does my personal information stay secure with GreenRide Campus?
                <button class="faq-toggle">+</button>
            </div>
            <div class="faq-answer">
                Yes, your personal information is kept secure. We only share necessary ride details like pickup location and destination. 
                Your contact information is only visible to confirmed ride partners, and all data is stored securely according to UTeM privacy guidelines.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                What happens if an accident is reported?
                <button class="faq-toggle">+</button>
            </div>
            <div class="faq-answer">
                If an accident is reported, the system will record the incident along with all ride details. 
                Users can review the ride history and ratings. 
                The report will be reviewed, and appropriate action will be taken based on UTeM policies.
            </div>
        </div>

    </div>
</section>

<!-- ======== footer ========= -->
<footer>
    <div class="footer-content">
        <div class="footer-brand">
            <h3>GREENRIDE CAMPUS</h3>
            <p>UTeM Carpooling Hub<br>Fakulti Teknologi Maklumat dan Komunikasi</p>
        </div>
        <div class="footer-column">
            <h4>Company</h4>
            <ul>
                <li><a href="company/about_us.php">About Us</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Explore</h4>
            <ul>
                <li><a href="auth/login.php">Find a ride</a></li>
                <li><a href="auth/login.php">Post a ride</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Safety</h4>
            <ul>
                <li><a href="safety/safetyPassenger.php">For passengers</a></li>
                <li><a href="safety/safetyDriver.php">For drivers</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Support</h4>
            <ul>
                <li><a href="company/contact_us.php">Contact us</a></li>
                <li><a href="safety/gender_preference_guide.php">Gender preference guide</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        ©2026 GREENRIDE CAMPUS - the OGs
    </div>
</footer>

<script>
document.querySelectorAll('.faq-question').forEach(function(question) {
    question.addEventListener('click', function() {
        var item   = this.closest('.faq-item');
        var answer = item.querySelector('.faq-answer');
        var btn    = item.querySelector('.faq-toggle');
        var isOpen = item.classList.contains('active');

        // close all
        document.querySelectorAll('.faq-item').forEach(function(i) {
            i.classList.remove('active');
            i.querySelector('.faq-toggle').textContent = '+';
        });

        // open if semua close
        if (!isOpen) {
            item.classList.add('active');
            btn.textContent = '×';
        }
    });
});
</script>

</body>
</html>