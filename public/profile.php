<?php
// public/profile.php

require_once '../includes/header.php'; // Inclui o header e já faz a proteção de rota
require_once '../config/database.php';
require_once '../core/functions.php';

// Busca os dados atuais do usuário logado para pré-popular o formulário
try {
    $sql = "SELECT name, email, cpf, birth_date FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Se por algum motivo o usuário não for encontrado, desloga por segurança
        header("Location: logout.php");
        exit();
    }
} catch (PDOException $e) {
    die("Erro ao buscar dados do usuário.");
}

?>

<main class="container">
    <div class="page-header">
        <h2>Meu Perfil</h2>
        <a href="dashboard.php" class="btn-back">&larr; Voltar para o Dashboard</a>
    </div>
    <p class="page-subtitle">Gerencie suas informações pessoais e de segurança.</p>

    <div id="message-container"></div>

    <div class="card profile-card">
        <h3>Dados Pessoais</h3>
        <hr>
        <form id="profile-form" action="../api/api_update_profile.php" method="POST" novalidate>
            <div class="input-group">
                <label for="name">Nome Completo</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="input-group">
                <label for="cpf">CPF (não pode ser alterado)</label>
                <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($user['cpf']); ?>" readonly>
            </div>
            <div class="input-group">
                <label for="birth_date">Data de Nascimento (não pode ser alterada)</label>
                <input type="text" id="birth_date" name="birth_date" value="<?php echo date('d/m/Y', strtotime($user['birth_date'])); ?>" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>

    <div class="card profile-card">
        <h3>Alterar Senha</h3>
        <hr>
        <form id="password-form" action="../api/api_change_password.php" method="POST" novalidate>
            <div class="input-group">
                <label for="current_password">Senha Atual</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="input-group">
                <label for="new_password">Nova Senha</label>
                <input type="password" id="new_password" name="new_password" required>
                <div id="new-password-strength-feedback"></div>
            </div>
            <div class="input-group">
                <label for="confirm_new_password">Confirmar Nova Senha</label>
                <input type="password" id="confirm_new_password" name="confirm_new_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Alterar Senha</button>
        </form>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>