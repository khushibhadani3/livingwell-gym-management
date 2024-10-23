<header class="header-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="logo">
                    <a href="./index.php">
                        <img src="img/logo.png" alt="">
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="nav-menu">
                    <ul>
                        <li><a href="./index.php">Home</a></li>
                        <li><a href="./about-us.php">About Us</a></li>
                        <li><a href="./class-details.php">Classes</a></li>
                        <li><a href="./services.php">Services</a></li>
                        <li><a href="./team.php">Our Team</a></li>
                        <li><a href="./contact.php">Contact</a></li>
                        <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                            <li><a href="./profile.php">Profile</a></li>
                        <?php elseif (isset($_SESSION['trainer_logged_in']) && $_SESSION['trainer_logged_in'] === true): ?>
                            <li><a href="./trainer_profile.php">Profile</a></li>
                        <?php else: ?>
                            <li><a href="./admin_profile.php">Profile</a></li>
                        <?php endif; ?>
                        <?php if ((isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) || (isset($_SESSION['trainer_logged_in']) && $_SESSION['trainer_logged_in'] === true) || (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true)): ?>
                            <li><a href="./logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="./login.php">Log in</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="top-option">
                    <div class="to-search search-switch">
                        <i class="fa fa-search"></i>
                    </div>
                    <div class="to-social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="canvas-open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>