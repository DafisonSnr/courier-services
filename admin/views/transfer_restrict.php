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
    
if(isset($_POST["yes"])){
    $userRef = $_POST["userRef"];
    $sql = mysqli_query($conn, "SELECT * FROM restriction WHERE user_Ref='$userRef'");
    $rowFetch = mysqli_fetch_assoc($sql);
    if($rowFetch['switch_Code'] == 'YES'){
        $sql = mysqli_query($conn, "UPDATE restriction SET switch_Code='NO' WHERE user_Ref='$userRef'");
        if($sql){
            echo "<script>alert('transfer has been unblocked');window.location.href='transfer_restrict.php'</script>";
        }else{
            echo "<script>alert('transfer could not be unblocked');window.location.href='transfer_restrict.php'</script>";
        }
    }else{
        $sql = mysqli_query($conn, "UPDATE restriction SET switch_Code='YES' WHERE user_Ref='$userRef'");
        if($sql){
            echo "<script>alert('transfer has been restricted');window.location.href='transfer_restrict.php'</script>";
        }else{

        }
    }
    
}
if(isset($_POST['fYes'])){
    $userRef = $_POST['freezREf'];
    $freezeSql = "SELECT * FROM real_acc WHERE user_ref='$userRef'";
    $freezeConn = $conn->query($freezeSql);
    $fetchId = mysqli_fetch_assoc($freezeConn);
    if($fetchId['status'] == 'BLOCKED'){
        $sql = mysqli_query($conn, "UPDATE real_acc SET status='OPENED' WHERE user_ref='$userRef'");
        if($sql){
            echo "<script>alert('Account has been Un-Frozen');window.location.href='transfer_restrict.php'</script>";
        }else{
            echo "<script>alert('Account could not be Un-frozen');window.location.href='transfer_restrict.php'</script>";
        }
    }else{
        $sql = mysqli_query($conn, "UPDATE real_acc SET status='BLOCKED' WHERE user_ref='$userRef'");
        if($sql){
            echo "<script>alert('Account has been temporarily Frozen');window.location.href='transfer_restrict.php'</script>";
        }else{
            echo "<script>alert('Account could not be Frozen');window.location.href='transfer_restrict.php'</script>";
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
                    <li> <a href="./codes.php">BILLING CODES</a></li>
                    <li> <a href="#"class="bg-danger">BLOCK/OPEN TRANSFER</a></li>
                    <li> <a href="./activate.php">ACTIVATE ACC</a></li>
                    <li> <a href="./edit_profile.php">EDIT PROFILE</a></li>
                    <li> <a href="./delete_cust.php">DELETE USER</a></li>
                    <li> <a href="./sign_out.php">SIGNOUT</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="column-large " id="col-large">
            <?php if(isset($_GET['blocked']) || isset($_GET['freeze'])){?>
                <?php
                            if(isset($_GET['blocked'])){
                                $blockedRef = $_GET['blocked'];
                                ?>
                                <div class="form-container card bg-warning mx-auto my-5" style="width: 18em;">
                                    <form action="" method="post" enctype="multipart/form" class="card-body text-center" >
                                        <input type="hidden" name="userRef" id="" value="<?=$blockedRef?>">
                                        <p class="fs-4 text-white">Are You Sured</p>
                                        <input type="submit" name="yes" value="YES" class="btn btn btn-danger">
                                        <a href="./transfer_restrict.php" class="btn btn btn-info">NO</a>
                                    </form>
                                </div>
                           <?php }?>
                           <?php
                            if(isset($_GET['freeze'])){
                                $freezeRef = $_GET['freeze'];
                                ?>
                                <div class="form-container card bg-warning mx-auto my-5" style="width: 18em;">
                                    <form action="" method="post" enctype="multipart/form" class="card-body text-center" >
                                        <input type="hidden" name="freezREf" id="" value="<?=$freezeRef?>">
                                        <p class="fs-4 text-white">Are You Sure?</p>
                                        <input type="submit" name="fYes" value="YES" class="btn btn btn-danger">
                                        <a href="./transfer_restrict.php" class="btn btn btn-info">NO</a>
                                    </form>
                                </div>
                           <?php }?>
           <?php }else{?>
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
                           <?php ?>
                            <a href="?blocked=<?=$row['user_ref']?>" id="bloc"  style="border: none; background:none;" class="btn btn-sm" name="blockTrans">
                            <?php 
                            $user_Ref = $row['user_ref'];
                            $codes = mysqli_query($conn, "SELECT * FROM restriction WHERE user_Ref='$user_Ref'");
                            if(mysqli_num_rows($codes)>0){
                                $row1 = mysqli_fetch_assoc($codes);
                            }else{
                                echo "no users found";
                            }
                            
                            if($row1['switch_Code'] == 'YES'){?>
                                <span class="btn" style="background-color: red; border:none; color: white;font-weight:bold; cursor: pointer">RESTRICTED</span>
                            <?php  }else{?>
                                    <span style="background-color: blue ; color: white; border:none; font-weight: bold;padding: 10px 15px; cursor: pointer">UNRESTRICTED</span>
                            <?php }?>
                            </a> 
                        </td>
                        <td>
                           <?php ?>
                            <a href="?freeze=<?=$row['user_ref']?>" id="blo"  style="border: none; background:none;" class="btn btn-sm" name="blockTrans">
                            <?php 
                            $user_Ref2 = $row['user_ref'];
                            $code = mysqli_query($conn, "SELECT * FROM real_acc WHERE user_ref='$user_Ref2'");
                            if(mysqli_num_rows($code)>0){
                                $row2 = mysqli_fetch_assoc($code);
                            }else{
                                echo "no users found";
                            }
                            // INSERT INTO real_acc(user_ref,cBal,aBal,status) VALUES('REG-1027021',0.00,0.00,'BLOCKED')
                            if($row2['status'] == 'BLOCKED'){?>
                                <span class="btn" style="background-color: red; border:none; color: white;font-weight:bold; cursor: pointer">FREEZE</span>
                            <?php  }else{?>
                                    <span style="background-color: blue ; color: white; border:none; font-weight: bold;padding: 10px 15px; cursor: pointer">UNFREEZE</span>
                            <?php }?>
                            </a> 
                        </td>
                    </tr>
                    <?php }?>;
                </tbody>
            </table>
           <?php }?>
        </div>
    </div>   
</div>

<?php require_once '../includes/dash_footer.php'; ?>