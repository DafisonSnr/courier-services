<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELCOME TO WELLSPRING COMMUNITY BANK</title>
    <link rel="icon" type="image/png" href="./assets/images/fave.png">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container ">
        <div class="row">
            <div id="show-otp-form" style="display: none">
                <?php require_once './otp/auth.php'?>
            </div>
            <div id="show-otp-form2" style="display: none">
                <?php require_once './otp/otp.php'?>
            </div>
            <div class="login-container">
                <form action="" id='login-form'>
                    <span id="status" style="color: red; font-size: 14px"></span>
                    <div class="form-group">
                        <a href="index">
                            <img src="./assets/images/wellspring.png" alt="Bank logo">
                        </a>
                        <h3>INTERNET BANKING</h3>
                    </div>
                    <div class="form-group">
                        <div class="form-login">
                            <h4>Online Realtime Balances and Transactions</h4>
                            <p class="instructions">Kindly Login with any of <span>UserID, Account Number, Phone Number or Email</span> 
                                and use the keypad for your password.
                            </p>
                            <input type="hidden" name="" id="ip">
                            <label for="username"> UserId:</label>
                            <input type="text" id="username" name="user" placeholder="User Name"> 
                            <span id="user_error"></span>
                            <br>
                            <label for="password">Password:</label>
                            <input type="password" id="password"  placeholder="Password">
                            <span id="pass_error"></span>
                            <button type="submit" class="submit" id="login_submit"><span class="spinal" display="block!important"></span> Login</button>
                            <div class="links">
                                <a href="#"  onclick="document.getElementById('modal-page').style.display ='block';">Forgot your password/UserID?</a>
                                <a href="#">Forgot your secret question?</a>
                            </div>
                            <div class="register-link">
                                <a href="register">
                                    <h5>- New here?</h5>
                                    <p>Click to register</p>
                                </a>
                            </div>
                            <div class="rember-me">
                                <input type="checkbox"  id="check"> <span class="rember">Remember My UserID</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="column-container">
                            <div class="column">
                                <h5>Security Tips</h5>
                                <p>
                                    Please note that Wellspring Community Bank
                                    will NEVER ask you to provide your PIN (Personal Identification Numbers).
                                </p>
                                <a href="#">READ MORE</a>
                            </div>
                            <div class="column">
                                <h5>Account Transfers (Instant)</h5>
                                <p>The fastest way to transfer money to other bank accounts</p>
                                <a href="#">TRY IT TODAY</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="footer">
                            <a href="#">PRIVACY POLICY</a>
                            <hr>
                            <a href="">TERMS & CONDITIONS</a>
                        </div>
                    </div>
                </form>
            </div>
            <section class="mod">
                <div class="login-modal" id="modal-page">
                    <div id="prevent" style="display: none;position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgb(0, 0, 0);background: rgba(0, 0, 0, 0.5);z-index:99"></div>
                        <form action="" method='POST' class="modal-content">
                            <div class="modal-con">
                                <span class="close-btn" onclick="document.getElementById('modal-page').style.display = 'none';">&times</span>
                            </div>
                            <div class="modal-con">
                                <input type="email" name="email" id="otp_email" placeholder="Enter Registered Email Address">
                                <span class="text-danger d-block" id="email_er"></span>
                            </div>
                            <div class="modal-con">
                                <button type='submit' id='submit_email'><span class="spinal2" display="block!important"></span>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
<!-- GetButton.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+44 7418 348769", // WhatsApp number
            call_to_action: "Message us", // Call to action
            button_color: "#FF6550", // Color of button
            position: "right", // Position may be 'right' or 'left'
            pre_filled_message: "Welcome to Wellspring Bank, please let us know how", // WhatsApp pre-filled message
        };
        var proto = 'https:', host = "getbutton.io", url = proto + '//static.' + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget -->
<!--<script src="//code.tidio.co/1rbgdqfxfaia3tfquhcaoi4vlxsmvymw.js" async></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
    <script src="./js/login.js"></script>
</body>
</html>
    
