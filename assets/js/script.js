document.addEventListener('DOMContentLoaded', () => {

    // MÓDULO 1: Interatividade dos cards de fatura
    const invoiceCards = document.querySelectorAll('.invoice-card');
    invoiceCards.forEach(card => {
        // Não precisamos mais do efeito de clique, pois o card inteiro é um link.
        // Podemos deixar essa parte vazia ou remover se quiser.
    });

    // Lógica de Login com AJAX
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

    const registerForm = document.getElementById('register-form');

    if (registerForm) {
        registerForm.addEventListener('submit', async (event) => {
            // 1. Prevenir o envio padrão (igual ao do login)
            event.preventDefault();

            // 2. Pegar o container de mensagens e o botão (igual ao do login)
            const messageContainer = document.getElementById('message-container');
            const submitButton = registerForm.querySelector('button[type="submit"]');

            // 3. Criar o FormData (igual ao do login)
            const formData = new FormData(registerForm);

            // 4. Lógica de desabilitar botão e limpar mensagens (igual ao do login)
            submitButton.disabled = true;
            submitButton.textContent = 'Cadastrando...';
            messageContainer.innerHTML = '';

            try {

                const password = registerForm.querySelector('#password').value;
                const confirmPassword = registerForm.querySelector('#confirm_password').value;

                // ADICIONA A VALIDAÇÃO
                if (password !== confirmPassword) {
                    messageContainer.innerHTML = `<div class="error-banner">As senhas não coincidem.</div>`;
                    // Para a execução aqui, reabilitando o botão
                    submitButton.disabled = false;
                    submitButton.textContent = 'Cadastrar';
                    return; // Sai da função
                }
                // 5. Fazer o fetch para o registerForm.action (igual ao do login)
                const response = await fetch(registerForm.action, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                // 6. AQUI ESTÁ A ÚNICA DIFERENÇA REAL
                if (data.success) {
                    // Se o cadastro deu certo, mostre uma mensagem de sucesso
                    // e limpe o formulário.
                    messageContainer.innerHTML = `<div class="success-banner">${data.message}</div>`;
                    registerForm.reset(); // Limpa os campos do formulário
                } else {
                    // Se deu erro, mostre a mensagem de erro
                    messageContainer.innerHTML = `<div class="error-banner">${data.message}</div>`;
                }

            } catch (error) {
                // Tratamento de erro (igual ao do login)
                messageContainer.innerHTML = `<div class="error-banner">Ocorreu um erro. Tente novamente.</div>`;
            } finally {
                // Reabilitar o botão (igual ao do login)
                submitButton.disabled = false;
                submitButton.textContent = 'Cadastrar';
            }
        });
    }

    // Máscaras e Validação Frontend
    const cpfInput = document.getElementById('cpf');
    const birthDateInput = document.getElementById('birth_date');

    if (cpfInput) {
        cpfInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca ponto após o terceiro dígito
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca ponto após o sexto dígito
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Coloca hífen antes dos dois últimos dígitos
            e.target.value = value.slice(0, 14); // Limita o tamanho
        });
    }

    if (birthDateInput) {
        // Altera o tipo do input de 'date' para 'text' para permitir a máscara
        birthDateInput.type = 'text';
        birthDateInput.placeholder = 'dd/mm/aaaa';

        birthDateInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '$1/$2');
            value = value.replace(/(\d{2})(\d)/, '$1/$2');
            e.target.value = value.slice(0, 10);
        });
    }

    // Lógica de Pagamento de Fatura com AJAX
    const payButton = document.getElementById('pay-invoice-btn');

    if (payButton) {
        payButton.addEventListener('click', async () => {
            const invoiceId = payButton.dataset.invoiceId;
            
            if (!confirm('Deseja realmente marcar esta fatura como paga?')) {
                return;
            }

            try {
                const formData = new FormData();
                formData.append('invoice_id', invoiceId);

                const response = await fetch('../api/api_update_status.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();

                if (data.success) {
                    // Atualiza a UI sem recarregar a página!
                    const statusElement = document.querySelector('.invoice-status');
                    statusElement.textContent = 'Paga';
                    statusElement.className = 'invoice-status status-paid';
                    payButton.style.display = 'none'; // Esconde o botão
                    alert(data.message); // Exibe um alerta de sucesso
                } else {
                    alert('Erro: ' + data.message);
                }
            } catch (error) {
                alert('Ocorreu um erro de comunicação com o servidor.');
            }
        });
    }
});