<?php
session_start();
require_once '../config/config.php';
$userRef = $_SESSION['user']['user_ref'];
$sqluser = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$userRef'");

$senderAcc = $_POST['sender'];

$acc_input = $_POST['acc_input'];
$sql = "SELECT * FROM users WHERE Sav_Acc_No='$acc_input' OR Check_Acc_No='$acc_input'";
$fetchedResults = $conn->query($sql);
if(mysqli_num_rows($fetchedResults)>0){
    $rowBenAcc = mysqli_fetch_assoc($sqluser);
    $sender = array($rowBenAcc['Check_Acc_No'],$rowBenAcc['Sav_Acc_No']);
    $row = mysqli_fetch_assoc($fetchedResults);
    $accBen = array($row['Check_Acc_No'],$row['Sav_Acc_No']);
    if($accBen != $sender){
        header('Content-Type: application/json');
        $data = array('status' => 200, 'data' => $row, "sender" => $senderAcc,"receiver"=>$acc_input);
        echo json_encode($data);  
    }else{
        $data = array('status' => 505);
        echo json_encode($data);
    }
}else{
    $data = array('status' => '500');
    echo json_encode($data);
}
?>



