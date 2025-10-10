<?php

require_once('db.php');

$ID_FUNCIONARIO = $_POST['funcionario'] ?? '';
$ID_TREM = $_POST['trem'] ?? '';
$DESCRICAO_PROBLEMA = $_POST['descricao'] ?? '';
$DATA_ENTRADA = $_POST['dataEntrada'] ?? '';

$stmt = $con->prepare("INSERT INTO chamados_manutencao (id_funcionario, id_trem, descricao_problema, data_entrada) VALUES(?, ?, ?, ?)");
$stmt->bind_param("iiss", $ID_FUNCIONARIO, $ID_TREM, $DESCRICAO_PROBLEMA, $DATA_ENTRADA);

if ($stmt->execute()) {
} else {
    echo "Deu ruim :(";
}

$stmt->close();
$con->close();

header("Location: ../html/maintenance.html");
