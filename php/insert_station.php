<?php
require_once('db.php');

$NOME_ESTACAO = $_POST['nome_estacao'] ?? '';
$STATUS_ESTACAO = $_POST['status_estacao'] ?? '';
$CONNECTIONS = $_POST['connections'] ?? [];

$stmt = $con->prepare("INSERT INTO estacao (nome_estacao, status_estacao) VALUES(?, ?)");
$stmt->bind_param("ss", $NOME_ESTACAO, $STATUS_ESTACAO);

if ($stmt->execute()) {
} else {
    echo "Deu ruim :(";
}
$id_estacao = $stmt->insert_id;

$stmt->close();

foreach ($CONNECTIONS as $id_connection) {

    $stmt = $con->prepare("INSERT INTO arestas_grafo_estacoes (id_estacao1, id_estacao2) VALUES(?, ?), (?, ?)");
    $stmt->bind_param("iiii", $id_estacao, $id_connection, $id_connection, $id_estacao);

    if ($stmt->execute()) {
    } else {
        echo "Deu ruim :(";
    }
    $stmt->close();
}

$con->close();

header("Location: stations.php");
