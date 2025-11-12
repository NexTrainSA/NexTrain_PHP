<?php
require_once('db.php'); // Inclui o arquivo de conexão

$con = get_con();
$mensagem = "";
$chamado = null;
$trens = [];
$funcionarios = [];
$ordem_servico = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ordem_servico_post = $_POST['ordem_servico'];
    $id_funcionario = $_POST['id_funcionario'];
    $id_trem = $_POST['id_trem'];
    $descricao_problema = $_POST['descricao_problema'];
    $data_entrada = $_POST['data_entrada']; 

    $stmt_update = $con->prepare("UPDATE chamados_manutencao SET id_funcionario = ?, id_trem = ?, descricao_problema = ?, data_entrada = ? WHERE ordem_servico = ?");
    
    
    $stmt_update->bind_param("iisss", $id_funcionario, $id_trem, $descricao_problema, $data_entrada, $ordem_servico_post);
    
    if ($stmt_update->execute()) {
       
        header("Location: maintenance.php?status=success_edit");
        exit();
    } else {
        $mensagem = "❌ Erro ao salvar a edição: " . $stmt_update->error;
        $ordem_servico = $ordem_servico_post; 
    }
    $stmt_update->close();
}



if (!$ordem_servico) {
    $ordem_servico = $_GET['ordem_servico'] ?? null;
}

if (!isset($ordem_servico) || !is_numeric($ordem_servico)) {
    
    header("Location: maintenance.php?status=error_data");
    exit();
}
$ordem_servico = (int)$ordem_servico; 


$stmt_chamado = $con->prepare("SELECT ordem_servico, id_funcionario, id_trem, descricao_problema, data_entrada FROM chamados_manutencao WHERE ordem_servico = ?");
$stmt_chamado->bind_param("i", $ordem_servico);
$stmt_chamado->execute();
$resultado_chamado = $stmt_chamado->get_result();

if ($resultado_chamado->num_rows === 1) {
    $chamado = $resultado_chamado->fetch_assoc();
} else {
    header("Location: maintenance.php?status=not_found");
    exit();
}
$stmt_chamado->close();



$trens = $con->query("SELECT id_trem, nome_trem FROM trens")->fetch_all(MYSQLI_ASSOC);
$funcionarios = $con->query("SELECT id_usuario, username_usuario FROM usuario")->fetch_all(MYSQLI_ASSOC);

$con->close(); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Chamado #<?= htmlspecialchars($chamado['ordem_servico']) ?></title>
    <script type="importmap">
        { "imports": { "@material/web/": "https://esm.run/@material/web/" } }
    </script>
    <script type="module"> import '@material/web/all.js'; </script>
</head>
<body>
    <main class="dashboard-container">
        <div class="form-container">
            <h1>Editar Chamado #<?= htmlspecialchars($chamado['ordem_servico']) ?></h1>

            <?php if ($mensagem): ?><p style="color:red;"><?= $mensagem ?></p><?php endif; ?>

            <form action="editar_chamados.php" method="POST">

                <input type="hidden" name="ordem_servico" value="<?= htmlspecialchars($chamado['ordem_servico']) ?>">
                <input type="hidden" name="data_entrada" value="<?= htmlspecialchars($chamado['data_entrada']) ?>">
                
                <md-outlined-text-field
                    label="Descrição do Problema"
                    name="descricao_problema"
                    value="<?= htmlspecialchars($chamado['descricao_problema']) ?>"
                    required>
                </md-outlined-text-field>

                <md-outlined-select label="Trem Afetado" name="id_trem" required>
                    <?php foreach ($trens as $trem_data): ?>
                        <md-select-option
                            value="<?= htmlspecialchars($trem_data['id_trem']) ?>"
                            <?php if ((int)$trem_data['id_trem'] === (int)$chamado['id_trem']) echo 'selected'; ?>>
                            <div slot="headline"><?= htmlspecialchars($trem_data['nome_trem']) ?></div>
                        </md-select-option>
                    <?php endforeach; ?>
                </md-outlined-select>

                <md-outlined-select label="Funcionário Encarregado" name="id_funcionario" required>
                    <?php foreach ($funcionarios as $funcionario): ?>
                        <md-select-option
                            value="<?= htmlspecialchars($funcionario['id_usuario']) ?>"
                            <?php if ((int)$funcionario['id_usuario'] === (int)$chamado['id_funcionario']) echo 'selected'; ?>>
                            <div slot="headline"><?= htmlspecialchars($funcionario['username_usuario']) ?></div>
                        </md-select-option>
                    <?php endforeach; ?>
                </md-outlined-select>

                <md-outlined-text-field
                    label="Data de Entrada"
                    name="data_entrada_visual"
                    value="<?= htmlspecialchars($chamado['data_entrada']) ?>"
                    readonly>
                </md-outlined-text-field>

                <md-filled-button type="submit" style="margin-top: 20px;">
                    <md-icon slot="icon">save</md-icon>
                    Salvar Edição
                </md-filled-button>

            </form>

            <md-text-button onclick="window.location.href='maintenance.php'" style="margin-top: 10px;">
                Cancelar
            </md-text-button>
        </div>
    </main>
</body>
</html>