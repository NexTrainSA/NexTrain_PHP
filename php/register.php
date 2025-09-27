<?php
    include_once "db.php";
    session_start();

    $user = $_POST["user"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];

    $mail_regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 

    $res="";

    if(!preg_match($mail_regex, $email)) {
        $res = "Email inválido.";
    } else if(strlen($pass) < 6) {
        $res = "Senha deve ter no mínimo 6 caracteres.";
    } else {
        $pass = md5($pass);
        $query = "INSERT INTO usuario (username_usuario, email_usuario, senha_usuario) VALUES ('$user', '$email', '$pass')";
        if(mysqli_query($con, $query)) {
            $res = "Usuário cadastrado com sucesso.";
        } else {
            $res = "Erro ao cadastrar usuário. Tente outro nome de usuário ou email.";
        }
    }

    header("location: ../index.php?msg=" . html_entity_decode($res));
?>