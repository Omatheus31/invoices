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
                    <li class="nav-item"><a href="index.php" class="nav-link">Utilizadores</a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle">Faturas <span class="arrow">&#9662;</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="manage_invoices.php">Listar Faturas</a></li>
                            <li><a href="add_invoice.php">Adicionar Fatura</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div class="header-actions">
                <span class="welcome-message">Admin: <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="../public/logout.php" class="btn btn-secondary">Sair</a>
            </div>
        </div>
    </header>