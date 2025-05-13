<?php

    $db_name = "nextrain_production";
    $db_user = "nextrain";
    $db_pass = ini_get('nt_db_pass');
    $db_host = ini_get('nt_db_host');
    $db_port = 6306;

    $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

    if(!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>