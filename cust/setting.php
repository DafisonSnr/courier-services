<?php 
require_once './update_cont/update.php';
  require_once './process.php';
  require_once './includes/reg-header.php';
  $user_Ref = $_SESSION['user']['user_ref'];
  $accHistory = mysqli_query($conn, "SELECT * FROM acc_history WHERE user_ref='$user_Ref' ORDER BY id DESC");

  $reg_info = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user_Ref'");
  $fetchReg  = mysqli_fetch_assoc($reg_info);

  //account balance query
  // $balance = mysqli_query($conn, "SELECT SUM(amt) AS total FROM acc_history WHERE user_ref='$user_Ref' AND tran_status='APPROVED'");
  // $fetchBal = mysqli_fetch_assoc($balance);

  $balance = mysqli_query($conn, "SELECT * FROM real_acc WHERE user_ref='$user_Ref'");
  $fetchBal = mysqli_fetch_assoc($balance);  
?>
<div class="container-fluid" id="push-container">
    <div class="column" id="column">
        <div class="column-small" id="small-col">
        <div class="buttons">
            <div class="icons-list" id="icon-small">
            <div class="bnk-logo" id="bnk-logo"  style="background-color: black; padding: 15px;">
                <img src="./assets/image/wellspring.png" alt="" style="width: 100%; margin: auto;">
            </div>
            <span class="nav-open" id="nav-open" onclick="navOpened()"><i class="fa-solid fa-bars"></i></span>
            <ul class="icons" id="icons">
                <li> <a href="transfer"><i class="fa-solid fa-table-columns" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
                <li> <a href="transfer"><i class="fa-solid fa-arrow-right-arrow-left" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
                <li> <a href="manage-bene"><i class="fa-solid fa-list-check" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
                <li> <a href="transfer"> <i class="fa-solid fa-wallet" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
                <li> <a href="#" onclick="statement();"> <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
                <li> <a href="mortgage"><i class="fa-solid fa-chart-column" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
                <li> <a href="#" onclick="card()"><i class="fa-solid fa-credit-card" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
                <li> <a href="settings"><i class="fa-solid fa-gear text-primary"  style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
                <li> <a href="./sign_out.php"><i class="fa-solid fa-right-from-bracket" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            </ul>
            </div>
            <div class="menu-list" id="menu-list">
            <div class="bnk-logo"  style="background-color: black; padding: 15px;">
                <img src="./assets/image/wellspring.png" alt="Logo" style="width: 100%; margin: auto;">
            </div>
            <ul class="list-items p-0">
                <li> <a href="dashboard"><i class="fa-solid fa-table-columns" style="font-size: 20px;margin-left: 8px; color:orangered;"></i> Dashboard</a></li>
                <li> <a href="transfer"><i class="fa-solid fa-arrow-right-arrow-left" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Transfers</a></li>
                <li> <a href="manage-bene"><i class="fa-solid fa-list-check" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Beneficiaries</a></li>
                <li> <a href="transfer"> <i class="fa-solid fa-wallet" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Payments</a></li>
                <li> <a href="#" onclick="statement();"> <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>E-STATEMENT</a></li>
                <li> <a href="mortgage"><i class="fa-solid fa-chart-column" style="font-size: 20px;margin-left: 8px; color:orangered;"></i> Mortgage</a></li>
                <li> <a href="#" onclick="card()"><i class="fa-solid fa-credit-card" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Card</a></li>
                <li class="bg-primary"> <a href="settings"><i class="fa-solid fa-gear"  style="font-size: 20px;margin-left: 8px; color:orangered;"></i> Setting</a></li>
                <li> <a href="settings"><i class="fa-solid fa-gear"  style="font-size: 20px;margin-left: 8px; color:orangered;"></i> Support</a></li>
                <li> <a href="./sign_out.php"><i class="fa-solid fa-right-from-bracket" style="font-size: 20px;margin-left: 8px; color:orangered;"></i> Signout</a></li>
            </ul>
            </div>
        </div>
    </div>
    <div class="column-large" id="col-large">
        <div class="language" style="float: right; margin-top: 20px; width: 200px">
            <?php include './language.php'; ?>
        </div>
        <div class="back-dashboard">
            <a href="dashboard"><i class="fa-solid fa-arrow-left-long"></i></a> 
        </div>
        <div class="general-settings-container">
        <?php 
            if(isset($_GET['enable']) || isset($_GET['disable'])){?>
            <form action="" method="post" enctype="multipart/form" autocomplete="off" class="my-5 p-3 w-75 ">
                <input type="hidden" name="enable_dis" id="" value="<?php 
                    if(isset($_GET['enable'])){
                        echo $user_Ref;
                    }
                    if(isset($_GET['disable'])){
                        echo $user_Ref;
                    }
                
                ?>">
                <div class="card" style="width: 18em">
                    <div class="card-body bg-info">
                        <p class="fs-5 text-white">Are you Sure?</p>
                        <button type="submit" name="enable" class="btn btn-sm btn-danger w-25">YES</button>
                        <a href="./settings" class="btn btn-sm btn-primary w-25">NO</a>
                    </div>
                </div>
            </form>
        <?php  }else{?>
            <?php 
                if(isset($_GET['reset_secret'])){?>
                <form action="" method="post" enctype="multipart/form" autocomplete="off" class="my-5 p-3 w-75 ">
                    <input type="hidden" name="reset_sec" id="" value="<?=$user_Ref?>">
                    <div class="card" style="width: 18em">
                        <div class="card-body bg-info">
                            <label for="" class="text-white">Question</label>
                        <input type="text" name="question_reset" id="" class="form-control form-control-sm " placeholder=" ">
                        <span class="text-danger d-block"><?=$q_reset_er?></span>
                        <label for="" class="text-white">Answer</label>
                        <input type="text" name="answer_reset" id="" class="form-control form-control-sm ">
                        <span class="text-danger d-block"><?=$a_reset_er?></span>
                        <button type="submit" name="reset" class="btn btn-sm btn-danger w-50 mt-2">Update</button>
                            <a href="./settings" class="btn btn-sm btn-primary w-50 mt-2">Cancel</a>
                        </div>
                    </div>
                </form>
            <?php  }else{?>
                <?php 
                    $sqlFetch = mysqli_query($conn, "SELECT * FROM OnBanking where user_ref='$user_Ref'");
                    if($sqlFetch) {
                        $row = mysqli_fetch_array($sqlFetch);
                    }
                    if(isset($_GET['forgot_secret'])){?>
                    <form action="" method="post" enctype="multipart/form" autocomplete="off" class="my-5 p-3 w-75 ">
                        <input type="hidden" name="forgot_sec" id="" value="<?=$user_Ref?>">
                        <div class="card" style="width: 18em">
                            <div class="card-body bg-info">
                                <label for="" class="text-white">Question</label>
                            <input type="text" name="" id="" value="<?=$row['question']?>" disabled readonly>
                            <label for="" class="text-white">Answer</label>
                            <input type="text" name="" id="" value="<?=$row['answer']?>" readonly>
                                <a href="./settings" class="btn btn-sm btn-primary w-25 mt-2">Cancel</a>
                            </div>
                        </div>
                    </form>
                <?php  }else{?>
                    <?php if(isset($_GET['remove_pin'])){?>
                        <form action="" method="post" enctype="multipart/form" autocomplete="off" class="my-5 p-3 w-75 ">
                            <input type="hidden" name="removePin" id="" value="<?=$user_Ref?>">
                            <div class="card" style="width: 18em">
                                <div class="card-body bg-info">
                                    <p class="fs-5 text-white">Are you Sure?</p>
                                    <button type="submit" name="yes" class="btn btn-sm btn-danger w-25">YES</button>
                                    <a href="./settings" class="btn btn-sm btn-primary w-25">NO</a>
                                </div>
                            </div>
                        </form>
                        <?php  }else{?>
                        <?php if(isset($_GET['change_pin'])){?>
                            <form action="" method="post" enctype="multipart/form" autocomplete="off" class="my-5 p-3 w-75 mx-auto bg-light shadow-lg ">
                                <span class="text-danger d-block"><?=$status3?></span>
                                <input type="hidden" name="cPin" id="" value="<?=$user_Ref?>">
                                <input type="password" name="old_pin" id="pass" onkeyup="limit(this)" onkeydown="limit(this)"   class="form-control form-control-sm mt-3" placeholder="Enter Old Pin(4 digits)" onkeypress="return (event.charCode != 8 && event.charCode == 0 || (event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))">
                                <span class="d-block text-danger"><?=$old_pin_er?></span>
                                <div class="check-container" style="margin-top: 5px; text-align: left">
                                    <label for="" >
                                    <input type="checkbox" name="" onclick="functionShow()">
                                        Show Password
                                    </label>   
                                </div>
                                <input type="password" name="new_pin" id="pass" onkeyup="limit(this)" onkeydown="limit(this)"   class="form-control form-control-sm mt-3" placeholder="Enter New Pin(4 digits)" onkeypress="return (event.charCode != 8 && event.charCode == 0 || (event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))">
                                <span class="d-block text-danger"><?=$new_pin_er?></span>
                                <br>
                                <input type="password" name="conf_pin" onkeydown="limit(this)" onkeyup="limit(this)" class="form-control form-control-sm mt-3" placeholder="Confirm Pin" onkeypress="return (event.charCode != 8 && event.char == 0 || (event.charCode == 46 ||(event.charCode >= 48 && event.charCode <= 57)))">
                                <span class="d-block text-danger"><?=$com_pin_er?></span>
                                <button type="submit" name="change_pin" class="btn btn-danger w-50 mt-3">Update</button>
                                <a href="./settings" class="btn btn-primary w-50 mt-3">cancel</a>
                                <script>
                                    function limit(element) {
                                        let input_length = 4;
                                        if (element.value.length > input_length){
                                            element.value = element.value.substr(0,input_length)
                                        }
                                    }
                                </script>
                            </form>
                            <?php  }else{?>
                                <?php if(isset($_GET['add_pin'])){?>
                                    <form action="" method="post" enctype="multipart/form" autocomplete="off" class="my-5 p-3 w-75 mx-auto bg-light shadow-lg ">
                                        <input type="hidden" name="fPin" id="" value="<?=$user_Ref?>">
                                        <input type="password" name="pin" id="pass" onkeyup="limit(this)" onkeydown="limit(this)"   class="form-control form-control-sm mt-3" placeholder="Enter Transaction Pin(4 digits)" onkeypress="return (event.charCode != 8 && event.charCode == 0 || (event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))">
                                        <span class="d-block text-danger"><?=$pin_er?></span>
                                        <br>
                                        <div class="check-container" style="margin-top: -20px;">
                                            <label for="" >
                                            <input type="checkbox" name="" onclick="functionShow()">
                                                Show Password
                                            </label>   
                                        </div>
                                        <input type="password" name="confirm_pin" onkeydown="limit(this)" onkeyup="limit(this)" class="form-control form-control-sm mt-3" placeholder="Confirm Pin" onkeypress="return (event.charCode != 8 && event.char == 0 || (event.charCode == 46 ||(event.charCode >= 48 && event.charCode <= 57)))">
                                        <span class="d-block text-danger"><?=$comPin_er?></span>
                                        <button type="submit" name="submit_pin" class="btn btn-danger w-50 mt-3">Update</button>
                                        <a href="./settings" class="btn btn-primary w-50 mt-3">cancel</a>
                                        <script>
                                            function limit(element) {
                                                let input_length = 4;
                                                if (element.value.length > input_length){
                                                    element.value = element.value.substr(0,input_length)
                                                }
                                            }
                                            567890
                                        </script>
                                    </form>
                                    <?php  }else{?>
                                        <?php 
                                            $questionSql = mysqli_query($conn, "SELECT * FROM OnBanking WHERE user_ref='$user_Ref'");
                                            $rowSql = mysqli_fetch_assoc($questionSql);
                                            $rowFetch = $rowSql['question'];
                                            $rowAnswer = $rowSql['answer'];
                                            if(isset($_GET['forgot'])) {?>
                                                <form action="" method="post" enctype="multipart/form" autocomplete="off" class="my-5 p-3 w-75 mx-auto bg-light shadow-lg forgot">
                                                    <span class="text-danger d-block"><?=$status2?></span>
                                                    <input type="hidden" name="fPass" id="" value="<?=$user_Ref?>">
                                                    <input type="hidden" name="DatabaseAns" id="" value="<?=$rowAnswer?>">
                                                    <label for="">Secret Question</label>
                                                    <input type="text" name="question" id="" value="<?=$rowFetch?>" class="form-control form-control-sm mt-3" readonly>
                                                    <label for="">Secret Answer</label>
                                                    <input type="text" name="answer" id="" placeholder="Secret Answer" class="form-control form-control-sm mt-3">
                                                    <span class="text-danger d-block"><?=$answer_er?></span>
                                                    <label for="">Login Username</label>
                                                    <input type="username" name="username"  class="form-control form-control-sm mt-3" placeholder="Enter Username">
                                                    <span class="d-block text-danger"><?=$user_er?></span>
                                                    <label for="">New Password</label>
                                                    <input type="password" name="password" id="pass" class="form-control form-control-sm mt-3" placeholder="Enter New Password">
                                                    <span class="d-block text-danger"><?=$fPass_er?></span>
                                                    <br>
                                                    <div class="check-container" style="margin-top: -20px; text-align: left">
                                                        <label for="" >
                                                        <input type="checkbox" name="" onclick="functionShow()">
                                                            Show Password
                                                        </label>   
                                                    </div>
                                                    <label for="">Confirm Password</label>
                                                    <input type="password" name="f-confirm" id="" class="form-control form-control-sm mt-3" placeholder="Confirm New Password">
                                                    <span class="d-block text-danger"><?=$cForgot_er?></span>
                                                    <button type="submit" name="forgot_pass" class="btn btn-danger w-50 mt-3">Update</button>
                                                    <a href="./settings" class="btn btn-primary w-50 mt-3">cancel</a>
                                                </form>
                                <?php  }else{?>
                                    <?php if(isset($_GET['change'])){?>
                                        <form action="" method="post" enctype="multipart/form" autocomplete="off" class="my-5 p-3 w-75 mx-auto bg-light shadow-lg ">
                                            <span class="text-danger d-block"><?=$status2?></span>
                                            <input type="hidden" name="user" id="" value="<?=$user_Ref?>">
                                            <input type="password" name="old_password" id="pass" class="form-control form-control-sm mt-3" placeholder="Enter Old Password">
                                            <span class="d-block text-danger"><?=$old_err?></span>
                                            <br>
                                            <div class="check-container" style="margin-top: -20px;">
                                                <label for="" >
                                                <input type="checkbox" name="" onclick="functionShow()">
                                                    Show Password
                                                </label>   
                                            </div>
                                            <input type="password" name="new_password" id="" class="form-control form-control-sm mt-3" placeholder="Enter New Password">
                                            <span class="d-block text-danger"><?=$new_err?></span>
                                            <input type="password" name="confirm" id="" class="form-control form-control-sm mt-3" placeholder="Confirm New Password">
                                            <span class="d-block text-danger"><?=$confirm_err?></span>
                                            <button type="submit" name="change_pass" class="btn btn-danger w-50 mt-3">Update</button>
                                            <a href="./settings" class="btn btn-primary w-50 mt-3">cancel</a>
                                        </form>
                                    <?php  }else{?>
                                        <div class="setting-container">
                                            <ul class="settings">
                                                <li>
                                                    <?php 
                                                        $fetch = mysqli_query($conn, "SELECT * FROM tranpin WHERE user_ref='$user_Ref'");
                                                        if(mysqli_num_rows($fetch)<1){?>
                                                            <a href="?add_pin">Add Transaction PIN</a>
                                                    <?php }else{?>
                                                        <span class="text-primary fw-bold" style="margin-left: 20px;">Pin created</span>
                                                    <?php }?>
                                                </li>
                                                <li><a href="?change_pin=<?=base64_encode($user_Ref)?>">Change Transaction PIN</a></li>
                                                <li><a href="?remove_pin=<?=base64_encode($user_Ref)?>">Remove Transaction PIN</a></li>
                                                <li><a href="?change=<?=base64_encode($user_Ref)?>">Change Password</a></li>
                                                <li><a href="?forgot=<?=base64_encode($user_Ref)?>">Forgot Password</a></li>
                                                <li><a href="?forgot_secret=<?=base64_encode($user_Ref)?>">Forgot Secret Answer</a></li>
                                                <li><a href="?reset_secret=<?=base64_encode($user_Ref)?>">Reset Secret Answer</a></li>
                                                <li>
                                                    <?php 
                                                        $sql = mysqli_query($conn, "SELECT * FROM otp where user_ref='$user_Ref'");
                                                        $sqlRowFetch = mysqli_fetch_assoc($sql);
                                                        if($sqlRowFetch['status'] == 'YES') {?>
                                                            <a href="?disable=<?=base64_encode($user_Ref)?>">Disable Login Auth</a>
                                                        <?php  }else{?>
                                                        <a href="?enable=<?=base64_encode($user_Ref)?>">Enable Login Auth</a>
                                                    <?php  }
                                                    ?>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                        <?php }?>
                    <?php }?>
                <?php }?>
            <?php }?>
        <?php }?>
        </div>
    </div>
    </div> 
</div>
<style>
    
    .setting-container ul.settings{
        margin-top: 30px;
        text-align: left;
    }
    .setting-container ul.settings li{
        list-style: none;
    }
    .setting-container ul.settings a{
        display: block;
        padding: 15px;
        color: #f00;
    }
    .setting-container ul.settings a:hover{
        opacity: 0.5;
    }
    .general-settings-container{
        width: 400px;
    }
</style>

<script>
    function functionShow() {
        let passInput = document.getElementById("pass");
        if(passInput.type =="password"){
            passInput.type = "text";
        }else{
            passInput.type = "password";    
        }
    }
</script>


<!-- sweetalertw pop through onclick -->
<script>
  function statement(){
    let timerInterval
    Swal.fire({
      title: 'Your request is processing..',
      html: 'Preparing statements <b></b>.',
      timer: 4000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading()
        const b = Swal.getHtmlContainer().querySelector('b')
        timerInterval = setInterval(() => {
          b.textContent = Swal.getTimerLeft()
        }, 150)
      },
      willClose: () => {
        clearInterval(timerInterval)
      }
    }).then((result) => {
      /* Read more about handling dismissals below */
      if (result.dismiss === Swal.DismissReason.timer) {
        console.log('I was closed by the timer')
        Swal.fire(
          'Statements completed. Kindly check your email for printed copy',
        )
      } 
    })
      
  }

function card(){
  Swal.fire({
  title: 'Do you want to Request a Card?',
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'Yes',
  denyButtonText: `No`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    Swal.fire('Your card request has been posted!', '', 'success')
  } else if (result.isDenied) {
    Swal.fire('Your card request has been denied!', '', 'info')
  }
})
}
</script>
<style>
  .swal2-popup {
    width: 250px!important;
    height: 250px!important;
    font-size: 12px !important;
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="./controller/js/transfer.js"></script> -->
<?php require_once './includes/dash_footer.php'; ?>