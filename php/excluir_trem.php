<?php

require_once('db.php');

$codigo = $_GET['id'];

$stmt = $con->prepare("DELETE FROM trens WHERE id_trem = ?");
$stmt->bind_param("i", $codigo);

if ($stmt->execute()) {
    header("Location: listar_trem.php");
    exit;
} else {
    echo "Erro ao excluir o trem: " . $stmt->error;
}

$stmt->close();
$con->close();

?>