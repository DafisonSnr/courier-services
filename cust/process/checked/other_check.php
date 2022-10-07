<?php

require_once './../../config/config.php';

$name = $_POST['name'];
$pin = $_POST['pin'];
$acc = $_POST['acc'];
$amt = $_POST['amt'];
$bank = $_POST['bank'];
$user = $_POST['user'];
$currency = $_POST['cur'];
$sender = $_POST['senderAcc'];
$swift = $_POST['swift'];
// {userRef:userRef,custName:custName,custAcc:custAcc,bank:bankName,swift:swiftCode,rout:routing,amt:amount,sender:sender}
// ACCOUNT HOLDER NAME
$nameSql = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user'");
if(mysqli_num_rows($nameSql)>0){
    $nameFetch = mysqli_fetch_assoc($nameSql);
    $holderName = $nameFetch['Names'];
}

$sql = mysqli_query($conn,"SELECT * FROM tranpin WHERE user_ref = '$user'");
if($sql) {
    $fetchPin = mysqli_fetch_assoc($sql);
    $dataBasePin = $fetchPin['pin'];
    if(password_verify($pin,$dataBasePin)){
        $sqlf = mysqli_query($conn, "SELECT * FROM OnBanking WHERE user_ref='$user' AND status='ACTIVE'");
        if(mysqli_num_rows($sqlf)>0) {
            $checkBalState = mysqli_query($conn,"SELECT * FROM real_acc WHERE user_ref = '$user' AND status = 'OPENED'");
            if(mysqli_num_rows($checkBalState)>0) {
                $checkRestriction = mysqli_query($conn,"SELECT * FROM restriction WHERE switch_Code = 'NO' AND user_ref = '$user'");
                if(mysqli_num_rows($checkRestriction)>0){
                    $tran_Ref = "TRAN".rand(000000,999999);
                    $status = "PENDING";
                    $tran_typ = "Debit";
                    $sqlUsers = mysqli_query($conn,"SELECT * FROM users WHERE reg_Ref='$user'");
                    if(mysqli_num_rows($sqlUsers)>0) {
                        $fetchUsers = mysqli_fetch_assoc($sqlUsers);
                        $savings = $fetchUsers['Sav_Acc_No'];
                        if($sender == $savings){
                            $sql = mysqli_query($conn,"SELECT * FROM real_acc WHERE user_ref = '$user'");
                            if(mysqli_num_rows($sql)>0) {
                                $row = mysqli_fetch_array($sql);
                                if($amt < $row['sBal'] && $amt != $row['sBal']) {
                                    if($stmt = mysqli_prepare($conn, "INSERT INTO acc_history(user_ref,tran_Ref,beneficiary_name,beneficiary_acc,beneficiary_bank,currency,amt,Tran_Typ,tran_status,Rec_Acc) VALUES(?,?,?,?,?,?,?,?,?,?)")){
                                        mysqli_stmt_bind_param($stmt,'ssssssssss',$user,$tran_Ref,$name,$acc,$bank,$currency,$amt,$tran_typ,$status,$sender);
                                        mysqli_stmt_execute($stmt);
                                        if(mysqli_affected_rows($conn)>0){
                                            header('Content-Type: application/text');
                                            $status = array('status' => 200);
                                            echo json_encode($status);
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
                                            header('Content-Type: application/text');
                                            $status = array('status' => 200);
                                            echo json_encode($status);
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
                    }
                }else{
                    $status = array('status' => 'required', 'senderName' =>$holderName,'receiverName'=>$name,'bankName'=>$bank,'swiftCode'=>$swift,
                    'amount'=>$amt,'senderAcc'=>$sender, 'recieverAcc' =>$acc);
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