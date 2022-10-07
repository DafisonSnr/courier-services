

// open navigation documents
let navOpen = document.getElementById("nav-open");
let navDisplay = document.getElementById("nav-display");
let navClose = document.getElementById("nav-close");
let notice = document.getElementById("notice");
let mained = document.getElementById("main-display");


// search document

let searchOpen = document.getElementById("search-open");
let searchDisplay = document.getElementById("search-display");
let searchClose = document.getElementById("s-close");

//login documents
let loginBtn = document.getElementById("loginBtn");
let closeBtn = document.getElementById("login-close");
let loginDisplay = document.getElementById("login-display");


//navigation eventListener
function navOpenFunction(){
    if(searchDisplay.style.display == 'block' || loginDisplay.style.display == 'block'){
        document.body.classList.add("stop-scrolling");
        navDisplay.style.display = 'block';
        searchDisplay.style.display = 'none';
        searchOpen.style.visibility = 'visible';
        loginDisplay.style.display = 'none';
        loginBtn.style.visibility = 'visible';
        navOpen.style.visibility = 'hidden';
        notice.style.opacity = '0.4';
       
    }else{
        document.body.classList.add("stop-scrolling");
        navOpen.style.visibility = 'hidden';
        navDisplay.style.display = 'block';
        notice.style.opacity = '0.4';
        navOpen.style.visibility = 'hidden';
    }
   
}
//navigation close eventListner
navClose.addEventListener('click', ()=>{
    document.body.classList.remove("stop-scrolling");
    document.getElementById("nav-display").style.display = 'none';
    navOpen.style.visibility = 'visible';
    notice.style.opacity = '1';
})

//open search EventListner
function searchOp(){
    if(navDisplay.style.display == 'block' || loginDisplay.style.display == 'block'){
        document.body.classList.add("stop-scrolling");
        loginDisplay.style.display = 'none';
        loginBtn.style.visibility = 'visible';
        navOpen.style.visibility = 'visible';
        navDisplay.style.display = 'none';
        searchDisplay.style.display = 'block';
        searchOpen.style.visibility = 'hidden';
        notice.style.opacity = '0.4';
        mained.style.opacity = '0.4';
    }else{
        document.body.classList.add("stop-scrolling");
        searchOpen.style.visibility = 'hidden';
        searchDisplay.style.display = 'block';
        notice.style.opacity = '0.4';
        mained.style.opacity = '0.4';
    }
}
//close search EventListner
searchClose.addEventListener('click', ()=>{
    document.body.classList.remove('stop-scrolling')
        searchDisplay.style.display = 'none'
        searchOpen.style.visibility = 'visible';
        notice.style.opacity = '1';
        mained.style.opacity = '1';
})
function  body(){
 leftScroll = window.pageXOffset || window.documentElement.leftScroll;
 window.onscroll = function(){
     window.onsecuritypolicyviolation(leftScroll);
 }
}
//open login EventListner
function loginBtnFunction(){
//     TopScroll = window.pageYOffset || document.documentElement.scrollTop;
//     LeftScroll = window.pageXOffset || document.documentElement.scrollLeft,

// // if scroll happens, set it to the previous value
// window.onscroll = function() {
// window.scrollTo(LeftScroll, TopScroll);
//         };
    if(navDisplay.style.display == 'block' || searchDisplay.style.display == 'block' ){
        document.body.classList.add("stop-scrolling");
        navDisplay.style.display = 'none';
        searchDisplay.style.display = 'none';
        navOpen.style.visibility = 'visible';
        searchOpen.style.visibility = 'visible';
        loginBtn.style.visibility = 'hidden';
        document.getElementById('login-display').style.display = "block";
        notice.style.opacity = '0.4';
        mained.style.opacity = '0.4';
    }else{
        document.body.classList.add("stop-scrolling");
        loginBtn.style.visibility = 'hidden';
        document.getElementById('login-display').style.display = "block"; 
        notice.style.opacity = '0.4';
        mained.style.opacity = '0.4';
    }
    
}
//close login EventListner
closeBtn.addEventListener('click', ()=>{
    // window.onscroll = function() {};
    document.body.classList.remove("stop-scrolling"); 
    document.getElementById('login-display').style.display = "none";
    loginBtn.style.visibility = 'visible';
    notice.style.opacity = '1';
    mained.style.opacity = '1';
})




