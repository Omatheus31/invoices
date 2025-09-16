document.addEventListener('DOMContentLoaded', () => {
    // Adiciona interatividade aos cards de fatura
    const invoiceCards = document.querySelectorAll('.invoice-card');

    invoiceCards.forEach(card => {
        card.addEventListener('click', () => {
            // No futuro, isso poderia abrir um modal com mais detalhes da fatura
            // Por enquanto, apenas um efeito visual para mostrar interatividade
            console.log(`Card clicado: Fatura ID ${card.dataset.invoiceId}`);
            card.style.transform = 'scale(1.02)';
            setTimeout(() => {
                card.style.transform = 'scale(1)';
            }, 200);
        });
    });
});