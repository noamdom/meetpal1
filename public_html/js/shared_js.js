/**------- Contants ------------ */

// nav link 
const links_arr = document.getElementsByClassName('nav_link');

/**------- Functions ------------ */

// this function set coockie of search line
function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (60 * 60 * 24)); // keep coocke for 1 hour
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}




    