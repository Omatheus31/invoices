<?php
// api/api_delete_user.php

session_start();
header('Content-Type: application/json');
require_once '../config/database.php';

$response = ['success' => false, 'message' => 'Acesso não autorizado ou requisição inválida.'];

// Segurança: Apenas admins podem apagar utilizadores
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id_to_delete = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

    // Segurança extra: Garante que um admin não possa apagar a si mesmo pela API
    if ($user_id_to_delete == $_SESSION['user_id']) {
        $response['message'] = 'Você não pode apagar sua própria conta de administrador.';
    } elseif ($user_id_to_delete) {
        try {
            $sql = "DELETE FROM users WHERE id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id_to_delete]);

            if ($stmt->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = 'Utilizador apagado com sucesso!';
            } else {
                $response['message'] = 'Utilizador não encontrado.';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Erro no banco de dados.';
        }
    } else {
        $response['message'] = 'ID de utilizador inválido.';
    }
}

echo json_encode($response);
?>