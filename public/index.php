<?php
session_start();
require_once '../config/database.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error_message = "Por favor, preencha todos os campos.";
    } else {
        try {
            $sql = "SELECT id, name, password_hash FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch();
                if (password_verify($password, $user['password_hash'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error_message = "Email ou senha inválidos.";
                }
            } else {
                $error_message = "Email ou senha inválidos.";
            }
        } catch(PDOException $e) {
            $error_message = "Ocorreu um erro. Tente novamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesse sua conta - Invoices</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main class="main-content-login">
        <section class="form-section">
            <div class="form-card">
                <a href="index.php"><h1 class="logo-form">Invoices</h1></a>
                <h2>Acesse sua conta</h2>
                <p>Consulte suas faturas de forma rápida e segura.</p>

                <?php if (!empty($error_message)): ?>
                    <div class="error-banner"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>

                <form action="index.php" method="post" novalidate>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Senha</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
                 <div class="form-footer">
                    <p>Não tem uma conta? <a href="register.php">Cadastre-se</a></p>
                </div>
            </div>
        </section>
        <section class="promo-section">
             <h2>Seu controle financeiro na palma da mão.</h2>
        </section>
    </main>
</body>
</html>