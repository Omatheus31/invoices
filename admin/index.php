<?php
// admin/index.php - Dashboard do Administrador

require_once 'admin_header.php'; // Proteção e cabeçalho
require_once '../config/database.php'; 

// --- LÓGICA PARA BUSCAR USUÁRIOS ---
try {
    // Query SQL para selecionar os dados de todos os usuários
    // Ordenamos por data de criação, dos mais recentes para os mais antigos
    $sql = "SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC";
    
    // Prepara e executa a query
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Pega todos os resultados em um array
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Em caso de erro, exibe uma mensagem
    echo '<main class="container"><div class="error-banner">Não foi possível buscar os usuários. Erro: ' . $e->getMessage() . '</div></main>';
    require_once 'admin_footer.php';
    exit(); // Para a execução
}
?>

<main class="container">
    <div class="dashboard-header">
        <h2>Gerenciamento de Usuários</h2>
        <p>Abaixo está a lista de todos os usuários cadastrados no sistema.</p>
    </div>

    <div class="admin-content card">
        <?php if (empty($users)): ?>
            <p>Nenhum usuário encontrado.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Cargo (Role)</th>
                        <th>Data de Cadastro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="role-tag role-<?php echo htmlspecialchars($user['role']); ?>">
                                    <?php echo htmlspecialchars(ucfirst($user['role'])); ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></td>
                            <td class="action-buttons">
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn-action btn-edit">Editar</a>
                                
                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $user['id']): ?>
                                    <a href="#" class="btn-action btn-delete-user" data-id="<?php echo $user['id']; ?>">Apagar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'admin_footer.php'; ?>