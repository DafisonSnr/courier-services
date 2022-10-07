<?php
require_once './../config/config.php';
require_once './../includes/reg-header.php';

$name = $_POST['name'];
$acc = $_POST['acc'];
$bank = $_POST['bank'];
$amt = $_POST['amt'];
$date = $_POST['date'];
$tranId = $_POST['tranId'];


$sql = mysqli_query($conn, "UPDATE acc_history SET beneficiary_name='$name',beneficiary_acc='$acc',beneficiary_bank='$bank', amt='$amt',hist_date='$date' WHERE tran_Ref='$tranId'");
if($sql) {
    header("Content-Type: application/text");
    $data = array('status' => 200, 'content' =>$sql);
    echo json_encode($data);
}else{
    $data = array('status' => 500);
    echo json_encode($data);
}

?>

