<?php
require_once './../../config/config.php';
require_once './../../includes/reg-header.php';
$search = $_POST['search'];
$sn = 1;
?>

<div class="column-large" id="col-large">
            <?php 
                if(isset($_GET['profile'])){
                    $user_ref = $_GET['profile'];
                    $country = mysqli_query($conn, "SELECT * FROM country");
                    $sql = mysqli_query($conn, "SELECT * FROM users WHERE reg_Ref='$user_ref'");
                    $fetch = mysqli_fetch_assoc($sql);
                    
                    ?>
                <form action="" method="POST" class="my-5 mx-auto p-4 shadow-lg bg-light w-50 h-100">
                    <input type="hidden" name="userRef" value="<?php echo $user_ref?>" id="">
                    <label for="">Account Name</label>
                    <input type="text" name="names" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['Names']?>">
                    <span class="d-block text-danger"><?=$name_er?></span>
                    <label for="">Account Type</label>
                    <input type="text" name="type" class="form-control form-control-sm w-100 my-3" placeholder="Account Type" value="<?=$fetch['acc_Type']?>">
                    <span class="d-block text-danger"><?=$typ_er?></span>
                    <label for="">DOB(Date of Birth)</label>
                    <input type="text" name="dob" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['dob']?>">
                    <span class="d-block text-danger"><?=$dob_er?></span>
                    <label for="">Gender</label>
                    <input type="text" name="gender" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['gender']?>">
                    <span class="d-block text-danger"><?=$gen_er?></span>
                    <label for="">Marital Status</label>
                    <input type="text" name="marital" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['marital']?>">
                    <span class="d-block text-danger"><?=$marit_er?></span>
                    <select name="country" id="">
                        <option value="">Select Country</option>
                        <?php while($rowCon = mysqli_fetch_array($country)){?>
                            <option value="<?=$rowCon['name']?>"><?=$rowCon['name']?></option>
                      <?php  }?>
                    </select>
                    <span class="d-block text-danger"><?=$con_er?></span>
                    <label for="">City</label>
                    <input type="text" name="city" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['city']?>">
                    <span class="d-block text-danger"><?=$city_er?></span>
                    <label for="">Zip Code</label>
                    <input type="text" name="zip" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['zip']?>">
                    <span class="d-block text-danger"><?=$zip_er?></span>
                    <label for="">SSN(Social Security)</label>
                    <input type="text" name="ssn" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['ssn']?>">
                    <label for="">Phone Number</label>
                    <input type="text" name="phone" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['phone']?>" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                    <span class="d-block text-danger"><?=$phone_er?></span>
                    <label for="">Email Address</label>
                    <input type="text" name="email" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['email']?>">
                    <span class="d-block text-danger"><?=$email_er?></span>
                    <label for="">Occupation</label>
                    <input type="text" name="work" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['work']?>">
                    <span class="d-block text-danger"><?=$work_er?></span>
                    <label for="">Next Of Kin</label>
                    <input type="text" name="kin" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['kin']?>">
                    <span class="d-block text-danger"><?=$kin_er?></span>
                    <label for="">Account Number</label>
                    <input type="text" name="acc" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['acc_No']?>" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                    <span class="d-block text-danger"><?=$acc_er?></span>
                    <select name="currencies" id="">
                        <option value="">Select Currency</option>
                        <option value="$">Dollar</option>
                        <option value="€">Euro</option>
                        <option value="£">Pound</option>
                    </select>
                    <span class="d-block text-danger"><?=$curr_er?></span>
                    <label for="">Registration Date</label>
                    <input type="text" name="date" class="form-control form-control-sm w-100 my-3" value="<?=$fetch['reg_date']?>">
                    <span class="d-block text-danger"><?=$date_er?></span>
                    <div class="buttons-container mx-auto w-50">
                        <a href="./edit_profile.php" class="btn btn-info">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="update">Update</button>
                    </div>
                   
                </form>
           
            <?php }else{?>
           
            <table class="table table-striped  table-hover" id="searchShow">
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
                                <a href="?profile=<?=base64_encode($row['reg_Ref'])?> " class="btn btn-sm btn-primary">EDIT</a>
                            </td>
                        </tr>
                    <?php }?>;
                </tbody>
            </table>
            <?php } ?>
        </div>