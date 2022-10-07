<?php
  session_start();
  require_once './configs/config.php';

  require_once "vendor/autoload.php";

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  
  



  function clean($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  // $sql = "SELECT * FROM OnBanking";
  // $fetchUsers = mysqli_query($conn, $sql);
  // $_SESSION['user'] = mysqli_fetch_assoc($fetchUsers); 

 $userInput = clean($_POST['userInput']);
 $passInput = clean($_POST['passInput']);
 $ip = clean($_POST['ip']);
//  $ip = clean($_POST['ip']);

 $sql = "SELECT * FROM OnBanking WHERE username='$userInput'";
 $result = $conn->query($sql);
  if(mysqli_num_rows($result)>0){
    $fetchPass = mysqli_fetch_assoc($result);
    $passIn = $fetchPass['password'];
    $pw = $passInput; 
    $state = $fetchPass['state']; 
    $user_ref = $fetchPass['user_ref'];
    $sqlUser = mysqli_query($conn, "SELECT * FROM users where reg_Ref='$user_ref'");
    $userRow = mysqli_fetch_assoc($sqlUser);
    $names = $userRow['Names'];
    $date = date("h:i:sA, M d,Y");
    $email = $userRow['email'];
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){

      $ip = $_SERVER['HTTP_CLIENT_IP'];
      
      } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      
      } else {
      
      $ip = $_SERVER['REMOTE_ADDR'];
      }
    if(password_verify($pw,$passIn)){
      if($state != 'BLOCKED'){
        sendMail($names,$email, $ip,$date);
        $_SESSION['user'] = true;
        $_SESSION['user'] = $fetchPass;
        $_SESSION['start'] = time(); // Taking now logged in time.
              // Ending a session in 30 minutes from the starting time.
        $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
        // header("content-type: application/json");
        echo json_encode(array('status' => 200));
      }else{
        echo json_encode(array('status' => 'error1'));
      }
    }else{
      echo json_encode(array('status' => 'error2'));
    }
  }
 

  function sendMail($names, $email, $ip,$date){
    $mail = new PHPMailer(true);
    
    $mail->setFrom('wellqotz@wellspringeu.com','WELLSPRING');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'SPRING-ONLINE LOG IN CONFIRMATION';
    $mail->Body = 
    '
      <html lang="en">
        <body">
          <h3>Dear '.$names.'</h3>
          <p>Please be informed that your SPRING-ONLINE profile was
          accessed at '.$date.' - IP Address: '.$ip.' </p>
          <p> If you did not log on to your SPRING-ONLINE profile at the time detailed above, Please send an Email</p>
          <p>Thank you for banking with us.</p>
        </body>
      </html>
    ';
    try {
        $mail->send();
        // echo "Email has been sent successfully";
    }catch (Exception $e) {
      $mail->ErrorInfo;
    }   
  }
?>