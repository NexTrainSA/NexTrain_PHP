<section class="content"> <!--Conteúdo da página-->

    <!-- https://www.w3schools.com/css/css_table_style.asp !-->

    <style>

        body {
            background-color: #dbd4bf;
            font-size: 18px;
        }

        input {
            border: 2px solid #a39774;
            background-color: #b5ab8d;
        }

        table, th, td {
            border: 1.25px solid;
        }
        
        td {
            font-style: italic;
        }

        tr:nth-child(even) {background-color: #b5ab8d;}

        .flex-container {
            display: flex;
        }

        .flex-child {
            flex: 1;
            margin: 20px;
        }  

        .flex-child:first-child {
            margin-right: 20px;
        }
    </style>


    <div class="flex-container">
        <div class="flex-child">
            <h2>Listagem de Páginas - Painel Administrador</h2>
            <?php 
                foreach(scandir('html/admin') as $name) {
                    if(str_starts_with($name, ".")) {
                        continue;
                    }
                    echo "<li><a href='?page=admin/".$name."'>" . $name . "</a></li>";
                }
            ?>
        </div>                
            
    </div>
</section>