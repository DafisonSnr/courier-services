<?php
require_once './includes/dash.php';
    require_once './config/config.php';
    $id = $_SESSION['user']['user_ref'];
    $sqlUser = "SELECT * FROM users WHERE reg_Ref='$id'";
    $resultSql = $conn->query($sqlUser );
    $fetch = mysqli_fetch_assoc($result);

  // function timeIndicator(){
  //    /* This sets the $time variable to the current hour in the 24 hour clock format */
  //    $time = date("H");
  //    /* Set the $timezone variable to become the current timezone */
  //    $timezone = date("e");
  //    /* If the time is less than 1200 hours, show good morning */
  //    if ($time < "12") {
  //        echo "Good morning";
  //    } else
  //    /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
  //    if ($time >= "12" && $time < "17") {
  //        echo "Good afternoon";
  //    } else
  //    /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
  //    if ($time >= "17" && $time < "19") {
  //        echo "Good evening";
  //    } else
  //    /* Finally, show good night if the time is greater than or equal to 1900 hours */
  //    if ($time >= "19") {
  //        echo "Good night";
  //    }
  //   echo $time;
  // }
  
  function timeIndicator2(){
    $hour = date('H');
    $dayTerm = ($hour > 17) ? "Evening" : (($hour > 12) ? "Afternoon" : "Morning");
    echo "Good " . $dayTerm;
    
  }

  $file_er = "";
  if(isset($_POST['upload'])){
    $uploads = "uploads/";
    $target_dir = $uploads. basename($_FILES['fileUpload']['name']);
    $image_file = strtolower(pathinfo($target_dir, PATHINFO_EXTENSION));
    $uploadOk = 1;
   
    if(file_exists($target_dir)){
      $file_er = "File uploaded already exists";
      $UploadOk = 0;
    }
    if($_FILES['fileUpload']['size']>5000000){
      $file_er = "File is too large";
      $uploadOk = 0;
    }
    if($image_file != "jpg" && $image_file != "png" && $image_file != "jpeg" && $image_file != "gif" && $image_file != "JPG" ){
      $file_er = "Image is not supported";
      $uploadOk = 0;
    }
    if($uploadOk == 0){
      $file_er = "File did not upload successfully";
      $uploadOk = 0;
    }else{
      if(move_uploaded_file($_FILES['fileUpload']['tmp_name'], $target_dir)){
        $sql = mysqli_query($conn, "UPDATE OnBanking SET image='$target_dir' WHERE user_ref='$id'");
        if($sql){
          echo "<script>alert('profile has been uploaded');window.location.href='./dashboard.php'</script>";
        }else{
          echo "<script>alert('profile failed to upload');window.location.href='./dashboard.php'</script>";
          
        }
      }
    } 
  }

  $status = '';
  if(isset($_POST['update'])){
    $uploads = "uploads/";
    $uploadOk = 1;
    $target_dir = $uploads . basename($_FILES['updatedFile']['name']);
    $image_file = strtolower(pathinfo($target_dir, PATHINFO_EXTENSION));
    if(file_exists($target_dir)){
      $status = "This file already exists";
      $uploadOk = 0;
    }
    if($_FILES['updatedFile']['size']> 5000000){
      $status = "file size is too big";
      $uploadOk = 0;
    }
    if($image_file != "jpg" && $image_file != "png" && $image_file != "jpeg" && $image_file != "gif" && $image_file != "JPG" ){
      $file_er = "Image is not supported";
      $uploadOk = 0;
    }
    if($uploadOk == 0){
      $file_er = "File did not upload successfully";
      $uploadOk = 0;
    }else{
      if(move_uploaded_file($_FILES['updatedFile']['tmp_name'], $target_dir)){
        $sql = mysqli_query($conn, "UPDATE OnBanking SET image='$target_dir' WHERE user_ref='$id'");
        if($sql){
          echo "<script>alert('Profile has been updated');window.location.href='./dashboard.php'</script>";
        }else{
          echo "<script>alert('Profile failed to been updated');window.location.href='./dashboard.php'</script>";
        }
      }
    }


  }
  if(isset($_POST['delete'])){
    $sql = mysqli_query($conn, "SELECT * FROM OnBanking WHERE user_ref='$id'");
    if(mysqli_num_rows($sql)>0){
      $sql = mysqli_query($conn, "UPDATE OnBanking SET image='NULL' WHERE user_ref='$id'");
      if($sql){
        echo "<script>alert('Image has been deleted successfully');window.location.href='./dashboard.php'</script>";
      }else{
        echo "<script>alert('Failed to delete image');window.location.href='./dashboard.php'</script>";
      }
    }
  }
                   
?>

