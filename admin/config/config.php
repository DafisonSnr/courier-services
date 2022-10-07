<?php

    $host = "localhost";
    $user = "root";
    $pass = "root";
    $db = "swiftBankDatabase";
    $conn = mysqli_connect($host, $user, $pass, $db);
    if(!$conn){
        die("Database Could not be reaached".mysqli_connect_error());
    }

    // $host = "localhost";
    // $user = "wellqotz_wellspringUser";
    // $pass = "Kpukpu@2020";
    // $db = "wellqotz_wellspringBase";
    // $conn = mysqli_connect($host, $user, $pass, $db);
    // if(!$conn){
    //     die("Database Could not be reaached".mysqli_connect_error());
    // }

?>