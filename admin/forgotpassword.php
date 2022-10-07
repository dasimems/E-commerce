<?php

// admin index page


require_once('../includes/session.php');
require_once('../includes/db_connect.php');
require_once('../includes/functions.php');




//this checks if session is set

if (isset($_SESSION['unametwo']) && isset($_SESSION['adminidtwo']) && !empty($_SESSION['unametwo']) && !empty($_SESSION['adminidtwo'])) {

    //if session is set, this confirm if it's found in database
    $sql = "SELECT * FROM admin WHERE id=:aId AND auname=:aUname LIMIT 1";

    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':aId', $_SESSION['adminidtwo']);
    $stmt->bindValue(':aUname', $_SESSION['unametwo']);
    $stmt->execute();
    $checkIfAvailable = $stmt->rowcount();

    if ($checkIfAvailable == 1) {
        $details = $stmt->fetch();
        $adminid = $details['id'];
        $adminusername = $details['auname'];
        $adminemail = $details['aemail'];
        $adminphoneNumber = $details['aphone_number'];
    } else {

        $_SESSION['errormessage'] = "Inavlid Details.";
        $_SESSION['uname'] = null;
        $_SESSION['adminid'] = null;
        redirect('forgotpassword.php');
    }
}


if (isset($_SESSION['uname']) && isset($_SESSION['adminid']) && !empty($_SESSION['uname']) && !empty($_SESSION['adminid'])) {

    //if session is set, this confirm if it's found in database
    $sql = "SELECT * FROM admin WHERE id=:aId AND auname=:aUname LIMIT 1";

    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':aId', $_SESSION['adminid']);
    $stmt->bindValue(':aUname', $_SESSION['uname']);
    $stmt->execute();
    $checkIfAvailable = $stmt->rowcount();

    if ($checkIfAvailable == 1) {
        $details = $stmt->fetch();
        $adminid = $details['id'];
        $adminusername = $details['auname'];
        $adminemail = $details['aemail'];
        $adminphoneNumber = $details['aphone_number'];
    } else {

        $_SESSION['errormessage'] = "Inavlid Details.";
        $_SESSION['uname'] = null;
        $_SESSION['adminid'] = null;
        redirect('forgotpassword.php');
    }
}





function checkifotpsent()
{
    if (isset($_SESSION['sent']) || isset($_SESSION['verified'])) {
        if (!empty($_SESSION['sent']) || !empty($_SESSION['verified'])) {
            echo 'style="display: none;"';
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
        <title>Reset Password</title>
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



    <div class="password-reset-form">

        <?php

        if (isset($_POST['get_otp'])) {
            print_r($_POST);
            if (!empty($_POST['forgot_password_details'])) {

                $forgotpassworddetails = $_POST['forgot_password_details'];

                $forgot_password_otp = mt_rand(100000, 999999);


                $forgotpasssql = "UPDATE admin SET aforgot_password_otp='$forgot_password_otp' WHERE id=:adminid AND auname=:adminusername LIMIT 1";
                $forgotstmt = $connect->prepare($forgotpasssql);
                $forgotstmt->bindValue(':adminid', $adminid);
                $forgotstmt->bindValue(':adminusername', $adminusername);
                $forgotexec = $forgotstmt->execute();

                if ($forgotpassworddetails === $adminemail) {

                    if ($forgotexec) {

                        $_SESSION['successmessage'] = 'OTP Has Been Sent To Your Email Address';
                        $_SESSION['sent'] = "otp is sent";
                        redirect('forgotpassword.php');
                    } else {
                        $_SESSION['errormessage'] = 'Something Went Wrong. Please Try Again Later!';
                        redirect('forgotpassword.php');
                    }
                } elseif ($forgotpassworddetails === $adminphoneNumber) {

                    if ($forgotexec) {

                        $_SESSION['successmessage'] = 'OTP Has Been Sent To Your Phone Number';
                        $_SESSION['sent'] = "otp is sent";
                        redirect('forgotpassword.php');
                    } else {
                        $_SESSION['errormessage'] = 'Something Went Wrong. Please Try Again Later!';
                        redirect('forgotpassword.php');
                    }
                }

                //                $_SESSION['forgot_password_details'] = $_POST['forgot_password_details'];
                //                redirect('forgotpassword.php');

            } else {
                $_SESSION['errormessage'] = 'Please Select Either Your Email OR Phone Number';
                redirect('forgotpassword.php');
            }
        }

        if (!isset($adminid) && !isset($adminusername)) {

        ?>

            <p>Please Input Your Email To Continue</p>

            <form action="verify_forgot_pass.php" method="post">

                <input type="email" name="check_password_email" placeholder="Input Your Email" id="check_password_email">
                <input type="submit" name="find_email" value="Verify">

            </form>


        <?php

        } else {
        ?>


            <p <?php checkifotpsent(); ?>>Please Select Where You Will Like To Receive Your Password Reset OTP</p>

            <form action="forgotpassword.php" method="post" <?php checkifotpsent(); ?>>

                <div class="">

                    <input type="radio" name="forgot_password_details" id="forgot_password_email" value="<?php echo $adminemail; ?>">
                    <label for="forgot_password_email"><?php echo $adminemail; ?></label><br><br>
                    <input type="radio" name="forgot_password_details" id="forgot_password_phone" value="<?php echo $adminphoneNumber; ?>">
                    <label for="forgot_password_phone"><?php echo substr($adminphoneNumber, 0, 6) . "****" . substr($adminphoneNumber, 11, 13); ?></label>
                    <input type="submit" value="Get OTP" name="get_otp">

                </div>

            </form>

            <?php
            if (isset($_SESSION['sent'])) {
                if (!empty($_SESSION['sent'])) {




            ?>

                    <p>Please Input The OTP Sent To Your Inbox</p>

                    <form action="verify_forgot_pass.php" method="post">

                        <input type="number" name="forgot_pass_otp" id="forgot_pass_otp" placeholder="Input OTP...">

                        <input type="submit" name="forgot_pass_otp_submit" value="Verify">
                    </form>


                <?php

                }
            }

            if (isset($_SESSION['verified'])) {
                if (!empty($_SESSION['verified'])) {

                ?>


                    <h2>Reset Password</h2>

                    <form action="verify_forgot_pass.php" method="post">

                        <input type="password" id="reset_password" name="reset_password" placeholder="Input New Password">

                        <input type="password" id="confirm_reset_password" name="confirm_reset_password" placeholder="Confirm New Password">

                        <input type="submit" name="submit_reset_password" value="Update Password">

                    </form>

            <?php
                }
            }

            ?>


        <?php
        }

        ?>



    </div>





</body>



<script src="../js/script.js"></script>

</html>