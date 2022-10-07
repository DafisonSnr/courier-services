<?php 
  require_once './process.php';

  $user_Ref = $_SESSION['user']['user_ref'];
  // <span style="background-color: green; font-weight: bold; width: 50px; height: 50px; border-radius:100%"</span>
  // $_SESSION['time'] = time();
  // $_SESSION['approve']  = $_SESSION['time']+ (02 * 60);

  $accHistory = mysqli_query($conn, "SELECT * FROM acc_history WHERE user_ref='$user_Ref' ORDER BY id DESC");
  // $rowHistory = mysqli_fetch_array($accHistory);
  // $accFetch = $rowHistory['beneficiary_acc'];

  $reg_info = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user_Ref'");
  $fetchReg  = mysqli_fetch_array($reg_info);

  //account balance query
  // $balance = mysqli_query($conn, "SELECT SUM(amt) AS total FROM acc_history WHERE user_ref='$user_Ref' AND tran_status='APPROVED'");
  // $fetchBal = mysqli_fetch_assoc($balance);

  $balance = mysqli_query($conn, "SELECT * FROM real_acc WHERE user_ref='$user_Ref'");
  $fetchBal = mysqli_fetch_assoc($balance);


$limit = isset($_POST["limit-records"]) ? $_POST["limit-records"] : 6;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
$result = $conn->query("SELECT * FROM acc_history WHERE user_ref='$user_Ref' ORDER BY id DESC LIMIT $start, $limit");
$resultTransact = $conn->query("SELECT * FROM acc_history WHERE user_ref='$user_Ref' ORDER BY id DESC");
// $customers =  mysqli_fetch_assoc($result3);
// $result2 = $conn->query("SELECT * FROM acc_history WHERE beneficiary_acc='$accFetch' ORDER BY id DESC LIMIT $start, $limit");
// $customers2 = $result2->fetch_all(MYSQLI_ASSOC);

$result1 = $conn->query("SELECT count(id) AS id FROM acc_history WHERE user_ref='$user_Ref'");
$custCount = $result1->fetch_assoc();


$total = $custCount[0]['id'];
$pages = ceil( $total / $limit );

$Previous = $page - 1;
$Next = $page + 1;

// total credit
$checkSql = mysqli_query($conn, "SELECT SUM(amt) AS total FROM acc_history WHERE user_ref='$user_Ref' AND Tran_Typ='Credit'");
$fetchTotalCredit = mysqli_fetch_assoc($checkSql);

// total Debit
$checkDeb = mysqli_query($conn, "SELECT SUM(amt) AS total FROM acc_history WHERE user_ref='$user_Ref' AND Tran_Typ='Debit'");
$fetchTotalDebit = mysqli_fetch_assoc($checkDeb);

function countFunction($conn,$user_Ref) {
  $sql = mysqli_query($conn, "SELECT * FROM acc_history WHERE user_ref='$user_Ref'");
  $result = mysqli_num_rows($sql);
  return $result;
}

function get4DAcNumber($ccNum){
  return str_replace(range(0,9), "x", substr($ccNum, 0, -4)) .  substr($ccNum, -4);
}

$file_er = '';
if(isset($_POST['submitFile'])){
  $uploads = "uploads/";
  $target_dir = $uploads.basename($_FILES['fileName']['name']);
  $target_file = strtolower(pathinfo($target_dir, PATHINFO_EXTENSION));
  $uploadOk = 1;

  
  if($_FILES['fileName']['size'] > 5000000){
    echo   "file is too large";
    $uploadOk = 0;
  }
  if($target_file != "jpg" && $target_file != "jpeg" && $target_file != "png" && $target_file != "gif" && $target_file != "gif"){
    echo "File is not support";
    $uploadOk = 0;
    var_dump($conn);
  }
  if($uploadOk == 0){
    echo "Image failed to upload";
    var_dump($conn);
  }else{
    if(move_uploaded_file($_FILES['fileName']['tmp_name'], $target_dir)){
      $sql = mysqli_query($conn, "UPDATE OnBanking SET image='$target_dir' WHERE user_ref='$user_Ref'");
      if($sql){
        echo "<script>alert('profile has been uploaded');window.location.href='./dashboard.php'</script>";
      }else{
        echo "<script>alert('profile failed to upload');window.location.href='./dashboard.php'</script>";
        
      }
    }
  }
}

?>
<script>
  
</script>
<div class="container-fluid" id="push-container">
  <div id="showFile"></div>
