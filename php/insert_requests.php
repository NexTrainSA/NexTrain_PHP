<?php
require_once('db.php');

// Coleta dos dados enviados pelo formulário
$NOME_FUNCIONARIO = $_POST['nome'];
$CPF_FUNCIONARIO = $_POST['cpf'];
$ID_FUNCIONARIO = $_POST['funcionario'];
$TELEFONE_FUNCIONARIO = $_POST['telefone'];
$ID_TREM  = $_POST['trem'];
$DESCRICAO_PROBLEMA = $_POST['descricao'];
$TECNICO_RESPONSAVEL = $_POST['tecnico'];
$DATA_ENTRADA = $_POST['dataEntrada'];
$DATA_SAIDA = $_POST['dataSaida'];

$sql = "INSERT INTO chamados_manutencao 
(nome_funcionario, cpf_funcionario, id_funcionario, telefone_funcionario, 
id_trem, descricao_problema, tecnico_responsavel, data_entrada, data_saida)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepara e executa
$stmt = $con->prepare($sql);
$stmt->bind_param(
    "ssiiissss",
    $NOME_FUNCIONARIO,
    $CPF_FUNCIONARIO,
    $ID_FUNCIONARIO,
    $TELEFONE_FUNCIONARIO,
    $ID_TREM,
    $DESCRICAO_PROBLEMA,
    $TECNICO_RESPONSAVEL,
    $DATA_ENTRADA,
    $DATA_SAIDA
);

if ($stmt->execute()) {
    header("Location: ../html/maintenance.html");
    exit;
} else {
    echo "Erro ao inserir: " . $stmt->error;
}

$stmt->close();
$con->close();
?>
