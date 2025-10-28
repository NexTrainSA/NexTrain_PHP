<?php

require_once('db.php');

$codigo = $_GET['id'];

$stmt = $con->prepare("DELETE FROM alertas WHERE id_alerta = ?");
$stmt->bind_param("i", $codigo);

if ($stmt->execute()) {
    header("Location: maintenence.php");
    exit;
} else {
    echo "Erro ao excluir a estação: " . $stmt->error;
}

$stmt->close();
$con->close();

?>