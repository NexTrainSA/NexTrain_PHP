<?php

require_once('db.php');

$con = get_con();

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



foreach ($alertas as $alerta) {
    
    ?>
    <div class="card-alerta">
        <div class="alerta-header">
            De: **<?php echo htmlspecialchars($alerta['nome_remetente']); ?>**
            Para: **<?php echo htmlspecialchars($alerta['nome_destinatario']); ?>**
            <span class="status-check">✅</span>
        </div>

        <div class="alerta-body">
            <p>**Descrição do alerta** -> <?php echo htmlspecialchars($alerta['descricao_alerta']); ?></p>
        </div>

        <div class="alerta-actions">
            <a href="edit_alert.php?id_alerta=<?php echo htmlspecialchars($alerta['id_alerta']); ?>" class="btn-editar">
                <span class="icon-editar">✏️</span> Editar
            </a>

            <a href="delete_alert.php?id_alerta=<?php echo htmlspecialchars($alerta['id_alerta']); ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este alerta?');">
                <span class="icon-excluir">❌</span> Excluir
            </a>
        </div>
    </div>
    <?php
   
}
// ... Resto do seu HTML
?>