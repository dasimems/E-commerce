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

if (isset($_SESSION['position'])) {

    $position = $_SESSION['position'];

    if (($position !== 'manager') && ($position !== 'CEO')) {
        redirect('dashboard.php');
    }
} else {
    $_SESSION['errormessage'] = "Please Log In Again";
    redirect('login.php');
}

if (isset($_POST['newposition'])) {

    $sentadminid = $_POST['fetchedadminid'];
    $sentadminuname = $_POST['fetchedadminuname'];
    $getadminprofilesql = "SELECT * FROM admin WHERE id=:id AND auname=:username LIMIT 1";
    $getadminprofilestmt = $connect->prepare($getadminprofilesql);
    $getadminprofilestmt->bindValue(':username', $sentadminuname);
    $getadminprofilestmt->bindValue(':id', $sentadminid);
    $getadminprofilestmt->execute();
    $getadminprofilerowcount = $getadminprofilestmt->rowcount();

    if ($getadminprofilerowcount < 1) {
        $_SESSION['errormessage'] = 'Admin Record Not Found';
        redirect('admin.php');
    } else {
        $getadminprofile = $getadminprofilestmt->fetch();

        $fetchedadminid = $getadminprofile['id'];
        $fetchedadminusername = $getadminprofile['auname'];
        $fetchedadminposition = $getadminprofile['aposition'];
        $fetchedadminfname = $getadminprofile['afname'];
    }

    if (!empty($_POST['newposition'])) {
        $updatedposition = $_POST['newposition'];
        if ($updatedposition === $fetchedadminposition) {
            $_SESSION['errormessage'] = "Admin is Already In That Position";
            redirect("viewprofile.php?username=$fetchedadminusername&name=$fetchedadminfname&update=position");
        } else {
            $updatepositionsql = "UPDATE admin SET aposition=:updatedposition WHERE id=:sentadminid AND auname=:sentadminuname LIMIT 1";
            $updatepositionstmt = $connect->prepare($updatepositionsql);
            $updatepositionstmt->bindValue(':updatedposition', $updatedposition);
            $updatepositionstmt->bindValue(':sentadminid', $sentadminid);
            $updatepositionstmt->bindValue(':sentadminuname', $sentadminuname);
            $updatedpositionexec = $updatepositionstmt->execute();
            if ($updatedpositionexec) {
                $_SESSION['successmessage'] = "Admin Position Updated";
                redirect("viewprofile.php?username=$fetchedadminusername&name=$fetchedadminfname");
            } else {

                $_SESSION['errormessage'] = "Something Went Wrong Please Try Again!";
                redirect("viewprofile.php?username=$fetchedadminusername&name=$fetchedadminfname&update=position");
            }
        }
    } else {

        $_SESSION['errormessage'] = "Please Admin Position Can't Be Empty";
        redirect("viewprofile.php?username=$fetchedadminusername&name=$fetchedadminfname&update=position");
    }
} else {
    redirect('admin.php');
}



?>

<html>



<script src="../js/script.js"></script>

</html>