//account login switch
let busLink = document.getElementById("busin");
let perLink = document.getElementById("person");
let clickBus = document.getElementById("click-business");
let clickPer = document.getElementById("click-personal");
let perColor = document.getElementById("personal-color")
let busColor = document.getElementById("business-color");
let perUnderline = document.getElementById("personal-underline")
function perFunction(){ 
    if(perLink.style.display == "none" || busLink.style.display == "block"){
        busLink.style.display = "none";
        busColor.style.color = "black";
        clickBus.style.border = "none";

        perLink.style.display = "block";
        perColor.style.color = "orangered";
        perUnderline.style.border = "none";
        clickPer.style.borderBottom = "2px solid orangered";

    }else{
        perLink.style.display = 'block';
        perUnderline.style.borderBottom = "2px solid orangered";
        clickPer.style.border = "none";
        perColor.style.color = "orangered"

    }
}

function busFunction(){
    if(busLink.style.display == 'none' || perLink.style.display == 'block' || perUnderline.style.borderBottom == '2px solid orangered'){
        perLink.style.display = "none";
        perUnderline.style.border = "none";
        clickPer.style.border = "none";
        perColor.style.color = "black";

        busLink.style.display = "block";
        busColor.style.color = "orangered";
        clickBus.style.borderBottom = "2px solid orangered";
    }else{
        busLink.style.display = 'block';
        clickBus.style.borderBottom = '2px solid orangered';
        busColor.style.color = 'orangered';
    }
    
}

let busLinkMed = document.getElementById("busin-medium");
let perLinkMed = document.getElementById("person-medium");
let clickBusMed = document.getElementById("click-business-medium");
let clickPerMed = document.getElementById("click-personal-medium");
let perColorMed = document.getElementById("personal-color-medium");
let busColorMed = document.getElementById("business-color-medium");
let perUnderlineMed = document.getElementById("personal-underline-medium");
function perFunctionMed(){ 
    if(perLinkMed.style.display == "none" || busLinkMed.style.display == "block"){
        busLinkMed.style.display = "none";
        busColorMed.style.color = "black";
        clickBusMed.style.border = "none";

        perLinkMed.style.display = "block";
        perColorMed.style.color = "orangered";
        perUnderlineMed.style.border = "none";
        clickPerMed.style.borderBottom = "2px solid orangered";

    }else{
        perLinkMed.style.display = 'block';
        perUnderlineMed.style.borderBottom = "2px solid orangered";
        clickPerMed.style.border = "none";
        perColorMed.style.color = "orangered"

    }
}

function busFunctionMed(){
    if(busLinkMed.style.display == 'none' || perLinkMed.style.display == 'block' || perUnderlineMed.style.borderBottom == '2px solid orangered'){
        perLinkMed.style.display = "none";
        perUnderlineMed.style.border = "none";
        clickPerMed.style.border = "none";
        perColorMed.style.color = "black";

        busLinkMed.style.display = "block";
        busColorMed.style.color = "orangered";
        clickBusMed.style.borderBottom = "2px solid orangered";
    }else{
        busLinkMed.style.display = 'block';
        clickBusMed.style.borderBottom = '2px solid orangered';
        busColorMed.style.color = 'orangered';
    }
    
}






//buttom navigation clicks
let personDropContent = document.getElementById('drop-content1');
let personUnderline = document.getElementById('per-underline');
let perDownAngle = document.getElementById('per-down-angle');
let perUpAngle = document.getElementById('per-up-angle');


//business document calls
let busDropContent = document.getElementById('bus-content');
let busUnderline = document.getElementById('bus-underline');
let busDownAngle = document.getElementById('bus-down-angle');
let busUpAngle = document.getElementById('bus-up-angle');

//about documents call
let abtDropContent = document.getElementById('about-content');
let abtUnderline = document.getElementById('abt-underline');
let abtDownAngle = document.getElementById('abt-down-angle');
let abtUpAngle = document.getElementById('abt-up-angle');

//about documents call
let helpDropContent = document.getElementById('help-content');
let helpUnderline = document.getElementById('help-underline');
let helpDownAngle = document.getElementById('help-down-angle');
let helpUpAngle = document.getElementById('help-up-angle');

//about documents call
let linksDropContent = document.getElementById('links-content');
let linksUnderline = document.getElementById('links-underline');
let linksDownAngle = document.getElementById('links-down-angle');
let linksUpAngle = document.getElementById('links-up-angle');


