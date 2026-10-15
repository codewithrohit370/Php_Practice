<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avangers</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


</head>
<body>
<video autoplay muted loop id="bg-video">
  <source src="Untitled.mp4" type="video/mp4">
</video>
<h1 class="title">AVENGERS</h1>

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