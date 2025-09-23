<?php

session_start();

// Proteção da página: se não estiver logado, redireciona para a página de login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once '../config/database.php';
require_once '../includes/header.php';

function getStatusClass($status) {
    switch ($status) {
        case 'Paga': return 'status-paid';
        case 'Vencida': return 'status-overdue';
        case 'Pendente': return 'status-pending';
        default: return '';
    }
}

// Pega o ID da fatura da URL e garante que seja um número inteiro
$invoice_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($invoice_id > 0) {
    try {
        // Prepara a query para buscar a fatura específica do usuário logado
        $sql = "SELECT * FROM invoices WHERE id = :invoice_id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':invoice_id' => $invoice_id,
            ':user_id' => $_SESSION['user_id']
        ]);

        // Pega os dados da fatura. fetch() é usado porque esperamos um resultado.
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se a fatura não for encontrada (ou não pertencer ao usuário), $invoice será false.
        if (!$invoice) {
            $error = "Fatura não encontrada ou acesso não permitido.";
        }
    } catch (PDOException $e) {
        $error = "Erro ao buscar dados da fatura.";
    }
} else {
    $error = "ID da fatura inválido.";
}

?>

<main class="container">
    <div class="page-header">
        <h2>Detalhes da Fatura</h2>
        <a href="dashboard.php" class="btn-back">&larr; Voltar para o Dashboard</a>
    </div>

    <?php if (isset($error)): ?>
        <div class="error-banner"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif (isset($invoice)): ?>
        <div class="card invoice-details-card">
            <div class="card-header">
                <h3><?php echo htmlspecialchars($invoice['description']); ?></h3>
                
                <?php if ($invoice['status'] === 'Pendente' || $invoice['status'] === 'Vencida'): ?>
                    <button id="pay-invoice-btn" class="btn btn-primary" data-invoice-id="<?php echo $invoice['id']; ?>">
                        Pagar Fatura
                    </button>
                <?php endif; ?>
            </div>
            <hr>
            <div class="details-grid">
                <div>
                    <strong>Status:</strong>
                    <span class="invoice-status <?php echo getStatusClass($invoice['status']); ?>">
                        <?php echo htmlspecialchars($invoice['status']); ?>
                    </span>
                </div>
                <div>
                    <strong>Valor:</strong>
                    <span class="invoice-amount-details">
                        R$ <?php echo number_format($invoice['amount'], 2, ',', '.'); ?>
                    </span>
                </div>
                <div>
                    <strong>Vencimento:</strong>
                    <span><?php echo date('d/m/Y', strtotime($invoice['due_date'])); ?></span>
                </div>
                <div>
                    <strong>Data de Criação:</strong>
                    <span><?php echo date('d/m/Y', strtotime($invoice['created_at'])); ?></span>
                </div>
            </div>
            <div class="barcode-section">
                <strong>Código de Barras:</strong>
                <p class="barcode-text"><?php echo htmlspecialchars($invoice['barcode']); ?></p>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php require_once '../includes/footer.php';
