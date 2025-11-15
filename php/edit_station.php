<?php

include_once("db.php"); 

// 1. Obter o ID da estação da URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID da estação não fornecido.");
}

$id_estacao = $_GET['id'];


$con = get_con(); 

$id_estacao_safe = mysqli_real_escape_string($con, $id_estacao); 

$query = "SELECT nome_estacao, status_estacao FROM estacao WHERE id_estacao = '$id_estacao_safe'";
$result = mysqli_query($con, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Estação não encontrada ou erro na consulta.");
}

$estacao = mysqli_fetch_assoc($result);
mysqli_free_result($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Editar Estação: <?php echo htmlspecialchars($estacao['nome_estacao']); ?></title>
</head>
<body>
    <section class ="dashboard-container">
    <main class="edit-container">
        <h1>Editar Estação: <?php echo htmlspecialchars($estacao['nome_estacao']); ?></h1>
        
        <form action="php/process_edit_station.php" method="POST">
            <input type="hidden" name="id_estacao" value="<?php echo htmlspecialchars($id_estacao); ?>">

            <label for="nome_estacao">Nome da Estação:</label>
            <md-outlined-text-field 
                id="nome_estacao" 
                name="nome_estacao" 
                value="<?php echo htmlspecialchars($estacao['nome_estacao']); ?>" 
                required>
            </md-outlined-text-field>

            <label for="status_estacao">Status:</label>
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
    </section>
</body>
</html>