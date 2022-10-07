<?php
    session_start();

    require_once './../../config/config.php';
    if(!isset($_SESSION['code'])){
        header("location: ./../../login.php");
    }else{
        $now = time();
        if($now > $_SESSION['expire']){
            session_destroy();
            echo "<script>alert('Your session has expired!');window.location.href='./../../login.php'</script>";
        }
    }

    $user_ref = $_SESSION['pass']['user_ref'];
    $password = $_SESSION['pass']['password'];
    function clean($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $newPass = $confirm = '';
    $newPass_er = $confirm_er = '';
    $passEncrypt = $status = '';
    if(isset($_POST['changePassword'])){
        $userId = $_POST['user_ref'];
        if(empty($_POST['newPass'])){
            $newPass_er = "Enter new password";
        }else{
            $newPass = clean($_POST['newPass']);
            $upper = preg_match("@[A-z]@", $newPass);
            $lower = preg_match("@[a-z]@", $newPass);
            $specialChar = preg_match("@[^\w]@", $newPass);
            $number = preg_match("@[0-9]@", $newPass);
            if(!$upper || !$lower || !$specialChar || !$number || strlen($newPass)<8){
                $newPass_er = "Passwords must contain at least one Uppercase letter and at least one 
                Lowercase letter and one digit and one Special character with password length greater than 8";
            }else{
                $passEncrypt = password_hash($newPass,PASSWORD_DEFAULT);
            }
        }
        if(empty($_POST['confirm'])){
            $confirm_er = "Enter new password";
        }else if($_POST['confirm'] != $_POST['newPass']){
            $confirm_er = "Passwords do not match";
        }else{
            $confirm = clean($_POST['confirm']);
        }
        if(empty($confirm_er) && empty($newPass_er))
        {
            $sql = mysqli_query($conn,"SELECT * FROM onbanking WHERE user_ref='$userId'");
            if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
                $fetchPass = $row['password'];
                if(password_verify($newPass,$fetchPass)){
                    $newPass_er = "Please use a different password(Password can,t be same as old password)";
                }else{
                    $sql = mysqli_query($conn, "UPDATE onbanking SET password='$passEncrypt' WHERE user_ref='$user_ref'");
                    if($sql){
                        echo "<script>alert('Password has been updated');window.location.href='./../../login.php';</script>";
                        session_destroy();
                    }else{
                        echo "<script>alert('Password has not been updated')</script>";
                    }
                }
            }else{
                $status = "not found";
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="form-container">
            <form action="" method="POST" class="form-contents" >
                <span><?=$status?></span>
                <input type="hidden" name="user_ref" id="" value="<?=$user_ref?>">
                <input type="password" name="newPass" id="newPass" placeholder="Enter your new password" pattern="(?=.*/d)(?=.*[a-z])(?=.*[A-Z])(?=.*?([@#$%&^+])(?=.*[0-9].{8,})">
                <div class="message" id="message">
                    <p id="upper" class="invalid">Password must contains atleast one <b>Uppercase</b></p>
                    <p id="lower" class="invalid">Password must contains atleast one <b>Lowercase</b></p>
                    <p id="character" class="invalid">Password must contains atleast one <b>Special Character</b></p>
                    <p id="number" class="invalid">Password must contains atleast one <b>Number</b></p>
                    <p id="length" class="invalid">Password must be greater than or equal <b>8</b></p>
                </div>
                <label for="">
                <input type="checkbox"  id="" onclick="showPassword();"> Show Password
                </label>
                <span class="text-danger d-block"><?=$newPass_er?></span>
                <input type="password" name="confirm" id="confirm" placeholder="Confirm new password">
                <span class="text-danger d-block"><?=$confirm_er?></span>
                <div class="form-submit">
                    <button type="submit" name="changePassword" id='d'>Update</button>
                </div>
            </form>
        </div>
</body>



<style>
    #message{
        display: none;
        width: 100%;
        text-align: left;
        font-size: 13px;
        padding: 5px;
        background-color: #f9f9f9;
    }
    #message .invalid::before{
        content: '❌';
        margin-right: 10px;
    }
    #message .valid::before{
        content: '✔';
        margin-right: 10px;
        color: green;
        font-weight: bold;
    }

    .form-container{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(0,0,0); /* fallback color*/
        background-color: rgba(0,0,0,0.3);
    }
    .form-container .form-contents{
        width: 55%;
        height: 40%;
        margin: 50px auto;
        padding: 40px  25px;
        background-color: #fff;
        border: 1px solid #ccc;
        text-align: center;
        -webkit-animation: animatezoom;
        animation: animatezoom 0.6s;
    }
    @-webkit-keyframe animatezoom{
        from{transform: scale(0)}
        to{transform: scale(1)}
    }
    @keyframes animatezoom {
        from{transform: scale(0)}
        to{transform: scale(1)}
    }
    .form-contents span{
        display: block;
        color: red;
    }
    .form-container .form-contents input[type="password"],input[type="text"]{
        width: 100%;
        margin: 10px 0;
        padding: 7px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }
    label{
        display: flex;
    }
    button{
        width: 50%;
        padding: 10px;
        color: #fff;
        background-color: #00f;
        border: none;
        cursor: pointer;
    }
    @media screen and (min-width: 768px) {
        .form-container .form-contents{
            width: 40%;
            height: 32%;
        }
        .form-container .form-contents input[type="password"],input[type="text"]{
            width: 90%;
        }
        label{
            margin-left: 20px;
        }
        #message{
        width: 100%;
        text-align: left;
        font-size: 14px;
        padding: 5px;
    }
    }
    @media screen and (min-width: 1200px) {
        #message{
        width: 95%;
        font-size: 15px;
        padding: 10px;
    }
        .form-container .form-contents{
            width: 30%;
            height: 35%;
        }
        .form-container .form-contents input[type="password"],input[type="text"]{
            width: 90%;
        }
        label{
            margin-left: 20px;
        }
    }
