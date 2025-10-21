<?php

require_once('db.php');

$stmt = $con->prepare("SELECT id_estacao, nome_estacao, status_estacao FROM estacao");
$stmt->execute();
$resultado = $stmt->get_result();

$estacoes1 = $resultado->FETCH_ALL(MYSQLI_ASSOC);
$estacoes2 = array();

foreach ($estacoes1 as $estacao) {
    $stmt = $con->prepare("SELECT arestas_grafo_estacoes.*, est_1.nome_estacao AS n1, est_2.nome_estacao AS n2 FROM arestas_grafo_estacoes JOIN estacao AS est_1 ON id_estacao1 = est_1.id_estacao JOIN estacao AS est_2 ON id_estacao2 = est_2.id_estacao WHERE arestas_grafo_estacoes.id_estacao1 = ?;");
    $stmt->bind_param("i", $estacao['id_estacao']);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $connections = $resultado->FETCH_ALL(MYSQLI_ASSOC);
    $estacao['connections'] = $connections;
    array_push($estacoes2, $estacao);
}

$estacoes = $estacoes2;

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
};

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
    };
};
