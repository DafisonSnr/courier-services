<?php
    require_once './../../config/config.php';

    $userRef = $_POST['userRef'];
    $custName = $_POST['custName'];
    $recieverAcc = $_POST['custAcc'];
    $bank = $_POST['bank'];
    $swift = $_POST['swift'];
    $rout = $_POST['rout'];
    $amt = $_POST['amt'];
    $sender = $_POST['sender'];
  
    // ACCOUNT HOLDER NAME
    $nameSql = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$userRef'");
    if(mysqli_num_rows($nameSql)>0){
        $nameFetch = mysqli_fetch_assoc($nameSql);
        $holderName = $nameFetch['Names'];
    }

    $frozeSql =  mysqli_query($conn, "SELECT * FROM real_acc WHERE user_ref ='$userRef'");
    $row1 = mysqli_fetch_assoc($frozeSql);
    $sql = mysqli_query($conn, "SELECT * FROM restriction WHERE user_Ref='$userRef'");
    $row = mysqli_fetch_assoc($sql);
        if($row1['status'] != 'BLOCKED') {
            if($row['switch_Code'] == 'NO'){
                header('Content-Type: application/text');
                $data = array('status' => 200, 'data' =>$sql);
                echo json_encode($data);
            }else {
                $data = array('status' => 500, 'senderName' =>$holderName,'receiverName'=>$custName,'bankName'=>$bank,'swiftCode'=>$swift,'routingNo'=>$rout,
                'amount'=>$amt,'senderAcct'=>$sender, 'recieverAcc' =>$recieverAcc
                );
                echo json_encode($data);
            }
        }else{
            echo json_encode(array('status' => 'error1'));
        }
       
        
?>