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
                    <li> <a href="#" class="bg-danger">ACCOUNT HISTORY</a></li>
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
                        <th>ACTION</th>
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
                        <td><a href="./history_edit.php?edit=<?=base64_encode($row['user_ref'])?>" class="btn btn-primary">View</a></td>
                    </tr>
                    <?php }?>;
                </tbody>
            </table>
        </div>
    </div>   
</div>



<?php require_once '../includes/dash_footer.php'; ?>