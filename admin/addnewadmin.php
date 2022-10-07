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
            exit();
        }
    } else {
        
        $_SESSION['position'] = null;
        $_SESSION['uname'] = null;
        $_SESSION['adminid'] = null;
        $_SESSION['errormessage'] = 'Wrong login details. Thanks For Trying and Have a Nice Day!';
        redirect("login.php");
        exit();
    }
}


if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['passwordtwo']) && isset($_POST['firstname']) && isset($_POST['middlename']) && isset($_POST['lastname']) && isset($_POST['phoneNumber']) && isset($_POST['email']) && isset($_POST['address']) && isset($_POST['country']) && isset($_POST['state']) && isset($_POST['city']) && isset($_POST['position'])) {

    $dateadded = date('l-F-Y / h-i-a');



    if (!empty($_POST['position'])) {

        if (strlen($_POST['position']) > 30) {
            $_SESSION['errormessage'] = 'Position Must Not Be More Than 30 Characters';
            redirect('admin.php?title=addnewcat');
        } else {
            $fetchpositionsql = "SELECT * FROM position WHERE ptitle='{$_POST['position']}'";
            $fetchpositionstmt = $connect->query($fetchpositionsql);
            $fetchposition = $fetchpositionstmt->fetch();


            $department = $fetchposition['pdept'];

            $_SESSION['newposition'] = $_POST['position'];
            $position = $_POST['position'];
        }
    } else {
        $_SESSION['errormessage'] = 'Position Field Can\'t Be Empty';
        redirect('admin.php?title=addnewcat');
    }

    if (!empty($_POST['city'])) {

        if (strlen($_POST['city']) > 300) {
            $_SESSION['errormessage'] = 'City Must Not Be More Than 300 Characters';
            redirect('admin.php?title=addnewcat');
        } else {
            $_SESSION['newcity'] = $_POST['city'];
            $city = $_POST['city'];
        }
    } else {
        $_SESSION['errormessage'] = 'City Field Can\'t Be Empty';
        redirect('admin.php?title=addnewcat');
    }

    if (!empty($_POST['state'])) {

        if (strlen($_POST['state']) > 200) {
            $_SESSION['errormessage'] = 'State Must Not Be More Than 200 Characters';
            redirect('admin.php?title=addnewcat');
        } else {
            $_SESSION['newstate'] = $_POST['state'];
            $state = $_POST['state'];
        }
    } else {
        $_SESSION['errormessage'] = 'State Field Can\'t Be Empty';
        redirect('admin.php?title=addnewcat');
    }

    if (!empty($_POST['country'])) {

        if (strlen($_POST['country']) > 60) {
            $_SESSION['errormessage'] = 'Country Must Not Be More Than 60 Characters';
            redirect('admin.php?title=addnewcat');
        } else {

            $sentcountry = $_POST['country'];

            $fetchcountrysql = "SELECT * FROM country WHERE coname='$sentcountry'";
            $fetchcountrystmt = $connect->query($fetchcountrysql);
            $fetchcountryrowcount = $fetchcountrystmt->rowcount();

            if ($fetchcountryrowcount < 1) {
                $_SESSION['errormessage'] = 'We are Not Available at The Inputed Country at This Moment. Please Check And Try Again Later';
                redirect('admin.php?title=addnewcat');
            } else {
                $_SESSION['newcountry'] = $sentcountry;
                $country = $_POST['country'];
            }
        }
    } else {
        $_SESSION['errormessage'] = 'Country Field Can\'t Be Empty';
        redirect('admin.php?title=addnewcat');
    }

    if (!empty($_POST['address'])) {

        if (strlen($_POST['address']) > 200) {
            $_SESSION['errormessage'] = 'Address Must Not Be More Than 200 Characters';
            redirect('admin.php?title=addnewcat');
        } else {
            $_SESSION['newaddress'] = $_POST['address'];
            $address = $_POST['address'];
        }
    } else {
        $_SESSION['errormessage'] = 'Address Field Can\'t Be Empty';
        redirect('admin.php?title=addnewcat');
    }

    if (!empty($_POST['email'])) {

        if (strlen($_POST['email']) > 50) {
            $_SESSION['errormessage'] = 'Email Must Not Be More Than 50 Characters';
            redirect('admin.php?title=addnewcat');
        } else {
            $verifemailsql = "SELECT * FROM admin WHERE aemail=:email LIMIT 1";
            $verifemailstmt = $connect->prepare($verifemailsql);
            $verifemailstmt->bindValue(':email', $_POST['email']);
            $verifemailstmt->execute();
            $verififemailisavailable = $verifemailstmt->rowCount();

            if ($verififemailisavailable < 1) {
                $_SESSION['newemail'] = $_POST['email'];
                $email = $_POST['email'];
            } else {
                $_SESSION['errormessage'] = 'Email Already Exist Please Try Another One';
                redirect('admin.php?title=addnewcat');
            }
        }
    } else {
        $_SESSION['errormessage'] = 'Email Field Can\'t Be Empty';
        redirect('admin.php?title=addnewcat');
    }

    if (!empty($_POST['phoneNumber'])) {

        if (strlen($_POST['phoneNumber']) > 20) {
            $_SESSION['errormessage'] = 'Phone Number Must Not Be More Than 20 Characters';
            redirect('admin.php?title=addnewcat');
        } else {
            $verifphoneNumbersql = "SELECT * FROM admin WHERE aphone_number=:phoneNumber LIMIT 1";
            $verifphoneNumberstmt = $connect->prepare($verifphoneNumbersql);
            $verifphoneNumberstmt->bindValue(':phoneNumber', $_POST['phoneNumber']);
            $verifphoneNumberstmt->execute();
            $verififphoneNumberisavailable = $verifphoneNumberstmt->rowCount();

            if ($verififphoneNumberisavailable < 1) {
                $_SESSION['newphoneNumber'] = $_POST['phoneNumber'];
                $phoneNumber = $_POST['phoneNumber'];
            } else {
                $_SESSION['errormessage'] = 'Phone Number Already Exist Please Try Another One';
                redirect('admin.php?title=addnewcat');
            }
        }
    } else {
        $_SESSION['errormessage'] = 'Phone Number Field Can\'t Be Empty';
        redirect('admin.php?title=addnewcat');
    }

    if (!empty($_POST['lastname'])) {

        if (strlen($_POST['lastname']) > 20) {
            $_SESSION['errormessage'] = 'Last Name Must Not Be More Than 20 Characters';
            redirect('admin.php?title=addnewcat');
        } else {
            $_SESSION['newlastname'] = $_POST['lastname'];
            $lastname = $_POST['lastname'];
        }
    } else {
        $_SESSION['errormessage'] = 'Last Name Field Can\'t Be Empty';
        redirect('admin.php?title=addnewcat');
    }

    if (!empty($_POST['middlename'])) {

        if (strlen($_POST['middlename']) > 20) {
            $_SESSION['errormessage'] = 'Middle Name Must Not Be More Than 20 Characters';
            redirect('admin.php?title=addnewcat');
        } else {
            $_SESSION['newmiddlename'] = $_POST['middlename'];
            $middlename = $_POST['middlename'];
        }
    } else {
        $_SESSION['errormessage'] = 'Middle Name Field Can\'t Be Empty';
        redirect('admin.php?title=addnewcat');
    }

    if (!empty($_POST['firstname'])) {

        if (strlen($_POST['firstname']) > 20) {
            $_SESSION['errormessage'] = 'First Name Must Not Be More Than 20 Characters';
            redirect('admin.php?title=addnewcat');
        } else {
            $_SESSION['newfirstname'] = $_POST['firstname'];
            $firstname = $_POST['firstname'];
        }
    } else {
        $_SESSION['errormessage'] = 'First Name Field Can\'t Be Empty';
        redirect('admin.php?title=addnewcat');
    }

    if (!empty($_POST['password'])) {

        if (strlen($_POST['password']) < 8) {
            $_SESSION['errormessage'] = 'Password Must Not Be Less Than 8 Characters';
            redirect('admin.php?title=addnewcat');
        } else {
            $password = $_POST['password'];
            
            if (!empty($_POST['passwordtwo'])) {

                if ($password !== $_POST['passwordtwo']) {
                    $_SESSION['errormessage'] = 'Password Doesn\'t Match';
                    redirect('admin.php?title=addnewcat');
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                }
            } else {
                $_SESSION['errormessage'] = 'Confirm Password Field Can\'t Be Empty';
                redirect('admin.php?title=addnewcat');
            }
        }
    } else {
        $_SESSION['errormessage'] = 'Password Field Can\'t Be Empty';
        redirect('admin.php?title=addnewcat');
    }

    if (!empty($_POST['uname'])) {

        if (strlen($_POST['uname']) > 10) {
            $_SESSION['errormessage'] = 'Username Must Not Be More Than 10 Characters';
            redirect('admin.php?title=addnewcat');
        } else {

            $verifunamesql = "SELECT * FROM admin WHERE auname=:uname LIMIT 1";
            $verifunamestmt = $connect->prepare($verifunamesql);
            $verifunamestmt->bindValue(':uname', $_POST['uname']);
            $verifunamestmt->execute();
            $verififunameisavailable = $verifunamestmt->rowCount();

            if ($verififunameisavailable < 1) {
                $_SESSION['newuname'] = $_POST['uname'];
                $username = $_POST['uname'];
            } else {
                $_SESSION['errormessage'] = 'Username Already Exist Please Try Another One';
                redirect('admin.php?title=addnewcat');
            }
        }
    } else {
        $_SESSION['errormessage'] = 'Username Field Can\'t Be Empty';
        redirect('admin.php?title=addnewcat');
    }

    if (isset($username) && isset($hashed_password) && isset($firstname) && isset($middlename) && isset($lastname) && isset($phoneNumber) && isset($email) && isset($address) && isset($country) && isset($state) && isset($city) && isset($position)) {

        if (!empty($username) && !empty($hashed_password) && !empty($firstname) && !empty($middlename) && !empty($lastname) && !empty($phoneNumber) && !empty($email) && !empty($address) && !empty($country) && !empty($state) && !empty($city) && !empty($position)) {


            $insetadminsql = "INSERT INTO admin (auname, apassword, afname, alname, amname, aemail, aaddress, aphone_number, acountry, astate, acity, aposition, adept, adate_added) VALUES (:uname, :apassword, :fname, :lname, :mname, :email, :address, :phonenum, :country, :state, :city, :aposition, :dept, :dateadded)";

            $insertadminstmt = $connect->prepare($insetadminsql);
            $insertadminstmt->bindValue(':uname', $username);
            $insertadminstmt->bindValue(':apassword', $hashed_password);
            $insertadminstmt->bindValue(':fname', $firstname);
            $insertadminstmt->bindValue(':lname', $lastname);
            $insertadminstmt->bindValue(':mname', $middlename);
            $insertadminstmt->bindValue(':email', $email);
            $insertadminstmt->bindValue(':address', $address);
            $insertadminstmt->bindValue(':phonenum', $phoneNumber);
            $insertadminstmt->bindValue(':country', $country);
            $insertadminstmt->bindValue(':state', $state);
            $insertadminstmt->bindValue(':city', $city);
            $insertadminstmt->bindValue(':aposition', $position);
            $insertadminstmt->bindValue(':dept', $department);
            $insertadminstmt->bindValue(':dateadded', $dateadded);

            $insertadminexec = $insertadminstmt->execute();

            if ($insertadminexec) {

                $_SESSION['newuname'] = null;
                $_SESSION['newfirstname'] = null;
                $_SESSION['newmiddlename'] = null;
                $_SESSION['newlastname'] = null;
                $_SESSION['newphoneNumber'] = null;
                $_SESSION['newemail'] = null;
                $_SESSION['newaddress'] = null;
                $_SESSION['newcountry'] = null;
                $_SESSION['newstate'] = null;
                $_SESSION['newcity'] = null;
                $_SESSION['newposition'] = null;

                $_SESSION['successmessage'] = 'Admin Added Succesfully';
                redirect('admin.php');
            } else {
                $_SESSION['errormessage'] = 'Something Went Wrong. Please Try Again';
                redirect('admin.php?title=addnewcat');
            }
        }
    }
} else {
    redirect('admin.php');
}


//print_r($_POST);


?>

<html>



<script src="../js/script.js"></script>

</html>