<?php
// admin/edit_invoice.php

require_once 'admin_header.php';
require_once '../config/database.php';

$invoice_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$invoice = null;

if ($invoice_id) {
    try {
        // Busca os dados da fatura específica para preencher o formulário
        $sql = "SELECT * FROM invoices WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $invoice_id]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Lidar com erro
    }
}

// Se a fatura não for encontrada, exibe um erro
if (!$invoice) {
    echo '<main class="container"><div class="error-banner">Fatura não encontrada!</div></main>';
    require_once 'admin_footer.php';
    exit();
}
?>

<main class="container">
    <div class="page-header">
        <h2>Editar Fatura #<?php echo htmlspecialchars($invoice['id']); ?></h2>
        <a href="manage_invoices.php" class="btn-back">&larr; Voltar para a Lista</a>
    </div>

    <div class="card">
        <div id="message-container"></div>

        <form id="edit-invoice-form" action="../api/api_update_invoice.php" method="post" novalidate>
            <input type="hidden" name="invoice_id" value="<?php echo htmlspecialchars($invoice['id']); ?>">
            
            <div class="input-group">
                <label for="description">Descrição</label>
                <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($invoice['description']); ?>" required>
            </div>

            <div class="input-group">
                <label for="amount">Valor</label>
                <input type="text" id="amount" name="amount" value="<?php echo htmlspecialchars($invoice['amount']); ?>" required>
            </div>

            <div class="input-group">
                <label for="due_date">Data de Vencimento</label>
                <input type="date" id="due_date" name="due_date" value="<?php echo htmlspecialchars($invoice['due_date']); ?>" required>
            </div>

            <div class="input-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="Pendente" <?php echo ($invoice['status'] === 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
                    <option value="Paga" <?php echo ($invoice['status'] === 'Paga') ? 'selected' : ''; ?>>Paga</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
</main>

<?php require_once 'admin_footer.php'; ?>