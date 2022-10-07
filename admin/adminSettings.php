<?php

require_once('../includes/session.php');
require_once('../includes/db_connect.php');
require_once('../includes/functions.php');

$_SESSION["last_page"] = $_SERVER['PHP_SELF'];



checkAdminLogin();

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
        $admindepartment = $details['adept'];
        
        $fetchsalarysql = "SELECT * FROM position WHERE ptitle='$adminposition' LIMIT 1";

        $fetchsalarystmt = $connect->query($fetchsalarysql);

        $adminsalary = $fetchsalarystmt->fetch()['psalary'];

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





?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Settings</title>
    <!--        bringing in all the required styles and scripts-->
    <link rel="stylesheet" href="../style/all.css">
    <script src="../js/all.js"></script>
    <link rel="stylesheet" href="../style/style.css">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>


<body onload="docfinish()">

    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->


    <div class="loader">

        <div class="loader-container">

            <div class="loader-anim-one"></div>

        </div>

    </div>

    <?php

    echo errormessage();
    echo sucessmessage();
    ?>


    <div class="update-block" <?php checkotp(); ?>>

        <div class="update-block-form">

            <?php

            if (isset($_GET['update']) && isset($_GET['phone'])) {
                if ($_GET['update'] === 'updatephone') {
                    if (isset($_SESSION['new_phone'])) {
                        if (!empty($_SESSION['new_phone'])) {

                            $new_phone = $_SESSION['new_phone'];


            ?>
                            <p>Please Enter The OTP Sent To Your Mobile Number</p>

                            <form action="finalemailphoneupdate.php" method="post">

                                <label for="phone_otp">OTP</label>
                                <input type="number" name="phone_otp" id="phone_otp" />
                                <input type="hidden" name="new_phone_to_verify" value="<?php echo $new_phone; ?>" />
                                <input type="submit" value="Verify" name="verify_phone_otp" />

                            </form>

                        <?php


                        }
                    }
                }
            }

            if (isset($_GET['update']) && isset($_GET['email'])) {
                if ($_GET['update'] === 'updateemail') {
                    if (isset($_SESSION['new_email'])) {
                        if (!empty($_SESSION['new_email'])) {

                            $new_email = $_SESSION['new_email'];


                        ?>
                            <p>Please Enter The OTP Sent To Your Email Address</p>

                            <form action="finalemailphoneupdate.php" method="post">

                                <label for="email_otp">OTP</label>
                                <input type="number" name="email_otp" id="email_otp" />
                                <input type="hidden" name="new_email_to_verify" value="<?php echo $new_email; ?>" />
                                <input type="submit" value="Verify" name="verify_email_otp" />

                            </form>

            <?php

                        }
                    }
                }
            }

            ?>

        </div>

    </div>

    <div class="back-alert">

        <div class="alert-one">

            <p>Are you sure you want to go back?</p>

            <button id="yes" onclick="back('adminSettings.php')"><i class="fas fa-check"></i></button><button id="no"><i class="fas fa-times"></i></button>

        </div>

    </div>

    <!--    the nav menu-->

    <nav class="nav-bar">

        <!--            bringing in the logo-->

        <div class="logo">
            <img src="../style/images/transparent%20ecommerce-logo.png">
        </div>

        <div class="links">

            <ul class="link-items">

                <li class="mobile-menu-btn" onclick="openMenu()"><a><i class="fas fa-bars"></i></a></li>

                <li class="link-item-content"><a href="logout.php"><i class="icon fas fa-user-times"></i> Logout</a></li>

            </ul>

        </div>

    </nav>
    <!--        the nav menu ends here-->

    <!--        the main content starts here-->

    <section class="main-content">

        <!--            the side bar starts here-->

        <div class="main-content-side-bar">

            <div class="main-content-side-bar-container">

                <div class="main-content-side-bar-container-links" title="Dashboard">

                    <a href="dashboard.php"><i class="fas fa-home"></i></a>

                </div>


                <div class="main-content-side-bar-container-links" title="Categories">

                    <a href="categories.php"><i class="fas fa-folder"></i></a>



                </div>

                <div class="main-content-side-bar-container-links" title="Sub-Categories">

                    <a href="sub_categories.php"><i class="fas fa-folder-open"></i></a>



                </div>



                <div class="main-content-side-bar-container-links" title="Admins">

                    <a href="<?php checkposition(); ?>"><i class="fas fa-users"></i></a>

                </div>

                <div class="main-content-side-bar-container-links" title="Products">

                    <a href="products.php"><i class="fas fa-dolly"></i></a>

                </div>


                <div class="main-content-side-bar-container-links" title="Account">

                    <i class="fas fa-cog"></i>

                    <div class="side-bar-link-hover">

                        <ul>

                            <li><a href="adminProfile.php"><i class="fas fa-user-circle"></i> &nbsp;View Profile</a></li>
                            <li><a href="adminSettings.php"><i class="fas fa-user-cog"></i> &nbsp;Account Settings</a></li>
                            <li><a href="locations.php"><i class="fas fa-map-marker-alt"></i> &nbsp;Location</a></li>
                            <li><a href="logout.php"><i class="fas fa-user-times"></i> &nbsp;Logout</a></li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>
        <!--            the side bar ends here-->

        <!--            the main content right side starts here-->

        <div class="main-right-side">

            <div class="profile-container">

                <div class="profile-container-left-side">

                    <div class="profile-img">

                        <img src="images/<?php echo $adminpic; ?>" alt="<?php echo $adminfname; ?>'s profile pic" />

                    </div>

                    <div class="admin-texts">

                        <h2 class="admin-name"><?php echo ucwords($adminfname) . " " . ucwords($adminmname) . " " . "." . ucwords(substr($adminlname, 0, 1)); ?></h2>
                        <p class="admin-position">Position : <?php echo ucwords($adminposition); ?></p>

                        <p class="admin-department">Department : <?php echo ucwords($admindepartment); ?></p>

                        <p class="admin-salary">Monthly Salary : <?php echo "&#8358;" . ucwords($adminsalary); ?></p>

                        <p class="admin-bio"><?php echo $adminbio; ?></p>
                        <p class="admin-phone"><a href="tel:<?php echo $adminphoneNumber; ?>"><?php echo $adminphoneNumber; ?></a></p>
                        <p class="admin-email"><a href="mailto:<?php echo $adminemail; ?>"><?php echo $adminemail; ?></a></p>

                    </div>

                </div>
                <div class="profile-container-right-side">

                    <div class="profile-security-form">

                        <div class="profile-form">

                            <form action="updatephoneemail.php" method="post">

                                <label for="phone">Phone Number</label>
                                <input type="tel" name="newphone" id="phone" value="<?php echo $adminphoneNumber; ?>" <?php disablesec("phone"); ?> />
                                <?php
                                if (!isset($_GET['update'])) {
                                ?>


                                    <div class="pro-btn" id="update-btn"><a href="adminSettings.php?update=phone"><span class="btn"><i class="fas fa-edit"></i>&nbsp;Update Phone Number</span></a></div>

                                    <?php
                                } else {

                                    if ($_GET['update'] !== "phone") {

                                    ?>

                                        <div class="pro-btn" id="update-btn"><a href="adminSettings.php?update=phone"><span class="btn"><i class="fas fa-edit"></i>&nbsp;Update Phone Number</span></a></div>

                                    <?php

                                    } else {

                                    ?>

                                        <div class="form-btns"><button type="button" class="back-btn"><i class="fas fa-arrow-left"></i>&nbsp;Back to Settings</button><button type="submit" class="update-btn" value="updatePhone"><i class="fas fa-check"></i>&nbsp;Update</button></div>

                                <?php
                                    }
                                }
                                ?>


                            </form>

                        </div>

                        <div class="profile-form">

                            <form action="updatephoneemail.php" method="post">

                                <label for="email">Email</label>
                                <input type="email" name="newemail" id="email" value="<?php echo $adminemail; ?>" <?php disablesec("email"); ?> />
                                <?php
                                if (!isset($_GET['update'])) {
                                ?>


                                    <div class="pro-btn" id="update-btn"><a href="adminSettings.php?update=email"><span class="btn"><i class="fas fa-edit"></i>&nbsp;Update Email</span></a></div>

                                    <?php
                                } else {

                                    if ($_GET['update'] !== "email") {

                                    ?>

                                        <div class="pro-btn" id="update-btn"><a href="adminSettings.php?update=email"><span class="btn"><i class="fas fa-edit"></i>&nbsp;Update Email</span></a></div>

                                    <?php

                                    } else {

                                    ?>

                                        <div class="form-btns"><button type="button" class="back-btn"><i class="fas fa-arrow-left"></i>&nbsp;Back to Settings</button><button type="submit" class="update-btn" value="updateEmail"><i class="fas fa-check"></i>&nbsp;Update</button></div>

                                <?php
                                    }
                                }
                                ?>

                            </form>

                        </div>

                        <div class="profile-form">

                            <form action="updatepassword.php" method="post">

                                <label for="oldpassword">Old Password</label>
                                <input type="password" name="oldpassword" id="oldpassword" placeholder="Input Old Password">

                                <label for="newpassword">New Password</label>
                                <input type="password" name="newpassword" id="newpassword" placeholder="Input New Password">

                                <label for="confirmnewpassword">Confirm Password</label>
                                <input type="password" name="confirmnewpassword" id="confirmnewpassword" placeholder="Input Password Again">

                                <div class="form-btns"><button type="submit" class="update-btn" value="updatepassword">Change Password</button></div>

                            </form>

                            <div class="forget-password-container">

                                <a href="forgotpassword.php">Forgot Password?</a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        <!--            the main content right side ends here-->

    </section>

    <!--        the main content ends here-->

    <!--        the footer starts here-->

    <div class="footer">

        <div class="footer-text">

            <p>Copyrights &copy; <?php echo date('Y'); ?> MEMS CART </p>

        </div>

    </div>

    <!--        the footer ends here-->

    <script src="../js/script.js"></script>


</body>

</html>