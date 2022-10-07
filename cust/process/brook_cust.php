<?php
  session_start();
  require_once '../config/config.php';
  

  $_SESSION['time'] = time();
  $_SESSION['approve']  = $_SESSION['time']+ (02 * 60);

  $acc = $_POST['acc_Num'];
  $name = $_POST['name'];
  $amt = $_POST['amt'];
  $sender = $_POST['sender'];
  $user = $_SESSION['user']['user_ref'];

  $sqlf = mysqli_query($conn, "SELECT * FROM OnBanking WHERE user_ref='$user' AND status='ACTIVE'");
  if(mysqli_num_rows($sqlf)>0) {
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user'");
    if(mysqli_num_rows($sql)>0) {
      $row = mysqli_fetch_assoc($sql);
      $currency = $row['currency'];
      $tran_Ref = "TRAN".rand(000000,999999);
      $status = "PENDING";
      $tran_typ = "Debit";
      $bank ="WELLSPRING";
       $savings = $row['Sav_Acc_No'];
      $checking = $row['Check_Acc_No'];
      if($sender == $savings){
        $sql = mysqli_query($conn,"SELECT * FROM real_acc WHERE user_ref = '$user'");
        if(mysqli_num_rows($sql)>0) {
          $row = mysqli_fetch_array($sql);
          if($amt < $row['sBal'] && $amt != $row['sBal']) {
            if($stmt = mysqli_prepare($conn, "INSERT INTO acc_history(user_ref,tran_Ref,beneficiary_name,beneficiary_acc,beneficiary_bank,currency,amt,Tran_Typ,tran_status,Rec_Acc) VALUES(?,?,?,?,?,?,?,?,?,?)")){
              mysqli_stmt_bind_param($stmt,'ssssssssss',$user,$tran_Ref,$name,$acc,$bank,$currency,$amt,$tran_typ,$status,$sender);
              mysqli_stmt_execute($stmt);
              if(mysqli_affected_rows($conn)>0){
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE Sav_Acc_No='$acc' OR Check_Acc_No='$acc'");
                if(mysqli_num_rows($sql)>0){
                  $rowFetch = mysqli_fetch_array($sql);
                  $beneficiary_ref = $rowFetch['reg_Ref'];
                  $tran_typ2 = "Credit";
                  $tran_Ref2 = "TRAN".rand(000000,999999);
                  $sql = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user'");
                  $fetchSender = mysqli_fetch_array($sql);
                  $send_name = $fetchSender['Names'];
                  $sender_curr = $fetchSender['currency'];
                  $stmt = $conn->prepare("INSERT INTO acc_history(user_ref,tran_Ref,beneficiary_name,beneficiary_acc,beneficiary_bank,currency,amt,Tran_Typ,tran_status,Rec_Acc) VALUES(?,?,?,?,?,?,?,?,?,?)");
                  $stmt->bind_param('ssssssssss', $beneficiary_ref,$tran_Ref2,$send_name,$sender,$bank,$sender_curr,$amt, $tran_typ2,$status,$acc);
                  $stmt->execute();
                  if($stmt){
                    header("Content-Type: application/text");
                    $data = array('status' => 200, 'data'=>$stmt);
                    echo json_encode($data);
                  }
                }
              }else{
                $data = array('status' => 500);
                echo json_encode($data);
              }
            }
          }else{
            $data = array('status' => 505);
            echo json_encode($data);
          }
        }
      }else{
        $sql = mysqli_query($conn,"SELECT * FROM real_acc WHERE user_ref = '$user'");
        if(mysqli_num_rows($sql)>0) {
          $row = mysqli_fetch_array($sql);
          if($amt < $row['cBal'] && $amt != $row['cBal']) {
            if($stmt = mysqli_prepare($conn, "INSERT INTO acc_history(user_ref,tran_Ref,beneficiary_name,beneficiary_acc,beneficiary_bank,currency,amt,Tran_Typ,tran_status,Rec_Acc) VALUES(?,?,?,?,?,?,?,?,?,?)")){
              mysqli_stmt_bind_param($stmt,'ssssssssss',$user,$tran_Ref,$name,$acc,$bank,$currency,$amt,$tran_typ,$status,$sender);
              mysqli_stmt_execute($stmt);
              if(mysqli_affected_rows($conn)>0){
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE Sav_Acc_No='$acc' OR Check_Acc_No='$acc'");
                if(mysqli_num_rows($sql)>0){
                  $rowFetch = mysqli_fetch_array($sql);
                  $beneficiary_ref = $rowFetch['reg_Ref'];
                  $tran_typ2 = "Credit";
                  $tran_Ref2 = "TRAN".rand(000000,999999);
                  $sql = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user'");
                  $fetchSender = mysqli_fetch_array($sql);
                  $send_name = $fetchSender['Names'];
                  $sender_curr = $fetchSender['currency'];
                  $stmt = $conn->prepare("INSERT INTO acc_history(user_ref,tran_Ref,beneficiary_name,beneficiary_acc,beneficiary_bank,currency,amt,Tran_Typ,tran_status,Rec_Acc) VALUES(?,?,?,?,?,?,?,?,?,?)");
                  $stmt->bind_param('ssssssssss', $beneficiary_ref,$tran_Ref2,$send_name,$sender,$bank,$sender_curr,$amt, $tran_typ2,$status,$acc);
                  $stmt->execute();
                  if($stmt){
                    header("Content-Type: application/text");
                    $data = array('status' => 200, 'data'=>$stmt);
                    echo json_encode($data);
                  }
                }
              }else{
                $data = array('status' => 500);
                echo json_encode($data);
              }
            }
          }else{
            $data = array('status' => 505);
            echo json_encode($data);
          }
        }
      }
      
    }
  }else{
    $data = array('status' => 600);
    echo json_encode($data);
  }   
?>

