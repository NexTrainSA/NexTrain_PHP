<?php
    $inipath = php_ini_loaded_file();
    $ini_array = parse_ini_file($inipath , true)["PHP"];

    $db_name = "nextrain_production";
    $db_user = "nextrain";
    $db_pass = $ini_array["nt_db_pass"];
    $db_host = $ini_array["nt_db_host"];
    $db_port = 6306;

    $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

    if(!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    function get_id_from_username($username) {
        global $con;
        $query = "SELECT id_usuario FROM usuario WHERE username_usuario = '$username'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['id_usuario'];
        }
        return null;
    }

    function check_user_permission($username, $permission) {
        global $con;
        $id = get_id_from_username($username);

        $q = mysqli_query($con, "SELECT id_permissao FROM permissao_usuario WHERE id_usuario_permissao = '$id' AND nome_permissao = '$permission'");
        if(mysqli_num_rows($q) > 0) {
            return true;
        }
    }
    
    return false;
?>