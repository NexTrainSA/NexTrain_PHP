<?php

require_once('db.php');

$stmt = $con->prepare("SELECT 
                a.id_alerta, 
                a.descricao_alerta, 
                remetente.username_usuario AS nome_remetente,
                destinatario.username_usuario AS nome_destinatario
            FROM alertas a
            JOIN usuario remetente ON remetente.id_usuario = a.id_funcionario
            JOIN usuario destinatario ON destinatario.id_usuario = a.id_funcionario_recebe");
$stmt->execute();
$resultado = $stmt->get_result();

$alertas = $resultado->FETCH_ALL(MYSQLI_ASSOC);


