<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header("Location: Avengers.php");
    exit();
}

require_once __DIR__ . '/connection.php';

$memberName = $_SESSION['name'] ?? 'Guild Member';
$memberEmail = $_SESSION['email'] ?? '';
$memberId = (int) $_SESSION['user_id'];
$memberRole = $_SESSION['role'] ?? 'member';

// Refresh basic account details from the database.
$stmt = mysqli_prepare(
    $check,
    "SELECT full_name, email, account_role FROM authentication WHERE user_id = ? LIMIT 1"
);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $memberId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && ($account = mysqli_fetch_assoc($result))) {
        $memberName = $account['full_name'];
        $memberEmail = $account['email'];
        $memberRole = $account['account_role'];
        $_SESSION['name'] = $memberName;
        $_SESSION['email'] = $memberEmail;
        $_SESSION['role'] = $memberRole;
    }
    mysqli_stmt_close($stmt);
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Profile | Avengers Guild</title>
    <link rel="stylesheet" href="style/bg-video.css">
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <video autoplay muted loop id="bg-video">
        <source src="src/Avanger.mp4" type="video/mp4">
    </video>

    <header class="navbar">
        <h1 class="title">AVENGERS</h1>
        <nav class="nav-links">
            <a href="Avengers.php">Home</a>
            <a href="Avengers.php#team">Guild Members</a>
            <a href="Avengers.php#contact">Contact Us</a>

            <div class="profile-menu">
                <button class="profile-trigger" id="profileTrigger" type="button"
                        aria-expanded="false" aria-controls="profileDropdown">
                    <span class="profile-avatar"><?php echo e(strtoupper(substr($memberName, 0, 1))); ?></span>
                    <span><?php echo e($memberName); ?></span>
                    <span class="dropdown-arrow">▾</span>
                </button>
                <div class="profile-dropdown" id="profileDropdown">
                    <a href="member-dashboard.php" class="selected">My Profile</a>
                    <a href="Avengers.php">Back to Website</a>
                    <a href="logout.php" class="logout-link">Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="profile-page">
        <section class="welcome-heading">
            <p class="profile-eyebrow">AVENGERS GUILD MEMBER AREA</p>
            <h2>WELCOME BACK, <span><?php echo e(strtoupper($memberName)); ?></span></h2>
            <p>Your guild profile and the latest announcements are right here.</p>
        </section>

        <section class="announcement-section" aria-label="Guild announcements">
            <div class="announcement-topline">
                <span class="live-dot"></span>
                <span>GUILD ANNOUNCEMENTS</span>
                <span class="announcement-count" id="announcementCount">01 / 03</span>
            </div>

            <div class="announcement-carousel">
                <article class="announcement-slide active">
                    <span class="announcement-label">WELCOME</span>
                    <h3>Welcome to the Avengers Guild</h3>
                    <p>Your account is ready. Visit your profile and stay connected with your guild.</p>
                </article>
                <article class="announcement-slide">
                    <span class="announcement-label">GUILD UPDATE</span>
                    <h3>Stay Connected With Your Team</h3>
                    <p>Check the home page regularly for guild updates, member information and activities.</p>
                </article>
                <article class="announcement-slide">
                    <span class="announcement-label">REMINDER</span>
                    <h3>Keep Your Account Details Updated</h3>
                    <p>Make sure your registered email address is active so you can receive important updates.</p>
                </article>

                <div class="carousel-controls">
                    <button type="button" id="previousAnnouncement" aria-label="Previous announcement">‹</button>
                    <div class="carousel-dots" id="carouselDots">
                        <button class="active" type="button" aria-label="Announcement 1"></button>
                        <button type="button" aria-label="Announcement 2"></button>
                        <button type="button" aria-label="Announcement 3"></button>
                    </div>
                    <button type="button" id="nextAnnouncement" aria-label="Next announcement">›</button>
                </div>
            </div>
        </section>

        <section class="member-profile-card">
            <div class="profile-card-heading">
                <div>
                    <p class="profile-eyebrow">YOUR ACCOUNT</p>
                    <h2>PROFILE <span>DETAILS</span></h2>
                </div>
                <span class="account-status"><i></i> Logged In</span>
            </div>

            <div class="profile-details">
                <div class="large-avatar"><?php echo e(strtoupper(substr($memberName, 0, 1))); ?></div>
                <div class="profile-data">
                    <div class="detail-item">
                        <span>Full Name</span>
                        <strong><?php echo e($memberName); ?></strong>
                    </div>
                    <div class="detail-item">
                        <span>Email Address</span>
                        <strong><?php echo e($memberEmail); ?></strong>
                    </div>
                    <div class="detail-item">
                        <span>Member ID</span>
                        <strong>#<?php echo e($memberId); ?></strong>
                    </div>
                    <div class="detail-item">
                        <span>Account Role</span>
                        <strong><?php echo e(ucfirst($memberRole)); ?></strong>
                    </div>
                </div>
            </div>

            <div class="profile-card-footer">
                <a href="Avengers.php" class="profile-home-btn">EXPLORE GUILD <span>→</span></a>
                <a href="logout.php" class="profile-logout-btn">LOG OUT</a>
            </div>
        </section>
    </main>

    <script>
    (() => {
        const slides = [...document.querySelectorAll('.announcement-slide')];
        const dots = [...document.querySelectorAll('#carouselDots button')];
        const count = document.getElementById('announcementCount');
        const previous = document.getElementById('previousAnnouncement');
        const next = document.getElementById('nextAnnouncement');
        const trigger = document.getElementById('profileTrigger');
        const dropdown = document.getElementById('profileDropdown');
        let current = 0;
        let timer;

        function showSlide(index) {
            current = (index + slides.length) % slides.length;
            slides.forEach((slide, i) => slide.classList.toggle('active', i === current));
            dots.forEach((dot, i) => dot.classList.toggle('active', i === current));
            count.textContent = String(current + 1).padStart(2, '0') + ' / ' +
                                String(slides.length).padStart(2, '0');
        }

        function restartTimer() {
            clearInterval(timer);
            timer = setInterval(() => showSlide(current + 1), 5000);
        }

        previous.addEventListener('click', () => {
            showSlide(current - 1);
            restartTimer();
        });
        next.addEventListener('click', () => {
            showSlide(current + 1);
            restartTimer();
        });
        dots.forEach((dot, i) => dot.addEventListener('click', () => {
            showSlide(i);
            restartTimer();
        }));
        restartTimer();

        trigger.addEventListener('click', () => {
            const isOpen = dropdown.classList.toggle('show');
            trigger.setAttribute('aria-expanded', String(isOpen));
        });
        document.addEventListener('click', event => {
            if (!event.target.closest('.profile-menu')) {
                dropdown.classList.remove('show');
                trigger.setAttribute('aria-expanded', 'false');
            }
        });
    })();
    </script>
</body>
</html>
