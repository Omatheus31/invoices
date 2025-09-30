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

// ... (função getStatusClass que já existe) ...

/**
 * Retorna o status "inteligente" de uma fatura, considerando a data atual.
 *
 * @param array $invoice O array de dados da fatura.
 * @return string O status real ('Paga', 'Pendente' ou 'Vencida').
 */
function getSmartStatus($invoice) {
    // Se a fatura já foi paga, nada mais importa. O status é 'Paga'.
    if ($invoice['status'] === 'Paga') {
        return 'Paga';
    }

    // Se a fatura não está paga, verificamos a data.
    // strtotime('today') pega o início do dia de hoje (00:00:00).
    // Se a data de vencimento for ANTERIOR a hoje, a fatura está vencida.
    if (strtotime($invoice['due_date']) < strtotime('today')) {
        return 'Vencida';
    }

    // Se nenhuma das condições acima for atendida, a fatura continua Pendente.
    return 'Pendente';
}


?>