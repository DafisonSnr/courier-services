<?php
    require_once './../../config/config.php';

    $codeRef = $_POST['codeRef'];

    $sqlActive = mysqli_query($conn, "SELECT * FROM OnBanking WHERE  status='ACTIVE'  AND user_ref='$codeRef'");
    if (mysqli_num_rows($sqlActive)>0){
        $sql = mysqli_query($conn, "UPDATE OnBanking SET status='INACTIVE' WHERE user_ref='$codeRef'");
        if($sql){
            header('Content-Type: application/json');
            $data = array('status' => 200, 'data' =>$sql);
            echo json_encode($data);
        }
    }else{
        $sql = mysqli_query($conn, "UPDATE OnBanking SET status='ACTIVE' WHERE user_ref='$codeRef'");
        if($sql){
            header('Content-Type: application/json');
            $data = array('status' => 201, 'data' => $sql);
            echo json_encode($data);
        }
    }

?>