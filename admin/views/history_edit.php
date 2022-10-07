<?php
    require_once '../config/config.php';
    require_once '../includes/reg-header.php';
    if(isset($_GET['edit'])){
        $user_ref = base64_decode($_GET['edit']);
        $sql_hist = mysqli_query($conn, "SELECT * FROM acc_history WHERE user_ref='$user_ref' ORDER BY id DESC");
    }
    
    $sn = 1;
    function timeIndictor(){
        $hour = date('H');
        if($hour > 17){
            echo "Good Evening" ;
        }elseif($hour>12){
            echo "Good Afternoon";
        }else{
            echo "Good Morning" ;
        }
        // $dayTime = ($hour > 17) ? 'Evening' : (($hour>12) ? 'Afternoon' : 'Morning');
        // echo 'Good'.$dayTime;
    }
?>
 

<!-- <select name="" id="edit_show" onchange="editFunction()" style="width: 268px; padding: 10px 50px 10px 10px; margin: 50px 10px;color: #fff; border: none; font-size: 22px; font-weight: bold;
    line-height: 1;
    border-radius: 5px;
    background: url(http://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/br_down.png) no-repeat right #ddd;
    -webkit-appearance: none;
    background-position-x: 244px;"> -->
    
  
<div class="show-container" id="showEditCon"  >
<div id="showEdit" class="show-edit" stye="float: right"></div>
</div>
<div class="back-dashboard" style="height: 25px">
    <a href="history.php"><i class="fa-solid fa-arrow-left-long" style="font-size: 40px; color: red; margin: 50px 0 30px 100px;"></i></a> 
</div>
<div id="show_delete"></div>
<table class="table table-striped bg-white" style="margin-top: 70px;">
<!-- <input type="text" name="" id="" onkeypress="return (event.charCode !=8 && event.charCode == 0 ||(event.charCode >= 47 && event.charCode <= 57))"> -->

    <thead class="bg-dark text-white  mt-5">
        <tr>
            <th>#</th>
            <th>TRAN_REF</th>
            <th>ACC_NAME</th>
            <th>ACC_NO</th>
            <th>BANK</th>
            <th>CUR</th>
            <th>AMOUNT</th>
            <th>TYPE</th>
            <th>STATUS</th>
            <th>DATE</th>
            <th colspan="3">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($sql_hist)){?>
            <tr>
                <td ><?=$sn++?></td>
                <td><?=$row['tran_Ref']?></td>
                <td><?=$row['beneficiary_name']?></td>
                <td><?=$row['beneficiary_acc']?></td>
                <td><?=$row['beneficiary_bank']?></td>
                <td><?=$row['currency']?></td>
                <td class="table-info"><?=number_format($row['amt'],2)?></td>
                <td><?=$row['Tran_Typ']?></td>
                <td>
                    <a href="#" value="<?=$row['tran_Ref']?>" id="approval">
                        <?php if($row['tran_status'] == "PENDING"){?>
                            <span class="btn btn-danger btn-sm text-white"><?=$row['tran_status']?></span>
                        <?php }else{?>
                            <span class="btn btn-sm " style="background-color: blue; color: #fff; font-weight: bold"><?=$row['tran_status']?></span>
                        <?php  }?>
                    </a>
                </td>
                <td><?=$row['hist_date']?></td>
                <td ><a href="#" value="<?=$row['id']?>" class="btn btn-danger" id="delete">Delete</a></td>
                <td ><a href="#" value="<?=$row['tran_Ref']?>" class="btn btn-danger" id="edit_show">Edit</a></td>
       <?php }?>
    </tbody>
</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./../js/script.js"></script>