//personal function call
function personal(e){
    const mediaQuery = window.matchMedia('(min-width: 768px)');
    if(mediaQuery.matches){
        e.preventDefault();
    }
   if(busDropContent.style.display == 'block' || abtDropContent.style.display == 'block' ||
    linksDropContent.style.display == 'block'  || helpDropContent.style.display == 'block' ||
    personDropContent.style.display == 'none'){
        busDropContent.style.display = 'none';
        busDownAngle.style.visibility = 'visible';
        busUpAngle.style.display = 'none';
        busUnderline.style.borderBottom = '1px solid #ccc';

        abtDropContent.style.display = 'none';
        abtDownAngle.style.visibility = 'visible';
        abtUpAngle.style.display = 'none';
        abtUnderline.style.borderBottom = '1px solid #ccc';

        helpDropContent.style.display = 'none';
        helpDownAngle.style.visibility = 'visible';
        helpUpAngle.style.display = 'none';
        helpUnderline.style.borderBottom = '1px solid #ccc';

        linksDropContent.style.display = 'none';
        linksDownAngle.style.visibility = 'visible';
        linksUpAngle.style.display = 'none';
        linksUnderline.style.borderBottom = '1px solid #ccc';

        personDropContent.style.display = 'block';
        perDownAngle.style.visibility = 'hidden';
        perUpAngle.style.display = 'block';
        personUnderline.style.borderBottom = 'none';
   }else{
        personDropContent.style.display = 'none';
        perDownAngle.style.visibility = 'visible';
        perUpAngle.style.display = 'none';
        personUnderline.style.borderBottom = '1px solid #ccc';
   }

    
}

//business drop down function
function business(e){
    const mediaQuery = window.matchMedia('(min-width: 768px)');
    if(mediaQuery.matches){
        e.preventDefault();
    }
    if(personDropContent.style.display == 'block' || abtDropContent.style.display == 'block' ||
    linksUnderline.style.display == 'block' || helpDropContent.style.display == 'block' ||
    busDropContent.style.display == 'none'){
        personDropContent.style.display = 'none';
        perDownAngle.style.visibility = 'visible';
        perUpAngle.style.display = 'none';
        personUnderline.style.borderBottom = '1px solid #ccc';

        abtDropContent.style.display = 'none';
        abtDownAngle.style.visibility = 'visible';
        abtUpAngle.style.display = 'none';
        abtUnderline.style.borderBottom = '1px solid #ccc';

        helpDropContent.style.display = 'none';
        helpDownAngle.style.visibility = 'visible';
        helpUpAngle.style.display = 'none';
        helpUnderline.style.borderBottom = '1px solid #ccc';

        linksDropContent.style.display = 'none';
        linksDownAngle.style.visibility = 'visible';
        linksUpAngle.style.display = 'none';
        linksUnderline.style.borderBottom = '1px solid #ccc';

        busDropContent.style.display = 'block';
        busDownAngle.style.visibility = 'hidden';
        busUpAngle.style.display = 'block';
        busUnderline.style.borderBottom = 'none';
    }else{
        busDropContent.style.display = 'none';
        busDownAngle.style.visibility = 'visible';
        busUpAngle.style.display = 'none';
        busUnderline.style.borderBottom = '1px solid #ccc';
    }
}

//about drop down function
function about(e){
    const mediaQuery = window.matchMedia('(min-width: 768px)');
    if(mediaQuery.matches){
        e.preventDefault();
    }
    if(personDropContent.style.display == 'block' || busDropContent.style.display == 'block' ||
    linksUnderline.style.display == 'block' || helpDropContent.style.display == 'block' ||
    abtDropContent.style.display == 'none'){
        personDropContent.style.display = 'none';
        perDownAngle.style.visibility = 'visible';
        perUpAngle.style.display = 'none';
        personUnderline.style.borderBottom = '1px solid #ccc';

        busDropContent.style.display = 'none';
        busDownAngle.style.visibility = 'visible';
        busUpAngle.style.display = 'none';
        busUnderline.style.borderBottom = '1px solid #ccc';

        helpDropContent.style.display = 'none';
        helpDownAngle.style.visibility = 'visible';
        helpUpAngle.style.display = 'none';
        helpUnderline.style.borderBottom = '1px solid #ccc';

        linksDropContent.style.display = 'none';
        linksDownAngle.style.visibility = 'visible';
        linksUpAngle.style.display = 'none';
        linksUnderline.style.borderBottom = '1px solid #ccc';

        abtDropContent.style.display = 'block';
        abtDownAngle.style.visibility = 'hidden';
        abtUpAngle.style.display = 'block';
        abtUnderline.style.borderBottom = 'none';

    }else{
        abtDropContent.style.display = 'none';
        abtDownAngle.style.visibility = 'visible';
        abtUpAngle.style.display = 'none';
        abtUnderline.style.borderBottom = '1px solid #ccc';
    }
}

