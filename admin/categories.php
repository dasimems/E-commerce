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
        $position = $details['aposition'];

        if ($position !== $_SESSION['position']) {
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
    <title>Categories</title>
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

            <button id="yes" onclick="back('categories.php')"><i class="fas fa-check"></i></button><button id="no"><i class="fas fa-times"></i></button>

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

                        <form action="searchcat.php" method="post">

                            <input type="text" name="categorySearch" placeholder="Category Search..." />

                            <input type="submit" name="submitcatsearch" value="Search" />

                        </form>

                    </div>
                    <div class="category-btn">

                        <a href="categories.php?title=addnewcat"><span><i class="fas fa-folder-plus"></i>&nbsp;&nbsp;Add New Category</span></a>

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
                                        echo 'CATEGORIES';
                                    }
                                } else {
                                    echo 'CATEGORIES';
                                }

                                ?>

                            </h2>

                        </div>

                        <div class="category-body-table">

                            <table>

                                <thead>

                                    <td>NO</td>
                                    <td>TITLE</td>
                                    <td>ADDED BY</td>
                                    <td>DATE ADDED</td>
                                    <td>TIME ADDED</td>
                                    <td>ACTION</td>
                                    <td>NO OF PRODUCTS</td>

                                </thead>

                                <?php

                                if (isset($_SESSION['catsearch'])) {

                                    if (!empty($_SESSION['catsearch'])) {
                                        $searchkeyword = $_SESSION['catsearch'];
                                        $_SESSION['catsearch'] = null;

                                        $catsearchsql = "SELECT * FROM category WHERE catitle LIKE :searchKey";

                                        $catsearchstmt = $connect->prepare($catsearchsql);
                                        $catsearchstmt->bindValue(':searchKey', "%".$searchkeyword."%");
                                        $catexecute = $catsearchstmt->execute();

                                        if ($catexecute) {
                                            $catsearchavailable = $catsearchstmt->rowcount();

                                            if ($catsearchavailable < 1) {


                                ?>
                                                <tr>

                                                    <td class="exception" style="background: white; color: black;" colspan="7">No Record Found!</td>

                                                </tr>

                                                <?php
                                            } else {
                                                $srno = 0;

                                                while ($catsearchlist = $catsearchstmt->fetch()) {
                                                    $catlistid = $catsearchlist['id'];
                                                    $catlisttitle = $catsearchlist['catitle'];
                                                    $catlistaddedby = $catsearchlist['caadded_by'];
                                                    $catlistdate = $catsearchlist['cadate_added'];
                                                    $catlisttime = $catsearchlist['catime_added'];
                                                    $srno++;

                                                ?>
                                                    <tr>

                                                        <td><?php echo $srno; ?></td>
                                                        <td><?php echo ucwords($catlisttitle); ?></td>
                                                        <td><?php echo ucwords($catlistaddedby); ?></td>
                                                        <td><?php echo $catlistdate; ?></td>
                                                        <td><?php echo $catlisttime; ?></td>
                                                        <td>


                                                            <a href="deletecat.php?id=<?php echo $catlistid; ?>&title=<?php echo $catlisttitle; ?>"><span class="deletcatlist"><i class="fas  fa-trash-alt"></i>&nbsp;&nbsp;DELETE</span></a><br>
                                                            <a href="categories.php?id=<?php echo $catlistid; ?>&name=<?php echo $catlisttitle; ?>&title=addnewcat"><span class="updatecatlist"><i class="fas  fa-edit"></i>&nbsp;&nbsp;Update</span></a>


                                                        </td>
                                                        <td>
                                                        
                                                        <a href="products.php?query=available">
                                                        <span id="available-products" style="background: green; padding:5px 10px; border-radius: 5px;">
                                                            <?php
                                                            
                                                                $fetchproductsql = "SELECT * FROM product WHERE pcategory='$catlisttitle' AND pstatus='available'";
                                                                $fetchproductstmt = $connect->query($fetchproductsql);
                                                                $fetchproductrowcount = $fetchproductstmt->rowCount();

                                                                echo $fetchproductrowcount;
                                                            
                                                            ?>
                                                        </span>
                                                    </a>

                                                    <a href="products.php?query=unavailable">
                                                        <span id="available-products" style="background: red; padding:5px 10px; border-radius: 5px; margin-left: 10px;">
                                                            <?php
                                                            
                                                                $fetchproductsql = "SELECT * FROM product WHERE pcategory='$catlisttitle' AND pstatus='unavailable'";
                                                                $fetchproductstmt = $connect->query($fetchproductsql);
                                                                $fetchproductrowcount = $fetchproductstmt->rowCount();

                                                                echo $fetchproductrowcount;
                                                            
                                                            ?>
                                                        </span>
                                                    </a>

                                                        </td>

                                                    </tr>

                                        <?php
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $catlistsql = "SELECT id, catitle, caadded_by, cadate_added, catime_added FROM category ORDER BY catitle ASC";

                                    $catliststmt = $connect->query($catlistsql);
                                    $catlistavailable = $catliststmt->rowcount();

                                    if ($catlistavailable < 1) {

                                        ?>

                                        <tr>

                                            <td class="exception" style="background: white; color: black;" colspan="7">You Have No Category In Your Database</td>

                                        </tr>

                                        <?php

                                    } else {

                                        // $catlistfetch = $catliststmt->fetch();
                                        $srno = 0;

                                        while ($catlist = $catliststmt->fetch()) {
                                            $catlistid = $catlist['id'];
                                            $catlisttitle = $catlist['catitle'];
                                            $catlistaddedby = $catlist['caadded_by'];
                                            $catlistdate = $catlist['cadate_added'];
                                            $catlisttime = $catlist['catime_added'];
                                            $srno++;

                                        ?>
                                            <tr>

                                                <td><?php echo $srno; ?></td>
                                                <td><?php echo ucwords($catlisttitle); ?></td>
                                                <td><?php echo ucwords($catlistaddedby); ?></td>
                                                <td><?php echo $catlistdate; ?></td>
                                                <td><?php echo $catlisttime; ?></td>
                                                <td>


                                                    <a href="deletecat.php?id=<?php echo $catlistid; ?>&title=<?php echo $catlisttitle; ?>"><span class="deletcatlist"><i class="fas  fa-trash-alt"></i>&nbsp;&nbsp;DELETE</span></a><br>
                                                    <a href="categories.php?id=<?php echo $catlistid; ?>&name=<?php echo $catlisttitle; ?>&title=addnewcat"><span class="updatecatlist"><i class="fas  fa-edit"></i>&nbsp;&nbsp;Update</span></a>


                                                </td>
                                                <td>
                                                    
                                                <a href="products.php?query=available">
                                                        <span id="available-products" style="background: green; padding:5px 10px; border-radius: 5px;">
                                                            <?php
                                                            
                                                                $fetchproductsql = "SELECT * FROM product WHERE pcategory='$catlisttitle' AND pstatus='available'";
                                                                $fetchproductstmt = $connect->query($fetchproductsql);
                                                                $fetchproductrowcount = $fetchproductstmt->rowCount();

                                                                echo $fetchproductrowcount;
                                                            
                                                            ?>
                                                        </span>
                                                    </a>

                                                    <a href="products.php?query=unavailable">
                                                        <span id="available-products" style="background: red; padding:5px 10px; border-radius: 5px; margin-left: 10px;">
                                                            <?php
                                                            
                                                                $fetchproductsql = "SELECT * FROM product WHERE pcategory='$catlisttitle' AND pstatus='unavailable'";
                                                                $fetchproductstmt = $connect->query($fetchproductsql);
                                                                $fetchproductrowcount = $fetchproductstmt->rowCount();

                                                                echo $fetchproductrowcount;
                                                            
                                                            ?>
                                                        </span>
                                                    </a>

                                                </td>

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

                                    <a href="categories.php"><span><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Back To Category</span></a>

                                </div>

                        <?php

                            }
                        }

                        ?>



                    </div>

                    <div class="category-form" <?php getPageSetTwo(); ?>>

                        <div class="category-form-header">
                            <h2>
                            
                                <?php 
                                if((!isset($_GET['id']) && !isset($_GET['name']) && !isset($_GET['category'])) || (empty($_GET['id']) && empty($_GET['name']) && empty($_GET['category']))){
                                ?>
                            
                                ADD NEW CATEGORY
                                <?php 
                                }else{
                                ?>

                                UPDATE CATEGORY

                                <?php 
                                }
                                ?>
                             </h2>
                        </div>

                        <form method="post">

                            <div class="form-input">

                                <label for="cattitle">Title</label>
                                <input type="text" name="cattitle" id="cattitle" placeholder="Input Category Title Here..." value="<?php echo isset($_GET['name']) && !empty($_GET['name'])? $_GET['name']: "" ;?>" />

                            </div>

                            <div class="form-input">

                                <button type="button" class="back-btn"><i class="fas fa-arrow-left"></i>&nbsp; Back To Categories</button>

                                <?php 
                                if((!isset($_GET['id']) && !isset($_GET['name']) && !isset($_GET['category'])) || (empty($_GET['id']) && empty($_GET['name']) && empty($_GET['category']))){
                                ?>
                                <button type="submit" class="update-btn" formaction="addnewcat.php"><i class="fas fa-check"></i>&nbsp;Add Category</button>
                                <?php

                                }else{
                                    
                                ?>

                                <input type="hidden" name="updatecatid" value="<?php echo $_GET['id']; ?>">

                                <button type="submit" class="update-btn" formaction="updatecat.php"><i class="fas fa-save"></i>&nbsp;Update Category</button>

                                <?php

                                }
                                                                
                                ?>
                                

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

    <div class="footer" <?php footertodown(); ?>>

        <div class="footer-text">

            <p>Copyrights &copy; <?php echo date('Y'); ?> MEMS CART </p>

        </div>

    </div>

    <!--        the footer ends here-->

    <script src="../js/script.js"></script>


</body>

</html>