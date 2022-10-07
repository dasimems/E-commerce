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

if (isset($_GET['username']) && isset($_GET['name'])) {
    if (!empty($_GET['username']) && !empty($_GET['name'])) {
        $username = $_GET['username'];
        $firstname = $_GET['name'];

        $getadminprofilesql = "SELECT * FROM admin WHERE auname=:username AND afname=:firstname LIMIT 1";
        $getadminprofilestmt = $connect->prepare($getadminprofilesql);
        $getadminprofilestmt->bindValue(':username', $username);
        $getadminprofilestmt->bindValue(':firstname', $firstname);
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
            $fetchedadminlname = $getadminprofile['alname'];
            $fetchedadminmname = $getadminprofile['amname'];
            $fetchedadminemail = $getadminprofile['aemail'];
            $fetchedadminaddress = $getadminprofile['aaddress'];
            $fetchedadminphoneNumber = $getadminprofile['aphone_number'];
            $fetchedadmincountry = $getadminprofile['acountry'];
            $fetchedadminstate = $getadminprofile['astate'];
            $fetchedadmincity = $getadminprofile['acity'];
            $fetchedadminpic = $getadminprofile['apic'];
            $fetchedadminbio = $getadminprofile['abio'];
            $fetchedadmindepartment = $getadminprofile['adept'];
            $fetchedadmindateadded = $getadminprofile['adate_added'];
            $fetchedadminlastseen = $getadminprofile['adate_last_login'];
            $fetchedadminstatus = $getadminprofile['astatus'];

            if($adminfname === $fetchedadminfname && $adminusername === $fetchedadminusername){
                redirect('adminProfile.php');
            }

            if($adminposition !== "CEO" && $fetchedadminposition === 'CEO'){
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

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo ucwords($fetchedadminfname) . "'s" . " profile"; ?>
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


            <div class="category-body">

                <div class="admin-profile">

                    <div class="admin-profile-image-barcode">

                        <div class="admin-profile-image" id="<?php echo $fetchedadminstatus; ?>">
                            <img src="images/<?php echo $fetchedadminpic; ?>" alt="<?php echo $fetchedadminusername . " profile pic"; ?>">
                        </div>

                        <div class="admin-profile-image-barcode-text">
                            <p><span>Date Added :</span><?php echo $fetchedadmindateadded; ?></p>
                            <p><span>Last Seen :</span><?php echo $fetchedadminlastseen; ?></p>
                        </div>

                    </div>

                    <div class="admin-profile-details">



                        <?php

                        if (isset($_GET['update']) && $_GET['update'] === 'position') {

                        ?>

                            <div class="update-position">

                                <h2>Update Admin Position</h2>

                                <div class="update-position-form">

                                    <form action="updateadminposition.php" method="post">

                                        <label for="updatedposition">Please Select Position</label>
                                        <select name="newposition" id="updatedposition">

                                            <option value="">---</option>
                                            <?php

                                            $fetchpositionsql = "SELECT * FROM position ORDER BY ptitle";

                                            $fetchpositionstmt = $connect->query($fetchpositionsql);

                                            while ($fetchposition = $fetchpositionstmt->fetch()) {
                                                $positiontitle = $fetchposition['ptitle'];

                                            ?>
                                                <option value="<?php echo ($positiontitle === 'CEO')? "" :$positiontitle; ?>"><?php echo ($positiontitle === 'CEO')? "" :ucwords($positiontitle); ?></option>

                                            <?php
                                            }



                                            ?>
                                        </select>
                                        <input type="hidden" name="fetchedadminid" value="<?php echo $fetchedadminid; ?>">
                                        <input type="hidden" name="fetchedadminuname" value="<?php echo $fetchedadminusername; ?>">


                                        <a href="viewprofile.php?username=<?php echo $username; ?>&name=<?php echo $firstname; ?>"><button type="button" class="back-btn">
                                                <i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Back to Admin Profile</button></a>
                                        <button type=" submit" name="updateposition" class="update-btn">
                                            <i class="fas fa-save"></i>&nbsp;&nbsp;Update Position</button>

                                    </form>

                                </div>

                            </div>

                        <?php

                        } else {
                        ?>

                            <div class="admin-details">

                                <div class="admin-details-container">
                                    <p><span>Full Name : </span><?php echo !empty($fetchedadminfname || $fetchedadminmname || $fetchedadminlname) ? ucwords($fetchedadminfname) . " " . ucwords($fetchedadminmname) . " " . ucwords($fetchedadminlname) : 'null'; ?></p>


                                </div>

                                <div class="admin-details-container">

                                    <p><span>Email : </span><?php echo !empty($fetchedadminemail) ? $fetchedadminemail : 'null'; ?></p>
                                    <?php

                                    if (!empty($fetchedadminemail)) {

                                    ?>


                                        <a href="sendmessage.php?mail=<?php echo $fetchedadminemail; ?>"><span><i class="fas fa-envelope"></i>&nbsp;&nbsp;Send Mail</span></a>
                                    <?php
                                    }

                                    ?>


                                </div>

                                <div class="admin-details-container">

                                    <p><span>Phone Number : </span><?php echo !empty($fetchedadminphoneNumber) ? $fetchedadminphoneNumber : 'null'; ?></p>


                                    <?php

                                    if (!empty($fetchedadminphoneNumber)) {

                                    ?>

                                        <a href="sendmessage.php?sms=<?php echo $fetchedadminphoneNumber; ?>"><span><i class="fas fa-mobile-alt"></i>&nbsp;&nbsp;Send Message</span></a>

                                    <?php
                                    }

                                    ?>

                                </div>

                                <div class="admin-details-container">

                                    <p><span>Address : </span><?php echo !empty($fetchedadminaddress) ? ucwords($fetchedadminaddress) . " " . ucwords($fetchedadmincity) . " " . ucwords($fetchedadminstate) . " " . ucwords($fetchedadmincountry) : 'null'; ?></p>

                                    <?php if (!empty($fetchedadminaddress)) {

                                    ?>
                                        <a href="viewaddress.php?id=<?php echo $fetchedadminid; ?>&username=<?php echo $fetchedadminusername; ?>"><span><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;View Address</span></a>

                                    <?php
                                    }
                                    ?>



                                </div>

                                <div class="admin-details-container">
                                    <p><span>Position : </span><?php echo !empty($fetchedadminposition) ? ucwords($fetchedadminposition) : 'null'; ?></p>

                                    <?php

                                    if (!empty($fetchedadminposition)) {


                                        $fetchsalarysql = "SELECT * FROM position WHERE ptitle='$fetchedadminposition' LIMIT 1";

                                        $fetchsalarystmt = $connect->query($fetchsalarysql);

                                        $fetchedsalary = $fetchsalarystmt->fetch()['psalary'];
                                    ?>

                                        <a href="viewprofile.php?username=<?php echo $username; ?>&name=<?php echo $firstname; ?>&update=position"><span><i class="fas fa-edit"></i>&nbsp;&nbsp;Update Position</span></a>

                                        <p class="currency"><span>Monthly Salary: </span><?php echo "&#8358;" . $fetchedsalary; ?></p>

                                    <?php

                                    }

                                    ?>
                                </div>

                                <div class="admin-details-container">
                                    <p><span>Department : </span><?php echo !empty($fetchedadmindepartment) ? ucwords($fetchedadmindepartment) : 'null'; ?></p>

                                </div>

                                <div class="admin-details-container">
                                    <p><span>Bio : </span><?php echo !empty($fetchedadminbio) ? ucwords($fetchedadminbio) : 'null'; ?></p>

                                </div>

                            </div>

                        <?php
                        }

                        ?>

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