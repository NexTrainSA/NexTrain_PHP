<?php

require_once('db.php');

$id_itinerario = $_GET['id_itinerario'] ?? '';

$stmt = $con->prepare("SELECT origem_itinerario FROM itinerario WHERE id_itinerario = ?;");
$stmt->bind_param("i", $id_itinerario);
$stmt->execute();
$resultado = $stmt->get_result();
$connections = $resultado->FETCH_ALL(MYSQLI_ASSOC);

echo $connections[0]['origem_itinerario'];