<?php

include 'db.php';



if (!isset($_GET['id_alerta'])) {
    die("ID do alerta não especificado.");
}

$id_alerta = $_GET['id_alerta'];
$con = get_con();


$stmt_alerta = $con->prepare("SELECT id_alerta, descricao_alerta, id_funcionario, id_funcionario_recebe FROM alertas WHERE id_alerta = ?");

$stmt_alerta->bind_param("i", $id_alerta);
$stmt_alerta->execute();
$result_alerta = $stmt_alerta->get_result();

if ($result_alerta->num_rows == 0) {
    die("Alerta não encontrado.");
}

$alerta_data = $result_alerta->fetch_assoc();
$stmt_alerta->close();

$users = get_all_users_as_array();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Alerta #<?php echo htmlspecialchars($alerta_data['id_alerta']); ?></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>

    <section class="dashboard-container">
        <section class="routes-container">
            <section class="page-header">
                <div class="header-content">
                    <h1 class="page-title">Editar Alerta</h1>
                    <p class="page-subtitle">Alerta de: <?php echo htmlspecialchars(get_username_from_id($alerta_data['id_funcionario'])); ?></p>
                </div>
            </section>

            <form action="process_edit_alert.php" method="POST" class="edit-form-container">

                <input type="hidden" name="id_alerta" value="<?php echo htmlspecialchars($alerta_data['id_alerta']); ?>">

                <label for="descricao_alerta">Descrição do Alerta:</label><br>
                <textarea id="descricao_alerta" name="descricao_alerta" rows="4" cols="80" required
                    style="width: 100%; padding: 10px; margin-bottom: 20px;"><?php echo htmlspecialchars($alerta_data['descricao_alerta']); ?></textarea><br>

                <label for="id_funcionario_recebe">Alerta Para (Funcionário que Recebe):</label><br>
                <select id="id_funcionario_recebe" name="id_funcionario_recebe" required
                    style="width: 100%; padding: 10px; margin-bottom: 20px;">
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo htmlspecialchars($user['id_usuario']); ?>"
                            <?php if ($user['id_usuario'] == $alerta_data['id_funcionario_recebe']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($user['username_usuario']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <div class="form-actions">
                    <md-filled-button type="submit">
                        <md-icon slot="icon">save</md-icon>
                        Salvar Edição
                    </md-filled-button>

                    <a href="../alerts.php"> <md-text-button>
                            Cancelar
                        </md-text-button>
                    </a>
                </div>
            </form>
        </section>
    </section>
</body>

</html>