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
            $_SESSION['errormessage'] = 'Please Login Again!';
            redirect("loginagain.php");
        }
    } else {

        $_SESSION['errormessage'] = "Wrong login details. Thanks For Trying and Have a Nice Day.";
        redirect("login.php");
    }
}

if (isset($_POST['updatefname']) && isset($_POST['updatemname']) && isset($_POST['updatelname']) && isset($_POST['updatecountry']) && isset($_POST['updatestate']) && isset($_POST['updatecity']) && isset($_POST['updateaddress']) && isset($_POST['updatebio'])) {

    if (!empty($_POST['updatefname']) && !empty($_POST['updatemname']) && !empty($_POST['updatelname']) && !empty($_POST['updatecountry']) && !empty($_POST['updatestate']) && !empty($_POST['updatecity']) && !empty($_POST['updateaddress'])) {

        $updatedfname = $_POST['updatefname'];
        $updatedmname = $_POST['updatemname'];
        $updatedlname = $_POST['updatelname'];
        $updatedaddress = $_POST['updateaddress'];
        $updatedcountry = $_POST['updatecountry'];
        $updatedstate = $_POST['updatestate'];
        $updatedcity = $_POST['updatecity'];
        $updatedbio = $_POST['updatebio'];
        $updatedimage = $_FILES['updatepic']['tmp_name'];

        if (!empty($updatedimage)) {
            $updatedimagename = $adminid . '.png';
            move_uploaded_file($updatedimage, "images/$updatedimagename");

            $updatesql = "UPDATE admin SET afname=:fname, alname=:lname, amname=:mname, aaddress=:address, acountry=:country, astate=:state, acity=:city, apic=:pic, abio=:bio WHERE id='$adminid' AND auname='$adminusername' LIMIT 1";

            $updatestmt = $connect->prepare($updatesql);
            $updatestmt->bindValue(':fname', $updatedfname);
            $updatestmt->bindValue(':mname', $updatedmname);
            $updatestmt->bindValue(':lname', $updatedlname);
            $updatestmt->bindValue(':address', $updatedaddress);
            $updatestmt->bindValue(':country', $updatedcountry);
            $updatestmt->bindValue(':state', $updatedstate);
            $updatestmt->bindValue(':city', $updatedcity);
            $updatestmt->bindValue(':pic', $adminid . '.png');
            $updatestmt->bindValue(':bio', $updatedbio);
            $updatestmt->execute();
        } else {
            $updatesql = "UPDATE admin SET afname=:fname, alname=:lname, amname=:mname, aaddress=:address, acountry=:country, astate=:state, acity=:city, abio=:bio WHERE id='$adminid' AND auname='$adminusername' LIMIT 1";

            $updatestmt = $connect->prepare($updatesql);
            $updatestmt->bindValue(':fname', $updatedfname);
            $updatestmt->bindValue(':mname', $updatedmname);
            $updatestmt->bindValue(':lname', $updatedlname);
            $updatestmt->bindValue(':address', $updatedaddress);
            $updatestmt->bindValue(':country', $updatedcountry);
            $updatestmt->bindValue(':state', $updatedstate);
            $updatestmt->bindValue(':city', $updatedcity);
            $updatestmt->bindValue(':bio', $updatedbio);
            $updatestmt->execute();
        }

        if ($updatestmt->execute()) {
            $_SESSION['successmessage'] = "Profile Info Updated Successfully";
            redirect("adminProfile.php");
        } else {
            $_SESSION['errormessage'] = "Error Updating Profile. Please Try Again!";
            redirect("adminProfile.php?id=$adminid&username=$adminusername&update=true");
        }
    } else {
        $_SESSION['errormessage'] = "Please Fill all Required Filled";
        redirect("adminProfile.php?id=$adminid&username=$adminusername&update=true");
    }
} else {
    redirect("adminProfile.php");
}

?>

<html>



<script src="../js/script.js"></script>

</html>