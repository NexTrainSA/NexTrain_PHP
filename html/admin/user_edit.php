<link rel="stylesheet" href="css/admin.css">
<script src="js/admin-icon-loader.js"></script>

<?php
   global $con;
   $conn = $con;

   $conn->real_query("SHOW COLUMNS FROM usuario;");
   $result = $conn->use_result();

   $fields = array();

    foreach($result as $name) {
        array_push($fields, $name["Field"]);
    }

    $result->free();

    if(array_key_exists("delete_id", $_GET)) {
        $conn->query("DELETE FROM usuario WHERE id_usuario=".$_GET["delete_id"]."");
   }

?>

<main class="dashboard-container user-management">
    <!-- Welcome Section -->
    <section class="welcome-section admin-welcome">
        <div class="welcome-content">
            <h1 class="dashboard-title">Gerenciamento de Usuários</h1>
            <p class="dashboard-subtitle">Criar, editar e gerenciar usuários do sistema</p>
        </div>
        <div class="admin-actions">
            <md-text-button onclick="history.back()">
                <md-icon slot="icon">arrow_back</md-icon>
                Voltar
            </md-text-button>
            <md-outlined-button onclick="refreshUserList()">
                <md-icon slot="icon">refresh</md-icon>
                Atualizar
            </md-outlined-button>
        </div>
    </section>

    <!-- User Statistics -->
    <section class="stats-section admin-stats">
        <div class="stats-grid">
            <md-card class="stat-card">
                <div class="stat-content">
                    <md-icon class="stat-icon total-users">group</md-icon>
                    <div class="stat-info">
                        <?php
                            $conn->real_query("SELECT COUNT(*) as count FROM usuario;");
                            $result = $conn->use_result();
                            $totalUsers = $result->fetch_assoc()['count'];
                            $result->free();
                        ?>
                        <span class="stat-value"><?php echo $totalUsers; ?></span>
                        <span class="stat-label">Total de Usuários</span>
                    </div>
                </div>
            </md-card>
        </div>
    </section>

    <!-- Main Content -->
    <div class="user-management-grid">
        <!-- Users List Section -->
        <section class="users-list-section">
            <md-card class="users-table-card">
                <div class="card-header">
                    <h2 class="card-title">Lista de Usuários</h2>
                    <div class="table-actions">
                        <md-outlined-text-field 
                            label="Buscar usuários" 
                            type="search"
                            id="user-search">
                            <md-icon slot="leading-icon">search</md-icon>
                        </md-outlined-text-field>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <?php 
                                    foreach($fields as $name) {
                                        if($name !== 'id_usuario') {
                                            echo "<th>" . ucfirst(str_replace('_', ' ', $name)) . "</th>";
                                        }
                                    }
                                    echo "<th>Ações</th>";
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $conn->real_query("SELECT * FROM usuario;");
                                $result2 = $conn->use_result();

                                foreach($result2 as $row) {
                                    echo "<tr class='user-row' data-user-id='".$row["id_usuario"]."'>";
                                    foreach($row as $key => $value) {
                                        if($key !== 'id_usuario') {
                                            if(strlen($value) == 32) {
                                                $value = "••••••••";
                                            }
                                            echo "<td>" . htmlspecialchars($value) . "</td>";
                                        }
                                    }
                                    echo "<td class='action-cell'>";
                                    echo "<div class='action-buttons'>";
                                    echo "<md-icon-button onclick='editUser(".$row["id_usuario"].")' title='Editar'>";
                                    echo "<md-icon>edit</md-icon>";
                                    echo "</md-icon-button>";
                                    echo "<md-icon-button onclick='managePermissions(".$row["id_usuario"].")' title='Permissões'>";
                                    echo "<md-icon>security</md-icon>";
                                    echo "</md-icon-button>";
                                    echo "<md-icon-button onclick='deleteUser(".$row["id_usuario"].", \"".htmlspecialchars($row["username_usuario"])."\")' title='Excluir'>";
                                    echo "<md-icon>delete</md-icon>";
                                    echo "</md-icon-button>";
                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                $result2->free();
                            ?>
                        </tbody>
                    </table>
                </div>
            </md-card>
        </section>

        <!-- Create User Section -->
        <section class="create-user-section">
            <md-card class="create-user-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <md-icon>person_add</md-icon>
                        Novo Usuário
                    </h2>
                </div>
                
                <form action="php/usermod_handler.php" method="POST" class="user-form">
                    <div class="form-fields">
                        <?php
                            foreach($fields as $name) {
                                if(str_starts_with($name, "id_")) {
                                    continue;
                                }
                                
                                $label = ucfirst(str_replace('_', ' ', $name));
                                $isPassword = str_starts_with($name, "senha_");
                                $type = $isPassword ? 'password' : 'text';
                                
                                echo "<md-outlined-text-field";
                                echo " label='" . htmlspecialchars($label) . "'";
                                echo " name='" . htmlspecialchars($name) . "'";
                                echo " type='" . $type . "'";
                                echo " required";
                                echo " class='form-field'>";
                                
                                if($isPassword) {
                                    echo "<md-icon slot='trailing-icon'>visibility</md-icon>";
                                }
                                
                                echo "</md-outlined-text-field>";
                            }
                        ?>
                    </div>
                    
                    <div class="form-actions">
                        <md-filled-button type="submit" name="submit" value="insert">
                            <md-icon slot="icon">add</md-icon>
                            Criar Usuário
                        </md-filled-button>
                    </div>
                </form>
            </md-card>
        </section>

        <!-- Edit User Section (conditionally shown) -->
        <?php if(array_key_exists("edit_id", $_GET)): ?>
        <section class="edit-user-section">
            <md-card class="edit-user-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <md-icon>edit</md-icon>
                        Editar Usuário
                    </h2>
                </div>
                
                <form action="php/usermod_handler.php" method="POST" class="user-form">
                    <div class="form-fields">
                        <?php
                            $edit_id = $_GET["edit_id"];
                            $conn->real_query("SELECT * FROM usuario WHERE id_usuario = " . $edit_id);
                            $result3 = $conn->use_result();

                            foreach($result3 as $result) {
                                foreach(array_keys($result) as $key) {
                                    $val = $result[$key];
                                    $label = ucfirst(str_replace('_', ' ', $key));
                                    $isPassword = str_starts_with($key, "senha_");
                                    $type = $isPassword ? 'password' : 'text';
                                    $value = $isPassword ? '' : htmlspecialchars($val);
                                    
                                    echo "<md-outlined-text-field";
                                    echo " label='" . htmlspecialchars($label) . "'";
                                    echo " name='" . htmlspecialchars($key) . "'";
                                    echo " type='" . $type . "'";
                                    echo " value='" . $value . "'";
                                    echo " class='form-field'";
                                    if($key === 'id_usuario') echo " readonly";
                                    echo ">";
                                    
                                    if($isPassword) {
                                        echo "<md-icon slot='trailing-icon'>visibility</md-icon>";
                                    }
                                    
                                    echo "</md-outlined-text-field>";
                                }
                            }
                            $result3->free();
                        ?>
                    </div>
                    
                    <div class="form-actions">
                        <md-outlined-button type="button" onclick="cancelEdit()">
                            Cancelar
                        </md-outlined-button>
                        <md-filled-button type="submit" name="submit" value="edit">
                            <md-icon slot="icon">save</md-icon>
                            Salvar Alterações
                        </md-filled-button>
                    </div>
                </form>
            </md-card>
        </section>
        <?php endif; ?>
    </div>
</main>

<!-- Delete Confirmation Dialog -->
<md-dialog id="delete-dialog">
    <div slot="headline">Confirmar Exclusão</div>
    <div slot="content">
        <p>Tem certeza que deseja excluir o usuário <strong id="delete-username"></strong>?</p>
        <p>Esta ação não pode ser desfeita.</p>
    </div>
    <div slot="actions">
        <md-text-button onclick="closeDeleteDialog()">Cancelar</md-text-button>
        <md-filled-button onclick="confirmDelete()" style="--md-filled-button-container-color: #D32F2F;">
            <md-icon slot="icon">delete</md-icon>
            Excluir
        </md-filled-button>
    </div>
</md-dialog>

<script>
let userToDelete = null;

function editUser(userId) {
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('edit_id', userId);
    window.location.href = currentUrl.toString();
}

function managePermissions(userId) {
    window.location.href = `?page=admin/permission_edit.php&user_id=${userId}`;
}

function deleteUser(userId, username) {
    userToDelete = userId;
    document.getElementById('delete-username').textContent = username;
    document.getElementById('delete-dialog').open = true;
}

function closeDeleteDialog() {
    document.getElementById('delete-dialog').open = false;
    userToDelete = null;
}

function confirmDelete() {
    if (userToDelete) {
        const currentUrl = new URL(window.location);
        currentUrl.searchParams.set('delete_id', userToDelete);
        window.location.href = currentUrl.toString();
    }
}

function cancelEdit() {
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.delete('edit_id');
    window.location.href = currentUrl.toString();
}

function refreshUserList() {
    window.location.reload();
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchField = document.getElementById('user-search');
    
    if (searchField) {
        searchField.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.user-row');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
    
    // Password visibility toggle
    document.querySelectorAll('md-outlined-text-field[type="password"]').forEach(field => {
        const icon = field.querySelector('md-icon[slot="trailing-icon"]');
        if (icon) {
            icon.addEventListener('click', function() {
                const isPassword = field.type === 'password';
                field.type = isPassword ? 'text' : 'password';
                this.textContent = isPassword ? 'visibility_off' : 'visibility';
            });
        }
    });
});
</script>