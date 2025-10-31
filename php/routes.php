<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--  Fontes e Estilos:  -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/maintenance.css">
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
        import { styles as typescaleStyles } from '@material/web/typography/md-typescale-styles.js';

        document.adoptedStyleSheets.push(typescaleStyles.styleSheet);

        // Ensure icons are loaded properly
        document.addEventListener('DOMContentLoaded', function () {
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
    <?php
// Adicione a lógica de exibição de mensagens de sucesso/erro aqui:
if (isset($_GET['message'])) {
    $message_type = $_GET['message'];
    $alert_message = '';
    $alert_class = '';

    switch ($message_type) {
        case 'edicao_sucesso':
            $alert_message = ' Rota editada e salva com sucesso!';
            $alert_class = 'success';
            break;
        case 'erro_dados_faltando':
            $alert_message = ' Erro ao editar: Dados de rota incompletos.';
            $alert_class = 'error';
            break;
        case 'erro_db':
            $error_details = $_GET['details'] ?? 'Verifique o log de erros do servidor.';
            $alert_message = ' Erro no banco de dados ao salvar a rota. Detalhes: ' . htmlspecialchars($error_details);
            $alert_class = 'error';
            break;
        default:
            $alert_message = '';
            break;
    }

    if (!empty($alert_message)) {
        echo '<div class="alert-container ' . $alert_class . '">';
        echo '    <p>' . $alert_message . '</p>';
        echo '</div>';
    }
}
?>

    <main class="routes-container">
        <!-- Page Header -->
        <section class="page-header">
            <div class="header-content">
                <h1 class="page-title">Gerenciamento de Rotas</h1>
                <p class="page-subtitle">Visualize e gerencie todas as rotas</p>
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
            <div class="routes-page-grid">
                <!-- Route Card 1 -->
                <?php
                include_once("php/listar_rotas.php");
                foreach($routes as $route) {
                    echo('
                <md-card class="route-detail-card" onclick="viewRouteDetails(`'.$route['id_rota'].'`)">
    <div class="route-card-content">
        <div class="route-header">
            <div class="route-icon-wrapper">
                <md-icon class="route-icon">'.($route['id_orig'] == $route['id_dest'] ? "circle" : "route").'</md-icon>
            </div>
            <div class="route-info">
                <h3 class="route-name">Rota '.$route['id_rota'].'</h3>
                <p class="route-line">'.($route['id_orig'] == $route['id_dest'] ? "Linha Circular" : "Linha Simples").'</p>
            </div>
            <md-chip label="Status" class="status-chip">
                <md-icon slot="icon">check_circle</md-icon>
            </md-chip>
        </div>

        <div class="route-details">
            '.render_route_path($route).'
        </div>

        <div class="route-actions">
            <a href="?page=edit_route.php&id='.$route['id_rota'].'" title="Editar Itinerário">
                            <md-text-button>
                             <md-icon slot="icon">edit</md-icon>
                            Editar
                            </md-text-button>
                            </a>
            
            <a href="php/excluir_rota.php?id='.$route['id_rota'].'" onclick="return confirm(\'Deseja mesmo excluir esta rota?\')">
                <md-text-button class="delete-btn">
                    <md-icon slot="icon">delete</md-icon>Excluir
                </md-text-button>
            </a>
        </div>
    </div>
</md-card>');}
            ?>
            </div>
        </section>

        <md-filled-button id="add-route-btn" onclick="window.location.href='?page=add_route.php'">
                    <md-icon slot="icon">add</md-icon>
                    Nova Rota
                </md-filled-button>
                
    </main>



    <!--  Scripts:  -->
    <script src="./js/icon-loader.js"></script>
    <script src="./js/dark_mode.js"></script>
    <script src="./js/sidebar.js"></script>
    <script src="./js/routes.js"></script>
    <script src="./js/confirm_delete.js"></script>
</body>

</html>