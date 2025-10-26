<main class="routes-container">
    
<div class="routes-grid">
<?php
$query = "SELECT * FROM trens"; 
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '
        <md-card class="route-detail-card">
            <div class="route-card-content">
                <div class="route-header">
                    <div class="route-icon-wrapper">
                        <md-icon class="route-icon">train</md-icon>
                    </div>
                    <div class="route-info">
                        <h3 class="route-name">'.htmlspecialchars($row['nome_trem']).'</h3>
                        <p class="route-line">'.htmlspecialchars($row['modelo_trem']).'</p>
                    </div>
                    <md-chip label="Ativo" class="status-chip status-on-time">
                        <md-icon slot="icon">check_circle</md-icon>
                    </md-chip>
                </div>

                <div class="route-details">
                    <div class="route-path">
                        <span class="station">'.htmlspecialchars($row['infos_trem']).'</span>
                    </div>
                </div>

                <div class="route-actions">
                    <md-text-button>
                        <md-icon slot="icon">edit</md-icon>
                        Editar
                    </md-text-button>
                    <md-text-button class="delete-btn" data-trem-id="'.$row['id_trem'].'">
                        <md-icon slot="icon">delete</md-icon>
                        Excluir
                    </md-text-button>
                </div>
            </div>
        </md-card>
        ';
    }
} else {
    echo '<p style="text-align:center;">Não tem trem :(.</p>';
}
?>
</div>
</main>
