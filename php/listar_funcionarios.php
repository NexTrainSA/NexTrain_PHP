<?php

require_once('db.php');

$stmt = $con->prepare("SELECT id_usuario, username_usuario FROM usuario");
$stmt->execute();
$resultado = $stmt->get_result();

$funcionarios = $resultado->FETCH_ALL(MYSQLI_ASSOC);
