<?php
// api/api_change_password.php

session_start();
header('Content-Type: application/json');
require_once '../config/database.php';

$response = ['success' => false, 'message' => 'Requisição inválida ou não autorizada.'];

if (!isset($_SESSION['user_id'])) {
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_new_password = $_POST['confirm_new_password'] ?? '';

    if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        $response['message'] = 'Todos os campos são obrigatórios.';
    } elseif ($new_password !== $confirm_new_password) {
        $response['message'] = 'A nova senha e a confirmação não coincidem.';
    } else {
        try {
            // 1. Busca o hash da senha atual do usuário no banco
            $sql = "SELECT password_hash FROM users WHERE id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            $user = $stmt->fetch();

            // 2. Verifica se a "senha atual" digitada corresponde ao hash do banco
            if ($user && password_verify($current_password, $user['password_hash'])) {
                // Se correspondeu, a senha está correta. Podemos prosseguir.

                // 3. Cria um novo hash para a nova senha
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                // 4. Atualiza a senha no banco de dados com o novo hash
                $update_sql = "UPDATE users SET password_hash = :new_password_hash WHERE id = :user_id";
                $update_stmt = $pdo->prepare($update_sql);
                $update_stmt->execute([
                    ':new_password_hash' => $new_password_hash,
                    ':user_id' => $user_id
                ]);

                $response['success'] = true;
                $response['message'] = 'Senha alterada com sucesso!';
            } else {
                // Se a senha atual não bateu, retorna um erro.
                $response['message'] = 'A senha atual está incorreta.';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Erro no banco de dados.';
        }
    }
}

echo json_encode($response);
?>