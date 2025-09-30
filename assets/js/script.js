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

    // Validação de Senha Forte
    const passwordInput = document.getElementById('password');
    const strengthFeedback = document.getElementById('password-strength-feedback');
    const registerButton = document.querySelector('#register-form button[type="submit"]');

    if (passwordInput && strengthFeedback && registerButton) {
        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;
            let strength = 0;
            let feedbackText = '';
            let feedbackColor = '';

            if (password.length >= 8) strength++; // Critério 1: Tamanho
            if (password.match(/[a-z]/)) strength++;    // Critério 2: Letra minúscula
            if (password.match(/[A-Z]/)) strength++;    // Critério 3: Letra maiúscula
            if (password.match(/[0-9]/)) strength++;    // Critério 4: Número
            if (password.match(/[^a-zA-Z0-9]/)) strength++; // Critério 5: Símbolo

            switch (strength) {
                case 0:
                case 1:
                case 2:
                    feedbackText = 'Senha Fraca';
                    feedbackColor = '#dc3545'; // Vermelho
                    break;
                case 3:
                case 4:
                    feedbackText = 'Senha Média';
                    feedbackColor = '#ffc107'; // Laranja
                    break;
                case 5:
                    feedbackText = 'Senha Forte';
                    feedbackColor = '#28a745'; // Verde
                    break;
            }

            if (password.length === 0) {
                strengthFeedback.innerHTML = '';
            } else {
                strengthFeedback.innerHTML = `<span style="color: ${feedbackColor}; font-size: 0.85rem; font-weight: 500;">${feedbackText}</span>`;
            }
            
            // Impede o envio se a senha for muito fraca
            if (strength < 3) {
                registerButton.disabled = true;
            } else {
                registerButton.disabled = false;
            }
        });
    }
    // --- MÓDULO ADMIN: Lógica de Adicionar Fatura com AJAX ---
    const addInvoiceForm = document.getElementById('add-invoice-form');

    if (addInvoiceForm) {
        addInvoiceForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const messageContainer = document.getElementById('message-container');
            const submitButton = addInvoiceForm.querySelector('button[type="submit"]');
            const formData = new FormData(addInvoiceForm);

            submitButton.disabled = true;
            submitButton.textContent = 'Cadastrando...';
            messageContainer.innerHTML = '';

            try {
                const response = await fetch(addInvoiceForm.action, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    messageContainer.innerHTML = `<div class="success-banner">${data.message}</div>`;
                    addInvoiceForm.reset(); // Limpa o formulário para um novo cadastro
                } else {
                    messageContainer.innerHTML = `<div class="error-banner">${data.message}</div>`;
                }

            } catch (error) {
                messageContainer.innerHTML = `<div class="error-banner">Ocorreu um erro de comunicação.</div>`;
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Cadastrar Fatura';
            }
        });
    }

    // --- MÓDULO 6: Lógica do Menu Dropdown (VERSÃO CORRIGIDA) ---
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');

        if (toggle && menu) {
            // Adiciona o listener de clique APENAS no botão que abre o menu
            toggle.addEventListener('click', (event) => {
                // Previne a ação padrão APENAS do botão de abrir
                event.preventDefault();
                event.stopPropagation(); // Impede o clique de se propagar para o 'window'

                const isActive = dropdown.classList.contains('active');

                // Fecha todos os outros dropdowns antes de decidir o que fazer
                closeAllDropdowns();

                // Se o menu não estava ativo, abre ele.
                if (!isActive) {
                    dropdown.classList.add('active');
                    menu.classList.add('show');
                }
            });
        }
    });

    // Função para fechar todos os dropdowns
    function closeAllDropdowns() {
        dropdowns.forEach(dropdown => {
            dropdown.classList.remove('active');
            dropdown.querySelector('.dropdown-menu').classList.remove('show');
        });
    }

    // Fecha os dropdowns se o usuário clicar fora deles (no 'window')
    window.addEventListener('click', (event) => {
        // A lógica '.closest' não é mais necessária aqui, pois o clique no toggle
        // não chega mais até o window, graças ao event.stopPropagation().
        closeAllDropdowns();
    });

    // --- MÓDULO 8: Lógica do Menu Hambúrguer ---
    const navToggle = document.querySelector('.nav-toggle');

    if (navToggle) {
        navToggle.addEventListener('click', () => {
            document.body.classList.toggle('nav-open');
        });
    }

    // --- MÓDULO 7: Lógica de Atualizar Perfil com AJAX ---
    const profileForm = document.getElementById('profile-form');

    if (profileForm) {
        profileForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const messageContainer = document.getElementById('message-container');
            const submitButton = profileForm.querySelector('button[type="submit"]');
            const formData = new FormData(profileForm);

            submitButton.disabled = true;
            submitButton.textContent = 'Salvando...';
            messageContainer.innerHTML = '';

            try {
                const response = await fetch(profileForm.action, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    messageContainer.innerHTML = `<div class="success-banner">${data.message}</div>`;

                    // Mágica extra: Atualiza o nome no header em tempo real!
                    const welcomeMessage = document.querySelector('.welcome-message');
                    if (welcomeMessage) {
                        welcomeMessage.textContent = 'Olá, ' + data.newName;
                    }

                } else {
                    messageContainer.innerHTML = `<div class="error-banner">${data.message}</div>`;
                }

            } catch (error) {
                messageContainer.innerHTML = `<div class="error-banner">Ocorreu um erro de comunicação.</div>`;
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Salvar Alterações';
            }
        });
    }

    // --- MÓDULO 7 (Fase 3): Lógica de Alterar Senha com AJAX ---
    const passwordForm = document.getElementById('password-form');

    if (passwordForm) {
        passwordForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const messageContainer = document.getElementById('message-container');
            const submitButton = passwordForm.querySelector('button[type="submit"]');
            const formData = new FormData(passwordForm);

            // Validação extra no frontend: as novas senhas batem?
            if (formData.get('new_password') !== formData.get('confirm_new_password')) {
                messageContainer.innerHTML = `<div class="error-banner">A nova senha e a confirmação não coincidem.</div>`;
                return;
            }

            submitButton.disabled = true;
            submitButton.textContent = 'Alterando...';
            messageContainer.innerHTML = '';

            try {
                const response = await fetch(passwordForm.action, {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.success) {
                    messageContainer.innerHTML = `<div class="success-banner">${data.message}</div>`;
                    passwordForm.reset(); // Limpa o formulário após o sucesso
                } else {
                    messageContainer.innerHTML = `<div class="error-banner">${data.message}</div>`;
                }
            } catch (error) {
                messageContainer.innerHTML = `<div class="error-banner">Ocorreu um erro de comunicação.</div>`;
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Alterar Senha';
            }
        });
    }

    // --- MÓDULO 7 (Fase 3): Validação de Senha Forte para Nova Senha ---
    const newPasswordInput = document.getElementById('new_password');
    const newStrengthFeedback = document.getElementById('new-password-strength-feedback');
    const changePasswordButton = document.querySelector('#password-form button[type="submit"]');

    if (newPasswordInput && newStrengthFeedback && changePasswordButton) {
        newPasswordInput.addEventListener('input', () => {
            const password = newPasswordInput.value;
            let strength = 0;
            let feedbackText = '';
            let feedbackColor = '';

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            switch (strength) {
                case 0:
                case 1:
                case 2:
                    feedbackText = 'Senha Fraca';
                    feedbackColor = '#dc3545';
                    break;
                case 3:
                case 4:
                    feedbackText = 'Senha Média';
                    feedbackColor = '#ffc107';
                    break;
                case 5:
                    feedbackText = 'Senha Forte';
                    feedbackColor = '#28a745';
                    break;
            }

            if (password.length === 0) {
                newStrengthFeedback.innerHTML = '';
            } else {
                newStrengthFeedback.innerHTML = `<span style="color: ${feedbackColor}; font-size: 0.85rem; font-weight: 500;">${feedbackText}</span>`;
            }

            changePasswordButton.disabled = strength < 3;
        });
    }
    // --- MÓDULO 12: Lógica para Apagar Fatura (Admin) ---
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', async (event) => {
            event.preventDefault(); // Impede o link de fazer qualquer coisa

            const invoiceId = button.dataset.id;

            // 1. Pede confirmação ao admin
            if (!confirm('Tem a certeza que deseja apagar permanentemente esta fatura? Esta ação não pode ser desfeita.')) {
                return; // Se o admin cancelar, a função para aqui
            }

            try {
                const formData = new FormData();
                formData.append('invoice_id', invoiceId);

                // 2. Envia a requisição para a API de exclusão
                const response = await fetch('../api/api_delete_invoice.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    alert(data.message); // Exibe um alerta de sucesso

                    // 3. A Mágica: Remove a linha da tabela da interface
                    const row = button.closest('tr'); // Encontra a linha (<tr>) pai do botão
                    row.remove(); // Remove a linha da tela

                } else {
                    alert('Erro: ' + data.message);
                }
            } catch (error) {
                alert('Ocorreu um erro de comunicação com o servidor.');
            }
        });
    });

    // --- MÓDULO 12: Lógica para Editar Fatura (Admin) ---
    const editInvoiceForm = document.getElementById('edit-invoice-form');

    if (editInvoiceForm) {
        editInvoiceForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const messageContainer = document.getElementById('message-container');
            const submitButton = editInvoiceForm.querySelector('button[type="submit"]');
            const formData = new FormData(editInvoiceForm);

            submitButton.disabled = true;
            submitButton.textContent = 'Salvando...';
            messageContainer.innerHTML = '';

            try {
                const response = await fetch(editInvoiceForm.action, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    messageContainer.innerHTML = `<div class="success-banner">${data.message}</div>`;
                    // Opcional: redirecionar para a lista após alguns segundos
                    setTimeout(() => {
                        window.location.href = 'manage_invoices.php';
                    }, 1500); // Redireciona após 1.5 segundos
                } else {
                    messageContainer.innerHTML = `<div class="error-banner">${data.message}</div>`;
                }

            } catch (error) {
                messageContainer.innerHTML = `<div class="error-banner">Ocorreu um erro de comunicação.</div>`;
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Salvar Alterações';
            }
        });
    }

    
});