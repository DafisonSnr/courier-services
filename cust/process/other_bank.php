<?php
  session_start();
  require_once '../config/config.php';

  $user_ref = $_SESSION['user']['user_ref'];
  $customer = $_POST['cust'];
  $acc_num = $_POST['acc'];
  $bank = $_POST['bank'];
  $routing = $_POST['rout'];
  $swift = $_POST['swift'];
  $formatAmt = $_POST['amt'];
  $sender = $_POST['sender'];

  $commas = "/,/i";

  $amt = preg_replace($commas,"",$formatAmt);

  $sqlf = mysqli_query($conn, "SELECT * FROM OnBanking WHERE user_ref='$user_ref' AND status='ACTIVE'");
  if(mysqli_num_rows($sqlf)>0) {
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user_ref'");
    if(mysqli_num_rows($sql)>0){
      $fetchReg = mysqli_fetch_assoc($sql);
      $currency = $fetchReg['currency'];
      $savings = $fetchReg['Sav_Acc_No'];
      $checking = $fetchReg['Check_Acc_No'];
      $type = "Debit";
      $status = "PENDING";
      $tran_Ref = "TRAN".rand(000000,999999);
      if($sender == $savings){
        $sqlTran = mysqli_query($conn,"SELECT * FROM real_acc WHERE user_ref='$user_ref'");
        $FetchRow = mysqli_fetch_assoc($sqlTran);
        if($amt < $FetchRow['sBal'] && $amt != $FetchRow['sBal']){
            $stmt = $conn->prepare("INSERT INTO acc_history(user_ref,tran_Ref,beneficiary_name,beneficiary_acc,beneficiary_bank,currency,amt,Tran_Typ,tran_status,Rec_Acc)VALUES(?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param('ssssssssss',$user_ref,$tran_Ref,$customer,$acc_num,$bank,$currency,$amt,$type,$status,$sender);
            $stmt->execute();
          if($stmt){
            header("Content-Type: application/text");
            $data = array('status' => 200, 'data' => $amt);
            echo json_encode($data);
          }else{
            $data = array('status' => 500);
            echo json_encode($data);  
          }
        }else{
          $data = array('status' => 505,'data'=>$amt);
          echo json_encode($data);
        }
      }else{
        $sqlTran = mysqli_query($conn,"SELECT * FROM real_acc WHERE user_ref='$user_ref'");
        $FetchRow = mysqli_fetch_assoc($sqlTran);
        if($amt <= $FetchRow['cBal'] && $amt != $FetchRow['sBal']){
            $stmt = $conn->prepare("INSERT INTO acc_history(user_ref,tran_Ref,beneficiary_name,beneficiary_acc,beneficiary_bank,currency,amt,Tran_Typ,tran_status,Rec_Acc)VALUES(?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param('ssssssssss',$user_ref,$tran_Ref,$customer,$acc_num,$bank,$currency,$amt,$type,$status,$sender);
            $stmt->execute();
          if($stmt){
            header("Content-Type: application/text");
            $data = array('status' => 200, 'data' => $amt);
            echo json_encode($data);
          }else{
            $data = array('status' => 500);
            echo json_encode($data);  
          }
        }else{
          $data = array('status' => 505,'data'=>$amt.$sender);
          echo json_encode($data);
        }
      }
    }
  }else{
    $data = array('status' => 600);
    echo json_encode($data);
  }  
?>