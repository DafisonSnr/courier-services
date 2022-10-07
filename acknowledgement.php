<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.1.1/cerulean/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
    <title>Document</title>
    <style>
        .bank {
            text-align:center;
            margin: 50px 0;
        }
        .bank h5{
            color: orangered;
            font-weight: bold;
            text-shadow: 2px 1px green;
            font-size: 25px;
        }
        .bank h5:first-child{
            color: rgb(47,164,231);
            font-weight: bold;
            text-shadow: 2px 1px  #000;
        }
        .bank i{
            background-color: green;
            width: 35px;
            height: 35px;
            border-radius:100%;
            color: white;
            padding:3px;
        }
        .acknowledgement{
            text-align:center;
            
        }
        .confirmation {
            text-align:center;
            margin: 70px 0;
        }
        .copyright{
            text-align:center;
        }
        .copyright a{
            text-decoration: none;
        }
        .success-container {
            display: none;
            position: fixed;
            top: 5%;
            left: 12%;
            right: 12%;
        }
        .success-container p{
            font-size: 14px;
        }
        .success-container span{
            float: right;
            font-size: 22px;
            cursor: pointer;
        }
        .success-container span:hover{
            color:red;
        }
        .success-container h3{
            font-size: 15px;
            color: #000;
        }
        .success-container .address h4{
            color: orangered;
        }
        .button-cont{
            text-align: right;
        }
        @media(min-width:768px){
            .success-container,.acknowledge-cont{
                width: 50%!important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="acknowledge-cont  shadow-lg bg-light mx-auto w-75 p-4 mt-5">
                <a href="./login" class="btn btn-sm btn-danger p-2 m-0">Back to Login</a>
                <div class="bank mx-auto w-100 mt-5 text-dark">
                    <h5>WELLSPRING</h5>
                    <h5><i class="fa-solid fa-building-columns"></i> BANK</h5>
                </div>
                <hr>
                <div class="acknowledgement">
                    <h3 class="text-dark">Acknowledgement</h3>
                    <p>Your Application has been received by our customer service</p>
                </div>
                <div class="confirmation mt-4">
                    <button class="btn btn-primary p3" id="showSuccess">Confirm your application</button>
                </div>
                <div class="copyright mt-4">
                    <p>Copyright &copy 2020 <a href="index">Wellspring Bank</a> All rights reserved</p>
                </div>
                <button class="btn btn-primary" type="button" disabled id="spinner-cont" style="display:none">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    processing...`
                </button>
            </div>
        </div>
        <div class="success-container mx-auto shadow-lg bg-light p-4 w-75" id="success-cont">
            <div class="bank mx-auto w-100 mt-5 text-dark" style="text-align: left">
                <h5>WELLSPRING </h5>
                <h5><i class="fa-solid fa-building-columns"></i> BANK</h5>
            </div>
            <hr>
            <h3>APPLICATION RECEIVED<span onclick="window.location.href='login'";>&times</span></h3>
            <hr>
            <div class="success">
                <h2>Success!!!</h2>
                <p>Kindly await 1-2 business working days to enable us process your application, meanwhile, we have sent you an
                    email with your account information.
                </p>
                <p>You will be notify via email immediately your account is activated</p>
            </div>
            <div class="address">
                <h4>WELLSPRING Bank</h4>
                <p>Portsmouth, United Kingdom</p>
            </div>
            <hr>
            <div class="button-cont">
                <a href="login" class="btn btn-primary btn-sm p-2">Okay</a>
            </div>
        </div>
        <div class="process">
                <div class="text-center" id="spiner" style="display: none;">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
                <span class="text-danger d-block" id="error"></span>
              </div>
    </div>
<script>
    $(document).ready(function () {
        $("#showSuccess").click(function () { 
            $("#showSuccess").html('<button class="btn btn-primary" type="button" disabled id="spinner-cont"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>processing...</button>')
            setTimeout(() => {
                let success = $("#success-cont").fadeIn();
            }, 2000);
        });
    });
</script>
</body>
</html>