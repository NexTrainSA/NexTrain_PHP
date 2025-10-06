<?php

require_once('db.php');

$NOME_FUNCIONARIO = $_POST['nome_funcionario'];
$CPF_FUNCIONARIO = $_POST['cpf_funcionario'];
$ID_FUNCIONARIO = $_POST['id_funcionario'];
$TELEFONE_FUNCIONARIO = $_POST['telefone_funcionario'];
$ID_TREM = $_POST['id_trem'];
$DESCRICAO_PROBLEMA = $_POST['descricao_problema'];
$DATA_ENTRADA = $_POST['data_entrada'];
$DATA_SAIDA = $_POST['data_saida'];

$stmt = $con->prepare("INSERT INTO maintenance_requests (nome_funcionario, cpf_funcionario, id_funcionario, telefone_funcionario, id_trem, descricao_problema, data_entrada, data_saida) VALUES(?, ? , ?, ?, ?, ?, ?, ? STR_TO_DATE(?) STR_TO_DATE(?))");
$stmt->bind_param("siiiisss", $NOME_FUNCIONARIO, $CPF_FUNCIONARIO, $ID_FUNCIONARIO, $TELEFONE_FUNCIONARIO, $ID_TREM, $DESCRICAO_PROBLEMA, $DATA_ENTRADA, $DATA_SAIDA );

if ($stmt -> execute()) {
} else {
echo "Deu ruim :(";
}

$stmt->close();
$con->close();


?>