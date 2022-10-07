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
if(isset($_POST['yes'])){
    $user_Ref = $_POST['userRef'];
    $deleteSql = mysqli_query($conn, "DELETE FROM users WHERE reg_Ref = '$user_Ref'");
    if($deleteSql){
        $sqlCheck = mysqli_query($conn, "SELECT * FROM OnBanking WHERE user_ref='$user_Ref'");
        if(mysqli_num_rows($sqlCheck)>0){
            $sqlOnDelete = mysqli_query($conn, "DELETE FROM OnBanking WHERE user_ref='$user_Ref'");
            if($sqlOnDelete){
                echo "<script>alert('Customer Details have been deleted successfully');window.location.href='./delete_cust.php'</script>";
            }else{
                echo "<script>alert('Customer failed to be deleted on OnBanking Table');window.location.href='./delete_cust.php'</script>";
            }
        }
    }else{
        echo "<script>alert('Customer failed to be deleted');window.location.href='./delete_cust.php'</script>";
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
                    <li> <a href="./edit_profile.php">EDIT PROFILE</a></li>
                    <li> <a href="./delete_cust.php" class="bg-danger">DELETE USER</a></li>
                    <li> <a href="./sign_out.php">SIGNOUT</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="column-large" id="col-large">
            <?php 
                if(isset($_GET['delete'])){
                    $user_ref = base64_decode($_GET['delete']);
                    ?>
                <form action="" method="POST" class="my-5 mx-auto text-center p-4 shadow-lg bg-light w-50 h-100 ">
                          <input type="hidden" name="userRef" value="<?php echo $user_ref?>" id="">
                        <p style="font-size: 15px; color: red; font-weight: bold">Are you show?</p>
                        <button type="submit" name="yes" class="btn btn-danger">YES</button>
                        <a href="./delete_cust.php" class="btn btn-sm btn-primary" style="width:50px;">NO</a>
                  
                </form>
            <?php }else{?>
            <form action="" method="post">
                <p>Search Result:<?=$search?> </p>
                <input type="text" name="users" id="name-Search" value="<?=$search?>" placeholder="Search Users here">
            </form>
            <table class="table table-striped  table-hover" id="searchShow">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>IMAGE</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>REG-DATE</th>
                        <th colspan="3">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $team = $search; 
                        $users = mysqli_query($conn,"SELECT * FROM users WHERE Names LIKE '%$team%' AND role='customer'  ORDER BY id DESC");
                        while ($row = mysqli_fetch_assoc($users)){?>
                    <tr>
                        <td><?=$sn++?></td>
                        <td><img style="width: 100px;" src="<?=$row['photo']?>" alt="image"></td>
                        <td><?=$row['Names']?></td>
                        <td><?=$row['email']?></td>
                        <td><?=$row['reg_date']?></td>
                        <td>
                            <a href="?delete=<?=base64_encode($row['reg_Ref'])?> " class="btn btn-sm btn-primary">DELETE</a>
                            <!-- <button id="blockTrans" value="" style="border: none" class="btn btn-sm btn-primary">
                            EDIT
                          </button>  -->
                        </td>
                    </tr>
                    <?php }?>;
                </tbody>
            </table>
            <?php } ?>
        </div>
    </div>   
</div>

<?php require_once '../includes/dash_footer.php'; ?>