<?php
include_once "db.php";
session_start();

$oldPass = $_POST["oldpass"];
$newPass = $_POST["newpass"];

$res = "";

if (!isset($_SESSION["username"])) {
    header("location: ../index.php");
    die();
}

if ($oldPass === $newPass) {
    $res = "Senha não pode ser igual a anterior.";
} else {
    $username = $_SESSION["username"];
    $oldPass = md5($oldPass);
    $newPass = md5($newPass);

    $query = "SELECT * FROM usuario WHERE username_usuario = '$username' AND senha_usuario = '$oldPass'";
    $result = mysqli_query($con, $query);



    if (mysqli_num_rows($result) > 0) {
        $query = "UPDATE usuario SET senha_usuario = '$newPass' WHERE username_usuario = '$username'";
        mysqli_query($con, $query);
        $res = "Senha alterada com sucesso.";
    } else {
        $res = "A senha anterior está errada.";
    }
}

header("location: ../index.php?msg=" . html_entity_decode($res));
