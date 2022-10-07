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
        $adminposition = $details['aposition'];

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

if (isset($_SESSION['newuname'])) {
    if (!empty($_SESSION['newuname'])) {
        $newuname = $_SESSION['newuname'];
    } else {
        $newuname = '';
    }
} else {
    $newuname = '';
}

if (isset($_SESSION['newfirstname'])) {
    if (!empty($_SESSION['newfirstname'])) {
        $newfirstname = $_SESSION['newfirstname'];
    } else {
        $newfirstname = '';
    }
} else {
    $newfirstname = '';
}

if (isset($_SESSION['newmiddlename'])) {
    if (!empty($_SESSION['newmiddlename'])) {
        $newmiddlename = $_SESSION['newmiddlename'];
    } else {
        $newmiddlename = '';
    }
} else {
    $newmiddlename = '';
}

if (isset($_SESSION['newlastname'])) {
    if (!empty($_SESSION['newlastname'])) {
        $newlastname = $_SESSION['newlastname'];
    } else {
        $newlastname = '';
    }
} else {
    $newlastname = '';
}

if (isset($_SESSION['newphoneNumber'])) {
    if (!empty($_SESSION['newphoneNumber'])) {
        $newphoneNumber = $_SESSION['newphoneNumber'];
    } else {
        $newphoneNumber = '';
    }
} else {
    $newphoneNumber = '';
}

if (isset($_SESSION['newemail'])) {
    if (!empty($_SESSION['newemail'])) {
        $newemail = $_SESSION['newemail'];
    } else {
        $newemail = '';
    }
} else {
    $newemail = '';
}

if (isset($_SESSION['newaddress'])) {
    if (!empty($_SESSION['newaddress'])) {
        $newaddress = $_SESSION['newaddress'];
    } else {
        $newaddress = '';
    }
} else {
    $newaddress = '';
}

if (isset($_SESSION['newcountry'])) {
    if (!empty($_SESSION['newcountry'])) {
        $newcountry = $_SESSION['newcountry'];
    } else {
        $newcountry = '';
    }
} else {
    $newcountry = '';
}

if (isset($_SESSION['newstate'])) {
    if (!empty($_SESSION['newstate'])) {
        $newstate = $_SESSION['newstate'];
    } else {
        $newstate = '';
    }
} else {
    $newstate = '';
}

if (isset($_SESSION['newcity'])) {
    if (!empty($_SESSION['newcity'])) {
        $newcity = $_SESSION['newcity'];
    } else {
        $newcity = '';
    }
} else {
    $newcity = '';
}

