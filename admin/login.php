<?php

// admin login page



require_once('../includes/session.php');
require_once('../includes/db_connect.php');
require_once('../includes/functions.php');




if (isset($_SESSION['uname']) && isset($_SESSION['adminid']) && !empty($_SESSION['uname']) && !empty($_SESSION['adminid'])) {

    //if session is set, this confirm if it's found in database
    $sql = "SELECT * FROM admin WHERE id=:aId AND auname=:aUname LIMIT 1";

    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':aId', $_SESSION['adminid']);
    $stmt->bindValue(':aUname', $_SESSION['uname']);
    $stmt->execute();
    $checkIfAvailable = $stmt->rowcount();

    if ($checkIfAvailable == 1) {
        // $_SESSION['successmessage'] = "You're Already Logged In!";
        if (isset($_SESSION['last_page'])) {
            $_SESSION['successmessage'] = "You're Already Logged In!";
            $page = $_SESSION['last_page'];
            redirect($page);
        } else {
            $_SESSION['successmessage'] = "You're Already Logged In!";
            redirect('dashboard.php');
        }
    }
}

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin Login</title>
    <!--        bringing in all the required styles and scripts-->
        <link rel="stylesheet" href="../style/all.css">
        <script src="../js/all.js"></script>
        <link rel="stylesheet" href="../style/style.css">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    
        
    <body onload="docfinish()">
    
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

            
            <div class="loader">
                
                <div class="loader-container">
                
                    <div class="loader-anim-one"></div>
                
                </div>
            
            </div>
     
            <?php
    
                echo errormessage();
                echo sucessmessage();
            ?>
            

    <nav class="nav-bar">

        <div class="logo"><img src="../style/images/transparent%20ecommerce-logo.png"></div>

    </nav>

    <section class="login-section">

        <h1 class="login-section-title">LOGIN</h1>

        <form action="checklogin.php" method="post">


            <div class="login-form-input">
                <label for="uname"><i class="fas fa-user"></i></label>
                <input type="text" name="uname" id="uname" placeholder="Please Input Your Username..." />

            </div>

            <div class="login-form-input">
                <label for="password"><i class="fas fa-key"></i></label>
                <input type="password" name="password" id="password" placeholder="Please Input Your Password..." />

            </div>



            <input type="checkbox" value="rememberMe" name="rememberme" id="remember-me">

            <label for="remember-me" id="remember-me">Remember Me</label>


            <div class="login-form-input">

                <input type="submit" value="Submit" id="submit-btn">

            </div>

        </form>

        <div class="forget-password-container">

            <a href="forgotpassword.php">Forgot Password?</a>

        </div>

    </section>


    <script src="../js/script.js"></script>
</body>

</html>