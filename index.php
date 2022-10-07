<?php
if(isset($_GET['page']) || !empty($_GET['page'])){
    $page = $_GET['page'];
//    echo $page;
   print_r(scandir("pages",0));
}else{
    header('location: index.php?page=home');
}

?>