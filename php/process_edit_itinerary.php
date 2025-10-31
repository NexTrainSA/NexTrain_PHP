<?php

include_once("db.php"); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_itinerario = $_POST['id_itinerario'] ?? null;
    $nova_origem = $_POST['origem_itinerario'] ?? null;
    $novo_destino = $_POST['destino_itinerario'] ?? null;

    if (!$id_itinerario || !$nova_origem || !$novo_destino) {
        header("Location: itinerary.php?message=erro_dados_faltando");
        exit();
    }
    

    $con = get_con(); 


    $id_itinerario_safe = mysqli_real_escape_string($con, $id_itinerario);
    $nova_origem_safe = mysqli_real_escape_string($con, $nova_origem);
    $novo_destino_safe = mysqli_real_escape_string($con, $novo_destino);


    $query = "UPDATE itinerario SET 
              origem_itinerario = '$nova_origem_safe', 
              destino_itinerario = '$novo_destino_safe' 
              WHERE id_itinerario = '$id_itinerario_safe'";

    $success = mysqli_query($con, $query);

    if ($success) {

        header("Location: ../index.php?page=itinerary.php&message=edicao_sucesso");
exit();
    } else {
     
        $error_details = mysqli_error($con);
        header("Location: itinerary.php?message=erro_db&details=" . urlencode($error_details));
        exit();
    }

} else {
    header("Location: ../index.php?page=stations.php");
    exit();
}
?>