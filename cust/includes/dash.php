<?php
    error_reporting(0);
    session_start();
    if(!(isset($_SESSION['user']))){
        header("location: ./../login");
    } else {
        $now = time(); // Checking the time now when home page starts.
        if ($now > $_SESSION['expire']) {
            session_destroy();
            echo "<script>alert('Your session has expired!');window.location.href='./../login'</script>";
        }
      
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.1.1/cerulean/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../assets/image/bb.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Signika:wght@300&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="./assets/css/dashboard.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>WELLSPRING BANK</title>
 <!-- <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./../assets/css/style.css"> -->
    <!-- <link rel="stylesheet" href="./../assets/scss/style.css">
    <link rel="stylesheet" href="./assets/scss/style.css">    -->
</head>
<body>