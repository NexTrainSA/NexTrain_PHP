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
        .form-maintenance * {
            font-family: Arial, sans-serif !important;
            color: #333 !important;
            font-size: 14px !important;
        }

        .form-maintenance {
            max-width: 800px;
            margin: 30px auto;
            background-color: whitesmoke;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-maintenance h1 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 25px;
            color: #222;
        }

        .form-maintenance fieldset {
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .form-maintenance legend {
            font-weight: bold;
            padding: 0 10px;
            font-size: 15px;
            color: #555;
        }

        .form-maintenance .form-group {
            margin-bottom: 15px;
        }

        .form-maintenance label {
            display: block;
            margin-bottom: 5px;
        }

        .form-maintenance input,
        .form-maintenance select,
        .form-maintenance textarea {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #fff;
            color: #000 !important;
        }

        .form-maintenance input:focus,
        .form-maintenance select:focus,
        .form-maintenance textarea:focus {
            outline: 2px solid rgb(115, 149, 184);
        }

        .form-maintenance button {
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

        .form-maintenance button:hover {
            background-color: rgb(115, 149, 184);
        }

        .form-maintenance input:invalid,
        .form-maintenance select:invalid,
        .form-maintenance textarea:invalid {
            border-color: rgb(115, 149, 184);
        }

        /* Dark Mode */

        body.dark-mode .form-maintenance {
            background-color: rgb(53, 72, 90);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        body.dark-mode .form-maintenance legend {
            color: #fafafa !important;
        }

        body.dark-mode .form-maintenance label {
            color: #fafafa !important;
        }

        body.dark-mode .form-maintenance button {
            background-color: rgb(88, 116, 143);
        }

        body.dark-mode .form-maintenance h1 {
            color: #fafafa !important;
        }
    </style>

    <section class="content">
        <div class="form-maintenance">
            <h1>Adicionar trem</h1>
            <form id="formOS" action="./php/insert_train.php" method="post">
                <fieldset>
                    <legend>Suas informações:</legend>

                    <div class="form-group">
                        <label for="nome">Nome do trem:*</label>
                        <input type="input" id="nome-trem" name="nome-trem" required>
                    </div>

                    <div class="form-group">
                        <label for="id-funcionario">Nome do funcionário:*</label>
                        <select id="id-funcionario" name="id-funcionario" required>
                            <option value="">Selecione...</option>
                            <?php
                            include("listar_funcionarios.php");
                            foreach ($funcionarios as $linha) {
                                echo  "<option value='" . $linha['id_usuario'] . "'>" . $linha['username_usuario'] . "</option>";
                            } ?>
                        </select>
                    </div>

                    <fieldset>

                        <div class="form-group">
                            <label for="modelo-trem">Modelo do trem:*</label>
                            <textarea id="modelo-trem" name="modelo-trem" rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="infos-trem">Informações do trem:</label>
                            <textarea id="infos-trem" name="infos-trem" rows="4"></textarea>
                        </div>

                    </fieldset>

                    <button type="submit" value="Enviar Novo Trem">Enviar Novo Trem</button>
            </form>
        </div>
    </section>

    <!--  Scripts:  -->
    <script src="./js/dark_mode.js"></script>
    <script src="./js/maintenance-requests.js"></script>
    <!--  Fim dos Scripts  -->

</body>

</html>