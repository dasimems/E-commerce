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

if(isset($_POST['cattitle']) && isset($_POST['updatecatid']) && !empty($_POST['updatecatid'])){

    $catid = $_POST['updatecatid'];

    $fetchcategorysql = "SELECT catitle FROM category WHERE id=:catid LIMIT 1";
    $fetchcategorystmt = $connect->prepare($fetchcategorysql);
    $fetchcategorystmt->bindValue(':catid', $catid);
    $fetchcategorystmt->execute();
    $fetchcategoryrowcount = $fetchcategorystmt->rowCount();

    if($fetchcategoryrowcount < 1){
        $_SESSION['errormessage'] = "Data Not Found";
        redirect('categories.php');
    }else{

        $fetchcategory =  $fetchcategorystmt->fetch();
        $title = $fetchcategory['catitle'];

        if(!empty($_POST['cattitle'])){
            $updatedtitle = $_POST['cattitle'];
            $updatecategorysql = "UPDATE category SET catitle=:title WHERE id=:catid LIMIT 1";
            $updatecategorystmt = $connect->prepare($updatecategorysql);
            $updatecategorystmt->bindValue(':title', $updatedtitle);
            $updatecategorystmt->bindValue(':catid', $catid);
            $updatecategory = $updatecategorystmt->execute();

            if($updatecategory){
                $_SESSION['successmessage'] = ucwords($title)." Category Updated";
                redirect('categories.php');
            }else{
                $_SESSION['errormessage'] = "something Went Wrong. Please Try Again!";
                redirect("categories.php?id=$catid&name=$title&title=addnewcat");

            }
        }else{
            $_SESSION['errormessage'] = "Category Field Can't Be Empty";
            redirect("categories.php?id=$catid&name=$title&title=addnewcat");
        }

    }

}else{
    redirect('categories.php');
}
//print_r($_POST);


?>

<html>



<script src="../js/script.js"></script>

</html>