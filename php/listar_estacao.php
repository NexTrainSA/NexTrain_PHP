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

function getIconFromStatus($status) {
    switch($status) {
        case 'OPEN':
            return 'success';
        case 'MAINTENANCE':
            return 'maintenance';
        case 'PERMANENTLY_CLOSED':
            return 'inactive';
        default:
            return 'warning';
    }
}
