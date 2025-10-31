<?php

include_once("db.php"); 
$con = get_con(); 

// 1. Obter e Sanitizar ID da Rota
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID da rota não fornecido.");
}
$id_rota = $_GET['id'];
$id_rota_safe = mysqli_real_escape_string($con, $id_rota); 

// 2. Buscar dados ATUAIS da ROTA
// Buscando os campos 'itinerario_rota' (ID) e 'caminho_rota' (String de IDs)
$query_rota = "SELECT itinerario_rota, caminho_rota FROM rota WHERE id_rota = '$id_rota_safe'";
$result_rota = mysqli_query($con, $query_rota);

if (!$result_rota || mysqli_num_rows($result_rota) === 0) {
    die("Rota não encontrada ou erro na consulta.");
}
$rota = mysqli_fetch_assoc($result_rota);
mysqli_free_result($result_rota);


// 3. Buscar TODOS os Itinerários para o SELECT
// Usamos JOINs para buscar o nome das estações de Origem e Destino do itinerário
$query_itinerarios = "SELECT 
                        i.id_itinerario, 
                        e_origem.nome_estacao AS nome_origem, 
                        e_destino.nome_estacao AS nome_destino 
                      FROM 
                        itinerario AS i 
                      JOIN 
                        estacao AS e_origem ON i.origem_itinerario = e_origem.id_estacao 
                      JOIN 
                        estacao AS e_destino ON i.destino_itinerario = e_destino.id_estacao";
                        
$result_itinerarios = mysqli_query($con, $query_itinerarios);
// Se houver erro, inicializa como array vazio para não quebrar a página
$itinerarios = $result_itinerarios ? mysqli_fetch_all($result_itinerarios, MYSQLI_ASSOC) : [];
if ($result_itinerarios) {
    mysqli_free_result($result_itinerarios);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Rota: <?php echo htmlspecialchars($id_rota); ?></title>
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    </head>
<body>
    <main class="edit-container">
        <h1>Editar Rota: <?php echo htmlspecialchars($id_rota); ?></h1> 

        <form action="php/process_edit_route.php" method="POST">
            <input type="hidden" name="id_rota" value="<?php echo htmlspecialchars($id_rota); ?>">
            
            <label for="itinerario_rota">Itinerário Associado:</label>
            <md-outlined-select id="itinerario_rota" name="itinerario_rota" required>
            <?php
            if (empty($itinerarios)) {
                echo '<md-select-option value="" disabled selected><div slot="headline">Nenhum itinerário encontrado</div></md-select-option>';
            } else {
                foreach($itinerarios as $itinerario) {
                    // Monta o nome de exibição: Itinerário X (Origem -> Destino)
                    $display_name = "Itinerário {$itinerario['id_itinerario']} ({$itinerario['nome_origem']} -> {$itinerario['nome_destino']})";
                    
                    // CRUCIAL: Pré-selecionar o itinerário atual
                    $selected = ($rota['itinerario_rota'] == $itinerario['id_itinerario']) ? 'selected' : '';
                    
                    echo "<md-select-option value=\"{$itinerario['id_itinerario']}\" {$selected}>
                            <div slot=\"headline\">{$display_name}</div>
                          </md-select-option>";
                }
            }
            ?>
            </md-outlined-select>

            <label for="caminho_rota">Estações do Caminho (IDs separados por vírgula):</label>
            <md-outlined-text-field 
                id="caminho_rota" 
                name="caminho_rota" 
                value="<?php echo htmlspecialchars($rota['caminho_rota']); ?>" 
                required
                placeholder="Ex: 10,12,15">
            </md-outlined-text-field>
            
            <md-filled-button type="submit">
                <md-icon slot="icon">save</md-icon>
                Salvar Alterações
            </md-filled-button>

            <md-outlined-button type="button" onclick="window.history.back()">
                Cancelar
            </md-outlined-button>
        </form>
    </main>
</body>
</html>