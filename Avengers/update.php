<?php
    include_once('connection.php');

    $user_id = $_GET['id'];

    if(isset($_POST['submit'])){
        $name = $_POST['Mamber_name'];
        $game_name = $_POST['Game_name'];
        $role = $_POST['role'];
        $age = $_POST['age'];
        $post = $_POST['Post'];

        $query = "UPDATE member SET Member_name='$name' , Game_name='$game_name' , Role='$role' , Age='$age' , Guild_Post='$post' WHERE Member_ID=$user_id";

        $query_check = mysqli_query($check , $query);
        if($query_check){
           header('Location: Admin.php');
           exit();
        }else{
            echo "Update Fail";
        }
    }
?>


<form method="post">
        <label>Enter Name</label>
        <input type="text" name="Mamber_name">

        <br>

        <label>Enter Game Name</label>
        <input type="text" name="Game_name">
        
        <label for="">Role</label>
        <select name="role">
            <option value="">Select Role</option>
            <option value="Rusher">Rusher</option>
            <option value="Sniper">Sniper</option>
            <option value="Secondary Rusher">Secondary Rusher</option>
            <option value="Nader">Nader</option>
            <option value="All Rounder">All Rounder</option>
        </select>

        <label for="">Enter Age</label>
        <input type="number" name="age" >
        
        <label for="">Post</label>
        <select name="Post">
            <option value="">Select Post</option>
            <option value="Leader">Leader</option>
            <option value="Acting Leader">Acting Leader</option>
            <option value="Officer">Officer</option>
            <option value="Member">Member</option>
        </select>

        <button name="submit">Submit</button>
    </form>
