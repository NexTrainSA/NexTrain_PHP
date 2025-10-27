<?php

require_once('db.php');

session_start();

session_unset();

session_destroy();

header("Location: ../html/stations.html");

?>