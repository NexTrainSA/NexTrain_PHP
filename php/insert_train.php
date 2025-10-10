<?php

require_once('db.php');

$NOME_TREM = $_POST['nome-trem'] ?? '';
$ID_FUNCIONARIO_ENCARREGADO_TREM = $_POST['id-funcionario'] ?? '';
$MODELO_TREM = $_POST['modelo-trem'] ?? '';
$INFOS_TREM = $_POST['infos-trem'] ?? '';

$stmt = $con->prepare("INSERT INTO trens (nome_trem, id_funcionario_encarregado_trem, modelo_trem, infos_trem) VALUES(?, ?, ?, ?)");
$stmt->bind_param("siss", $NOME_TREM, $ID_FUNCIONARIO_ENCARREGADO_TREM, $MODELO_TREM, $INFOS_TREM);

if ($stmt->execute()) {
} else {
    echo "Deu ruim :(";
}

$stmt->close();
$con->close();

header("Location: ../html/trains.html");
