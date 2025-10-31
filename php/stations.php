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
    <script src="./js/stations.js"></script>

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
// Verifica se há uma mensagem na URL
if (isset($_GET['message'])) {
    $message_type = $_GET['message'];
    $alert_message = '';
    $alert_class = '';

    switch ($message_type) {
        case 'edicao_sucesso':
            $alert_message = ' Estação editada e salva com sucesso!';
            $alert_class = 'success';
            break;
        case 'erro_dados_faltando':
            $alert_message = ' Erro ao editar: Dados incompletos.';
            $alert_class = 'error';
            break;
        case 'erro_db':
            $error_details = $_GET['details'] ?? 'Verifique o log de erros do servidor.';
            $alert_message = ' Erro no banco de dados. Detalhes: ' . htmlspecialchars($error_details);
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
        <!-- Page Header OPAAAAAA -->
        <section class="page-header">
            <div class="header-content">
                <h1 class="page-title">Lista de Estações</h1>
                <p class="page-subtitle">Visualize e gerencie as estações no ferrorama</p>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="search-and-filters">
                    <md-outlined-text-field id="route-search" label="Buscar por estação" type="search"
                        class="search-field">
                        <md-icon slot="leading-icon">search</md-icon>
                    </md-outlined-text-field>
                </div>

                <md-filled-button id="add-route-btn" onclick="window.location.href='?page=add_station.php'">
                    <md-icon slot="icon">add</md-icon>
                    Nova Estação
                </md-filled-button>
            </div>
        </section>

        <!-- Routes Grid -->
        <section class="routes-grid-section">
            <div class="routes-grid">
                <!-- Route Card 1 -->
                <?php

                include_once("php/listar_estacao.php");
                foreach($estacoes as $estacao) {
                    echo('
                <md-card class="route-detail-card" onclick="viewRouteDetails(`'.$estacao['nome_estacao'].'`)">
                    <div class="route-card-content">
                        <div class="route-header">
                            <div class="route-icon-wrapper">
                                <md-icon class="route-icon">location_city</md-icon>
                            </div>
                            <div class="route-info">
                                <h3 class="route-name">'.$estacao['nome_estacao'].'</h3>
                                <span onload=""></span>
                                <p class="route-line">'.translateStationStatus($estacao['status_estacao']).'</p>
                            </div>
                            <md-chip label="'.$estacao['status_estacao'].'" class="status-chip status-'.$estacao['status_estacao'].'">
                                <!-- <md-icon slot="icon">'.getIconFromStatus($estacao['status_estacao']).'</md-icon> -->
                            </md-chip>
                        </div>
                        <div class="route-actions">
                         <a href="?page=edit_station.php&id='.$estacao['id_estacao'].'" title="Editar Estação">
                            <md-text-button>
                             <md-icon slot="icon">edit</md-icon>
                            Editar
                            </md-text-button>
                            </a>
                            
                            <a href="php/excluir_estacao.php?id='.$estacao['id_estacao'].'" onclick="return confirm(\'Deseja mesmo excluir esta estação?\')">
                                <md-text-button class="delete-btn">
                                    <md-icon slot="icon">delete</md-icon>Excluir
                                </md-text-button>
                            </a>
                        </div>
                    </div>
                </md-card>');}
                ?>
            </div>

            <!-- Load More Button -->
            <div class="load-more-section">
                <md-outlined-button class="load-more-btn">
                    <md-icon slot="icon">expand_more</md-icon>
                    Carregar Mais Estações
                </md-outlined-button>
            </div>
        </section>

        <?php
                            include("php/graph_view.php");
            ?>

    </main>



    <!--  Scripts:  -->
    <script src="./js/icon-loader.js"></script>
    <script src="./js/dark_mode.js"></script>
    <script src="./js/sidebar.js"></script>
</body>

</html>