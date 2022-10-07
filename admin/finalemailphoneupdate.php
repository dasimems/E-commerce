<?php

// admin index page


require_once('../includes/session.php');
require_once('../includes/db_connect.php');
require_once('../includes/functions.php');



checkAdminLogin();

//this checks if session is set

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
        $adminpassword = $details['apassword'];
        $adminposition = $details['aposition'];
        $adminfname = $details['afname'];
        $adminlname = $details['alname'];
        $adminmname = $details['amname'];
        $adminemail = $details['aemail'];
        $adminaddress = $details['aaddress'];
        $adminphoneNumber = $details['aphone_number'];
        $admincountry = $details['acountry'];
        $adminstate = $details['astate'];
        $admincity = $details['acity'];
        $adminpic = $details['apic'];
        $adminbio = $details['abio'];
        $adminphoneotp = $details['aphone_otp'];
        $adminemailotp = $details['aemail_otp'];

        if ($adminposition !== $_SESSION['position']) {
            $_SESSION['position'] = null;
            $_SESSION['uname'] = null;
            $_SESSION['adminid'] = null;
            $_SESSION['redirect'] = "redirect";
            redirect("loginagain.php");
        }
    } else {

        $_SESSION['errormessage'] = "Wrong login details. Thanks For Trying and Have a Nice Day.";
        redirect("login.php");
    }
}

if (isset($_POST['verify_phone_otp'])) {
    if (!empty($_POST['phone_otp'])) {

        $otp = $_POST['phone_otp'];
        $phonetoupdate = $_POST['new_phone_to_verify'];

        if ($otp === $adminphoneotp) {

            $updatephonesql = "UPDATE admin SET aphone_number=:newphone, aphone_otp='0' WHERE id='$adminid' AND auname='$adminusername' LIMIT 1";
            $updatephonestmt = $connect->prepare($updatephonesql);
            $updatephonestmt->bindValue(':newphone', $phonetoupdate);
            $updatenewphone = $updatephonestmt->execute();

            if ($updatenewphone) {
                $_SESSION['new_phone'] = null;
                $_SESSION['successmessage'] = 'Your Phone Number Has Been Updated';
                redirect('adminSettings.php');
            } else {
                $_SESSION['errormessage'] = "Something Went Wrong. Please Try Again!";
                redirect('adminSettings.php?update=updatephone&phone=update');
            }
        } else {
            $_SESSION['errormessage'] = "Invalid OTP";
            redirect('adminSettings.php?update=updatephone&phone=update');
        }
    } else {
        $_SESSION['errormessage'] = "Please Input The OTP Sent to You";
    }
}

if (isset($_POST['verify_email_otp'])) {
    if (!empty($_POST['email_otp'])) {

        $otp = $_POST['email_otp'];
        $emailtoupdate = $_POST['new_email_to_verify'];

        if ($otp === $adminemailotp) {

            $updateemailsql = "UPDATE admin SET aemail=:newemail, aemail_otp='0' WHERE id='$adminid' AND auname='$adminusername' LIMIT 1";
            $updateemailstmt = $connect->prepare($updateemailsql);
            $updateemailstmt->bindValue(':newemail', $emailtoupdate);
            $updatenewemail = $updateemailstmt->execute();

            if ($updatenewemail) {
                $_SESSION['new_email'] = null;
                $_SESSION['successmessage'] = 'Your Email Address Has Been Updated';
                redirect('adminSettings.php');
            } else {
                $_SESSION['errormessage'] = "Something Went Wrong. Please Try Again!";
                redirect('adminSettings.php?update=updateemail&email=update');
            }
        } else {
            $_SESSION['errormessage'] = "Invalid OTP";
            redirect('adminSettings.php?update=updateemail&email=update');
        }
    } else {
        $_SESSION['errormessage'] = "Please Input The OTP Sent to Your Email Address";
        redirect('adminSettings.php?update=updateemail&email=update');
    }
}

?>

<html>



<script src="../js/script.js"></script>

</html>