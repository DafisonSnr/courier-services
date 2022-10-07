<?php
require_once './includes/reg-header.php';
require_once './config/config.php';
$user_ref = $_SESSION['user']['user_ref'];

$brokSql = mysqli_query($conn, "SELECT * FROM brook_beneficiary WHERE cust_Ref='$user_ref'");
$otherSql = mysqli_query($conn, "SELECT * FROM other_beneficiary WHERE cust_Ref='$user_ref'");



?>

<div class="container-fluid">
    <div class="bank-back-container" id="bank-back">
        <div class="bank-container" id="bankCon" style="display:block!important" >
            <!-- <span class="close-ben-btn" onclick="window.location.reload();">&times</span> -->

            <div class="buttons-show mt-3">
                <button id="brok-Btn" onclick="brokFunction()">WELLSPRING</button>
                <button id="other-Btn" class="second-Btn" onclick="otherFunction()" style="color: black;background-color: #fff;">OTHER BANK</button>
            </div>
            <div class="beneficiareis">
                <div class="brookline" >
                    <br>
                    <select name="brook" id="showBrook" onchange="showUsers()" style="display: block;">
                        <option value="" >Select Beneficiary</option>
                        <?php while ($row1 = mysqli_fetch_assoc($brokSql)){?>
                            <option value="<?=$row1['beneficiary_Ref']?>"><?=$row1['name']."-".$row1['acc_Num']?> </option>
                        <?php }?>
                    </select>
                    <span id="showTxt"></span>
                </div>
                <div class="others" id="">
                    <select name="other" id="showOther" onchange="showOtherUsers()" style="display: none;">
                        <option value="">Select Beneficiary</option>
                        <?php while($row = mysqli_fetch_assoc($otherSql)){?>
                            <option  value="<?=$row['id']?>"><?=$row['name']."-".$row['acc_Num']?></option>
                        <?php   }?>
                    </select>
                    <span id="showOtherTxt"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="./js/transfer.js"></script> -->
<?php require_once './includes/dash_footer.php'?>