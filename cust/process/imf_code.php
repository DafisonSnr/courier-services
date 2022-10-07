<?php
require_once '../config/config.php';

$imfCode = $_POST['imf'];
$imfRef = $_POST['imfRef'];
$imfSql = mysqli_query($conn, "SELECT * FROM require_codes WHERE imf_code='$imfCode' AND cust_id='$imfRef'");
if(mysqli_num_rows($imfSql)){
    header("content-Type: application/text");
    $data = array('status' => 200, 'code'=>$imfSql);
    echo json_encode($data);
}else{
    $data = array('status' => 500);
    echo json_encode($data);
}
?>