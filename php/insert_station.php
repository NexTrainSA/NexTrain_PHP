<?php

require_once('db.php');

$NOME_ESTACAO = $_POST['nome_estacao'] ?? '';
$STATUS_ESTACAO = $_POST['status_estacao'] ?? '';

$stmt = $con->prepare("INSERT INTO estacao (nome_estacao, status_estacao) VALUES(?, ?)");
$stmt->bind_param("ss", $NOME_ESTACAO, $STATUS_ESTACAO);

if ($stmt->execute()) {
} else {
    echo "Deu ruim :(";
}

$stmt->close();
$con->close();

header("Location: ../html/index.html");
