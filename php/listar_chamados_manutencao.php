<?php

require_once('db.php');

$stmt = $con->prepare("SELECT 
            c.ordem_servico,
            c.descricao_problema,
            t.nome_trem,
            u.username_usuario
        FROM chamados_manutencao c
        INNER JOIN trens t ON c.id_trem = t.id_trem
        INNER JOIN usuario u ON t.id_funcionario_encarregado_trem = u.id_usuario
        ORDER BY c.ordem_servico");

$stmt->execute();
$resultado = $stmt->get_result();

$chamados = $resultado->FETCH_ALL(MYSQLI_ASSOC);


