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

if (isset($_GET['id']) && isset($_GET['title'])) {

    if (!empty($_GET['id']) && !empty($_GET['title'])) {

        $categoryid = $_GET['id'];
        $categorytitle = $_GET['title'];

        $checkifavailablesql = "SELECT * FROM category WHERE id='$categoryid' AND catitle='$categorytitle' LIMIT 1";
        $checkifavailablestmt = $connect->query($checkifavailablesql);
        $checkifavailableexec = $checkifavailablestmt->rowcount();

        if ($checkifavailableexec !== 0) {

            $deletesql = "DELETE FROM category WHERE id='$categoryid' AND catitle='$categorytitle'";
            $deletestmt = $connect->query($deletesql);

            if ($deletestmt) {
                $_SESSION['successmessage'] = 'Category Deleted Successfully';
                redirect('categories.php');
            } else {
                $_SESSION['errormessage'] = 'Something isn\'t right.';
                redirect('categories.php');
            }
        } else {
            $_SESSION['errormessage'] = 'Category Not Found!';
            redirect('categories.php');
        }
    } else {
        redirect('categories.php');
    }
} else {
    redirect('categories.php');
}

?>

<html>



<script src="../js/script.js"></script>

</html>