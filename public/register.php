<?php
session_start();
require_once '../config/database.php';

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Coleta e sanitização básica dos dados
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $cpf = trim($_POST['cpf']); // Adicionar máscara se desejar no frontend
    $birth_date = trim($_POST['birth_date']);
    $password = trim($_POST['password']);

    // 2. Validação dos campos
    if (empty($name) || empty($email) || empty($cpf) || empty($birth_date) || empty($password)) {
        $error_message = "Todos os campos são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Formato de email inválido.";
    } else {
        try {
            // 3. Verifica se o email ou CPF já existem
            $sql = "SELECT id FROM users WHERE email = :email OR cpf = :cpf";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email, 'cpf' => $cpf]);
            if ($stmt->rowCount() > 0) {
                $error_message = "Email ou CPF já cadastrado.";
            } else {
                // 4. Hash da senha (segurança)
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                // 5. Inserção no banco de dados com Prepared Statements
                $sql = "INSERT INTO users (name, email, cpf, birth_date, password_hash) VALUES (:name, :email, :cpf, :birth_date, :password_hash)";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':cpf', $cpf);
                $stmt->bindParam(':birth_date', $birth_date);
                $stmt->bindParam(':password_hash', $password_hash);
                
                if ($stmt->execute()) {
                    $success_message = "Cadastro realizado com sucesso! Você já pode fazer o login.";
                    // Limpa os campos do post para não repopular o formulário
                    $_POST = array();
                } else {
                    $error_message = "Ocorreu um erro ao realizar o cadastro. Tente novamente.";
                }
            }
        } catch (PDOException $e) {
            $error_message = "Erro no banco de dados: " . $e->getMessage();
        }
    }
}
?>
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

                <?php if (!empty($error_message)): ?>
                    <div class="error-banner"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>
                 <?php if (!empty($success_message)): ?>
                    <div class="success-banner"><?php echo htmlspecialchars($success_message); ?></div>
                <?php endif; ?>

                <form action="register.php" method="post" novalidate>
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
</body>
</html>