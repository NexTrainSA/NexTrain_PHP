<section class="content"> <!--Conteúdo da página-->

    <?php
       global $con;
       $conn = $con;

       $conn->real_query("SHOW COLUMNS FROM usuario;");
       $result = $conn->use_result();

       $fields = array();

        foreach($result as $name) {
            array_push($fields, $name["Field"]);
        }

        $result->free();

        if(array_key_exists("delete_id", $_GET)) {
            $conn->query("DELETE FROM usuario WHERE id_usuario=".$_GET["delete_id"]."");
       }

    ?>

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
            <h2>Listagem de Usuários</h2>
            <table>
                <tr>
                <?php 
                    foreach($fields as $name) {
                        echo "<th>" . $name . "</th>";
                    }
                ?>
                </tr>

                
                    <?php
                        $conn->real_query("SELECT * FROM usuario;");
                        $result2 = $conn->use_result();

                        foreach($result2 as $row) {
                            echo "<tr>";
                            foreach($row as $x) {
                                if(strlen($x) == 32) {
                                    $x = "********";
                                }
                                echo "<td>" . $x . "</td>";
                            }
                            echo "<td><button onclick='document.location.href = document.location.href + `&edit_id=".$row["id_usuario"]."`'>Editar</button></td>";
                            echo "<td><button onclick='document.location.href = `?page=admin/permission_edit.php&user_id=` + ".$row["id_usuario"]."'>Permissões</button></td>";
                            echo "<td><button onclick='document.location.href = document.location.href + `&delete_id=".$row["id_usuario"]."`'>Excluir</button></td>";

                            echo "</tr>";
                        }
                        $result2->free();
                    ?>
                </tr>
            </table>
        </div>                
            
        <br/>
        
        <div class="flex-child">
            <h2>Inserção de Usuários</h2>
            <form action="php/usermod_handler.php" method="POST">
                        <?php
                            foreach($fields as $name) {
                                if(str_starts_with($name, "id_")) {
                                    continue;
                                }
                                if(str_starts_with($name, "senha_")) {
                                    echo $name . ": <input type='password' name='".$name."'><br>";
                                }else{
                                    echo $name . ": <input type='text' name='".$name."'><br>";
                                }
                            }
                            echo "<input type='submit' id='submit' name='submit' value='insert'>"
                        ?>
            </form>
        </div>

        <?php
            if(array_key_exists("edit_id", $_GET)) {
                echo "<div class='flex-child'><h2>Edição de Usuários</h2>";
                echo "<form action='php/usermod_handler.php' method='POST'>";
                $edit_id = $_GET["edit_id"];
                $conn->real_query("SELECT * FROM usuario WHERE id_usuario = " . $edit_id);
                $result3 = $conn->use_result();

                foreach($result3 as $result) {
                    foreach(array_keys($result) as $key) {
                        $val = $result[$key];
                        if(str_starts_with($key, "senha_")) {
                            echo $key . ": <input type='password' name='".$key."' value=''><br>";
                        }else {
                            echo $key . ": <input type='text' name='".$key."' value='".$val."'><br>";
                        }
                    }
                }

                echo "<input type='submit' id='submit' name='submit' value='edit'></form>";

                $result3->free();
                echo "</div>";
            }
        ?>
    </div>
</section>