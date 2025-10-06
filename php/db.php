<?php
$inipath = php_ini_loaded_file();
$ini_array = parse_ini_file($inipath, true)["PHP"];

$db_name = "nextrain_production";
$db_user = "nextrain";
$db_pass = $ini_array["nt_db_pass"];
$db_host = $ini_array["nt_db_host"];
$db_port = 6306;

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

function get_id_from_username($username)
{
    global $con;
    $query = "SELECT id_usuario FROM usuario WHERE username_usuario = '$username'";
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['id_usuario'];
    }
    return null;
}

function get_permission_id_by_name($permissionName)
{
    global $con;
    $query = "SELECT id_permissao FROM permissao WHERE nome_permissao = '$permissionName'";
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['id_permissao'];
    }
    return null;
}

function get_username_from_id($id)
{
    global $con;
    $query = "SELECT username_usuario FROM usuario WHERE id_usuario = '$id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['username_usuario'];
    }
    return null;
}

function check_user_permission($username, $permission)
{
    global $con;
    $id = get_id_from_username($username);
    $idperm = get_permission_id_by_name($permission);

    $q = mysqli_query($con, "SELECT id_permissao FROM permissao_usuario WHERE id_usuario_permissao = '$id' AND id_permissao = '$idperm'");
    if (mysqli_num_rows($q) > 0) {
        return true;
    }
}

function get_all_users_as_array()
{
    global $con;
    $q = mysqli_query($con, "SELECT * FROM usuario");
    $users = [];
    while ($row = mysqli_fetch_assoc($q)) {
        $users[] = $row;
    }
    return $users;
}

/* Função para criar a tabela de chamados de manutenção
function create_requests_table()
{
    global $con;
    $sql = "CREATE TABLE IF NOT EXISTS maintenance_requests (
        ordem_servico INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nome_funcionario VARCHAR(100) NOT NULL,
        cpf_funcionario VARCHAR(11) NOT NULL,
        id_funcionario INT NOT NULL,
        telefone_funcionario VARCHAR(11),
        id_trem VARCHAR(100),
        descricao_problema TEXT NOT NULL,
        tecnico_responsavel VARCHAR(100),
        data_entrada DATE  NOT NULL,
        data_saida DATE NOT NULL,
        FOREIGN KEY (id_funcionario) REFERENCES usuario(id_usuario),
        FOREIGN KEY (id_trem) REFERENCES trains(id_trem)
    )";
    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return "Erro: " . mysqli_error($con);
    }
}*/

// Função para criar tabela para schedule/tarefas
function create_schedule_table()
{
    global $con;
    $sql = "CREATE TABLE IF NOT EXISTS schedule (
        id_tarefa INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        id_funcionario INT NOT NULL,
        descricao_tarefa TEXT NOT NULL,
        FOREIGN KEY (id_funcionario) REFERENCES usuario(id_usuario)
    )";
    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return "Erro: " . mysqli_error($con);
    }
}

// Função para inserir na tabela schedule
function insert_schedule($id_tarefa, $id_funcionario, $descricao_tarefa)
{
    global $con;
    $id_tarefa = mysqli_real_escape_string($con, $id_tarefa);
    $id_funcionario = mysqli_real_escape_string($con, $id_funcionario);
    $descricao_tarefa = mysqli_real_escape_string($con, $descricao_tarefa);

    $sql = "INSERT INTO trains (nome_trem, id_funcionario_encarregado_trem, modelo_trem, infos_trem)
            VALUES ('$id_tarefa', $id_funcionario, '$descricao_tarefa', " . ")";
    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return "Erro: " . mysqli_error($con);
    }
}

// Função para criar a tabela com as informações dos trens
function create_trains_table()
{
    global $con;
    $sql = "CREATE TABLE IF NOT EXISTS trains (
        id_trem INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nome_trem VARCHAR(100) NOT NULL,
        id_funcionario_encarregado_trem INT NOT NULL,
        modelo_trem VARCHAR(100) NOT NULL,
        infos_trem VARCHAR(255) NULL,
        FOREIGN KEY (id_funcionario_encarregado_trem) REFERENCES usuario(id_usuario)
    )";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return "Erro: " . mysqli_error($con);
    }
}

function insert_train($nome_trem, $id_funcionario_encarregado_trem, $modelo_trem, $infos_trem = null)
{
    global $con;
    $nome_trem = mysqli_real_escape_string($con, $nome_trem);
    $modelo_trem = mysqli_real_escape_string($con, $modelo_trem);
    $infos_trem = $infos_trem ? mysqli_real_escape_string($con, $infos_trem) : null;

    $sql = "INSERT INTO trains (nome_trem, id_funcionario_encarregado_trem, modelo_trem, infos_trem)
            VALUES ('$nome_trem', $id_funcionario_encarregado_trem, '$modelo_trem', " . ($infos_trem ? "'$infos_trem'" : "NULL") . ")";
    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return "Erro: " . mysqli_error($con);
    }
}