</style>


<script>

    let passInput = document.getElementById('newPass')
    function showPassword(){
        if(passInput.type == 'password'){
            passInput.type = 'text';
        }else{
            passInput.type = 'password';
        }
    }
    var message = document.getElementById('message');
    var formContainer = document.querySelector('form');
    var upper = document.getElementById('upper');
    var lower = document.getElementById('lower');
    var char = document.getElementById('character');
    var number = document.getElementById('number');
    var length = document.getElementById('length');
   
    passInput.onfocus = function() {
        const mediaQuery = window.matchMedia('(min-width: 768px)');
        if(mediaQuery.matches){
            message.style.display = 'block';
            formContainer.style.height = '10%';
        }
        message.style.display = 'block';
        formContainer.style.height = '72%';
    }
    passInput.onblur = function() {
        message.style.display = 'none';
        formContainer.style.height = '30%';
    };
    passInput.onkeyup = function() {
        var upperCase = /[A-Z]/g;
        if(passInput.value.match(upperCase)){
            upper.classList.remove('invalid');
            upper.classList.add('valid');

        }else{
            upper.classList.remove('valid');
            upper.classList.add('invalid');
        }
        var lowerCase = /[a-z]/g;
        if(passInput.value.match(lowerCase)){
            lower.classList.remove('invalid');
            lower.classList.add('valid');

        }else{
            lower.classList.remove('valid');
            lower.classList.add('invalid');
        }
        var numberInput = /[0-9]/g;
        if(passInput.value.match(numberInput)){
            number.classList.remove('invalid');
            number.classList.add('valid');

        }else{
            number.classList.remove('valid');
            number.classList.add('invalid');
        }
        var specChar = /[@#$%&*+]/g;
        if(passInput.value.match(specChar)){
            char.classList.remove('invalid');
            char.classList.add('valid');

        }else{
            char.classList.remove('valid');
            char.classList.add('invalid');
        }
        
        if(passInput.value.length >=8){
            length.classList.remove('invalid');
            length.classList.add('valid');

        }else{
            length.classList.remove('valid');
            length.classList.add('invalid');
        }
    }


</script>
</html>