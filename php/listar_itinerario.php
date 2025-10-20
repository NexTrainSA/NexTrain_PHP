<?php

require_once('db.php');

$stmt = $con->prepare("SELECT i.id_itinerario, e_origem.nome_estacao AS nome_origem, e_destino.nome_estacao AS nome_destino FROM itinerario AS i JOIN estacao AS e_origem ON i.origem_itinerario = e_origem.id_estacao JOIN estacao AS e_destino ON i.destino_itinerario = e_destino.id_estacao;");
$stmt->execute();
$resultado = $stmt->get_result();

$itinerarios = $resultado->FETCH_ALL(MYSQLI_ASSOC);
