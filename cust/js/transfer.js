

// saved beneficiaries switcher functions
let brokBtn = document.getElementById("brok-Btn");
let otherBtn = document.getElementById("other-Btn");
let showBrok = document.getElementById("showBrook");
let showOther = document.getElementById("showOther");
let inputField = document.getElementById("showTxt");
let inputFieldOther = document.getElementById("showOtherTxt");
let bankContainer = document.getElementById("bankCon");


function otherFunction() {
    brokBtn.style.backgroundColor = "#fff";
    brokBtn.style.color = "black";
    otherBtn.style.backgroundColor = "orangered";
    otherBtn.style.color = "#fff";
    showBrok.style.display = "none";
    showOther.style.display = "block";
    showOther.style.marginLeft = "140px";
    inputField.style.display = "none";
    inputFieldOther.style.display = "block";
    bankContainer.style.height = "450px"
}
function brokFunction() {
    if(showBrok.style.display == "block") {

    }else{
        otherBtn.style.display = "block";
        otherBtn.style.backgroundColor = "#fff";
        otherBtn.style.color = "black";
        showOther.style.display = "none";
        brokBtn.style.backgroundColor = "orangered";
        brokBtn.style.color = "#fff";
        showBrok.style.display = "block";
        inputField.style.display = "block";
        inputFieldOther.style.display = "none";
        bankContainer.style.height = "380px";
    }

}
// save beneficiaries endes here

// call for other beneficiaries

// function showOtherUsers(str){
   
//     if(str ===""){
//         document.getElementById("showOtherTxt").innerHTML = ""
//     }else{
//         let xmlHTTPS = new XMLHttpRequest();
//         xmlHTTPS.onreadystatechange = function(){
//             if(xmlHTTPS.readyState === 4 && xmlHTTPS.status === 200){
               
//                 document.getElementById("showOtherTxt").innerHTML = this.responseText;
//             }
//         }
//         xmlHTTPS.open("GET", "fetch_other_users.php?q="+str, true);
//         xmlHTTPS.send();
//     }
   
// }

// fetch beneficiaries/send to beneficiaries ajax request
var showOtherUsers = function(){
    let beneficiaries = $("#showOther").val();
    if(beneficiaries == ""){
        $("#showOtherTxt").html('');
    }else{
        $.ajax({
            url: './process/fetch_other_users.php',
            type: 'POST',
            dataType: 'html',
            data: {bend:beneficiaries},
            success: function(data){
                $("#showOtherTxt").html(data);
            }
        })
    }
}
var showUsers = function(){
    let beneficiaries = $("#showBrook").val();
    if(beneficiaries == ""){
        $("#showTxt").html('');
    }else{
        $.ajax({
            url: './process/fetch_user.php',
            type: 'POST',
            dataType: 'html',
            data: {bend:beneficiaries},
            success: function(data){
                $("#showTxt").html(data);
            }
        })
    }
    
}


    
$(document).ready(function() {
    $("#show_state").on("click", function(event) {
        event.preventDefault();
        $("#statement").show();
    })
})
