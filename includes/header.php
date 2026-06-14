<?php
$base = str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 2);
?>
<header>
    <div class="logo-container">
        <img src="<?php echo $base; ?>assets/images/logo.png" alt="GreenRide Campus Logo">
        GREENRIDE CAMPUS
    </div>
    <nav>
        <span class="nav-user-greeting">👤 <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?></span>
        <a href="<?php echo $base; ?>auth/logout.php" class="btn btn-outline-white">Logout</a>
    </nav>
</header>
