<?php
    require_once '../config/config.php';
    require_once './includes/reg-header.php';
   

?>  
<script>
    
</script>
<style>
    .container-cot{
        width: 100%;
        margin: 150px 0;
    }
    input{
        width: 100%;
    }
    .submit{
        margin-top: 20px;
        background-color: blue;
        color: white;
    }
</style>
<div class="container-cot">
    <form action="" method="post" id="cot-form"  style="display: none">
        <input type="hidden"  id="ctRef" value="<?php echo $userRef?>" placeholder="d">
        <input type="text" id="cot" placeholder="Enter COT code to continue">
        <span id="cot_error" class="text-danger d-block"></span> 
        <button type="submit" id="cotSubmit" class="submit">CONTINUE</button>
    </form>

    <form action="" method="post" id="nft-form" style="display: none">
    <input type="hidden"  id="nfRef" value="<?php echo $userRef?>">
        <input type="text" id="nft" placeholder="Enter NFT code">
        <span id="nft_error" class="text-danger d-block"></span> 
        <button type="submit" id="nftSubmit" class="submit">CONTINUE</button>
    </form>
    <form action="" method="post" id="imf-form" style="display: none">
    <input type="hidden" id="imRef" value="<?php echo $userRef?>">
        <input type="text" id="imf" placeholder="Enter IMF code">
        <span id="imf_error" class="text-danger d-block"></span> 
        <button type="submit" id="imfSubmit" class="submit">CONTINUE</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11" customClass: swal-size-sm></script>
