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
  <source src="src/Avanger.mp4" type="video/mp4">
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
                <img src="src/mohitt.jpeg"
                     alt="Guild Leader">
            </div>

            <h3>CAPTAIN</h3>
            <p class="leader-role">Head of the Guild</p>

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
                <img src="src/Acting leader.jpeg"
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

    
        $fetch_query = "
    SELECT * FROM member
    ORDER BY
        CASE
            WHEN Guild_Post = 'Leader' THEN 1
            WHEN Guild_Post = 'Acting Leader' THEN 2
            WHEN Guild_Post = 'Officer' THEN 3
            ELSE 4
        END ASC,
        Member_name ASC
    ";

    $check_query = mysqli_query($check, $fetch_query);


    $cropX = isset($row['crop_x']) ? (int)$row['crop_x'] : 50;
    $cropY = isset($row['crop_y']) ? (int)$row['crop_y'] : 50;

    $cropX = max(0, min(100, $cropX));
    $cropY = max(0, min(100, $cropY));



    if ($check_query && mysqli_num_rows($check_query) > 0) {
    ?>

    <div class="card-container">

        <?php while ($row = mysqli_fetch_assoc($check_query)) { ?>

        <div class="member-card">

            <div class="member-image-box">
                <img src="src/<?php echo $row['image_path'] ?>"
                     alt="Member profile"
                     class="member-image"
                     style="object-position: <?php
                         echo (int)($row['crop_x'] ?? 50);
                             ?>% <?php
                          echo (int)($row['crop_y'] ?? 50);
                         ?>%;"
                     >

                <span class="member-status"><?php echo $row['Guild_Post'];  ?></span>
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


<!-- Php mailer -->
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$config = require __DIR__ . '/config.php';

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // $mail->SMTPDebug = 2;                                       
    $mail->isSMTP();                                            
    $mail->Host       = $config['smtp_host'];                    
    $mail->SMTPAuth   = true;                             
    $mail->Username   = $config['smtp_username'];                 
    $mail->Password   = $config['smtp_password'];                        
    $mail->SMTPSecure = 'tls';                              
    $mail->Port       = 587;  

    $mail->setFrom('rohitbgmi370@gmail.com', 'Guild Avangers');           
    $mail->addAddress('krahul935499@gmail.com', 'Rahul Kumar');
     
    $mail->isHTML(true);                                  
    $mail->Subject = 'Guild Application Received | Avengers Guild';

$mail->Body = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received</title>
</head>

<body style="margin:0; padding:0; background-color:#f1f3f6; font-family:Arial,Helvetica,sans-serif;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
        style="background-color:#f1f3f6; padding:30px 10px;">
        <tr>
            <td align="center">

                <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                    style="max-width:600px; background-color:#ffffff; border-radius:12px; overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="background-color:#171717; padding:30px 20px; border-bottom:4px solid #d4a72c;">

                            <h1 style="margin:0; color:#f5c542; font-size:28px; letter-spacing:3px;">
                                AVENGERS
                            </h1>

                            <p style="margin:10px 0 0; color:#d1d5db; font-size:13px; letter-spacing:1px;">
                                GUILD APPLICATION UPDATE
                            </p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding:35px 30px; color:#333333;">

                            <h2 style="margin:0 0 20px; color:#222222; font-size:23px;">
                                Application Received!
                            </h2>

                            <p style="margin:0 0 16px; font-size:15px; line-height:1.8;">
                                Hello Player,
                            </p>

                            <p style="margin:0 0 16px; font-size:15px; line-height:1.8;">
                                Thank you for applying to join
                                <strong style="color:#b8860b;">Avengers Guild</strong>!
                                We are glad that you are interested in becoming a part of our team.
                            </p>

                            <p style="margin:0 0 20px; font-size:15px; line-height:1.8;">
                                Your application has been successfully received and is
                                currently awaiting review by our team.
                            </p>

                            <!-- Status Box -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                style="background-color:#fff9e8; border:1px solid #f0d98b; border-radius:8px;">
                                <tr>
                                    <td style="padding:20px;">

                                        <p style="margin:0 0 10px; color:#8a6508; font-size:14px; font-weight:bold;">
                                            WHAT HAPPENS NEXT?
                                        </p>

                                        <p style="margin:0; color:#444444; font-size:14px; line-height:1.8;">
                                            Our team will review your application and
                                            contact you within
                                            <strong>4–12 hours</strong> with an update
                                            regarding your application status.
                                        </p>

                                    </td>
                                </tr>
                            </table>

                            <p style="margin:22px 0 0; font-size:14px; line-height:1.8; color:#555555;">
                                Please be patient while we review your application.
                                Keep an eye on your inbox for our response.
                            </p>

                            <p style="margin:25px 0 0; font-size:15px; line-height:1.8;">
                                Good luck, and we hope to see you on the battlefield!
                            </p>

                            <p style="margin:25px 0 0; font-size:14px; line-height:1.8;">
                                Best regards,<br>
                                <strong style="color:#b8860b;">Avengers Guild Team</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="background-color:#171717; padding:20px;">

                            <p style="margin:0 0 8px; color:#f5c542; font-size:13px; font-weight:bold;">
                                AVENGERS GUILD
                            </p>

                            <p style="margin:0; color:#b0b0b0; font-size:11px; line-height:1.6;">
                                This is an automated confirmation email.<br>
                                Please do not reply unless instructed by our team.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
';

$mail->AltBody = 'Hello Player,

Thank you for applying to join Avengers Guild!

Your application has been successfully received and is awaiting review. Our team will contact you within 4–12 hours with an update regarding your application status.

Please be patient while we review your application.

Good luck, and we hope to see you on the battlefield!

Best regards,
Avengers Guild Team';
    $mail->send();
    echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


?>

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
            <a href="#leadership">⚔ 3D HIMANSHU</a>
            <a href="#contact">Contact the Guild</a>
        </div>

        <div class="footer-column">
            <h3>Connect</h3>
            
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