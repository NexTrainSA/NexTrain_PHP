const open = document.querySelector("#toggle-btn");
hamburger.addEventListener("click", function() {
    document.querySelector("#sidebar").classList.toggle("expand");
})

function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("expand");
}
