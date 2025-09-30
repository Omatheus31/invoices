<?php
// admin/add_invoice.php

require_once 'admin_header.php';
require_once '../config/database.php';

// Lógica para buscar todos os usuários para popular o <select>
try {
    $user_sql = "SELECT id, name, email FROM users WHERE role = 'user' ORDER BY name ASC";
    $user_stmt = $pdo->prepare($user_sql);
    $user_stmt->execute();
    $users = $user_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Lidar com o erro, talvez mostrar uma mensagem e sair
    die("Não foi possível buscar os usuários.");
}
?>

<main class="container">
    <div class="dashboard-header">
        <h2>Cadastrar Nova Fatura</h2>
        <p>Preencha os dados abaixo para adicionar uma nova fatura para um usuário.</p>
    </div>

    <div class="card">
        <div id="message-container"></div> <form id="add-invoice-form" action="../api/api_add_invoice.php" method="post" novalidate>

            <div class="input-group">
                <label for="user_id">Usuário</label>
                <select id="user_id" name="user_id" required>
                    <option value="">-- Selecione um usuário --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo htmlspecialchars($user['id']); ?>">
                            <?php echo htmlspecialchars($user['name']) . ' (' . htmlspecialchars($user['email']) . ')'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group">
                <label for="description">Descrição</label>
                <input type="text" id="description" name="description" required>
            </div>

            <div class="input-group">
                <label for="amount">Valor (ex: 1234.56)</label>
                <input type="text" id="amount" name="amount" required>
            </div>

            <div class="input-group">
                <label for="due_date">Data de Vencimento</label>
                <input type="date" id="due_date" name="due_date" required>
            </div>

            <div class="input-group">
                <label for="barcode">Código de Barras (Opcional)</label>
                <input type="text" id="barcode" name="barcode">
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar Fatura</button>
        </form>
    </div>
</main>

<?php require_once 'admin_footer.php'; ?>