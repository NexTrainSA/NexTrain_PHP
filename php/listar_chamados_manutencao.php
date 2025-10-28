<?php

require_once('db.php');

$stmt = $con->prepare("SELECT id_funcionario, id_trem, descricao_problema, data_entrada FROM chamados_manutencao");
$stmt->execute();
$resultado = $stmt->get_result();

$chamados = $resultado->FETCH_ALL(MYSQLI_ASSOC);


