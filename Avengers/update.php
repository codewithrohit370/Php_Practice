<?php
    include_once('connection.php');

    $user_id = $_GET['id'];

    $fatch_query = "SELECT * FROM member WHERE Member_ID=$user_id";
    $check_query = mysqli_query($check, $fatch_query);
    $row = mysqli_fetch_assoc($check_query);
    

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
        <input type="text" name="Mamber_name" value="<?php echo $row['Member_name']; ?>">

        <br>

        <label>Enter Game Name</label>
        <input type="text" name="Game_name" value="<?php echo $row['Game_name']; ?>">
        
        <label for="">Role</label>
        <select name="role">
            <option value="">Select Role</option>
            <option value="Rusher" <?php if ($row['Role'] == 'Rusher') echo 'selected'; ?> >Rusher</option>
            <option value="Sniper" <?php if ($row['Role'] == 'Sniper') echo 'selected'; ?> >Sniper</option>
            <option value="Secondary Rusher"  <?php if ($row['Role'] == 'Secondary Rusher') echo 'selected'; ?> >Secondary Rusher</option>
            <option value="Nader" <?php if ($row['Role'] == 'Nader') echo 'selected'; ?> >Nader</option>
            <option value="All Rounder"   <?php if ($row['Role'] == 'All Rounder') echo 'selected'; ?> >All Rounder</option>
        </select>

        <label for="">Enter Age</label>
        <input type="number" name="age" value="<?php echo $row['Age']; ?>" >
        
        <label for="">Post</label>
        <select name="Post" value="<?php echo $row['Guild_Post']; ?>">
            <option value="">Select Post</option>
            <option value="Leader" <?php if($row['Guild_Post'] == 'Leader') echo 'selected'?> >Leader</option>
            <option value="Acting Leader" <?php if($row['Guild_Post'] == 'Acting Leader') echo 'selected'?>>Acting Leader</option>
            <option value="Officer" <?php if($row['Guild_Post'] == 'Officer') echo 'selected'?>>Officer</option>
            <option value="Member" <?php if($row['Guild_Post'] == 'Member') echo 'selected'?>>Member</option>
        </select>

        <button name="submit">Submit</button>
    </form>
