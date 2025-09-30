<?php
// core/functions.php

/**
 * Retorna a classe CSS correspondente ao status de uma fatura.
 *
 * @param string $status O status da fatura (ex: 'Paga', 'Pendente').
 * @return string A classe CSS correspondente.
 */
function getStatusClass($status) {
    switch ($status) {
        case 'Paga': return 'status-paid';
        case 'Vencida': return 'status-overdue';
        case 'Pendente': return 'status-pending';
        default: return '';
    }
}

// Futuramente, outras funções globais poderão ser adicionadas aqui.
?>