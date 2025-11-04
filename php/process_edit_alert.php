<?php

include 'db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $con = get_con();

   
    $id_alerta = mysqli_real_escape_string($con, $_POST['id_alerta']);
    $descricao_alerta = mysqli_real_escape_string($con, $_POST['descricao_alerta']);
    $id_funcionario_recebe = mysqli_real_escape_string($con, $_POST['id_funcionario_recebe']);

  
    $query = "UPDATE alerta SET 
                descricao_alerta = '$descricao_alerta',
                id_funcionario_recebe = '$id_funcionario_recebe'
              WHERE id_alerta = '$id_alerta'";

    if (mysqli_query($con, $query)) {
      
        header("Location: alerts.php?status=success_edit&id=" . $id_alerta);
        exit();
    } else {
      
        
        echo "Erro ao atualizar o alerta: " . mysqli_error($con);
        header("Location: alerts.php?status=error_edit");
        exit();
    }
} else {
    header("Location: alerts.php");
    exit();
}