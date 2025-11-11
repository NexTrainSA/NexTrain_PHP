<?php

require_once('../db.php'); 


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../trains.php"); 
    exit();
}


$id_trem = filter_input(INPUT_POST, 'id_trem', FILTER_VALIDATE_INT);
$nome_trem = filter_input(INPUT_POST, 'nome_trem', FILTER_SANITIZE_STRING);
$modelo_trem = filter_input(INPUT_POST, 'modelo_trem', FILTER_SANITIZE_STRING);

$infos_trem_input = filter_input(INPUT_POST, 'infos_trem', FILTER_SANITIZE_STRING);
$infos_trem = empty($infos_trem_input) ? NULL : $infos_trem_input; 

$id_funcionario_encarregado = filter_input(INPUT_POST, 'id_funcionario_encarregado', FILTER_VALIDATE_INT);

if (!$id_trem || !$nome_trem || !$modelo_trem || !$id_funcionario_encarregado) {
   
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


if ($infos_trem === NULL) {
   
    $stmt->bind_param("sssii", $nome_trem, $modelo_trem, $infos_trem_null, $id_funcionario_encarregado, $id_trem);
    $infos_trem_null = NULL; 
} else {
    $stmt->bind_param("sssii", $nome_trem, $modelo_trem, $infos_trem, $id_funcionario_encarregado, $id_trem);
}


if ($stmt->execute()) {
    
    header("Location: ../trains.php?status=success_edit"); 
} else {
    
    header("Location: ../trains.php?status=error_edit&db_error=" . urlencode($stmt->error)); 
}

$stmt->close();


exit();
?>