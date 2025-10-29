<?php

include_once("db.php"); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $id_estacao = $_POST['id_estacao'] ?? null;
    $novo_nome = $_POST['nome_estacao'] ?? null;
    $novo_status = $_POST['status_estacao'] ?? null;

    if (!$id_estacao || !$novo_nome || !$novo_status) {
        header("Location: station.php?message=erro_dados_faltando");
        exit();
    }
    

    $con = get_con(); 


    $id_estacao_safe = mysqli_real_escape_string($con, $id_estacao);
    $novo_nome_safe = mysqli_real_escape_string($con, $novo_nome);
    $novo_status_safe = mysqli_real_escape_string($con, $novo_status);

   
    $query = "UPDATE estacao SET 
              nome_estacao = '$novo_nome_safe', 
              status_estacao = '$novo_status_safe' 
              WHERE id_estacao = '$id_estacao_safe'";
              
    $success = mysqli_query($con, $query);

    if ($success) {
      
        header("Location:../index.php?page=stations.php");
        exit();
    } else {
     
        $error_details = mysqli_error($con);
        header("Location: station.php?message=erro_db&details=" . urlencode($error_details));
        exit();
    }

} else {
    header("Location: ../index.php?page=stations.php");
    exit();
}
?>