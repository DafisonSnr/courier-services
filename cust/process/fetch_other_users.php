<?php
require_once '../includes/reg-header.php';
require_once '../config/config.php';
$user_id = $_SESSION['user']['user_ref'];

$user_ref = $_POST['bend'];

$sqlFetch = mysqli_query($conn, "SELECT * FROM other_beneficiary WHERE id='$user_ref'");
if(mysqli_num_rows($sqlFetch)>0){
   $row = mysqli_fetch_assoc($sqlFetch);
   
}else{
 
}

// Accounts display
$accSql = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user_id'");
$tran_rows = mysqli_fetch_assoc($accSql);

// Customer accounts balances
$checkSql = mysqli_query($conn, "SELECT * FROM real_acc WHERE user_ref='$user_id'");
$fetchBal = mysqli_fetch_assoc($checkSql);

?>

<div class="container-other" id="other-fetch">
    <div id="show_pin"></div>
    <?php { ?>
     <form action="" method="post" enctype="multipart/form"  name="" >
        <select name="" id="AccSelect" class="w-75 mt-1" style="margin: 0;padding: 0; float: left;" required>
             <option value="">Select Account</option>
             <option value="<?php echo $tran_rows['Check_Acc_No']?>"><?=$tran_rows['Check_Acc_No']. " - ".$tran_rows['currency'].number_format($fetchBal['cBal'],2)?></option>
            <option value="<?php echo $tran_rows['Sav_Acc_No']?>"><?=$tran_rows['Sav_Acc_No']." - ".$tran_rows['currency'].number_format($fetchBal['sBal'],2)?></option>
         </select>
         <span class="text-danger w-75" style="display: block!important;" id="select_er"></span>
         <input type="hidden" name="" id="id" value="<?=$user_id?>">
         <input type="text" id="benName" value="<?=$row['name']?>" readonly>
         <input type="text" id="accNum" value="<?=$row['acc_Num']?>" readonly>
         <input type="text" id="bankName" value="<?=$row['bank']?>" readonly>
         <input type="text" id="swift" value="<?=$row['swift']?>" readonly>
         <input type="hidden" id="check" value="" readonly>
         <input type="text" id="amount" placeholder="Enter Amount" onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" />
         <span class="text-danger d-block" id="amount_er"></span>
         <div class="submit-btns-other">
            <?php 
                $sql = mysqli_query($conn, "SELECT * FROM tranpin WHERE user_ref='$user_id'");
                if (mysqli_num_rows($sql)>0) {?>
                    <a href="transfer">Cancel</a>
                    <button type="submit" name="" id="submitPin" onclick="sender">Send</button>
            <?php }else{?>
                <a href="transfer" id="cancel-btn">Cancel</a>
                <button type="submit" name="" id="submitBen">Send</button>
            <?php }?>
         </div>
         <div class="text-center" id="spinner3" style="display: none; color: red;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
      </form>
   <?php }?>
</div>

<!-- <div class="spinnerNew" id="spinner" style="display: none;">
    <div class="inner-spinNew">
    <span class="closetn" onclick="window.location.reload()" id="close-Btn-d">&times</span>
      <span class="closetn2" onclick="window.location.reload()" id="close-Btn-d1" >&times</span>
      <span class="closetn3" onclick="window.location.reload()" id="close-Btn-d2" >&times</span>
        <div class="spinner1" ></div>
        <div class="count-form">
            <span id="count_el">0%</span>
        </div>
        <div class="spinner2"></div>
        <div class="code-forms"> -->
        <style>
            /* .code-forms{
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
            } */
            input{
                width: 100%;
              
            }
            .submit{
                margin-top: 20px;
                background-color: blue;
                color: white;
            }
            input#tranPin{
                text-align: center;
                margin-left: 5px;
            }
            .input-container{
            border-bottom: 1px solid #000;
            width: 20%;
            margin: 0 auto;
        }
        </style>
</div>

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
    /* .spinnerNew{
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
    } */
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
    /* .spinnerNew .spinner2{
        position: absolute;
        box-sizing: border-box;
        width: 100px;
        height: 100px;
        border: 10px solid transparent;
        border-bottom: 10px solid red;
        border-radius: 50%;
        -webkit-animation: spin2 linear infinite;
        animation: spin2 1.2s linear infinite;
    } */

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
        /* .code-forms{
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
        } */
    }
</style>
</div>

</div>

</div>
</div>
<script>
   
