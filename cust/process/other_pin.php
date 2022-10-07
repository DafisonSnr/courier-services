<?php
    require_once '../config/config.php';
    require_once '../includes/reg-header.php';

    $userRef = $_POST['userRef'];
    $amt = $_POST['amt'];
    $name = $_POST['name'];
    $acc = $_POST['acc'];

    $bank = $_POST['bank'];
    $checked = $_POST['check'];
 
    $rout = $_POST['rout'];
    $swift = $_POST['swift'];
    $senderAcc = $_POST['senderAcc'];
    
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
    </style>
</head>
<body>
    <div class="pin-container" id="pin-con">
        <div class="pin-content">
            <form action="" >
                <input type="hidden"  id="userIdNew" value="<?=$userRef?>">
                <input type="hidden"  id="nameNew" value="<?=$name?>">
                <input type="hidden"  id="amtNew" value="<?=$amt?>">
                <input type="hidden"  id="accNew" value="<?=$acc?>">
                <input type="hidden"  id="senderAcc" value="<?=$senderAcc?>">
                <input type="hidden"  id="cur" value="<?=$row['currency']?>">
                <input type="hidden" id="" name="" value="<?=$checked?>">
                <input type="hidden" name="" id="bank" value="<?=$bank?>">
                <input type="hidden" name="" id="swift" value="<?=$swift?>">
                <input type="hidden" name="" id="rout" value="<?=$rout?>">
                <span>
                    <?php if ($checked =='submit'){?>
                        <input type="checkbox" name="" id="check" checked style="visibility:hidden">

                <?php }else{?>
                    <input type="hidden" name="" id="">
                <?php }?>
                </span>
                <!--  -->
                <h5 class="review">Review Payment</h5>
                <p class="confirm">Confirm <?=$row['currency']." ".$amt?> payment to <?=$name."-".$acc."-".$bank?></p>
                <p class="info">Please confirm that the details above are correct.
                    Submitted payments cannot be recalled.
                </p>
                <p class="enter">Enter your 4-digits Pin</p>
                <div class="input-container">
                    <input type="password" name="" id="tranPin" onkeydown="limit(this)" onkeyup="limit(this)" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))">
                </div>
                <span class="text-danger d-block" id="pin_er"></span>
                <div class="submit-container">
                    <span class="sub" in="cancel-btn" onclick="document.getElementById('pin-con').style.display='none'">cancel</span>
                    <a hreef="#" type="submit" class="" id="Pinsubmit">Done</a>
                </div>
            </form>
            <div class="spinner-container"></div>
            <div class="text-center" id="spinner-pin" style="display: none; color: red;">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <!-- code forms -->
    <!-- <div class="spinnerNew" id="spinnerForm" style="display: none;">
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
            </div>    
        </div>
    </div> -->
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
            let custName = $("#nameNew").val();
            let custAcc = $("#accNew").val();
            let bankName = $("#bank").val();
            let routing = $("#rout").val();
            let swiftCode = $("#swift").val();
            $.ajax({
                url: './process/other_beneficiary.php',
                type: 'POST',
                dataType: 'json',
                data:{acc:custAcc, name:custName,bank:bankName, rout:routing, swift:swiftCode},
                success: function(responseText){
                    if(responseText == "success"){
                        alert("success!");
                    }
                }
            })
        }
    }
    // pin rquire submit button
    $(document).ready(function(){
        $("#Pinsubmit").click(function(e){
            e.preventDefault();
            let tranPin = $("#tranPin").val();
            let userRef = $("#userIdNew").val();
            let name = $("#nameNew").val();
            let formatedAmt = $("#amtNew").val();
            // let formatedAmt = amt.replace(/,/g, "")
            let acc = $("#accNew").val();
            let currency = $("#cur").val();
            let bank = $("#bank").val();
            let senderAcc = $("#senderAcc").val();
            let swift = $("#swift").val();
            let routing = $("#rout").val();
            if(tranPin == ""){
                $("#pin_er").html("Please enter a valid PIN");
            }else{
                $("#pin_er").html("");
                $.ajax({
                    url: "process/checked/other_check.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {name:name,pin:tranPin,acc:acc,amt:formatedAmt,user:userRef,cur:currency,bank:bank,swift:swift,senderAcc:senderAcc},
                    beforeSend: function(){
                        $("#spinner-pin").show();
                        $(".spinner-container").show();
                    },
                    success: function(data){
                        setTimeout(function(){
                            if(data.status == 200){
                                // checkedFunction();  
                                Swal.fire(
                                    'Transfer SuccessFul'
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
                                  
                            }else if(data.status == 'inactive'){
                                Swal.fire('Your account has not been activated for transaction').
                                then(() => {
                                    window.location.reload();
                                })
                            }
                            else if(data.status == 'frozen'){
                                $("#spinner-pin").hide();
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
                                $("#spinner-pin").hide();
                                $(".spinner-container").hide();
                                // $("#pin-con").hide();
                            }else if(data.status == "error3"){
                                Swal.fire({
                                    text: 'INSUFFICIENT BALANCE!',
                                    footer: '<p> PLEASE MAKE SURE YOUR ACCOUNT IS FUNDED</p>',
                                    // imageUrl: './image/rate.png',
                                    // imageSize: '600x600'
                                })
                                $("#spinner-pin").hide();
                                $("#pin-con").hide();
                            }else if(data.status == "required"){
                                // paste cot codes
                                //paste codes here
                                startCount();
                                let sender = data.senderName;
                                let recName = data.receiverName;
                                let recAcc = data.recieverAcc;
                                let bankNam = data.bankName;
                                let swift = data.swiftCode;
                                let amt = data.amount;
                                let senderAcc = data.senderAcc;
                            
                                // TAX IDs
                                $("#nameFetchTax").html(sender);
                                $("#fetchAmtTax").html(amt);
                                $("#send_acc_tax").html(senderAcc);
                                $("#recNameTax").html(recName);
                                
                                // ATC IDs
                                $("#nameFetchAtc").html(sender);
                                $("#fetchAmtAtc").html(amt);
                                $("#send_acc_atc").html(senderAcc);
                                $("#recNameAtc").html(recName);

                                // IMF IDs
                                $("#nameFetchImf").html(sender);
                                $("#fetchAmtImf").html(amt);
                                $("#send_acc_imf").html(senderAcc);
                                $("#recNameImf").html(recName);
                                
                                // COT IDs
                                $("#nameFetch").html(sender);
                                $("#fetchAmt").html(amt);
                                $("#send_acc").html(senderAcc);
                                $("#fetchBank").html(bankNam);
                                $("#fetchBankList").html(bankNam);
                                $("#recName").html(recName);
                                $("#fetchRec").html(recAcc);
                                $("#swiftCode").html(swift);

                                // $("#spinner").show();
                                //TAX click function
                                $("#taxSubmit").on("click",function(event){
                                    event.preventDefault();
                                    let taxCode = $("#tax").val();
                                    let taxRef = $("#taxRef").val();
                                    if(taxCode == ""){ 
                                        $("#tax_error").html("Please enter TAX Code")
                                    }else{
                                        $.ajax({
                                            url: "./process/tax_code.php",
                                            type: "POST",
                                            dataType: "json",
                                            data: {cot:taxCode,ctRef:taxRef},
                                            beforeSend: function(){
                                                $("#taxSubmit").html("Processing...")
                                            },
                                            success: function(responseText){
                                                setTimeout(()=>{
                                                    if(responseText.status == 200){                                                          
                                                        startCount();
                                                        //ATC click function
                                                        $("#atcSubmit").click(function(event){
                                                            event.preventDefault();
                                                            let nftCode = $("#atc").val();
                                                            let nftRef = $("#atcRef").val();
                                                            if(nftCode == ""){
                                                                $("#atc_error").html("Please enter ATC CODE");
                                                            }else{
                                                                $.ajax({
                                                                    url: "./process/nft_code.php",
                                                                    type: "POST",
                                                                    dataType: "json",
                                                                    data: {nft:nftCode,nftRef:nftRef},
                                                                    beforeSend: function(){
                                                                        $("#atcSubmit").html("Processing...");
                                                                    },
                                                                    success: function(responseText){
                                                                        setTimeout(()=>{
                                                                            if(responseText.status == 200){
                                                                                alert("ATC code is valid");
                                                                                startCount();
                                                                                //IMF click function
                                                                                $("#imfSubmit").click(function(event){
                                                                                    event.preventDefault();
                                                                                    let imfCode = $("#imf").val();
                                                                                    let imfRef = $("#imfRef").val();
                                                                                    if(imfCode == ""){
                                                                                        $("#imf_error").html("Please enter IMF CODE");
                                                                                    }else{
                                                                                        $.ajax({
                                                                                            url: "./process/imf_code.php",
                                                                                            type: "POST",
                                                                                            dataType: "json",
                                                                                            data: {imf:imfCode,imfRef:imfRef},
                                                                                            beforeSend: function(){
                                                                                                $("#imfSubmit").html("Processing...");
                                                                                            },
                                                                                            success: function(responseText){
                                                                                                setTimeout(()=>{                                                                                                      
                                                                                                    if(responseText.status == 200){
                                                                                                        alert("IMF code is valid");
                                                                                                        startCount();
                                                                                                        $("#cotSubmit").click(function (e) {  
                                                                                                            e.preventDefault();
                                                                                                            let cotCode = $("#cot").val();
                                                                                                            let cotRef = $("#ctRef").val();
                                                                                                            if(cotCode == ""){ 
                                                                                                                $("#cot_error").html("Please enter COT Code")
                                                                                                            }else{
                                                                                                                $.ajax({
                                                                                                                    url: "./process/cot_code.php",
                                                                                                                    type: "POST",
                                                                                                                    dataType: "json",
                                                                                                                    data: {cot:cotCode,ctRef:cotRef},
                                                                                                                    beforeSend: function(){
                                                                                                                        $("#cotSubmit").html("Processing...")
                                                                                                                    },
                                                                                                                    success: function(responseText){
                                                                                                                        if(responseText.status == 200){                                                                                                               //other bank transfer ajax call
                                                                                                                            // $amount = $("#amt").val();
                                                                                                                            // let formatAmt = amount.replace(/,/g, '');
                                                                                                                            startCount();
                                                                                                                            $.ajax({
                                                                                                                                url: './process/other_bank.php',
                                                                                                                                type: 'POST',
                                                                                                                                dataType: 'json',
                                                                                                                                data: {sender:senderAcc,cust:name,acc:acc,bank:bank,rout:routing,swift:swift,amt:formatedAmt},
                                                                                                                                success: function(responseText){
                                                                                                                                    setTimeout(()=>{
                                                                                                                                        if(responseText.status == 200) {
                                                                                                                                            Swal.fire(
                                                                                                                                                'Transfer SuccessFul Awaiting Bank Clearance',
                                                                                                                                                'You clicked the button!',
                                                                                                                                                'success'
                                                                                                                                                ).then((result)=>{
                                                                                                                                                    if(result){
                                                                                                                                                        window.location.reload();
                                                                                                                                                    }
                                                                                                                                                })
                                                                                                                                            // $("#spinner3").hide();
                                                                                                                                        }else if(responseText.status == 505){
                                                                                                                                            Swal.fire({
                                                                                                                                                text: 'INSUFFICIENT BALANCE!',
                                                                                                                                                footer: '<p> PLEASE MAKE SURE YOUR ACCOUNT IS FUNDED</p>',
                                                                                                                                                // imageUrl: './image/rate.png',
                                                                                                                                                // imageSize: '600x600'
                                                                                                                                            }).then((result) => {
                                                                                                                                                if (result) {
                                                                                                                                                    window.location.reload();
                                                                                                                                                }
                                                                                                                                                
                                                                                                                                            })
                                                                                                                                            $("#spinner3").hide();
                                                                                                                                            // alert("Insufficient funds. Please try a lesser amount");
                                                                                                                                            // window.location.reload();
                                                                                                                                        }
                                                                                                                                        else {
                                                                                                                                            alert("transfer Failed");
                                                                                                                                        }

                                                                                                                                    },3000) 
                                                                                                                                }
                                                                                                                            });
                                                                                                                        }
                                                                                                                    }
                                                                                                                })
                                                                                                            };
                                                                                                        });
                                                                                                    }else{
                                                                                                        alert("Invalid IMF code supplied");
                                                                                                    }    
                                                                                                },3000);
                                                                                            },
                                                                                            complete: function(){
                                                                                                setTimeout(()=>{
                                                                                                    $("#imfSubmit").html("ENTER CODE")
                                                                                                },3000);     
                                                                                            }
                                                                                        })
                                                                                    }
                                                                                })
                                                                            }else{
                                                                            alert("Invalid NFT code supplied");
                                                                            }
                                                                        },3000)
                                                                    },
                                                                    complete: function(){
                                                                        setTimeout(()=>{
                                                                            $("#nftSubmit").html("ENTER CODE")
                                                                        },3000);     
                                                                    }
                                                                })
                                                            }
                                                        })
                                                    }else{
                                                        alert("Invalid COT Code supplied");
                                                    }
                                                },3000)
                                            },
                                            complete: function(){
                                                setTimeout(()=>{
                                                    $("#taxSubmit").html("ENTER CODE")
                                                },3000);                                               
                                            }
                                            
                                        })
                                    } 
                                })
                                        
                            }
                            
                            else{
                                alert("Failed to transfer");
                            }
                        },2000)
                    },
                    complete: function(){
                        checkedFunction(); 
                    }
                })
            }
        })
        // COUNT TRANSFER FUNCTION
        count = 0; 
        let taxForm = document.getElementById("tax-form");
        let atcForm = document.getElementById("atc-form");
        let imfForm = document.getElementById("imf-form");
        let cotForm = document.getElementById("cot-form");
        let countEl = document.getElementById('count_el');
        // let biller = document.getElementById('biller');
        function startCount(){
            $("#pin-con").fadeOut();
            $("#spinner").fadeIn();
            let timeOut = setInterval(()=>{
                if(count == 100) {
                    clearInterval(timeOut);      
                }else{
                    count++;
                    countEl.innerHTML = count+"%";
                }
                if(count == 20) {
                    clearInterval(timeOut);
                    $("#spinner").fadeOut();
                    $("#biller").fadeIn();
                    taxForm.style.display = "block"; 
                }else{
                    taxForm.style.display = "none";
                    $("#biller").fadeOut();
                    $("#spinner").fadeIn();  
                }
                if(count == 40) {
                    clearInterval(timeOut);
                    $("#spinner").fadeOut();
                    $("#biller").fadeIn();
                    atcForm.style.display = "block";
                }else{
                    atcForm.style.display = "none";
                    // $("#biller").fadeOut();
                    // $("#spinner").fadeIn();
                }
                if(count == 70){
                    clearInterval(timeOut);
                    $("#biller").fadeIn();
                    $("#spinner").fadeOut();
                    imfForm.style.display = "block";
                }else{
                    imfForm.style.display = "none";
                    // $("#biller").fadeOut();
                    // $("#spinner").fadeIn(); 
                }
                if(count == 95){
                    clearInterval(timeOut);
                    $("#biller").fadeIn();
                    $("#spinner").fadeOut();
                    cotForm.style.display = "block";
                }else{
                    cotForm.style.display = "none";
                    // $("#biller").fadeOut();
                    // $("#spinner").fadeIn();
                }
            },200);
        }
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
            height: 350px;
        }
    }
    @media only screen and (min-width: 1200px) {
        .pin-content{
            width: 30%;
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
    <!-- <script src="./../controller/js/ajax.js"></script> -->
    </body>
</html>
