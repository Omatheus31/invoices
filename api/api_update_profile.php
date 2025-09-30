<?php
// api/api_update_profile.php

session_start();
header('Content-Type: application/json');
require_once '../config/database.php';

$response = ['success' => false, 'message' => 'Requisição inválida ou não autorizada.'];

// Segurança: Apenas usuários logados podem acessar esta API
if (!isset($_SESSION['user_id'])) {
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($name) || empty($email)) {
        $response['message'] = "Nome e email são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Formato de email inválido.";
    } else {
        try {
            // VERIFICAÇÃO CRUCIAL: O novo email já está em uso por OUTRO usuário?
            $sql = "SELECT id FROM users WHERE email = :email AND id != :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email, 'user_id' => $user_id]);

            if ($stmt->rowCount() > 0) {
                $response['message'] = "Este email já está sendo utilizado por outra conta.";
            } else {
                // Se o email estiver livre, podemos prosseguir com a atualização
                $update_sql = "UPDATE users SET name = :name, email = :email WHERE id = :user_id";
                $update_stmt = $pdo->prepare($update_sql);
                $update_stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':user_id' => $user_id
                ]);

                // PASSO IMPORTANTE: Atualizar o nome na sessão para refletir na interface
                $_SESSION['user_name'] = $name;

                $response['success'] = true;
                $response['message'] = 'Perfil atualizado com sucesso!';
                $response['newName'] = $name; // Enviamos o novo nome de volta para o JS
            }
        } catch (PDOException $e) {
            $response['message'] = "Erro no banco de dados.";
        }
    }
}

echo json_encode($response);
?>