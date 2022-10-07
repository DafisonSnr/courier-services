<?php
// session_start();
//  require_once './header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.1.1/cerulean/bootstrap.min.css">
    <title>Document</title>
    <style>
        .container {
            width: 500px;
            /* height: 500px;
            margin: 200px auto;
            background-color: #ccc; */
        }
        .row{
            position: relative;
        }
    ::placeholder{
        font-weight: bold;
    }
    /* input{
       width: 50%; 
       margin: 20px 0 0 100px;
       padding: 10px;
       border: 2px solid blue;
    } */
    p.message{
        width: 70%;
        margin: 10px auto;
        color: #f00;
        font-weight: bold;
    }
    @media only screen and (min-width: 768px) {
        .container{
            width: 700px;
        }
    }
    @media only screen and (min-width: 1200px) {
        .container{
            width: 500px;
            box-sizing: border-box;
        }
        p.message{
            width: 80%;
            font-size: 16px;
            margin: 10px auto;
            color: #f00;
            font-weight: bold;
        }

    }
    .spinner-background{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(0,0,0,0);
        background-color: rgba(0,0,0,0.5);     
    }
    
    .text-center{
       margin-top: 200px;;
    }
</style>
</head>
<body>
    <div id="showform"></div>
<div class="container">
    <div class="row text-center mx-auto w-100 my-5 shadow-lg bg-light">
        <p class="message">OTP code has been sent to your email(code last for 10min)</p>
        <form action="" method="post" autocomplete="off">
            <input type="hidden" id="userEmail">
            <input type="hidden" id="userRef">
            <input type="password" name="otp_password" placeholder="Enter 6 digits OTP code" id="otp_pass" class="form-control form-control-sm w-50 mx-auto" onkeydown="limit(this)" onkeyup="limit(this)" onkeypress="return (event.charCode !=8 && event.charCode ==0 ||(event.charCode == 46 ||(event.charCode >=48 && event.charCode <=57)))">
            <span id="otpPass_er" class="text-danger d-block"></span>
            <button type="submit" id="submit_pass_otp" class="btn btn btn-primary w-50 my-3 mx-auto " onclick="">Login</button>
        </form>
        <div class="spinner-background2">
            <div class="text-center" id="spiner" style="color:red;">
                <div class="spinner-border" role="status">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    function limit(element) {
        var num_limit = 6;
        if(element.value.length > num_limit){
            element.value = element.value.substr(0, num_limit);
        }
    }
</script>

<style>
     .spinner-background2{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(0,0,0,0);
        background-color: rgba(0,0,0,0.5);     
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./../js/login.js"></script>
</html>


