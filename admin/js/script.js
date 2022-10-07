let smallCol = document.getElementById('icon-small');
    let navOpen = document.getElementById('column');
    let navList = document.getElementById('menu-list');
    let largeCol = document.getElementById('col-large');
    function navOpened(){
      smallCol.style.display = 'none';;
      navList.style.width = '200px';
      largeCol.style.marginLeft = '150px';
    }
    function navClose(){
      smallCol.style.display = 'block';
      navList.style.width = '0px';
      largeCol.style.marginLeft = '0px';
      
    }    
    // $(":file").filestyle();



   $("#edited").on("click",function(){
    let edit_Id = $(this).val();
    $.ajax({
      url: "./process/process.php",
      type: "POST",
      dataType: "html",
      data:{edit:edit_Id},
      success: function(data){
        $("#tran_edit").html(data);
      }
    })
   })

$(document).ready(function(){
  $("a#approval").click(function(){
    let approval = $(this).attr("value");
    $.ajax({
      url: './process/approval.php',
      type: "POST",
      dataType: 'json',
      data:{approval:approval},
      success: function(data){
        if(data.status == 'credit200'){
          alert("transaction approved and account credited successfully");
          window.location.reload();
        }else if(data.status == 200){
          alert("transaction approved and account debited successfully");
          window.location.reload();
        }
        else if(data.status == 'error500'){
          alert("transaction is already approved");
          window.location.reload();
        }
      }
    })
  })



  $("a#edit_show").on("click",function(){
  let value = $(this).attr('value');
    $.ajax({
      url: "./process/process.php",
      type: "POST",
      dataType: "html",
      data:{edit:value},
      success: function(data){
        if(data){
          $("#showEditCon").show();
          $("#showEdit").html(data);
        }
      }
    })
  })

  //delete transaction history from database
  $("a#delete").click(function(){
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-danger m-3',
        cancelButton: 'btn btn-success'
      },
      buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'YES',
      cancelButtonText: 'NO',
      reverseButtons: true,
      width: '50%',
      height: '20%'
    }).then((result) => {
      if (result.isConfirmed) {
        let deleteVal = $(this).attr('value');
        $.ajax({
          url: './process/delete.php',
          type: "POST",
          dataType: 'html',
          data:{delVal:deleteVal},
          success: function(){
            alert("History deleted successfully");
            window.location.reload();
          }
        })
      } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ){
          window.location.reload();
      //   swalWithBootstrapButtons.fire(
      //     'Cancelled',
      //     'Your imaginary file is safe :)',
      //     'error'
      //   )
      }
    })
  })

  //Codes generating call
  $("button#codes").click(function(){
    let userRef = $(this).attr("value");
    $.ajax({
      url: './process/codes.php',
      type: "POST",
      dataType: 'json',
      data:{user:userRef},
      beforeSend: function(){
        $("a#codes").html('codes Generating');
      },
      success: function(data) {
        if (data.status == 200){
          alert("codes have been generated successfully");
          window.location.reload();
        }else if (data.status == 500){
          alert("Couldn't generate codes'");
          window.location.reload();
        }else{
          alert("Codes have already been generated'");
          window.location.reload();
        }
      },
      complete: function(){
        $("a#codes").html('Generate Codes');
      }
    })
  })

  // show codes generated function
  $("button#view").click(function(){
    let codeRef = $(this).attr("value");
    $.ajax({
      url: './process/view_codes.php',
      type: 'POST',
      dataType: 'html',
      data:{codeRef: codeRef},
      success: function(data){
        $(".code-background").show();
        $("#showcodes").html(data);
      }

    })
  })

  //activate/deactivate account function
  $("button#activate").click(function(){
    let codeRef = $(this).attr("value");
    $.ajax({
        url: './process/activate_ajax.php',
        type: 'POST',
        dataType: 'json',
        data:{codeRef: codeRef},
        success: function(responseText){
          if(responseText.status == 200){
            alert("Your account has been deactivated");
            window.location.reload();
          }else{
            alert("Your account has been activated");
            window.location.reload();
          }

        }
    })
  })

  //suspend/unsuspend account function

  $("button#blockTransfer").click(function(){
    let codeRef = $(this).attr("value");
    $.ajax({
      url: './process/suspend.php',
      type: 'POST',
      dataType: 'json',
      data:{codeRef: codeRef},
      success: function(responseText){
        if(responseText.status == 200){
          alert("Your account has been SUSPENDED");
          window.location.reload();
        }else{
          alert("Your account has been UNSUSPENDED");
          window.location.reload();
        }
      }
    })
  })
})

    //search from data base via usernames function
   $(document).ready(function(){
     $("#edit-Search").keyup(function(){
       let search = $("#edit-Search").val();
       if(search == ""){
          $("#searchShow").show();
       }else{
         $.ajax({
           url: "./process/edit_search.php",
           type: "POST",
           data:{search:search},
           success: function(data){
             $("#searchShow").html(data);
           }

         })
       }
     })

     //search from customer registeration details via Names function
     $("#name-Search").keyup(function(){
       let search = $("#name-Search").val();
       if(search == ""){
          $("#searchShow").show();
       }else{
         $.ajax({
           url: "./process/user_search.php",
           type: "POST",
           data:{search:search},
           success: function(data){
             $("#searchShow").html(data);
           }

         })
       }
     })

     //transfer blocking and unblocking funciton

     $("button#blockTrans").click(function(){
       let custValue = $(this).attr("value");
       $.ajax({
         url: "./process/block_trans.php",
         type: "POST",
         dataType: "json",
         data:{custValue:custValue},
         success: function(responseText){
          if(responseText.status == 200){
            alert("Transfer has been blocked and code will be required for all transfer");
            window.location.reload();
          }else{
            alert("Transfer has been unblocked and code will not be required during transfer");
            window.location.reload();
          }
         }
       })
     })
     
  })
   
   
   

  
