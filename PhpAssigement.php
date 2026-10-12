<?php
    //Question 1
    $math = 87;
    $sci = 99;
    $sst = 76;
    $hindi= 99;
    $english = 45;
    $total = $math + $sci + $sst + $hindi + $english;
    $avg = $total/5;
    echo "Total Marks : ".$total;
    echo "<br>";
    echo "Avarage No : ".$avg;



    //Question 2
    $side = 7;
    $area = $side * $side;
    echo "<br>";
    echo "Area of Squrae : ".$area;
    echo "<br>";

    //Question 3
    $length = 7;
    $breadth = 8;
    $areaReatangle = $length * $breadth;
    echo "Area of Reatangle : ".$areaReatangle;
    echo "<br>";

    //Question 4

    $length1 = 45;
    $breadth1 = 65;
    $parimeter = 2*($length1 + $breadth1);
    echo "Parimeter of Reatangle :".$parimeter;
    echo "<br>";

    //question 5;
    $salary = 26500;
    $increaseSalary = $salary * 5/100;
    $newSalary = $salary + $increaseSalary;
    echo "New Salary : ".$newSalary;
    echo "<br>";

    //Question 6

    $reminder = 8 % 3;
    echo "Reminder of 8 / 3 Is :".$reminder;
    echo "<br>";

    //question 7

    $radius = 20;
    $areaOfCircle = 3.14 * $radius * $radius;
    echo "Area of Circle : ".$areaOfCircle;
    echo "<br>";

?>