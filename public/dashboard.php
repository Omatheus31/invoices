<?php
session_start();
// Se não estiver logado, redireciona para a página de login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../core/functions.php';

try {
    // Pega os parâmetros da URL. Se não existirem, são strings vazias.
    $search = trim($_GET['search'] ?? '');
    $status = trim($_GET['status'] ?? '');

    // 1. Começa com a query SQL base
    $sql = "SELECT id, description, amount, due_date, status FROM invoices WHERE user_id = :user_id";
    
    // 2. Prepara um array de parâmetros para o prepared statement
    $params = [':user_id' => $_SESSION['user_id']];

    // 3. Adiciona a condição de BUSCA (LIKE) se o campo de busca foi preenchido
    if (!empty($search)) {
        $sql .= " AND description LIKE :search";
        $params[':search'] = '%' . $search . '%'; // O '%' é o coringa do LIKE
    }

    // 4. Adiciona a condição de FILTRO (status) se um status foi escolhido
    if (!empty($status)) {
        $sql .= " AND status = :status";
        $params[':status'] = $status;
    }

    // 5. Adiciona a ordenação no final da query
    $sql .= " ORDER BY due_date DESC";

    // 6. Prepara e executa a query construída dinamicamente
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Não foi possível buscar as faturas: " . $e->getMessage());
}

?>

<main class="container">
    <div class="dashboard-header">
        <h2>Minhas Faturas</h2>
        <p>Olá, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! Aqui estão seus últimos lançamentos.</p>
    </div>
    <div class="card filter-bar">
        <form action="dashboard.php" method="GET" class="filter-form">
            <div class="search-group">
                <input type="text" name="search" placeholder="Buscar por descrição..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                <button type="submit" class="btn-search">Buscar</button>
            </div>
        </form>
        <div class="filter-links">
            <a href="dashboard.php" class="<?php echo empty($_GET['status']) ? 'active' : ''; ?>">Todas</a>
            <a href="dashboard.php?status=Pendente" class="<?php echo ($_GET['status'] ?? '') === 'Pendente' ? 'active' : ''; ?>">Pendentes</a>
            <a href="dashboard.php?status=Paga" class="<?php echo ($_GET['status'] ?? '') === 'Paga' ? 'active' : ''; ?>">Pagas</a>
            <a href="dashboard.php?status=Vencida" class="<?php echo ($_GET['status'] ?? '') === 'Vencida' ? 'active' : ''; ?>">Vencidas</a>
        </div>
    </div>
    <div class="invoice-list">
        <?php if (empty($invoices)): ?>
            <div class="card no-invoices">
                <p>Nenhuma fatura encontrada.</p>
            </div>
        <?php else: ?>
            <?php foreach ($invoices as $invoice): ?>
                <a href="invoice_details.php?id=<?php echo $invoice['id']; ?>" class="invoice-link">
                    <div class="card invoice-card">
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
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>