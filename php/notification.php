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
        import { styles as typescaleStyles } from '@material/web/typography/md-typescale-styles.js';

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

        <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!--  Fontes e Estilos:  -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

    <style>
        .form-schedule * {
            font-family: Arial, sans-serif !important;
            color: #333 !important;
            font-size: 14px !important;
        }

        .form-schedule {
            max-width: 800px;
            margin: 30px auto;
            background-color: whitesmoke;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-schedule h1 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 25px;
            color: #222;
        }

        .form-schedule fieldset {
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .form-schedule legend {
            font-weight: bold;
            padding: 0 10px;
            font-size: 15px;
            color: #555;
        }

        .form-schedule .form-group {
            margin-bottom: 15px;
        }

        .form-schedule label {
            display: block;
            margin-bottom: 5px;
        }

        .form-schedule input,
        .form-schedule select,
        .form-schedule textarea {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #fff;
            color: #000 !important;
        }

        .form-schedule input:focus,
        .form-schedule select:focus,
        .form-schedule textarea:focus {
            outline: 2px solid rgb(115, 149, 184);
        }

        .form-schedule button {
            background-color: rgb(71, 94, 117);
            color: white !important;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 15px;
            transition: background-color 0.3s;
        }

        .form-schedule button:hover {
            background-color: rgb(115, 149, 184);
        }

        .form-schedule input:invalid,
        .form-schedule select:invalid,
        .form-schedule textarea:invalid {
            border-color: rgb(115, 149, 184);
        }

        /* Dark Mode */

        body.dark-mode .form-schedule {
            background-color: rgb(53, 72, 90);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        body.dark-mode .form-schedule legend {
            color: #fafafa !important;
        }

        body.dark-mode .form-schedule label {
            color: #fafafa !important;
        }

        body.dark-mode .form-schedule button {
            background-color: rgb(88, 116, 143);
        }

        body.dark-mode .form-schedule h1 {
            color: #fafafa !important;
        }
    </style>

    <section class="content">
        <div class="form-schedule">
            <h1>Adicionar tarefa</h1>
            <form id="formOS" onsubmit="return validateForm(event)">
                <fieldset>
                    <legend>Suas informações:</legend>

                    <div class="form-group">
                        <label for="id_funcionario">ID do funcionário:*</label>
                        <select id="id_funcionario" required>
                            <option value="">Selecione...</option>
                            <?php
                            include("listar_funcionarios.php");
                            foreach ($funcionarios as $linha) {
                                echo  "<option value='" . $linha['id_usuario'] . "'>" . $linha['id_usuario'] . "</option>";
                            } ?>
                        </select>
                    </div>
                </fieldset>


                <fieldset>
                    <legend>Sua nova tarefa:</legend>
                    <div class="form-group">
                        <label for="descricao_tarefa">Descrição da tarefa:*</label>
                        <textarea id="descricao_tarefa" required></textarea>
                    </div>
                </fieldset>
                <button type="submit">Adicionar tarefa</button>

            </form>
        </div>
    </section>

    <!--  Scripts:  -->
    <script src="./js/dark_mode.js"></script>
    <script src="./js/add_task.js"></script>
    <!--  Fim dos Scripts  -->

</body>

</html>

    </section> <!--  Fim do Conteúdo  -->

    <footer>
        <p>&copy; 2025 SA NexTrain. Todos os direitos reservados.</p>
    </footer>

    <script src="./js/dark_mode.js"></script>
    <script src="./js/sidebar.js"></script>

</body>