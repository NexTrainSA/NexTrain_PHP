<?php

include_once("db.php"); 

// 1. Obter o ID da estação da URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID do itinerário não fornecido.");
}

$id_itinerario = $_GET['id'];


$con = get_con(); 

$id_itinerario_safe = mysqli_real_escape_string($con, $id_itinerario); 

$query = "SELECT origem_itinerario, destino_itinerario FROM itinerario WHERE id_itinerario = '$id_itinerario_safe'";
$result = mysqli_query($con, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Itinerário não encontrado ou erro na consulta.");
}

$itinerario = mysqli_fetch_assoc($result);
mysqli_free_result($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Editar origem: <?php echo htmlspecialchars($itinerario['origem_itinerario']); ?></title>
</head>
<body>
    <section class="dashboard-container">
    <main class="edit-container">


        <h1>Editar Itinerário: <?php echo htmlspecialchars($itinerario['origem_itinerario']); ?></h1>

        <form action="php/process_edit_itinerary.php" method="POST">
            <input type="hidden" name="id_itinerario" value="<?php echo htmlspecialchars($id_itinerario); ?>">
        <label for="origem_itinerario">Nome da Origem:</label>

        <md-outlined-select id="origem_itinerario" name="origem_itinerario">
        <?php
            include_once("php/listar_estacao.php");

            foreach($estacoes as $estacao) {
                echo '<md-select-option value="'.htmlspecialchars($estacao['id_estacao']).'">
                    <div slot="headline">'.htmlspecialchars($estacao['nome_estacao']).'</div>
                </md-select-option>';
            }
        ?>

        </md-outlined-select>
        
        <label for="destino_itinerario">Nome do Destino:</label>
        <md-outlined-select id="destino_itinerario" name="destino_itinerario">
        <?php

            foreach($estacoes as $estacao) {
                echo '<md-select-option value="'.htmlspecialchars($estacao['id_estacao']).'">
                    <div slot="headline">'.htmlspecialchars($estacao['nome_estacao']).'</div>
                </md-select-option>';
            }
        ?>

        </md-outlined-select>
            
            <md-filled-button type="submit">
                <md-icon slot="icon">save</md-icon>
                Salvar Alterações
            </md-filled-button>

            <md-outlined-button type="button" onclick="window.history.back()">
                Cancelar
            </md-outlined-button>
        </form>
    </main></section>
</body>
</html>