
// https://www.w3schools.com/js/js_cookies.asp
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}

function toggleDarkMode() {
    document.body.classList.toggle("dark-mode");
}

window.onload(() => {
    console.log("load");
})

if(getCookie("darkMode") === "true") {
    toggleDarkMode();
    console.log("Dark Mode")
}