<?php 

function redirect($location){
    header("location:{$location}");
}

function checkAdminLogin(){
    if(!isset($_SESSION['uname']) || !isset($_SESSION['adminid']) || empty($_SESSION['uname']) || empty($_SESSION['adminid'])){
        $_SESSION['errormessage'] = "Please Provide Your Login Details";
        redirect("login.php");
        exit();
    }
    
   
}

function checkposition(){
    if(isset($_SESSION['position'])){
        echo $_SESSION['position']=="manager" || $_SESSION['position']=="CEO" ? "admin.php" : "#" ; 
    }else
    { 
        echo "#"; 
    }
}

function disableForm(){
    if(!isset($_GET['update'])){
        echo 'readonly disabled';
    }
}

function disablesec($val){
    if(!isset($_GET['update']) || $_GET['update'] !== $val){
        echo 'readonly disabled';
    }
}

function getPageSet(){
    
    if(isset($_GET['title'])){
        if(!empty($_GET['title'])){
            echo 'style="display: none;"';
        }
    }
}

function getPageSetTwo(){
    
    if(!isset($_GET['title']) || empty($_GET['title'])){
        
        echo 'style="display: none;"';
        
    }
}

function footertodown(){
    
    if(isset($_GET['title'])){
        if(!empty($_GET['title'])){
        
            echo 'style="position: absolute; width: 100%; bottom: 0;"';
        }
        
    }
}






?>