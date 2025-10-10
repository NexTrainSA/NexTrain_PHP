<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--  Fontes e Estilos:  -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
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
    </script>
</head>

<body>

    <section class="content" style="margin-top: 20px;"> <!--  Conteúdo da Página:  -->
        <!--  Card:  -->
        <div id="alerts-box" class="danger">
            <div class="alert-item" style="display:flex; align-items: center;">
                <md-filled-tonal-icon-button style="--md-sys-color-secondary-container: #ffffff;">
                    <md-icon class="alert">thunderstorm</md-icon>
                </md-filled-tonal-icon-button>
                <div class="alert-content" style="display: flex; flex-direction: column;">
                    <h2 class="alert-title"><b>Atrasos</b></h2>
                    <span class="alert-location"><i>Fortes chuvas durante a rota do seu Trem, Aguarde!</i></span>
                </div>
            </div>
        </div>


        <div id="alerts-box">
            <div class="alert-item" style="display:flex; align-items: center;">
                <md-filled-tonal-icon-button style="--md-sys-color-secondary-container: #ffffff;">
                    <md-icon class="alert">hourglass</md-icon>
                </md-filled-tonal-icon-button>
                <div class="alert-content" style="display: flex; flex-direction: column;">
                    <h2 class="alert-title"><b>Atrasos</b></h2>
                    <span class="alert-location"><i>Mudanças de Horários</i></span>
                </div>
            </div>
        </div>

        <div id="alerts-box">
            <div class="alert-item" style="display:flex; align-items: center;">
                <md-filled-tonal-icon-button style="--md-sys-color-secondary-container: #ffffff;">
                    <md-icon class="alert">flood</md-icon>
                </md-filled-tonal-icon-button>
                <div class="alert-content" style="display: flex; flex-direction: column;">
                    <h2 class="alert-title"><b>Enchentes</b></h2>
                    <span class="alert-location"><i>Alerta de Enchentes</i></span>
                </div>
            </div>
        </div>

        <div id="alerts-box">
            <div class="alert-item" style="display:flex; align-items: center;">
                <md-filled-tonal-icon-button style="--md-sys-color-secondary-container: #ffffff;">
                    <md-icon class="alert">road</md-icon>
                </md-filled-tonal-icon-button>
                <div class="alert-content" style="display: flex; flex-direction: column;">
                    <h2 class="alert-title"><b>Rota</b></h2>
                    <span class="alert-location"><i>Acompanhe a rota em tempo real</i></span>
                </div>
            </div>
        </div>
        <!--  Card:  -->
        <div id="alerts-box" class="warning">
            <div class="alert-item" style="display:flex; align-items: center;">
                <md-filled-tonal-icon-button style="--md-sys-color-secondary-container: #ffffff;">
                    <md-icon class="alert">warning</md-icon>
                </md-filled-tonal-icon-button>
                <div class="alert-content" style="display: flex; flex-direction: column;">
                    <h2 class="alert-title"><b>Acidentes</b></h2>
                    <span class="alert-location"><i>Aconteceu um acidente durante o trajeto, Aguarde!</i></span>
                </div>
            </div>
        </div>

        <button>Cadastrar nova notificação</button>
        <div>
            <md-fab class="nxt-btn" onclick="document.location.href = '?page=add_task.php'" label="Cadastrar nova notificação">
                <md-icon slot="icon">add</md-icon>
            </md-fab>
        </div>

       
    
