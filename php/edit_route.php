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
$query_rota = "SELECT itinerario_rota, caminho_rota FROM rota WHERE id_rota = '$id_rota_safe'";
$result_rota = mysqli_query($con, $query_rota);

if (!$result_rota || mysqli_num_rows($result_rota) === 0) {
    die("Rota não encontrada ou erro na consulta.");
}
$rota = mysqli_fetch_assoc($result_rota);
mysqli_free_result($result_rota);


// 3. Buscar TODOS os Itinerários para o SELECT
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
$itinerarios = $result_itinerarios ? mysqli_fetch_all($result_itinerarios, MYSQLI_ASSOC) : [];
if ($result_itinerarios) {
    mysqli_free_result($result_itinerarios);
}

// 4. Buscar TODAS as Estações para um possível SELECT de estação intermediária
$query_estacoes = "SELECT id_estacao, nome_estacao FROM estacao ORDER BY nome_estacao ASC";
$result_estacoes = mysqli_query($con, $query_estacoes);
$estacoes = $result_estacoes ? mysqli_fetch_all($result_estacoes, MYSQLI_ASSOC) : [];
if ($result_estacoes) {
    mysqli_free_result($result_estacoes);
}

// O ID da(s) estação(ões) intermediária(s) atual(is)
$caminho_ids = array_filter(explode(',', $rota['caminho_rota']));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Rota: <?php echo htmlspecialchars($id_rota); ?></title>
</head>

<body>
    <section class="dashboard-container">
        <main class="edit-container">
            <h1>Editar Rota: <?php echo htmlspecialchars($id_rota); ?></h1>

            <form action="php/process_edit_route.php" method="POST">
                <input type="hidden" name="id_rota" value="<?php echo htmlspecialchars($id_rota); ?>">

                <label for="itinerario_rota">Indique o terminal em que está e o seu destino : </label>
                <md-outlined-select id="itinerario_rota" name="itinerario_rota" required>
                    <?php
                    // Lógica para preencher e pré-selecionar o Itinerário (correto)
                    if (empty($itinerarios)) {
                        echo '<md-select-option value="" disabled selected><div slot="headline">Nenhum itinerário encontrado</div></md-select-option>';
                    } else {
                        foreach ($itinerarios as $itinerario) {
                            $display_name = "Itinerário {$itinerario['id_itinerario']} ({$itinerario['nome_origem']} -> {$itinerario['nome_destino']})";
                            $selected = ($rota['itinerario_rota'] == $itinerario['id_itinerario']) ? 'selected' : '';

                            echo "<md-select-option value=\"{$itinerario['id_itinerario']}\" {$selected}>
                            <div slot=\"headline\">{$display_name}</div>
                          </md-select-option>";
                        }
                    }
                    ?>
                </md-outlined-select>

                <?php
                if (empty($caminho_ids)) {
                    // Se não há estações intermediárias, exibe um campo vazio para adição
                    $caminho_ids = ['']; // Adiciona um campo de seleção vazio
                }

                foreach ($caminho_ids as $index => $current_id) {
                    // O nome do campo é crucial: 'caminho_rota[]' transforma em um array no POST
                    $field_name = "caminho_rota[]";
                    $field_label = "Estação entre o caminho" . ($index + 1);

                    echo "<label for='interm_{$index}'>{$field_label}:</label>";
                    echo "<md-outlined-select id='interm_{$index}' name='{$field_name}' data-index='{$index}'>";

                    // Opção vazia (Permite remover a estação)
                    echo '<md-select-option value=""><div slot="headline">Nenhuma</div></md-select-option>';

                    // Opções com todas as estações
                    foreach ($estacoes as $estacao) {
                        $selected = (string)$current_id === (string)$estacao['id_estacao'] ? 'selected' : '';

                        echo "<md-select-option value=\"{$estacao['id_estacao']}\" {$selected}>
                            <div slot=\"headline\">{$estacao['nome_estacao']}</div>
                          </md-select-option>";
                    }
                    echo "</md-outlined-select>";
                }
                ?>
                <md-filled-button type="submit">
                    <md-icon slot="icon">save</md-icon>
                    Salvar Alterações
                </md-filled-button>

                <md-outlined-button type="button" onclick="window.history.back()">
                    Cancelar
                </md-outlined-button>
            </form>
        </main>
    </section>
</body>

</html>