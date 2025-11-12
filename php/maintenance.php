<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alertas e Manutenções | SA NexTrain</title>

    <!-- Fontes e Ícones -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Estilos -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/maintenance.css">
    <link rel="stylesheet" href="/html/templates/header.html">
    <link rel="stylesheet" href="/html/templates/footer.html">

    <!-- Material Web -->
    <script type="importmap">
        {
        "imports": {
        "@material/web/": "https://esm.run/@material/web/"
        }
    }
    </script>
    <script type="module">
        import '@material/web/all.js';
        import {
            styles as typescaleStyles
        } from '@material/web/typography/md-typescale-styles.js';

        document.adoptedStyleSheets.push(typescaleStyles.styleSheet);

        // Ensure icons are loaded properly
        document.addEventListener('DOMContentLoaded', function() {
            // Force icon font load
            const testIcon = document.createElement('md-icon');
            testIcon.textContent = 'schedule';
            testIcon.style.position = 'absolute';
            testIcon.style.left = '-9999px';
            document.body.appendChild(testIcon);

            setTimeout(() => {
                document.body.removeChild(testIcon);
            }, 100);
        });
    </script>


</head>

<body>
    <main class="dashboard-container">
        <main class="routes-container">
            <!-- Cabeçalho -->
            <section class="page-header">
                <div class="header-content">
                    <h1 class="page-title">Manutenções</h1>
                    <p class="page-subtitle">Veja os chamados de manutenção</p>
                </div>
            </section>


            <!-- Cards de Alertas -->
            <section class="routes-grid-section">
                <div class="routes-grid">

                    <!-- Teste -->
                    <?php
                    include_once('listar_chamados_manutencao.php');
                    foreach ($chamados as $linha): ?>
                        <md-card class="route-alert-card thunderstorm">
                            <div class="route-card-content">
                                <div class="route-header">
                                    <div class="route-icon-wrapper">
                                        <md-icon class="route-icon">train</md-icon>
                                    </div>

                                    <div class="route-info">
                                        <h3 class="route-name"><?= htmlspecialchars($linha['nome_trem']) ?></h3>
                                    </div>
                                    <md-chip label="<?= htmlspecialchars($linha['username_usuario']) ?>"
                                        class="status-chip alert-thunder">
                                        <md-icon slot="icon">build</md-icon>
                                    </md-chip>
                                </div>

                                <p class="alert-description">
                                    <?= htmlspecialchars($linha['descricao_problema']) ?>
                                </p>
                            </div>

                            <div class="route-actions">
                               <a href="php/editar_chamados.php?ordem_servico=<?= htmlspecialchars($linha['ordem_servico']) ?>">
                                    <md-text-button class="edit-btn">
                                        <md-icon slot="icon">edit</md-icon>
                                        Editar
                                    </md-text-button>
                                </a>
                                <a href="php/excluir_chamados.php?id=<?= $linha['ordem_servico'] ?>"
                                    onclick="return confirm('Deseja mesmo excluir este chamado?')">
                                    <md-text-button class="delete-btn">
                                        <md-icon slot="icon">delete</md-icon>
                                        Excluir
                                    </md-text-button>
                                </a>
                            </div>
                        </md-card>
                    <?php endforeach; ?>

            </section>


            <!-- Botão Flutuante -->
            <md-fab class="nxt-btn" label="Abrir chamado de manutenção"
                onclick="window.location.href='?page=maintenance-requests.php'">
                <md-icon slot="icon">add</md-icon>
            </md-fab>

            <!-- Scripts -->
            <script src="./js/dark_mode.js"></script>
            <script src="./js/sidebar.js"></script>
            <script src="./js/icon-loader.js"></script>
        </main>
    </main>
</body>

</html>