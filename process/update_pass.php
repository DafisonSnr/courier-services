<?php
    require_once './configs/config.php';

    require_once "vendor/autoload.php";
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    $email = $_POST['email'];
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);
        if(mysqli_num_rows($result) > 0){
            $check = mysqli_query($conn, "SELECT * FROM pass_change_otp WHERE email ='$email'");
            if(mysqli_num_rows($check) < 1){
                $otp = rand(000000,999999);
                $sql = mysqli_query($conn, "INSERT INTO pass_change_otp VALUES(NULL,'$otp','$email')");
                if($sql){
                    $sql = mysqli_query($conn, "SELECT * FROM pass_change_otp WHERE email='$email'");
                    $row = mysqli_fetch_array($result);
                    sendMail($otp,$email);
                    echo json_encode(array('status' => 'inserted','data' => $row)); 
                }else{
                    echo json_encode(array('status' => 'failed'));
                }
            }else{
                $otp = rand(000000,999999);
                $sql = mysqli_query($conn, "UPDATE pass_change_otp SET otp='$otp'");
                if($sql){
                    $sql = mysqli_query($conn, "SELECT * FROM pass_change_otp WHERE email='$email'");
                    $row = mysqli_fetch_assoc($result);
                    sendMail($otp,$email);
                    echo json_encode(array('status' => 'updated','data' => $row));
                }else{
                    echo json_encode(array('status' => 'error'));
                }
            }
        }else{
            echo json_encode(array('status' => 'invalid'));
        }

    function sendMail($otp,$email){
        $mail = new PHPMailer(true);
        $mail->setFrom('wellqotz@wellspringeu.com','WELLSPRING');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "OTP VERIFICATION CODE";
        $mail->Body = "
            <h5> <strong>Dear Valued Customer,</strong></h5>
            <p>Your Password Verification Code is: $otp</p>
            <p> Please do not share this code with others.</p>
            <p>If you did not initiate this request, Kindly contact support immediately.</p>
            <h6> <strong>WELLSPRING Team</strong></h6>
            <p>If you have any questions, pleae feel free to contact us at <a href='#'>Email</a></p>
        ";
        $mail->AltBody = "This is the plain text version of the email content";
        try {
            $mail->send();
        } catch (Exception $e) {
            $mail->ErrorInfo;
        }
    }
?>