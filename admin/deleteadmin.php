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

        if($adminid === $_GET['id'] && $adminusername === $_GET['title']) {

            $_SESSION['errormessage'] = "Unknown Request";
            
            redirect('admin.php');

        }else{

            $deletedadminid = $_GET['id'];
            $deletedadminuname = $_GET['title'];

            $checkifavailablesql = "SELECT * FROM admin WHERE id='$deletedadminid' AND auname='$deletedadminuname' LIMIT 1";
            $checkifavailablestmt = $connect->query($checkifavailablesql);
            $checkifavailableexec = $checkifavailablestmt->rowcount();

            if ($checkifavailableexec > 0) {

                $checkifavailableposition = $checkifavailablestmt->fetch()['aposition'];

                if($checkifavailableposition === 'CEO'){

                    
                    $_SESSION['errormessage'] = "Unknown Request";
                    
                    redirect('admin.php');

                }else{

                    $uploadedadminimage = $checkifavailablestmt->fetch()['apic'];

                    $deletesql = "DELETE FROM admin WHERE id='$deletedadminid' AND auname='$deletedadminuname'";
                    $deletestmt = $connect->query($deletesql);

                    if ($deletestmt) {

                        if($uploadedadminimage !== 'avatar.png'){

                            unlink('images/'.$uploadedadminimage);

                        }
                        
                        $_SESSION['successmessage'] = 'Admin Data Deleted Successfully';
                        redirect('admin.php');
                    } else {
                        $_SESSION['errormessage'] = 'Something isn\'t right.';
                        redirect('admin.php');
                    }

                }

            }else{
                $_SESSION['errormessage'] = 'Admin Data Not Found!';
                redirect('admin.php');
            }

        }
    } else {
        redirect('admin.php');
    }
} else {
    redirect('admin.php');
}

?>

<html>



<script src="../js/script.js"></script>

</html>