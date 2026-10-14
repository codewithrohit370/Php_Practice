<?php
    if(isset($_POST['enter'])){
        $nm = $_POST['username'];
        $em = $_POST['email'];
        $ag = $_POST['age'];
        $feedBack = $_POST['FeedBack'];
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <label for="">Enter Name</label>
        <input type="text" name="username">
        <br>
        <label for="">Enter Email</label>
        <input type="text" name="email">
        <br>
        <label for="">Enter age</label>
        <input type="number" name="age">
        <br>
        <label for="">Tell Me About your Self</label>
        <textarea type="text" name="FeedBack"></textarea>

        <br>
        <button name="enter">Show details</button>
    </form>



    <p>Name : <?php echo $nm ?? ''?></p>
    <p>Email : <?php echo $em ?? ''?></p>
    <p>Age : <?php echo $ag ?? ''?></p>
    <p>FeedBack : <?php echo $feedBack ?? ''?></p>


    <?php
        if(isset($_POST['check'])){
            $name = $_POST['nm'];
            $age = $_POST['ag'];

            if($age>=18){
            $result = $name . " Your Age is ". $age ." So Your eligble For vote";
        }elseif($age<0){
            $result = "Invaild Entry";
        }
        else{
            $result = $name . " Your Age is ". $age ." So Your Not eligble For vote";
        }
        }
        
    ?>
    <h1 style="text-align:center;">Let's Check You are eligble for Vote or Not</h1>
    <form  method="post">
    <label for="">Enter Your Name</label>
    <input type="text" name="nm">
    <br>
    <label for="">Enter Age</label>
    <input type="number" name=ag>

    <button name='check' class='result'>See Result</button>
    </form>

    <h3><?php echo $result?></h3>
</body>
</html>