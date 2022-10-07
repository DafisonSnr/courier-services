<?php
require_once '../includes/reg-header.php';
require_once '../config/config.php';
$user_ref = $_POST['bend'];
$sqlFetch = mysqli_query($conn, "SELECT * FROM brook_beneficiary WHERE beneficiary_Ref='$user_ref'");
$row = mysqli_fetch_assoc($sqlFetch);

$user_ref = $_SESSION['user']['user_ref'];
// Accounts display
$accSql = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user_ref'");
$tran_rows = mysqli_fetch_assoc($accSql);

// Customer accounts balances
$checkSql = mysqli_query($conn, "SELECT * FROM real_acc WHERE user_ref='$user_ref'");
$fetchBal = mysqli_fetch_assoc($checkSql);
?>

<div class="container-fetch" id="form-fetch">
    <?php { ?>
     <form action="" method="post" enctype="multipart/form"  name="">
         <select name="" id="AccType" class="w-100 mt-1">
            <option value="">Select Account</option>
            <option value="<?php echo $tran_rows['Check_Acc_No']?>"><?=$tran_rows['Check_Acc_No']. " - ".$tran_rows['currency'].number_format($fetchBal['cBal'],2)?></option>
            <option value="<?php echo $tran_rows['Sav_Acc_No']?>"><?=$tran_rows['Sav_Acc_No']." - ".$tran_rows['currency'].number_format($fetchBal['sBal'],2)?></option>
         </select>
         <span class="d-block text-danger" style="display: block; color: red;" id="select_er"></span>
         <input type="hidden" id="id" value="<?=$user_ref?>" readonly>
         <input type="text" id="BenName" value="<?=$row['name']?>" readonly>
         <input type="text" id="accNum" value="<?=$row['acc_Num']?>" readonly>
         <input type="text" id="type" value="<?=$row['acc_Type']?>" readonly>
         <input type="hidden" id="cur" value="" readonly>
         <input type="hidden" id="check" value="" readonly>
         <input type="text" name="" id="amt" placeholder="Enter Amount">
         <span id="amount_er" class="text-danger d-block"></span>
         <span class="text-danger d-block fw-bold" id="amt_er"></span>
         <div class="submit-btns">
             <?php 
                $sql = mysqli_query($conn, "SELECT * FROM tranpin WHERE user_ref='$user_ref'");
                if (mysqli_num_rows($sql)>0) {?>
                    <a href="transfer" id="cancel-btn-pin">Cancel</a>
                    <button type="submit" name="" id="submitPin" onclick="sender">Send</button>
                <?php }else{?>
                    <a href="transfer" id="cancel-btn">Cancel</a>
                    <button type="submit" name="" id="submit" onclick="sender">Send</button>
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
<!-- let showCloseBtn = document.getElementById("close-Btn-display")
   showCloseBtn.style.display = "block"; -->
   <div id="show_pin"></div>
<div class="spinnerNew" id="spinner" style="display: none;">
    
    <div class="inner-spinNew" >
        <span class="closetn" onclick="window.location.reload()" id="close-Btn-d">&times</span>
        <span class="closetn2" onclick="window.location.reload()" id="close-Btn-d1" >&times</span>
        <span class="closetn3" onclick="window.location.reload()" id="close-Btn-d2" >&times</span>
        <div class="spinner1" ></div>
        <div class="count-form">
            <span id="count_el">0%</span>
        </div>
        <div class="spinner2"></div>
        <div class="code-forms" id="inner-spinNewId">
            <style>
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
                    <input type="text" id="cot" placeholder="Enter COT code to continue">
                    <span id="cot_error" class="text-danger d-block"></span> 
                    <button type="submit" id="cotSubmit" class="submit">CONTINUE</button>
                </form>

                <form action="" method="post" id="nft-form" style="display: none">
                    <input type="text" id="nft" placeholder="Enter NFT code">
                    <span id="nft_error" class="text-danger d-block"></span> 
                    <button type="submit" id="nftSubmit" class="submit">CONTINUE</button>
                </form>
                <form action="" method="post" id="imf-form" style="display: none">
                    <input type="text" id="imf" placeholder="Enter IMF code">
                    <span id="imf_error" class="text-danger d-block"></span> 
                    <button type="submit" id="imfSubmit" class="submit">CONTINUE</button>
                </form>
            </div>
        </div>    
    </div>
</div>



<style>
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
   width: 100%!important;
   height: 600px!important;
   font-size: 15px !important;
   font-family: Georgia, serif;
   }
   .swal2-button {
        display: flex;
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
</style>
<script>
 
    $(document).ready(function(){
        // Transaction Pin Code
        $("#submitPin").click(function(e){
            e.preventDefault();
            let acc_Num = $("#accNum").val();
            let name = $("#BenName").val();
            let amted =  $("#amt").val();
            var formatAmt = amted.replace(/,/g, '');
            let userRef = $("#id").val();
            let type = $("#type").val();
            let cur = $("#cur").val();
            let sender = $("#AccType  :selected").val();
            let checked = $("#check").val();
            if(formatAmt == ""){
                $("#amount_er").html("Please enter amount");
            }
            if(!$("#AccType").val()){
                $("#select_er").html("Please Select Account");
            }else{
                $("#select_er").html("");
            }
            if(formatAmt != "" && sender != ""){
                $.ajax({
                    url: "./process/pin_confirm.php",
                    type: "POST",
                    dataType: "html",
                    data: {userRef:userRef,name:name,fmt:formatAmt,acc:acc_Num,check:checked,cur:cur,type:type,amt:amted,sender:sender},
                    success: function(data){
                        $("#show_pin").html(data);
                    }
                })
            }
        })


        // start here
        $("#submit").on("click",function(e){
            e.preventDefault();
            let acc_Num = $("#accNum").val();
            let name = $("#BenName").val();
            let amted =  $("#amt").val();
            var formatAmt = amted.replace(/,/g, '');
            let userRef = $("#id").val();
            let sender = $("#AccType :selected").val();
            if(formatAmt == ""){
                $("#amount_er").html("Please enter amount");
            }
            if(!$("#AccType").val()){
                $("#select_er").html("Please select Account");
            }else{
                $("#select_er").html("")
            }
            if(formatAmt != "" && sender != ""){
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
                                url: './process/checked/checked.php',
                                type: 'POST',
                                dataType: 'json',
                                data: {userRef:userRef},
                                success: function(responseText){
                                    if (responseText.status == 200){
                                        // let formatAmt = amount.replace(/,/g, '');
                                        $.ajax({
                                            url: './process/brook_cust.php',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {name:name,acc_Num:acc_Num,amt:formatAmt,sender:sender},
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
                                                        'You clicked the button!',
                                                        'success'
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
    })
    // automatical commas for saved Beneficiary amount
    $('#amt').keyup(function (event) {
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="./js/transfer.js"></script> -->