if (isset($_SESSION['newposition'])) {
    if (!empty($_SESSION['newposition'])) {
        $newposition = $_SESSION['newposition'];
    } else {
        $newposition = '';
    }
} else {
    $newposition = '';
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
    <title>Admins</title>
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

            <button id="yes" onclick="back('admin.php')"><i class="fas fa-check"></i></button><button id="no"><i class="fas fa-times"></i></button>

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



            <div class="category">

                <div class="category-header" <?php getPageSet(); ?>>

                    <div class="category-search">

                        <form action="searchadmin.php" method="post">

                            <input type="text" name="adminSearch" placeholder="admin Search..." />

                            <input type="submit" name="submitadminsearch" value="Search" />

                        </form>

                    </div>
                    <div class="category-btn">

                        <a href="admin.php?title=addnewcat"><span><i class="fas fa-user-plus"></i>&nbsp;&nbsp;Add New Admin</span></a>

                    </div>

                </div>

                <div class="category-body">

                    <div class="category-body-container" <?php getPageSet(); ?>>

                        <div class="category-body-header">

                            <h2>
                                <?php


                                if (isset($_SESSION['catsearch'])) {

                                    if (!empty($_SESSION['catsearch'])) {
                                        echo 'Your Search Result For "' . $_SESSION['catsearch'] . '"';
                                    } else {
                                        echo 'ADMINS';
                                    }
                                } else {
                                    echo 'ADMINS';
                                }

                                ?>

                            </h2>

                        </div>

                        <div class="category-body-table" id="admin-table">

                            <table>

                                <thead>

                                    <td>NO</td>
                                    <td id="pic">PROFILE PIC</td>
                                    <td >DETAILS</td>
                                    <td id="bio">BIO</td>
                                    <td id="action">ACTION</td>

                                </thead>

                                <?php

                                if (isset($_SESSION['catsearch'])) {

                                    if (!empty($_SESSION['catsearch'])) {
                                        $searchkeyword = $_SESSION['catsearch'];
                                        $_SESSION['catsearch'] = null;

                                        $catsearchsql = "SELECT * FROM admin WHERE afname LIKE :searchKey OR alname LIKE :searchKey OR amname LIKE :searchKey OR aemail LIKE :searchKey OR aaddress LIKE :searchKey OR aphone_number LIKE :searchKey OR acountry LIKE :searchKey OR astate LIKE :searchKey OR acity LIKE :searchKey OR aposition LIKE :searchKey OR adept LIKE :searchKey ORDER BY afname ASC";

                                        $catsearchstmt = $connect->prepare($catsearchsql);
                                        $catsearchstmt->bindValue(':searchKey', "%".$searchkeyword."%");
                                        $catexecute = $catsearchstmt->execute();

                                        if ($catexecute) {
                                            $catsearchavailable = $catsearchstmt->rowcount();

                                            if ($catsearchavailable < 1) {


                                ?>
                                                <tr>

                                                    <td class="exception" style="background: white; color: black;" colspan="5">No Record Found!</td>

                                                </tr>

                                                <?php
                                            } else {
                                                $srno = 0;

                                                while ($catsearchlist = $catsearchstmt->fetch()) {
                                                    $adminid = $catsearchlist['id'];
                                                    $adminuname = $catsearchlist['auname'];
                                                    $adminfname = $catsearchlist['afname'];
                                                    $adminlname = $catsearchlist['alname'];
                                                    $adminmname = $catsearchlist['amname'];
                                                    $admincountry = $catsearchlist['acountry'];
                                                    $adminstate = $catsearchlist['astate'];
                                                    $admincity = $catsearchlist['acity'];
                                                    $adminposition = $catsearchlist['aposition'];
                                                    $adminpic = $catsearchlist['apic'];
                                                    $adminbio = $catsearchlist['abio'];
                                                    $adminaddeddate = $catsearchlist['adate_added'];
                                                    $adminlastlogin = $catsearchlist['adate_last_login'];
                                                    $srno++;

                                                ?>
                                                    <tr>

                                                        <td rowspan="6"><?php echo $srno; ?></td>
                                                        <td rowspan="6"  id="pic"><img src="images/<?php echo $adminpic; ?>" alt="<?php echo $adminfname . '' . $adminmname . '' . $adminlname . ' profile pic'; ?>"></td>
                                                        <td id="details-row">Full Name: <?php echo ucwords($adminfname) . ' ' . ucwords($adminmname) . ' ' . ucwords($adminlname); ?></td>
                                                        <td rowspan="6" id="bio"><?php echo empty($adminbio) ? 'null' : $adminbio; ?></td>
                                                        <td rowspan="3" id="action">


                                                            <a href="deleteadmin.php?id=<?php echo $adminid; ?>&title=<?php echo $adminuname; ?>"><span class="deletcatlist"><i class="fas  fa-trash-alt"></i>&nbsp;&nbsp;DELETE</span></a>


                                                        </td>

                                                    </tr>

                                                    <tr>

                                                        <td id="details-row">Location: <?php echo ucwords($admincity) . ' ' . ucwords($adminstate) . '. ' . ucwords($admincountry); ?></td>


                                                    </tr>

                                                    <tr>

                                                        <td id="details-row">Date Added: <?php echo empty($adminaddeddate) ? 'null' : $adminaddeddate; ?></td>


                                                    </tr>

                                                    <tr>

                                                        <td id="details-row">Last Seen: <?php echo empty($adminlastlogin) ? 'null' : $adminlastlogin; ?></td>


                                                        <td rowspan="3" id="action">


                                                            <a href="viewprofile.php?username=<?php echo $adminuname; ?>&name=<?php echo $adminfname; ?>" target="_blank"><span class="view-profile"><i class="far fa-eye"></i>&nbsp;&nbspVIEW PROFILE</span></a>


                                                        </td>

                                                    </tr>

                                                    <tr>

                                                        <td id="details-row">Position: <?php echo empty($adminposition) ? 'null' : ucwords($adminposition); ?></td>

                                                    </tr>

                                                    <tr>
                                                        <td class="blank"></td>

                                                    </tr>

                                        <?php
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $catlistsql = "SELECT * FROM admin ORDER BY afname ASC";

                                    $catliststmt = $connect->query($catlistsql);
                                    $catlistavailable = $catliststmt->rowcount();

                                    if ($catlistavailable < 1) {

                                        ?>

                                        <tr>

                                            <td class="exception" style="background: white; color: black;" colspan="4">You Have No Existing Admin In Your Database</td>

                                        </tr>

                                        <?php

                                    } else {

                                        // $catlistfetch = $catliststmt->fetch();
                                        $srno = 0;

                                        while ($catlist = $catliststmt->fetch()) {
                                            $adminid = $catlist['id'];
                                            $adminuname = $catlist['auname'];
                                            $adminfname = $catlist['afname'];
                                            $adminlname = $catlist['alname'];
                                            $adminmname = $catlist['amname'];
                                            $admincountry = $catlist['acountry'];
                                            $adminstate = $catlist['astate'];
                                            $admincity = $catlist['acity'];
                                            $adminposition = $catlist['aposition'];
                                            $adminpic = $catlist['apic'];
                                            $adminbio = $catlist['abio'];
                                            $adminaddeddate = $catlist['adate_added'];
                                            $adminlastlogin = $catlist['adate_last_login'];
                                            $srno++;

                                        ?>


                                            <tr>

                                                <td rowspan="6"><?php echo $srno; ?></td>
                                                <td rowspan="6"  id="pic"><img src="images/<?php echo $adminpic; ?>" alt="<?php echo $adminfname . '' . $adminmname . '' . $adminlname . ' profile pic'; ?>"></td>
                                                <td id="details-row">Full Name: <?php echo ucwords($adminfname) . ' ' . ucwords($adminmname) . ' ' . ucwords($adminlname); ?></td>
                                                <td rowspan="6" id="bio"><?php echo empty($adminbio) ? 'null' : $adminbio; ?></td>
                                                <td rowspan="3" id="action">


                                                    <a href="deleteadmin.php?id=<?php echo $adminid; ?>&title=<?php echo $adminuname; ?>"><span class="deletcatlist"><i class="fas  fa-trash-alt"></i>&nbsp;&nbsp;DELETE</span></a>


                                                </td>

                                            </tr>

                                            <tr>

                                                <td id="details-row">Location: <?php echo ucwords($admincity) . ' ' . ucwords($adminstate) . '. ' . ucwords($admincountry); ?></td>


                                            </tr>

                                            <tr>

                                                <td id="details-row">Date Added: <?php echo empty($adminaddeddate) ? 'null' : $adminaddeddate; ?></td>


                                            </tr>

                                            <tr>

                                                <td id="details-row">Last Seen: <?php echo empty($adminlastlogin) ? 'null' : $adminlastlogin; ?></td>


                                                <td rowspan="3" id="action">


                                                    <a href="viewprofile.php?username=<?php echo $adminuname; ?>&name=<?php echo $adminfname; ?>" target="_blank"><span class="view-profile"><i class="far fa-eye"></i>&nbsp;&nbspVIEW PROFILE</span></a>


                                                </td>

                                            </tr>

                                            <tr>



                                                <td id="details-row">Position: <?php echo empty($adminposition) ? 'null' : ucwords($adminposition); ?></td>

                                            </tr>

                                            <tr>
                                                <td class="blank"></td>

                                            </tr>


                                <?php
                                        }
                                    }
                                }

                                ?>


                            </table>


                        </div>

                        <?php

                        if (isset($searchkeyword)) {
                            if (!empty($searchkeyword)) {
                        ?>

                                <div class="category-back-btn">

                                    <a href="admin.php"><span><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Back To Admin</span></a>

                                </div>

                        <?php

                            }
                        }

                        ?>



                    </div>

                    <div class="category-form" id="sub-category-form" <?php getPageSetTwo(); ?>>

                        <div class="category-form-header">
                            <h2>ADD NEW ADMIN</h2>
                        </div>

                        <form action="addnewadmin.php" method="post">

                            <div class="form-input">

                                <label for="uname">Username</label>
                                <input type="text" name="uname" id="uname" placeholder="Input Admin Username Here..." value="<?php echo returnValue($newuname); ?>" />

                            </div>

                            <div class="form-input">

                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" placeholder="Input Admin Password Here..." />

                            </div>

                            <div class="form-input">

                                <label for="passwordtwo">Confirm Password</label>
                                <input type="password" name="passwordtwo" id="passwordtwo" placeholder="Confirm Admin Password..." />

                            </div>

                            <div class="form-input">

                                <label for="firstname">First Name</label>
                                <input type="text" name="firstname" id="firstname" placeholder="Input Admin First Name Here..." value="<?php echo returnValue($newfirstname); ?>" />

                            </div>

                            <div class="form-input">

                                <label for="middlename">Middle Name</label>
                                <input type="text" name="middlename" id="middlename" placeholder="Input Admin Middle Name Here..." value="<?php echo returnValue($newmiddlename); ?>" />

                            </div>

                            <div class="form-input">

                                <label for="lastname">Last Name</label>
                                <input type="text" name="lastname" id="lastname" placeholder="Input Admin Last Name Here..." value="<?php echo returnValue($newlastname); ?>" />

                            </div>

                            <div class="form-input">

                                <label for="phoneNumber">Telephone Number</label>
                                <input type="tel" name="phoneNumber" id="phoneNumber" placeholder="Input Admin Mobile Number Here..." value="<?php echo returnValue($newphoneNumber); ?>" />

                            </div>

                            <div class="form-input">

                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" placeholder="Input Admin Email Here..." value="<?php echo returnValue($newemail); ?>" />

                            </div>

                            <div class="form-input">

                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" placeholder="Input Admin Address Here..." value="<?php echo returnValue($newaddress); ?>" />

                            </div>

                            <div class="form-input">

                                <label for="country">Country</label>
                                <select name="country" id="country">

                                    <option value="<?php echo !empty($newcountry)? returnValue($newcountry) : ""; ?>"><?php echo !empty($newcountry)? returnValue($newcountry) : "---"; ?></option>

                                    <?php

                                    if (empty($newcountry || !isset($newcountry))) {
                                        $fetchcountrysql = "SELECT * FROM country ORDER BY coname ASC";
                                        $fetchcountrystmt = $connect->query($fetchcountrysql);

                                        while ($fetchcountry =  $fetchcountrystmt->fetch()) {
                                            $fetchedcountry = $fetchcountry['coname'];


                                    ?>
                                            <option value="<?php echo $fetchedcountry; ?>"><?php echo ucwords($fetchedcountry); ?></option>
                                    <?php
                                        }
                                    }
                                    ?>

                                </select>

                            </div>

                            <div class="form-input">

                                <label for="state">State</label>
                                <input type="text" name="state" id="state" placeholder="Input Admin State Here..." value="<?php echo returnValue($newstate); ?>" />

                            </div>

                            <div class="form-input">

                                <label for="city">City</label>
                                <input type="text" name="city" id="city" placeholder="Input Admin City Here..." value="<?php echo returnValue($newcity); ?>" />

                            </div>

                            <div class="form-input">

                                <label for="position">Position</label>
                                <select name="position" id="position">

                                    <option value="<?php echo !empty($newposition)? returnvalue($newposition): ""; ?>"><?php echo !empty($newposition)? returnvalue($newposition): "---"; ?></option>
                                    <?php

                                    if (empty($newposition) || !isset($newposition)) {


                                        $fetchpositionsql = "SELECT * FROM position ORDER BY ptitle";

                                        $fetchpositionstmt = $connect->query($fetchpositionsql);

                                        while ($fetchposition = $fetchpositionstmt->fetch()) {
                                            $positiontitle = $fetchposition['ptitle'];

                                    ?>
                                            <option value="<?php echo ($positiontitle === 'CEO')?"" :$positiontitle; ?>"><?php echo ($positiontitle === 'CEO')?"" :ucwords($positiontitle); ?></option>

                                    <?php
                                        }
                                    }



                                    ?>
                                </select>

                            </div>

                            <div class="form-input">

                                <button type="button" class="back-btn"><i class="fas fa-arrow-left"></i>&nbsp; Back To Admin</button>
                                <button type="submit" class="update-btn" value="updateInputs"><i class="fas fa-check"></i>&nbsp;Add New Admin</button>

                            </div>

                        </form>

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