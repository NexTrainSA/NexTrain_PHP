<?php
require_once('db.php');

session_start();

if (!isset($_SESSION["conectado"]) || $_SESSION["conectado"] != true) {
    header("Location: ../html/stations.html");
    exit;
}

$pk_estacao = $_POST['pkEstacao'] ?? '';
$nome_estacao = trim($_POST['nome_estacao'] ?? '');

$stmt = $conexao->prepare("UPDATE estacao SET nome_estacao = ? WHERE pk_estacao = ? AND fk_professor = ?");
$stmt->bind_param("sii", $nome_estacao, $pk_estacao, $_SESSION['id_estacao']);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: ../html/stations.html?sucesso=editado");
        exit;
    } else {
        echo "Nenhuma alteração realizada. Verifique se a estação existe.";
    }
} else {
    echo "Erro ao editar: " . $stmt->error;
}

$stmt->close();
$conexao->close();

?>