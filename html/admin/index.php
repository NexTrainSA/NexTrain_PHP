<section class="content"> <!--Conteúdo da página-->

    <!-- https://www.w3schools.com/css/css_table_style.asp !-->
    <link rel="stylesheet" href="css/admin.css">

    <div class="flex-container">
        <div class="flex-child">
            <h2 style="text-align: center;">Listagem de Páginas - Painel Administrador</h2>
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