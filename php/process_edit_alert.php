<?php


include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $con = get_con(); 

   
    $id_alerta = trim($_POST['id_alerta']);
    $descricao_alerta = trim($_POST['descricao_alerta']);
    $id_funcionario_recebe = trim($_POST['id_funcionario_recebe']);

   
    if (!filter_var($id_alerta, FILTER_VALIDATE_INT) || !filter_var($id_funcionario_recebe, FILTER_VALIDATE_INT)) {
       
        header("Location: alerts.php?status=error_validation");
        exit();
    }
    
   
    $query = "UPDATE alertas SET 
                descricao_alerta = ?,
                id_funcionario_recebe = ?
              WHERE id_alerta = ?";

    $stmt = $con->prepare($query);

    if ($stmt === false) {
        
        error_log("Erro na preparação do statement: " . $con->error);
        header("Location: alerts.php?status=error_prepare");
        exit();
    }

   
    $stmt->bind_param("sii", $descricao_alerta, $id_funcionario_recebe, $id_alerta);

    if ($stmt->execute()) {
       
        $stmt->close();
        $con->close();
        header("Location: alerts.php?status=success_edit");
        exit();
    } else {
        
        error_log("Erro na execução da atualização: " . $stmt->error);
        $stmt->close();
        $con->close();
        header("Location: alerts.php?status=error_edit");
        exit();
    }
} else {
    
    header("Location: alerts.php");
    exit();
}
?>