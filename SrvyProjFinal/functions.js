function navMenu(){
    var logo = document.getElementById("logo");

    if(logo.classList.contains("active")){
        logo.classList.remove("active");
        document.getElementById("topnav").style.height = "43px";
    }else{
        logo.classList.add("active");
        document.getElementById("topnav").style.height = "100%";
    }
}