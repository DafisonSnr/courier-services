$(document).ready(function(){
    $("#submit-otp").click(function(e){
        e.preventDefault();
        let authCode = $("#otp").val();
        if(authCode == ""){
            $("#otp_er").html("This Field is required");
        }else{
            $("#otp_er").html("")
            $.ajax({
                url: "./process/autheticate.php",
                type: "POST",
                dataType: "json",
                data:{otp:authCode},
                beforeSend: function(){
                    $(".spinner-background").show();
                },
                success: function(data){
                    setTimeout(function(){
                        if(data.status == "ok"){
                            window.location.href = "./../client/dashboard.php";
                        }else{
                            alert("Invalid OTP Code");
                            window.location.reload();
                        }
                    },2000)
                }
            })
        }
    })
})