<?php

// admin index page


require_once('../includes/session.php');
require_once('../includes/db_connect.php');
require_once('../includes/functions.php');


//this checks if session is set

if (!isset($_POST['find_email']) || !isset($_POST['forgot_pass_otp_submit']) || !isset($_POST['submit_reset_password'])) {
    redirect('forgotpassword.php');
}

if (isset($_POST['find_email'])) {

    if (!empty($_POST['check_password_email'])) {

        $verifemail = $_POST['check_password_email'];

        $verifemailsql = "SELECT * FROM admin WHERE aemail=:email LIMIT 1";
        $verifemailstmt = $connect->prepare($verifemailsql);
        $verifemailstmt->bindValue(':email', $verifemail);
        $verifemailexec = $verifemailstmt->execute();

        if ($verifemailexec) {
            $verifemailfetch = $verifemailstmt->fetch();

            if ($verifemailfetch > 0) {
                $_SESSION['adminidtwo'] = $verifemailfetch['id'];
                $_SESSION['unametwo'] = $verifemailfetch['auname'];

                $_SESSION['successmessage'] = 'Email Record Found';
                redirect('forgotpassword.php');
            } else {

                $_SESSION['errormessage'] = 'Email Record Not Found In Our Database';
                redirect('forgotpassword.php');
            }
        }
    } else {
        $_SESSION['errormessage'] = 'Please Input Your Email Address';
        redirect('forgotpassword.php');
    }
}

if (isset($_POST['forgot_pass_otp_submit'])) {
    if (!empty($_POST['forgot_pass_otp'])) {

        if (isset($_SESSION['adminid']) && isset($_SESSION['uname'])) {
            if (!empty($_SESSION['adminid']) && !empty($_SESSION['uname'])) {
                $id = $_SESSION['adminid'];
                $uname = $_SESSION['uname'];
            }
        } elseif (isset($_SESSION['adminidtwo']) && isset($_SESSION['unametwo'])) {
            if (!empty($_SESSION['adminidtwo']) && !empty($_SESSION['unametwo'])) {
                $id = $_SESSION['adminidtwo'];
                $uname = $_SESSION['unametwo'];
            }
        }

        $forgotpassotp = $_POST['forgot_pass_otp'];

        $forgototpsql = "SELECT aforgot_password_otp FROM admin WHERE id='$id' AND auname='$uname' LIMIT 1";
        $forgototpstmt = $connect->query($forgototpsql);
        $forgototpfetch = $forgototpstmt->fetch();

        $fetchedotp = $forgototpfetch['aforgot_password_otp'];

        if ($forgotpassotp === $fetchedotp) {
            $updateotpsql = "UPDATE admin SET aforgot_password_otp='0' WHERE id='$id' AND auname='$uname' LIMIT 1";
            $connect->query($updateotpsql);
            $_SESSION['sent'] = null;
            $_SESSION['verified'] = "verified";
            redirect('forgotpassword.php');
        } else {
            $_SESSION['errormessage'] = 'Invalid OTP';
            redirect('forgotpassword.php');
        }
    } else {
        $_SESSION['errormessage'] = 'Please Input The OTP Sent To You';
        redirect('forgotpassword.php');
    }
}

if (isset($_POST['submit_reset_password'])) {
    if (!empty($_POST['reset_password']) && !empty($_POST['confirm_reset_password'])) {

        $newpass = $_POST['reset_password'];
        $confirmnewpass = $_POST['confirm_reset_password'];

        if ($newpass === $confirmnewpass) {

            
            if(strlen($newpass) < 8){
                $_SESSION['errormessage'] = 'Please Input at Least 8 Characters';
                redirect('forgotpassword.php');
            }else{


                if (isset($_SESSION['adminid']) && isset($_SESSION['uname'])) {
                    if (!empty($_SESSION['adminid']) && !empty($_SESSION['uname'])) {
                        $id = $_SESSION['adminid'];
                        $uname = $_SESSION['uname'];
                    }
                } elseif (isset($_SESSION['adminidtwo']) && isset($_SESSION['unametwo'])) {
                    if (!empty($_SESSION['adminidtwo']) && !empty($_SESSION['unametwo'])) {
                        $id = $_SESSION['adminidtwo'];
                        $uname = $_SESSION['unametwo'];
                    }
                }

                $hashednewpass = password_hash($newpass, PASSWORD_DEFAULT);

                $updatepasssql = "UPDATE admin SET apassword='$hashednewpass' WHERE id='$id' AND auname='$uname' LIMIT 1";
                $updatepassstmt = $connect->query($updatepasssql);

                if ($updatepassstmt) {


                    $_SESSION['verified'] = null;

                    if (isset($_SESSION['adminid']) && isset($_SESSION['uname'])) {

                        if (!empty($_SESSION['adminid']) && !empty($_SESSION['uname'])) {
                            $_SESSION['successmessage'] = 'Password Changed Sucessfully';
                            redirect('adminSettings.php');
                        }
                    } elseif (isset($_SESSION['adminidtwo']) && isset($_SESSION['unametwo'])) {

                        if (!empty($_SESSION['adminidtwo']) && !empty($_SESSION['unametwo'])) {

                            $_SESSION['successmessage'] = 'Password Changed. You Can Now Login With Your New Password';
                            $_SESSION['adminidtwo'] = null;
                            $_SESSION['unametwo'] = null;
                            redirect('login.php');
                        }
                    }
                } else {

                    $_SESSION['errormessage'] = 'Something Went Wrong Please Try Again Later';
                    redirect('forgotpassword.php');
                }
            }
        
        } else {
            $_SESSION['errormessage'] = 'Inputed Password Doesn\'t Match!';
            redirect('forgotpassword.php');
        }
    } else {
        $_SESSION['errormessage'] = 'Please Input Something To all Fields';
        redirect('forgotpassword.php');
    }
}

?>

<html>



<script src="../js/script.js"></script>

</html>