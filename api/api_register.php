<?php

header('Content-Type: application/json');

require_once '../config/database.php'; 

$response = ['success' => false, 'message' => 'Requisição inválida.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Coleta de todos os dados do formulário
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');   
    $birth_date = trim($_POST['birth_date'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validação inicial
    if (empty($name) || empty($email) || empty($cpf) || empty($birth_date) || empty($password)) {
        $response['message'] = "Todos os campos são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Formato de email inválido.";
    } else {
            try {
                // VERIFICAÇÃO DE DUPLICIDADE
                // Antes de inserir, verificamos se já existe um usuário com este email ou CPF.
                $sql = "SELECT id FROM users WHERE email = :email OR cpf = :cpf";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['email' => $email, 'cpf' => $cpf]);

                if ($stmt->rowCount() > 0) {
                    // Se encontrou algum registro o usuário já existe
                    $response['message'] = "Este email ou CPF já está cadastrado.";
                } else {
                    // CRIPTOGRAFIA DA SENHA
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);

                    // INSERÇÃO NO BANCO DE DADOS
                    $sql = "INSERT INTO users (name, email, cpf, birth_date, password_hash) VALUES (:name, :email, :cpf, :birth_date, :password_hash)";
                    $stmt = $pdo->prepare($sql);

                    $params = [
                        ':name' => $name,
                        ':email' => $email,
                        ':cpf' => $cpf,
                        ':birth_date' => $birth_date,
                        ':password_hash' => $password_hash
                    ];

                    // PREPARA A RESPOSTA DE SUCESSO
                    if ($stmt->execute($params)) {
                        $response['success'] = true;
                        $response['message'] = "Cadastro realizado com sucesso! Agora você pode fazer login.";
                        $response['redirectUrl'] = 'index.php'; // Informa ao JS para onde redirecionar
                    } else {
                        $response['message'] = "Ocorreu um erro ao realizar o cadastro. Tente novamente.";
                    }
                }
            }catch (PDOException $e) {
                $response['message'] = "Erro no banco de dados. Por favor, contate o suporte.";
        }
    }
}

// Converte o array de resposta em JSON e o envia de volta para o JavaScript
echo json_encode($response);
?>