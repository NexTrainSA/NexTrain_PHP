<?php

    session_start();

    if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
        include_once '../html/login.html';
    }else{
        include_once '../html/templates/header.html';
        $page = isset($_GET["page"]) ?$_GET["page"] : "index.html";
        include_once '../html/'.$page;
        include_once '../html/templates/footer.html';
    }
?>