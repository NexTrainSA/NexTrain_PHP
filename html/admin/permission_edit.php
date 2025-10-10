<link rel="stylesheet" href="css/admin.css">
<script src="js/admin-icon-loader.js"></script>

<?php
global $con;
$conn = $con;
?>

<main class="dashboard-container permissions-management">
    <!-- Page Header -->
    <section class="page-header permissions-header">
        <div class="header-breadcrumb">
            <md-text-button onclick="history.back()">
                <md-icon slot="icon">arrow_back</md-icon>
                Voltar
            </md-text-button>
        </div>

        <div class="header-content">
            <div class="title-section">
                <md-icon class="page-icon">security</md-icon>
                <div class="title-text">
                    <h1 class="page-title">Gerenciamento de Permissões</h1>
                    <p class="page-subtitle">Controle os acessos e permissões dos usuários</p>
                </div>
            </div>

            <div class="header-actions">
                <md-filled-button onclick="savePermissions()">
                    <md-icon slot="icon">save</md-icon>
                    Salvar Alterações
                </md-filled-button>
            </div>
        </div>
    </section>

    <?php if (isset($_GET["user_id"])): ?>
        <!-- Single User Permissions -->
        <?php
        $userId = $_GET["user_id"];
        $username = get_username_from_id($userId);
        ?>
        <section class="single-user-section">
            <md-card class="user-info-card">
                <div class="user-info-header">
                    <md-icon class="user-avatar">account_circle</md-icon>
                    <div class="user-details">
                        <h3 class="username"><?php echo htmlspecialchars($username); ?></h3>
                        <p class="user-id">ID: <?php echo $userId; ?></p>
                    </div>
                </div>
            </md-card>

            <md-card class="permissions-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <md-icon>shield</md-icon>
                        Permissões do Usuário
                    </h2>
                </div>

                <div class="permissions-grid">
                    <?php
                    // Use buffered query to avoid "Commands out of sync" error
                    $result = mysqli_query($conn, "SELECT * FROM permissao");

                    if ($result) {
                        while ($perm = mysqli_fetch_assoc($result)) {
                            $permName = $perm["nome_permissao"];
                            $hasPermission = check_user_permission($username, $permName);
                            $permLabel = ucfirst(str_replace('_', ' ', $permName));

                            echo "<div class='permission-item'>";
                            echo "<div class='permission-info'>";
                            echo "<span class='permission-name'>" . htmlspecialchars($permLabel) . "</span>";
                            echo "<span class='permission-description'>Permite acesso a " . strtolower($permLabel) . "</span>";
                            echo "</div>";
                            echo "<md-switch class='permission-switch' data-permission='" . htmlspecialchars($permName) . "' data-user-id='" . $userId . "'";
                            if ($hasPermission) echo " selected";
                            echo " onchange='togglePermission(this)'></md-switch>";
                            echo "</div>";
                        }
                        mysqli_free_result($result);
                    }
                    ?>
                </div>
            </md-card>
        </section>
    <?php else: ?>
        <!-- All Users Permissions Matrix -->
        <section class="permissions-matrix-section">
            <md-card class="permissions-matrix-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <md-icon>grid_view</md-icon>
                        Matrix de Permissões
                    </h2>
                    <div class="matrix-actions">
                        <md-outlined-text-field
                            label="Buscar usuário"
                            type="search"
                            id="user-permission-search">
                            <md-icon slot="leading-icon">search</md-icon>
                        </md-outlined-text-field>
                    </div>
                </div>

                <div class="matrix-container">
                    <table class="permissions-matrix">
                        <thead>
                            <tr>
                                <th class="user-column">Usuário</th>
                                <?php
                                $perm = array();
                                // Use buffered query to avoid "Commands out of sync" error
                                $result3 = mysqli_query($conn, "SELECT * FROM permissao");

                                if ($result3) {
                                    while ($name = mysqli_fetch_assoc($result3)) {
                                        $permName = $name["nome_permissao"];
                                        array_push($perm, $permName);
                                        $permLabel = ucfirst(str_replace('_', ' ', $permName));
                                        echo "<th class='permission-column' title='" . htmlspecialchars($permLabel) . "'>";
                                        echo "<div class='permission-header'>";
                                        echo "<md-icon>security</md-icon>";
                                        echo "<span>" . htmlspecialchars($permLabel) . "</span>";
                                        echo "</div>";
                                        echo "</th>";
                                    }
                                    mysqli_free_result($result3);
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Use buffered query to avoid "Commands out of sync" error
                            $result2 = mysqli_query($conn, "SELECT * FROM usuario");

                            if ($result2) {
                                while ($user = mysqli_fetch_assoc($result2)) {
                                    $userId = $user["id_usuario"];
                                    $username = $user["username_usuario"];

                                    echo "<tr class='user-permission-row' data-username='" . strtolower($username) . "'>";
                                    echo "<td class='user-cell'>";
                                    echo "<div class='user-info'>";
                                    echo "<md-icon class='user-icon'>account_circle</md-icon>";
                                    echo "<div class='user-text'>";
                                    echo "<span class='user-name'>" . htmlspecialchars($username) . "</span>";
                                    echo "<span class='user-id-small'>ID: " . $userId . "</span>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</td>";

                                    foreach ($perm as $permName) {
                                        $hasPermission = check_user_permission($username, $permName);
                                        echo "<td class='permission-cell'>";
                                        echo "<md-checkbox class='permission-checkbox'";
                                        echo " data-user-id='" . $userId . "'";
                                        echo " data-permission='" . htmlspecialchars($permName) . "'";
                                        if ($hasPermission) echo " checked";
                                        echo " onchange='togglePermission(this)'></md-checkbox>";
                                        echo "</td>";
                                    }
                                    echo "</tr>";
                                }
                                mysqli_free_result($result2);
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="matrix-footer">
                    <div class="bulk-actions">
                        <md-outlined-button onclick="selectAllPermissions()">
                            <md-icon slot="icon">select_all</md-icon>
                            Selecionar Tudo
                        </md-outlined-button>
                        <md-outlined-button onclick="clearAllPermissions()">
                            <md-icon slot="icon">clear_all</md-icon>
                            Limpar Tudo
                        </md-outlined-button>
                    </div>

                    <md-filled-button onclick="saveAllPermissions()">
                        <md-icon slot="icon">save</md-icon>
                        Salvar Todas as Alterações
                    </md-filled-button>
                </div>
            </md-card>
        </section>
    <?php endif; ?>
</main>

<script>
    // Permission management functions
    function savePermissions() {
        const userId = <?php echo isset($_GET["user_id"]) ? intval($_GET["user_id"]) : 'null'; ?>;

        if (!userId) {
            alert('ID do usuário não encontrado');
            return;
        }

        const permissions = [];
        document.querySelectorAll('.permission-switch[selected], .permission-switch:checked').forEach(element => {
            permissions.push(element.dataset.permission);
        });

        const data = {
            action: 'save_single_user',
            userId: userId,
            permissions: permissions
        };

        fetch('php/permission_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showMessage('Sucesso', result.message, 'success');
                } else {
                    showMessage('Erro', result.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Erro', 'Erro de conexão ao salvar permissões', 'error');
            });
    }

    function saveAllPermissions() {
        const changes = [];
        document.querySelectorAll('.permission-checkbox, .permission-switch').forEach(element => {
            const userId = element.dataset.userId;
            const permission = element.dataset.permission;
            const isChecked = element.hasAttribute('selected') || element.checked;

            changes.push({
                userId: parseInt(userId),
                permission: permission,
                granted: isChecked
            });
        });

        const data = {
            action: 'save_all_permissions',
            changes: changes
        };

        fetch('php/permission_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showMessage('Sucesso', `${result.updated_count} permissões atualizadas com sucesso`, 'success');
                } else {
                    showMessage('Erro', result.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Erro', 'Erro de conexão ao salvar permissões', 'error');
            });
    }

    function selectAllPermissions() {
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = true;
            checkbox.setAttribute('checked', '');
        });
    }

    function clearAllPermissions() {
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = false;
            checkbox.removeAttribute('checked');
        });
    }

    // Toggle individual permission
    function togglePermission(element) {
        const userId = element.dataset.userId;
        const permission = element.dataset.permission;
        const granted = element.hasAttribute('selected') || element.checked;

        const data = {
            action: 'toggle_permission',
            userId: parseInt(userId),
            permission: permission,
            granted: granted
        };

        fetch('php/permission_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (!result.success) {
                    // Revert the change if it failed
                    if (granted) {
                        element.removeAttribute('selected');
                        element.checked = false;
                    } else {
                        element.setAttribute('selected', '');
                        element.checked = true;
                    }
                    showMessage('Erro', result.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert the change if it failed
                if (granted) {
                    element.removeAttribute('selected');
                    element.checked = false;
                } else {
                    element.setAttribute('selected', '');
                    element.checked = true;
                }
                showMessage('Erro', 'Erro de conexão ao alterar permissão', 'error');
            });
    }

    // Message display function
    function showMessage(title, message, type = 'info') {
        // Create a simple alert dialog
        const dialog = document.createElement('md-dialog');
        dialog.innerHTML = `
        <div slot="headline" style="display: flex; align-items: center; gap: 8px;">
            <md-icon style="color: ${type === 'success' ? '#4CAF50' : type === 'error' ? '#F44336' : '#2196F3'};">
                ${type === 'success' ? 'check_circle' : type === 'error' ? 'error' : 'info'}
            </md-icon>
            <span>${title}</span>
        </div>
        <div slot="content">
            <p>${message}</p>
        </div>
        <div slot="actions">
            <md-filled-button onclick="this.closest('md-dialog').close()">
                OK
            </md-filled-button>
        </div>
    `;

        document.body.appendChild(dialog);
        dialog.open = true;

        // Remove dialog after it's closed
        dialog.addEventListener('close', () => {
            document.body.removeChild(dialog);
        });
    }

    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchField = document.getElementById('user-permission-search');

        if (searchField) {
            searchField.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('.user-permission-row');

                rows.forEach(row => {
                    const username = row.dataset.username;
                    row.style.display = username.includes(searchTerm) ? '' : 'none';
                });
            });
        }

        // Add event listeners for permission changes
        document.querySelectorAll('.permission-checkbox, .permission-switch').forEach(element => {
            element.addEventListener('change', function() {
                // Optional: Auto-save on change (uncomment if desired)
                // togglePermission(this);
            });
        });
    });
</script>