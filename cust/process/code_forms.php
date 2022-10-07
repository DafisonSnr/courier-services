<?php
    require_once '../config/config.php';
    require_once './includes/reg-header.php';
    $userRef = $_SESSION['user']['user_ref'];

    // fetch billing amount
    $sqlTax = mysqli_query($conn,"SELECT * FROM bill_Amt WHERE user_Ref= '$userRef' AND bill='tax'");
    $fetchTax = mysqli_fetch_assoc($sqlTax);

    $sqlatc = mysqli_query($conn,"SELECT * FROM bill_Amt WHERE user_Ref= '$userRef' AND bill='atc'");
    $fetchAtc = mysqli_fetch_assoc($sqlatc);

    $sqlImf = mysqli_query($conn,"SELECT * FROM bill_Amt WHERE user_Ref= '$userRef' AND bill='imf'");
    $fetchImf = mysqli_fetch_assoc($sqlImf);

    $sqlCot = mysqli_query($conn,"SELECT * FROM bill_Amt WHERE user_Ref= '$userRef' AND bill='cot'");
    $fetchCot = mysqli_fetch_assoc($sqlCot);
    // fetch billing amount ends here

    $sqlUsers = mysqli_query($conn,"SELECT * FROM users WHERE reg_Ref='$userRef'");
    $fetchUsers = mysqli_fetch_assoc($sqlUsers)
?>  
<style>
    .container-cot{
        width: 100%;
        margin: 150px 0;
    }
    input{
        width: 100%;
    }
    .submit{
        margin-top: 20px;
        background-color: blue;
        color: white;
    }
    span.closetn{
       display: none;
        position: absolute;
        top: -15px;
        right: 10px;
        font-size: 40px;
        float: right;
        color: black;
        cursor: pointer;
    }
    span.closetn:hover{
        color: red;
    }
    .cot-bill-container{
        width: 100%;
        text-align: left;
        padding: 0px;
        margin: -129px 0;
        font-size: 14px;
        color: rgb(8, 8, 78);
    }
    .cot-bill-container ul{
        text-align: left;
        margin: 0;
        padding: 0;
    }
    .cot-bill-container p,span{
        width: 100%;
        font-size: 14px;
    }
    .cot-bill-container ul li{
        list-style: none;
        padding: 5px 0;
    }
