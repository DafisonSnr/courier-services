<?php
    require_once '../config/config.php';

    $userRef = $_POST['userRef'];
    $sql = mysqli_query($conn, "SELECT * FROM restriction WHERE switch_Code='YES' AND user_Ref='$userRef'");
    if(mysqli_num_rows($sql)>0) {
        header('Content-Type: application/text');
        $data = array('status' => 200, 'data' =>$sql);
        echo json_encode($data);
    }else {
        $data = array('status' => 500);
        echo json_encode($data);
    }