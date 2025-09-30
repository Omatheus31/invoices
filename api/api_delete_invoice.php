<?php
// api/api_delete_invoice.php

session_start();
header('Content-Type: application/json');
require_once '../config/database.php';

$response = ['success' => false, 'message' => 'Acesso não autorizado ou requisição inválida.'];

// Segurança: Apenas admins podem apagar faturas
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoice_id = filter_input(INPUT_POST, 'invoice_id', FILTER_VALIDATE_INT);

    if ($invoice_id) {
        try {
            // Prepara e executa o comando DELETE
            $sql = "DELETE FROM invoices WHERE id = :invoice_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':invoice_id' => $invoice_id]);

            // rowCount() retorna o número de linhas afetadas. Se for > 0, a exclusão funcionou.
            if ($stmt->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = 'Fatura apagada com sucesso!';
            } else {
                $response['message'] = 'Fatura não encontrada.';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Erro no banco de dados.';
        }
    } else {
        $response['message'] = 'ID da fatura inválido.';
    }
}

echo json_encode($response);
?>