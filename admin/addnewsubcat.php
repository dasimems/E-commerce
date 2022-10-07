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

if (isset($_POST['cattitle']) && isset($_POST['subcattitle'])) {

    if (!empty($_POST['subcattitle']) && !empty($_POST['cattitle'])) {

        if (strlen($_POST['subcattitle']) > 49) {

            $_SESSION['errormessage'] = "Please Input Characters Less Than 50!";
            redirect('sub_categories.php?title=addnewcat');
        } elseif ($_POST['cattitle'] === "none") {

            $_SESSION['errormessage'] = "Please Make Sure Your Category List Isn't Empty";
            redirect('categories.php');
        } else {

            $subcattitle = $_POST['subcattitle'];
            $cattitle = $_POST['cattitle'];
            $dateadded = date('l-F-Y');
            $timeadded = date('h-i-a');

            $catchecksql = "SELECT * FROM sub_category WHERE subcattitle=:cattitle LIMIT 1";
            $catcheckstmt = $connect->prepare($catchecksql);
            $catcheckstmt->bindValue(':cattitle', $subcattitle);
            $catcheckexecute = $catcheckstmt->execute();
            $catcheckavailable = $catcheckstmt->rowcount();

            if ($catcheckavailable < 1) {



                $catsql = "INSERT INTO sub_category (subcattitle, category, subcaadded_by, subcadate_added, subcatime_added) VALUES (:title,  '$cattitle', '$adminusername', '$dateadded', '$timeadded')";
                $catstmt = $connect->prepare($catsql);
                $catstmt->bindValue(':title', $subcattitle);
                $catexecute = $catstmt->execute();

                if ($catexecute) {
                    $_SESSION['successmessage'] = "Sub-Category Sucessfully Added";
                    redirect('sub_categories.php');
                } else {
                    $_SESSION['errormessage'] = "Something Went Wrong, Please Try Again Later. Thanks!";
                    redirect('sub_categories.php?title=addnewcat');
                }
            } else {
                $_SESSION['errormessage'] = ucwords($subcattitle) . " is Already Included In The Database. Please Try Another Name. Thanks";
                redirect('sub_categories.php?title=addnewcat');
            }
        }
    } else {
        $_SESSION['errormessage'] = "Please Input Something!";
        redirect('sub_categories.php?title=addnewcat');
    }
} else {
    redirect('sub_categories.php');
}

//print_r($_POST);


?>

<html>



<script src="../js/script.js"></script>

</html>