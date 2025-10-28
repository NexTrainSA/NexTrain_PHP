<?php

require_once('db.php');

$FUNCIONARIO_MANDA = $_POST['funcionario_manda'] ?? '';
$FUNCIONARIO_RECEBE = $_POST['funcionario_recebe'] ?? '';
$DESCRICAO = $_POST['descricao'] ?? '';

$stmt = $con->prepare("INSERT INTO alertas (id_funcionario, id_funcionario_recebe, descricao_alerta) VALUES(?, ?, ?)");
$stmt->bind_param("iis", $FUNCIONARIO_MANDA, $FUNCIONARIO_RECEBE, $DESCRICAO);

if ($stmt->execute()) {
} else {
    echo "Deu ruim :(";
}

$stmt->close();
$con->close();

header("Location: maintenance.php");
