document.addEventListener('DOMContentLoaded', () => {

    // --- MÓDULO 1: Interatividade dos cards de fatura ---
    const invoiceCards = document.querySelectorAll('.invoice-card');
    invoiceCards.forEach(card => {
        // Não precisamos mais do efeito de clique, pois o card inteiro é um link.
        // Podemos deixar essa parte vazia ou remover se quiser.
    });

    // --- MÓDULO 2: Lógica de Login com AJAX ---
    const loginForm = document.getElementById('login-form');

    if (loginForm) {
        loginForm.addEventListener('submit', async (event) => {
            // 1. Impede o envio tradicional do formulário
            event.preventDefault();

            const errorContainer = document.getElementById('error-container');
            const submitButton = loginForm.querySelector('button[type="submit"]');
            
            // Pega os dados do formulário
            const formData = new FormData(loginForm);

            // Desabilita o botão para evitar múltiplos cliques
            submitButton.disabled = true;
            submitButton.textContent = 'Entrando...';
            errorContainer.innerHTML = ''; // Limpa erros antigos

            try {
                // 2. Envia os dados para a API usando fetch
                const response = await fetch(loginForm.action, {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Erro na comunicação com o servidor.');
                }
                
                // 3. Converte a resposta da API (JSON) em um objeto JavaScript
                const data = await response.json();

                // 4. Trata a resposta
                if (data.success) {
                    // Se o login foi bem-sucedido, redireciona
                    window.location.href = data.redirectUrl;
                } else {
                    // Se falhou, exibe a mensagem de erro
                    errorContainer.innerHTML = `<div class="error-banner">${data.message}</div>`;
                }

            } catch (error) {
                // Trata erros de conexão/rede
                errorContainer.innerHTML = `<div class="error-banner">Ocorreu um erro. Tente novamente.</div>`;
                console.error('Erro no fetch:', error);
            } finally {
                // Reabilita o botão
                submitButton.disabled = false;
                submitButton.textContent = 'Entrar';
            }
        });
    }
});