<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avangers</title>
    <link rel="stylesheet" href="style/bg-video.css">
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/hero-section.css">
    <link rel="stylesheet" href="style/guild-leader.css">
    <link rel="stylesheet" href="style/playerShow.css">
    <link rel="stylesheet" href="style/Contact-form.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


</head>
<body>
<video autoplay muted loop id="bg-video">
  <source src="Untitled.mp4" type="video/mp4">
</video>


<header class="navbar">
    <h1 class="title">AVENGERS</h1>
    <nav class="nav-links">
        <a href="Avengers.php" class="active">Home</a>
        <a href="#contact">Contact Us</a>
        <button class="nav-btn login-btn">Login</button>
        <button class="nav-btn signup-btn">Sign Up</button>
    </nav>
</header>

<section class="hero-section">
    <div class="hero-content">
        <p class="hero-tag">EARTH'S MIGHTIEST HEROES</p>

        <h1>
            ASSEMBLE YOUR
            <span>ULTIMATE TEAM</span>
        </h1>

        <p class="hero-description">
            Discover your squad, choose your role, and
            fight together to become legendary.
        </p>

        <div class="hero-buttons">
            <a href="#team" class="hero-btn primary-btn">
                Explore Team
            </a>

            <a href="#contact" class="hero-btn secondary-btn">
                Join the Avengers
            </a>
        </div>
    </div>
</section>

<!-- GUILD LEADERSHIP SECTION -->

<section class="leadership-section" id="leadership">

    <div class="section-heading">
        <p class="section-tag">THE PEOPLE BEHIND THE GUILD</p>
        <h2>GUILD <span>LEADERSHIP</span></h2>
        <p class="section-description">
            Leading the team, building trust, and fighting together.
        </p>
    </div>

    <div class="leadership-container">

        <!-- GUILD LEADER -->
        <div class="leader-card">
            <div class="leader-badge">GUILD LEADER</div>

            <div class="leader-image">
                <img src="mohitt.jpeg"
                     alt="Guild Leader">
            </div>

            <h3>CAPTAN</h3>
            <p class="leader-role">Founder & Head of the Guild</p>

            <div class="leader-divider"></div>

            <p class="leader-description">
                The main leader who guides the guild,
                makes important decisions, and leads the team.
            </p>
        </div>

        <!-- ACTING GUILD LEADER -->
        <div class="leader-card acting-leader">
            <div class="leader-badge acting-badge">
                ACTING GUILD LEADER
            </div>

            <div class="leader-image acting-image">
                <img src="images/acting-guild-leader.jpeg"
                     alt="Acting Guild Leader">
            </div>

            <h3>NG FLASH</h3>
            <p class="leader-role">Leadership & Team Management</p>

            <div class="leader-divider"></div>

            <p class="leader-description">
                Supports the guild leader and manages
                the team when the main leader is unavailable.
            </p>
        </div>

    </div>
</section>


 

