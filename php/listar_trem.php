<?php

require_once('db.php');

$stmt = $con->prepare("SELECT * FROM trens");
$stmt->execute();
$resultado = $stmt->get_result();

$trens = $resultado->FETCH_ALL(MYSQLI_ASSOC);