<?php
// CORRIGIDO: O caminho mais robusto para resolver o erro 'Failed to open stream'
require_once(dirname(__DIR__) . '/db.php'); 

// 1. Verificar se os dados do formulário foram submetidos
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../trains.php"); 
    exit();
}

// 2. Validar e sanitizar os dados
$id_trem = filter_input(INPUT_POST, 'id_trem', FILTER_VALIDATE_INT);
$nome_trem = filter_input(INPUT_POST, 'nome_trem', FILTER_SANITIZE_STRING);
$modelo_trem = filter_input(INPUT_POST, 'modelo_trem', FILTER_SANITIZE_STRING);
$infos_trem_input = filter_input(INPUT_POST, 'infos_trem', FILTER_SANITIZE_STRING);
// Garante que NULL seja passado para o banco se o campo estiver vazio
$infos_trem = empty($infos_trem_input) ? NULL : $infos_trem_input; 

// O nome do campo no POST é 'id_funcionario_encarregado', mas ele será mapeado para a coluna 'id_funcionario_encarregado_trem'
$id_funcionario_encarregado = filter_input(INPUT_POST, 'id_funcionario_encarregado', FILTER_VALIDATE_INT); 

// 3. Checagem básica
if (!$id_trem || !$nome_trem || !$modelo_trem || !$id_funcionario_encarregado) {
    header("Location: ../trains.php?status=error_data");
    exit();
}

$con = get_con(); 

// 4. Preparar e executar a query de UPDATE (CORRIGIDO: 'id_funcionario_encarregado_trem')
$query = "UPDATE trens 
          SET nome_trem = ?, 
              modelo_trem = ?, 
              infos_trem = ?, 
              id_funcionario_encarregado_trem = ? 
          WHERE id_trem = ?";

$stmt = $con->prepare($query);

// O bind_param precisa de uma variável não-NULL para o 's'
if ($infos_trem === NULL) {
    $infos_trem_null = NULL; 
    $stmt->bind_param("ssisi", $nome_trem, $modelo_trem, $infos_trem_null, $id_funcionario_encarregado, $id_trem);
} else {
    $stmt->bind_param("ssisi", $nome_trem, $modelo_trem, $infos_trem, $id_funcionario_encarregado, $id_trem);
}


if ($stmt->execute()) {
    header("Location: ../trains.php?status=success_edit"); 
} else {
    header("Location: ../trains.php?status=error_edit&db_error=" . urlencode($stmt->error)); 
}

$stmt->close();
exit();
?>