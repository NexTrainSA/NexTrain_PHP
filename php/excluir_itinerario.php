<?php

require_once('db.php');

$codigo = $_GET['id'];

$stmt = $con->prepare("DELETE FROM rota WHERE id_itinerario = ?");
$stmt->bind_param("i", $codigo);

if ($stmt->execute()) {
    header("Location: itinerary.php");
    exit;
} else {
    echo "Erro ao excluir a rota: " . $stmt->error;
}

$stmt->close();
$con->close();

?>