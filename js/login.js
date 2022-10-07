
$(function() {
    $('#login_submit').on("click", function(event){
        event.preventDefault();
        let userInput = $('#username').val();
        let passInput = $('#password').val();
        let ipAddress = $('#ip').val();
        if(userInput  == ""){
            $('#user_error').html("Enter your username");  
        }else{
            $('#user_error').html("")  
        }
        if(passInput  == ""){
            $('#pass_error').html("Enter your password");
        }else{
            $('#pass_error').html("")
        }
        if(userInput != "" && passInput != ""){
            $.ajax({
                url: "./process/check.php",
                type: "POST",
                dataType: "json",
                data:{user:userInput,pass:passInput},
                beforeSend: function(){
                    $('#login_submit').html("<span class='spinal' style='display: block;'></span>");
                    $(".cover").show();
                },
                success: function(response){
                    if(response.status == "success"){
                        $("#show-otp-form").show();
                        let userName = response.data.username;
                        $("#userInput").val(userName);
                        $("#login-form").hide();
                        $(".mod").hide();
                        $("#header").hide();
                        $(".hidden-page").hide();
                        $(".cover").hide();
                        // document.getElementById('hidden-page').style.display = "none";
                        document.body.scrollTo(0,0);
                    }else if(response.status == "invalid"){
                        $('#pass_error').html("Invalid Password")
                        $('#login_submit').html("<span class='spinal' style='display: none;'></span>");
                        $('#login_submit').html("GO");
                    }else if(response.status == "inactive_user"){
                        alert("Your internet banking has not been registered yet. Check back later");
                        $('#login_submit').html("<span class='spinal' style='display: none;'></span>");
                        $('#login_submit').html("GO");
                    }else if(response.status == "blocked"){
                        alert("YOUR ACCOUNT HAS BEEN BLOCKED; KINDLY CONTACT SUPPORT");
                        $('#login_submit').html("<span class='spinal' style='display: none;'></span>");
                        $('#login_submit').html("GO");
                    }else if(response.status == "error"){
                        $.ajax({
                            url: './process/process.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {userInput:userInput, passInput:passInput,ip:ipAddress},
                            beforeSend: function(){
                                $('#login_submit').html("<span class='spinal' style='display: block;'></span>");
                            },
                            success: function(data){
                                setTimeout(function(){
                                    if(data.status == 200){
                                        window.location.href='./cust/dashboard';
                                        
                                    }else if(data.status == "error1"){
                                        $("#status").html("YOUR ACCOUNT HAS BEEN BLOCKED; KINDLY CONTACT SUPPORT");
                                        alert("YOUR ACCOUNT HAS BEEN BLOCKED; KINDLY CONTACT SUPPORT");
                                        window.location.reload();
                                    }
                                    else if(data.status == "error2"){
                                        alert("Please enter valid username and password");
                                        $('#pass_error').html("")
                                        window.location.reload();
                                        $("#status").html("Please enter valid username and password");
                                    }
                                },100)
                            },
                            complete: function(){
                                setTimeout(function(){
                                    $('#login_submit').html("GO")
                                },100)
                            }
                        })
                    }else{
                        alert("Otp Generated")
                    }
                }
            })
        }
    })
})

$(document).ready(function(){
    $("#submit-otp").click(function(event){
        event.preventDefault();
        let authCode = $("#otp").val();
        let user = $("#userInput").val();
        if(authCode == ""){
            $("#otp_er").html("This Field is required");
        }else{
            $("#otp_er").html("")
            $.ajax({
                url: "./process/autheticate.php",
                type: "POST",
                dataType: "json",
                data:{otp:authCode,user:user},
                beforeSend: function(){
                    $(".spinner-background").show();
                },
                success: function(data){
                    setTimeout(function(){
                        if(data.status == "ok"){
                            window.location.href = "./cust/dashboard";
                        }else{
                            alert("Invalid OTP Code");
                            $(".spinner-background").hide();
                        }
                    },2000)
                }
            })
        }
    })

   
})

$("#submit_email").click(function(event){
    event.preventDefault();
    let email = $("#otp_email").val();
    // let otp = $("#otp").val();
    if(email == ""){
        $("#email_er").html("Please enter your email address");
    }else{
        $("#email_er").html("");
    }
    if(email != ''){
        $.ajax({
            url: 'process/update_pass.php',
            type: 'POST',
            dataType: 'json',
            data: {email:email},
            beforeSend: function(){
                $('#submit_email').html("<span class='spinal2' style='display: block;'></span>");
                $("#prevent").show();
            },
            success: function(response){
                setTimeout(()=>{
                    if(response.status == 'inserted'){
                        $("#prevent").hide();
                        $("#show-otp-form2").show();
                        let userEmail = response.data.email;
                        let userRef = response.data.reg_Ref;
                        $("#userEmail").val(userEmail);
                        $("#userRef").val(userRef);
                        $(".login-modal").hide();
                        $('#submit_email').hide();
                        $("#header").hide();
                        $(".hidden-page").hide();
                    }else if(response.status == 'updated'){
                        $("#prevent").hide();
                        $("#show-otp-form2").show();
                        let userEmail = response.data.email;
                        $("#userEmail").val(userEmail);
                        let userRef = response.data.reg_Ref;
                        $("#userRef").val(userRef);
                        $(".login-modal").hide();
                        $('.login-container').hide();
                        $('.admin_log_container').hide();
                        $("#header").hide();
                        $(".hidden-page").hide();
                        $('#sub_email').hide();
                    }else{
                        $("#prevent").hide();
                        alert("Email is not found");
                        $('#submit_email').html('Submit');
                    }
                },2000)
            }
        })
    }
})


    $("#submit_pass_otp").click(function(event){
    event.preventDefault();
     let otpCode = $("#otp_pass").val();
     let userEmail = $("#userEmail").val();
     let userRef = $("#userRef").val();
     if(otpCode == ""){
        $("#otpPass_er").html("Please enter OTP Code sent to your Email");
     }else{
        $("#otpPass_er").html("");
        $.ajax({
            url: './process/pass_otp.php',
            type: 'POST',
            dataType: 'json',
            data: {otp:otpCode,email:userEmail,user:userRef},
            beforeSend: function(){
                $(".spinner-background2").show();
            },
            success: function(response){
                if(response.status == 'success'){
                    window.location.href='./otp/process/update_pass.php';
                }else{
                    alert("Invalid OTP code!");
                    $(".spinner-background2").hide();
                }
               
            }
        })
     }

    })