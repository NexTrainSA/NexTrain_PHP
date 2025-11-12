<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alertas</title>

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
                    <h1 class="page-title">Alertas</h1>
                    <p class="page-subtitle">Veja os alertas recentes</p>
                </div>
            </section>


            <div class="routes-grid">
                <?php
                require_once('db.php');

                $query = "SELECT 
                a.id_alerta, 
                a.descricao_alerta, 
                remetente.username_usuario AS nome_remetente,
                destinatario.username_usuario AS nome_destinatario
            FROM alertas a
            JOIN usuario remetente ON remetente.id_usuario = a.id_funcionario
            JOIN usuario destinatario ON destinatario.id_usuario = a.id_funcionario_recebe;";

                $result = $con->query($query);

                if (!$result) {
                    die("Erro na query: " . $con->error);
                }

                if ($result->num_rows > 0):
                    while ($alertas = $result->fetch_assoc()):
                ?>
                        <md-card class="route-detail-card">
                            <div class="route-card-content">
                                <div class="route-header">
                                    <div class="route-icon-wrapper">
                                        <md-icon class="route-icon">train</md-icon>
                                    </div>
                                    <div class="route-info">
                                        <h3 class="route-name">De: <?= htmlspecialchars($alertas['nome_remetente']) ?></h3>
                                        <p class="route-line">Para: <?= htmlspecialchars($alertas['nome_destinatario']) ?></p>
                                    </div>
                                    <md-chip label="Ativo" class="status-chip status-on-time">
                                        <md-icon slot="icon">check_circle</md-icon>
                                    </md-chip>
                                </div>

                                <div class="route-details">
                                    <div class="route-path">
                                        <span class="station">Descrição do alerta</span>
                                        <md-icon class="path-arrow">arrow_forward</md-icon>
                                        <span class="station"><?= htmlspecialchars($alertas['descricao_alerta']) ?></span>
                                    </div>
                                </div>

                                <div class="route-actions">
                                    <a href="php/edit_alert.php?id_alerta=<?php echo htmlspecialchars($alertas['id_alerta']); ?>">
                                        <md-text-button class="edit-btn">
                                            <md-icon slot="icon">edit</md-icon>
                                            Editar
                                        </md-text-button>
                                    </a>
                                    <a href="php/excluir_alerta.php?id=<?= $alertas['id_alerta'] ?>"
                                        onclick="return confirm('Deseja mesmo excluir este alerta?')">
                                        <md-text-button class="delete-btn">
                                            <md-icon slot="icon">delete</md-icon>
                                            Excluir
                                        </md-text-button>
                                    </a>
                                </div>
                            </div>
                        </md-card>
                <?php
                    endwhile;
                else:
                    echo "<p style='text-align:center;'>Nenhum alerta encontrado.</p>";
                endif;

                $con->close();
                ?>

            </div>


            </section>

            <md-fab class="nxt-btn" label="Enviar um novo alerta"
                onclick="window.location.href='?page=alerts-requests.php'">
                <md-icon slot="icon">add</md-icon>
            </md-fab>

        </main>
    </main>
    <!-- Scripts -->
    <script src="./js/dark_mode.js"></script>
    <script src="./js/sidebar.js"></script>
    <script src="./js/icon-loader.js"></script>
</body>

</html>