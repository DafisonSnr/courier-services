
<?php
    
    session_start();
    require_once './configs/config.php';


    $otp = $_POST['otp'];
    $email = $_POST['email'];
    $user = $_POST['user'];
    $sql = mysqli_query($conn, "SELECT * FROM pass_change_otp WHERE email = '$email' AND otp = '$otp'");
    if(mysqli_num_rows($sql) > 0){
        $sql = mysqli_query($conn, "SELECT * FROM onbanking WHERE user_ref='$user'");
        if($sql){
            $row = mysqli_fetch_assoc($sql);
            $_SESSION['code'] = true;
            $_SESSION['pass'] = $row;
            $_SESSION['time'] = time();
            $_SESSION['expire'] = $_SESSION['time'] + (10 * 60);
            echo json_encode(array('status'=>'success'));
        }
       
    }else{
        echo json_encode(array('status'=>'error'));
    }

?>


