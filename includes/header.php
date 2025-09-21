<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Invoices</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="main-header-v2">
        <div class="container header-container">
            <div class="header-logos">
                <a href="#" class="logo-main">Invoices</a>
                <a href="https://www.riachuelo.com.br/" target="_blank">RIACHUELO</a>
                <a href="https://www.casariachuelo.com.br/" target="_blank">CASA RIACHUELO</a>
                <a href="https://www.carters.com.br/" target="_blank">carter's</a>
                <a href="https://www.fanlab.com.br/" target="_blank">FAN!</a>
            </div>
            <div class="header-actions">
                <?php if (isset($_SESSION['user_id'])): ?>
                     <span class="welcome-message">Olá, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <a href="logout.php" class="btn btn-secondary">Sair</a>
                <?php else: ?>
                    <a href="index.php" class="btn btn-primary">Pagar Fatura</a>
                <?php endif; ?>
            </div>
        </div>
    </header>