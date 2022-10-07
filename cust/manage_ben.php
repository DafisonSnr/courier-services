<?php
require_once './config/config.php';
require_once './process.php';
require_once './includes/reg-header.php';
$user = $_SESSION['user']['user_ref'];
$brookCount = 1;
$otherCount = 1;

$brookSql = mysqli_query($conn, "SELECT * FROM brook_beneficiary WHERE cust_Ref='$user'");
$otherSql = mysqli_query($conn, "SELECT * FROM other_beneficiary WHERE cust_Ref='$user'");

if(isset($_POST['yes'])){
  $userBrok = $_POST['userRef'];
  $brookSql = mysqli_query($conn, "DELETE  FROM brook_beneficiary WHERE beneficiary_Ref='$userBrok'");
  if($brookSql){
      echo  "<script>alert('Beneficiary Details have been deleted');window.location.href='./manage_ben.php';</script>";
  }else{
      echo "<script>alert('Beneficiary Details failed to be deleted');window.location.href='./manage_ben.php';</script>";
        $otheruUser = $_POST['userRef'];
  $sql = mysqli_query($conn, "DELETE FROM other_beneficiary WHERE beneficiary_Ref='$otheruUser'");
  if($sql){
      echo "<script>alert('Beneficiary Details have been deleted');window.location.href='./manage_ben.php';</script>";
  }else{
      echo "<script>alert('Beneficiary Details failed to be deleted');window.location.href='./manage_ben.php';</script>";
  }
  }
}

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
            <li> <a href="manage-bene"><i class="fa-solid fa-list-check text-primary" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
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
            <li> <a href="transfer"><i class="fa-solid fa-arrow-right-arrow-left" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Transfers</a></li>
            <li class="bg-primary"> <a href="manage-bene"><i class="fa-solid fa-list-check" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Beneficiaries</a></li>
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
      <div class="language" style="float: right; margin-top: 20px; width: 200px">
        <?php include './language.php'; ?>
      </div>
      <div class="back-dashboard">
        <a href="dashboard"><i class="fa-solid fa-arrow-left-long"></i></a> 
      </div>
      <?php 
        if(isset($_GET['delete']) || isset($_GET['brdelete'])){?>
          <div class="card mx-auto mt-5"  style="width: 18rem;">
            <form action="" method="post" class="card-body bg-warning text-center">
              <input type="hidden" name="userRef" value="<?php  if(isset($_GET['delete'])){
                echo $otherBen = base64_decode($_GET['delete']);
                }
                if(isset($_GET['brdelete'])){
                  echo  $userBrook = base64_decode($_GET['brdelete']);
                }?>">
                <p class="text-white fw-bold fs-5">Are you Sure?</p>
                <input type="submit" class="btn btn-danger btn-sm" value="YES" name="yes">
                <a href="./manage_ben.php" class="btn btn-primary btn-sm">NO</a>
            </form>
          </div>
      <?php }else{?>
        <div class="brook-beneficiaries mt-3 ms-3 w-100">
          <table  class="table table-striped">
            <thead>
              <tr class="bg-dark text-white">
                <th colspan="3">WELLSPRING BENEFICIARIES</th>
              </tr>
              <tr>
                <th>#</th>
                <th>ACC-NO</th>
                <th>NAME</th>
                <th>ACC-TYPE</th>
                <th>DATE</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if(mysqli_num_rows($brookSql) == 0){?>
                <tr>
                  <td colspan="5" class="text-center text-danger fw-bold">NO BENEFICIARY SAVED</td>
                </tr>
              <?php }else
              while ($row1 = mysqli_fetch_array($brookSql)){?> 
                <tr>
                  <td><?=$brookCount++?></td>
                  <td><?=$row1['acc_Num']?></td>
                  <td><?=$row1['name']?></td>
                  <td><?=$row1['acc_Type']?></td>
                  <td><?=$row1['saved_date']?></td>
                  <td><a href="?brdelete=<?=base64_encode($row1['beneficiary_Ref'])?>" class="btn btn-danger">Delete</a></td>
                </tr> 
              <?php }?>
            </tbody>
          </table>
        </div>
        <div class="other-beneficiaries mt-5 ms-3">
          <table  class="table table-striped">
            <thead>
              <tr class="bg-dark text-white">
                <th colspan="4">OTHER BENEFICIARIES</th>
              </tr>
              <tr>
                <th>#</th>
                <th>ACC-NO</th>
                <th>NAME</th>
                <th>BANK</th>
                <th>SWIFT</th>
                <th>ROUTING</th>
                <th>DATE</th>
                <th>ACTION</th>
              </tr>  
            </thead>
            <tbody>
              <?php 
                if(mysqli_num_rows($otherSql) == 0){?>
                <tr>
                    <td colspan="5" class="text-center text-danger fw-bold">NO BENEFICIARY SAVED</td>
                </tr>
              <?php }else
              while ($row = mysqli_fetch_array($otherSql)){?> 
                <tr>
                  <td><?=$brookCount++?></td>
                  <td><?=$row['acc_Num']?></td>
                  <td><?=$row['name']?></td>
                  <td><?=$row['bank']?></td>
                  <td><?=$row['swift']?></td>
                  <td><?=$row['routing']?></td>
                  <td><?=$row['saved_Date']?></td>
                  <td><a href="?delete=<?=base64_encode($row['beneficiary_Ref'])?>" class="btn btn-danger">Delete</a></td>
                </tr> 
              <?php }?>
            </tbody>
          </table>
        </div>
      <?php }?>
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
<?php require_once './includes/dash_footer.php'?>