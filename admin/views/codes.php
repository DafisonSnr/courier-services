<?php 
  require_once '../config/config.php';
  require_once '../includes/reg-header.php';
  require_once './process.php';
  
 
  $sn = 1;

  //search query
  if(isset($_POST["search"])){
    $search = $_POST["users"]; 
  }else{
      $search = "";
  }
  $amt_er = '';
  if(isset($_POST["updateAmt"])){
        $userRef = $_POST["userId"];
        $selectBill = $_POST["billing"];
        $amt = $_POST["amountInput"];
        $sql = mysqli_query($conn, "SELECT * FROM bill_Amt WHERE user_Ref = '$userRef' AND bill='$selectBill'");
        if(mysqli_num_rows($sql)<1){
            if(empty($_POST['amountInput'])){
                $amt_er = "Enter amount";
            }else{
                $sql = mysqli_query($conn, "INSERT INTO bill_Amt(user_Ref,bill,amount) VALUES('$userRef','$selectBill','$amt')");
                if($sql){
                    echo "<script>alert('Payment has been updated');</script>";
                }else{
                    echo "<script>alert('Payment failed to be updated');</script>";  
                }
            }
        }else{
            if(empty($_POST['amountInput'])){
                $amt_er = "Enter amount";
            }else{
                $sql = mysqli_query($conn, "UPDATE bill_Amt SET amount='$amt' WHERE user_Ref='$userRef' AND bill='$selectBill'");
                if($sql){
                    echo "<script>alert('Payment has been updated');</script>";
                }else{
                    echo "<script>alert('Payment failed to be updated');</script>";
                }
            }
        }
    }


?>

<div class="container-fluid">
    <div class="column" id="column">
        <div class="colum-small">
            <div class="buttons">
                <div class="menu-list" id="menu-list">
                    <div class="profile">
                        <div class="pic-container">
                            <div class="greetings">
                                <span class="tiemIndictor"><?=timeIndicator2()?></span>
                                <h4 class="cust-Name"><?=$fetch['Names']?></h4>
                            </div>
                        </div>
                    </div>
                    <ul class="list-items" >
                    <li> <a href="./dashboard.php">USERS</a></li>
                    <li> <a href="./history.php">ACCOUNT HISTORY</a></li>
                    <li> <a href="./codes.php" class="bg-danger">BILLING CODES</a></li>
                    <li> <a href="./transfer_restrict.php">BLOCK/OPEN TRANSFER</a></li>
                    <li> <a href="./activate.php">ACTIVATE ACC</a></li>
                    <li> <a href="./edit_profile.php">EDIT PROFILE</a></li>
                    <li> <a href="./delete_cust.php">DELETE USER</a></li>
                    <li> <a href="./sign_out.php">SIGNOUT</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="column-large" id="col-large">
            <?php
                if(isset($_GET['billing'])){
                    $userReference = base64_decode($_GET['billing']);
                ?>
                    <form action="" method="post">
                        <div class="container">
                            <div class="shadow-lg bg-light mx-auto p-4 mt-5 w-50">
                                <input type="hidden" name="userId" value="<?=$userReference?>">
                                <select name="billing" id="" class="form-control my-3" required>
                                    <option value="">Select Billing</option>
                                    <option value="tax"<?php echo(isset($_POST['billing']) && $_POST['billing'] == "tax")? "selected" : "";?>>TAX_code</option>
                                    <option value="atc" <?php echo(isset($_POST['billing']) && $_POST['billing'] == "atc")? "selected" : "";?>>ATC_code</option>
                                    <option value="imf" <?php echo(isset($_POST['billing']) && $_POST['billing'] == "imf")? "selected" : "";?> >IMF_code</option>
                                    <option value="cot" <?php echo(isset($_POST['billing']) && $_POST['billing'] == "cot")? "selected" : "";?>>COT_code</option>
                                </select>
                                <input type="text" name="amountInput" id="amtInput" class="form-control my-3" placeholder="Enter Amount">
                                <span id="amt_error" class="text-danger d-block"><?=$amt_er?></span>
                                <div class="submit-container mx-auto text-center">
                                    <a href="codes.php" class="btn btn-danger">CANCEL</a>
                                    <button class="btn btn-primary" name="updateAmt">UPDATE</button>
                                </div>
                            </div>
                        </div>
                    </form>
            <?php   }else{?>
                <form action="" method="post">
                    <p>Search Result:<?=$search?> </p>
                    <input type="text" name="users" id="user-Search" value="<?=$search?>" placeholder="Search Users here">
                    <button type="submit" name="search">Search</button>
                </form>
                <table class="table table-striped  table-hover" id="searchShow">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>IMAGE</th>
                            <th>USERNAME</th>
                            <th colspan="3">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $team = $search; 
                            $users = mysqli_query($conn,"SELECT * FROM OnBanking WHERE username LIKE '%$team%' AND role='customer' ORDER BY id DESC");
                            while ($row = mysqli_fetch_assoc($users)){?>
                        <tr>
                            <td><?=$sn++?></td>
                            <td><img style="width: 100px;" src="<?=$row['image']?>" alt="image"></td>
                            <td><?=$row['username']?></td>
                            <td>
                                <button id="codes" value="<?=$row['user_ref']?>" style="border: none">
                                <?php 
                                $user_Rf = $row["user_ref"];
                                $require_codes = mysqli_query($conn, "SELECT * FROM require_codes WHERE cust_id='$user_Rf'");
                                if(mysqli_num_rows($require_codes)<1){?>
                                        <span class="btn" style="background-color: blue; border:none; color: white; cursor: pointer">Generate Codes</span>
                            <?php  }else{?>
                                        <span style="background-color: none; color: red; border:none; font-weight: bold; cursor: normal">Code Generated</span>
                                <?php }?>
                            </button> 
                            </td>
                            <td><button class="btn btn-primary btn-sm" value="<?=$row['user_ref']?>" id="view">View-Codes</button></td>
                            <td><a href="?billing=<?=base64_encode($row['user_ref'])?>" class="btn btn-primary btn-sm" value="" id="billAmt">Bill-Amt</a></td>
                        </tr>
                        <?php }?>;
                    </tbody>
                </table>
                <div class="code-background">
                    <div id="showcodes"></div>
                </div>
            <?php }?>
        </div>
    </div>   
</div>

<script src="./js/script.js"></script>
<script>
  let amtInput = document.getElementById("amtInput");
  amtInput.onkeyup = function(){
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
<style>
    .code-background{
        display: none;
        position: absolute;
        top: 0px;
        width: 70%;
        margin: 0 auto;
    }
</style>

<?php require_once '../includes/dash_footer.php'; ?>