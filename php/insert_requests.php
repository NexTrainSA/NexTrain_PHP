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

$stmt = $con->prepare("INSERT INTO maintenance_requests (nome, fk_funcionario, telefone, fk_trem, data_entrada, data_prevista_saida, descrição, fk_funcionario_tecnico) VALUES(?, ? , ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(sisisssi, $nomeFuncionario, $idFuncionario)

if ($stmt -> execute()) {
} else {
echo "Deu ruim :(";
}

$stmt->close();
$con->close();


?>