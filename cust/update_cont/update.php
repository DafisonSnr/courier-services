<?php
require_once './config/config.php';

$old = $new_Pass = $confrim = '';
$old_err = $new_err = $confirm_err = '';
$status2 = '';
if(isset($_POST['change_pass'])){
    $user_ref = $_POST['user'];
    $old_input = $_POST['old_password'];
    $new = $_POST['new_password'];
    if(empty($old_input)){
        $old_err = "This field is required";
    }else{
        $sql = mysqli_query($conn, "SELECT * FROM OnBanking WHERE user_ref='$user_ref'");
        $row = mysqli_fetch_assoc($sql);
        $fetchPass = $row['password'];
        if(password_verify($old_input, $fetchPass)){
            if($new == $old_input){
                $new_err = "Please use a different password(Password can,t be same as old password)";
            }else{
                $old = $old_input;
            }
        }else{
            $old_err = "Invalid Old Password";
        }
    }
    if(empty($_POST['new_password'])){
        $new_err = "This field is required";
    }else{
        $upperCase = preg_match('@[A-Z]@',$new);
        $lowerCase = preg_match('@[a-z]@',$new);
        $number = preg_match('@[0-9]@',$new);
        $character = preg_match('@[^\w]@',$new);
        if(!$upperCase || !$lowerCase || !$number || strlen($new)<8){
            $new_err = "Passwords must contain at least one Uppercase letter and at least one 
            Lowercase letter and one digit and one Special character with password length greater than 8";
        }else{
            $new_Pass = password_hash($new, PASSWORD_DEFAULT);
        }
    }
    if(empty($_POST['confirm'])){
        $confirm_err = "This field is required";
    }else if($new != $_POST['confirm']){
        $confirm_err = "Password do not match";
    }
    if(empty($confirm_err) && empty($new_err) && empty($old_err)){
        if($sql){   
            $sql = mysqli_query($conn, "UPDATE OnBanking SET password='$new_Pass' WHERE user_ref='$user_ref'");
            if($sql){
                echo "<script>alert('Password have been changed successfully');window.location.href='./settings'</script>";
            }else{
                echo "<script>alert('Failed to change Password');window.location.href='./settings'</script>";
            }
        }
    }
}


//forgot password
$user = $fPass = $cForgot = $answer = '';
$user_er = $fPass_er = $cForgot_er = $answer_er = '';
if(isset($_POST['forgot_pass'])){
    $user_ref = $_POST['fPass'];
    $user_Input = $_POST['username'];
    $new = $_POST['password'];
    $answerData = $_POST['DatabaseAns'];
    $sql = mysqli_query($conn, "SELECT * FROM OnBanking WHERE username='$user_Input'");
    if($user_Input == ''){
        $user_er = "This field is required";
    }elseif(mysqli_num_rows($sql)>0){
        $user = $user_Input;
    }else{
        $user_er = "Invalid username";
    }
    if(empty($_POST['password'])){
        $fPass_er = "This field is required";
    }else{
        $upperCase = preg_match('@[A-Z]@',$new);
        $lowerCase = preg_match('@[a-z]@',$new);
        $number = preg_match('@[0-9]@',$new);
        $character = preg_match('@[^\w]@',$new);
        if(!$upperCase || !$lowerCase || !$number || strlen($new)<8){
            $fPass_er = "Passwords must contain at least one Uppercase letter and at least one 
            Lowercase letter and one digit and one Special character with password length greater than 8";
        }else{
            $fPass = password_hash($new, PASSWORD_DEFAULT);
        }
    }
    if(empty($_POST['f-confirm'])){
        $cForgot_er = "This field is required";
    }else if($new != $_POST['f-confirm']){
        $cForgot_er = "Password do not match";
    }
    if(empty($_POST['answer'])){
        $answer_er = "This field is required";
    }elseif($_POST['answer'] != $answerData){
        $answer_er = "Answers do not match";
    } else {
        $answer = $_POST['answer'];
    }
    if(empty($user_er) && empty($fPass_er) && empty($cForgot_er) && empty($answer_er)){
        $sql = mysqli_query($conn, "SELECT * FROM OnBanking WHERE username='$user' AND answer='$answer'"); 
        if($sql){
            $rowFetch = mysqli_fetch_assoc($sql);
            $fetchPassword = $rowFetch['password'];
            if(password_verify( $new ,$fetchPassword)){
                $fPass_er = "Please use a different password(Password can,t be same as old password)"; 
            }else{
                $sql = mysqli_query($conn, "UPDATE OnBanking SET password='$fPass' WHERE username='$user' AND user_ref='$user_ref'");
                if($sql){
                    echo "<script>alert('Password have been changed successfully');window.location.href='./settings'</script>";
                }else{
                    echo "<script>alert('Failed to change Password');window.location.href='./settings'</script>";
                }
            }
        }
        
    }
}
// ADD PIN 
$pin = $comfirmPin = '';
$pin_er = $comPin_er = '';

