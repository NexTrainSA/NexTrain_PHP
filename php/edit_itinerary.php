<?php

include_once("db.php"); 

// 1. Obter o ID da estação da URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID do itinerário não fornecido.");
}

$id_estacao = $_GET['id'];


$con = get_con(); 

$id_estacao_safe = mysqli_real_escape_string($con, $id_itinerario); 

$query = "SELECT origem_itinerario, destino_itinerario FROM itinerario WHERE id_itinerario = '$id_itinerario_safe'";
$result = mysqli_query($con, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Itinerário não encontrado ou erro na consulta.");
}

$estacao = mysqli_fetch_assoc($result);
mysqli_free_result($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Editar origem: <?php echo htmlspecialchars($itinerario['origem_itinerario']); ?></title>
</head>
<body>
    <main class="edit-container">
        <h1>Editar Estação: <?php echo htmlspecialchars($itinerario['origem_itinerario']); ?></h1>
        
        <form action="php/process_edit_station.php" method="POST">
            <input type="hidden" name="id_itinerario" value="<?php echo htmlspecialchars($id_itinerario); ?>">

            <label for="origem_itinerario">Nome da Origem:</label>
            <md-outlined-text-field 
                id="origem_itinerario" 
                name="origem_itinerario" 
                value="<?php echo htmlspecialchars($estacao['origem_itinerario']); ?>" 
                required>
            </md-outlined-text-field>
            
            <label for="destino_itinerario">Status:</label>
            <select id="status_estacao" name="status_estacao" required>
                <option value="OPEN" <?php if ($estacao['status_estacao'] == 'aberta') echo 'selected'; ?>>ABERTA</option>
                <option value="PERMANENTLY_CLOSED" <?php if ($estacao['status_estacao'] == 'fechada') echo 'selected'; ?>>FECHADA </option>
                <option value="UNKNOWN" <?php if ($estacao['status_estacao'] == 'unknown') echo 'selected'; ?>> DESCONHECIDO </option>
                <option value="MAINTENANCE" <?php if ($estacao['status_estacao'] == 'manutencao') echo 'selected'; ?>>MANUTENÇÃO </option>
            </select>
            
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