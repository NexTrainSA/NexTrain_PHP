<?php

require_once('db.php');

$itinerary = $_POST['itinerary'] ?? '';

$full_trajectory = $_POST['full_trajectory'] ?? '';

$stmt = $con->prepare("INSERT INTO rota (itinerario_rota, caminho_rota) VALUES(?, ?)");

$stmt->bind_param("is", $itinerary, $full_trajectory);

if ($stmt->execute()) {
} else {
    echo "Deu ruim :(";
}

$stmt->close();
$con->close();

header("Location:../index.php?page=routes.php.php");
