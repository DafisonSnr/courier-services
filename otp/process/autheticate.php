<?php
    session_start();
    require_once './../../config/config.php';
    $user = $_POST['user'];
    $otpCode = $_POST['otp'];
    $serch = mysqli_query($conn, "SELECT * from otp WHERE otp_code = '$otpCode' AND username = '$user'");
    if(mysqli_num_rows($serch)>0) {
        $row = mysqli_fetch_assoc($serch);
        $fetchUser = $row['username'];
        $sql = mysqli_query($conn, "SELECT * FROM OnBanking WHERE username='$fetchUser'");
        if(mysqli_num_rows($sql)>0) {
            $fetchRow = mysqli_fetch_assoc($sql);
            $_SESSION['user'] = true;
            $_SESSION['user'] = $fetchRow;
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
            header('Content-Type: application/json');
            $status = array('status' => 'ok');
            echo json_encode($status);
        }
    }else{
        $status = array('status' => 'error');
        echo json_encode($status);
    }
?>