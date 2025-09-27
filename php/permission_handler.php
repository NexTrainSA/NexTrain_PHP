<?php
session_start();
include_once 'db.php';

// Check if user has admin permissions
if (!check_user_permission($_SESSION["username"], "ADMIN_PAGES")) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Acesso negado']);
    exit;
}

global $con;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
        exit;
    }
    
    $action = $input['action'] ?? '';
    
    switch ($action) {
        case 'save_single_user':
            saveSingleUserPermissions($input);
            break;
            
        case 'save_all_permissions':
            saveAllPermissions($input);
            break;
            
        case 'toggle_permission':
            togglePermission($input);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Ação inválida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}

function saveSingleUserPermissions($data) {
    global $con;
    
    $userId = intval($data['userId']);
    $permissions = $data['permissions'] ?? [];
    
    // Validation: Check if we're trying to remove admin permissions from the last admin
    if (!in_array('ADMIN_PAGES', $permissions)) {
        $adminCount = mysqli_query($con, "
            SELECT COUNT(DISTINCT pu.id_usuario_permissao) as admin_count 
            FROM permissao_usuario pu 
            JOIN permissao p ON pu.id_permissao = p.id_permissao 
            WHERE p.nome_permissao = 'ADMIN_PAGES'
        ");
        $adminCountRow = mysqli_fetch_assoc($adminCount);
        
        if ($adminCountRow['admin_count'] <= 1) {
            echo json_encode([
                'success' => false, 
                'message' => 'Não é possível remover permissões administrativas do último administrador do sistema'
            ]);
            return;
        }
    }
    
    try {
        // Start transaction
        mysqli_begin_transaction($con);
        
        // Remove all existing permissions for this user
        $stmt = mysqli_prepare($con, "DELETE FROM permissao_usuario WHERE id_usuario_permissao = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($con));
        }
        mysqli_stmt_bind_param($stmt, "i", $userId);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
        
        // Add new permissions
        foreach ($permissions as $permission) {
            $permissionId = get_permission_id_by_name($permission);
            if ($permissionId) {
                $stmt = mysqli_prepare($con, "INSERT INTO permissao_usuario (id_usuario_permissao, id_permissao) VALUES (?, ?)");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . mysqli_error($con));
                }
                mysqli_stmt_bind_param($stmt, "ii", $userId, $permissionId);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
                }
                mysqli_stmt_close($stmt);
            }
        }
        
        // Commit transaction
        mysqli_commit($con);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Permissões atualizadas com sucesso',
            'updated_count' => count($permissions)
        ]);
        
    } catch (Exception $e) {
        mysqli_rollback($con);
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar permissões: ' . $e->getMessage()]);
    }
}

function saveAllPermissions($data) {
    global $con;
    
    $changes = $data['changes'] ?? [];
    $successCount = 0;
    
    try {
        // Start transaction
        mysqli_begin_transaction($con);
        
        foreach ($changes as $change) {
            $userId = intval($change['userId']);
            $permission = $change['permission'];
            $granted = $change['granted'];
            
            $permissionId = get_permission_id_by_name($permission);
            
            if (!$permissionId) continue;
            
            if ($granted) {
                // Add permission if it doesn't exist
                $checkStmt = mysqli_prepare($con, "SELECT id_permissao FROM permissao_usuario WHERE id_usuario_permissao = ? AND id_permissao = ?");
                mysqli_stmt_bind_param($checkStmt, "ii", $userId, $permissionId);
                mysqli_stmt_execute($checkStmt);
                $result = mysqli_stmt_get_result($checkStmt);
                
                if (mysqli_num_rows($result) == 0) {
                    $insertStmt = mysqli_prepare($con, "INSERT INTO permissao_usuario (id_usuario_permissao, id_permissao) VALUES (?, ?)");
                    mysqli_stmt_bind_param($insertStmt, "ii", $userId, $permissionId);
                    mysqli_stmt_execute($insertStmt);
                    mysqli_stmt_close($insertStmt);
                    $successCount++;
                }
                mysqli_stmt_close($checkStmt);
            } else {
                // Remove permission
                $deleteStmt = mysqli_prepare($con, "DELETE FROM permissao_usuario WHERE id_usuario_permissao = ? AND id_permissao = ?");
                mysqli_stmt_bind_param($deleteStmt, "ii", $userId, $permissionId);
                mysqli_stmt_execute($deleteStmt);
                if (mysqli_stmt_affected_rows($deleteStmt) > 0) {
                    $successCount++;
                }
                mysqli_stmt_close($deleteStmt);
            }
        }
        
        // Commit transaction
        mysqli_commit($con);
        
        echo json_encode([
            'success' => true, 
            'message' => "Permissões atualizadas com sucesso",
            'updated_count' => $successCount,
            'total_changes' => count($changes)
        ]);
        
    } catch (Exception $e) {
        mysqli_rollback($con);
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar permissões: ' . $e->getMessage()]);
    }
}

function togglePermission($data) {
    global $con;
    
    $userId = intval($data['userId']);
    $permission = $data['permission'];
    $granted = $data['granted'];
    
    $permissionId = get_permission_id_by_name($permission);
    
    if (!$permissionId) {
        echo json_encode(['success' => false, 'message' => 'Permissão inválida']);
        return;
    }
    
    try {
        if ($granted) {
            // Add permission
            $stmt = mysqli_prepare($con, "INSERT IGNORE INTO permissao_usuario (id_usuario_permissao, id_permissao) VALUES (?, ?)");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . mysqli_error($con));
            }
            mysqli_stmt_bind_param($stmt, "ii", $userId, $permissionId);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
        } else {
            // Remove permission
            $stmt = mysqli_prepare($con, "DELETE FROM permissao_usuario WHERE id_usuario_permissao = ? AND id_permissao = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . mysqli_error($con));
            }
            mysqli_stmt_bind_param($stmt, "ii", $userId, $permissionId);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
        }
        
        echo json_encode([
            'success' => true, 
            'message' => 'Permissão atualizada com sucesso'
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao alterar permissão: ' . $e->getMessage()]);
    }
}
?>
