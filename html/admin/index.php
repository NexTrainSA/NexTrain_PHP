<link rel="stylesheet" href="css/admin.css">
<script src="js/admin-icon-loader.js"></script>

<main class="dashboard-container admin-dashboard">
    <!-- Welcome Section -->
    <section class="welcome-section admin-welcome">
        <div class="welcome-content">
            <h1 class="dashboard-title">Painel de Administração</h1>
            <p class="dashboard-subtitle">Gerencie usuários, permissões e sistema NexTrain</p>
        </div>
    </section>

    <!-- Quick Stats -->
    <section class="stats-section admin-stats">
        <div class="stats-grid">
            <md-card class="stat-card">
                <div class="stat-content">
                    <md-icon class="stat-icon users-icon">group</md-icon>
                    <div class="stat-info">
                        <?php
                        global $con;
                        $conn = $con;
                        $conn->real_query("SELECT COUNT(*) as count FROM usuario;");
                        $result = $conn->use_result();
                        $userCount = $result->fetch_assoc()['count'];
                        $result->free();
                        ?>
                        <span class="stat-value"><?php echo $userCount; ?></span>
                        <span class="stat-label">Usuários</span>
                    </div>
                </div>
            </md-card>

            <md-card class="stat-card">
                <div class="stat-content">
                    <md-icon class="stat-icon permissions-icon">security</md-icon>
                    <div class="stat-info">
                        <?php
                        $conn->real_query("SELECT COUNT(*) as count FROM permissao;");
                        $result = $conn->use_result();
                        $permCount = $result->fetch_assoc()['count'];
                        $result->free();
                        ?>
                        <span class="stat-value"><?php echo $permCount; ?></span>
                        <span class="stat-label">Permissões</span>
                    </div>
                </div>
            </md-card>

            <md-card class="stat-card">
                <div class="stat-content">
                    <md-icon class="stat-icon system-icon">monitor_heart</md-icon>
                    <div class="stat-info">
                        <span class="stat-value">Online</span>
                        <span class="stat-label">Sistema</span>
                    </div>
                </div>
            </md-card>
        </div>
    </section>

    <!-- Management Cards -->
    <section class="management-section">
        <div class="section-header">
            <h2 class="section-title">Gerenciamento</h2>
            <p class="section-subtitle">Acesse as ferramentas de administração</p>
        </div>

        <div class="management-grid">
            <md-card class="management-card" onclick="navigateTo('?page=admin/user_edit.php')">
                <div class="card-content">
                    <div class="card-header">
                        <div class="card-icon-wrapper users-bg">
                            <md-icon class="card-icon">people</md-icon>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title">Gerenciar Usuários</h3>
                            <p class="card-description">Criar, editar e excluir usuários do sistema</p>
                        </div>
                    </div>

                    <div class="card-actions">
                        <md-text-button>
                            <md-icon slot="icon">arrow_forward</md-icon>
                            Acessar
                        </md-text-button>
                    </div>
                </div>
            </md-card>

            <md-card class="management-card" onclick="navigateTo('?page=admin/permission_edit.php')">
                <div class="card-content">
                    <div class="card-header">
                        <div class="card-icon-wrapper permissions-bg">
                            <md-icon class="card-icon">shield</md-icon>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title">Permissões</h3>
                            <p class="card-description">Gerenciar permissões e acessos dos usuários</p>
                        </div>
                    </div>

                    <div class="card-actions">
                        <md-text-button>
                            <md-icon slot="icon">arrow_forward</md-icon>
                            Acessar
                        </md-text-button>
                    </div>
                </div>
            </md-card>

            <md-card class="management-card" onclick="navigateTo('?page=admin/app_info.php')">
                <div class="card-content">
                    <div class="card-header">
                        <div class="card-icon-wrapper system-bg">
                            <md-icon class="card-icon">info</md-icon>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title">Informações do Sistema</h3>
                            <p class="card-description">Visualizar informações técnicas e versão</p>
                        </div>
                    </div>

                    <div class="card-actions">
                        <md-text-button>
                            <md-icon slot="icon">arrow_forward</md-icon>
                            Acessar
                        </md-text-button>
                    </div>
                </div>
            </md-card>

            <md-card class="management-card" onclick="openDatabaseManager()">
                <div class="card-content">
                    <div class="card-header">
                        <div class="card-icon-wrapper database-bg">
                            <md-icon class="card-icon">storage</md-icon>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title">Banco de Dados</h3>
                            <p class="card-description">Gerenciar e monitorar o banco de dados</p>
                        </div>
                    </div>

                    <div class="card-actions">
                        <md-text-button>
                            <md-icon slot="icon">arrow_forward</md-icon>
                            Acessar
                        </md-text-button>
                    </div>
                </div>
            </md-card>
        </div>
    </section>

    <!-- Recent Activity -->
    <section class="activity-section">
        <div class="section-header">
            <h2 class="section-title">Atividade Recente</h2>
        </div>

        <md-card class="activity-card">
            <div class="activity-content">
                <div class="activity-item">
                    <md-icon class="activity-icon">person_add</md-icon>
                    <div class="activity-info">
                        <span class="activity-text">Novo usuário criado</span>
                        <span class="activity-time">Há 2 horas</span>
                    </div>
                </div>

                <div class="activity-item">
                    <md-icon class="activity-icon">security</md-icon>
                    <div class="activity-info">
                        <span class="activity-text">Permissões atualizadas</span>
                        <span class="activity-time">Há 4 horas</span>
                    </div>
                </div>

                <div class="activity-item">
                    <md-icon class="activity-icon">update</md-icon>
                    <div class="activity-info">
                        <span class="activity-text">Sistema atualizado</span>
                        <span class="activity-time">Ontem</span>
                    </div>
                </div>
            </div>
        </md-card>
    </section>
</main>

<script>
    function navigateTo(url) {
        window.location.href = url;
    }

    function refreshData() {
        window.location.reload();
    }

    function openSystemSettings() {
        alert('Configurações do sistema - Em desenvolvimento');
    }

    function openDatabaseManager() {
        alert('Gerenciador de banco de dados - Em desenvolvimento');
    }

    // Immediate icon fix for admin page
    if (typeof window.fixAdminIcons === 'function') {
        window.fixAdminIcons();
    } else {
        // Fallback if script hasn't loaded yet
        setTimeout(function() {
            if (typeof window.fixAdminIcons === 'function') {
                window.fixAdminIcons();
            }
        }, 500);
    }
</script>