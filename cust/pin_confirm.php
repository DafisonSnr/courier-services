<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="pin-container" id="pin-con">
        <div class="pin-content">
            <form action="" >
                <input type="hidden"  id="#userIdNew" value="">
                <input type="hidden"  id="nameNew" value="">
                <input type="hidden"  id="amtNew" value="">
                <input type="hidden"  id="accNew" value="">
                <input type="hidden"  id="cur" value="">
                <h5 class="review">Review Payment</h5>
                <p class="confirm">Confirm <?$row['currency']?><span id="amtCom"></span> payment to <?$row['currency']. " ".$name."-".$acc?></p>
                <p class="info">Please confirm that the details above are correct.
                    Submitted payments cannot be recalled.
                </p>
                <p class="enter">Enter your 4-digits Pin</p>
                <div class="input-container">
                    <input type="password" name="" id="tranPin" onkeydown="limit(this)" onkeyup="limit(this)" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))">
                </div>
                <span class="text-danger d-block" id="pin_er"></span>
                <div class="submit-container">
                <span class="sub" onclick="document.getElementById('pin-con').style.display='none'">cancel</span>
                <a hreef="#" type="submit" class="" id="Pinsubmit">Done</a>
                </div>
            </form>
            <div class="text-center" id="spinner" style="display: none; color: red;">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <script>
        function limit(element){
            let num_length = 4;
            if(element.value.length > num_length){
                element.value = element.value.substr(0, num_length)
            }
        }
      
            $("#Pinsubmit").click(function(e){
                e.preventDefault();
                let tranPin = $("#tranPin").val();
                let userRef = $("#userIdNew").val();
                let name = $("#nameNew").val();
                let amt = $("#amtNew").val();
                let acc = $("#accNew").val();
                let currency = $("#cur").val();
            if(tranPin == ""){
                $("#pin_er").html("Please enter a valid PIN");
            }else{
                $("#pin_er").html("");
                $.ajax({
                    url: "process/checked/check_pin.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {name:name,pin:tranPin,acc:acc,amt:amt,user:userRef,cur:currency},
                    beforeSend: function(){
                        $("#spinner").show();
                    },
                    success: function(data){
                        setTimeout(function(){
                            if(data.status == "success"){
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
                            }else if(data.status == "error1"){
                                alert("Invalid transfer PIN!");
                            }else if(data.status == "error3"){
                                Swal.fire({
                                    text: 'INSUFFICIENT BALANCE!',
                                    footer: '<p> PLEASE MAKE SURE YOUR ACCOUNT IS FUNDED</p>',
                                    // imageUrl: './image/rate.png',
                                    // imageSize: '600x600'
                                })
                                $("#spinner").hide();
                                $("#pin-con").hide();
                            }else{
                                alert("Failed to transfer");
                            }
                        },2000)
                    }
                })
            }

        })

       
    </script>
    <style>
    .pin-container{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(255,255,255);
        background-color: rgba(255,255,255,0.6);

    }
    .pin-content{
        width: 30%;
        height: 300px;;
        margin: 100px auto;
        padding: 18px 25px;
        text-align: left;
        background-color: #fff;
        border: 1px solid #fff;
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
    }
    .input-container{
        border-bottom: 1px solid #000;
        width: 30%;
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
        margin: 20px;;
    }
    span.sub{
    margin-right: 15px;
    color: orangered;
    cursor: pointer;
    }
    a{  
        text-decoration: none;
        display: block;
        margin-right: 15px;
        color: #000;
    }

    </style>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <!-- <script src="./controller/js/ajax.js"></script> -->
    </body>
</html>
