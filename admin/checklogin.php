<?php

// admin index page


require_once('../includes/session.php');
require_once('../includes/db_connect.php');
require_once('../includes/functions.php');



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

if (isset($_POST['uname']) && isset($_POST['password'])) {
    if (empty($_POST['uname']) || empty($_POST['password'])) {

        $_SESSION["errormessage"] = "Please Fill all Field!";
        redirect("login.php");
    } else {
        $uname = $_POST['uname'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM admin WHERE auname=:aUname LIMIT 1";

        $stmt = $connect->prepare($sql);
        $stmt->bindValue(':aUname', $uname); // binds the inputed value
        $stmt->execute();
        $checkIfAvailable = $stmt->rowcount();

        if ($checkIfAvailable == 1) { // this check if the username with the inputed field is found

            $values = $stmt->fetch();

            //fetching the neccessary data

            $adminId = $values['id'];
            $savedauname = $values['auname'];
            $savedapassword = $values['apassword'];
            $savedaposition = $values['aposition'];

            if (password_verify($password, $savedapassword)) {
                $_SESSION['uname'] = $savedauname;;
                $_SESSION['adminid'] = $adminId;
                $_SESSION['position'] = $savedaposition;
                $_SESSION['successmessage'] = "Welcome ". ucwords($uname);

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
            } else {
                $_SESSION["errormessage"] = "Incorrect Password. Please Try Again!";
                redirect("login.php");
            }
        } elseif ($checkIfAvailable > 1) {
            $_SESSION["errormessage"] = "Something Went Wrong, Please Try Again Later. Thanks!";
            redirect("login.php");
        } else {
            $_SESSION["errormessage"] = "Login Detail Not Found, Please Try Again!";
            redirect("login.php");
        }
    }
}



?>

<html>

    
        
        <script src="../js/script.js"></script>

</html>