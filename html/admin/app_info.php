<style>
    body {
        background-color: #dbd4bf !important;
    }
</style>

<?php
    if(!check_user_permission($_SESSION["username"], "APP_INFO")) {
        die ("<h1>Você não tem permissão para acessar essa página!</h1>");
    }

    $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));
    $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
    $commitDate->setTimezone(new \DateTimeZone('America/Sao_Paulo'));
    $commitAuthor = trim(exec('git log -n1 --pretty=%cn HEAD'));

    echo "<br/><h1>Informações do App</h1>";
    echo "<h2>Versão: " . $commitHash . "</h2>";
    echo "<h2>Data do último commit: " . $commitDate->format('d/m/Y H:i:s') . "</h2>";
    echo "<h2>Autor do último commit: " . $commitAuthor . "</h2>";

    phpinfo();
?>