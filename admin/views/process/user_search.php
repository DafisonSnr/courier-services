<?php
require_once './../../config/config.php';
require_once './../../includes/reg-header.php';
$search = $_POST['search'];
$sn = 1;


if(isset($_POST['yes'])){
    $user_Ref = $_POST['userRef'];
    $deleteSql = mysqli_query($conn, "DELETE FROM users WHERE reg_Ref = '$user_Ref'");
    if($deleteSql){
        $sqlCheck = mysqli_query($conn, "SELECT * from OnBanking WHERE user_ref='$user_Ref'");
        if(mysqli_num_rows($sqlCheck)>0){
            $sqlOnDelete = mysqli_query($conn, "DELETE FROM OnBanking WHERE user_ref='$user_Ref'");
            if($sqlOnDelete){
                echo "<script>alert('Customer Details have been deleted successfully');window.location.href='./../delete_cust.php'</script>";
            }else{
                echo "<script>alert('Customer failed to be deleted on OnBanking Table');window.location.href='./../delete_cust.php'</script>";
            }
        }
    }else{
        echo "<script>alert('Customer failed to be deleted');window.location.href='./delete_cust.php'</script>";
    }

}
?>

<table class="table table-striped  table-hover" >
    <thead>
        <tr>
            <th>#</th>
            <th>IMAGE</th>
            <th>NAME</th>
            <th>EMAIL</th>
            <th>REG-DATE</th>
            <th colspan="3">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $team = $search; 
            $users = mysqli_query($conn,"SELECT * FROM users WHERE Names LIKE '%$team%' AND role='customer' ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($users)){?>
        <tr>
            <td><?=$sn++?></td>
            <td><img style="width: 100px;" src="<?=$row['photo']?>" alt="image"></td>
            <td><?=$row['Names']?></td>
            <td><?=$row['email']?></td>
            <td><?=$row['reg_date']?></td>
            <td>
                <a href="?delete=<?=base64_encode($row['reg_Ref'])?> " class="btn btn-sm btn-primary">DELETE</a>
            </td>
        </tr>
        <?php }?>;
    </tbody>
</table>