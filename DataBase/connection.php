<?php
    $cheak = mysqli_connect("localhost" , "root","" , "chack");
    if($cheak){
        echo "DataBase Connected Successfully";
    }else{
        echo "DataBase Connect Unsuccessfull";
    }

?>