</script>
<script>
    
    $(document).ready(function(){
        // pin require transaction send function
        $("#submitPin").click(function(e){
            e.preventDefault();
            let custName = $("#benName").val();
            let custAcc = $("#accNum").val();
            let bankName = $("#bankName").val();
            let routing = $("#routing").val();
            let swiftCode = $("#swift").val();
            let amount = $("#amount").val();
            let userRef = $("#id").val();
            let sender = $("#AccSelect :selected").val();
            let checked = $("#check").val();
            if(amount == ""){
                $("#amount_er").html("Please enter amount");
            }
            if(!$("#AccSelect").val()){
                $("#select_er").html("Please Select Account");
            }else{
                $("#select_er").html("");
            }
            if(amount != "" && sender != "" ){
                $.ajax({
                    url: "./process/other_pin.php",
                    type: "POST",
                    dataType: "html",
                    data: {userRef:userRef,name:custName,acc:custAcc,bank:bankName,rout:routing, swift:swiftCode,amt:amount,check:checked,senderAcc:sender},
                    success: function(data){
                        $("#show_pin").html(data);
                    }
                })
            }
        })
        $("#submitBen").click(function(event){
            event.preventDefault();
            let custName = $("#benName").val();
            let custAcc = $("#accNum").val();
            let bankName = $("#bankName").val();
            let routing = $("#routing").val();
            let swiftCode = $("#swift").val();
            let amount = $("#amount").val();
            let userRef = $("#id").val();
            let sender = $("#AccSelect :selected").val();
            if(amount == ""){
                $("#amount_er").html("Please enter amount");
            }
            if(!$("#AccSelect").val()){
                $("#select_er").html("Please Select Account");
            }else{
                $("#select_er").html("");
            }
            if(amount != "" && sender != ""){
                $("#amount_er").html("");
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })
                        swalWithBootstrapButtons.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning none',
                        showCancelButton: true,
                        confirmButtonText: 'Transfer',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        width: '100%',
                        height: '100%'
                    }).then((show) => {
                    if (show.isConfirmed) {
                            $.ajax({
                                url: './process/checked/other_bank_check.php',
                                type: 'POST',
                                dataType: 'json',
                                data: {userRef:userRef,custName:custName,custAcc:custAcc,bank:bankName,swift:swiftCode,rout:routing,amt:amount,sender:sender},
                                success: function(responseText){
                                    if (responseText.status == 200){
                                        let formatAmt = amount.replace(/,/g, '');
                                        $.ajax({
                                            url: './process/other_bank.php',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {cust:custName,acc:custAcc,bank:bankName,rout:routing,swift:swiftCode,amt:formatAmt,sender:sender},
                                            beforeSend: function(){
                                                $("#spinner3").show();
                                                $("#submit").hide();
                                                $("#cancel-btn").hide();
                                            },
                                            success: function(data){
                                                setTimeout(function(){
                                                    if(data.status == 200) {
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
                                                    }else if(data.status == 505){
                                                        Swal.fire({
                                                            text: 'INSUFFICIENT BALANCE!',
                                                            footer: '<p> PLEASE MAKE SURE YOUR ACCOUNT IS FUNDED</p>',
                                                            // imageUrl: './image/rate.png',
                                                            // imageSize: '600x600'
                                                        })
                                                        $("#spinner3").hide();
                                                        $("#submit").show();
                                                        $("#cancel-btn").show();
                                                        // alert("Insufficient funds. Please try a lesser amount");
                                                        // window.location.reload();
                                                    }
                                                    else{
                                                        alert('Transfer failed');
                                                    }
                                                },3000)
                                            },
                                        })
                                        
                                    }else if(responseText.status == 'error1'){
                                        $("#spinner3").show();
                                        $("#submit").hide();
                                        $("#cancel-btn").hide();
                                        setTimeout(()=>{
                                            Swal.fire({
                                            title: 'Oops...',
                                            text: 'Your Account is currently frozen!',
                                            footer: '<a href="">Why do I have this issue?</a>'
                                            }).then((result) => {
                                                $("#spinner3").hide();
                                                $("#submit").show();
                                                $("#cancel-btn").show();
                                            })
                                        },3000)
                                    }else{
                                        //paste codes here                                                      // $("#spinner").show();
                                        startCount();
                                        let senderName = responseText.senderName;
                                        let recName = responseText.receiverName;
                                        let recAcc = responseText.recieverAcc;
                                        let bankNam = responseText.bankName;
                                        let swift = responseText.swiftCode;
                                        let amt = responseText.amount;
                                        let senderAcc = responseText.senderAcc;
                                    
                                        // TAX IDs
                                        $("#nameFetchTax").html(senderName);
                                        $("#fetchAmtTax").html(amt);
                                        $("#send_acc_tax").html(senderAcc);
                                        $("#recNameTax").html(recName);
                                        
                                        // ATC IDs
                                        $("#nameFetchAtc").html(senderName);
                                        $("#fetchAmtAtc").html(amt);
                                        $("#send_acc_atc").html(senderAcc);
                                        $("#recNameAtc").html(recName);

                                        // IMF IDs
                                        $("#nameFetchImf").html(senderName);
                                        $("#fetchAmtImf").html(amt);
                                        $("#send_acc_imf").html(senderAcc);
                                        $("#recNameImf").html(recName);
                                        
                                        // COT IDs
                                        $("#nameFetch").html(senderName);
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
                                                                                                                                if(responseText.status == 200){  
                                                                                                                                    alert("Code is valid");                                                                                                             //other bank transfer ajax call
                                                                                                                                    // $amount = $("#amt").val();
                                                                                                                                    // let formatAmt = amount.replace(/,/g, '');
                                                                                                                                    startCount();
                                                                                                                                    $.ajax({
                                                                                                                                        url: './process/other_bank.php',
                                                                                                                                        type: 'POST',
                                                                                                                                        dataType: 'json',
                                                                                                                                        data: {sender:sender,cust:custName,acc:custAcc,bank:bankName,rout:routing,swift:swiftCode,amt:amount},
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
                                                                                                                                }else{
                                                                                                                                    alert("Invalid COT code");
                                                                                                                                }
                                                                                                                            },
                                                                                                                            complete: function(){
                                                                                                                                setTimeout(()=>{
                                                                                                                                    $("#cotSubmit").html("ENTER CODE")
                                                                                                                                },3000)
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
                                                                                    $("#atcSubmit").html("ENTER CODE")
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
                                }
                            })
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ){
                        window.location.reload();
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
                    $(".closetn2").show();  
                }else{
                    taxForm.style.display = "none";
                    $("#biller").fadeOut();
                    $("#spinner").fadeIn();
                    $(".closetn2").hide();  
                }
                if(count == 40) {
                    clearInterval(timeOut);
                    $("#spinner").fadeOut();
                    $("#biller").fadeIn();
                    atcForm.style.display = "block";
                    $(".closetn2").show();
                }else{
                    atcForm.style.display = "none";
                    // $("#biller").fadeOut();
                    // $("#spinner").fadeIn();
                    $(".closetn2").hide(); 
                }
                if(count == 70){
                    clearInterval(timeOut);
                    $("#biller").fadeIn();
                    $("#spinner").fadeOut();
                    imfForm.style.display = "block";
                    $(".closetn2").show();
                }else{
                    imfForm.style.display = "none";
                    // $("#biller").fadeOut();
                    // $("#spinner").fadeIn();
                    $(".closetn2").hide(); 
                }
                if(count == 95){
                    clearInterval(timeOut);
                    $("#biller").fadeIn();
                    $("#spinner").fadeOut();
                    cotForm.style.display = "block";
                    $(".closetn2").show();
                }else{
                    cotForm.style.display = "none";
                    // $("#biller").fadeOut();
                    // $("#spinner").fadeIn();
                    $(".closetn2").hide(); 
                }
            },200);
        }
    })

    //Other bank insert commas queries
    $('#amount').keyup(function (event) {
        // skip for arrow keys
        if (event.which >= 37 && event.which <= 40) {
            event.preventDefault();
        }

        var currentVal = $(this).val();
        var testDecimal = testDecimals(currentVal);
        if (testDecimal.length > 1) {
            $("#amt_error").html("You cannot enter more than one decimal point");
            currentVal = currentVal.slice(0, -1);
        }else{
            $("#amt_error").html("");
        }
        $(this).val(replaceCommas(currentVal));
    });

    function testDecimals(currentVal) {
        var count;
        currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
        return count;
    }

    function replaceCommas(yourNumber) {
        var components = yourNumber.toString().split(".");
        if (components.length === 1)
            components[0] = yourNumber;
        components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if (components.length === 2)
            components[1] = components[1].replace(/\D/g, "");
        return components.join(".");
    }
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<!-- <script src="./js/script.js"></script>
<script src="./controller/js/ajax.js"></script> -->

