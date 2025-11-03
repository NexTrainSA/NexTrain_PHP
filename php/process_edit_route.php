<?php

include_once("db.php"); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_rota = $_POST['id_rota'] ?? null;
    $novo_itinerario_rota = $_POST['itinerario_rota'] ?? null;
    
    // --- INÍCIO DA CORREÇÃO ---
    // 1. Pega o caminho_rota como um ARRAY (pois usamos caminho_rota[] no formulário)
    $caminho_array = $_POST['caminho_rota'] ?? []; 

    // 2. Filtra IDs vazios (remover a opção "-- Nenhuma --" se selecionada)
    $caminho_array = array_filter($caminho_array, function($id) {
        return !empty($id);
    });

    // 3. Converte o array de IDs de volta para a string separada por vírgulas que o BD espera
    $novo_caminho_rota = implode(',', $caminho_array); 
    // --- FIM DA CORREÇÃO ---

    // A verificação de dados faltantes precisa ser ajustada, pois o caminho pode ser vazio
    // Se a rota for direta (Origem -> Destino), o $novo_caminho_rota será uma string vazia.
    if (!$id_rota || !$novo_itinerario_rota) {
        header("Location: routes.php?message=erro_dados_faltando");
        exit();
    }
    
    $con = get_con(); 

    // Sanitização
    $id_rota_safe = mysqli_real_escape_string($con, $id_rota);
    $novo_itinerario_rota_safe = mysqli_real_escape_string($con, $novo_itinerario_rota);
    // Sanitiza a nova string de caminho
    $novo_caminho_rota_safe = mysqli_real_escape_string($con, $novo_caminho_rota);


    // Consulta com as variáveis sanitizadas
    $query = "UPDATE rota SET 
              itinerario_rota = '$novo_itinerario_rota_safe', 
              caminho_rota = '$novo_caminho_rota_safe' 
              WHERE id_rota = '$id_rota_safe'";

    $success = mysqli_query($con, $query);

    if ($success) {
        // Redirecionamento de sucesso
        header("Location: ../index.php?page=routes.php&message=edicao_sucesso");
        exit();
    } else {
        // Redirecionamento de erro
        $error_details = mysqli_error($con);
        // CRUCIAL: Mudar o redirecionamento para routes.php
        header("Location: ../index.php?page=routes.php&message=erro_db&details=" . urlencode($error_details));
        exit();
    }

} else {
    // Redirecionamento padrão em caso de acesso direto
    header("Location: ../index.php?page=routes.php");
    exit();
}
?>