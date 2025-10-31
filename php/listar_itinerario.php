<?php

require_once('db.php');

// 1. Obter a conexão
$con = get_con();

// 2. Consulta com JOIN (Correta para buscar os nomes)
$query = "SELECT 
            i.id_itinerario, 
            e_origem.nome_estacao AS nome_origem, 
            e_destino.nome_estacao AS nome_destino 
          FROM 
            itinerario AS i 
          JOIN 
            estacao AS e_origem ON i.origem_itinerario = e_origem.id_estacao 
          JOIN 
            estacao AS e_destino ON i.destino_itinerario = e_destino.id_estacao";

// 3. Executar a consulta
$result = mysqli_query($con, $query);

// 4. Verificar e buscar todos os resultados
$itinerarios = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $itinerarios[] = $row;
    }
    mysqli_free_result($result);
} else {
    // Tratar erro de consulta se necessário
    // echo "Erro na consulta: " . mysqli_error($con);
}

// A variável $itinerarios agora contém o array de dados.
// O restante do seu código em itinerary.php continua a usar $itinerarios.