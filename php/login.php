<?php

    session_start();

    if(isset($_POST["user"]) && isset($_POST["pass"])) {
        $u = $_POST["user"];
        $p = $_POST["pass"];

        $q = mysqli_query($con,"SELECT * FROM usuario WHERE username_usuario = '$u' AND senha_usuario = '".md5($p)."' LIMIT 1;");
        
        if(mysqli_num_rows($q) > 0) {
            $_SESSION["username"] = $u;
            $_SESSION["loggedin"] = true;
        }
    }

    header("location: index.php");

?>