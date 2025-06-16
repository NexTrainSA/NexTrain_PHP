<section class="content"> <!--Conteúdo da página-->

    <?php
       global $con;
       $conn = $con;

    ?>

    <!-- https://www.w3schools.com/css/css_table_style.asp !-->
    <link rel="stylesheet" href="css/admin.css">

    <div class="grid-container">              
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