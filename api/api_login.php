<?php
// api/api_login.php

session_start();
// Define o tipo de conteúdo da resposta como JSON
header('Content-Type: application/json');

require_once '../config/database.php';

// Cria um array para a resposta
$response = ['success' => false, 'message' => 'Requisição inválida.'];

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $response['message'] = 'Por favor, preencha todos os campos.';
    } else {
        try {
            $sql = "SELECT id, name, password_hash FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch();
                if (password_verify($password, $user['password_hash'])) {
                    // Login bem-sucedido. Prepara a resposta de sucesso.
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    
                    $response['success'] = true;
                    $response['message'] = 'Login realizado com sucesso!';
                    $response['redirectUrl'] = 'dashboard.php'; // Informa ao JS para onde redirecionar
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

// Converte o array de resposta em JSON e o envia de volta para o JavaScript
echo json_encode($response);
?>