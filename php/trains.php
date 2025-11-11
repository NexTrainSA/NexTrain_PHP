<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
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

<main class="dashboard-container">
    <main class="routes-container">
        
        <section class="page-header">
            <div class="header-content">
                <h1 class="page-title">Lista de Trens</h1>
                <p class="page-subtitle">Visualize e gerencie todos os seus trens</p>
            </div>

            <?php
            // Lógica de exibição de status (sucesso/erro)
            if (isset($_GET['status'])):
                $message = '';
                $class = '';

                if ($_GET['status'] === 'success_edit') {
                    $message = "Trem editado com sucesso! 🎉";
                    $class = "status-success";
                } elseif ($_GET['status'] === 'error_edit') {
                    $message = "Erro ao editar o trem. Verifique os logs.";
                    $class = "status-error";
                } elseif ($_GET['status'] === 'error_data') {
                    $message = "Erro: Dados do formulário incompletos ou inválidos.";
                    $class = "status-error";
                }
            ?>
                <div class="<?= $class ?>" style="padding: 15px; margin-bottom: 20px; border-radius: 5px; text-align: center; color: white; background-color: <?php echo $class === 'status-success' ? '#4CAF50' : '#F44336'; ?>;">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

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
        <section class="routes-grid-section">
            <div class="routes-grid">
                <?php
                // Atenção: A conexão deve ser aberta antes da query
                // Se a variável $con já foi inicializada em um require_once anterior, 
                // você pode reabrí-la ou usá-la. Assumindo que $con está acessível ou será reaberta.
                // Se você não está usando a página listar_trem.php,
                // você PRECISA re-incluir o db.php e reabrir a conexão aqui se ela foi fechada.
                require_once('db.php');
                $con = get_con(); // Chame a função que retorna a conexão

                $query = "SELECT * FROM trens";
                $result = $con->query($query);

                if ($result && $result->num_rows > 0):
                    while ($trem = $result->fetch_assoc()):
                ?>