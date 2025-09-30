<?php
// api/api_update_invoice.php

session_start();
header('Content-Type: application/json');
require_once '../config/database.php';

$response = ['success' => false, 'message' => 'Acesso não autorizado ou requisição inválida.'];

// Segurança: Apenas admins podem editar faturas
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e valida os dados do formulário
    $invoice_id = filter_input(INPUT_POST, 'invoice_id', FILTER_VALIDATE_INT);
    $description = trim($_POST['description'] ?? '');
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    $due_date = trim($_POST['due_date'] ?? '');
    $status = trim($_POST['status'] ?? '');

    // Validação
    if (!$invoice_id || empty($description) || $amount === false || empty($due_date) || empty($status)) {
        $response['message'] = "Todos os campos são obrigatórios e devem ser válidos.";
    } else {
        try {
            // Prepara a query UPDATE
            $sql = "UPDATE invoices SET 
                        description = :description, 
                        amount = :amount, 
                        due_date = :due_date, 
                        status = :status 
                    WHERE id = :invoice_id";
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                ':description' => $description,
                ':amount' => $amount,
                ':due_date' => $due_date,
                ':status' => $status,
                ':invoice_id' => $invoice_id
            ]);

            $response['success'] = true;
            $response['message'] = 'Fatura atualizada com sucesso!';

        } catch (PDOException $e) {
            $response['message'] = 'Erro no banco de dados ao atualizar a fatura.';
        }
    }
}

echo json_encode($response);
?>