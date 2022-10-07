<?php

$dbconnection = "mysql:host=localhost;dbname=ecommerceweb1";
$dbuname = "root";
$dbpassword = "";

$connect = new PDO($dbconnection, $dbuname, $dbpassword);

 function checkadminlogin2(){
        if(isset($_SESSION['uname']) && isset($_SESSION['adminid']) && !empty($_SESSION['uname']) && !empty($_SESSION['adminid'])){
      
      //if session is set, this confirm if it's found in database
      $sql = "SELECT * FROM admin WHERE id=:aId AND auname=:aUname LIMIT 1";
      
      $stmt = $connect->prepare($sql);
      $stmt->bindValue(':aId',$_SESSION['adminid']);
      $stmt->bindValue(':aUname',$_SESSION['uname']);
      $stmt->execute();
      $checkIfAvailable = $stmt->rowcount(); 
      
      if($checkIfAvailable==1){
            $details = $stmt->fetch();
          
            $adminid = $details['id'];
            $adminusername = $details['uname'];
      }else{
          
        $_SESSION['errormessage']="Wrong login details. Thanks For Trying and Have a Nice Day.";
        redirect("login.php");
      }
    }
    }

?>