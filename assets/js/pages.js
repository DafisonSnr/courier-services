// function userInfo(str){
//     if(str == ''){
//         document.getElementById("txtHint").innerHTML = '';
//     }else{
//         let xmlHttp = new XMLHttpRequest();
//         xmlHttp.onreadystatechange = function(){
//             if(this.readyState == 4 && this.status == 200){
//                 document.getElementById("txtHint").innerHTML = this.responseText;
//             }
//         }
//         xmlHttp.open("GET", "users.php?q="+str, true);
//         xmlHttp.send();
//     }
// }

// var reg = document.getElementById('reg-modal');
   
// window.onclick = function(event) {
// if (event.target == reg) {
//     reg.style.display = "none";
// }
// }

let num25 = document.getElementById('number-25');
let num250 = document.getElementById('number-250');
let num10 = document.getElementById('number-10');
let num1530 = document.getElementById('number-1530');
count = 0;
count2 = 0;
count3 = 0;
count4 = 0;
function countNum(){
    let timeOut = setInterval(()=>{
        if(count == 26){
            clearInterval(timeOut);
        }else{
            num25.innerHTML = count;
            count++;
            
        }
        
    },30)
    let timeOut1 = setInterval(()=>{
        if(count2 == 260){
            clearInterval(timeOut1)
        }else{
            num250.innerHTML = count2;
            count2++;
        }
        
    },1)
    let timeOut2 = setInterval(()=>{
        if(count3 == 11){
            clearInterval(timeOut2)
        }else{
            num10.innerHTML = count3;
            count3++;
        }
        
    },50)
    let timeOut3 = setInterval(()=>{
        if(count4 == 1530){
            clearInterval(timeOut3)
        }else{
            num1530.innerHTML = count4;
            count4 +=10;
        } 
    })
}   
// count numbers on page load
window.onload = function(){
    countNum();
}

let navOpen = document.getElementById('open-nav-btn');
let navContent = document.getElementById('nav-content');
let navEl = document.getElementById('works');
 function showNav(){
    navEl.style.marginRight = '150px';
    navContent.style.width = '250px';
 }
    
// close nav content
navEl.addEventListener("click", () => {
    var mediaQuery = window.matchMedia('(min-width: 768px)');
    if(mediaQuery.matches){

    }else{
        navEl.style.marginRight = '0px';
        document.getElementById('nav-content').style.width = '0px';
    }

});


// <-- script to scroll to top of page -->

let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (
    document.body.scrollTop > 20 ||
    document.documentElement.scrollTop > 20
  ) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener("click", backToTop);

function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

//  script to scroll to to of page endes here 