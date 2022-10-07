<?php
require_once './../../config/config.php';
require_once './../../includes/reg-header.php';

$delVal = $_POST['delVal'];

$sql = mysqli_query($conn, "SELECT * FROM acc_history WHERE id='$delVal'");
if (mysqli_num_rows($sql) > 0) {
    $sql = mysqli_query($conn, "DELETE FROM acc_history WHERE id='$delVal'");   
    if($sql) {
        // header("content-type: application/json_encode");
        // $data = array('Status' => 200, 'data' => $sql);
        // echo json_encode($data);
        echo "success";
    }else{
        echo "error";
        // $data = array('Status' => 500);
        // echo json_encode($data);
    }
 
}
?>