<?php 
  require_once './process.php';
  require_once './includes/reg-header.php';
  $user_Ref = $_SESSION['user']['user_ref'];
  $accHistory = mysqli_query($conn, "SELECT * FROM acc_history WHERE user_ref='$user_Ref'");

  $reg_info = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user_Ref'");
  $fetchReg  = mysqli_fetch_assoc($reg_info);

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
            <li> <a href="dashboard"><i class="fa-solid fa-table-columns" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li> <a href="transfer"><i class="fa-solid fa-arrow-right-arrow-left" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li> <a href="manage-bene"><i class="fa-solid fa-list-check" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li> <a href="transfer"> <i class="fa-solid fa-wallet" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li> <a href="#" onclick="statement();"> <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
            <li> <a href="mortgage"><i class="fa-solid fa-chart-column text-primary" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
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
            <li> <a href="transfer"><i class="fa-solid fa-arrow-right-arrow-left" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Transfers</a></li>
            <li> <a href="manage-bene"><i class="fa-solid fa-list-check" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Beneficiaries</a></li>
            <li> <a href="transfer"> <i class="fa-solid fa-wallet" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Payments</a></li>
            <li> <a href="#" onclick="statement();"> <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>E-STATEMENT</a></li>
            <li class="bg-primary"> <a href="mortgage"><i class="fa-solid fa-chart-column" style="font-size: 20px;margin-left: 8px; color:orangered;"></i> Mortgage</a></li>
            <li> <a href="#" onclick="card()"><i class="fa-solid fa-credit-card" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Card</a></li>
            <li> <a href="settings"><i class="fa-solid fa-gear"  style="font-size: 20px;margin-left: 8px; color:orangered;"></i> Setting</a></li>
            <li> <a href="#"><i class="fa-solid fa-headset" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Support</a></li>
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
        <div style="position: relative;width:100%;height:auto; margin-top: 50px;">
          <iframe src="https://www.mortgagecalculator.net/embeddable/v2/?size=1" width="100%" frameborder="0" scrolling="yes" height="300"></iframe>               
          <iframe style="margin-top: 10px;" src="https://www.mortgagecalculator.net/embeddable/?id=1" width="100%" frameborder="0" scrolling="yes" height="280"></iframe>
        </div>
      </div>
    </div>
  </div> 
</div>
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



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="./controller/js/transfer.js"></script>
<?php require_once './includes/dash_footer.php'; ?>