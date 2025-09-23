<?php
// invoices/index.php

// Redireciona o usuário para a página de login principal dentro da pasta /public
header("Location: public/index.php");
exit(); // Garante que nenhum outro código seja executado após o redirecionamento
?>