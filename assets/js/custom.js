/*--------------------------
Simplified sweetaalert
---------------------------- */
function toastAlert(bool1,pos,bool2,time,kind,msg){

    const Toast = Swal.mixin({
      toast: bool1,
      position: pos,
      showConfirmButton: bool2,
      timer: time
    });

    Toast.fire({
      type: kind,
      title: msg
    })
    }

/*--------------------------
Validate Email 
---------------------------- */
function validateEmail(email) {
  let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

/*--------------------------
Submit Registration
---------------------------- */
function sbtReg(){

  let fullname = $("input[name=fullname]").val();
  let acct_type = $("#acct_type").val();
  let d_o_b = $("input[name=d_o_b]").val();
  let gender = $("#gender").val();
  let country = $("#country").val();
  let currency = $("#currency").val();
  let city = $("input[name=city]").val();
  let zipcode = $("input[name=zipcode]").val();
  let ssn = $("input[name=ssn]").val();
  let phone = $("input[name=phone]").val();
  let email = $("input[name=email]").val();
  let profile_pic = $("input[name=profile-pic]").val();
  let secquestion = $("#secquestion").val();
  let sec_ans = $("input[name=sec_ans]").val();
  let pword = $("input[name=pword]").val();
  let cofpword = $("input[name=cofpword]").val(); 
  let pin = $("input[name=pin]").val();
  let cofpin = $("input[name=cofpin]").val();


  if( fullname == "" || fullname == null ){ toastAlert(true,"top-end",false,3000,"info","Please Fill Your Full Name"); return; }
  if( acct_type == "" || acct_type == null ){ toastAlert(true,"top-end",false,3000,"info","Please Select a Account type"); return; }
  if( d_o_b  == "" || d_o_b == null ){ toastAlert(true,"top-end",false,3000,"info","Please your Date of Birth"); return; }
  if( gender == "" || gender == null ){ toastAlert(true,"top-end",false,3000,"info","Please Select your Gender"); return; }
  if( country == "" || country == null ){ toastAlert(true,"top-end",false,3000,"info","Please Select your Country"); return; }
  if( currency == "" || currency == null ){ toastAlert(true,"top-end",false,3000,"info","Please Select your currency"); return; }
  if( city == "" || city == null ){ toastAlert(true,"top-end",false,3000,"info","Please Fill select fill your City"); return; }
  if( zipcode == "" || zipcode == null ){ toastAlert(true,"top-end",false,3000,"info","Please Fill Your ZipCode"); return; }
  if( ssn == "" || ssn == null ){ toastAlert(true,"top-end",false,3000,"info","Please Fill your SSN"); return; }
  if( phone == "" || phone == null ){ toastAlert(true,"top-end",false,3000,"info","Please Fill Your Phone Number"); return; }
  if( email == "" || email == null ){ toastAlert(true,"top-end",false,3000,"info","Please Fill Email Address"); return; }
  if ( validateEmail(email) !== true ){ toastAlert(true,"top-end",false,3000,"error","Sorry This email is wrong"); return; }
  if( profile_pic == "" || profile_pic == null ){ toastAlert(true,"top-end",false,3000,"info","Please Upload a Picture"); return; }
  if( secquestion == "" || secquestion == null ){ toastAlert(true,"top-end",false,3000,"info","Please Select your security Question"); return; }
  if( sec_ans == "" || sec_ans == null ){ toastAlert(true,"top-end",false,3000,"info","Please fill your Security Answer"); return; }
  if( pword == "" || pword == null ){ toastAlert(true,"top-end",false,3000,"info","Please Fill your Password"); return; }  
  if( cofpword == "" || cofpword == null ){ toastAlert(true,"top-end",false,3000,"info","Please Comfirm your Password"); return; }     
  if( pin == "" || pin == null ){ toastAlert(true,"top-end",false,3000,"info","Please Fill Pin"); return; }          
  if( cofpin == "" || cofpin == null ){ toastAlert(true,"top-end",false,3000,"info","Please Confirm your Pin"); return; }          
  if( pword != cofpword ){ toastAlert(true,"top-end",false,3000,"info","Both Passwords Should Match Please"); return; }
  if( pin != cofpin ){ toastAlert(true,"top-end",false,3000,"info","Both Pin Should Match Please"); return; }
      

  if( document.getElementById("agree").checked == true ){

    let form = $('form')[0]; // You need to use standard javascript object here
    let formData = new FormData(form);

    $.ajax({
        url: 'apps/login/register.php',
        data: formData,
        type: 'POST',
        contentType: false, 
        processData: false,
        success : function(data){
          let info = data.trim();
          if( info == "success" ){
            toastAlert(true,"top-end",false,3000,"success","Welcome "+email);
            setTimeout(function(){ window.location = "../e-banking/index.php"} , 3200);
          }
          else if( info == "File is not an image." ){
            toastAlert(true,"top-end",false,3000,"info","File is not an image."); 
            return;
          }
          else if( info == "Sorry, your file is too large." ){
            toastAlert(true,"top-end",false,3000,"info","Sorry, your file is too large."); 
            return;
          }
          else if( info == "Not allowed" ){
            toastAlert(true,"top-end",false,3000,"info","This file not allowed"); 
            return;
          }
          else if( info == "email error" ){
            toastAlert(true,"top-end",false,3000,"info","This Email Already Exist"); 
            return;
          }
          else if( info == "Signup error" ){
            toastAlert(true,"top-end",false,3000,"error","Sorry you cannot register this account"); 
            return;
          }
          else if( info == "Sorry, your file was not uploaded." ){
            toastAlert(true,"top-end",false,3000,"info","Registration Failed, Please Try Again"); 
            return;
          }                              
        }
    })

  }else{

    toastAlert(true,"top-end",false,3000,"info","Please Agree To our Terms And Policies"); return;

  }
}

/*--------------------------
Submit Login One
---------------------------- */
function sbtLog1(){

  let email = $("input[name=email]").val();
  let pword = $("input[name=pword]").val();

  if( email == "" || email == null ){ toastAlert(true,"top-end",false,3000,"info","Please Input your username"); return; }

  if( pword == "" || pword == null ){ toastAlert(true,"top-end",false,3000,"info","Please Input your password"); return; }

  let dataString = "email="+email+"&pword="+pword ;

  $.ajax({
    url : "apps/login/login.php",
    type : "POST",
    data : dataString,
    success : function(data){
      info = data.trim();
      if( info == "success" ){
        toastAlert(true,"top-end",false,3000,"success","Welcome "+email);
        setTimeout(function(){ window.location = "e-banking/account-summary.php"} , 3200);
      }
      else if( info == "Wrong" ){
        toastAlert(true,"top-end",false,3000,"error","Wrong Details, Please Try Again");
      }
      else if( info == "user does not exist" ){
        toastAlert(true,"top-end",false,3000,"info","This User does not exist, Please Sign Up");
      }
      else if( info == "inactive" ){
        Swal.fire({
          icon: 'info',
          title: 'Account Suspended',
          text: 'please visit any of our branch to reactivate your account',
          footer: 'THANK YOU FOR CHOOSING Community Bank America'
        })
        setTimeout(function(){ location.reload()} , 2000);  
    }      
      else{
        toastAlert(true,"top-end",false,3000,"info","Something went wrong try again");
      }
    }
  })

}

/*--------------------------
Submit Login Two
---------------------------- */
function sbtLog2(){

  let email = $("input[name=email]").val();
  let pin = $("input[name=pin]").val();

  if( pin == "" || pin == null ){ toastAlert(true,"top-end",false,3000,"info","Please Fill all Fields"); return; }

  let dataString = "pin="+pin+"&email="+email ;

  $.ajax({
    url : "../apps/login/login.php",
    type : "POST",
    data : dataString,
    success : function(data){
      info = data.trim();
      if( info == "success" ){
          toastAlert(true,"top-end",false,3000,"success","Welcome "+email);
          setTimeout(function(){ window.location = "../e-banking/index.php"} , 3200);
      }
      else if( info = "Suspended" ){
          toastAlert(true,"top-end",false,3000,"success","Welcome "+email);
          setTimeout(function(){ window.location = "../e-banking/account.php"} , 3200);        
      }      
      else{
        toastAlert(true,"top-end",false,3000,"info","Login Failed, Please Try Again");
      }
    }
  })

}

