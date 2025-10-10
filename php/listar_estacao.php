<?php

require_once('db.php');

$stmt = $con->prepare("SELECT * FROM estacao");
$stmt->execute();
$resultado = $stmt->get_result();

$estacoes = $resultado->FETCH_ALL(MYSQLI_ASSOC);

function translateStationStatus($status) {
    switch($status) {
        case 'OPEN':
            return 'Aberto';
        case 'MAINTENANCE':
            return 'Manutenção';
        case 'PERMANENTLY_CLOSED':
            return 'Fechado Permanentemente';
        default:
            return 'Desconhecido';
    }
}