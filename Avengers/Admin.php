<?php
    include_once('connection.php');
    if(isset($_POST['submit'])){
        $member_name = $_POST['Mamber_name'];
        $game_name = $_POST['Game_name'];
        $role = $_POST['role'];
        $age = $_POST['age'];
        $post = $_POST['Post'];

        $query = "INSERT INTO member(Member_name, Game_name , Role , Age , Guild_Post) VALUES('$member_name' , '$game_name' , '$role' , '$age' , '$post')";

        $query_check = mysqli_query($check , $query);

        if($query_check){
            echo "Data Insert Success";
        }else{
            echo "Data Insert Unsuccess";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avangers Admin Panel</title>
</head>

<style>
   table {
  width: 100%;
  border-collapse: collapse; 
}

th, td {
  border: 1px solid #333333; 
  padding: 8px;             
  text-align: center;
}


</style>
<body>
    <h1>Add Memeber</h1>

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

        <label for="">Select Image</label>
        <input type="file" name="image">

        <button type="submit" name="submit">Submit</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Member Name</th>
            <th>Game Name</th>
            <th>Role</th>
            <th>Age</th>
            <th>Post</th>
            <th>image</th>
            <th>Update/Delete</th>
        </tr>

        <?php
                $fatch_query = "SELECT * FROM member";
                 $check_query = mysqli_query($check, $fatch_query);

                if(mysqli_num_rows($check_query)>0){
                  while($row = mysqli_fetch_assoc($check_query)){
                    ?>
            <tr>
                <td><?php echo $row['Member_ID'] ?></td>
                <td><?php echo $row['Member_name'] ?></td>
                <td><?php echo $row['Game_name'] ?></td>
                <td><?php echo $row['Role'] ?></td>
                <td><?php echo $row['Age'] ?></td>
                <td><?php echo $row['Guild_Post'] ?></td>
                <td><a href="update.php?id=<?php echo $row['Member_ID'] ?>">Update</a>/ <a href="deleteUser.php?id=<?php echo $row['Member_ID'] ?>">Delete</a></td>
            </tr>
       <?php             
            }
                }
        ?>
    </table>
</body>
</html>
