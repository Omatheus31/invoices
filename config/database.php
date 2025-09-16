<?php
// config/database.php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Deixe em branco se for o padrão do XAMPP
define('DB_NAME', 'invoices_db');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // Define o modo de erro do PDO para exceção
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Define o charset para utf8mb4
    $pdo->exec("SET NAMES 'utf8mb4'");
} catch(PDOException $e){
    die("ERRO: Não foi possível conectar ao banco de dados. " . $e->getMessage());
}
?>