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

if (isset($_POST['newphone'])) {

    if (!empty($_POST['newphone'])) {

        $newphone = $_POST['newphone'];

        if ($newphone === $adminphoneNumber) {
            $_SESSION['errormessage'] = "Please Input a New Phone Number";
            redirect('adminSettings.php?update=phone');
        } else {

            $phonesql = "SELECT* FROM admin WHERE aphone_number=:phone LIMIT 1";
            $phonestmt = $connect->prepare($phonesql);
            $phonestmt->bindValue(':phone', $newphone);
            $phonestmt->execute();

            $checkphone = $phonestmt->rowcount();

            if ($checkphone === 0) {

                $phone_otp = mt_rand(100000, 999999);

                $new_sql =  "UPDATE admin SET aphone_otp='$phone_otp' WHERE id='$adminid' AND auname='$adminusername' LIMIT 1";

                $update_otp = $connect->query($new_sql);

                if ($update_otp) {

                    // this is where the sms function comes in.

                    $_SESSION['new_phone'] = $newphone;

                    $_SESSION['successmessage'] = 'An OTP Has Been Sent To Your Updated Phone Number';

                    redirect('adminSettings.php?update=updatephone&phone=update');
                } else {
                    $_SESSION['errormessage'] = "Something Went Wrong, Please Try Again. Thanks";
                    redirect('adminSettings.php?update=phone');
                }
            } else {
                $_SESSION['errormessage'] = "This Phone Number Already Exist In Our Database, Please Try Another One. Thanks";
                redirect('adminSettings.php?update=phone');
            }
        }
    } else {
        $_SESSION['errormessage'] = "Please Input a Phone Number";
        redirect('adminSettings.php?update=phone');
    }
}

if (isset($_POST['newemail'])) {

    if (!empty($_POST['newemail'])) {

        $newemail = $_POST['newemail'];

        if ($newemail === $adminemail) {
            $_SESSION['errormessage'] = "Please Input a New Email Address";
            redirect('adminSettings.php?update=email');
        } else {

            $emailsql = "SELECT* FROM admin WHERE aemail=:email LIMIT 1";
            $emailstmt = $connect->prepare($emailsql);
            $emailstmt->bindValue(':email', $newemail);
            $emailstmt->execute();

            $checkemail = $emailstmt->rowcount();

            if ($checkemail === 0) {

                $email_otp = mt_rand(100000, 999999);

                $new_sql =  "UPDATE admin SET aemail_otp='$email_otp' WHERE id='$adminid' AND auname='$adminusername' LIMIT 1";

                $update_otp = $connect->query($new_sql);

                if ($update_otp) {

                    // this is where the code to send the otp to the email comes in.

                    $_SESSION['new_email'] = $newemail;

                    $_SESSION['successmessage'] = 'An OTP Has Been Sent To Your Updated Email Address';

                    redirect('adminSettings.php?update=updateemail&email=update');
                } else {
                    $_SESSION['errormessage'] = "Something Went Wrong, Please Try Again. Thanks";
                    redirect('adminSettings.php?update=email');
                }
            } else {
                $_SESSION['errormessage'] = "This Email Address Already Exist In Our Database, Please Try Another One. Thanks";
                redirect('adminSettings.php?update=email');
            }
        }
    } else {
        $_SESSION['errormessage'] = "Please Input a Email Address";
        redirect('adminSettings.php?update=email');
    }
}


if (isset($_POST['newphone']) || isset($_POST['newemail'])) {
} else {

    redirect('adminSettings.php');
}



?>

<html>



<script src="../js/script.js"></script>

</html>