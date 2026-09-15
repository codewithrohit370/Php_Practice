<?php
    $math = 23;
    $sci = 19;
    $sst = 28;
    $hindi = 15;
    $engish = 58;
    $total = $math + $sci + $sst + $hindi + $engish;
    $avg = $total / 5
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Card</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container">
        <h3>Student Result</h3>
        <img src="faq-hero-mobile.png">
        <p>Student Name : <?php echo "<span> Popat </span>"?></p>
        <p>Math : <?php echo "<span>$math</span>" ?></p>
        <p>Sci : <?php echo "<span>$sci</span>" ?></p>
        <p>SST : <?php echo "<span>$sst</span>" ?></p>
        <p>Hindi : <?php echo "<span>$hindi</span>" ?></p>
        <p>Engish : <?php echo "<span>$engish</span>" ?></p>
        <p>Total : <?php echo "<span>$total</span>"?></p>
        <p>Avg :  <?php echo "<span>$avg </span>" ?></p>
        <p>Grade : <?php if($avg < 0 || $avg>100){
        echo "<span>Invaild Entry</span>";
    }
    elseif ($avg>89){
        echo "<span>A </span>";
    }
    elseif ($avg>70 && $avg<90){
        echo "<span>B</span>";
    }
    elseif ($avg>60 && $avg<70){
        echo "<span>C</span";
    }
    elseif ($avg>33 && $avg<60){
        echo "<span>D</span>";
    }
    else{
        echo "<span>Fail</span>";
    } ?></p>
    </div>
</body>
</html>