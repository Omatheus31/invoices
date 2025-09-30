<?php
// api/api_login.php

session_start();
header('Content-Type: application/json');
require_once '../config/database.php';

$response = ['success' => false, 'message' => 'Requisição inválida.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $response['message'] = 'Por favor, preencha todos os campos.';
    } else {
        try {
            // 1. Modificamos a query para buscar também a coluna 'role'
            $sql = "SELECT id, name, password_hash, role FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch();
                if (password_verify($password, $user['password_hash'])) {
                    // Login bem-sucedido
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    // 2. Guardamos o cargo do usuário na sessão (MUITO IMPORTANTE)
                    $_SESSION['user_role'] = $user['role'];

                    $response['success'] = true;

                    // 3. Decidimos para onde redirecionar com base no cargo
                    if ($user['role'] === 'admin') {
                        $response['redirectUrl'] = '../admin/index.php'; // Redireciona para o dashboard do admin
                    } else {
                        $response['redirectUrl'] = 'dashboard.php'; // Redireciona para o dashboard do usuário
                    }
                } else {
                    $response['message'] = 'Email ou senha inválidos.';
                }
            } else {
                $response['message'] = 'Email ou senha inválidos.';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Ocorreu um erro no servidor. Tente novamente.';
        }
    }
}

echo json_encode($response);
?>