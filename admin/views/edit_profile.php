<?php 
  require_once '../config/config.php';
  require_once '../includes/reg-header.php';

  
 
  $sn = 1;

  function timeIndicator2(){
    $hour = date('H');
    $dayTerm = ($hour > 17) ? "Evening" : (($hour > 12) ? "Afternoon" : "Morning");
    echo "Good " . $dayTerm;
    
  }

  //search query
  if(isset($_POST["search"])){
    $search = $_POST["users"]; 
  }else{
      $search = "";
  }
$name = $typ = $dob = $gen = $marit = $city = $zip = $ssn = $phone  = $email  = $work  = $kin  = $acc  = $curr = $date = $con = $checking = "";
$name_er = $typ_er = $dob_er = $gen_er = $marit_er = $city_er = $zip_er = $phone_er = $email_er = $work_er = $kin_er = $acc_er = $curr_er = $date_er   = $con_er = $checking_er = "";
  if(isset($_POST["update"])){
      $userRef = $_POST["userRef"];
      if(empty($_POST['names'])){
          $name_er = "Please enter a name";
      }else{
          $name = $_POST['names'];
          if(!preg_match("/^[a-zA-Z-' ]*$/",$name)){
            $name_er = "Only letters and whitespaces are allowed";
          }else{
              $cleanNames = $name;
          }
      }
      if(empty($_POST['type'])){
          $typ_er = "Please enter Account Type";
      }else{
          $typ = $_POST['type'];
      }
      if(empty($_POST['dob'])){
          $dob_er = "This Field is required";
      }else{
          $dob = $_POST['dob'];
      }
      if(empty($_POST['gender'])){
          $gen_er = "This field is required";
      }else{
          $gen = $_POST['gender'];
      }
      if(empty($_POST['marital'])){
          $marit_er = "this field is required";
      }else{
          $marit = $_POST['marital'];
      }
      if(empty($_POST['city'])){
          $city_er = "this field is required";
      }else{
          $city = $_POST['city'];
      }
      if(empty($_POST['zip'])){
          $zip_er = "this field is required";
      }else{
          $zip = $_POST['zip'];
      }
      if(empty($_POST['ssn'])){
          
      }else{
          $ssn = $_POST['ssn'];
      }
      if(empty($_POST['phone'])){
        $phone_er = "this field is required";
      }else{
          $phone = $_POST['phone'];
      }
      if(empty($_POST['email'])){
          $email_er = "this field is required";
      }else{
          $email = $_POST['email'];
          if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
              $email_er = "Please Enter a valid Email Address";
          }
      }
      if(empty($_POST['work'])){
          $work_er = "This field is required";
      }else{
          $work = $_POST['work'];
      }
      if(empty($_POST['kin'])){
          $kin_er = "This field is required";
      }else{
          $kin = $_POST['kin'];
      }
      if(empty($_POST['currencies'])){
          $curr_er = "This field is required";
      }else{
          $curr = $_POST['currencies'];
      }
      if(empty($_POST['acc'])){
          $acc_er = "This field is required";
      }else{
          $acc = $_POST['acc'];
      }
      if(empty($_POST['date'])){
          $date_er = "This field is required";
      }else{
          $date = $_POST['date'];
      }
      if(empty($_POST['country'])){
          $con_er = "This field is required";
      }else{
          $con = $_POST['country'];
      }
      if(empty($_POST['checking'])){
        $checking_er = "This Field is required";
      }else{
        $checking = $_POST['checking'];
      }
      if(empty($name_er) && empty($typ_er) && empty($dob_er) && empty($gen_er) && empty($marit_er) 
      && empty($city_er) && empty($zip_er) && empty($phone_er) && empty($email_er) && empty($work_er)
      && empty($kin_er) && empty($acc_er) && empty($curr_er) && empty($date_er) && empty($con_er) && empty($checking_er)){
        $updateSql = mysqli_query($conn,"UPDATE users SET Names='$name', acc_Type='$typ',dob='$dob',
        gender='$gen',marital='$marit',country='$con',city='$city',zip='$zip',ssn='$ssn',phone='$phone',
        email='$email',work='$work',kin='$kin',Sav_Acc_No='$acc',Check_Acc_No='$checking' currency='$curr',reg_date='$date' WHERE reg_Ref='$userRef'");
        if($updateSql){
            echo "<script>alert('Customer Profile has been Updated successfully');window.location.href='./edit_profile.php'</script>";
        }else{
            echo "<script>alert('Customer Profile failed to be updated successfully')</script>";
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
                                <h4 class="cust-Name"><?=$_SESSION['admin']['username']?></h4>
                            </div>
                        </div>
                    </div>
                    <ul class="list-items" >
                    <li> <a href="./dashboard.php">USERS</a></li>
                    <li> <a href="./history.php">ACCOUNT HISTORY</a></li>
                    <li> <a href="./codes.php">BILLING CODES</a></li>
                    <li> <a href="./transfer_restrict.php">BLOCK/OPEN TRANSFER</a></li>
                    <li> <a href="./activate.php">ACTIVATE ACC</a></li>
                    <li> <a href="./edit_profile.php" class="bg-danger">EDIT PROFILE</a></li>
                    <li> <a href="./delete_cust.php">DELETE USER</a></li>
                    <li> <a href="./sign_out.php">SIGNOUT</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="column-large" id="col-large">
            <div class="edit_history">
                <?php 
                    if(isset($_GET['profile'])){
                        $user_ref = base64_decode($_GET['profile']);
                        $country = mysqli_query($conn, "SELECT * FROM country");
                        $sql = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user_ref'");
                        $fetch = mysqli_fetch_assoc($sql);
                        ?>
                    <form action="" method="POST" class="my-5 mx-auto p-4 shadow-lg bg-light w-50 h-100">
                        <input type="hidden" name="userRef" value="<?php echo $user_ref?>" id="">
                        <label for="">Account Name</label>
                        <input type="text" name="names" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['Names']?>">
                        <span class="d-block text-danger"><?=$name_er?></span>
                        <label for="">Account Type</label>
                        <input type="text" name="type" class="form-control form-control-sm w-100 my-3" placeholder="Account Type" value="<?=$fetch['acc_Type']?>">
                        <span class="d-block text-danger"><?=$typ_er?></span>
                        <label for="">DOB(Date of Birth)</label>
                        <input type="text" name="dob" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['dob']?>">
                        <span class="d-block text-danger"><?=$dob_er?></span>
                        <label for="">Gender</label>
                        <input type="text" name="gender" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['gender']?>">
                        <span class="d-block text-danger"><?=$gen_er?></span>
                        <label for="">Marital Status</label>
                        <input type="text" name="marital" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['marital']?>">
                        <span class="d-block text-danger"><?=$marit_er?></span>
                        <select name="country" id="" class="form-control form-control-sm w-100">
                            <option value="">Select Country</option>
                            <?php while($rowCon = mysqli_fetch_array($country)){?>
                                <option value="<?=$rowCon['name']?>"><?=$rowCon['name']?></option>
                        <?php  }?>
                        </select>
                        <span class="d-block text-danger"><?=$con_er?></span>
                        <label for="">City</label>
                        <input type="text" name="city" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['city']?>">
                        <span class="d-block text-danger"><?=$city_er?></span>
                        <label for="">Zip Code</label>
                        <input type="text" name="zip" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['zip']?>">
                        <span class="d-block text-danger"><?=$zip_er?></span>
                        <label for="">SSN(Social Security)</label>
                        <input type="text" name="ssn" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['ssn']?>">
                        <label for="">Phone Number</label>
                        <input type="text" name="phone" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['phone']?>" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        <span class="d-block text-danger"><?=$phone_er?></span>
                        <label for="">Email Address</label>
                        <input type="text" name="email" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['email']?>">
                        <span class="d-block text-danger"><?=$email_er?></span>
                        <label for="">Occupation</label>
                        <input type="text" name="work" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['work']?>">
                        <span class="d-block text-danger"><?=$work_er?></span>
                        <label for="">Next Of Kin</label>
                        <input type="text" name="kin" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['kin']?>">
                        <span class="d-block text-danger"><?=$kin_er?></span>
                        <label for="">Checking Account</label>
                        <input type="text" name="checking" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['Check_Acc_No']?>" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        <span class="d-block text-danger"><?=$checking_er?></span>
                        <label for="">Saving Account</label>
                        <input type="text" name="acc" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['Sav_Acc_No']?>" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                        <span class="d-block text-danger"><?=$acc_er?></span>
                        <select name="currencies" id="">
                            <option value="">Select Currency</option>
                            <option value="$">Dollar</option>
                            <option value="€">Euro</option>
                            <option value="£">Pound</option>
                        </select>
                        <span class="d-block text-danger"><?=$curr_er?></span>
                        <label for="">Registration Date</label>
                        <input type="text" name="date" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['reg_date']?>">
                        <span class="d-block text-danger"><?=$date_er?></span>
                        <div class="buttons-container mx-auto w-75 d-flex">
                            <a href="./edit_profile.php" class="btn btn-info mx-auto w-75">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-auto w-75" name="update">Update</button>
                        </div>
                    
                    </form>
            
                <?php }else{?>
                    <form action="" method="post">
                        <p>Search Result:<?=$search?> </p>
                        <input type="text" name="users" id="edit-Search" value="<?=$search?>" placeholder="Search Users here">
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
                                $users = mysqli_query($conn,"SELECT * FROM users WHERE Names LIKE '%$team%' AND role='customer' ORDER BY id DESC");
                                while ($row = mysqli_fetch_assoc($users)){?>
                                <tr>
                                    <td><?=$sn++?></td>
                                    <td><img style="width: 100px;" src="<?=$row['photo']?>" alt="image"></td>
                                    <td><?=$row['Names']?></td>
                                    <td><?=$row['email']?></td>
                                    <td><?=$row['reg_date']?></td>
                                    <td>
                                        <a href="?profile=<?=base64_encode($row['reg_Ref'])?> " class="btn btn-sm btn-primary">EDIT</a>
                                        <!-- <button id="blockTrans" value="" style="border: none" class="btn btn-sm btn-primary">
                                        EDIT
                                    </button>  -->
                                    </td>
                                </tr>
                            <?php }?>;
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>   
</div>

<style>
    label{
        text-transform: uppercase;
        font-weight: bold;
        color: #000;
    }
   
</style>

<?php require_once '../includes/dash_footer.php'; ?>