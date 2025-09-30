<?php
// admin/manage_invoices.php

require_once 'admin_header.php';
require_once '../config/database.php';
require_once '../core/functions.php';

// --- LÓGICA PARA BUSCAR TODAS AS FATURAS ---
try {
    // Usamos JOIN para pegar o nome do utilizador junto com os dados da fatura
    $sql = "SELECT i.*, u.name as user_name 
            FROM invoices i 
            JOIN users u ON i.user_id = u.id 
            ORDER BY i.created_at DESC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo '<main class="container"><div class="error-banner">Não foi possível buscar as faturas. Erro: ' . $e->getMessage() . '</div></main>';
    require_once 'admin_footer.php';
    exit();
}
?>

<main class="container">
    <div class="dashboard-header">
        <h2>Gerenciamento de Faturas</h2>
        <p>Abaixo está a lista de todas as faturas cadastradas no sistema.</p>
    </div>

    <div class="admin-content card">
        <?php if (empty($invoices)): ?>
            <p>Nenhuma fatura encontrada no sistema.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID Fatura</th>
                        <th>Utilizador</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $invoice): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($invoice['id']); ?></td>
                            <td><?php echo htmlspecialchars($invoice['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($invoice['description']); ?></td>
                            <td>R$ <?php echo number_format($invoice['amount'], 2, ',', '.'); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($invoice['due_date'])); ?></td>
                            <td>
                                <span class="role-tag role-<?php echo strtolower(getSmartStatus($invoice)); ?>">
                                    <?php echo htmlspecialchars(getSmartStatus($invoice)); ?>
                                </span>
                            </td>
                            <td class="action-buttons">
                                <a href="edit_invoice.php?id=<?php echo $invoice['id']; ?>" class="btn-action btn-edit">Editar</a>
                                <a href="#" class="btn-action btn-delete" data-id="<?php echo $invoice['id']; ?>">Apagar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'admin_footer.php'; ?>