<?php
// Se este arquivo for um include, o require_once deve ser relativo ao arquivo principal.
require_once('db.php'); 

$con = get_con();

// Sua query original do listar_trem.php
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

// ... Resto do seu HTML
?>