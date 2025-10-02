<?php
// admin/edit_user.php

require_once 'admin_header.php';
require_once '../config/database.php';

$user_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$user = null;

if ($user_id) {
    try {
        $sql = "SELECT id, name, email, role FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {}
}

if (!$user) {
    echo '<main class="container"><div class="error-banner">Utilizador não encontrado!</div></main>';
    require_once 'admin_footer.php';
    exit();
}
?>

<main class="container">
    <div class="page-header">
        <h2>Editar Utilizador #<?php echo htmlspecialchars($user['id']); ?></h2>
        <a href="index.php" class="btn-back">&larr; Voltar para a Lista</a>
    </div>

    <div class="card">
        <div id="message-container"></div>
        <form id="edit-user-form" action="../api/api_update_user.php" method="post" novalidate>
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
            
            <div class="input-group">
                <label for="name">Nome Completo</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="input-group">
                <label for="role">Cargo (Role)</label>
                <select id="role" name="role" required>
                    <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
</main>

<?php require_once 'admin_footer.php'; ?>