if(isset($_POST['submit_pin'])){
    $user_ref = $_POST['fPin'];
    $sql = mysqli_query($conn, "SELECT  * FROM tranpin WHERE user_ref='$user_ref'");
    $row = mysqli_fetch_assoc($sql);
    if(empty($_POST['pin'])){
        $pin_er = "This field is required";
    }else{
        $pin = password_hash($_POST['pin'],PASSWORD_DEFAULT);
    }
    if(empty($_POST['confirm_pin'])){
        $comPin_er = "This field is required";
    }elseif($_POST['confirm_pin'] != $_POST['pin']){
        $comPin_er = "Passwords do not match";
    }
    else{
        $comfirmPin = $_POST['confirm_pin'];
    }
    if(empty($pin_er) && empty($comPin_er)){
        if($stmt = mysqli_prepare($conn, "INSERT INTO tranpin(user_ref,pin) VALUES(?,?)")){
            mysqli_stmt_bind_param($stmt,"ss",$user_ref,$pin);
            mysqli_stmt_execute($stmt);
            if(mysqli_affected_rows($conn)>0){
                echo "<script>alert('Transaction Pin has been created successfully');window.location.href='./settings'</script>";
            }else{
                echo "<script>alert('Transaction Pin failed to be created');window.location.href='./settings'</script>";
            }

        }
    }

}

//chnage transactiono pin
$old_pin = $new_pin = $com_pin = '';
$old_pin_er = $new_pin_er = $com_pin_er = '';
$status3 = "";
if(isset($_POST['change_pin'])){
    $user_ref = $_POST['cPin'];
    $old_Input = $_POST['old_pin'];
    $new_Input = $_POST['new_pin'];
    if(empty($_POST['old_pin'])){
        $old_pin_er = "This field is required";
    }else{
        $sql = mysqli_query($conn,"SELECT * FROM tranpin WHERE user_ref='$user_ref'");
        if(mysqli_num_rows($sql) > 0){
            $row1 = mysqli_fetch_assoc($sql);
            $fetchPin = $row1['pin'];
            if(password_verify($old_Input,$fetchPin)){
                $old_pin = $old_Input;
                if($new_Input == $old_pin){
                    $new_pin_er = "Please use a different Pin(Transaction Pin can't be same as old Pin)";
                }
            }else{
                $old_pin_er = "Incorrect Pin";
            }
        }else{
            $status3 = "You have not created any transaction Pin";
        }
    }
    if(empty($_POST['new_pin'])){
        $new_pin_er = "This field is required";
    }else{
        $new_pin = password_hash($new_Input,PASSWORD_DEFAULT);
    }
    if(empty($_POST['conf_pin'])){
        $com_pin_er = "This field is required";
    }elseif($_POST['conf_pin'] != $new_Input){
        $com_pin_er = "Pins do not match";
    }else{
        $com_pin = $_POST['conf_pin'];
    }
    if(empty($com_pin_er) && empty($new_pin_er) && empty($old_pin_er) && empty($status3)){
        $sql = mysqli_query($conn,"UPDATE tranpin SET pin = '$new_pin' WHERE user_ref = '$user_ref'");
        if($sql) {
            echo "<script>alert('Your transaction pin has been changed');window.location.href='./settings'</script>";
        }else{
            echo "<script>alert('Transaction pin failed to change');window.location.reload()</script>";
        }
    }
}

// remove pin from table
if(isset($_POST['yes'])){
    $user_ref = $_POST['removePin'];
    $sql = mysqli_query($conn, "SELECT * FROM tranpin WHERE user_ref = '$user_ref'");
    if(mysqli_num_rows($sql)>0){
        $sql = mysqli_query($conn, "DELETE FROM tranpin WHERE user_ref = '$user_ref'");
        if($sql){
            echo "<script>alert('Your Transaction pin has been removed');window.location.href='./settings'</script>";
        }else{
            echo "<script>alert('Failed to remove transaction pin');window.location.href='./settings'</script>";
        }
    }else{
        echo "<script>alert('NO transaction pin found!Please create Pin');window.location.href='./settings'</script>";
    }
}
// secret question resting
$q_reset = $a_reset = '';
$q_reset_er = $a_reset_er = '';
if(isset($_POST['reset'])){
    $user_ref = $_POST['reset_sec'];
    $q_check = $_POST['question_reset'];
    if(empty($_POST['question_reset'])){
        $q_reset_er = "This Field is required";
    }
    else{
        $specChar = "@[^\w]@"; 
        $removeSpec = preg_replace($specChar, " ",$q_check);
        $q_reset = $removeSpec."?";
        
    }
    if(empty($_POST['answer_reset'])){
        $a_reset_er = "This Field is required";
    }else{
        $a_reset = $_POST['answer_reset'];
    }
    if($q_reset_er == "" && $a_reset_er == ""){
        $sql = mysqli_query($conn, "UPDATE OnBanking SET question='$q_reset', answer='$a_reset' WHERE user_ref = '$user_ref'");
        if($sql){
            echo "<script>alert('Your secret Question/Answer has been reset');window.location.href='./settings';</script>";
        }else{
            echo "<script>alert('failed to reset');window.location.href='./settings';</script>";
        }
    }
}
//add/remove login authentication

if(isset($_POST['enable'])){
    $user_ref = $_POST['enable_dis'];
    $sql = mysqli_query($conn, "SELECT * FROM otp WHERE user_ref = '$user_ref'");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_array($sql);
        if($row['status'] == "YES"){
            $sql = mysqli_query($conn, "UPDATE otp SET status = 'NO' WHERE user_ref = '$user_ref'");
            if($sql){
                echo "<script>alert('Login Authentication has been successfully disabled.');window.location.href='./settings';</script>";
            }else{
                echo "<script>alert('faile to deactivated')<script>";
            }
        }else{
            $sql = mysqli_query($conn, "UPDATE otp SET status = 'YES' WHERE user_ref = '$user_ref'");
            if($sql){
                echo "<script>alert('Login Authentication has been successfully enabled.');window.location.href='./settings';</script>";
            }else{
                echo "<script>alert('faile to activated')<script>";
            }
        }
    }

    } 
?>