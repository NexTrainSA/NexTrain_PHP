<?php

require_once('db.php'); 


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: listar_chamados_manutencao.php?status=error_method");
    exit();
}

$ordem_servico = $_POST['ordem_servico'] ?? null;
$id_funcionario = $_POST['id_funcionario'] ?? null;
$id_trem = $_POST['id_trem'] ?? null;
$descricao_problema = $_POST['descricao_problema'] ?? null;
$data_entrada = $_POST['data_entrada'] ?? null; 


if (empty($ordem_servico) || empty($id_funcionario) || empty($id_trem) || empty($descricao_problema) || empty($data_entrada)) {
    header("Location: editar_chamados.php?ordem_servico={$ordem_servico}&status=missing_fields");
    exit();
}

$con = get_con();


$sql = "UPDATE chamados_manutencao 
        SET id_funcionario = ?, id_trem = ?, descricao_problema = ?, data_entrada = ? 
        WHERE ordem_servico = ?";

$stmt = $con->prepare($sql);


$stmt->bind_param("iisss", $id_funcionario, $id_trem, $descricao_problema, $data_entrada, $ordem_servico);


if ($stmt->execute()) {
    
    header("Location: maintenance.php?status=success_edit");
} else {
   
    header("Location: maintenance.php?status=error_edit");
}
exit();