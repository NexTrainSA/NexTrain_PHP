<link rel="stylesheet" href="css/admin.css">
<script src="js/admin-icon-loader.js"></script>

<?php
    if(!check_user_permission($_SESSION["username"], "APP_INFO")) {
        echo "<main class='dashboard-container'>";
        echo "<md-card class='error-card'>";
        echo "<div class='error-content'>";
        echo "<md-icon class='error-icon'>block</md-icon>";
        echo "<h1 class='error-title'>Acesso Negado</h1>";
        echo "<p class='error-message'>Você não tem permissão para acessar essa página!</p>";
        echo "<md-outlined-button onclick='history.back()'>Voltar</md-outlined-button>";
        echo "</div>";
        echo "</md-card>";
        echo "</main>";
        die();
    }

    $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));
    $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
    $commitDate->setTimezone(new \DateTimeZone('America/Sao_Paulo'));
    $commitAuthor = trim(exec('git log -n1 --pretty=%cn HEAD'));
?>

<main class="dashboard-container system-info">
    <!-- Page Header -->
    <section class="page-header app-info-header">
        <div class="header-breadcrumb">
            <md-text-button onclick="history.back()">
                <md-icon slot="icon">arrow_back</md-icon>
                Voltar
            </md-text-button>
        </div>
        
        <div class="header-content">
            <div class="title-section">
                <md-icon class="page-icon">info</md-icon>
                <div class="title-text">
                    <h1 class="page-title">Informações do Sistema</h1>
                    <p class="page-subtitle">Detalhes técnicos e versão do aplicativo</p>
                </div>
            </div>
        </div>
    </section>

    <!-- App Information Cards -->
    <section class="app-info-section">
        <div class="info-grid">
            <!-- Version Info -->
            <md-card class="info-card">
                <div class="info-header">
                    <md-icon class="info-icon version-icon">label</md-icon>
                    <h3 class="info-title">Versão</h3>
                </div>
                <div class="info-content">
                    <span class="info-value"><?php echo htmlspecialchars($commitHash); ?></span>
                    <span class="info-description">Hash do commit atual</span>
                </div>
            </md-card>

            <!-- Last Update -->
            <md-card class="info-card">
                <div class="info-header">
                    <md-icon class="info-icon date-icon">schedule</md-icon>
                    <h3 class="info-title">Última Atualização</h3>
                </div>
                <div class="info-content">
                    <span class="info-value"><?php echo $commitDate->format('d/m/Y H:i:s'); ?></span>
                    <span class="info-description">Data do último commit</span>
                </div>
            </md-card>

            <!-- Author -->
            <md-card class="info-card">
                <div class="info-header">
                    <md-icon class="info-icon author-icon">person</md-icon>
                    <h3 class="info-title">Autor</h3>
                </div>
                <div class="info-content">
                    <span class="info-value"><?php echo htmlspecialchars($commitAuthor); ?></span>
                    <span class="info-description">Autor do último commit</span>
                </div>
            </md-card>

            <!-- System Status -->
            <md-card class="info-card">
                <div class="info-header">
                    <md-icon class="info-icon status-icon">check_circle</md-icon>
                    <h3 class="info-title">Status</h3>
                </div>
                <div class="info-content">
                    <span class="info-value status-online">Online</span>
                    <span class="info-description">Sistema operacional</span>
                </div>
            </md-card>
        </div>
    </section>

    <!-- System Information -->
    <section class="system-info-section">
        <md-card class="system-info-card">
            <div class="card-header">
                <h2 class="card-title">
                    <md-icon>computer</md-icon>
                    Informações do Sistema
                </h2>
                <div class="system-actions">
                    <md-outlined-button onclick="toggleSystemInfo()">
                        <md-icon slot="icon">visibility</md-icon>
                        <span id="toggle-text">Mostrar Detalhes</span>
                    </md-outlined-button>
                </div>
            </div>
            
            <div id="php-info-container" class="php-info-container" style="display: none;">
                <div class="system-stats">
                    <div class="stat-item">
                        <span class="stat-label">PHP Version:</span>
                        <span class="stat-value"><?php echo phpversion(); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Server:</span>
                        <span class="stat-value"><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Document Root:</span>
                        <span class="stat-value"><?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown'; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Memory Limit:</span>
                        <span class="stat-value"><?php echo ini_get('memory_limit'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Max Execution Time:</span>
                        <span class="stat-value"><?php echo ini_get('max_execution_time'); ?>s</span>
                    </div>
                </div>
                
                <div class="phpinfo-wrapper">
                    <?php 
                        ob_start();
                        phpinfo();
                        $phpinfo = ob_get_contents();
                        ob_end_clean();
                        
                        // Clean up phpinfo output to make it more presentable
                        $phpinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $phpinfo);
                        $phpinfo = preg_replace('/<table[^>]*>/', '<table class="phpinfo-table">', $phpinfo);
                        echo $phpinfo;
                    ?>
                </div>
            </div>
        </md-card>
    </section>

    <!-- Environment Details -->
    <section class="environment-section">
        <md-card class="environment-card">
            <div class="card-header">
                <h2 class="card-title">
                    <md-icon>settings</md-icon>
                    Configurações do Ambiente
                </h2>
            </div>
            
            <div class="environment-grid">
                <div class="env-item">
                    <md-icon class="env-icon">storage</md-icon>
                    <div class="env-info">
                        <span class="env-label">Banco de Dados</span>
                        <span class="env-value">MySQL/MariaDB</span>
                    </div>
                </div>
                
                <div class="env-item">
                    <md-icon class="env-icon">web</md-icon>
                    <div class="env-info">
                        <span class="env-label">Servidor Web</span>
                        <span class="env-value">Apache/Nginx</span>
                    </div>
                </div>
                
                <div class="env-item">
                    <md-icon class="env-icon">code</md-icon>
                    <div class="env-info">
                        <span class="env-label">Framework</span>
                        <span class="env-value">PHP Nativo</span>
                    </div>
                </div>
                
                <div class="env-item">
                    <md-icon class="env-icon">palette</md-icon>
                    <div class="env-info">
                        <span class="env-label">UI Framework</span>
                        <span class="env-value">Material Design 3</span>
                    </div>
                </div>
            </div>
        </md-card>
    </section>
</main>

<script>
function toggleSystemInfo() {
    const container = document.getElementById('php-info-container');
    const toggleText = document.getElementById('toggle-text');
    const isVisible = container.style.display !== 'none';
    
    container.style.display = isVisible ? 'none' : 'block';
    toggleText.textContent = isVisible ? 'Mostrar Detalhes' : 'Ocultar Detalhes';
}
</script>