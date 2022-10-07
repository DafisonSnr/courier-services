<?php
    require_once './../../config/config.php';

    $userRef = $_POST['userRef'];

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
                $data = array('status' => 500, 'data' =>$sql);
                echo json_encode($data);
            }
        }else{
            echo json_encode(array('status' => 'error1'));
        }
       
        
   