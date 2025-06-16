function openNav() {
    if (window.innerWidth <= 768) {
        document.getElementById("mySidenav").style.width = "50%";
    } else {
        document.getElementById("mySidenav").style.width = "20%";
    }

}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0%";
}