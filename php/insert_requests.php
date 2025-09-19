<?php

require_once('db.php');

$ORDEM_SERVICO = $_POST['ordem_servico'];
$NOME_FUNCIONARIO = $_POST['nome_funcionario'];
$CPF_FUNCIONARIO = $_POST['cpf'];
$ID_FUNCIONARIO = $_POST['id_funcionario'];
$TELEFONE_FUNCIONARIO = $_POST['telefone_funcionario'];
$INFO_TREM = $_POST['info_trem'];
$DESCRICAO_PROBLEMA = $_POST['descricao_problema']; 
$TECNICO_RESPONSAVEL = $_POST['tecnico_responsavel'];
$DATA_ENTRADA = $_POST['data_entrada'];
$DATA_SAIDA = $_POST['data_saida'];

$stmt = $con->prepare("INSERT INTO maintenance_requests (ordem_servico, nome_funcionario, cpf_funcionario, id_funcionario, telefone_funcionario, info_trem, descricao_problema, tecnico_responsavel, data_entrada, data_saida) VALUES(?, ? , ?, ?, ?, ?, ?, ? STR_TO_DATE(?) STR_TO_DATE(?))");
$stmt->bind_param(isiiisssss $ORDEM_SERVICO, $NOME_FUNCIONARIO, $CPF_FUNCIONARIO, $ID_FUNCIONARIO, $TELEFONE_FUNCIONARIO, $INFO_TREM, $DESCRICAO_PROBLEMA, $TECNICO_RESPONSAVEL,  $DATA_ENTRADA, $DATA_SAIDA )

if ($stmt -> execute()) {
} else {
echo "Deu ruim :(";
}

$stmt->close();
$con->close();


?>