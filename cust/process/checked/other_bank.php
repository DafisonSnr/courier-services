<?php
    session_start();
    require_once './../../config/config.php';

    $user_ref = $_SESSION['user']['user_ref'];
    $customer = $_POST['cust'];
    $acc_num = $_POST['acc'];
    $bank = $_POST['bank'];
    // $routing = $_POST['rout'];
    // $swift = $_POST['swift'];
    $formatAmt = $_POST['amt'];
    $comma = "/,./i";
    $amt = preg_replace($comma, "",$formatAmt);
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user_ref'");
    if(mysqli_num_rows($sql)>0){
        $fetchReg = mysqli_fetch_assoc($sql);
        $currency = $fetchReg['currency'];
        $type = "Debit";
        $status = "PENDING";
        $tran_Ref = "TRAN".rand(000000,999999);
        $sqlTran = mysqli_query($conn,"SELECT * FROM real_acc WHERE user_ref='$user_ref'");
        $FetchRow = mysqli_fetch_assoc($sqlTran);
        if($amt < $FetchRow['cBal'] && $amt < $FetchRow['aBal']){
            $stmt = $conn->prepare("INSERT INTO acc_history(user_ref,tran_Ref,acc_name,acc_num,bank,currency,amt,Tran_Typ,tran_status)VALUES(?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param('sssssssss',$user_ref,$tran_Ref,$customer,$acc_num,$bank,$currency,$amt,$type,$status);
            $stmt->execute();
          if($stmt){
            header("Content-Type: application/json");
            $data = array('status' => 200, 'data' => $stmt);
            echo json_encode($data);
          }else{
            $data = array('status' => 500);
            echo json_encode($data);  
          }
        }else{
          $data = array('status' => 505);
          echo json_encode($data);
        }
    }
?>