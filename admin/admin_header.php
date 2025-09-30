<?php require_once __DIR__ . '/auth_admin.php'; // O segurança sempre vem primeiro! ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css"> 
    <title>Painel Admin - Invoices</title>
</head>
<body>
    <header class="main-header-v2">
        <div class="container header-container">
            <a href="index.php" class="logo-main">Admin Invoices</a>
            <nav class="main-nav">
                <ul>
                    <li class="nav-item"><a href="index.php" class="nav-link">Usuários</a></li>
                    <li class="nav-item"><a href="add_invoice.php" class="nav-link">Cadastrar Fatura</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <span class="welcome-message">Admin: <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="../public/logout.php" class="btn btn-secondary">Sair</a>
            </div>
        </div>
    </header>