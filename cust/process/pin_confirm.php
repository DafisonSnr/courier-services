<?php
    require_once '../config/config.php';
    require_once '../includes/reg-header.php';

    $userRef = $_POST['userRef'];
    $amt = $_POST['amt'];
    $name = $_POST['name'];
    $acc = $_POST['acc'];
    $formatAmt = $_POST['fmt'];
    $cur = $_POST['cur'];
    $checked = $_POST['check'];
    $type = $_POST['type'];
    $sender = $_POST['sender'];
    
    $pinCheck = mysqli_query($conn, "SELECT * FROM tranpin WHERE user_ref = '$userRef'");
    if(mysqli_num_rows($pinCheck) ==1){
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref = '$userRef'");
        if(mysqli_num_rows($sql)>0){
            $row = mysqli_fetch_array($sql);
        }
    }else{
        echo "Error";
        
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .close-btn{
            float: right;
            font-size: 40px;
            color: red;
            margin: -30px 0px 20px 0;
            cursor: pointer;
        }
        .close-btn:hover{
            color: black;
        }
        .bouncer{
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            width: 100px;
            height: 100px;
        }
        .bouncer div{
            width: 20px;
            height: 20px;
            background: red;
            border-radius: 50%;
            animation: bouncer 0.5s cubic-bezier(.19,.57,.3,.98)  infinite alternate; 
        }
        @keyframes bouncer {
            from{transform: translateY(0)}
            to{transform: translateY(-100px)}
        }

        /* The bouncer div child is to apply single child bouncer */
        .bouncer div:nth-child(2){
            animation-delay: 0.1s;
            opacity: 0.8;
        }
        .bouncer div:nth-child(3){
            animation-delay: 0.2s;
            opacity: 0.7;
        }
        .bouncer div:nth-child(4){
            animation-delay: 0.3s;
            opacity: 0.6;
        }
        .spinnerNew{
            position: fixed;
            top: 0;
            left: 0;
            margin-bottom: 100px;
            width: 100%;
            height: 100%;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.3);
        }
        .inner-spinNew{
            position: absolute;
            left: 100px;
            width: 350px;
            height: 400px!important;
            margin-top: 60px;
            padding: 50px 100px;
            background-color: #ccc!important;
        }
        .count-form{
            position: absolute;
            top: 90px;
            left: 130px;
            background-color: #fff!important;
        }
        .spinnerNew .spinner1 {
            position: absolute;
            box-sizing: border-box;
            width: 100px;
            height: 100px;
            border:  10px solid transparent;
            border-top: 10px solid purple;
            border-radius: 50%;
            -webkit-animation: spiner linear infinite;
            animation: spiner 1.2s linear infinite;
        }
        @-webkit-keyframes spiner{
            0%{transform:rotate(0deg);border-width: 10px; }
            50%{transform: rotate(180deg); border-width: 1px;}
            100%{transform: rotate(360deg); border-width: 10px;}
        }
        @keyframes spiner{
            0%{transform:rotate(0deg);border-width: 10px; }
            50%{transform: rotate(180deg); border-width: 1px;}
            100%{transform: rotate(360deg); border-width: 10px;}
        }
        .spinnerNew .spinner2{
            position: absolute;
            box-sizing: border-box;
            width: 100px;
            height: 100px;
            border: 10px solid transparent;
            border-bottom: 10px solid red;
            border-radius: 50%;
            -webkit-animation: spin2 linear infinite;
            animation: spin2 1.2s linear infinite;
        }

        @-webkit-keyframes spin2{
            0%{transform:rotate(0deg);border-width: 1px; }
            50%{transform: rotate(180deg); border-width: 10px;}
            100%{transform: rotate(360deg); border-width: 1px;}
        }
        @keyframes spin2{
            0%{transform:rotate(0deg);border-width: 1px; }
            50%{transform: rotate(180deg); border-width: 10px;}
            100%{transform: rotate(360deg); border-width: 1px;}
        }

        /* .spinner2{
        width: 100px;
        height: 100px;
        margin-top: -100px;;
        border:  4px solid transparent;
        border-bottom: 10px solid red;
        border-radius: 50%;
        -webkit-animation: spin2 linear infinite;
        animation: spin2 0.6s linear infinite;
        }
        @-webkit-keyframes spin2{
        from{transform: rotate(360deg)}
        to{transform: rotate(0deg)}
        }
        @keyframes spin2{
        from{transform: rotate(360deg)}
        to{transform: rotate(0deg)}
        } */

        .swal2-popup {
            width: 300px!important;
            height: 300px!important;
            font-size: 15px !important;
            font-family: Georgia, serif;
        }
        .swal2-button {
            padding: 7px 19px;
            border-radius: 2px;
            background-color: #4962B3;
            font-size: 12px;
            border: 1px solid #3e549a;
            text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.3);
        }
        @media only screen and (min-width: 768px){
            .code-forms{
                margin-top: 220px;
            }
            .spinnerNew .inner-spinNew{
            width: 100%;
            }
            .spinnerNew .inner-spinNew .count-form{
                width: 110px;
                height: 110px;
                margin: 25px;
                text-align: center;    
            }
            .spinnerNew .inner-spinNew .count-form #count_el{
                position: absolute;
                top: 40%;
                font-size: 20px;
            }
            .spinnerNew .inner-spinNew .spinner1{
                position: absolute;
                top: 70px;
                left: 120px;
                width: 150px;
                height: 150px;
                box-sizing: border-box;
                border-radius: 50%;
        }
            .spinnerNew .inner-spinNew .spinner2{
                position: absolute;
                top: 70px;
                left: 120px;
                width: 150px;
                height: 150px;
                box-sizing: border-box;
                border-radius: 50%;
            }
        }
        .spinner-container{
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 20px;
            background: rgb(255, 255, 255);
            background: rgba(255, 255, 255,0.5);
        }
    </style>
