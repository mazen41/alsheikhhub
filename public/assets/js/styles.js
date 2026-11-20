//  alert("hiii");
function showmenu(){
    mainmenu1.style.display ="inline-block";
    searchIcon.style.display ="none";
    hidden.style.display ="none!important";
    // var links = window.document.li[]style.display="block";
}
function hidemenu() {
    mainmenu1.style.display = "none";
    // var links = window.document.li[]style.display="block";
}
function showmenus() {
    mainmenu2.style.display = "grid";
    // var links = window.document.li[]style.display="block";
}
function hidemenus() {
    mainmenu2.style.display = "none";
    // var links = window.document.li[]style.display="block";
}
function showcats() {
    maincats.style.display = "grid";
    // var links = window.document.li[]style.display="block";
}
function hidecats() {
    maincats.style.display = "none";
    // var links = window.document.li[]style.display="block";
}





//  alert("hiii");
function showmenu2() {
    var menus = window.document.getElementById('menus');
    for (menuIndex = 0; menuIndex < menus.length; menuIndex++) {
        menus[menuIndex].style.display = "grid";
    }
    // var links = window.document.li[]style.display="block";
}
function hidemenu2() {
    var menus = window.document.getElementById('menus');
    for (menuIndex = 0; menuIndex < menus.length; menuIndex++) {
        menus[menuIndex].style.display = "none";
    }
}