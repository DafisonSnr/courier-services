<?php
require_once './process/configs/config.php';

require_once "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;  
  // fetch countries names from database
  $sqlCon = mysqli_query($conn,"SELECT * FROM country");

  // clean user inputs
  function clean($edata) {
    $data = trim($edata);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $fName = $type = $dob = $gen = $marital = $contry = $city = $zip 
  = $ssn = $phone = $email = $occup = $kin = $question = $answer = $pass 
  = $confirm = $user = $curr = $reg_Ref = '';
  $status = '';
  //error message
  $fName_er = $type_er = $dob_er = $gen_er = $marital_er = $contry_er = $city_er = $zip_er = 
  $number_er = $email_er = $occup_er = $kin_er = $question_er = $answer_er = $pass_er = $confirm_er = 
  $user_er = $curr_er = $file_er ='';

  if(isset($_POST['register'])){
    $user_input = clean($_POST['user']);
    $sqluser = mysqli_query($conn,"SELECT * FROM OnBanking WHERE username='$user_input'");
    if(mysqli_num_rows($sqluser)>0){
      $user_er = "Username already taken";
    }elseif($user_input == ""){
      $user_er = "This Field is Required";
    }else{
      $user = $user_input;
    }
    if($_POST['type'] == "") {
      $type_er = "This Field is Required";
    }else{
      $type = clean($_POST['type']);
    }
    if($_POST['dob'] == ""){
      $dob_er = "This Field is Required";
    }else{
      $dob = clean($_POST['dob']);
    }
    if($_POST['country'] == "NULL"){
      $contry_er = "This Field is Required";
    }else{
      $contry = clean($_POST['country']);
    }
    if($_POST['city'] == ""){
      $city_er = "This Field is Required";
    }else{
      $city = clean($_POST['city']);
    }
    if($_POST['names'] == ""){
      $fName_er = "This Field is Required";
    }else{
      $fName = clean($_POST['names']);
      if(!preg_match("/^[a-zA-Z-' ]*$/",$fName)){
        $name_er = "Only Letters and whitespaces are allowed";
      }
    }
    if($_POST['gender'] == NULL){
      $gen_er = "This Field is Required";
    }else{
      $gen = clean($_POST['gender']);
    }
    if($_POST['marital'] == NULL){
      $marital_er = "This Field is Required";
    }else{
      $marital = clean($_POST['marital']);
    }
    if($_POST['zip'] == ""){
      $zip_er = "This Field is Required";
    }else{
      $zip = clean($_POST['zip']);
    }
    if($_POST['ssn'] == ""){
      $ssn = "****";
    }else{
      $ssn = clean($_POST['ssn']);
    }
    $phone_input = clean($_POST['phone']);
    $phoneSql = mysqli_query($conn,"SELECT * FROM users where phone = '$phone_input'");
    if($_POST['phone'] == ""){
      $number_er = "This Field is Required";
    }elseif(mysqli_num_rows($phoneSql)>0) {
      $number_er = "Phone Number is already in use";
    }
    else{
      $phone =  $phone_input;
    }
    $email_input = clean($_POST['email']);
    $emailSql = mysqli_query($conn,"SELECT * FROM users where email = '$email_input'");
    if($_POST['email'] == ""){
      $email_er = "This Field is Required";
    }elseif(mysqli_num_rows($emailSql) >0){
      $email_er = "Email already exists";
    }
    else{
      if(!filter_var($email_input, FILTER_VALIDATE_EMAIL)){
        $email_er = "Invalid Email Address";
      }else{
        $email = $email_input;
      }
    }
    if($_POST['occupation'] == ""){
      $occup_er = "This Field is Required";
    }else{
      $occup = clean($_POST['occupation']);
    }
    if($_POST['kin'] == ""){
      $kin_er = "This Field is Required";
    }else{
      $kin = clean($_POST['kin']);
    }
    if($_POST['question'] == ""){
      $question_er = "This Field is Required";
    }else{
      $question = clean($_POST['question']);
    }
    if($_POST['answer'] == ""){
      $answer_er = "This Field is Required";
    }else{
      $answer = clean($_POST['answer']);
    }
    if($_POST['currencies'] == ""){
      $curr_er = "This Field is Required";
    }else{
      $curr = clean($_POST['currencies']);
    }
    if($_POST['passwords'] == ""){
      $pass_er = "This Field is Required";
    }else{
      $pass_input = clean($_POST['passwords']);
      $lower = preg_match('@[a-z]@',$pass_input);
      $upper = preg_match('@[A-Z]@', $pass_input);
      $number = preg_match('@[0-9]@', $pass_input);
      $character = preg_match('@[^\w]@', $pass_input);
      if(!$lower || !$upper || !$number || !$character || strlen($pass_input)<8){
        $pass_er = "Passwords must contain at least one Uppercase letter and at least one 
        Lowercase letter and one digit and one Special character with password length greater than 8";
      }else{
        $pass = password_hash($pass_input, PASSWORD_DEFAULT);
      }
    }
    if($_POST['confirm'] == ""){
        $confirm_er = "This Field is Required";
    }elseif($_POST['confirm'] != $_POST['passwords']){
      $confirm_er = "Passwords do not match";
    }else{
      $confirm = clean($_POST['confirm']);
    }

    $uploads = "uploads/";
    $uploadOk = 1;
    $upload_dir = $uploads . basename($_FILES['fileUpload']['name']);
    $imageDir = strtolower(pathinfo($upload_dir, PATHINFO_EXTENSION));
    
    // if(isset($_POST['register'])){
    //   $check = getimagesize($_FILES['fileUpload']['tmp_name']);
    //   if($check !== false){
    //     echo "file is supported";
    //     $uploadOk = 1;
    //   }else{
    //     echo "Invalid file";
    //     $uploadOk = 0;
    //   }
    // }

    // if(file_exists($upload_dir)){
    //   $file_er = "This file already exists";
    //   $uploadOk = 0;
    // }

    if($_FILES['fileUpload']['size']>5000000){
      $file_er = "This file is too big to be uploaded";
      $uploadOk = 0;
    }
    if($imageDir != 'jpg' && $imageDir != 'png' && $imageDir != 'gif' && $imageDir != 'jpeg'){
      $file_er = "This file is not supported";
      $uploadOk = 0;
    }
    if($uploadOk == 0){
      $file_er = "File not uploaded successfully";
    }else{
      if(empty($file_er) && empty($fName_er) && empty($type_er) && empty($dob_er)
        && empty($gen_er) && empty($marital_er)&& empty($contry_er) && empty($city_er)
        && empty($zip_er) && empty($number_er) && empty($email_er) && empty($occup_er)
        && empty($kin_er) && empty($question_er) && empty($answer_er) && empty($pass_er)
        && empty($confirm_er) && empty($user_er) && empty($curr_er)){
          if(move_uploaded_file($_FILES['fileUpload']['tmp_name'], $upload_dir)){
            $reg_Ref = "REG-".rand(0000000,9999999);
            $sav_Acc = "302".rand(1111111,9999999);
            $check_Acc = "201".rand(0000000,9999999);
            $date = date("Y-m-d H:i:s");
            $role = "customer";
            $state = "OPENED";
            $pofile_Pic = "NULL";
            $userStatus = "INACTIVE";
            if($stmt = mysqli_prepare($conn, "INSERT INTO users(reg_Ref,Names,acc_Type,dob,gender,
              marital,country,city,zip,ssn,phone,email,work,kin,Sav_Acc_No,Check_Acc_No,currency,photo,role)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")){
              mysqli_stmt_bind_param($stmt, 'sssssssssssssssssss',$reg_Ref,$fName,$type,$dob,$gen,$marital,
              $contry,$city, $zip,$ssn,$phone, $email,$occup,$kin,$sav_Acc,$check_Acc,$curr,$upload_dir,$role);
              mysqli_stmt_execute($stmt);
              if(mysqli_affected_rows($conn)>0){
                  $checkUserOnlinebank = "Pending";
                // insert into online bankinf table in database
                if( $stmt1 = mysqli_prepare($conn, "INSERT INTO OnBanking(user_ref,username,password,question,answer,
                  image,status,role,state,valid_user,reg_date)VALUES(?,?,?,?,?,?,?,?,?,?,?)")){
                  mysqli_stmt_bind_param($stmt1,'sssssssssss',$reg_Ref,$user,$pass,$question,$answer,$pofile_Pic,$userStatus,$role,$state,$checkUserOnlinebank,$date);
                  mysqli_stmt_execute($stmt1);
                  if(mysqli_affected_rows($conn)>0){
                    // insert into account restriction table in database
                    $code_status = "NO";
                    $stmt2 = $conn->prepare("INSERT INTO restriction(user_Ref,switch_Code)VALUES(?,?)");
                    $stmt2->bind_param('ss', $reg_Ref, $code_status );
                    $stmt2->execute();
                    if($stmt2){
                      // insert into customer account balance table in database
                      $sBal = 0.00;
                      $cBal = 0.00;
                      $loan = 0.00;
                      $tranStatus = "OPENED";
                      $stmt3 = $conn->prepare("INSERT INTO real_acc(user_ref,cBal,sBal,loanBal,status) VALUES (?,?,?,?,?)");
                      $stmt3->bind_param('sssss',$reg_Ref,$cBal,$sBal,$loan,$tranStatus);
                      $stmt3->execute();
                      if($stmt3){
                        // insert into otp table just once via registration
                        $firstOtpCode = rand(000000,999999);
                        $otpStatus = "YES";
                        $stmt4 = $conn->prepare("INSERT INTO otp(user_ref,otp_code,username,status) VALUES (?,?,?,?)");
                        $stmt4->bind_param('ssss',$reg_Ref,$firstOtpCode,$user,$otpStatus);
                        $stmt4->execute();
                        if($stmt4){
                          // sendMail send successful registration message to customer that registered
                          sendMail($fName, $email, $check_Acc,$sav_Acc,$user);
                          echo "<script>window.location.href='acknowledgement'</script>";
                        }
                      }
                    }
                  }else{
                    echo "<script>alert('Registration Failure')</script>";
                  }
                }else{
                  $status = "online failed to insert";
                }
              }else{
                $status = "failed to insert to users";
              }
            }else{
              $status = "could not upload files";
            }
          }else{
            $status = "failed to be uploaded successfully";
          }
      }
    }
  }

  function sendMail($fName, $email, $sav_Acc,$check_Acc,$user){
    $mail = new PHPMailer(true);
    
    $mail->setFrom('wellqotz@wellspringeu.com','WELLSPRING');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'CUSTOMER\'S ACCOUNT REGISTRATION';
    $mail->Body = 
    '
      <h3>Dear '.$fName.',</h3>
      <h3>Wellspring Bank</h3>
      <h3>ACCOUNT NOTIFICATION</h3>
      <p>Dear '.$fName.', Thank you so much for allowing us to help you with your recent account opening. We are committed to
        providing our customers with the highest level of service and the most innovative banking products possible. We are
        glad you chose us a s your financial institution and hope you will take advantage of our wide variety of savings,
        investment and loan products, all designed to meet your specific needs.
      </p>
      <p>
        For more detailed i nformation about any of our products, loans, credit cards or other financial services, please refer to
        our website. You many contact us by phone.
      </p>
      <p>Your WELLSPRING account numbers Are:
            <ul>
              <li>Checking Account Number: '.$check_Acc.'</li>
              <li>Savings Account Number: '.$sav_Acc.'</li>
          </ul>
      
      </p>
      <h3 style="background-color: black; color: white;">  ONLINE BANKING DETAILS:</h3>
      <ul>
        <li style="list-style: none; margin: 0;">Username : '.$user.'</li>
        <li style="list-style: none; margin: 0;">Account name : '.$fName.' </li>
      </ul>
      <hr>
      <h5>Regards</h5>
      <h5 style="color: yellow;">Wellspring Bank</h5>
      <p> 
        Please do not hesitate to contact us should you have any question.
        We will contact you in the near future to ensure you are completely satisfied with our services.
      </p>
      <p>Copyright &copy; 2022 SPRING_INC All rights reserved.</p>
    ';
    try {
      $mail->send();
        // echo "Email has been sent successfully";
    }catch (Exception $e) {
      $mail->ErrorInfo;
    }   
  }
  
?> 