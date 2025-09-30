<?php
// public/generate_invoice_pdf.php

session_start();

// Proteção: Apenas usuários logados podem gerar PDFs
if (!isset($_SESSION['user_id'])) {
    die("Acesso não autorizado.");
}

// Inclui os arquivos necessários
require_once '../config/database.php';
require_once '../core/functions.php';
require_once '../libraries/fpdf.php'; // Incluindo a biblioteca FPDF

$invoice_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($invoice_id <= 0) {
    die("ID da fatura inválido.");
}

// --- Busca dos Dados da Fatura e do Usuário ---
try {
    // Query AVANÇADA: Usamos JOIN para buscar dados da fatura E do usuário de uma só vez
    $sql = "SELECT i.*, u.name as user_name, u.email as user_email, u.cpf as user_cpf
            FROM invoices i
            JOIN users u ON i.user_id = u.id
            WHERE i.id = :invoice_id AND i.user_id = :user_id";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':invoice_id' => $invoice_id, ':user_id' => $_SESSION['user_id']]);
    $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$invoice) {
        die("Fatura não encontrada ou não pertence a este usuário.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar dados: " . $e->getMessage());
}

// --- Geração do PDF com FPDF ---

// 1. Cria o objeto PDF
$pdf = new FPDF();
$pdf->AddPage(); // Adiciona uma página

// 2. Define a fonte para o Título
$pdf->SetFont('Arial', 'B', 20);
// Escreve o título
// Cell(largura, altura, 'texto', borda, quebra de linha, alinhamento)
$pdf->Cell(0, 10, 'Fatura Invoices', 0, 1, 'C');
$pdf->Ln(10); // Pula uma linha

// 3. Informações do Cliente
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, 'Dados do Cliente', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, 'Nome: ' . utf8_decode($invoice['user_name']), 0, 1);
$pdf->Cell(0, 7, 'Email: ' . $invoice['user_email'], 0, 1);
$pdf->Cell(0, 7, 'CPF: ' . $invoice['user_cpf'], 0, 1);
$pdf->Ln(10);

// 4. Detalhes da Fatura
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, 'Detalhes da Fatura', 0, 1);
$pdf->SetFont('Arial', '', 12);
// Desenha uma linha para separar
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 190, $pdf->GetY());
$pdf->Ln(2);

$pdf->Cell(50, 7, 'Descricao:', 0, 0);
$pdf->Cell(0, 7, utf8_decode($invoice['description']), 0, 1);

$pdf->Cell(50, 7, 'Vencimento:', 0, 0);
$pdf->Cell(0, 7, date('d/m/Y', strtotime($invoice['due_date'])), 0, 1);

// Pega o status "inteligente"
$smart_status = getSmartStatus($invoice);
$pdf->Cell(50, 7, 'Status:', 0, 0);
$pdf->Cell(0, 7, $smart_status, 0, 1);

$pdf->Ln(5);

// Valor com mais destaque
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(50, 10, 'Valor Total:', 0, 0);
$pdf->Cell(0, 10, 'R$ ' . number_format($invoice['amount'], 2, ',', '.'), 0, 1);
$pdf->Ln(10);

// 5. Código de Barras
if (!empty($invoice['barcode'])) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 7, 'Codigo de Barras', 0, 1);
    $pdf->SetFont('Courier', '', 12);
    $pdf->Cell(0, 7, $invoice['barcode'], 0, 1);
}

// 6. Envia o PDF para o Navegador
// 'I': Envia o arquivo inline para o navegador. O navegador decide se abre ou baixa.
// 'D': Força o download do arquivo.
// 'F': Salva o arquivo no servidor.
$pdf->Output('I', 'fatura-' . $invoice_id . '.pdf');

// utf8_decode() é usado para converter caracteres especiais (como ç, ã) para um formato que o FPDF entende.
?>