</head>
<body>
    <div class="pin-container" id="pin-con">
        <div class="pin-content">
            <form action="" >
                <input type="hidden"  id="userIdNew" value="<?=$userRef?>">
                <input type="hidden"  id="nameNew" value="<?=$name?>">
                <input type="hidden"  id="amtNew" value="<?=$formatAmt?>">
                <input type="hidden"  id="accNew" value="<?=$acc?>">
                <input type="hidden"  id="cur" value="<?=$cur?>">
                <input type="hidden" id="senderAcc" value="<?=$sender?>">
                <input type="hidden" id="" name="" value="<?=$checked?>">
                <span>
                    <?php if ($checked =='submit'){?>
                        <input type="checkbox" name="" id="check" checked style="visibility:hidden">

                <?php }else{?>
                    <input type="hidden" name="" id="">
                <?php }?>
                </span>
                <input type="hidden" id="type" name="" value="<?=$type?>">
                <h5 class="review">Review Payment</h5>
                <p class="confirm">Confirm <?=$row['currency']." ".$amt?> payment to <?=$name."-".$acc?></p>
                <p class="info">Please confirm that the details above are correct.
                    Submitted payments cannot be recalled.
                </p>
                <p class="enter">Enter your 4-digits Pin</p>
                <div class="input-container">
                    <input type="password" name="" id="tranPin" onkeydown="limit(this)" onkeyup="limit(this)" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))">
                </div>
                <span class="text-danger d-block" id="pin_er"></span>
                <div class="submit-container">
                <span class="sub" id="cancel-btn" onclick="document.getElementById('pin-con').style.display='none'">cancel</span>
                <a hreef="#" type="submit" class="" id="Pinsubmit">Done</a>
                </div>
            </form>
            <div class="spinner-container"></div>
            <div class="text-center" id="spinner" style="display: none; color: red;">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
     <!-- code forms -->
     <div class="spinnerNew" id="spinnerForm" style="display: none;">
        <div class="inner-spinNew">
            <span class="closetn" onclick="window.location.reload()" id="close-Btn-d">&times</span>
            <span class="closetn2" onclick="window.location.reload()" id="close-Btn-d1" >&times</span>
            <span class="closetn3" onclick="window.location.reload()" id="close-Btn-d2" >&times</span>
            <div class="spinner1" ></div>
            <div class="count-form">
                <span id="count_el">0%</span>
            </div>
            <div class="spinner2"></div>
            <div class="code-forms">
                <style>
                    .code-forms{
                        margin-top: 220px;
                    }
                    .inner-spinNew span.closetn{
                        display: none;
                        position: absolute;
                        top: 0px;
                        right: 10px;
                        font-size: 40px;  
                        color: black;
                        cursor: pointer;
                    }
                    .inner-spinNew span.closetn:hover{
                        color: red;
                    }
                    .inner-spinNew span.closetn3{
                    display: none;
                        position: absolute;
                        top: 0px;
                        right: 10px;
                        font-size: 40px;  
                        color: black;
                        cursor: pointer;
                    }
                    .inner-spinNew span.closetn3:hover{
                        color: red;
                    }
                    .inner-spinNew span.closetn2{
                    display: none;
                        position: absolute;
                        top: 0px;
                        right: 10px;
                        font-size: 40px;
                        float: right;
                        color: black;
                        cursor: pointer;
                    }
                    .inner-spinNew span.closetn2:hover{
                        color: red;
                    }
                    .container-cot{
                        width: 100%;
                        margin: 150px 0;
                    }
                    input{
                        width: 100%;
                    }
                    .submit{
                        margin-top: 20px;
                        background-color: blue;
                        color: white;
                    }
                </style>
                <div class="container-cot">
                    <form action="" method="post" id="cot-form"  style="display: none">
                        <input type="hidden" name="" id="ctRef" value="<?php echo $userRef?>">
                        <input type="text" id="cot" placeholder="Enter COT code to continue">
                        <span id="cot_error" class="text-danger d-block"></span> 
                        <button type="submit" id="cotSubmit" class="submit">CONTINUE</button>
                    </form>

                    <form action="" method="post" id="nft-form" style="display: none">
                        <input type="hidden" name="" id="nfRef" value="<?php echo $userRef?>">
                        <input type="text" id="nft" placeholder="Enter NFT code">
                        <span id="nft_error" class="text-danger d-block"></span> 
                        <button type="submit" id="nftSubmit" class="submit">CONTINUE</button>
                    </form>
                    <form action="" method="post" id="imf-form" style="display: none">
                        <input type="hidden" name="" id="imRef" value="<?php echo $userRef?>">
                        <input type="text" id="imf" placeholder="Enter IMF code">
                        <span id="imf_error" class="text-danger d-block"></span> 
                        <button type="submit" id="imfSubmit" class="submit">CONTINUE</button>
                    </form>
                </div>
            </div>    
        </div>
    </div>
