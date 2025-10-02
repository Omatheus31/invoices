<?php
// api/api_update_user.php

session_start();
header('Content-Type: application/json');
require_once '../config/database.php';

$response = ['success' => false, 'message' => 'Acesso não autorizado ou requisição inválida.'];

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = trim($_POST['role'] ?? '');

    if (!$user_id || empty($name) || empty($email) || !in_array($role, ['user', 'admin'])) {
        $response['message'] = "Todos os campos são obrigatórios e devem ser válidos.";
    } else {
        try {
            // Verifica se o novo email já está em uso por OUTRO utilizador
            $sql = "SELECT id FROM users WHERE email = :email AND id != :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email, ':user_id' => $user_id]);

            if ($stmt->rowCount() > 0) {
                $response['message'] = "Este email já está a ser utilizado por outra conta.";
            } else {
                $update_sql = "UPDATE users SET name = :name, email = :email, role = :role WHERE id = :user_id";
                $update_stmt = $pdo->prepare($update_sql);
                $update_stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':role' => $role,
                    ':user_id' => $user_id
                ]);

                $response['success'] = true;
                $response['message'] = 'Utilizador atualizado com sucesso!';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Erro no banco de dados.';
        }
    }
}

echo json_encode($response);
?>