<?php

    session_start();

    if(isset($_POST["user"]) && isset($_POST["pass"])) {
        $u = $_POST["user"];
        $p = $_POST["pass"];

        if($u == "admin" && $p == "admin") {
            $_SESSION["username"] = "admin";
            $_SESSION["loggedin"] = true;
        }
    }

    header("location: index.php");

?>