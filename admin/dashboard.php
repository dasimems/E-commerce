<?php

require_once('../includes/session.php');
require_once('../includes/db_connect.php');
require_once('../includes/functions.php');

$_SESSION["last_page"] = null;

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
    <title>Dashboard</title>
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

            <div class="dashboard-container">

                <div class="dashboard-header">
                    <h1><i class="fas fa-home"></i>&nbsp;&nbsp;Admin Dashboard</h1>
                </div>

                <div class="dashboard-content">

                    <div class="dashboard-cards">

                        <div class="dashboard-cards-content" id="pending-products" onclick="redirect('products.php?query=pending')">

                            <div class="dashboard-card-icon">

                                <i class="fas fa-clock"></i>

                            </div>

                            <div class="dashboard-card-text">

                                <div class="dashboard-card-number">
                                    <h2>24</h2>
                                </div>

                                <div class="dashboard-card-link">
                                    <a href="products.php?query=pending">Ordered Products</a>
                                </div>

                            </div>

                        </div>

                        <div class="dashboard-cards-content" id="delivered-products" onclick="redirect('products.php?query=delivered')">

                            <div class="dashboard-card-icon">

                                <i class="fas fa-check"></i>

                            </div>

                            <div class="dashboard-card-text">

                                <div class="dashboard-card-number">
                                    <h2>24</h2>
                                </div>

                                <div class="dashboard-card-link">
                                    <a href="products.php?query=delivered">Delivered Products</a>
                                </div>

                            </div>

                        </div>

                        <div class="dashboard-cards-content" id="registerd-users" onclick="redirect('dashboard.php')">

                            <div class="dashboard-card-icon">

                                <i class="fas fa-pen"></i>

                            </div>

                            <div class="dashboard-card-text">

                                <div class="dashboard-card-number">
                                    <h2>24</h2>
                                </div>

                                <div class="dashboard-card-link">
                                    <a>Registerd Users</a>
                                </div>

                            </div>

                        </div>

                        <div class="dashboard-cards-content" id="active-users" onclick="redirect('dashboard.php')">

                            <div class="dashboard-card-icon">

                                <i class="fas fa-user-circle"></i>

                            </div>

                            <div class="dashboard-card-text">

                                <div class="dashboard-card-number">
                                    <h2>24</h2>
                                </div>

                                <div class="dashboard-card-link">
                                    <a>Active Users</a>
                                </div>

                            </div>

                        </div>


                    </div>

                    <?php

                    if ($position === 'manager' || $position === 'CEO') {

                    ?>
                        <div class="dashboard-cards">

                            <div class="dashboard-cards-content" id="departments" onclick="redirect('positions.php?query=departments')">

                                <div class="dashboard-card-icon">

                                    <i class="fas fa-award"></i>

                                </div>

                                <div class="dashboard-card-text">

                                    <div class="dashboard-card-number">
                                        <h2>

                                            <?php

                                            $fetchdepartmentsql = "SELECT * FROM department";

                                            $fetchdepartmentstmt = $connect->query($fetchdepartmentsql);

                                            $fetchdepartmentrowcount = $fetchdepartmentstmt->rowCount();

                                            echo $fetchdepartmentrowcount;

                                            ?>

                                        </h2>
                                    </div>

                                    <div class="dashboard-card-link">
                                        <a href="positions.php?query=departments">Departments</a>
                                    </div>

                                </div>

                            </div>

                            <div class="dashboard-cards-content" id="positions" onclick="redirect('positions.php?query=positions')">

                                <div class="dashboard-card-icon">

                                    <i class="fas fa-id-badge"></i>

                                </div>

                                <div class="dashboard-card-text">

                                    <div class="dashboard-card-number">
                                        <h2>
                                            <?php

                                            $fetchpositionsql = "SELECT * FROM position";

                                            $fetchpositionstmt = $connect->query($fetchpositionsql);

                                            $fetchpositionrowcount = $fetchpositionstmt->rowCount();

                                            echo $fetchpositionrowcount;

                                            ?></h2>
                                    </div>

                                    <div class="dashboard-card-link">
                                        <a href="positions.php?query=positions">Positions</a>
                                    </div>

                                </div>

                            </div>

                            <div class="dashboard-cards-content" id="admins" onclick="redirect('admin.php')">

                                <div class="dashboard-card-icon">

                                    <i class="fas fa-users"></i>

                                    <p class="active-admins"><span>

                                            <?php

                                            $fetchactiveadminsql = "SELECT * FROM admin WHERE astatus='active'";

                                            $fetchactiveadminstmt = $connect->query($fetchactiveadminsql);

                                            $fetchactiveadminrowcount = $fetchactiveadminstmt->rowCount();

                                            echo $fetchactiveadminrowcount;

                                            ?>

                                        </span></p>

                                </div>

                                <div class="dashboard-card-text">

                                    <div class="dashboard-card-number">
                                        <h2>

                                            <?php

                                            $fetchactiveadminssql = "SELECT * FROM admin";

                                            $fetchactiveadminsstmt = $connect->query($fetchactiveadminssql);

                                            $fetchactiveadminsrowcount = $fetchactiveadminsstmt->rowCount();

                                            echo $fetchactiveadminsrowcount;

                                            ?>

                                        </h2>
                                    </div>

                                    <div class="dashboard-card-link">
                                        <a href="admin.php">Admins</a>
                                    </div>

                                </div>

                            </div>

                            <div class="dashboard-cards-content" id="applicants" onclick="redirect('applicants.php')">

                                <div class="dashboard-card-icon">

                                    <i class="fas fa-user-clock"></i>

                                </div>

                                <div class="dashboard-card-text">

                                    <div class="dashboard-card-number">
                                        <h2>24</h2>
                                    </div>

                                    <div class="dashboard-card-link">
                                        <a href="applicants.php">Applicants</a>
                                    </div>

                                </div>

                            </div>


                        </div>

                    <?php

                    }
                    ?>

                    <div class="dashboard-table">

                        <div class="dashboard-table-header">
                            <h2>Recent Products</h2>
                        </div>

                        <div class="dashboard-table-content">

                            <table>

                                <thead>
                                    <td>Name</td>
                                    <td>Category</td>
                                    <td>Sub-Category</td>
                                    <td class="price">Price</td>
                                    <td class="quantity">Quantity</td>
                                    <td>Date Added</td>
                                </thead>

                                <tr>

                                    <td>Name</td>
                                    <td>Category</td>
                                    <td>Sub-Category</td>
                                    <td class="price">Price</td>
                                    <td class="quantity">Quantity</td>
                                    <td>Date Added</td>

                                </tr>

                            </table>

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