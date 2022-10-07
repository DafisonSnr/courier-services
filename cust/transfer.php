<?php 
require_once './config/config.php';
require_once './process.php';
require_once './includes/reg-header.php';


$userRef = $_SESSION['user']['user_ref'];
$sqlfetchResult = mysqli_query($conn, "SELECT * FROM users where reg_Ref='$userRef'");
$tran_row = mysqli_fetch_assoc($sqlfetchResult);

// Current balance query
  $checkBal = mysqli_query($conn, "SELECT * FROM real_acc WHERE user_ref='$userRef'");
  $fetchBal = mysqli_fetch_assoc($checkBal);
            
?>
<div class="container-fluid" id="push-container">
  <div class="column" id="column">
    <div class="column-small" id="small-col">
      <div class="buttons">
        <div class="icons-list" id="icon-small">
          <div class="bnk-logo" id="bnk-logo"  style="background-color: black; padding: 15px;">
            <img src="./assets/image/wellspring.png" alt="Logo" style="width: 100%; margin: auto;">
          </div>
          <span class="nav-open" id="nav-open" onclick="navOpened()"><i class="fa-solid fa-bars"></i></span>
          <ul class="icons" id="icons">
            <li> <a href="transfer"><i class="fa-solid fa-table-columns text-primary" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li> <a href="transfer"><i class="fa-solid fa-arrow-right-arrow-left" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li> <a href="manage-bene"><i class="fa-solid fa-list-check" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li> <a href="transfer"> <i class="fa-solid fa-wallet" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li> <a href="#" onclick="statement();"> <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li> <a href="mortgage"><i class="fa-solid fa-chart-column" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li> <a href="#" onclick="card()"><i class="fa-solid fa-credit-card" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li> <a href="settings"><i class="fa-solid fa-gear"  style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li><a href="#"><i class="fa-solid fa-headset" style="font-size: 20px;margin-left: 8px; color:orangered;"></i></a></li>
            <li> <a href="./sign_out.php"><i class="fa-solid fa-right-from-bracket" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
          </ul>
        </div>
        <div class="menu-list" id="menu-list">
          <div class="bnk-logo"  style="background-color: black; padding: 15px;">
            <img src="./assets/image/wellspring.png" alt="Logo" style="width: 100%; margin: auto;">
          </div>
          <ul class="list-items p-0">
            <li> <a href="dashboard"><i class="fa-solid fa-table-columns" style="font-size: 20px;margin-left: 8px; color:orangered;"></i> Dashboard</a></li>
            <li class="bg-primary"> <a href="transfer"><i class="fa-solid fa-arrow-right-arrow-left" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Transfers</a></li>
            <li> <a href="manage-bene"><i class="fa-solid fa-list-check" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Beneficiaries</a></li>
            <li> <a href="transfer"> <i class="fa-solid fa-wallet" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Payments</a></li>
            <li> <a href="#" onclick="statement();"> <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>E-STATEMENT</a></li>
            <li> <a href="mortgage"><i class="fa-solid fa-chart-column" style="font-size: 20px;margin-left: 8px; color:orangered;"></i> Mortgage</a></li>
            <li> <a href="#" onclick="card()"><i class="fa-solid fa-credit-card" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Card</a></li>
            <li> <a href="settings"><i class="fa-solid fa-gear"  style="font-size: 20px;margin-left: 8px; color:orangered;"></i> Setting</a></li>
            <li> <a href="#"><i class="fa-solid fa-headset" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Support</a></li>
            <li> <a href="./sign_out.php"><i class="fa-solid fa-right-from-bracket" style="font-size: 20px;margin-left: 8px; color:orangered;"></i> Signout</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="column-large" id="col-large">
      <!-- ajax confirm call -->
      <div class="language" style="float: right; margin-top: 20px; width: 200px">
        <?php include './language.php'; ?>
      </div>
      
      <div class="back-dashboard">
        <a href="dashboard"><i class="fa-solid fa-arrow-left-long"></i></a> 
      </div>
      
      <div class="transfer">
        <!-- <h5>Transaction</h5> -->
        <ul class="transactions">
            <li><a href="#" id="brookline-acc" onclick="document.getElementById('brookline').style.display='block'">Other Wellspring Account <i class="fa-solid fa-angles-right"></i></a></li>
            <li><a href="#" id="other" onclick="document.getElementById('other-bank').style.display='block'">Transfer To Other Bank <i class="fa-solid fa-angles-right"></i></a></li>
            <li onclick="document.getElementById('show-saved').style.display='block'"><a href="#" id="saved-acc" >To Saved Beneficiary <i class="fa-solid fa-angles-right"></i></a></li>
            <li><a href="#" id="print">Print Transaction Reciept <i class="fa-solid fa-angles-right"></i></a></li>
        </ul>
 
      </div>
      <div class="saved-beneficiariey" id="show-saved" style="display:none;">
        <?php require_once './beneficiaries.php'; ?>
      </div>
      <div class="form-list-inputs">
        <div class="form-container">
          <div class="brookline-acc" id="brookline">
            <form action=""  class="brook-content brook-animate" method="POST">
              <span class="close-btn" onclick="document.getElementById('brookline').style.display='none'">&times</span>
              <select name="debit" id="AccounSelect" class="selected" required>
                <option value="" selected>Select account to debit</option>
                <option value="<?=$tran_row['Check_Acc_No']?>"><?=$tran_row['Check_Acc_No']. " - ".$tran_row['currency'].number_format($fetchBal['cBal'],2)?></option>
                <option value="<?=$tran_row['Sav_Acc_No']?>"><?=$tran_row['Sav_Acc_No']." - ".$tran_row['currency'].number_format($fetchBal['sBal'],2)?></option>
              </select>
              <span id="fetchResult" class="text-danger"></span>
              <br>
              <input type="text" name="accoun" id="accNumber" placeholder="Enter Account Number" onkeydown="limit(this)" onkeypress="return (event.charCode !=8 && event.charCode == 0 || (event.charCode >= 48 && event.charCode <= 57))">
              <script>
                function limit(e) {
                  input_limit = 10;
                  if(e.value.length > input_limit){
                    e.value = e.value.substr(0, input_limit);
                  }
                }
              </script>
              <span id="fetchResult" class="text-danger d-block"></span>
              <br>
              <span id="txt" class="text-danger d-block"></span>
              <div class="process">
                <div class="text-center" id="spiner" style="display: none;">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
                <span class="text-danger d-block" id="error"></span>
              </div>
                  <!-- </div> -->
            </form>
          </div>
          
          <div class="pop-container" id="fetchAccount">
          <div  id="showConfirm" class="show-confirm" style="z-index: 99;"></div>
            <form action="" method="post" class="form-content">
              <div class="container1">
                <input type="hidden" name="" id="id" value="<?=$userRef?>">
                <input type="hidden" class="form-control"  id="sender_Acc">
                <input type="text" class="form-control"  id="acc_Num">
                <input type="text" class="form-control" id="name" >
                <input type="text" class="form-control" id="type" >
                <input type="text" class="form-control" id="curt" readonly>
                <input type="text" name="" id="amt" placeholder="Enter Amount" class="form-control">
                <span class="text-danger d-block" id="amt_er"></span>
                <br>
                <div class="saved-ben-click" style="margin: -25px 0 10px 0;">
                  <input type="checkbox" name="savedBen" id="myCheck" type="button" value="submit"> <label for="">Save Beneficiary</label>
                </div>
                <?php 
                  $sql = mysqli_query($conn, "SELECT * FROM tranpin WHERE user_ref='$userRef'");
                  if(mysqli_num_rows($sql)>0){?>
                    <div id="transfer">
                      <button id="pinSubmit" type="submit" >Transfer</button>
                      <a href="transfer" >Cancel</a>
                    </div>
                 <?php }else{?>
                  <div id="transfer " >
                    <button id="same-bank" type="submit" >Transfer</button>
                    <a href="transfer" id="cancel-same-bank" >Cancel</a>
                  </div>
                 <?php }?>
              </div>
              <div class="text-center" id="spinnering" style="display: none; color: red;">
                <div class="spinner-border" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>
            </form>
          </div>
          <script>
              let popShow = document.getElementById("fetchAccount")
              window.onclick =function(event){
                if(event.target ==  popShow){
                  popShow.style.display = "none";
                  window.location.reload();
                }
              } 
            </script>
          <div class="other-bank" id="other-bank" >
            <div id="showResponse" style="z-index: 99;"></div>
            <form action="" method="post" class="form-content other-animate">
              <?php 
                $sqlCheck = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$userRef'");
                $tran_rows = mysqli_fetch_array($sqlCheck);
              ?>
              <select name="debit" id="AccToDebit" class="selected" required>
                <option value="">Select Account</option>
                <option value="<?php echo $tran_rows['Check_Acc_No']?>"><?=$tran_rows['Check_Acc_No']. " - ".$tran_row['currency'].number_format($fetchBal['cBal'],2)?></option>
                <option value="<?php echo $tran_rows['Sav_Acc_No']?>"><?=$tran_rows['Sav_Acc_No']." - ".$tran_row['currency'].number_format($fetchBal['sBal'],2)?></option>
              </select>
             
              <span class="d-block text-danger" style="color: red; display:block;" id="select_er"></span>
              <input type="hidden" id="id" value="<?=$userRef?>">
              <input type="text" name="name" id="benName" placeholder="Enter Account Name">
              <span class="text-danger d-block" id="benName_er"></span>
              <input type="text" id="accNum"  placeholder="Enter Account Number" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" />
              <span class="text-danger d-block" id="benAcc_er"></span>
              <input type="text" name="bank" id="bankName" placeholder="Enter Bank Name">
              <span class="text-danger d-block" id="benBank_er"></span>
              <input type="text" id="routing"  placeholder="Enter Routing Number for local transfer" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" />
              <span class="text-danger d-block" id="routing_er"></span>
              <input type="text" name="swift" id="swift" placeholder="Only enter swift for International transfer">
              <span class="text-danger d-block" id="swift_er"></span>
              <!-- <input type="text"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> -->
              <input type="text" id="amount" placeholder="Enter Amount" onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" />
              <!-- <input type="number" name="amt" id="amount" placeholder="Enter Amount"> -->
              <span class="text-danger d-block" id="amount_er"></span>
              <div class="saved-click">
                <input type="checkbox" name="savedBen" id="other-bank-ben" value="submit">
                <label for="checkbox" class="">Save Beneficiary</label>
              </div>
             
              <div class="process2 w-75 d-flex mx-auto" id="process2-hide">
                <?php 
                  $sql = mysqli_query($conn, "SELECT * FROM tranpin WHERE user_ref='$userRef'");
                  if(mysqli_num_rows($sql)>0){?>
                    <a href="transfer" class="cancel btn btn-sm btn-danger">Cancel</a>
                    <button type="submit" name="send" class="transafer btn btn-sm btn-primary" id="pinSubmit_other">Send</button>
                 <?php }else{?>
                    <a href="transfer" class="cancel btn btn-sm btn-danger" id="cancel-other-bank">Cancel</a>
                    <button type="submit" name="send" class="transafer btn btn-sm btn-primary" id="sender2">Send</button>
                <?php }
                ?>
              
              </div>
              <div class="text-center" id="spinner3" style="display: none; color: red;">
                <div class="spinner-border" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>
            </form>
          </div>
          <div class="spinnerNew" id="spinner" style="display: none;">
            <div class="inner-spinNew">
              <div class="spinner-container">
                <div class="spinner1" ></div>
                <div class="count-form">
                  <span id="count_el">0%</span>
                </div>
                <div class="spinner2"></div>
              </div>
            </div>
          </div>
          <div class="bill_form" id="biller" style="display: none;">
            <div class="inner-bill">
              <span class="closetn2" onclick="window.location.reload()" id="close-Btn-d" >&times</span>
              <?php require_once './process/code_forms.php';?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
         
