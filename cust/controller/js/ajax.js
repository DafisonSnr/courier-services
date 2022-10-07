

function checkedFunction(){
    let check = document.getElementById("myCheck")
    if(check.checked == true){
        let acc_Num = $("#acc_Num").val();
        let name = $("#name").val();
        let type = $("#type").val();
        $.ajax({
            url: "./process/brok_beneficiary.php",
            type: "POST",
            dataType: "json",
            data: {acc_Num:acc_Num, name:name, type:type},
            success: function(data){
                if(data.status == "200"){
                    alert("Beneficiary successfully saved")
                }else{
                    alert("Failed to save beneficiary beneficiary already exists");
                }
            }
        })

    }
}


function clickConfirm(){
    document.getElementById("checker").click();
}
// code required transfer
$(document).ready(function(){
    // AUTO DETECT ACCOUNT KEYUP FUNCTION
    var accInput = document.getElementById("accNumber");
    accInput.onkeyup = function(){
       if(accInput.value.length == 10 ){
            // to check if select option is not empty---if( $('#fruit_name').has('option').length > 0 ) 
            if( !$('#AccounSelect').val()){
                $("#fetchResult").html("Please Select account to be debited");
            }else{   
                $("#fetchResult").html("");
                let selected_Acc = $("#AccounSelect :selected").val();
                let acc_input = accInput.value;
                $.ajax({
                    url: './process/process.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {acc_input:acc_input,sender:selected_Acc},
                    beforeSend: function(){
                        $('#spiner').show();
                        $(".close-btn").hide();
                    },
                    success: function(responseText){
                        setTimeout(function(){
                            if(responseText.status === 200){
                                $("#brookline").hide();
                                let senderAcc = responseText.sender;
                                let accNum = responseText.receiver;
                                let names = responseText.data.Names;
                                let type = responseText.data.acc_Type;
                                let cur = responseText.data.currency;
                                $("#sender_Acc").val(senderAcc).prop("readonly",true);
                                $("#acc_Num").val(accNum).prop("readonly",true);
                                $("#name").val(names).prop("readonly",true);;
                                $("#type").val(type).prop("readonly",true);;
                                $("#curt").val(cur);
                                $("#fetchAccount").show();
                                $('#brookline').hide();
                            }else if(responseText.status == 505){
                                alert("You cannot make transfer to you own account");
                            }
                            else{
                                alert("Account not found");
                            }

                        },1000);
                    },
                    complete: function(){
                        setTimeout(function(){
                            $('#spiner').hide();
                        },3000)
                    }
                }) 
            }
        }
        
    }

    $("#pinSubmit").click(function(e){
        e.preventDefault();
        let acc_Num = $("#acc_Num").val();
        let name = $("#name").val();
        let amt =  $("#amt").val();
        let sender = $("#sender_Acc").val();
        let currency =  $("#curt").val();
        var formatAmt = amt.replace(/,/g, '');
        let userRef = $("#id").val();
        let type = $("#type").val();
        // let check = $("#myCheck").val();
        // var checkbox_value = $("#myCheck").val();
        
        // $(":checkbox").each(function () {
        //     var ischecked = $(this).is(":checked");
        //     if (ischecked) {
        //         checkbox_value += $(this).val() + "|";
        //     }
        // });
        var checkbox_value = "";
        $("#myCheck").each(function () {
            var ischecked = $(this).is(":checked");
            if (ischecked) {
                checkbox_value += $(this).val();
            }
        });
        if(formatAmt == ""){
            $("#amt_er").html("Please enter amount");
        }else{
            $("#amt_er").html("");
            $.ajax({
                url: "process/pin_confirm.php",
                type: "POST",
                dataType: "html",
                // contentType: 'application/json; charset=utf-8',
                data: {acc:acc_Num,userRef:userRef,amt:amt,name:name,fmt:formatAmt,cur:currency,check:checkbox_value,type:type,sender:sender},
                success: function(data){
                    $("#showConfirm").html(data);
                    $("#fetchAccount").show();
                }
            })
        }

    })

    // SAME BANK TRANSFER AJAX CALL FUNCTION
    $("#same-bank").click(function(e){
        e.preventDefault();
        let acc_Num = $("#acc_Num").val();
        let name = $("#name").val();
        let amt =  $("#amt").val();
        let senderAcc = $("#sender_Acc").val();
        // let currency =  $("#curt").val();
        var formatAmt = amt.replace(/,/g, '');
        let userRef = $("#id").val();
        if(formatAmt == ""){
            $("#amt_er").html("Please enter amount");
        }else{
            $("#showConfirm").hide(); 
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })
                        swalWithBootstrapButtons.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning none',
                        showCancelButton: true,
                        confirmButtonText: 'Transfer',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        width: '100%',
                        height: '100%'
                    }).then((show) => {
                    if (show.isConfirmed) {
                            $.ajax({
                                url: './process/checked/checked.php',
                                type: 'POST',
                                dataType: 'json',
                                data: {userRef:userRef},
                                success: function(responseText){
                                    if (responseText.status == 200){
                                        // let formatAmt = amount.replace(/,/g, '');
                                        $.ajax({
                                            url: './process/brook_cust.php',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {name:name,acc_Num:acc_Num,amt:formatAmt,sender:senderAcc},
                                            beforeSend: function(){
                                                $("#spinnering").show();
                                                $("#same-bank").hide();
                                                $("#cancel-same-bank").hide();
                                            },
                                            success: function(data){
                                                setTimeout(function(){
                                                    if(data.status == 200) {
                                                        checkedFunction();
                                                        Swal.fire(
                                                        'Transfer SuccessFul',
                                                        ).then((result) => {
                                                            if(result){
                                                                Swal.fire({
                                                                    title: '<strong>RATE OUR SERVICES</strong>',
                                                                    html:
                                                                    'Thank you for banking with us!</b>, ' +
                                                                    '<a href="//https://swifbanking.local/">Contact</a> ' +
                                                                    '',
                                                                    showCloseButton: true,
                                                                    showCancelButton: true,
                                                                    focusConfirm: false,
                                                                    confirmButtonText:
                                                                    '<i class="fa fa-thumbs-up"></i> Great!',
                                                                    confirmButtonAriaLabel: 'Thumbs up, great!',
                                                                    cancelButtonText:
                                                                    '<i class="fa fa-thumbs-down"></i>',
                                                                    cancelButtonAriaLabel: 'Thumbs down' ,
                                                                    imageHeight: 80, 
                                                                    imageWidth: 80,   
                                                                }).then((result) => {
                                                                    if(result.isConfirmed){
                                                                        alert("Thank you for your Response 😀")
                                                                        window.location.reload();
                                                                    }else{
                                                                        alert("Thank you for your Response 😌")
                                                                        window.location.reload();
                                                                    }
                                                                })
                                                            } 
                                                        })      
                                                    }else if(data.status == 600){
                                                        Swal.fire('Your account has not been activated for transaction').
                                                        then(() => {
                                                            window.location.reload();
                                                        }) 
                                                    }
                                                    else if(data.status == 505){
                                                        Swal.fire({
                                                            text: 'INSUFFICIENT BALANCE!',
                                                            footer: '<p> PLEASE MAKE SURE YOUR ACCOUNT IS FUNDED</p>',
                                                            // imageUrl: './image/rate.png',
                                                            // imageSize: '600x600'
                                                        })
                                                        $("#spinnering").hide();
                                                        $("#same-bank").show();
                                                        $("#cancel-same-bank").show();
                                                        // alert("Insufficient funds. Please try a lesser amount");
                                                        // window.location.reload();
                                                    }
                                                    else{
                                                        alert('Transfer failed');
                                                    }
                                                },1000)
                                            },
                                        })
                                        
                                    }else if(responseText.status == 'error1'){
                                        $("#spinnering").show();
                                        $("#same-bank").hide();
                                        $("#cancel-same-bank").hide();
                                        setTimeout(()=>{
                                            Swal.fire({
                                            title: 'Oops...',
                                            text: 'Your Account is currently frozen!',
                                            footer: '<a href="">Why do I have this issue?</a>'
                                            }).then((result) => {
                                                $("#spinnering").hide();
                                                $("#same-bank").show();
                                                $("#cancel-same-bank").show();
                                            })
                                        },3000)
                                    }else{
                                        // $("#spinner").show();
                                        $("#spinnering").show();
                                        $("#same-bank").hide();
                                        $("#cancel-same-bank").hide();
                                        setTimeout(()=>{
                                            Swal.fire({
                                            title: 'Oops...',
                                            text: 'Transfer Error!',
                                            footer: '<a href="">Why do I have this issue?</a>'
                                            }).then((result) => {
                                                $("#spinnering").hide();
                                                $("#same-bank").show();
                                                $("#cancel-same-bank").show();
                                            })
                                        },3000)

                                    }
                                }
                            })
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ){
                        window.location.reload();
                    }    
                })
                
                        
              
        }

    })
    // other bank transfer required pin ajax request
    $("#pinSubmit_other").click(function(event){
        event.preventDefault();
        let custName = $("#benName").val();
        let custAcc = $("#accNum").val();
        let bankName = $("#bankName").val();
        let routing = $("#routing").val();
        let swiftCode = $("#swift").val();
        let amount = $("#amount").val();
        let userRef = $("#id").val();
        let checkbox_value = "";
        $("#other-bank-ben").each(function () {
            var ischecked = $(this).is(":checked");
            if (ischecked) {
                checkbox_value += $(this).val();
            }
        })
        let senderAcc = $("#AccToDebit :selected").val();
        if(!$("#AccToDebit").val()){
            $("#select_er").html("Please Select Account")
        }else{
            $("#select_er").html("");
        }
        if(custName == ""){
            $("#benName_er").html(" enter account name");
        }else{
            $("#benName_er").html("");
        }
        if(custAcc == ""){
            $("#benAcc_er").html("Please enter account number");
        }else{
            $("#benAcc_er").html("");
        }
        if(bankName == ""){
            $("#benBank_er").html("Please enter beneficiary bank")
        }else{
            $("#benBank_er").html("");
        }
        if(swiftCode == ""){
            $("#swift_er").html("Please enter routing number");
        }else{
            $("#swift_er").html("");
        }
        if(amount == ""){
            $("#amount_er").html("Please enter amount");
        }else{
            $("#amount_er").html("");
        }
        if(custName != "" && custAcc != "" && bankName != "" && swiftCode != "" && amount != "" && senderAcc != ""){
            $.ajax({
                url: "./process/other_pin.php",
                type: "POST",
                dataType: "html",
                data: {name:custName,acc:custAcc,bank:bankName,rout:routing,swift:swiftCode,userRef:userRef,amt:amount,check:checkbox_value,senderAcc:senderAcc},
                success: function(data){
                    $("#showResponse").html(data);
                    $("#other-bank").show();
                }
                
            })
        }
   
    })

    // SAME BANK SAVE BENEFICIARY DETAILS
   

    // TRANSFER TO OTHER BANK AJAX CALL FUNCTION
    $("#sender2").click(function(event){
        event.preventDefault();
        let custName = $("#benName").val();
        let custAcc = $("#accNum").val();
        let bankName = $("#bankName").val();
        let routing = $("#routing").val();
        let swiftCode = $("#swift").val();
        let amount = $("#amount").val();
        let userRef = $("#id").val();
        let sender = $("#AccToDebit :selected").val();
        if(custName == ""){
            $("#benName_er").html("Please enter account name");
        }if(custAcc == ""){
            $("#benAcc_er").html("Please enter account number");
        }if(bankName == ""){
            $("#benBank_er").html("Please enter beneficiary bank")
        }if(swiftCode == ""){
            $("#swift_er").html("Please enter routing number");
        }if(amount == ""){
            $("#amount_er").html("Please enter amount");
        }
        if(custName != "" && custAcc != "" && bankName != "" && swiftCode != "" && amount != "" ){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning none',
                    showCancelButton: true,
                    confirmButtonText: 'Transfer',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    width: '100%',
                    height: '100%'
                }).then((show) => {
                if (show.isConfirmed) {
                        $.ajax({
                            url: './process/checked/other_bank_check.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {userRef:userRef,custName:custName,custAcc:custAcc,bank:bankName,swift:swiftCode,rout:routing,amt:amount,sender:sender},
                            success: function(responseText){
                                if (responseText.status == 200){
                                    let formatAmt = amount.replace(/,/g, '');
                                    $.ajax({
                                        url: './process/other_bank.php',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {cust:custName,acc:custAcc, bank:bankName, rout:routing, swift:swiftCode,amt:formatAmt,sender:sender},
                                        beforeSend: function(){
                                            $("#spinner3").show();
                                            $("#sender2").hide();
                                            $("#cancel-other-bank").hide();
                                        },
                                        success: function(data){
                                            otherBeneficiary();
                                            setTimeout(function(){
                                                if(data.status == 200) {
                                                    Swal.fire(
                                                    'Transfer SuccessFul',
                                                    ).then((result) => {
                                                        if(result){
                                                            Swal.fire({
                                                                title: '<strong>RATE OUR SERVICES</strong>',
                                                                html:
                                                                'Thank you for banking with us!</b>, ' +
                                                                '<a href="//https://swifbanking.local/">Contact</a> ' +
                                                                '',
                                                                showCloseButton: true,
                                                                showCancelButton: true,
                                                                focusConfirm: false,
                                                                confirmButtonText:
                                                                '<i class="fa fa-thumbs-up"></i> Great!',
                                                                confirmButtonAriaLabel: 'Thumbs up, great!',
                                                                cancelButtonText:
                                                                '<i class="fa fa-thumbs-down"></i>',
                                                                cancelButtonAriaLabel: 'Thumbs down' ,
                                                                imageHeight: 80, 
                                                                imageWidth: 80,   
                                                            }).then((result) => {
                                                                if(result.isConfirmed){
                                                                    alert("Thank you for your Response 😀")
                                                                    window.location.reload();
                                                                }else{
                                                                    alert("Thank you for your Response 😌")
                                                                    window.location.reload();
                                                                }
                                                            })
                                                        } 
                                                    })      
                                                }else if(data.status == 600){
                                                    Swal.fire('Your account has not been activated for transaction').
                                                    then(() => {
                                                        window.location.reload();
                                                    })
                                                }
                                                else if(data.status == 505){
                                                Swal.fire({
                                                text: 'INSUFFICIENT BALANCE!',
                                                footer: '<p> PLEASE MAKE SURE YOUR ACCOUNT IS FUNDED</p>',
                                                // imageUrl: './image/rate.png',
                                                // imageSize: '600x600'
                                                })
                                                $("#spinner3").hide();
                                                $("#sender2").show();
                                                $("#cancel-other-bank").show();
                                                // alert("Insufficient funds. Please try a lesser amount");
                                                // window.location.reload();
                                                }
                                                else{
                                                    alert('Transfer failed');
                                                }
                                            },3000)
                                        },
                                    })
                                    
                                }else if(responseText.status == 'error1'){
                                    $("#spinner3").show();
                                    $("#sender2").hide();
                                    $("#cancel-other-bank").hide();
                                    setTimeout(()=>{
                                        Swal.fire({
                                        title: 'Oops...',
                                        text: 'Your Account is currently frozen!',
                                        footer: '<a href="">Why do I have this issue?</a>'
                                        }).then((result) => {
                                            $("#spinner3").hide();
                                            $("#sender2").show();
                                            $("#cancel-other-bank").show();
                                        })
                                    },3000)
                                }else{
                                    // $("#spinner").show();
                                    startCount();
                                    let senderName = responseText.senderName;
                                    let recName = responseText.receiverName;
                                    let recAcc = responseText.recieverAcc;
                                    let bankNam = responseText.bankName;
                                    let swift = responseText.swiftCode;
                                    let amt = responseText.amount;
                                    let senderAccount = responseText.senderAcct;
                                   
                                    // TAX IDs
                                    $("#nameFetchTax").html(senderName);
                                    $("#fetchAmtTax").html(amt);
                                    $("#send_acc_tax").html(senderAccount);
                                    $("#recNameTax").html(recName);
                                    
                                    // ATC IDs
                                    $("#nameFetchAtc").html(senderName);
                                    $("#fetchAmtAtc").html(amt);
                                    $("#send_acc_atc").html(senderAccount);
                                    $("#recNameAtc").html(recName);

                                    // IMF IDs
                                    $("#nameFetchImf").html(senderName);
                                    $("#fetchAmtImf").html(amt);
                                    $("#send_acc_imf").html(senderAccount);
                                    $("#recNameImf").html(recName);
                                    
                                    // COT IDs
                                    $("#nameFetch").html(senderName);
                                    $("#fetchAmt").html(amt);
                                    $("#send_acc").html(senderAccount);
                                    $("#fetchBank").html(bankNam);
                                    $("#fetchBankList").html(bankNam);
                                    $("#recName").html(recName);
                                    $("#fetchRec").html(recAcc);
                                    $("#swiftCode").html(swift);

                                   // $("#spinner").show();
                                   //TAX click function
                                   $("#taxSubmit").on("click",function(event){
                                       event.preventDefault();
                                       let taxCode = $("#tax").val();
                                       let taxRef = $("#taxRef").val();
                                       if(taxCode == ""){ 
                                           $("#tax_error").html("Please enter TAX Code")
                                       }else{
                                           $.ajax({
                                               url: "./process/tax_code.php",
                                               type: "POST",
                                               dataType: "json",
                                               data: {cot:taxCode,ctRef:taxRef},
                                               beforeSend: function(){
                                                   $("#taxSubmit").html("Processing...")
                                               },
                                               success: function(responseText){
                                                   setTimeout(()=>{
                                                       if(responseText.status == 200){                                                          
                                                           startCount();
                                                           //ATC click function
                                                           $("#atcSubmit").click(function(event){
                                                               event.preventDefault();
                                                               let nftCode = $("#atc").val();
                                                               let nftRef = $("#atcRef").val();
                                                               if(nftCode == ""){
                                                                   $("#atc_error").html("Please enter ATC CODE");
                                                               }else{
                                                                   $.ajax({
                                                                       url: "./process/nft_code.php",
                                                                       type: "POST",
                                                                       dataType: "json",
                                                                       data: {nft:nftCode,nftRef:nftRef},
                                                                       beforeSend: function(){
                                                                           $("#atcSubmit").html("Processing...");
                                                                       },
                                                                       success: function(responseText){
                                                                           setTimeout(()=>{
                                                                               if(responseText.status == 200){
                                                                                   alert("ATC code is valid");
                                                                                   startCount();
                                                                                   //IMF click function
                                                                                   $("#imfSubmit").click(function(event){
                                                                                       event.preventDefault();
                                                                                       let imfCode = $("#imf").val();
                                                                                       let imfRef = $("#imfRef").val();
                                                                                       if(imfCode == ""){
                                                                                           $("#imf_error").html("Please enter IMF CODE");
                                                                                       }else{
                                                                                           $.ajax({
                                                                                               url: "./process/imf_code.php",
                                                                                               type: "POST",
                                                                                               dataType: "json",
                                                                                               data: {imf:imfCode,imfRef:imfRef},
                                                                                               beforeSend: function(){
                                                                                                   $("#imfSubmit").html("Processing...");
                                                                                               },
                                                                                               success: function(responseText){
                                                                                                   setTimeout(()=>{                                                                                                      
                                                                                                       if(responseText.status == 200){
                                                                                                           alert("IMF code is valid");
                                                                                                           startCount();
                                                                                                           $("#cotSubmit").click(function (e) {  
                                                                                                               e.preventDefault();
                                                                                                               let cotCode = $("#cot").val();
                                                                                                               let cotRef = $("#ctRef").val();
                                                                                                               if(cotCode == ""){ 
                                                                                                                   $("#cot_error").html("Please enter COT Code")
                                                                                                               }else{
                                                                                                                   $.ajax({
                                                                                                                       url: "./process/cot_code.php",
                                                                                                                       type: "POST",
                                                                                                                       dataType: "json",
                                                                                                                       data: {cot:cotCode,ctRef:cotRef},
                                                                                                                       beforeSend: function(){
                                                                                                                           $("#cotSubmit").html("Processing...")
                                                                                                                       },
                                                                                                                        success: function(responseText){
                                                                                                                           if(responseText.status == 200){                                                                                                               //other bank transfer ajax call
                                                                                                                               // $amount = $("#amt").val();
                                                                                                                               // let formatAmt = amount.replace(/,/g, '');
                                                                                                                               startCount();
                                                                                                                               $.ajax({
                                                                                                                                   url: './process/other_bank.php',
                                                                                                                                   type: 'POST',
                                                                                                                                   dataType: 'json',
                                                                                                                                   data: {sender:sender,cust:custName,acc:custAcc,bank:bankName,rout:routing,swift:swiftCode,amt:amount},
                                                                                                                                   success: function(responseText){
                                                                                                                                       setTimeout(()=>{
                                                                                                                                           if(responseText.status == 200) {
                                                                                                                                               Swal.fire(
                                                                                                                                                   'Transfer SuccessFul Awaiting Bank Clearance',
                                                                                                                                                   'You clicked the button!',
                                                                                                                                                   'success'
                                                                                                                                                   ).then((result)=>{
                                                                                                                                                       if(result){
                                                                                                                                                           window.location.reload();
                                                                                                                                                       }
                                                                                                                                                   })
                                                                                                                                               // $("#spinner3").hide();
                                                                                                                                           }else if(responseText.status == 505){
                                                                                                                                               Swal.fire({
                                                                                                                                                   text: 'INSUFFICIENT BALANCE!',
                                                                                                                                                   footer: '<p> PLEASE MAKE SURE YOUR ACCOUNT IS FUNDED</p>',
                                                                                                                                                   // imageUrl: './image/rate.png',
                                                                                                                                                   // imageSize: '600x600'
                                                                                                                                               }).then((result) => {
                                                                                                                                                   if (result) {
                                                                                                                                                       window.location.reload();
                                                                                                                                                   }
                                                                                                                                                   
                                                                                                                                               })
                                                                                                                                               $("#spinner3").hide();
                                                                                                                                               // alert("Insufficient funds. Please try a lesser amount");
                                                                                                                                               // window.location.reload();
                                                                                                                                           }
                                                                                                                                           else {
                                                                                                                                               alert("transfer Failed");
                                                                                                                                           }

                                                                                                                                       },3000) 
                                                                                                                                   }
                                                                                                                               });
                                                                                                                            }else{
                                                                                                                                alert("Invalid code supplied");
                                                                                                                            }
                                                                                                                       },
                                                                                                                       complete: function(){
                                                                                                                        setTimeout(()=>{
                                                                                                                            $("#cotSubmit").html("ENTER CODE");
                                                                                                                        },3000)
                                                                                                                       }
                                                                                                                   })
                                                                                                               };
                                                                                                           });
                                                                                                       }else{
                                                                                                           alert("Invalid IMF code supplied");
                                                                                                       }    
                                                                                                   },3000);
                                                                                               },
                                                                                               complete: function(){
                                                                                                   setTimeout(()=>{
                                                                                                       $("#imfSubmit").html("ENTER CODE")
                                                                                                   },3000);     
                                                                                               }
                                                                                           })
                                                                                       }
                                                                                   })
                                                                               }else{
                                                                               alert("Invalid NFT code supplied");
                                                                               }
                                                                           },3000)
                                                                       },
                                                                       complete: function(){
                                                                           setTimeout(()=>{
                                                                               $("#nftSubmit").html("ENTER CODE")
                                                                           },3000);     
                                                                       }
                                                                   })
                                                               }
                                                           })
                                                       }else{
                                                           alert("Invalid COT Code supplied");
                                                       }
                                                   },3000)
                                               },
                                               complete: function(){
                                                   setTimeout(()=>{
                                                       $("#taxSubmit").html("ENTER CODE")
                                                   },3000);                                               
                                               }
                                               
                                           })
                                       } 
                                   })
                                }
                            }
                        })
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ){
                    window.location.reload();
                }
            })
                   
        }
    })

    // COUNT TRANSFER FUNCTION
    count = 0; 
    let taxForm = document.getElementById("tax-form");
    let atcForm = document.getElementById("atc-form");
    let imfForm = document.getElementById("imf-form");
    let cotForm = document.getElementById("cot-form");
    let countEl = document.getElementById('count_el');
    // let biller = document.getElementById('biller');
    function startCount(){
        $("#spinner").fadeIn();
        let timeOut = setInterval(()=>{
            if(count == 100) {
                clearInterval(timeOut);
            }else{
                count++;
                countEl.innerHTML = count+"%";
            }
            if(count == 20) {
                clearInterval(timeOut);
                $("#spinner").fadeOut();
                $("#biller").fadeIn();
                taxForm.style.display = "block"; 
                $(".closetn2").show();  
            }else{
                taxForm.style.display = "none";
                $("#biller").fadeOut();
                $("#spinner").fadeIn();
                $(".closetn2").hide();  
            }
            if(count == 40) {
                clearInterval(timeOut);
                $("#spinner").fadeOut();
                $("#biller").fadeIn();
                atcForm.style.display = "block";
                $(".closetn2").show();
            }else{
                atcForm.style.display = "none";
                // $("#biller").fadeOut();
                // $("#spinner").fadeIn();
                $(".closetn2").hide(); 
            }
            if(count == 70){
                clearInterval(timeOut);
                $("#biller").fadeIn();
                $("#spinner").fadeOut();
                imfForm.style.display = "block";
                $(".closetn2").show();
            }else{
                imfForm.style.display = "none";
                // $("#biller").fadeOut();
                // $("#spinner").fadeIn();
                $(".closetn2").hide(); 
            }
            if(count == 95){
                clearInterval(timeOut);
                $("#biller").fadeIn();
                $("#spinner").fadeOut();
                cotForm.style.display = "block";
                $(".closetn2").show();
            }else{
                cotForm.style.display = "none";
                // $("#biller").fadeOut();
                // $("#spinner").fadeIn();
                $(".closetn2").hide(); 
            }
        },200);
    }

    //OTHER BANK SAVE BENEFICIARY
    function otherBeneficiary(){
        let otherBen = document.getElementById("other-bank-ben");
        if(otherBen.checked == true){
            let custName = $("#benName").val();
            let custAcc = $("#accNum").val();
            let bankName = $("#bankName").val();
            let routing = $("#routing").val();
            let swiftCode = $("#swift").val();
            $.ajax({
                url: './process/other_beneficiary.php',
                type: 'POST',
                dataType: 'html',
                data:{acc:custAcc, name:custName,bank:bankName, rout:routing, swift:swiftCode},
            })

        }
    }

    //Other bank insert commas queries
    $('#amount').keyup(function (event) {
        // skip for arrow keys
        if (event.which >= 37 && event.which <= 40) {
            event.preventDefault();
        }

        var currentVal = $(this).val();
        var testDecimal = testDecimals(currentVal);
        if (testDecimal.length > 1) {
            $("#amt_error").html("You cannot enter more than one decimal point");
            currentVal = currentVal.slice(0, -1);
        }else{
            $("#amt_error").html("");
        }
        $(this).val(replaceCommas(currentVal));
    });

    function testDecimals(currentVal) {
        var count;
        currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
        return count;
    }

    function replaceCommas(yourNumber) {
        var components = yourNumber.toString().split(".");
        if (components.length === 1)
            components[0] = yourNumber;
        components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if (components.length === 2)
            components[1] = components[1].replace(/\D/g, "");
        return components.join(".");
    }
 
})


