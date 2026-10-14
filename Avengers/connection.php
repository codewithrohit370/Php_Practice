<?php
    $check = mysqli_connect("localhost" , "root" , "" , "avangers");

    if($check){
        $massage =  "DataBase Connected Successfully";
    }else{
        echo "DataBase Can't Connect";
    }
?>