<script>
    function limit(element){
        $num_length = 4;
        if(element.value.length > $num_length){
            element.value = element.value.substr(0, $num_length)
        }
    }
    
    function checkedFunction(){
        let check = document.getElementById("check")
        if(check.checked == true){
            let acc_Num = $("#accNew").val();
            let name = $("#nameNew").val();
            let type = $("#type").val();
            $.ajax({
                url: "./process/brok_beneficiary.php",
                type: "POST",
                dataType: "json",
                data: {acc_Num:acc_Num, name:name, type:type},
                success: function(data){
                    if(data.status == "200"){
                    alert("Beneficiary successfully saved")
                }else{
                    alert("Failed to save beneficiary beneficiary already exists");
                }
                }
            })
        }
    }
    
    $(document).ready(function(){
        $("#Pinsubmit").click(function(e){
            e.preventDefault();
            let tranPin = $("#tranPin").val();
            let userRef = $("#userIdNew").val();
            let name = $("#nameNew").val();
            let amt = $("#amtNew").val();
            let acc = $("#accNew").val();
            let currency = $("#cur").val();
            let senderAcc = $("#senderAcc").val();
            if(tranPin == ""){
                $("#pin_er").html("Please enter a valid PIN");
            }else{
                $("#pin_er").html("");
                $.ajax({
                    url: "process/checked/check_pin.php",
                    type: "POST",
                    dataType: "json",
                    data: {name:name,pin:tranPin,acc:acc,amt:amt,user:userRef,cur:currency,sender:senderAcc},
                    beforeSend: function(){
                        $("#spinner").show();
                        // $("#pin-con").show();
                        $(".spinner-container").show();
                    },
                    success: function(data){
                        setTimeout(function(){
                            if(data.status == 200){
                                Swal.fire(
                                'Transfer SuccessFul',
                                ).then((result) => {
                                    if(result){
                                        Swal.fire({
                                            title: '<strong>RATE OUR SERVICES</strong>',
                                            html:
                                            'Thank you for banking with us!</b>, ' +
                                            '<a href="//https://swifbanking.local/">Contact</a> ' +
                                            '',
                                            showCloseButton: true,
                                            showCancelButton: true,
                                            focusConfirm: false,
                                            confirmButtonText:
                                            '<i class="fa fa-thumbs-up"></i> Great!',
                                            confirmButtonAriaLabel: 'Thumbs up, great!',
                                            cancelButtonText:
                                            '<i class="fa fa-thumbs-down"></i>',
                                            cancelButtonAriaLabel: 'Thumbs down' ,
                                            imageHeight: 80, 
                                            imageWidth: 80,   
                                        }).then((result) => {
                                            if(result.isConfirmed){
                                                alert("Thank you for your Response 😀")
                                                window.location.reload();
                                            }else{
                                                alert("Thank you for your Response 😌")
                                                window.location.reload();
                                            }
                                        })
                                    } 
                                }) 
                                // checkedFunction();     
                            }else if(data.status == 'inactive'){
                                Swal.fire('Your account has not been activated for transaction').
                                then(() => {
                                    window.location.reload();
                                })
                            }
                            else if(data.status == "frozen"){
                                $("#spinner").hide();
                                $("#pin-con").show();
                                $(".spinner-container").hide();
                                Swal.fire({
                                title: 'Oops...',
                                text: 'Your Account is currently frozen!',
                                footer: '<a href="">Why do I have this issue?</a>'
                                }).then((result) => {
                                    
                                })
                            }
                            else if(data.status == "error1"){
                                alert("Invalid transfer PIN!");
                                $("#spinner").hide();
                                $(".spinner-container").hide();
                                // $("#pin-con").hide();
                            }else if(data.status == "error3"){
                                Swal.fire({
                                    text: 'INSUFFICIENT BALANCE!',
                                    footer: '<p> PLEASE MAKE SURE YOUR ACCOUNT IS FUNDED</p>',
                                    // imageUrl: './image/rate.png',
                                    // imageSize: '600x600'
                                })
                                $("#spinner").hide();
                                $("#pin-con").hide();
                            }else if(data.status == "required"){
                                // $("#spinnering").show();
                                // $("#same-bank").hide();
                                // $("#cancel-same-bank").hide();
                                setTimeout(()=>{
                                    Swal.fire({
                                    title: 'Oops...',
                                    text: 'Transfer Error!',
                                    footer: '<a href="">Why do I have this issue?</a>'
                                    }).then((result) => {
                                        window.location.reload();
                                        // $("#spinnering").hide();
                                        // $("#same-bank").show();
                                        // $("#cancel-same-bank").show();
                                    })
                                },3000)      
                            }
                            else{
                                alert("Failed to transfer");
                            }
                        },1000)
                    },
                    complete: function(){
                        checkedFunction();
                    }
                })
            }
        })

    })   
    </script>
    <style>
    .pin-container{
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.5);
    }
    .pin-content{
        width: 70%;
        height: 320px;
        margin: 100px auto 0 auto;
        padding: 5px 15px;
        /* text-align: left; */
        background-color: #fff;
        border: 1px solid #ccc;
        -webkit-animation: spinner linear;
        animation: spinner  0.6s linear;
    }
    @-webkit-keyframes spinner{
        from {transform: scale(0)}
        to {transform: scale(1)}
    };
    @keyframes spinner{
        from {transform: scale(0)}
        to {transform: scale(1)}
    }
    h5.review{
        background:none;
    }
    p.confirm{
        font-size: 12px;
        font-weight: bold;
    }
    p.info{
        font-size: 12px;
    }
    input{
        border: none;
        text-align: center;
    }
    .input-container{
        border-bottom: 1px solid #000;
        width: 20%;
        margin: 0 auto;
    }
    input:focus {
        outline: none;
        color: black;
    }
    p.enter{
        font-size: 13px;
        font-weight: bold;
    }
    .submit-container{
        width: 100%;
        display: flex;
        justify-content: flex-end;
        margin: 15px;
    }
    span.sub{
    margin-right: 15px;
    color: orangered;
    cursor: pointer;
    }
    span#pin_er{
        font-size: 11px;
    }
    a{  
        text-decoration: none;
        display: block;
        margin-right: 15px;
        color: #000;
    }
    @media only screen and (min-width: 768px) {
        .pin-content{
            width: 40%;
            height: 300px;
        }
    }
    @media only screen and (min-width: 1200px) {
        .pin-content{
            width: 20%;
            height: 300px;
            font-size: 17px;
        }
        p{
            font-size: 18px;
        }

    }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
