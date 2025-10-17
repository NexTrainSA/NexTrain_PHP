<?php

require_once('db.php');

$stmt = $con->prepare("SELECT * FROM itinerario");
$stmt->execute();
$resultado = $stmt->get_result();

$itinerarios = $resultado->FETCH_ALL(MYSQLI_ASSOC);
