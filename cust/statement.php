<?php

require_once './config/config.php';
require_once './includes/reg-header.php';

$tran_Id = $_GET['tran_ref'];
$sender = $_SESSION['user']['username'];
if(isset($_GET['tran_ref'])){
    $tran_Id = $_GET['tran_ref'];
}
    

$sql = mysqli_query($conn,"SELECT * FROM acc_history WHERE tran_Ref='$tran_Id'");
$row1 = mysqli_fetch_assoc($sql);

?>


    <div class="container-fluid">
        <div class="statement-container" id="statement" style="overflow: auto;" >
            <div class="statement-modal">
                <h3>Successful</h3>
                <div class="img-container">
                    <img src="./assets/image/checkmark2.png" alt="">
                </div>
                <h5>Transaction SuccessFul</h5>
                <hr>
                <ul>
                <li>Paid On <span><?=$row1['hist_date']?></span></li>
                <li>Sender <span><?=$sender?></span></li>
                <li>Beneficiary <span><?=$row1['beneficiary_acc']?></span></li>
                <li>Beneficiary Bank <span><?=$row1['beneficiary_bank']?></span></li>
                <li class="amt">Amount <span><?=$row1['amt']?></span></li>
                </ul>
                <button onclick="window.print()">Save</button>
                
            </div>
            <!-- <div class="spinner-container">
                dsf
                <div class="spinner-outer">
                    <div class="inner-spin-background">
                        
                    </div>
                </div>
            </div> -->
        </div>
        
        
    </div>
<style>
   
    .statement-container{
        width: 500px!important;
        margin: 0 auto;
        
    }
</style>