</style>
<div class="container-cot">
    <form action="" method="post" id="tax-form"  style="display: none">
        <div class="cot-bill-container">
            <p>
                Dear <span class="text-danger text-upper fw-bold" id="nameFetchTax"></span>, your transfer cannot be approved without a Government Validated <b>TAX code</b>(Excluding VAT) for foreign citizens.
            </p>
            <p>
                Your are transfering <span class="text-danger fw-bold">
                <?php 
                    if($fetchUsers['currency'] == "$"){
                        echo "USD ";
                    }elseif($fetchUsers['currency'] == "€"){
                        echo "EUR ";
                    }else{
                        echo "GBP ";
                    }
                ?></span><span id="fetchAmtTax" class="text-danger fw-bold"></span> from your  <span class="text-danger fw-bold" id="send_acc_tax"></span>
                to <span class="text-danger fw-bold" id="recNameTax"></span>
            </p>
            <p>Your Calculated <b>TAX Code</b> Payment is: <span class="text-danger fw-bold" id="fee"> 
                <?php 
                    if($fetchUsers['currency'] == "$"){
                        echo "USD ";
                    }elseif($fetchUsers['currency'] == "€"){
                        echo "EUR ";
                    }else{
                        echo "GBP ";
                    }
                ?><?=$fetchTax['amount'] ?? 0?></span>
            </p>
            <P class="fw-bold">Contact customer service via</P>
            <a href="mailTo:helpcenter@wellspringeu.com " class="btn btn-primary" style="margin-top: -10px">helpcenter@wellspringeu.com</a>
            <span class="fw-bold">for your TAX code payment</span>
        </div>
        <div class="submit-field" style="margin-top: 155px; text-align: center">
            <input type="hidden"  id="taxRef" value="<?php echo $userRef?>">
            <input type="text" class="form-control mx-auto" style="width: auto" id="tax" placeholder="Enter TAX code to continue">
            <span id="tax_error" class="text-danger d-block"></span> 
            <button type="submit" id="taxSubmit" class="submit" style="width: auto; margin-top: 4px">Confirm Code</button>
        </div>
    </form>
    <form action="" method="post" id="atc-form"  style="display: none;">
        <div class="anti-container">
            <style>
                .anti-container p,span{
                    font-size: 12.8px!important;
                }
            </style>
            <div class="cot-bill-container">
                <p>
                    Dear <span class="text-danger text-upper fw-bold" id="nameFetchAtc"></span>, The United States Department of Defense has sanctioned financial 
                    institutions to request <b>Anti Terrorism Approval Code</b> before approving international wire transactions.
                </p>
                <p>Department of Defense mandates that you obtain an Anti Terrorism Code for any international wire transactions: This will give approval to all your transactions</p>
                <p>
                    Your are transfering <span class="text-danger fw-bold">
                    <?php 
                        if($fetchUsers['currency'] == "$"){
                            echo "USD ";
                        }elseif($fetchUsers['currency'] == "€"){
                            echo "EUR ";
                        }else{
                            echo "GBP ";
                        }
                    ?>
                    </span><span id="fetchAmtAtc" class="text-danger fw-bold"></span> from your  <span class="text-danger fw-bold" id="send_acc_atc"></span>
                    to <span class="text-danger fw-bold" id="recNameAtc"></span>
                </p>
                <p>Your Calculated <b>ATC Code</b> Payment is: <span class="text-danger fw-bold" id="fee">
                    <?php 
                        if($fetchUsers['currency'] == "$"){
                            echo "USD ";
                        }elseif($fetchUsers['currency'] == "€"){
                            echo "EUR ";
                        }else{
                            echo "GBP ";
                        }
                    ?><?=$fetchAtc['amount'] ?? 0?></span>
                </p>
                <P class="fw-bold">Contact customer service via</P>
                <a href="mailTo:helpcenter@wellspringeu.com" class="btn btn-primary" style="margin-top: -10px">helpcenter@wellspringeu.com</a>
                <span class="fw-bold">for your ATC code payment</span>
            </div>
            <div class="submit-field" style="margin-top: 155px; text-align: center">
                <input type="hidden"  id="atcRef" value="<?php echo $userRef?>">
                <input type="text" class="form-control mx-auto" style="width: auto" id="atc" placeholder="Enter ATC code to continue">
                <span id="atc_error" class="text-danger d-block"></span> 
                <button type="submit" id="atcSubmit" class="submit" style="width: auto; margin-top: 4px">Confirm Code</button>
            </div>
        </div>
    </form>
    <form action="" method="post" id="imf-form"  style="display: none">
        <div class="cot-bill-container">
            <p>
                Dear <span class="text-danger text-upper fw-bold" id="nameFetchImf"></span>, our Banking Transfer Services are guided by laws of 
                the United States FDIC and International Monetary Funds(IMF), to ensure your funds are free from money laundering. You are required
                to get a valid IMF clearance code from our wire transfer unit.
            </p>
            <p>
                Your are transfering <span class="text-danger fw-bold">
                <?php 
                    if($fetchUsers['currency'] == "$"){
                        echo "USD ";
                    }elseif($fetchUsers['currency'] == "€"){
                        echo "EUR ";
                    }else{
                        echo "GBP ";
                    }
                ?>
                </span><span id="fetchAmtImf" class="text-danger fw-bold"></span> from your  <span class="text-danger fw-bold" id="send_acc_imf"></span>
                to <span class="text-danger fw-bold" id="recNameImf"></span>
            </p>
            <p>Your Calculated <b>IMF Code</b> Payment is: <span class="text-danger fw-bold" id="fee"> 
                <?php 
                    if($fetchUsers['currency'] == "$"){
                        echo "USD ";
                    }elseif($fetchUsers['currency'] == "€"){
                        echo "EUR ";
                    }else{
                        echo "GBP ";
                    }
                ?>
                <?=$fetchImf['amount'] ?? 0?> </span>
            </p>
            <P class="fw-bold">Contact customer service via</P>
            <a href="mailTo:helpcenter@wellspringeu.com" class="btn btn-primary" style="margin-top: -10px">helpcenter@wellspringeu.com</a>
            <span class="fw-bold">for your IMF code payment</span>
        </div>
        <div class="submit-field" style="margin-top: 155px; text-align: center">
            <input type="hidden"  id="imfRef" value="<?php echo $userRef?>">
            <input type="text" class="form-control mx-auto" style="width: auto" id="imf" placeholder="Enter IMF code to continue">
            <span id="imf_error" class="text-danger d-block"></span> 
            <button type="submit" id="imfSubmit" class="submit" style="width: auto; margin-top: 4px">Confirm Code</button>
        </div>
    </form>
    <form action="" method="post" id="cot-form"  style="display: none">
        <div class="cot-bill-container">
            <p>
                Dear <span class="text-danger text-upper fw-bold" id="nameFetch"></span>,kindly note that you are making a wire transfer of <span class="text-danger fw-bold">
                    <?php 
                        if($fetchUsers['currency'] == "$"){
                            echo "USD ";
                        }elseif($fetchUsers['currency'] == "€"){
                            echo "EUR ";
                        }else{
                            echo "GBP ";
                        }
                    ?>
                </span>
                <span id="fetchAmt" class="text-danger fw-bold"></span> from your <span class="text-danger fw-bold" id="send_acc"></span> to <span class="text-danger fw-bold" id="fetchBank"></span> with the underlisted details:
            </p>
            <ul>
                <li>Bank Name: <span id="fetchBankList"></span></li>
                <li>Beneficiary: <span id="recName"></span></li>
                <li>Swift Code/IBAN: <span id="swiftCode"></span></li>
                <li>Bank Account: <span id="fetchRec"></span></li>
            </ul>
            <p>Your Calculated COT Code Payment is : <span class="text-danger fw-bold" id="fee">
                <?php 
                    if($fetchUsers['currency'] == "$"){
                        echo "USD ";
                    }elseif($fetchUsers['currency'] == "€"){
                        echo "EUR ";
                    }else{
                        echo "GBP ";
                    }
                ?>
                <?=$fetchCot['amount'] ?? 0?></span>
            </p>
            <P class="fw-bold">Contact customer service via</P>
            <a href="mailTo:helpcenter@wellspringeu.com" class="btn btn-primary" style="margin-top: -10px">helpcenter@wellspringeu.com</a>
            <span class="fw-bold">for your COT code payment</span>
        </div>
        <div class="submit-field" style="margin-top: 155px; text-align: center">
            <input type="hidden"  id="ctRef" value="<?php echo $userRef?>">
            <input type="text" class="form-control mx-auto" style="width: auto" id="cot" placeholder="Enter COT code to continue">
            <span id="cot_error" class="text-danger d-block"></span> 
            <button type="submit" id="cotSubmit" class="submit" style="width: auto; margin-top: 4px">Confirm Code</button>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11" customClass: swal-size-sm></script>
<script src="../controller/js/ajax.js"></script>
<script src="./controller/js/transfer.js"></script>