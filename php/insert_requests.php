<?php

require_once('db.php');

$NOME_FUNCIONARIO = $_POST['nome'] ?? '';
$CPF_FUNCIONARIO = $_POST['cpf'] ?? '';
$ID_FUNCIONARIO = $_POST['funcionario'] ?? '';
$TELEFONE_FUNCIONARIO = $_POST['telefone'] ?? '';
$ID_TREM = $_POST['trem'] ?? '';
$DESCRICAO_PROBLEMA = $_POST['descricao'] ?? '';
$TECNICO_RESPONSAVEL = $_POST['tecnico'] ?? '';
$DATA_ENTRADA = $_POST['dataEntrada'] ?? '';
$DATA_SAIDA = $_POST['dataSaida'] ?? '';

$stmt = $con->prepare("INSERT INTO chamados_manutencao (nome_funcionario, cpf_funcionario, id_funcionario, telefone_funcionario, id_trem, descricao_problema, data_entrada, data_saida) VALUES(?, ?, ?, ?, ?, ? STR_TO_DATE(?) STR_TO_DATE(?))");
$stmt->bind_param("siiiisss", $NOME_FUNCIONARIO, $CPF_FUNCIONARIO, $ID_FUNCIONARIO, $TELEFONE_FUNCIONARIO, $ID_TREM, $DESCRICAO_PROBLEMA, $DATA_ENTRADA, $DATA_SAIDA);

if ($stmt->execute()) {
} else {
    echo "Deu ruim :(";
}

$stmt->close();
$con->close();

header("Location: ../html/maintenance.html");