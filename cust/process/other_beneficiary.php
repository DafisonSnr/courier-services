<?php
session_start();
require_once "../config/config.php";

$acc = $_POST['acc'];
$name = $_POST['name'];
$bank =$_POST['bank'];
$routing = $_POST['rout'];
$swiftCode = $_POST['swift'];
$user_Ref = $_SESSION['user']['user_ref'];
$date = date("Y-m-d H:i:s");
$sql = mysqli_query($conn, "SELECT * FROM other_beneficiary WHERE acc_Num='$acc' AND cust_Ref='$user_Ref'");
if(mysqli_num_rows($sql) === 0){
    $beneficiary_Ref = "BEN".rand(000000,999999);
    $sqlInsert = "INSERT INTO other_beneficiary(cust_Ref,beneficiary_Ref,acc_Num,name,bank,swift,routing,saved_Date)VALUES('$user_Ref','$beneficiary_Ref','$acc','$name','$bank','$swiftCode','$routing','$date')";
    $sqlConnect = $conn->query($sqlInsert);
    if($sqlConnect){
        // header("content-type: application/text");
        echo "success";
       
    }else {
        echo "failed to insert";
    }
}
?>
