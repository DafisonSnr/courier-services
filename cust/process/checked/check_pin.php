<?php

require_once './../../config/config.php';

$name = $_POST['name'];
$pin = $_POST['pin'];
$acc = $_POST['acc'];
$amt = $_POST['amt'];
$user = $_POST['user'];
$currency = $_POST['cur'];
$sender = $_POST['sender'];
$sql = mysqli_query($conn,"SELECT * FROM tranpin WHERE user_ref = '$user'");
if($sql) {
    $fetchPin = mysqli_fetch_assoc($sql);
    $dataBasePin = $fetchPin['pin'];
    if(password_verify($pin,$dataBasePin)){
        $sql = mysqli_query($conn, "SELECT * FROM OnBanking WHERE user_ref='$user' AND status='ACTIVE'");
        if(mysqli_num_rows($sql)>0) {
            $checkBalState = mysqli_query($conn,"SELECT * FROM real_acc WHERE user_ref = '$user' AND status = 'OPENED'");
            if(mysqli_num_rows($checkBalState)>0) {
                $checkRestriction = mysqli_query($conn,"SELECT * FROM restriction WHERE switch_Code = 'NO' AND user_ref = '$user'");
                if(mysqli_num_rows($checkRestriction)>0){
                    $sqlUserInfo = mysqli_query($conn,"SELECT * FROM users WHERE ref_Ref='$user'");
                    $fetchUser = mysqli_fetch_assoc($sqlUserInfo);
                    $savings = $fetchUser['Sav_Acc_No'];
                    $tran_Ref = "TRAN".rand(000000,999999);
                    $status = "PENDING";
                    $tran_typ = "Debit";
                    $bank = "WELLSPRING";
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
                                                header('Content-Type: application/json');
                                                $status = array('status' => 200);
                                                echo json_encode($status); 
                                            }
                                        }
                                    }else{
                                        $status = array('status' => 'error2');
                                        echo json_encode($status);
                                    }
                                }
                            }else{
                                $status = array('status' => 'error3');
                                echo json_encode($status);
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
                                                header('Content-Type: application/json');
                                                $status = array('status' => 200);
                                                echo json_encode($status); 
                                            }
                                        }
                                    }else{
                                        $status = array('status' => 'error2');
                                        echo json_encode($status);
                                    }
                                }
                            }else{
                                $status = array('status' => 'error3');
                                echo json_encode($status);
                            }
                        }
                    }
                }else{
                    $status = array('status' => 'required', 'data' =>$user);
                echo json_encode($status);
                }
            }else{
                $status = array('status' => 'frozen');
                echo json_encode($status);
            }
        }else{
            $data = array('status' => 'inactive');
            echo json_encode($data);
        }  
    }else{
        $status = array('status' => 'error1', 'data' =>$user);
        echo json_encode($status);
    }
    
}



?>