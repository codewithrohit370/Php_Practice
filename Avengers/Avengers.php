<?php
include_once('connection.php');
    include('authication.php');
    include("login.php");

?>

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
    <link rel="stylesheet" href="style/auth.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">


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
            <button class="nav-btn login-btn" onclick="openAuth('login')">Login</button>
            <button class="nav-btn signup-btn" onclick="openAuth('signup')">Sign Up</button>
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

                <a onclick="openAuth('signup')" class="hero-btn secondary-btn">
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
                    <img src="src/WhatsApp Image 2026-10-16 at 3.49.32 PM.jpeg" alt="Guild Leader">
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
                    <img src="src/s8.jpg" alt="Acting Guild Leader">
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



    if ($check_query && mysqli_num_rows($check_query) > 0) {
    ?>

        <div class="card-container">

            <?php while ($row = mysqli_fetch_assoc($check_query)) { ?>

            <div class="member-card">

                <div class="member-image-box">
                    <img src="src/<?php echo $row['image_path'] ?>" alt="Member profile" class="member-image">

                    <span class="member-status">
                        <?php echo $row['Guild_Post'];  ?>
                    </span>
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

                    <button type="button" class="show-details-btn"
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

    if(isset($_POST['submit-btn'])){

    $name = trim($_POST['member_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $query = trim($_POST['Query'] ?? '');

    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($query)) {
        echo "Please enter valid details.";
    exit;
    }

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
    $mail->addAddress($email, $name);
     
    $mail->isHTML(true);                                  
    $mail->Subject = 'We Received Your Query | Avengers Guild';

    $mail->Body = '
        <div style="margin:0;padding:30px 10px;background:#f1f3f6;font-family:Arial,sans-serif;">

            <div style="max-width:600px;margin:auto;background:#ffffff;border-radius:12px;overflow:hidden;">

                <div style="background:#171717;padding:30px;text-align:center;border-bottom:4px solid #d4a72c;">

                    <h1 style="color:#f5c542;margin:0;letter-spacing:3px;">
                        AVENGERS
                    </h1>

                    <p style="color:#d1d5db;font-size:13px;">
                        GUILD SUPPORT CENTER
                    </p>

                </div>

                <div style="padding:35px 30px;color:#333;">

                    <h2 style="color:#222;">Query Received!</h2>

                    <p>Hello <strong>'.$name.'</strong>,</p>

                    <p style="line-height:1.8;">
                        Thank you for contacting
                        <strong style="color:#b8860b;">Avengers Guild</strong>.
                    </p>

                    <p style="line-height:1.8;">
                        We have successfully received your query.
                        Our team will review your message and get back
                        to you as soon as possible.
                    </p>

                    <div style="background:#fff9e8;border:1px solid #f0d98b;
                    padding:20px;border-radius:8px;margin:25px 0;">

                        <h3 style="color:#8a6508;margin-top:0;">
                            WHAT HAPPENS NEXT?
                        </h3>

                        <h2 style="color:#222;margin-bottom:10px;">
                            4–6 Hours
                        </h2>

                        <p style="line-height:1.7;margin-bottom:0;">
                            Our team will review your query and reply
                            to your email within 4–6 hours.
                        </p>

                    </div>

                    <p style="line-height:1.8;">
                        Please keep an eye on your inbox for our response.
                    </p>

                    <p style="margin-top:25px;line-height:1.8;">
                        Best regards,<br>
                        <strong style="color:#b8860b;">
                            Avengers Guild Support Team
                        </strong>
                    </p>

                </div>

                <div style="background:#171717;padding:20px;text-align:center;">

                    <p style="color:#f5c542;font-weight:bold;">
                        AVENGERS GUILD
                    </p>

                    <p style="color:#b0b0b0;font-size:12px;">
                        United as one. Stronger together.
                    </p>

                </div>

            </div>
        </div>';

    $mail->AltBody = "Hello $name,

        Thank you for contacting Avengers Guild.

        We have successfully received your query.

        Our team will review your message and reply within 4-6 hours.

        Best regards,
        Avengers Guild Support Team";
    $mail->send();
    echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}

?>

    <section class="contact-section" id="contact">

        <div class="contact-heading">
            <p class="section-tag">BECOME A WARRIOR</p>
            <h2>Ask<span>Query</span></h2>
            <p>Fill in your details and take your place on the team.</p>
        </div>

        <form class="guild-form" method="POST">

            <div class="form-grid">

                <div class="form-group">
                    <label for="member_name">Full Name</label>
                    <input type="text" id="member_name" name="member_name" placeholder="Enter your full name"
                        maxlength="100" required>
                </div>


                <div class="form-group full-width">
                    <label for="phone">Email ID</label>
                    <input type="email" id="phone" name="email" placeholder="Enter your Email id" required>
                    <small>Enter your Email ID.</small>
                </div>

                <div class="form-group full-width">
                    <label for="Query">Ask Query</label>
                    <textarea id="phone" name="Query" placeholder="Enter your Query" required></textarea>
                </div>

            </div>

            <button type="submit" class="submit-guild-btn" name="submit-btn">
                Ask Query <span>→</span>
            </button>

            <p class="form-note">
                Your Query will be submitted to the guild administrator.
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
                &copy;
                <?php echo date('Y'); ?>
                <span>AVENGERS GUILD</span>.
                All rights reserved.
            </p>

            <a href="#top" class="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;">
                Back to Top ↑
            </a>
        </div>

    </footer>


    <!-- AUTH POPUP -->
    <div class="auth-overlay" id="authOverlay">

        <div class="auth-modal">

            <button type="button" class="auth-close" onclick="closeAuth()">
                &times;
            </button>

            <div class="auth-heading">
                <p class="auth-tag">AVENGERS GUILD</p>
                <h2 id="authTitle">MEMBER <span>LOGIN</span></h2>
            </div>

            <!-- AUTH TABS -->
            <div class="auth-tabs">
                <button type="button" id="loginTab" class="auth-tab active" onclick="switchAuth('login')">
                    LOGIN
                </button>

                <button type="button" id="signupTab" class="auth-tab" onclick="switchAuth('signup')">
                    SIGN UP
                </button>
            </div>

            <!-- LOGIN FORM -->
            <form class="auth-form" id="loginForm" method="POST">

                <div class="auth-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="auth-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="auth-options">
                    <label>
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>

                    <a href="forgot-password.php">Forgot Password?</a>
                </div>

                 <?php if (!empty($loginMessage)) { ?>

                <p class="auth-message">
                    <?php echo htmlspecialchars($loginMessage); ?>
                </p>
                
                <?php } ?>

                <button type="submit" name="login" class="auth-submit">
                    LOGIN TO GUILD →
                </button>

            </form>

            <!-- SIGNUP FORM -->
            <form class="auth-form" id="signupForm" method="POST" hidden>

                <div class="auth-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Enter your full name" required>
                </div>

                <div class="auth-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="auth-group">
                    <label>Create Password</label>
                    <input type="password" name="password" placeholder="Minimum 8 characters" minlength="8" required>
                </div>

                <div class="auth-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirm your password" minlength="8"
                        required>
                </div>

                <button type="submit" name="signup" class="auth-submit">
                    CREATE ACCOUNT →
                </button>

            </form>

            <?php if (!empty($signupMessage)) { ?>
                <p class="auth-message">
                    <?php echo htmlspecialchars($signupMessage); ?>
                </p>
            <?php } ?>

            <p class="auth-switch" id="authSwitchText">
                    Don't have an account?
                  <a href="#" id="authSwitchLink">Sign Up</a>
            </p>

        </div>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <script src="animation.js"></script>

<?php if (isset($_POST['signup'])) { ?>

<script>
    window.addEventListener('load', function () {
        openAuth('signup');
    });
</script>

<?php } ?>
<?php if (isset($_POST['login'])) { ?>

<script>
    window.addEventListener('load', function () {
        openAuth('login');
    });
</script>

<?php } ?>

</body>
</html>
</body>

</html>