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
    // --- LÓGICA DE PAGINAÇÃO E FILTRAGEM (VERSÃO CORRIGIDA) ---

    // 1. Definições da Paginação (sem alterações)
    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // 2. Pega os parâmetros de filtro (sem alterações)
    $search = trim($_GET['search'] ?? '');
    $status = trim($_GET['status'] ?? '');

    // 3. Prepara a base da query e dos parâmetros (sem alterações)
    $sql_base = "FROM invoices WHERE user_id = :user_id";
    $params = [':user_id' => $_SESSION['user_id']];

    // 4. Adiciona a condição de BUSCA (sem alterações)
    if (!empty($search)) {
        $sql_base .= " AND description LIKE :search";
        $params[':search'] = '%' . $search . '%';
    }

    // 5. NOVA LÓGICA DE FILTRO DE STATUS (A CORREÇÃO ESTÁ AQUI!)
    if (!empty($status)) {
        switch ($status) {
            case 'Pendente':
                // Faturas pendentes são as que estão no banco como 'Pendente'
                // E cuja data de vencimento é HOJE ou no FUTURO.
                $sql_base .= " AND status = 'Pendente' AND due_date >= CURDATE()";
                break;
            case 'Vencida':
                // Faturas vencidas são as que estão no banco como 'Pendente'
                // E cuja data de vencimento já PASSOU.
                $sql_base .= " AND status = 'Pendente' AND due_date < CURDATE()";
                break;
            case 'Paga':
                // Faturas pagas são simplesmente as que estão marcadas como 'Paga'.
                $sql_base .= " AND status = 'Paga'";
                break;
        }
    }

    // 6. Contagem para paginação (sem alterações)
    $total_sql = "SELECT COUNT(*) " . $sql_base;
    $total_stmt = $pdo->prepare($total_sql);
    $total_stmt->execute($params);
    $total_invoices = $total_stmt->fetchColumn();
    $total_pages = ceil($total_invoices / $limit);

    // 7. Query principal com LIMIT e OFFSET (sem alterações na estrutura)
    $sql = "SELECT id, description, amount, due_date, status " . $sql_base . " ORDER BY due_date DESC LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    
    foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val);
    }
    
    $stmt->execute();
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
                                <span class="invoice-status <?php echo getStatusClass(getSmartStatus($invoice)); ?>">
                                    <?php echo htmlspecialchars(getSmartStatus($invoice)); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="pagination">
            <?php if ($total_pages > 1): ?>
                
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>&status=<?php echo $status; ?>">&laquo; Anterior</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>&status=<?php echo $status; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>&status=<?php echo $status; ?>">Próximo &raquo;</a>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>