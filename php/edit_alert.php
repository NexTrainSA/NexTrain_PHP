<?php


include_once("db.php");


if (!isset($_GET['id_alerta']) || empty($_GET['id_alerta'])) {

    header("Location: alerts.php");
    exit();
}

$id_alerta = $_GET['id_alerta'];

$con = get_con();


$id_alerta_safe = mysqli_real_escape_string($con, $id_alerta);
$query_alerta = "SELECT id_funcionario, id_funcionario_recebe, descricao_alerta FROM alertas WHERE id_alerta = '$id_alerta_safe'";
$result_alerta = mysqli_query($con, $query_alerta);

if (!$result_alerta || mysqli_num_rows($result_alerta) === 0) {

    header("Location: alerts.php");
    exit();
}
$alerta_data = mysqli_fetch_assoc($result_alerta);
mysqli_free_result($result_alerta);

$query_users = "SELECT id_usuario, username_usuario FROM usuario";
$result_users = mysqli_query($con, $query_users);
$users = [];
if ($result_users) {
    while ($row = mysqli_fetch_assoc($result_users)) {
        $users[] = $row;
    }
    mysqli_free_result($result_users);
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Alerta #<?php echo htmlspecialchars($alerta_data['id_alerta']); ?></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">

    <script type="importmap">
        {
            "imports": {
                "@material/web/": "https://esm.run/@material/web/"
            }
        }
    </script>
    <script type="module">
        import '@material/web/all.js';
    </script>

</head>

<body>
    <section style="max-width: 1200px;
    margin: 0 auto;
    padding: 24px 16px;
    display: flex;
    flex-direction: column;
    gap: 32px;">
        <main class="edit-container">

            <section class="page-header">
                <div class="header-content">
                    <h1 class="page-title">Editar Alerta</h1>
                    <p class="page-subtitle">Alerta criado por: **<?php echo htmlspecialchars(get_username_from_id($alerta_data['id_funcionario'])); ?>**</p>
                </div>
            </section>

            <form action="process_edit_alert.php" method="POST" class="edit-form-container">

                <input type="hidden" name="id_alerta" value="<?php echo htmlspecialchars($id_alerta); ?>">

                <label for="descricao_alerta">Descrição do Alerta:</label>
                <textarea id="descricao_alerta" name="descricao_alerta" rows="4" required><?php echo htmlspecialchars($alerta_data['descricao_alerta']); ?></textarea>

                <label for="id_funcionario_recebe">Alerta Para (Funcionário que Recebe):</label>
                <md-outlined-select id="id_funcionario_recebe" name="id_funcionario_recebe" label="Selecione o Destinatário">
                    <?php
                    $current_recipient_id = $alerta_data['id_funcionario_recebe'];
                    foreach ($users as $user): ?>
                        <md-select-option value="<?php echo htmlspecialchars($user['id_usuario']); ?>"
                            <?php if ($user['id_usuario'] == $current_recipient_id) echo 'selected'; ?>>
                            <div slot="headline"><?php echo htmlspecialchars($user['username_usuario']); ?></div>
                        </md-select-option>
                    <?php endforeach; ?>
                </md-outlined-select>

                <div class="form-actions">
                    <md-filled-button type="submit">
                        <md-icon slot="icon">save</md-icon>
                        Salvar Edição
                    </md-filled-button>

                    <md-outlined-button type="button" onclick="window.history.back()">
                        Cancelar
                    </md-outlined-button>
                </div>
            </form>
        </main>
    </section>
</body>

</html>