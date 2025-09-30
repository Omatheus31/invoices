<?php
// api/api_add_invoice.php

session_start();
header('Content-Type: application/json');
require_once '../config/database.php';

$response = ['success' => false, 'message' => 'Requisição inválida ou não autorizada.'];

// Segurança: Apenas admins podem adicionar faturas
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $description = trim($_POST['description'] ?? '');
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    $due_date = trim($_POST['due_date'] ?? '');
    $barcode = trim($_POST['barcode'] ?? null);

    if (empty($user_id) || empty($description) || empty($amount) || empty($due_date)) {
        $response['message'] = "Por favor, preencha todos os campos obrigatórios.";
    } else {
        try {
            $sql = "INSERT INTO invoices (user_id, description, amount, due_date, barcode, status) VALUES (:user_id, :description, :amount, :due_date, :barcode, 'Pendente')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':description' => $description,
                ':amount' => $amount,
                ':due_date' => $due_date,
                ':barcode' => $barcode
            ]);

            $response['success'] = true;
            $response['message'] = 'Fatura cadastrada com sucesso!';

        } catch (PDOException $e) {
            $response['message'] = 'Erro no banco de dados: ' . $e->getMessage();
        }
    }
}

echo json_encode($response);
?>