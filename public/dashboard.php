<?php
session_start();
// Se não estiver logado, redireciona para a página de login
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

try {
    $sql = "SELECT id, description, amount, due_date, status FROM invoices WHERE user_id = :user_id ORDER BY due_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Em um app real, logaríamos o erro
    die("Não foi possível buscar as faturas.");
}

?>

<main class="container">
    <div class="dashboard-header">
        <h2>Minhas Faturas</h2>
        <p>Olá, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! Aqui estão seus últimos lançamentos.</p>
    </div>

    <div class="invoice-list">
        <?php if (empty($invoices)): ?>
            <div class="card no-invoices">
                <p>Nenhuma fatura encontrada.</p>
            </div>
        <?php else: ?>
            <?php foreach ($invoices as $invoice): ?>
                <a href="invoice_details.php?id=<?php echo $invoice['id']; ?>" class="invoice-link">
                    <div class="invoice-summary">
                        <div class="invoice-description">
                            <h3><?php echo htmlspecialchars($invoice['description']); ?></h3>
                            <p>Vencimento: <?php echo date('d/m/Y', strtotime($invoice['due_date'])); ?></p>
                        </div>
                        <div class="invoice-details">
                            <span class="invoice-amount">R$ <?php echo number_format($invoice['amount'], 2, ',', '.'); ?></span>
                            <span class="invoice-status <?php echo getStatusClass($invoice['status']); ?>">
                                <?php echo htmlspecialchars($invoice['status']); ?>
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>