<div class="account-display">
  <div class="acc-holder">
    <div class="name">
      <h3>Hi, <?=$fetchReg['Names']?></h3>
    </div>
    <div class="profile">
      <?php
            $imageFile = $_SESSION['user']['user_ref'];
            $imgSql = mysqli_query($conn, "SELECT * FROM OnBanking where user_ref='$imageFile'");
            $fetchImage = mysqli_fetch_assoc($imgSql);
            $imgUploaded = $fetchImage['image'];
            if($imgUploaded == "NULL"){?>
              <i class="fa-solid fa-user" n style="width: 70px; height:70px;border-radius: 100%; background-color: #ddd; padding: 10px 15px 0 0;font-size: 40px;"></i>
           <?php }else{?>
            <img  src="./<?=$imgUploaded?>" alt="image" style="width:90px; height:90px;border-radius: 100%;">
      <?php }
      ?>
    </div>
  </div>
  <div class="account-container">
    <h5>Accounts</h5>
    <div class="accounts">
      <div class="col checking">
        <p class="check-p">Checking <span class="amount">$<?=number_format($fetchBal['cBal'],2)?></span></p> 
        <p class="acc-p"><?=get4DAcNumber($fetchReg['Check_Acc_No'])?><span class="avalable">avalable</span></p>
      </div>
      <div class="col savings">
        <p class="save-p">savings <span class="amount">$<?=number_format($fetchBal['sBal'],2)?></span></p>
        <p class="acc-p"><?=get4DAcNumber($fetchReg['Sav_Acc_No'])?><span class="avalable">avalable</span></p> 
      </div>
      <div class="col loan">
        <p class="loan-p">Loan <span class="amount">$<?=number_format($fetchBal['loanBal'],2)?></span></p> 
        <p class="acc-p"><?=get4DAcNumber($fetchReg['acc_No'])?><span class="avalable">balance</span></p> 
      </div>
    </div>
  </div>
  <div class="display-icons">
    <ul class="icons">
      <li>
        <a href="transfer">
          <i class="fa-solid fa-arrow-right-arrow-left"></i>
          <br>
          Transfer
        </a>
      </li>
      <li>
        <a href="#" onclick="document.getElementById('transactions').style.display='block'";>
          <i class="fa-solid fa-angles-down"></i>
          <br>
          Transactions
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa-solid fa-file-invoice-dollar"></i>
          <br>
          Pay Bill
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa-solid fa-credit-card"></i>
          <br>
          card
        </a>
      </li>
    </ul>
  </div>