<!-- <div class="bouncer">
  <div></div>
  <div></div>
  <div></div>
  <div></div>
</div> --> 
<style>

  .bill_form .inner-bill span.closetn2{
    display: block;
    position: absolute;
    top: -10px;
    right: -130px;
    font-size: 40px!important;
    color: red;
    cursor: pointer;
  }
  .bill_form .inner-bill span.closetn2:hover{
    color: black;
  }
  .form-container .brookline-acc span.close-btn{
    position: absolute;
    top: 130px;
    left: 130px;
    font-size: 30px!important;
    color: red;
    margin: -60px 0px -20px 10px;
    cursor: pointer;
  }
  .form-container .brookline-acc span.close-btn:hover{
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
  /* @media(min-width: 390px){
    .inner-spinNew{
      
   
    }
  } */
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
  .bill_form{
    position: fixed;
    top: 0;
    left: 0;
    margin-bottom: 100px;
    width: 100%;
    height: 100%;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.3);
  }
  .inner-bill{
    position: absolute;
    left: 100px;
    width: 300px;
    height: 600px;
    margin: 60px  25px 0 -20px;
    padding: 20px;
    background-color: #ccc;
  }
  .inner-spinNew{
    position: absolute;
    left: 100px;
    width: 300px;
    height: 20%;
    margin: 60px  25px 0 -20px;
    padding: 50px 30px;
    background-color: #f9f9f1;

  }

  .count-form{
    position: absolute;
    top: 60px;
    left: 110px;
    background-color: #fff;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    text-align: center;
    z-index: 99;
  }
  #count_el{
    position: absolute;
    top: 30%;
    left: 0;
    right: 0;
    text-align: center;
    margin: 0 auto;
  }
  .spinnerNew .spinner1 {
    position: absolute;
    left: 100px;
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
    left: 100px;
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
</style>

<!-- saved beneficiary display none -->
<script>
  let container = document.getElementById("bank-back");
    window.onclick = function(event) {
        if (event.target == container) {
            container.style.display = "none";
        }
    }
</script>
<!-- saved beneficiaries ends here -->

<!-- sweetalertw pop through onclick -->
<script>
  // 
  
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
<script src="./controller/js/ajax.js"></script>
<script src="./js/transfer.js"></script>

