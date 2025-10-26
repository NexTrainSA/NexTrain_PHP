<?php

require_once('conexao.php');

$codigo = $_GET['codigo'];

$stmt = $conexao->prepare("DELETE FROM estacao WHERE id_estacao = ?");
$stmt->bind_param("i", $codigo);

if ($stmt->execute()) {
    header("Location: stations.html");
    exit;
} else {
    echo "Erro ao excluir a atividade: " . $stmt->error;
}

$stmt->close();
$conexao->close();

?>