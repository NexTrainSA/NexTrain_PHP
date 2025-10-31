<?php

include_once("db.php"); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_rota = $_POST['id_rota'] ?? null;
    $novo_itinerario_rota = $_POST['itinerario_rota'] ?? null;
    $novo_caminho_rota = $_POST['caminho_rota'] ?? null;

    if (!$id_rota || !$novo_itinerario_rota || !$novo_caminho_rota) {
        header("Location: routes.php?message=erro_dados_faltando");
        exit();
    }
    

    $con = get_con(); 


    $id_rota_safe = mysqli_real_escape_string($con, $id_rota);
    $novo_itinerario_rota_safe = mysqli_real_escape_string($con, $novo_itinerario_rota);
    $novo_caminho_rota_safe = mysqli_real_escape_string($con, $novo_caminho_rota);


    $query = "UPDATE rota SET 
              itinerario_rota = '$novo_itinerario_rota_safe', 
              caminho_rota = '$novo_caminho_rota_safe' 
              WHERE id_rota = '$id_rota_safe'";

    $success = mysqli_query($con, $query);

    if ($success) {

        header("Location: ../index.php?page=routes.php&message=edicao_sucesso");
exit();
    } else {
     
        $error_details = mysqli_error($con);
        header("Location: routes.php?message=erro_db&details=" . urlencode($error_details));
        exit();
    }

} else {
    header("Location: ../index.php?page=stations.php");
    exit();
}
?>