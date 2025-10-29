<?php

require_once('db.php');

$codigo = $_GET['id'];

$stmt = $con->prepare("DELETE FROM chamados_manutencao WHERE ordem_servico = ?");
$stmt->bind_param("i", $codigo);

if ($stmt->execute()) {
    header("Location: ../index.php?page=maintenance.php");
    exit;
} else {
    echo "Erro ao excluir o chamado: " . $stmt->error;
}

$stmt->close();
$con->close();

?>