<?php

require_once('db.php');

$codigo = $_GET['id'];

$stmt = $con->prepare("DELETE FROM estacao WHERE id_estacao = ?");
$stmt->bind_param("i", $codigo);
$redirect = $_GET['redirect'] ?? 'stations.php';


if ($stmt->execute()) {
    header("Location: $redirect");
    exit;
} else {
    echo "Erro ao excluir a estação: " . $stmt->error;
}

$stmt->close();
$con->close();

?>