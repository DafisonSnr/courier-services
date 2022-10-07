<?php 
    require_once './includes/reg-header.php';
    require_once './process.php';
?>
<div class="reg-container mt-5">
    <div class="reg-row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <a href="index">
                    <img src="./assets/images/wellspring.png" alt="Bank Logo">
                </a>
                <h2>Sign Up</h2>
                <h5>SECTION ONE</h5>
                <span class="d-block text-danger"><?=$status?></span>
            </div>
            <div class="form-container">
                <input type="text" name="names" placeholder="Full Name" id="name" value="<?=$fName?>" required>
                <span class="text-danger"><?=$fName_er?></span>
                <select name="type" id="type" value="<?=$type?>" required  >
                    <option value="" selected>--Select Account Type--</option>
                    <option value="current">Checking Account</option>
                    <option value="current">Savings Account</option>
                    <option value="current">Loan Account</option>
                </select>
                <select name="currencies" value="<?=$curr?>">
                    <option value="">Select Currency</option>
                    <option value="$">Dollar</option>
                    <option value="€">Euro</option>
                    <option value="£">Pound</option>
                </select>
                <span class="d-block text-danger"><?=$curr_er?></span>
                <span class="d-block text-danger"><?=$type_er?></span>
                <input type="text" name="dob" id="dob" placeholder="DOB(YYY-MM-DD)" value="<?=$dob?>" required>
                <span class="d-block text-danger"><?=$dob_er?></span>
                <select name="gender" id="gender" value="<?=$gen?>">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <span class="d-block text-danger"><?=$gen_er?></span>
                <select name="marital" id="marital" required>
                    <option value="">Marital Status</option>
                    <option value="Single"<?php echo(isset($_POST['marital']) && $_POST['marital'] == "Single") ? "selected" : "";?>>Single</option>
                    <option value="Married" <?php echo(isset($_POST['marital']) && $_POST['marital'] == "Married") ? "selected" : "";?>> Married</option>
                    <option value="Separated" <?php echo(isset($_POST['marital']) && $_POST['marital'] == "Separated") ? "selected" : "";?>> Separated</option>
                    <option value="Divorced" <?php echo (isset($_POST['marital']) && $_POST['marital']=="Divorced")?"selected" : ""?>> Divorced</option>
                    <option value="Widowed" <?php echo(isset($_POST['marital']) && $_POST['marital'] == "Widowed")?"selected" : ""?> >Widowed</option>
                </select>
                <span class="d-block text-danger"><?=$marital_er?></span>
                <select name="country" id="country" value="<?=$contry?>">
                    <option value="NULL" selected>Select Country</option>
                    <?php while ($row = mysqli_fetch_assoc($sqlCon)){?>
                        <option value="<?=$row['name']?>" <?php echo(isset($_POST['country']) && $_POST['country'] == $row['name'])?"selected" : ""?>><?=$row['name']?></option>
                   <?php  }?>
                </select>
                <span class="d-block text-danger"><?=$contry_er?></span>
                <input type="text" name="city" id="city" placeholder="City" value="<?=$city?>" required>
                <span class="d-block text-danger"><?=$city_er?></span>
                <input type="text" name="zip" id="zip" placeholder="Zip Code" value="<?=$zip?>" required>
                <span class="d-block text-danger"><?=$zip_er?></span>
                <input type="text" name="ssn" id="ssn" onkeydown="limit(this)" onkeyup="limit(this)" placeholder="SSN(Optional)" value="<?=$ssn?>">
                <input type="tel" name="phone" id="numbers" onkeydown="limit(this)" onkeyup="limit(this)" placeholder="Phone Number" value="<?=$phone?>" onkeypress="return (event.charCode != 8 && event.charCode ==0 || (event.charCode >=48 && event.charCode <=57))" required>
                <span class="d-block text-danger"><?=$number_er?></span>
                <input type="email" name="email" id="email" placeholder="Enter E-mail" value="<?=$email?>" required>
                <span class="d-block text-danger"><?=$email_er?></span>
                <input type="text" name="occupation" id="occupation" placeholder="Occupation" value="<?=$occup?>" required>
                <span class="d-block text-danger"><?=$occup_er?></span>
                <input type="text" name="kin" id="kin" placeholder="Next Of Kin" value="<?=$kin?>" required>
                <span class="d-block text-danger"><?=$kin_er?></span>
            </div>
            <div class="form-container">
                <h5>SECTION TWO</h5> 
                <h3 class="online-bank">ONLINE BANKING REGISTRATION</h3>
                <input type="text" name="user" id="user" placeholder="Enter Username" value="<?=$user?>" required>
                <span class="d-block text-danger"><?=$user_er?></span>
                <input type="password" name="passwords" id="pass" placeholder="Create Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[@#$%^&*+])(?=.*[0-9]).{8,}" 
                value="<?=$pass?>" required>
                <div class="showPassword">
                   <span><input type="checkbox" name="" onclick="functionShow()"></span>Show Password 
                </div>
                <div class="message" id="message">
                    <p id="upper" class="invalid">Password must contains atleast one <b>Uppercase</b></p>
                    <p id="lowercase" class="invalid">Password must contains atleast one <b>Lowercase</b></p>
                    <p id="character" class="invalid">Password must contains atleast one <b>Special Character</b></p>
                    <p id="number" class="invalid">Password must contains atleast one <b>Number</b></p>
                    <p id="length" class="invalid">Password must be greater than or equal <b>8</b></p>
                </div>
                <span class="d-block text-danger"><?=$pass_er?></span>
               <input type="password" name="confirm" id="confirm" placeholder="Confirm Password">
               <span class="d-block text-danger"><?=$confirm_er?></span>
               <input type="text" name="question" id="question" placeholder="Secret Question" value="<?=$question?>" required>
               <span class="d-block text-danger"><?=$question_er?></span>
               <input type="password" name="answer" id="answer" placeholder="Secret Answer">
               <span class="d-block text-danger"><?=$answer_er?></span>
            </div>
            <div class="form-container">
                <h5>SECTION THREE</h5>
                <div class="file-section">
                    <p class="document"> Document Upload</p>
                    <p>To avoid delay in verifying your account, Please abide by the follow rules below:</p>
                    <ul class="uploads">
                        <li>You can Upload Passport/Driving Licence etc.</li>
                        <li>Uploaded credential must be valid and not expired</li>
                        <li>Document should be in good condition and clearly visible</li>
                    </ul>
                    <p class="insert">Insert your ID below:</p>
                    <div class="ids">
                        <input type="file" name="fileUpload" id="fileUpload" required>
                        <span class="d-block text-danger"><?=$file_er?></span>
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <div class="check-policy">
                        <input type="checkbox" name="policy" id="policy" value="" required><span>I accept The Terms of Use and Privacy Policy</span>
                    </div>
                </div>
            </div>
            <div class="form-container">
                <button type="submit" class="register" name="register">SignUp</button>
                <span class="log-sign">Already SignUp? <a href="#" onclick="document.getElementById('modal-page').style.display='block'">Login</a></span>
            </div>
        </form>
        <div id="show-otp-form" style="display: none; position: fixed; top: 60px; left: 0; right: 0;">
            <?php require_once './otp/auth.php'?>
        </div>
        <section class="mod">
            <div class="login-modal-med" id="modal-page">
                <form action="" class="modal-content-med animate">
                    <div class="modal-con">
                        <span class="close-btn" onclick="document.getElementById('modal-page').style.display = 'none';">&times</span>
                    </div>
                    <div class="modal-con">
                        <input type="hidden" name="" id="ip">
                        <input type="text" id="username" placeholder="Enter Username">
                        <span id="user_error" class="text-danger d-block fw-bold"></span>
                        <input type="password" id="password" placeholder="Enter Password">
                        <span id="pass_error" class="text-danger d-block fw-bold"></span>
                        <button type="submit" id="login_submit">Login <span class="spinal" display="block!important"></span></button>
                    </div>
                    <div class="modal-con">
                        <button style="width:auto" type="button" class="cancel-btn" onclick="document.getElementById('modal-page').style.display = 'none';">Cancel</button>
                        <span class="psw">Forget <a href="#">Password?</a></span>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<style>
                    
    .message{
        display: none;
        background-color: #ccc;
        width: 80%;
        margin: 10px auto;
        text-align: left;
        padding: 15px 10px;
    }
    .invalid::before{
        content: '❌';
        color: red;
        margin-left: 5px;
        margin-right: 5px;
    }
    .valid::before{
        content: "✓";
        color: green;
        margin: 0 5px;
        font-weight: bold;
    }
