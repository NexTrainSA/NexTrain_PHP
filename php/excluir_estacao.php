<?php

require_once('db.php');

$codigo = $_GET['id'];

$stmt = $con->prepare("DELETE FROM estacao WHERE id_estacao = ?");
$stmt->bind_param("i", $codigo);

if ($stmt->execute()) {
    header("Location: ../html/stations.html");
    exit;
} else {
    echo "Erro ao excluir a estação: " . $stmt->error;
}

$stmt->close();
$con->close();

?>