<?php

// admin index page


require_once('../includes/session.php');
require_once('../includes/db_connect.php');
require_once('../includes/functions.php');



checkAdminLogin();

//this checks if session is set

  if(isset($_SESSION['uname']) && isset($_SESSION['adminid']) && !empty($_SESSION['uname']) && !empty($_SESSION['adminid'])){
      
      //if session is set, this confirm if it's found in database
      $sql = "SELECT * FROM admin WHERE id=:aId AND auname=:aUname LIMIT 1";
      
      $stmt = $connect->prepare($sql);
      $stmt->bindValue(':aId',$_SESSION['adminid']);
      $stmt->bindValue(':aUname',$_SESSION['uname']);
      $stmt->execute();
      $checkIfAvailable = $stmt->rowcount(); 
      
      if($checkIfAvailable==1){
        $_SESSION['successmessage']="You're Already Logged In";
        if (isset($_SESSION['last_page'])) {
            if(!empty($_SESSION['last_page'])){
              $page = $_SESSION['last_page'];
              redirect($page);
            }else{
              
              redirect('dashboard.php');
            }
      } else {
          redirect('dashboard.php');
      }

      }else{
          
        $_SESSION['errormessage']="Login Detail not Found. Please Try Again!";
        redirect("login.php");
      }
    }
?>

<html>

    
        
        <script src="../js/script.js"></script>

</html>