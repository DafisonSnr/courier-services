<?php
require_once './../../config/config.php';
$user = $_POST['user'];

$sql = mysqli_query($conn, "SELECT * FROM require_codes WHERE cust_id='$user'");
if(mysqli_num_rows($sql)<1) {
    $tax = "TX".rand(000000,999999);
    $atc = "ATC".rand(000000,999999);
    $imf = "IMF".rand(000000,999999);
    $cot = "CT".rand(000000,999999);

    $stmt = $conn->prepare("INSERT INTO require_codes(cust_id,tax_code,nft_code,imf_code,cot_code) VALUES(?,?,?,?,?)");
    $stmt->bind_param('sssss', $user,$tax,$atc,$imf,$cot);
    $stmt->execute();
    if($stmt){
        header("Content-Type: application/json");
        $data = array('status' => 200, 'data' => $stmt);
        echo json_encode($data);
    }else{
        $data = array('status' => 500);
        echo json_encode($data);
    }
    
}else{
    $data = array('status' => 501);
        echo json_encode($data);
}

?>