<?php
    include_once("connection.php");
    
    $member_id = $_GET['id'];    

    $delete_query = "DELETE FROM member WHERE Member_ID=$member_id";
    $check_query = mysqli_query($check, $delete_query);


    if($check_query){
        header("Location: admin.php");
        exit();
    }else{
        echo "Data not Deleted";
    }

?>