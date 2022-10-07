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
    $loginActive = $_POST["activate"];
    $sql  = mysqli_query($conn, "SELECT * FROM OnBanking WHERE user_ref = '$loginActive'");
    if(mysqli_num_rows($sql)>0){
        $fetchUsers = mysqli_fetch_array($sql);
        if($fetchUsers['valid_user'] == "Pending"){
            $sql  = mysqli_query($conn, "UPDATE Onbanking SET valid_user='Approved' WHERE user_ref = '$loginActive'");
            if($sql == true){
                echo "<script>alert('Login has been approved');window.location.href='dashboard.php'</script>";
            }else{
                echo "<script>alert('Login failed');window.location.href='dashboard.php'</script>";
            }
        }else{
            $sql  = mysqli_query($conn, "UPDATE Onbanking SET valid_user='Pending' WHERE user_ref = '$loginActive'");
            if($sql == true){
                echo "<script>alert('Login has been suspended');window.location.href='dashboard.php'</script>";
            }else{
                echo "<script>alert('Login failed');window.location.href='dashboard.php'</script>";
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
                        <li> <a href="#" class="bg-danger">USERS</a></li>
                        <li> <a href="./history.php">ACCOUNT HISTORY</a></li>
                        <li> <a href="./codes.php">BILLING CODES</a></li>
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
                if(isset($_GET['login_activate'])){
                    $loginId = base64_decode($_GET['login_activate']);
                    ?>
                    <form action="" method="post" class="alert alert-info w-50 mx-auto text-center">
                        <input type="hidden" name="activate" value="<?=$loginId ?>">
                        <p>Are you Sure?</p>
                        <input type="submit" class="btn btn-danger btn-sm" name="yes" value="YES">
                        <a href="dashboard.php" class="btn btn-sm btn-info">NO</a>
                    </form>
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
                            <th colspan='2'>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $team = $search; 
                            $users = mysqli_query($conn,"SELECT * FROM OnBanking WHERE username LIKE '%$team%' AND role='customer' ORDER BY id DESC");
                            while ($row = mysqli_fetch_assoc($users)){?>
                        <tr>
                            <td><?=$sn++?></td>
                            <td><img style="width: 100px;" src="./<?=$row['image']?>" alt=""></td>
                            <td><?=$row['username']?></td>
                            <td><a href="./transfer.php?id=<?=base64_encode($row['user_ref'])?>" class='btn btn-primary' onclick="fund()">Fund</a></td>
                            <td><a href="?login_activate=<?=base64_encode($row['user_ref'])?>">
                                <?php
                                    $check = $row['user_ref'];
                                    $checkBase = mysqli_query($conn, "SELECT * FROM OnBanking WHERE user_ref='$check'");
                                    $fetchBase = mysqli_fetch_assoc($checkBase);
                                    if($fetchBase['valid_user'] == 'Pending'){?>
                                        <button class='btn btn-danger'>activate_Login</button>
                                <?php }else{?>
                                        <button class='btn btn-primary'>Login_activated</button>
                                    <?php  }
                                ?>
                                
                            </a>  
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            <?php }?>
        </div>
    </div>   
</div>



<?php require_once '../includes/dash_footer.php'; ?>