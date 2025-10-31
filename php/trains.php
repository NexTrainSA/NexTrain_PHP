<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <!--  Fontes e Estilos:  -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/html/templates/header.html">
    <link rel="stylesheet" href="/html/templates/footer.html">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

        <section class="page-header">
            <div class="header-content">
                <h1 class="page-title">Lista de Trens</h1>
                <p class="page-subtitle">Visualize e gerencie todos os seus trens</p>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="search-and-filters">
                    <md-outlined-text-field id="route-search" label="Buscar trens" type="search" class="search-field">
                        <md-icon slot="leading-icon">search</md-icon>
                    </md-outlined-text-field>

                    <md-outlined-button id="filter-btn" onclick="toggleFilters()">
                        <md-icon slot="icon">filter_list</md-icon>
                        Filtros
                    </md-outlined-button>
                </div>

                <md-filled-button id="add-route-btn" onclick="window.location.href='?page=add_trains.php'">
                    <md-icon slot="icon">add</md-icon>
                    Novo Trem
                </md-filled-button>
            </div>

            <!-- Filters Panel (Initially Hidden) -->
            <div id="filters-panel" class="filters-panel" style="display: none;">
                <div class="filters-content">
                    <div class="filter-group">
                        <md-outlined-select label="Status">
                            <md-select-option value="all">
                                <div slot="headline">Todos</div>
                            </md-select-option>
                            <md-select-option value="active">
                                <div slot="headline">Ativo</div>
                            </md-select-option>
                            <md-select-option value="delayed">
                                <div slot="headline">Atrasado</div>
                            </md-select-option>
                            <md-select-option value="maintenance">
                                <div slot="headline">Manutenção</div>
                            </md-select-option>
                        </md-outlined-select>
                    </div>

                    <div class="filter-group">
                        <md-outlined-select label="Linha">
                            <md-select-option value="all">
                                <div slot="headline">Todas as Linhas</div>
                            </md-select-option>
                            <md-select-option value="line1">
                                <div slot="headline">Linha 1</div>
                            </md-select-option>
                            <md-select-option value="line2">
                                <div slot="headline">Linha 2</div>
                            </md-select-option>
                        </md-outlined-select>
                    </div>

                    <div class="filter-actions">
                        <md-text-button onclick="clearFilters()">Limpar</md-text-button>
                        <md-filled-tonal-button onclick="applyFilters()">Aplicar</md-filled-tonal-button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Routes Grid -->
        <section class="routes-grid-section">
            <div class="routes-grid">
                <?php
                require_once('db.php');
                $query = "SELECT * FROM trens";
                $result = $con->query($query);

                if ($result && $result->num_rows > 0):
                    while ($trem = $result->fetch_assoc()):
                ?>
                        <md-card class="route-detail-card">
                            <div class="route-card-content">
                                <div class="route-header">
                                    <div class="route-icon-wrapper">
                                        <md-icon class="route-icon">train</md-icon>
                                    </div>
                                    <div class="route-info">
                                        <h3 class="route-name"><?= htmlspecialchars($trem['nome_trem']) ?></h3>
                                        <p class="route-line"><?= htmlspecialchars($trem['modelo_trem']) ?></p>
                                    </div>
                                    <md-chip label="Ativo" class="status-chip status-on-time">
                                        <md-icon slot="icon">check_circle</md-icon>
                                    </md-chip>
                                </div>

                                <div class="route-details">
                                    <div class="route-path">
                                        <span class="station">Informações</span>
                                        <md-icon class="path-arrow">arrow_forward</md-icon>
                                        <span class="station"><?= htmlspecialchars($trem['infos_trem']) ?></span>
                                    </div>
                                </div>

                                <div class="route-actions">
                                    <md-text-button onclick="editTrain(<?= $trem['id_trem'] ?>)">
                                        <md-icon slot="icon">edit</md-icon>
                                        Editar
                                    </md-text-button>
                                    <a href="php/excluir_trem.php?id=<?= $trem['id_trem'] ?>"
                                        onclick="return confirm('Deseja mesmo excluir este trem?')">
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
                    ?>
                    <p style="text-align:center;">Não tem trem :(</p>
                <?php endif;
                $con->close();
                ?>
            </div>

            <!-- Load More Button -->
            <div class="load-more-section">
                <md-outlined-button class="load-more-btn">
                    <md-icon slot="icon">expand_more</md-icon>
                    Carregar Mais Trens
                </md-outlined-button>
            </div>
        </section>
    </main>

    <!--  Scripts:  -->
    <script src="./js/icon-loader.js"></script>
    <script src="./js/dark_mode.js"></script>
    <script src="./js/sidebar.js"></script>
    <script src="./js/routes.js"></script>

</body>

</html>