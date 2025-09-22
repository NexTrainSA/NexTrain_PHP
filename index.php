<?php
    session_start();
    include("./php/db.php");

    if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
        include_once './html/login.html';
    }else{
        include_once './html/templates/header.html';
        $page = isset($_GET["page"]) ?$_GET["page"] : "index.html";

        if(str_contains($page, "admin")) {
            if(!check_user_permission($_SESSION["username"], "ADMIN_PAGES")) {
                http_response_code(403);
                die("<script>alert('Você não tem permissão para acessar esta página.'); document.location.href = '.'</script>");
            }
        }
        include_once './html/'.$page;
        include_once './php/'.$page;
        include_once './html/templates/footer.html';
    }
?>