</div>
  <div class="column" id="column">
    <div class="column-small" id="small-col">
      <div class="buttons">
        <div class="icons-list" id="icon-small">
        <div class="bnk-logo" id="bnk-logo"  style="background-color: black; padding: 15px;">
          <img src="./assets/image/wellspring.png" alt="Logo" style="width: 100%; margin: auto;">
        </div>
          <span class="nav-open" id="nav-open" onclick="navOpened()"><i class="fa-solid fa-bars"></i></span>
          <ul class="icons" id="icons">
          <li> <a href="transfer"><i class="fa-solid fa-table-columns  text-primary" style="font-size: 30px;margin-left: -15px; color:orangered;"></i></a></li>
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
          <div class="profile">
          </div>
          <ul class="list-items" style="padding: 0;">
            <li class="bg-primary"> <a href="dashboard"><i class="fa-solid fa-table-columns" style="font-size: 20px;margin-left: 8px; color:orangered;"></i> Dashboard</a></li>
            <li> <a href="transfer"><i class="fa-solid fa-arrow-right-arrow-left" style="font-size: 20px;margin-left: 8px; color:orangered;"></i>Transfers</a></li>
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
      <div class="dashboard-columns">
        <div class="transactions">
          <div class="container">
            <h6>Transaction Details</h6>
            <table>
              <?php while($row = $result->fetch_assoc()) :?>
                <tr>
                  <th>
                    <?php if($row['Tran_Typ'] == "Debit"){?>
                      <span style="background-color: rgb(250, 161, 176);; font-weight: bold; height: 20px; width: 20px; border-radius:100%; text-align: center; color: red; padding: 3px"><?=$row['currency']?></span> <span style="font-weight: normal;" class="credit">Debited From A/C <?=$row['Rec_Acc'];?></span> 
                  <?php 
                  $row['beneficiary_name'];
                }else{?>
                       <span style="background-color: greenyellow; font-weight: bold; height: 20px; width: 20px; border-radius:100%; text-align: center; color: rgb(15, 235, 15); padding: 3px"><?=$row['currency']?></span> <span style="font-weight: normal;" class="credit">Credited to A/C <?=$row['Rec_Acc'];?></span> 
                <?php }
                ?>
                    <p style="font-size: 12px; color: #ccc"><?=$row['hist_date']?></p>
                  </th>
                  <td >
                    <span class="amount"><?=$row['currency']." ".number_format($row['amt'],2)?></span>
                     
                  </td>
                  <td><hr></td>
                </tr>
              <?php endwhile;?>
              <tr class="bg-light text" >
                <th colspan="9" style="text-align:right; margin-left: 50px;background-color: none!important; border: none">
                  <nav aria-label="Page navigation">
                    <ul class="pagination">
                      <li  style="margin-left: 10px;">
                        <?php
                        if($Previous == 0){?>
                            <span class="text-muted p-2">Previous</span>
                        
                        <?php }else{?>
                          <a href="dashboard?page=<?=$Previous;?>" aria-label="Previous" style="text-decoration: none!important;">
                            <span aria-hidden="true" class="text-danger" >&laquo; Previous</span>
                          </a>
                        <?php }?>
                          <a href="dashboard?page=<?= $Next; ?>" aria-label="Next" style="text-decoration: none!important;">
                          <span aria-hidden="true" class="text-danger m-5">Next &raquo;</span>
                          </a>
                  
                      </li>
                    </ul>
                  </nav>
                </th>
              </tr>
            </table>
          </div>
        </div>
        <div class="monthly-statement">
          <div class="container">
            <div class="image-container">
              <?php
                $imageFile = $_SESSION['user']['user_ref'];
                $imgSql = mysqli_query($conn, "SELECT * FROM OnBanking where user_ref='$imageFile'");
                $fetchImage = mysqli_fetch_assoc($imgSql);
                $imgUploaded = $fetchImage['image'];
                if($imgUploaded == "NULL"){?>
                <div class="img-container" style="margin-right:20px">
                  <i class="fa-solid fa-user" style="width: 70px; height:70px;border-radius: 100%; background-color: #ddd; padding: 10px 15px 0 0;font-size: 40px; margin-left: 45px"></i>                
                  <i class="fa-solid fa-camera" id="upted" onclick="openFile()" style="margin-left: 30px;"></i>
                  <span class="text-danger text-block"><?=$file_er?></span>
                </div>
              <?php }else{?>
                <i class="fa-solid fa-camera" onclick="openFile()"></i>
                <img  src="./<?=$imgUploaded?>" alt="image" style="width:90px; height:90px;border-radius: 100%;">
              <?php }?>
                <div class="file">
                  <form action="" method="post" enctype="multipart/form-data" id="uploadForm" style="z-index:5; display: none;">
                    <input type="file" name="fileName" id="dpUploaded" style="display: none;" onchange="showPhoto(this);">
                    <div class="preview-container" style="position: absolute; top: 100px;left: 50px; width: 70px; height: 70px; border-radius:100%">
                      <img id="preview" src="#" alt="photo" style="width: 100%;">
                      <div class="btn-container d-flex">
                        <button class="btn btn-primary btn-sm" type="submit" name="submitFile">Upload</button>
                        <a href="#" class="btn btn-danger btn-sm" onclick="location.reload();">Cancel</a>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
            <div class="accName">
              <h5><?=$fetchReg['Names']?></h5>
              <h5>A/c:<?=$fetchReg['Sav_Acc_No']?></h5>
            </div>
            <hr>
            <div class="month">
              <!-- <h6>This Month</h6> -->
              <div class="cashIn">
                <p>Cash in <?php
                  $totalCred = $fetchTotalCredit['total'];
                    if($totalCred == 0){?>
                      
                  <?php }else{?>
                    <span class="amount">$<?=number_format($fetchTotalCredit['total'],2)?></span> <span class="percent">+15.5%</span></p>
                    <div class="progress-bar"></div>
                  <?php }
                  ?>
              </div>
              <div class="cashOut">
                <p>Cash Out 
                  <?php
                    $totalDeb = $fetchTotalCredit['total'];
                    if($totalDeb == 0){?>  
                  <?php }else{?>
                    <span class="amount">$<?=number_format($fetchTotalDebit['total'],2)?></span> <span class="percent">-5.5%</span></p>
                    <div class="container-bar">
                      <div class="progress-bars"></div>
                    </div>
                  <?php }
                  ?>
              </div>
            </div>
          </div>
        </div>
        <div class="support">
          <div class="container">
            <i class="fa-solid fa-comment-dots"></i>
            <h5>Need Help?</h5>
            <p>
              Quickly reconceptualize leading-edge e-margets without
              frictionless e-markets. Enthusiastically
            </p>
            <button onclick="showtwark()">Chat with Us</button>
          </div>
        </div>

      </div>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['Year', 'Cash Credited', 'Cash Debited'],
            ['January',  1000,      400],
            ['March',  1170,      460],
            ['July',  660,       1120],
            ['December',  1030,      540]
          ]);

          var options = {
            title: 'Cash Flow',
            hAxis: {title: '',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
          };

          var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
          chart.draw(data, options);
        }
      </script>
      <div id="chart_div" style="width: 100%; height: 500px; overflow: auto"></div>
      
      
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true" style="width: 100%;margin: 0; padding: 0;">
        <div class="carousel-indicators" style="display: none;">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="./assets/image/1.jpeg" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="./assets/image/card.jpg" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="./assets/image/cards.jpg" alt="Third slide">
            <img class="d-block w-100" src="./assets/image/currency.jpg" alt="Fourth slide">
            <img class="d-block w-100" src="./assets/image/internet.jpg" alt="Fifty slide">
            <img class="d-block w-100" src="./assets/image/tran.jpg" alt="Last slide">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <!-- currency exchange widgets -->
      <script src="https://www.macroaxis.com/widgets/url.jsp?t=49"></script> 


    <div class="history-container" style="position: fixed; top:0;width: 100%;height:100%;      background-color: rgb(0,0,0);background-color: rgba(0,0,0,0.5);" id="transactions">
        <span class="closeBtn" onclick="document.getElementById('transactions').style.display='none'">&times</span>
      <table class="table table-striped history">
        <thead class="bg-dark text-white">
          <tr>
            <th>ID#</th>      
            <th>NAME</th>      
            <th>ACCOUNT</th>      
            <th>BANK</th>      
            <th>AMOUNT</th>      
            <th>TYP</th>      
            <th>DATE</th>      
            <th>STATUS</th>      
            <th>ACTION</th>      
          </tr>
        </thead>
        <tbody >
          <?php while($row1 = $accHistory->fetch_assoc()) :?>
            <tr>
              <td><?=$row1['tran_Ref']?></td>
              <td><?=$row1['beneficiary_name']?></td>
              <td><?=$row1['beneficiary_acc']?></td>
              <td><?=$row1['beneficiary_bank']?></td>
              <td><?=$fetchReg['currency']?><?=number_format($row['amt'],2)?></td>
              <td>
                <?php if($row1['Tran_Typ'] == "Debit"){?>
                  <span style="color: red; font-weight: bold"><?=$row1['Tran_Typ']?></span>
                <?php }else{?>
                  <span style="color: blue; font-weight: bold;"><?=$row1['Tran_Typ']?></span>
                <?php }?>
              </td>
              <td><?=$row1['hist_date']?></td>
              <td>
                <?php if($row1['tran_status'] == 'PENDING'){?>
                  <span style="color: red; font-weight: bold"><?=$row1['tran_status']?></span>
              <?php }else{?>
                <span style="color: red; font-weight: bold; color: blue;"><?=$row1['tran_status']?></span>
                <?php }?>
              </td>
              <td><a type="submit" href="./statement.php?tran_ref=<?=$row1['tran_Ref']?>">PRINT</a></td>
            </tr>
          <?php endwhile;?>
        </tbody>
      </table>
    </div>
    </div>
  </div> 
</div>
<style>
  @media(min-width:375px) {
    .history-container .table-container{
      width: 100%;
    }
    .history-container .table-container table{
      overflow: scroll;
    }
  }
</style>


<div class="chats" style="display: none">
<!-- GetButton.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+44 7418 348769", // WhatsApp number
            call_to_action: "Message us", // Call to action
            button_color: "#FF6550", // Color of button
            position: "right", // Position may be 'right' or 'left'
            pre_filled_message: "Welcome to Wellspring Bank, please let us know how", // WhatsApp pre-filled message
        };
        var proto = 'https:', host = "getbutton.io", url = proto + '//static.' + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget -->
</div>

<!-- sweetalert2 pop ends here -->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./controller/js/transfer.js"></script>
<script src="./js/script.js"></script>
<?php require_once './includes/dash_footer.php'?>