//help and security function
function help(e){
    const mediaQuery = window.matchMedia('(min-width: 768px)');
    if(mediaQuery.matches){
        e.preventDefault();
    }
    if(personDropContent.style.display == 'block' || busDropContent.style.display == 'block' ||
    linksDropContent.style.display == 'block' || abtDropContent.style.display == 'block' ||
    helpDropContent.style.display == 'none'){
        personDropContent.style.display = 'none';
        perDownAngle.style.visibility = 'visible';
        perUpAngle.style.display = 'none';
        personUnderline.style.borderBottom = '1px solid #ccc';

        busDropContent.style.display = 'none';
        busDownAngle.style.visibility = 'visible';
        busUpAngle.style.display = 'none';
        busUnderline.style.borderBottom = '1px solid #ccc';

        abtDropContent.style.display = 'none';
        abtDownAngle.style.visibility = 'visible';
        abtUpAngle.style.display = 'none';
        abtUnderline.style.borderBottom = '1px solid #ccc';

        linksDropContent.style.display = 'none';
        linksDownAngle.style.visibility = 'visible';
        linksUpAngle.style.display = 'none';
        linksUnderline.style.borderBottom = '1px solid #ccc';

        helpDropContent.style.display = 'block';
        helpDownAngle.style.visibility = 'hidden';
        helpUpAngle.style.display = 'block';
        helpUnderline.style.borderBottom = 'none';

    }else{
        helpDropContent.style.display = 'none';
        helpDownAngle.style.visibility = 'visible';
        helpUpAngle.style.display = 'none';
        helpUnderline.style.borderBottom = '1px solid #ccc';
    }
}


//quick links function
function quicklinks(e){
    const mediaQuery = window.matchMedia('(min-width: 768px)');
    if(mediaQuery.matches){
        e.preventDefault();
    }
    if(personDropContent.style.display == 'block' || busDropContent.style.display == 'block' ||
    helpDropContent.style.display == 'block' || abtDropContent.style.display == 'block' ||
    linksDropContent.style.display == 'none'){
        personDropContent.style.display = 'none';
        perDownAngle.style.visibility = 'visible';
        perUpAngle.style.display = 'none';
        personUnderline.style.borderBottom = '1px solid #ccc';

        busDropContent.style.display = 'none';
        busDownAngle.style.visibility = 'visible';
        busUpAngle.style.display = 'none';
        busUnderline.style.borderBottom = '1px solid #ccc';

        abtDropContent.style.display = 'none';
        abtDownAngle.style.visibility = 'visible';
        abtUpAngle.style.display = 'none';
        abtUnderline.style.borderBottom = '1px solid #ccc';

        helpDropContent.style.display = 'none';
        helpDownAngle.style.visibility = 'visible';
        helpUpAngle.style.display = 'none';
        helpUnderline.style.borderBottom = '1px solid #ccc';

        linksDropContent.style.display = 'block';
        linksDownAngle.style.visibility = 'hidden';
        linksUpAngle.style.display = 'block';
        linksUnderline.style.borderBottom = 'none';

    }else{
        linksDropContent.style.display = 'none';
        linksDownAngle.style.visibility = 'visible';
        linksUpAngle.style.display = 'none';
        linksUnderline.style.borderBottom = '1px solid #ccc';
    }
}

//gtconnect documents call 
let gtconUpAngle = document.getElementById('gtconnect-up-angle');
let gtconDownAngle = document.getElementById('gtconnect-down-angle');
let gtconDropDown = document.getElementById('gtconnect-drop');
function gtconnect(e){
    const mediaQuery = window.matchMedia('(min-width: 768px)');
    if(mediaQuery.matches){
        e.preventDefault();
    }
    if(gtconDropDown.style.display == 'none'){
        gtconDropDown.style.display = 'block';
        gtconDownAngle.style.visibility = 'hidden';
        gtconUpAngle.style.display = 'block';
    }else{
        gtconDropDown.style.display = 'none';
        gtconDownAngle.style.visibility = 'visible';
        gtconUpAngle.style.display = 'none';
    }
}

// window.onclick = function(e){
//     if(e.target == navDisplay){
//         navDisplay.style.display = 'none';
//     }
//     if(e.target == searchDisplay){
//         searchDisplay.style.display = 'none';
//     }
// }




