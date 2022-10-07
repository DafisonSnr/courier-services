<?php
session_start();
    if(!isset($_SESSION['code'])){
        header("location: ../rtcbrk=log_in");
    }else{
        $now = time();
        if($now > $_SESSION['expire']){
            session_destroy();
            echo "<script>alert('Your session has expired!');window.location.href='./rtcbrk=log_in'</script>";
        }
    }

?>


