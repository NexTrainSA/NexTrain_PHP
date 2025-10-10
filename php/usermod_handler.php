<?php
include_once './db.php';

global $con;

$con->real_query("SHOW COLUMNS FROM usuario;");
$result = $con->use_result();

$fields = array();

foreach ($result as $name) {
    if ($name["Field"] == "id_usuario") {
        continue;
    }
    array_push($fields, $name["Field"]);
}

$result->free();

if (sizeof($_POST) > 0) {
    $_POST["senha_usuario"] = md5($_POST["senha_usuario"]);

    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'insert') {
            unset($_POST["submit"]);
            $values = array();
            foreach (array_values($_POST) as $value) {
                $val = "'" . $value . "'";
                array_push($values, $val);
            }
            $con->query("INSERT INTO usuario(" . implode(", ", $fields) . ") VALUES (" . str_replace("agora", "'+NOW()+'", implode(",", $values)) . ")");
        }

        if ($_POST['submit'] == 'edit') {
            unset($_POST["submit"]);
            $keys = array_keys($_POST);

            unset($keys[0]);
            $list = "";

            foreach ($keys as $key) {
                $list = $list . "," . $key . " = '" . $_POST[$key] . "'";
            }

            $list = substr($list, 1);

            $query = "UPDATE usuario SET " . $list . " WHERE (`id_usuario` = '" . $_POST["id_usuario"] . "');";
            $con->query($query);
        }
    }

    header("location: ../index.php?page=admin/user_edit.php");
}
