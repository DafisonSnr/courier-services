<?php
require_once './../../config/config.php';
require_once './../../includes/reg-header.php';
$codeRef = $_POST['codeRef'];
$status = "";
$viewCodes = mysqli_query($conn, "SELECT * FROM require_codes WHERE cust_id = '$codeRef'");
if(mysqli_num_rows($viewCodes)>0) {?>
    <?php $row = mysqli_fetch_assoc($viewCodes)?>
    <div class="view-container" id="remove">
        <span class="closeBtn" onclick="window.location.reload();">&times</span>
        <?php 
                echo "<table class='table table-striped'>
                    <tr>
                        <th>TAX-CODE</th>
                        <th>ATC-CODE</th>
                        <th>IMF-CODE</th>
                        <th>COT-CODE</th>
                    </tr>";
                    echo "<tr>";
                        echo   "<td>".$row['tax_code']."</td>";
                        echo   "<td>".$row['nft_code']."</td>";
                        echo  "<td>".$row['imf_code']."</td>";
                        echo  "<td>".$row['cot_code']."</td>";
                    echo  "</tr>";
            echo "</table>";
        ?>
    </div>
<?php }else{?>
    <div class="view-container">
        <span class="closeBtn" onclick="window.location.reload();">&times</span>
        <?php echo "<table class='table table-striped'>
                    <tr>
                        <th>COTCODE</th>
                        <th>NFTCODE</th>
                        <th>IMFCODE</th>
                    </tr>";
                    echo "<tr>";
                        echo   "<td colspan='4' class='text-center text-danger'>NO CODE FOUND</td>";
                        
                    echo  "</tr>";
            echo "</table>";
        ?>
    </div>
<?php }

?>
<style>
       .closeBtn{
           float: right;
           font-size: 30px;
           color: #f00;
           cursor: pointer;
       }
    
       .view-container{
           background-color: #fff;
           width: auto;
           margin-top: 60px;
           padding: 20px;
           overflow-x: scroll;
           -webkit-animation: animatezoom;
           animation: animatezoom 0.6s;
       }
       @-webkit-keyframes animatezoom{
           from {transform: scale(0)}
           to {transform: scale(1)}
       }
       @keyframes animatezoom{
           from {transform: scale(0)}
           to {transform: scale(1)}
       }
   </style>
