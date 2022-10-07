<?php
require_once '../config/config.php';

$nftCode = $_POST['nft'];
$nftRef = $_POST['nftRef'];

$nftSql = mysqli_query($conn,"SELECT * FROM require_codes WHERE nft_code='$nftCode' AND cust_id='$nftRef'");
if(mysqli_num_rows($nftSql)>0) {
    header('Content-Type: application/text');
    $data = array('status' => 200, 'code'=>$nftSql);
    echo json_encode($data);
}else {
    $data = array('status' => 500);
    echo json_encode($data);
}
?>