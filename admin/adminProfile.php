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
    <title>Profile</title>
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


    <div class="back-alert">

        <div class="alert-one">

            <p>Are you sure you want to go back?</p>

            <button id="yes" onclick="back('adminProfile.php')"><i class="fas fa-check"></i></button><button id="no"><i class="fas fa-times"></i></button>

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

                    <!--                        creating the update button-->

                    <?php

                    if (!isset($_GET['update'])) {

                        echo "
                    
                        <div class=\"profile-btn\">
                        
                            <div class=\"pro-btn\" id=\"update-btn\"><a href=\"adminProfile.php?id={$adminid}&username={$adminusername}&update=true\"><span class=\"btn\"><i class=\"fas fa-edit\"></i>&nbsp;Update Profile</span></a></div>
                            
                        </div>
                        
                        ";
                    }

                    ?>

                    <!--                        creating the update form-->

                    <div class="profile-update-form">

                        <div class="profile-form">

                            <form action="updateprofile.php" enctype="multipart/form-data" method="post">

                                <label for="updatefname">First Name</label>
                                <input type="text" name="updatefname" id="updatefname" value="<?php echo $adminfname; ?>" <?php disableForm(); ?> />

                                <label for="updatemname">Middle Name</label>
                                <input type="text" name="updatemname" id="updatemname" value="<?php echo $adminmname; ?>" <?php disableForm(); ?> />

                                <label for="updatelname">Last Name</label>
                                <input type="text" name="updatelname" id="updatelname" value="<?php echo $adminlname; ?>" <?php disableForm(); ?> />

                                <label for="updatecountry">Country</label>

                                <select name="updatecountry" id="updatecountry" <?php disableForm(); ?>>

                                    <option value="<?php echo $admincountry; ?>"><?php echo ucwords($admincountry); ?></option>

                                    <?php
                                    $fetchcountrysql = "SELECT * FROM country ORDER BY coname ASC";
                                    $fetchcountrystmt = $connect->query($fetchcountrysql);

                                    while ($fetchcountry =  $fetchcountrystmt->fetch()) {
                                        $fetchedcountry = $fetchcountry['coname'];


                                    ?>
                                        <option value="<?php if($admincountry === $fetchedcountry){echo "---";}else{ echo $fetchedcountry; } ?>"><?php echo ucwords($fetchedcountry); ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>

                                <label for="updatestate">State</label>
                                <input type="text" name="updatestate" id="updatestate" value="<?php echo $adminstate; ?>" <?php disableForm(); ?> />

                                <label for="updatecity">City</label>
                                <input type="text" name="updatecity" id="updatecity" value="<?php echo $admincity; ?>" <?php disableForm(); ?> />

                                <label for="updateaddress">Address</label>
                                <input type="text" name="updateaddress" id="updateaddress" value="<?php echo $adminaddress; ?>" <?php disableForm(); ?> />


                                <input type="<?php echo isset($_GET['update']) ? "file" : "hidden"; ?>" name="updatepic" id="updatepic" accept="image/x-png, image/jpeg" />

                                <label for="updatebio">Bio</label>
                                <textarea name="updatebio" id="updatebio" <?php disableForm(); ?>><?php echo $adminbio; ?></textarea>

                                <?php

                                if (isset($_GET['update'])) {
                                    echo '<div class="form-btns"><button type="button" class="back-btn"><i class="fas fa-arrow-left"></i>&nbsp;Back to Profile</button><button type="submit" class="update-btn" value="updateInputs"><i class="fas fa-check"></i>&nbsp;Update</button></div>';
                                }

                                ?>

                            </form>
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