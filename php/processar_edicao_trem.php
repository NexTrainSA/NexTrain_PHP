<?php


require_once('../db.php');


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../trains.php");
    exit();
}


$id_trem = filter_input(INPUT_POST, 'id_trem', FILTER_VALIDATE_INT);
$nome_trem = filter_input(INPUT_POST, 'nome_trem', FILTER_SANITIZE_STRING);
$modelo_trem = filter_input(INPUT_POST, 'modelo_trem', FILTER_SANITIZE_STRING);


$id_funcionario_encarregado_trem = filter_input(INPUT_POST, 'id_funcionario_encarregado_trem', FILTER_VALIDATE_INT);

$infos_trem_input = filter_input(INPUT_POST, 'infos_trem', FILTER_SANITIZE_STRING);

$infos_trem = empty($infos_trem_input) ? null : $infos_trem_input;


if (!$id_trem || !$nome_trem || !$modelo_trem || !$id_funcionario_encarregado_trem) {

    header("Location: ../trains.php?status=error_data");
    exit();
}


$con = get_con();


$query = "UPDATE trens 
          SET nome_trem = ?, 
              modelo_trem = ?, 
              infos_trem = ?, 
              id_funcionario_encarregado_trem = ? 
          WHERE id_trem = ?";

$stmt = $con->prepare($query);


$stmt->bind_param(
    "sssii",
    $nome_trem,
    $modelo_trem,
    $infos_trem,
    $id_funcionario_encarregado_trem,
    $id_trem
);



if ($stmt->execute()) {

    header("Location: ../trains.php?status=success_edit");
} else {

    header("Location: ../trains.php?status=error_edit&db_error=" . urlencode($stmt->error));
}

$stmt->close();

if (isset($con)) {
    $con->close();
}

exit();
