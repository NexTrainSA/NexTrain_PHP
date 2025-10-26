<?php

require_once('db.php');

$codigo = $_GET['codigo'];

$stmt = $con->prepare("DELETE FROM rota WHERE id_trem = ?");
$stmt->bind_param("i", $codigo);

if ($stmt->execute()) {
    header("Location: ../html/trains.html");
    exit;
} else {
    echo "Erro ao excluir o trem: " . $stmt->error;
}

$stmt->close();
$con->close();

?>