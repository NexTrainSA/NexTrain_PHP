<?php
require_once('db.php'); 

$con = get_con(); 


if (!isset($_GET['id_trem']) || !is_numeric($_GET['id_trem'])) {
    
    header("Location: trains.php?status=error_id");
    exit();
}

$id_trem = (int)$_GET['id_trem'];
$trem = null;
$funcionarios = []; 


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

<head>
    <meta charset="UTF-8">
    <title>Editar Trem - <?= htmlspecialchars($trem['nome_trem']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css"> 
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
    <style>
       
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #363949;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-container h1 {
            color: #ffffff;
            margin-bottom: 20px;
            text-align: center;
        }

        md-outlined-text-field, md-outlined-select {
            width: 100%;
            margin-bottom: 20px;
            --md-sys-color-primary: #8AB4F8; 
            --md-outlined-text-field-container-color: #4A4D5C;
            --md-outlined-text-field-input-text-color: #FFFFFF;
            --md-outlined-text-field-label-text-color: #B0B0B0;
        }
        
        md-filled-button {
            width: 100%;
            --md-filled-button-container-color: #8AB4F8;
            --md-filled-button-label-text-color: #1F1F1F;
        }
    </style>
</head>

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
                                <?php if ((int)$funcionario['id_usuario'] === (int)$trem['id_funcionario_encarregado']) echo 'selected'; ?>
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