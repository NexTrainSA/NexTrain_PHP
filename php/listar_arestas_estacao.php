<?php

require_once('db.php');

$id_estacao = $_GET['id_estacao'] ?? '';

if($id_estacao != '') {
    $stmt = $con->prepare("SELECT arestas_grafo_estacoes.*, est_1.nome_estacao AS n1, est_2.nome_estacao AS n2 FROM arestas_grafo_estacoes JOIN estacao AS est_1 ON id_estacao1 = est_1.id_estacao JOIN estacao AS est_2 ON id_estacao2 = est_2.id_estacao WHERE arestas_grafo_estacoes.id_estacao1 = ?;");
    $stmt->bind_param("i", $id_estacao);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $connections = $resultado->FETCH_ALL(MYSQLI_ASSOC);

    echo json_encode($connections);
}

function list_edges_from_station($station_id) {
    global $con;
    $stmt = $con->prepare("SELECT * FROM arestas_grafo_estacoes WHERE id_estacao1 = ? OR id_estacao2 = ?;");
    $stmt->bind_param("ii", $station_id, $station_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->FETCH_ALL(MYSQLI_ASSOC);
}

function list_all_edges() {
    global $con;
    $stmt = $con->prepare("SELECT * FROM arestas_grafo_estacoes;");
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->FETCH_ALL(MYSQLI_ASSOC);
}