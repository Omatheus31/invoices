<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Invoices</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main class="main-content-login">
        <section class="form-section">
            <div class="form-card">
                <a href="index.php"><h1 class="logo-form">Invoices</h1></a>
                <h2>Crie sua conta</h2>
                <p>É rápido, fácil e seguro.</p>

                <div id="message-container"></div>

                <form id="register-form" action="../api/api_register.php" method="post" novalidate>
                    <div class="input-group">
                        <label for="name">Nome Completo</label>
                        <input type="text" id="name" name="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    <div class="input-group">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" required placeholder="000.000.000-00" value="<?php echo isset($_POST['cpf']) ? htmlspecialchars($_POST['cpf']) : ''; ?>">
                    </div>
                     <div class="input-group">
                        <label for="birth_date">Data de Nascimento</label>
                        <input type="date" id="birth_date" name="birth_date" required value="<?php echo isset($_POST['birth_date']) ? htmlspecialchars($_POST['birth_date']) : ''; ?>">
                    </div>
                    <div class="input-group">
                        <label for="password">Senha</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
                <div class="form-footer">
                    <p>Já tem uma conta? <a href="index.php">Faça o login</a></p>
                </div>
            </div>
        </section>
        <section class="promo-section">
            </section>
    </main>
    <?php require_once '../includes/footer.php'; ?>
</body>
</html>