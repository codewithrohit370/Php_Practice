<?php
    if(isset($_POST['sub'])){
        @$user_name = $_POST['username'];
        @$user_email = $_POST['email'];
        @$user_age = $_POST['age'];
        @$user_city = $_POST['city'];
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

    <h1>Enter Bio Data</h1>
    
    <form method="Post">
        <label for="username">Name</label>
        <input type="text" name="username" id="username">
        <br>

        <label for="email">Email</label>
        <input type="text" name="email" id="email">
        <br>
        <label for="age">Age</label>
        <input type="number" name="age" id="age">
        <br>
        <label for="city">City</label>
        <input type="text" name="city" id="city">
        <br>
        <input type="submit" value="get user details" name="sub">
    </form>

    <h1>Here Is Your data</h1>
    <h4>Name : <?php echo $user_name?></h4>
    <h4>Email : <?php echo $user_email?></h4>
    <h4>age : <?php echo $user_age?></h4>
    <h4>City : <?php echo $user_city?></h4>
</body>
</html>