<?php 
  require_once '../config/config.php';
  require_once '../includes/reg-header.php';
$id = base64_decode($_GET['id']) ;

$name = $acc = $bank = $amt = $currency = $accTyp = '';
$name_er = $acc_er = $bank_er = $amt_er = $cur_er ='';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $user_ref = $_POST['user_id'];

 if(empty($_POST['name'])){
    $name_er = "This field is required";
 }else{
   $name = $_POST['name'];
 }
 if(empty($_POST['account'])){
    $acc_er = "This field is required";
 }else{
   $acc = $_POST['account'];
 }
 if(empty($_POST['bank'])){
    $bank_er = "This field is required";
 }else{
   $bank = $_POST['bank'];
 }
 if(empty($_POST['amount'])){
    $amt_er = "This field is required";
 }else{
   $commas = "/,/";
   $amount = $_POST['amount'];
   $amt = preg_replace($commas, "",$amount);
 }
 if($_POST['currency'] == 'NULL'){
    $cur_er = "This field is required";
 }else{
   $currency = $_POST['currency'];
 }
 
 if(empty($name_er)&&empty($acc_er)&&empty($bank_er)&&empty($amt_er)&&empty($cur_er)){
     $rec_Acc = $_POST['account_type'];
   $tran_Ref = "TRAN".rand(0000000,999999);
   $tran_Typ = "Credit";
    $stmt = $conn->prepare("INSERT INTO acc_history(user_ref,tran_Ref,beneficiary_name,beneficiary_acc,beneficiary_bank,currency,amt,Tran_Typ,Rec_Acc)VALUES(?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('sssssssss',$user_ref, $tran_Ref,$name,$acc,$bank,$currency,$amt,$tran_Typ,$rec_Acc);
    $stmt->execute();
    if(mysqli_affected_rows($conn)>0){
      echo "<script>alert('Transfer successful');</script>";
    }else{
      echo "failed";
    } 
  }
}
?>

<div class="container">
  <div class="form-tran-container p-5">
    <form action="" method="post" >
      <select name="account_type" id="" required>
        <?php
          $checkAcc = mysqli_query($conn,"SELECT * FROM users WHERE reg_Ref='$id'");
          if(mysqli_num_rows($checkAcc)>0){
            $fetchAcc = mysqli_fetch_assoc($checkAcc);
          }
        ?>
        <option value="" selected>Select Account</option>
        <option value="<?=$fetchAcc['Sav_Acc_No']?>">Savings-<?=$fetchAcc['Sav_Acc_No']?></option>
        <option value="<?=$fetchAcc['Check_Acc_No']?>">Checking-<?=$fetchAcc['Check_Acc_No']?></option>
        <option value="Loan">Loan</option>
      </select>
        <input type="hidden" name="user_id" value="<?=$id?>">
        <label for="">Account Name</label>
        <input type="text" name="name" id="" >
        <span class="text-danger"><?=$name_er?></span>
        <label for="">Account Number</label>
        <input type="text" name="account" id="" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
        <span class="text-danger "><?=$acc_er?></span>
        <label for="">Bank Name</label>
        <input type="text" name="bank" id="">
        <span class="text-danger"><?=$bank_er?></span>
        <label for="">Amount</label>
        <input type="text" name="amount" id="amt">
        <span class="text-danger"><?=$amt_er?></span>
        <select name="currency" id="">
          <option value="NULL" selected>Select Currency</option>
          <option value="$">Dollar</option>
          <option value="€">Euro</option>
          <option value="£">Pound</option>
        </select>
        <span class="text-danger"><?=$cur_er?></span>
        <div class="buttons-container">
          <a href="./dashboard.php">Cancel</a>
          <button type="submit"  class="send">Transfer</button>
        </div>
    </form>
  </div>
</div>
<script>
  let amt = document.getElementById("amt");
  amt.onkeyup = function(){
    // alert("it fines in here")
    var currentVal = $(this).val();
      var testDecimal = testDecimals(currentVal);
      if (testDecimal.length > 1) {
          $("#amt_error").html("You cannot enter more than one decimal point");
          currentVal = currentVal.slice(0, -1);
      }else{
          $("#amt_error").html("");
      }
      $(this).val(replaceCommas(currentVal));
  }
  // $('#amt').keyup(function (event) {
  //     // skip for arrow keys
  //     if (event.which >= 37 && event.which <= 40) {
  //         event.preventDefault();
  //     }
      
  //     var currentVal = $(this).val();
  //     var testDecimal = testDecimals(currentVal);
  //     if (testDecimal.length > 1) {
  //         $("#amt_error").html("You cannot enter more than one decimal point");
  //         currentVal = currentVal.slice(0, -1);
  //     }else{
  //         $("#amt_error").html("");
  //     }
  //     $(this).val(replaceCommas(currentVal));
  // });
  
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
<script src="../js/script.js">
  
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>