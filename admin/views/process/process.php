<?php
require_once './../../config/config.php';
require_once './../../includes/reg-header.php';
    $edited = $_POST['edit'];
    $editSql = mysqli_query($conn, "SELECT * FROM acc_history WHERE  tran_Ref='$edited'");
    $row = mysqli_fetch_assoc($editSql);

    

?>

<div class="container-form" id="form-container">
    <form action="" method="POST" enctype="multipart/form animated" class="animted">
        <input type="hidden" id="tranId" value="<?php echo $edited; ?>" >
        <input type="text" id="name" value="<?=$row['beneficiary_name']; ?>">
        <input type="text" id="acc_num" value="<?=$row['beneficiary_acc']?>" >
        <input type="text"  id="bank" value="<?=$row['beneficiary_bank']?>">
        <input type="text" id="amt" value="<?=$row['amt']?>" >
        <input type="text" id="date" value="<?=$row['hist_date']?>">
       <button class="cancel" onclick="document.getElementById('form-container').style.display='none'">Cancel</button>
       <button  type="submit" id="update">Update</button>
    </form>
</div>


<style>
.container-form{
    display: block;
    width: 400px;
    padding-bottom: 20px;
    background-color: #fff; 
    color: #fff;
    margin-bottom: 20px;
    text-align: center;
}

input{
    width: 90%;
    padding: 7px 0;
    margin-top: 20px;
    font-size: 20px;
}
button{
    margin-top: 20px;
    background-color: blue;
    padding: 10px 20px;
    color: #fff;
    font-size: 20px;
    border: none;
}
.cancel{
    background-color: red;
    margin-right: 20px;
}
</style>

<script>
    $(document).ready(function(){
        $("#update").on("click", function(e){
            e.preventDefault();
            let accName = $("#name").val();
            let accNumber = $("#acc_num").val();
            let bank = $("#bank").val();
            let amt = $("#amt").val();
            let date = $("#date").val();
            let tranId = $("#tranId").val();
            if(accName == ""){
                $("#name_er").html("Field is required");
            }
            if(accNumber == ""){
                $("#acc_er").html("Field is required");
            }
            if(bank == ""){
                $("#bank_er").html("Field is required");
            }
            if(amt == ""){
                $("#amt_er").html("Field is required");
            }
            if(date == ""){
                $("#date_er").html("Field is required");
            }
            $.ajax({
                url: './edit_hist.php',
                type: "POST",
                dataType: "json",
                data: {name:accName,acc:accNumber,bank:bank,amt:amt,date:date, tranId:tranId},
                beforeSend: function(){
                    $("#update").html("Updating...");
                },
                complete: function(){
                    setTimeout(()=>{
                    $("#update").html("Update");
                    alert("History updated successfully");
                        window.location.reload();
                    },3000);
                }
            })
        })
    })
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./../js/script.js"></script>