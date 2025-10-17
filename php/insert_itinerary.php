<?php

require_once('db.php');

$ORIGEM = $_POST['origem'] ?? '';
$DESTINO = $_POST['destino'] ?? '';

$stmt = $con->prepare("INSERT INTO itinerario (origem_itinerario, destino_itinerario) VALUES(?, ?)");
$stmt->bind_param("ii", $ORIGEM, $DESTINO);

if ($stmt->execute()) {
} else {
    echo "Deu ruim :(";
}

$stmt->close();
$con->close();

header("Location: ../html/index.html");
