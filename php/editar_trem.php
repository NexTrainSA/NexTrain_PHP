<?php
require_once('db.php'); 

$con = get_con(); 

// 1. Buscar o ID do Trem na URL (usando 'id_trem')
if (!isset($_GET['id_trem']) || !is_numeric($_GET['id_trem'])) {
    die("ID do trem inválido ou não fornecido.");
}

$id_trem = (int)$_GET['id_trem'];
$trem = null;
$funcionarios = []; 

// 2. Buscar dados do trem atual (CORRIGIDO: 'id_funcionario_encarregado_trem')
$stmt_trem = $con->prepare("SELECT id_trem, nome_trem, modelo_trem, id_funcionario_encarregado_trem, infos_trem FROM trens WHERE id_trem = ?");
$stmt_trem->bind_param("i", $id_trem);
$stmt_trem->execute();
$resultado_trem = $stmt_trem->get_result();

if ($resultado_trem->num_rows === 1) {
    $trem = $resultado_trem->fetch_assoc();
} else {
    die("Trem não encontrado.");
}
$stmt_trem->close();

// 3. Buscar lista de funcionários
$query_func = "SELECT id_usuario, username_usuario FROM usuario"; 
$result_func = $con->query($query_func);

if ($result_func) {
    while ($func = $result_func->fetch_assoc()) {
        $funcionarios[] = $func;
    }
}
$con->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<body>
    <main class="dashboard-container">
        <div class="form-container">
            <h1>⚙️ Editar Trem: <?= htmlspecialchars($trem['nome_trem']) ?></h1>
            
            <form action="php/processar_edicao_trem.php" method="POST">
                
                <input type="hidden" name="id_trem" value="<?= htmlspecialchars($trem['id_trem']) ?>">

                <md-outlined-text-field 
                    label="Nome do Trem" 
                    name="nome_trem" 
                    value="<?= htmlspecialchars($trem['nome_trem']) ?>"
                    required
                ></md-outlined-text-field>

                <md-outlined-text-field 
                    label="Modelo do Trem" 
                    name="modelo_trem" 
                    value="<?= htmlspecialchars($trem['modelo_trem']) ?>"
                    required
                ></md-outlined-text-field>

                <md-outlined-text-field 
                    label="Informações Adicionais" 
                    name="infos_trem" 
                    value="<?= htmlspecialchars($trem['infos_trem'] ?? '') ?>"
                    maxlength="255"
                ></md-outlined-text-field>

                <md-outlined-select label="Funcionário Encarregado" name="id_funcionario_encarregado" required>
                    <?php if (!empty($funcionarios)): ?>
                        <?php foreach ($funcionarios as $funcionario): ?>
                            <md-select-option 
                                value="<?= htmlspecialchars($funcionario['id_usuario']) ?>"
                                <?php 
                                    // CORRIGIDO: Usar a chave correta para comparação
                                    if ((int)$funcionario['id_usuario'] === (int)$trem['id_funcionario_encarregado_trem']) echo 'selected'; 
                                ?>
                            >
                                <div slot="headline"><?= htmlspecialchars($funcionario['username_usuario']) ?></div>
                            </md-select-option>
                        <?php endforeach; ?>
                    <?php else: ?>
                         <md-select-option value="" disabled>
                            <div slot="headline">Nenhum funcionário encontrado.</div>
                        </md-select-option>
                    <?php endif; ?>
                </md-outlined-select>

                <md-filled-button type="submit">
                    <md-icon slot="icon">save</md-icon>
                    Salvar Alterações
                </md-filled-button>

            </form>
            <md-text-button onclick="window.location.href='?page=trains.php'" style="margin-top: 10px;">
                Cancelar
            </md-text-button>
        </div>
    </main>
</body>
</html>