<?php
// admin/auth_admin.php

// Inicia a sessão para verificar as variáveis
session_start();

// Lógica de proteção:
// 1. O usuário NÃO está logado (não existe 'user_role')
// OU
// 2. O usuário ESTÁ logado, mas o cargo dele NÃO é 'admin'
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Em ambos os casos, ele não tem permissão. Expulsa para a página de login.
    header("Location: ../public/index.php");
    exit();
}

// Se o script passar por aqui, significa que o usuário é um admin.
?>