</style>
<script>
    function limit(element){
        let limit_num = 10;
        if(element.value.length > limit_num){
            element.value = element.value.substr(0, limit_num);
        }
    }
    // Password required format functions
    let passInput = document.getElementById('pass');
    let message = document.getElementById('message');
    function functionShow() {
        if(passInput.type =="password"){
            passInput.type = "text";
        }else{
            passInput.type = "password";    
        }
    }

    passInput.onfocus = function(){
        document.getElementById("message").style.display = "block";
    }
    passInput.onblur = function(){
        document.getElementById("message").style.display = "none";
    }
    passInput.onkeyup = function(){
        let upperCase = document.getElementById("upper")
        let upper = /[A-Z]/g;
        if(passInput.value.match(upper)){
            upperCase.classList.remove("invalid")
            upperCase.classList.add("valid");
        }else{
            upperCase.classList.remove("valid");
            upperCase.classList.add("invalid");
        }
        let lowercase = document.getElementById("lowercase");
        let lower = /[a-z]/g;
        if(passInput.value.match(lower)){
            lowercase.classList.remove("invalid")
            lowercase.classList.add("valid");
        }else{
            lowercase.classList.remove("valid");
            lowercase.classList.add("invalid");
        }
        let character = document.getElementById("character");
        let specChar = /[@#$%&*!]/g;
        if(passInput.value.match(specChar)){
            character.classList.remove("invalid");
            character.classList.add("valid");
        }else{
            character.classList.remove("valid");
            character.classList.add("invalid");
        }
        let number1 = document.getElementById("number");
        let numberse = /[0-9]/g;
        if(passInput.value.match(numberse)){
            number1.classList.remove("invalid");
            number1.classList.add("valid")
        }else{
            number1.classList.remove("valid");
            number1.classList.add("invalid");
        }
        let length = document.getElementById("length");
        if(passInput.value.length >=8){
            length.classList.remove("invalid");
            length.classList.add("valid");
        }else{
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }
</script>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="./js/login.js"></script>


