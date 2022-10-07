<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.1.1/cerulean/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./assets/scss/style.css">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="../assets/image/corvus.png">
</head>
<body>
    <header >
        
        <div class="notice" id="notice">
            <div class="container-work" id="first">
                <div class="bigcontainer">
                    <h3>Important Notice:</h3>
                    <span>
                        Please be mindful of fake sites run by fraudulent parties posing as Guaranty Trust Bank Ltd or its affiliates. Do not disclose your personal information and financial details to anyone online or anywhere else.
                    </span>
                </div>
            </div>
        </div>
        <nav>
            <div class="nav-small">
                <div class="small-links">
                    <span class="list" id="nav-open"> <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="10.7" viewBox="0 0 16 10.7"><path d="M0 1.8h16V0H0v1.8zm0 4.4h16V4.4H0v1.8zm0 4.5h16V8.9H0v1.8z"></path></svg></a></span>
                    <span id="search-open" class="search-top"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path fill-rule="evenodd" d="M14.18 13.24c1.172-1.41 1.91-3.22 1.91-5.2C16.09 3.62 12.47 0 8.044 0S0 3.62 0 8.04c0 4.43 3.62 8.05 8.045 8.05a7.915 7.915 0 0 0 5.195-1.91l3.62 3.62c.134.13.302.2.47.2a.683.683 0 0 0 .47-.2.65.65 0 0 0 0-.94l-3.62-3.62zm-6.135 1.54c-3.687 0-6.704-3.01-6.704-6.7 0-3.69 3.017-6.71 6.704-6.71s6.704 3.02 6.704 6.71-3.017 6.7-6.704 6.7z"></path></svg></a></span>
                    <div class="search-d-content" id="search-display">
                        <input type="text" class="search-input" placeholder="Search" id="search-input">
                        <div class="search-container" >
                            <span id="s-close" class="search-close">&times</span>
                        </div>
                    </div>
                    <span class="loginBtn" id="loginBtn"><a href="#"><span class="cat"><svg xmlns="http://www.w3.org/2000/svg" style="color: white" width="14" height="18" viewBox="0 0 14 18"><path fill-rule="evenodd" d="M2.625 6H0v12h14V6H2.625zM1.5 7.5h11v9h-11v-9zM6.993 0c2.19-.004 4 1.805 4.007 4.04V6H3V4.053C2.998 1.818 4.803.008 6.993 0zm.003 1.5a2.538 2.538 0 0 0-2.541 2.553V6h5.09V4.043A2.538 2.538 0 0 0 6.996 1.5z"></path></svg></span>Login</a></span>
                        
                        <!-- small screen login page -->
                        <div class="login-D-down login-m-page" id="login-display">
                            <div class="login-container">
                                <span id="login-close" class="login-close">&times</span>
                            </div>
                            <h5>Online Banking</h5>
                            <div class="login-links">
                                <span><a href="#" id="personal-color" onclick="perFunction()">Personal</a></span>
                                <span><a href="#" id="business-color"  onclick="busFunction()">Business</a></span>
                                <span id="personal-underline"  style="width: 32%; margin-left: 30%; margin-top: 25px; border-bottom: 2px solid orangered; display: block;"></span>
                                <div  class="acc-bord-bottom">
                                    <p id="click-personal"  style="width: 32%; margin-left: 30%; margin-top: 25px;"></p>
                                    <p id="click-business"  style="width: 32%; margin-left: 55%; margin-top: 25px;"></p>
                                </div>
                            </div>
                            <div class="l-d-content">
                                <div class="drop-content2">
                                    <a href="./register.php" target="_blank" class="personal" id="person">Login</a>
                                    <a href="../login.php" target="_blank" class="business" id="busin">Login</a>
                                    <div class="l-register">
                                        <span><a href="#">Register</a></span>
                                        <hr>
                                        <span><a href="#">Demo</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="small-logo">
                        <img style="width: 150px" src="../assets/image/brooklogo.png" alt="">
                    </div>
                    <hr>
                </div>  
            </div>
            
            <!-- Medium media screen login page -->
            <div class="login-m-page" id="log">
                <span class="med-login-close" onclick="document.getElementById('log').style.display = 'none'">&times</span>
                <h5>Online Banking</h5>
                <div class="login-links">
                    <span><a href="#" id="personal-color-medium" onclick="perFunctionMed()">Personal</a></span>
                    <span><a href="#" id="business-color-medium"  onclick="busFunctionMed()">Business</a></span>
                    <span id="personal-underline-medium"  style="width: 100px; margin-left: 80px; margin-top: 25px; border-bottom: 2px solid orangered; display: block;"></span>
                    <div  class="acc-bord-bottom">
                        <p id="click-personal-medium"  style="width: 100px; margin-left: 80px; margin-top: 25px;"></p>
                        <p id="click-business-medium"  style="width: 100px; margin-left: 200px; margin-top: 25px;"></p>
                    </div>
                </div>
                <div class="l-d-content">
                    <div class="drop-content2">
                        <a href="#" target="_blank" class="personal" id="person-medium" >Login</a>
                        <button    class="business click-btn" id="busin-medium" onclick="document.getElementById('modal-page').style.display ='block';">Login</button>
                        <div class="l-register">
                            <span><a href="./register.php">Register</a></span>
                            <hr>
                            <span><a href="../controll/login.php">Demo</a></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navigations">
                <ul class="secondary">
                    <li><a href="">Locate<i class="fa-solid fa-angle-down"></i></a></li>
                    <li><a href="">Media</a></li>
                    <li><a href="">Help Centre<i class="fa-solid fa-angle-down"></i></a></li>
                    <li><a href="">Security</a></li>
                    <li><a href=""><i class="fa-solid fa-magnifying-glass"></i></a></li>
                </ul>
                <ul class="primary">
                    <li><a href="../controller/login.php"><i class="fa-solid fa-lock"></i>Login<i class="fa-solid fa-angle-right"></i></a></li>
                </ul>
                <div class="logo">
                    <img style="width: 300px" src="../assets/image/brooklogo.png" alt="">
                </div>
            </div>
        </nav>
        <section class="nav2">
        <div class="navigation2" id="nav-display">
                <div class="close-container">
                    <span class="closeNav" id="nav-close">&times</span>
                </div>
            <ul class="navigation-list">
                <li class="homeBtn-icon"><a href=""><i class="fa-solid fa-house-chimney"></i><span class="homeBtn">Home</span></a></li>
                <li class="drobBtn1">Personal Banking <span class="angles"><i class="fa-solid fa-angle-right"></i></span>
                    <div class="drop-wrap1">
                        <div class="drop-hover-wrapper">
                            <div class="drop-content1 drop-content-large">
                                <div class="drop-accounts">
                                    <a href="#" class="dropBtn2">Accounts<i class="fa-solid fa-angle-right"></i>
                                    <div class="drop-content2">
                                        <div class="vierities-acc">
                                            <a class="content-a cont-a" href="">Current Accounts <i class="fa-solid fa-angle-right"></i></a></a>
                                            <div class="current-acc-cont">
                                                <a href="#">Individual Current Accounts</a>
                                                <a href="#">e-Account</a>
                                                <a href="#">Domiciliary Account</a>
                                                <a href="#">Gtmax</a>
                                                <a href="#">Seniors Account</a>
                                            </div>
                                        </div>
                                        <a class="content-a" href="">Savings & Investment Accounts <i class="fa-solid fa-angle-right"></i></a>
                                        <a class="content-a" href="">Compare Accounts </a>
                                        <a class="content-a" href="./register.php">Open an Accounts</a>
                                    </div>
                                </div>
                                <a href="#">Services<i class="fa-solid fa-angle-right"></i></a>
                                <a href="#">Cards<i class="fa-solid fa-angle-right"></i></a>
                                <a href="#">Loans<i class="fa-solid fa-angle-right"></i></a>
                                <a href="#">Ways to Bank<i class="fa-solid fa-angle-right"></i></a>
                                <a href="#">Non Resident Nigerian <br>(NRN) Service  <i class="fa-solid fa-angle-right"></i></a>
                                <a href="#">Private Banking <i class="fa-solid fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>Business Banking <span class="angles"><i class="fa-solid fa-angle-right"></i></span>
                <div class="drop-wrap1"></div>
                </li>
                <li>About Us <span class="angles"><i class="fa-solid fa-angle-right"></i></span>
                    <div class="drop-wrap1"></div>
                </li>
                <li>Investor Relationships <span class="angles"><i class="fa-solid fa-angle-right"></i></span>
                    <div class="drop-wrap1"></div>
                </li>
                <li>Open an Account <span class="angles"><i class="fa-solid fa-angle-right"></i></span>
                    <div class="drop-wrap1"></div>
                </li>
            </ul>
            <div class="tour">
                <a href="#first"> <i class="fa-solid fa-play"></i><spann class="welcome">Welcome Tour</span></a>
            </div>
        </div>
    </section>
    </header>