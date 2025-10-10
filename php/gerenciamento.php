<?php

require_once('db.php');

$ID_TREM = $_POST['id_trem'] ?? '';
$NOME_TREM = $_POST['nome_trem'] ?? '';
$MODELO_TREM = $_POST['modelo_trem'] ?? '';
$CAPACIDADE = $_POST['capacidade'] ?? '';
$ANO_FABRICACAO = $_POST['ano_fabricacao'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar'])) {
    $stmt = $con->prepare("INSERT INTO trens (id_trem, nome_trem, modelo_trem, capacidade, ano_fabricacao) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issii", $ID_TREM, $NOME_TREM, $MODELO_TREM, $CAPACIDADE, $ANO_FABRICACAO);

    if ($stmt->execute()) {
    } else {
        echo "erro ao cadastrar trem.";
    }

    $stmt->close();
    $con->close();

    header("Location: ../html/gerenciamento.html");
    exit;
}

//Informações do trem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    $stmt = $con->prepare("UPDATE trens SET nome_trem=?, modelo_trem=?, capacidade=?, ano_fabricacao=? WHERE id_trem=?");
    $stmt->bind_param("ssiii", $NOME_TREM, $MODELO_TREM, $CAPACIDADE, $ANO_FABRICACAO, $ID_TREM);

    if ($stmt->execute()) {
    } else {
        echo "erro ao atualizar trem.";
    }

    $stmt->close();
    $con->close();

    header("Location: ../html/gerenciamento.html");
    exit;
}

// Exemplo de remoção de trem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remover'])) {
    $stmt = $con->prepare("DELETE FROM trens WHERE id_trem=?");
    $stmt->bind_param("i", $id_trem);

    if ($stmt->execute()) {
    } else {
        echo "erro ao remover trem.";
    }

    $stmt->close();
    $con->close();

    header("Location: ../html/gerenciamento.html");
    exit;
}