// this will add commas automatically with more than one periods

// code for adding commas automatically while type(decimal point will be ignored)
// // $(document).ready(function(){
// //     $('#amt').keyup(function(event){
      
// //       // skip for arrow keys
// //       if(event.which >= 37 && event.which <= 40){
// //           event.preventDefault();
// //       }
// //       var $this = $(this);
// //       var num = $this.val().replace(/,/gi, "").split("").reverse().join("");

// //       var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1,").split("").reverse().join(""));

// //       // the following line has been simplified. Revision history contains original.
// //       $this.val(num2);});});

// //     function RemoveRougeChar(convertString){


// //     if(convertString.substring(0,1) == ","){

// //         return convertString.substring(1, convertString.length)            

// //     }
// //     // return convertString;
// //     return Number((convertString / 100).toFixed(2));

// }

// $('#amt').keyup(function(event) {

//     // skip for arrow keys
//     if(event.which >= 37 && event.which <= 40){
//      event.preventDefault();
//     }
  
//     $(this).val(function(index, value) {
//         value = value.replace(/,/g,''); // remove commas from existing input
//         return numberWithCommas(value); // add commas back in
//     });
//   });
  
//   function numberWithCommas(x) {
//       var parts = x.toString().split(".");
//       parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//       return parts.join(".");
//   }
  

    //this function add commas automatically with just one periods allowed after insert first period
  $('#amt').keyup(function (event) {
    // skip for arrow keys
    if (event.which >= 37 && event.which <= 40) {
        event.preventDefault();
    }

    var currentVal = $(this).val();
    var testDecimal = testDecimals(currentVal);
    if (testDecimal.length > 1) {
        $("#amt_error").html("You cannot enter more than one decimal point");
        currentVal = currentVal.slice(0, -1);
    }else{
        $("#amt_error").html("");
    }
    $(this).val(replaceCommas(currentVal));
});

function testDecimals(currentVal) {
    var count;
    currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
    return count;
}

function replaceCommas(yourNumber) {
    var components = yourNumber.toString().split(".");
    if (components.length === 1)
        components[0] = yourNumber;
    components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if (components.length === 2)
        components[1] = components[1].replace(/\D/g, "");
    return components.join(".");
}

//count script numbers






