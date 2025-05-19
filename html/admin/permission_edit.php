<section class="content"> <!--Conteúdo da página-->

    <?php
       global $con;
       $conn = $con;

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
            display: grid;
        }

    </style>


    <div class="flex-container">              
        <table>
            <tr>
                <th>Usuário</th>
                <?php
                    $perm = array();

                    $conn->real_query("SELECT * FROM permissao;");
                    $result3 = $conn->use_result();

                    foreach($result3 as $name) {
                        array_push($perm, $name["nome_permissao"]);
                        echo "<th>" . $name["nome_permissao"] . "</th>";
                    }

                    $result3->free();
                    
                    if(isset($_GET["user_id"])) {
                        fetchPermissions($perm, $_GET["user_id"], get_username_from_id($_GET["user_id"]));
                    }else{
                        $conn->real_query("SELECT * FROM usuario;");
                        $result2 = $conn->use_result();
                        $users = array();

                        foreach($result2 as $name) {
                            array_push($users, [$name["id_usuario"], $name["username_usuario"]]);
                            
                        }
                        $result2->free();

                        foreach($users as $user) {
                            fetchPermissions($perm, $user[0], $user[1]);
                        }

                    }

                    function fetchPermissions($perm, $userId, $username) {
                        global $con; 
                        $user_id = $userId;
                        echo "<tr>";
                        echo "<td>" . $username . "</td>";
                        foreach($perm as $name) {
                            if(check_user_permission($username, $name)) {
                                echo "<td><input type='checkbox' checked></td>";
                            } else {
                                echo "<td><input type='checkbox'></td>";
                            }
                        }
                        echo "</tr>";
                    }

                ?>
            </tr>
        </table>
        <button>Salvar</button>

    </div>
    
</section>