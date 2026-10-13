<?php
    include_once('connection.php');

    if(isset($_POST['btn'])){
        $name = $_POST['name'];
        $age = $_POST['age'];
        $feedback = $_POST['feedBack'];

        $query = "INSERT INTO user(name , age , feedback) VALUES ('$name' , '$age' , '$feedback')";
        $query_check = mysqli_query($cheak , $query);

        if($query_check){
            echo "Data Submited";
        }
        else{
            echo "Data Not Submit";
        }

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
    
    <form method="post">
        <label for="name">Enter Name</label>
        <input type="text" name="name">

        <br>

        <label for="age"> Enter Age</label>
        <input type="number" name="age">

        <br>

        <label for="feedBack">FeedBack</label>
        <input type="text" name="feedBack">

        <button name="btn">submit</button>

        <button name="btn2">Show Data</button>
    </form>


    <table border=2 >
        <tr>
            <th>Student_id</th>
            <th>Student_Name</th>
            <th>Student_Age</th>
            <th>Student_Feedack</th>
        </tr>

    <?php
    if(isset($_POST['btn2'])){
        $fatchDataQuery = "SELECT * FROM user";
           $query_check2 = mysqli_query($cheak , $fatchDataQuery);
           if(mysqli_num_rows($query_check2)>0){
               while($rows = mysqli_fetch_assoc($query_check2)){
                ?>
    
    
        <tr>
            <td><?php echo $rows['student_id'] ?></td>
            <td><?php echo $rows['name'] ?></td>
            <td><?php echo $rows['age'] ?></td>
            <td><?php echo $rows['feedback'] ?></td>
    </tr>
      

 
<?php 


               }
           }
    }
?>

</table>
</body>
</html>