<?php

require_once('../includes/session.php');
require_once('../includes/db_connect.php');
require_once('../includes/functions.php');

$_SESSION["last_page"] = $_SERVER['PHP_SELF'];

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

if ((!isset($_GET['sms']) && !isset($_GET['mail'])) || (empty($_GET['sms']) && empty($_GET['mail']))) {
    redirect('admin.php');
}

checkAdminLogin();
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
    <title>Send

        <?php if (isset($_GET['sms'])) {
            if (!empty($_GET['sms'])) {
                echo "SMS";
            }
        } elseif (isset($_GET['mail'])) {
            if (!empty($_GET['mail'])) {
                echo "Mail";
            }
        } ?>

    </title>
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

            <div class="message-container">

                <?php

                if (isset($_GET['mail']) && !empty($_GET['mail'])) {

                    $sendingemail = $_GET['mail'];

                ?>

                    <div class="mail-container">

                        <h2>SEND EMAIL</h2>
                        <form action="send_mail_sms.php" method="post">

                            <div class="mail-form-input">

                                <label for="email">E-mail</label>

                                <input type="email" name="emails" id="email" placeholder="Please Input Email..." value="<?php echo $sendingemail; ?>">

                            </div>

                            <div class="mail-form-input">

                                <label for="mail-message">Message</label>

                                <textarea name="mailMessage" id="mail-message" placeholder="Enter Message..."></textarea>

                            </div>

                            <div class="mail-form-input">

                                <a href="admin.php">
                                    <span>
                                        <i class="fas fa-arrow-left"></i> Back to Admins</span>
                                </a>

                                <button type="submit">
                                    <i class="fas fa-check"></i> Send Mail</button>
                            </div>
                        </form>

                    </div>

                <?php

                }

                ?>

                <?php

                if (isset($_GET['sms']) && !empty($_GET['sms'])) {

                    $mobilenumber = $_GET['sms'];

                ?>

                    <div class="sms-container">

                        <h2>SEND MESSAGE</h2>
                        <form action="send_mail_sms.php" method="post">

                            <div class="mail-form-input">

                                <label for="tel">Mobile Number</label>

                                <input type="tel" name="phone_number" id="tel" placeholder="Input Phone Number..." value="<?php echo $mobilenumber; ?>">

                            </div>

                            <div class="mail-form-input">

                                <label for="mail-message">Message</label>

                                <textarea name="mailMessage" id="mail-message" placeholder="Enter Message..."></textarea>

                            </div>

                            <div class="mail-form-input">

                                <a href="admin.php">
                                    <span>
                                        <i class="fas fa-arrow-left"></i> Back to Admins</span>
                                </a>

                                <button type="submit" name="sendSms">
                                    <i class="fas fa-check"></i> Send SMS</button>
                            </div>
                        </form>


                    </div>

                <?php

                }

                ?>



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