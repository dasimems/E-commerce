window.addEventListener('scroll',()=>{
    var nav = document.querySelector('nav');
    var sidebar = document.querySelector('.main-content-side-bar');
    
    if(window.scrollY >= 50){
        nav.style.position = 'fixed';
        sidebar.style.marginTop = '50px';
        sidebar.style.transition = 'none';
    }else{
        nav.style.position = 'inherit';
        sidebar.style.marginTop = '0';
        sidebar.style.transition = 'none';
    }
    
})

//if(window.clientWidth = 980){
//    
//document.querySelector('.profile-container-left-side').style.height = 'auto';
//}else{
//  var defprofilesidebarwidth = document.querySelector('.profile-container-right-side').clientHeight;
//
//document.querySelector('.profile-container-left-side').style.height = defprofilesidebarwidth + "px";  
//}





document.querySelector('.back-btn').addEventListener('click',()=>{
    document.querySelector('.back-alert').style.display = "flex";
    document.querySelector('.back-alert').style.animationName = "fadein";
})


document.querySelector('.alert-one #no').addEventListener('click', ()=>{
    document.querySelector('.back-alert').style.display = "none";
    document.querySelector('.back-alert').style.animationName = "";
})


function back(p){
    window.location.replace(p);
}

function redirect(p){
    window.location.assign(p);
}

var docloader = document.querySelector('.loader');



function docfinish(){
    
    function removeLoader(){
        
       var docloader = document.querySelector('.loader');
       var errormessage = document.querySelector('.display-message');
        
        
        docloader.style.display = 'none';
        errormessage.style.opacity = '1';
        errormessage.style.animationName = 'error';
        
        function removeErrorMessage(){
            
            errormessage.style.opacity = '0';
            errormessage.style.display = 'none';
        }
        
        setTimeout(removeErrorMessage, 2000);
    }
    
    setTimeout(removeLoader, 0);

    

    var body = document.querySelector('body');


    if(body.clientHeight < window.innerHeight){
        var mainRightSide = document.querySelector('.main-right-side');
        var margin = window.innerHeight - body.clientHeight;
        
        mainRightSide.style.marginBottom = margin+"px";
        console.log(margin);
    }
    
}

function openMenu(){
    if(document.querySelector('.main-content-side-bar-container').style.left !== "0px"){
        document.querySelector('.main-content-side-bar-container').style.left = "0px"
        document.querySelector('.main-content-side-bar-container').style.transition = "1s ease all";
    }else{
        document.querySelector('.main-content-side-bar-container').style.left = "-50px"
        document.querySelector('.main-content-side-bar-container').style.transition = "1s ease all";
    }
}



window.addEventListener('resize', ()=>{
    
    if(window.innerWidth > 500){
        
        document.querySelector('.main-content-side-bar-container').style.left = "0px";
        document.querySelector('.main-content-side-bar-container').style.transition = "1s ease all";
        
//        console.log(window.innerHeight);
//        console.log("body" + document.querySelector('body').clientHeight);
        
    
        
    }else{
        
        
        document.querySelector('.main-content-side-bar-container').style.left = "-50px"
        document.querySelector('.main-content-side-bar-container').style.transition = "1s ease all";
        
    }
    
})