<?php
require_once '../config/config.php';
$taxCode = $_POST['cot'];
$taxRef = $_POST['ctRef'];
$sql = mysqli_query($conn,"SELECT * FROM require_codes where cust_id='$taxRef'");
if(mysqli_num_rows($sql)>0) {
    $row = mysqli_fetch_assoc($sql);
    if($row['tax_code'] == $taxCode) {
        header('Content-Type: application/text');
        $data = array('status' => 200, 'code' =>$sql);
        echo json_encode($data);
    }else {
        $data = array('status' => 500);
        echo json_encode($data);
    }
}else {
    $data = array('status' => 500);
    echo json_encode($data);
}
?>