<?php
// api/api_update_status.php

session_start();
header('Content-Type: application/json');

require_once '../config/database.php';

$response = ['success' => false, 'message' => 'Requisição inválida.'];

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'Acesso não autorizado.';
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoice_id = $_POST['invoice_id'] ?? 0;
    
    if ($invoice_id > 0) {
        try {
            // Prepara a query para ATUALIZAR o status para 'Paga'
            // A cláusula WHERE garante que o usuário só possa pagar a PRÓPRIA fatura
            $sql = "UPDATE invoices SET status = 'Paga' WHERE id = :invoice_id AND user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                ':invoice_id' => (int)$invoice_id,
                ':user_id' => $_SESSION['user_id']
            ]);

            // rowCount() > 0 significa que a linha foi afetada/atualizada
            if ($stmt->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = 'Fatura paga com sucesso!';
            } else {
                $response['message'] = 'Fatura não encontrada ou já estava paga.';
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