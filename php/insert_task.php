<?php

require_once('db.php');

$ID_FUNCIONARIO = $_POST['id_funcionario'] ?? '';
$DESCRICAO_PROBLEMA = $_POST['descricao_tarefa'] ?? '';


$stmt = $con->prepare("INSERT INTO agenda (id_funcionario, descricao_tarefa) VALUES(?, ? )");
$stmt->bind_param("is", $ID_FUNCIONARIO, $DESCRICAO_TAREFA);

if ($stmt->execute()) {
} else {
    echo "Deu ruim :(";
}

$stmt->close();
$con->close();
