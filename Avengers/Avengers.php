<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avangers</title>
    <link rel="stylesheet" href="style/bg-video.css">
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/hero-section.css">
    <link rel="stylesheet" href="style.css">
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


 <div class="card-container">

 <?php
    include_once ('connection.php');

    $fatch_query = "SELECT * FROM member";
    $check_query = mysqli_query($check, $fatch_query);

    if(mysqli_num_rows($check_query)>0){
        while($row = mysqli_fetch_assoc($check_query)){
          ?>
          <div class="card">
              <img src="MOHIT.jpeg" class="img-2">
              <p class="p-1"><?php echo $row['Game_name'] ?></p>
              <p class="p-2"><?php echo $row['Guild_Post'] ?></p>
              <button class="add-btn">Team Up</button>
          </div>
<?php          
        }
    }

?>

</div>
    
</body>
</html>