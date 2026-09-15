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

    <p>Name : <?php echo $nm?></p>
    <p>Email : <?php echo $em?></p>
    <p>Age : <?php echo $ag?></p>
    <p>FeedBack : <?php echo $feedBack?></p>
</body>
</html>