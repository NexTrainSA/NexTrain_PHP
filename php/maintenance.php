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
    <main class="routes-container">
        <!-- Cabeçalho -->
        <section class="page-header">
            <div class="header-content">
                <h1 class="page-title">Alertas e Manutenções</h1>
                <p class="page-subtitle">Veja os trens e trajetos que estão com avisos ativos</p>
            </div>
        </section>


        <div class="routes-grid">
            <?php
            require_once('db.php');

            $query = "SELECT * FROM alertas";
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
                                    <h3 class="route-name"><?= htmlspecialchars($alertas['id_alerta']) ?></h3>
                                    <p class="route-line"><?= htmlspecialchars($alertas['id_funcionario']) ?></p>
                                </div>
                                <md-chip label="Ativo" class="status-chip status-on-time">
                                    <md-icon slot="icon">check_circle</md-icon>
                                </md-chip>
                            </div>

                            <div class="route-details">
                                <div class="route-path">
                                    <span class="station">Informações</span>
                                    <md-icon class="path-arrow">arrow_forward</md-icon>
                                    <span class="station"><?= htmlspecialchars($alertas['descricao_alerta']) ?></span>
                                </div>
                            </div>

                            <div class="route-actions">
                                <md-text-button onclick="editTrain('<?= htmlspecialchars($alertas['descricao_alerta']) ?>')">
                                    <md-icon slot="icon">edit</md-icon>
                                    Editar
                                </md-text-button>
                                <a href="../php/excluir_alerta.php?id=<?= $alerta['id_alerta'] ?>"
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

        <!-- Cards de Alertas -->
        <section class="routes-grid-section">
            <div class="routes-grid">

                <!-- Card 1 -->
                <md-card class="route-alert-card thunderstorm">
                    <div class="route-card-content">
                        <div class="route-header">
                            <div class="route-icon-wrapper">
                                <md-icon class="route-icon">train</md-icon>
                            </div>
                            <div class="route-info">
                                <h3 class="route-name">DB 8598</h3>
                                <p class="route-line">Linha Azul</p>
                            </div>
                            <md-chip label="Trovoada no trajeto" class="status-chip alert-thunder">
                                <md-icon slot="icon">bolt</md-icon>
                            </md-chip>
                        </div>
                        <p class="alert-description">Alerta de tempestade detectado entre Estação Central e Terminal
                            Norte.</p>
                    </div>
                    <md-text-button>
                        <md-icon slot="icon">delete</md-icon>
                        Excluir
                    </md-text-button>
                </md-card>

                <!-- Card 2 -->
                <md-card class="route-alert-card obstacle">
                    <div class="route-card-content">
                        <div class="route-header">
                            <div class="route-icon-wrapper">
                                <md-icon class="route-icon">train</md-icon>
                            </div>
                            <div class="route-info">
                                <h3 class="route-name">DB 9360</h3>
                                <p class="route-line">Linha Verde</p>
                            </div>
                            <md-chip label="Objeto no trilho" class="status-chip alert-obstacle">
                                <md-icon slot="icon">warning</md-icon>
                            </md-chip>
                        </div>
                        <p class="alert-description">Sensor detectou um objeto obstruindo o trilho próximo à Estação
                            Sul.</p>
                    </div>
                    <md-text-button>
                        <md-icon slot="icon">delete</md-icon>
                        Excluir
                    </md-text-button>
                </md-card>

                <!-- Card 3 -->
                <md-card class="route-alert-card mechanical">
                    <div class="route-card-content">
                        <div class="route-header">
                            <div class="route-icon-wrapper">
                                <md-icon class="route-icon">train</md-icon>
                            </div>
                            <div class="route-info">
                                <h3 class="route-name">DB 7521</h3>
                                <p class="route-line">Linha Vermelha</p>
                            </div>
                            <md-chip label="Falha mecânica" class="status-chip alert-mechanical">
                                <md-icon slot="icon">build</md-icon>
                            </md-chip>
                        </div>
                        <p class="alert-description">O trem apresentou falha mecânica e está parado no Distrito
                            Industrial.</p>
                    </div>
                    <md-text-button>
                        <md-icon slot="icon">delete</md-icon>
                        Excluir
                    </md-text-button>
                </md-card>

                <!-- Card 4 -->
                <md-card class="route-alert-card accident">
                    <div class="route-card-content">
                        <div class="route-header">
                            <div class="route-icon-wrapper">
                                <md-icon class="route-icon">train</md-icon>
                            </div>
                            <div class="route-info">
                                <h3 class="route-name">DB 4182</h3>
                                <p class="route-line">Linha Amarela</p>
                            </div>
                            <md-chip label="Acidente detectado" class="status-chip alert-accident">
                                <md-icon slot="icon">emergency</md-icon>
                            </md-chip>
                        </div>
                        <p class="alert-description">Acidente registrado próximo ao Centro Histórico. Equipe a caminho.
                        </p>
                    </div>
                    <div class="route-actions">
                        <md-text-button>
                            <md-icon slot="icon">delete</md-icon>
                            Excluir
                        </md-text-button>
                    </div>
                </md-card>
            </div>


        </section>


        <!-- Botão Flutuante -->
        <md-fab class="nxt-btn" label="Abrir chamado de manutenção"
            onclick="window.location.href='?page=maintenance-requests.php'">
            <md-icon slot="icon">add</md-icon>
        </md-fab>


        <md-fab class="nxt-btn" label="Enviar um novo Alerta"
            onclick="window.location.href='?page=alerts-requests.php'">
            <md-icon slot="icon">add</md-icon>
        </md-fab>


        <!-- Scripts -->
        <script src="./js/dark_mode.js"></script>
        <script src="./js/sidebar.js"></script>
        <script src="./js/icon-loader.js"></script>
</body>

</html>