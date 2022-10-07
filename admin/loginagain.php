<?php

// admin index page


require_once('../includes/session.php');
require_once('../includes/db_connect.php');
require_once('../includes/functions.php');

if(isset($_SESSION['redirect']) && !empty($_SESSION['redirect'])){
    $_SESSION['redirect'] = null;
    $_SESSION['errormessage'] = "Please Login Again";
    redirect('login.php');

}else{
    if(isset($_SESSION['last_page']) && !empty($_SESSION['last_page'])){
        redirect($_SESSION['last_page']);
    }else{
        redirect('dashboard.php');
    }
}

?>

<html>



<script src="../js/script.js"></script>

</html>