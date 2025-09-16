<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Invoices</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <a href="dashboard.php" class="logo">Invoices</a>
            <nav>
                <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="logout.php" class="btn btn-secondary">Sair</a>
            </nav>
        </div>
    </header>