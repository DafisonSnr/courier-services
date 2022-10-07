<?php
require_once './../../config/config.php';

$codeRef = $_POST['codeRef'];
$sqlCheck = mysqli_query($conn, "SELECT * FROM OnBanking WHERE state='OPENED' AND user_ref='$codeRef'");
if(mysqli_num_rows($sqlCheck)>0) {
    $sqlUpdate = mysqli_query($conn, "UPDATE OnBanking SET state='BLOCKED' WHERE user_ref='$codeRef'");
    if($sqlUpdate){
        header('Content-Type: application/json');
        $data = array('status' =>200, 'code' =>$sqlCheck);
        echo json_encode($data);
    }
}else{
    $sqlOpened = mysqli_query($conn, "UPDATE OnBanking SET state='OPENED' WHERE user_ref='$codeRef'");
    if($sqlOpened){
        header('Content-Type: application/json');
        $data = array('status' => 201, 'code'=>$sqlOpened);
        echo json_encode($data);
    }
}
?>