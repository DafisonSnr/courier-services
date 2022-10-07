<?php
    session_start();
    require_once './config/config.php';
    // require_once './includes/admin-header.php';
    
    function clean($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
      // $sql = "SELECT * FROM OnBanking";
      // $fetchUsers = mysqli_query($conn, $sql);
      // $_SESSION['user'] = mysqli_fetch_assoc($fetchUsers); 
    if(isset($_POST['submit'])){
        $userInput = clean($_POST['username']);
        $passInput = clean($_POST['password']);
        $sql = "SELECT * FROM OnBanking WHERE username='$userInput'";
        $result = $conn->query($sql);
        if(mysqli_num_rows($result)>0){
            $fetchPass = mysqli_fetch_assoc($result);
            $passIn = $fetchPass['password'];
            $role = $fetchPass['role'];
            $pw = $passInput;  
            if(password_verify($pw,$passIn)){
            $_SESSION['admin'] = true;
            $_SESSION['admin'] = $fetchPass;
            if($role === "admin"){
                echo "<script>alert('logged In');window.location.href='./admin/views/dashboard.php';</script>";
                
            }else{
                echo "<script>alert('This Portal is for admin Only')</script>";
            }
            }else{
                echo "<script>alert('Invalid password')</script>";
            }
        }else{
            echo "<script>alert('Invalid UserID')</script>";
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
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container">
        <div class="row">
        <div id="show-otp-form" style="display: none">
                <?php require_once './otp/auth.php'?>
            </div>
            <div id="show-otp-form2" style="display: none">
                <?php require_once './otp/otp.php'?>
            </div>
            <div class="admin_log_container">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <img src="./assets/images/wellspring.png" alt="Bank logo">
                        <h3>ADMIN PORTAL</h3>
                    </div>
                    <div class="form-group">
                        <div class="form-login">
                        <label for="usernae"> UserId:</label>
                            <input type="text" name="username" placeholder="Enter Username"> 
                            <span id="user_error"></span>
                            <br>
                            <label for="password">Password:</label>
                            <input type="password" name="password" placeholder="Password">
                            <span id="pass_error"></span>
                            <button type="submit" class="submit" name="submit"> Login</button>
                            <div class="links">
                                <a href="javascript:void(0)"  onclick="document.getElementById('modal-page').style.display ='block';">Forgot your password/UserID?</a>
                                <a href="#">Forgot your secret question?</a>
                            </div>
                        
                            <div class="rember-me">
                                <input type="checkbox"  id="check"> <span class="rember">Remember My UserID</span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- <div class="form-group">
                        <div class="footer">
                            <a href="#">PRIVACY POLICY</a>
                            <hr>
                            <a href="">TERMS & CONDITIONS</a>
                        </div>
                    </div> -->

                </form>
            </div>
        </div>
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
                                <span class="text-danger d-block" id="email_er" style="color:red;"></span>
                            </div>
                            <div class="modal-con">
                                <button type='submit' id='submit_email'><span class="spinal2" display="block!important"></span>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
       
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
    <script src="./js/login.js"></script>
</body>
</html>
    
