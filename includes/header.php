<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="main-header-v2">
        <div class="container header-container">

            <a href="dashboard.php" class="logo-main">Invoices</a>

            <button class="nav-toggle" aria-label="Abrir menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="nav-wrapper">
                <nav class="main-nav">
                    <ul>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle">Faturas <span class="arrow">&#9662;</span></a>
                            <ul class="dropdown-menu">
                                <li><a href="dashboard.php">Minhas Faturas</a></li>
                                <li><a href="#">Pagar Fatura</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link">Conta Digital</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Empréstimos</a></li>
                    </ul>
                </nav>

                <div class="header-actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle">
                                <span class="welcome-message">Olá, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                                <span class="arrow">&#9662;</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="profile.php">Meu Perfil</a></li>
                                <li><a href="logout.php">Sair</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="index.php" class="btn btn-primary">Entrar</a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </header>