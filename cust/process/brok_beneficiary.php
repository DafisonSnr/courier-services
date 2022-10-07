<?php
session_start();
require_once "../config/config.php";

$acc_Num = $_POST['acc_Num'];
$name = $_POST['name'];
$type =$_POST['type'];
$user_Ref = $_SESSION['user']['user_ref'];
$date = date("Y-m-d H:i:s");
$sql = mysqli_query($conn, "SELECT * FROM brook_beneficiary WHERE acc_Num='$acc_Num' AND cust_Ref='$user_Ref'");
if(mysqli_num_rows($sql) === 0){
    $beneficiary_Ref = "BEN".rand(000000,999999);
    $sqlInsert = "INSERT INTO brook_beneficiary(cust_Ref,beneficiary_Ref,acc_Num,name,acc_Type,saved_date)VALUES('$user_Ref', '$beneficiary_Ref','$acc_Num','$name','$type','$date')";
    $sqlConnect = $conn->query($sqlInsert);
    if($sqlConnect){
        echo "success";
    }
}
?>


