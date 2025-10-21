<?php

require_once('db.php');

$stmt = $con->prepare("SELECT rota.*, it.origem_itinerario AS id_orig, it.destino_itinerario AS id_dest, est_1.nome_estacao AS n1, est_2.nome_estacao AS n2 FROM rota 
	JOIN itinerario AS it ON itinerario_rota = it.id_itinerario
	JOIN estacao AS est_1 ON origem_itinerario = est_1.id_estacao 
	JOIN estacao AS est_2 ON destino_itinerario = est_2.id_estacao	
;");
$stmt->execute();
$resultado = $stmt->get_result();

$routes = $resultado->FETCH_ALL(MYSQLI_ASSOC);

function get_trajectory_station_names($caminho_rota) {
    global $con;
    $station_ids = explode(',', $caminho_rota);
    $station_names = [];

    $placeholders = implode(',', array_fill(0, count($station_ids), '?'));
    $stmt = $con->prepare("SELECT id_estacao, nome_estacao FROM estacao WHERE id_estacao IN ($placeholders)");
    $stmt->bind_param(str_repeat('i', count($station_ids)), ...$station_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    $stations = [];
    while ($row = $result->fetch_assoc()) {
        $stations[$row['id_estacao']] = $row['nome_estacao'];
    }

    foreach ($station_ids as $id) {
        if (isset($stations[$id])) {
            $station_names[] = $stations[$id];
        }
    }

    return implode(' -> ', $station_names);
}

/*

                            <div class="route-path">
                                <span class="station">'.$route['n1'].'</span>
                                <md-icon class="path-arrow">arrow_forward</md-icon>
                                <span class="station">'.$route['n2'].'</span>
                            </div>
*/

function render_route_path($route) {
    
    $html = '<div class="route-path">';

    $traj = explode(",",$route["caminho_rota"]);

    $traj = array_merge(array($route["id_orig"]), $traj);

    foreach ($traj as $index => $station_id) {
        global $con;
        $stmt = $con->prepare("SELECT nome_estacao FROM estacao WHERE id_estacao = ?");
        $stmt->bind_param("i", $station_id);
    $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $html .= '<span class="station">'.$row['nome_estacao'].'</span>';
            if ($index < count($traj) - 1) {
                $html .= '<md-icon class="path-arrow">arrow_forward</md-icon>';
            }
        }
    }

    $html .= '</div>';

    return $html;
}