<section class="members-section" id="team">

    <div class="section-heading">
        <p class="section-tag">UNITED WE FIGHT</p>
        <h2>OUR GUILD <span>MEMBERS</span></h2>
        <p class="section-description">
            Every warrior has a story. Meet your teammates.
        </p>
    </div>

    <?php
    include_once('connection.php');

    $fetch_query = "SELECT * FROM member";
    $check_query = mysqli_query($check, $fetch_query);

    if ($check_query && mysqli_num_rows($check_query) > 0) {
    ?>

    <div class="card-container">

        <?php while ($row = mysqli_fetch_assoc($check_query)) { ?>

        <div class="member-card">

            <div class="member-image-box">
                <img src="mohitt.jpeg"
                     alt="Member profile"
                     class="member-image">

                <span class="member-status">GUILD MEMBER</span>
            </div>

            <div class="member-info">

                <h3 class="member-name">
                    <?php echo htmlspecialchars($row['Member_name']); ?>
                </h3>

                <p class="game-name">
                    <span>Game Name:</span>
                    <?php echo htmlspecialchars($row['Game_name']); ?>
                </p>

                <div class="member-tags">
                    <span class="role-tag">
                        <?php echo htmlspecialchars($row['Role']); ?>
                    </span>

                    <span class="post-tag">
                        <?php echo htmlspecialchars($row['Guild_Post']); ?>
                    </span>
                </div>

                <button
                    type="button"
                    class="show-details-btn"
                    data-name="<?php echo htmlspecialchars($row['Member_name'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-game="<?php echo htmlspecialchars($row['Game_name'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-role="<?php echo htmlspecialchars($row['Role'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-age="<?php echo htmlspecialchars((string)$row['Age'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-post="<?php echo htmlspecialchars($row['Guild_Post'], ENT_QUOTES, 'UTF-8'); ?>"
                    onclick="showMemberDetails(this)">

                    Show Details <span>↗</span>
                </button>

            </div>
        </div>

        <?php } ?>

    </div>

    <?php } else { ?>

        <p class="no-members">
            No guild members found. Add members from your admin panel.
        </p>

    <?php } ?>

</section>



<section class="contact-section" id="contact">

    <div class="contact-heading">
        <p class="section-tag">BECOME A WARRIOR</p>
        <h2>JOIN THE <span>GUILD</span></h2>
        <p>Fill in your details and take your place on the team.</p>
    </div>

    <form class="guild-form" action="join-guild.php" method="POST">

        <div class="form-grid">

            <div class="form-group">
                <label for="member_name">Full Name</label>
                <input type="text" id="member_name"
                       name="member_name"
                       placeholder="Enter your full name"
                       maxlength="100" required>
            </div>

            <div class="form-group">
                <label for="game_name">Game Name</label>
                <input type="text" id="game_name"
                       name="game_name"
                       placeholder="Your in-game name"
                       maxlength="100" required>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age"
                       placeholder="Enter your age"
                       min="1" max="120" required>
            </div>

            <div class="form-group">
                <label for="game_id">Game ID</label>
                <input type="text" id="game_id" name="game_id"
                       placeholder="Enter your game ID"
                       maxlength="100" required>
            </div>

            <div class="form-group full-width">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone"
                       placeholder="Enter your contact number"
                       pattern="[0-9]{10}"
                       maxlength="10"
                       inputmode="numeric" required>
                <small>Enter your 10-digit mobile number.</small>
            </div>

        </div>

        <button type="submit" class="submit-guild-btn">
            SUBMIT APPLICATION <span>→</span>
        </button>

        <p class="form-note">
            Your details will be submitted to the guild administrator.
        </p>

    </form>
</section>


<footer class="site-footer" id="footer">

    <div class="footer-main">

        <div class="footer-brand">
            <a href="Avengers.php" class="footer-logo">
                <span class="footer-shield">A</span>
                AVENGERS
            </a>

            <p>
                United as one. Stronger together.
                Built to dominate.
            </p>

            <div class="footer-motto">
                POWER <span>•</span> UNITY <span>•</span> LOYALTY
            </div>
        </div>

        <div class="footer-column">
            <h3>Quick Links</h3>
            <a href="Avengers.php">Home</a>
            <a href="#leadership">Guild Leadership</a>
            <a href="#team">All Members</a>
            <a href="#contact">Join the Guild</a>
        </div>

        <div class="footer-column">
            <h3>Guild Leaders</h3>
            <a href="#leadership">♛ CAPTAN</a>
            <a href="#leadership">⚔ NG FLASH</a>
            <a href="#contact">Contact the Guild</a>
        </div>

        <div class="footer-column">
            <h3>Connect</h3>
            <!-- Replace # with your actual social profile URLs -->
            <a href="#" target="_blank" rel="noopener noreferrer">
                Instagram
            </a>
            <a href="#" target="_blank" rel="noopener noreferrer">
                YouTube
            </a>
            <a href="#" target="_blank" rel="noopener noreferrer">
                Discord
            </a>
        </div>

    </div>

    <div class="footer-bottom">
        <p>
            &copy; <?php echo date('Y'); ?>
            <span>AVENGERS GUILD</span>.
            All rights reserved.
        </p>

        <a href="#top" class="back-to-top"
           onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;">
            Back to Top ↑
        </a>
    </div>

</footer>



<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

<script src="animation.js"></script>
</body>
</html>