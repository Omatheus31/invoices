-- =================================================================
-- SCRIPT PARA INSERIR FATURAS DE EXEMPLO PARA UM NOVO USUÁRIO
-- =================================================================
--
-- INSTRUÇÕES:
-- 1. Encontre o ID do usuário que você acabou de cadastrar na tabela `users`.
-- 2. Substitua TODAS as 4 ocorrências de 'SEU_NOVO_ID_DE_USUARIO_AQUI' pelo seu ID.
-- 3. Execute este script na aba SQL do phpMyAdmin.
--

BEGIN;

INSERT INTO `invoices` (`user_id`, `description`, `amount`, `due_date`, `status`, `barcode`) VALUES
('SEU_NOVO_ID_DE_USUARIO_AQUI', 'Fatura de Internet - Vivo Fibra', '119.90', '2025-10-10', 'Pendente', '8461000000001199000000000000000000112345678901234'),
('SEU_NOVO_ID_DE_USUARIO_AQUI', 'Compra na Loja Online - Placa de Vídeo', '2850.00', '2025-10-05', 'Pendente', '846100000002850000000000000000000198765432109876'),
('SEU_NOVO_ID_DE_USUARIO_AQUI', 'Mensalidade da Academia', '89.90', '2025-09-25', 'Paga', '846100000000089900000000000000000156473829105738'),
('SEU_NOVO_ID_DE_USUARIO_AQUI', 'Conta de Luz - Equatorial', '325.40', '2025-09-15', 'Vencida', '846100000000325400000000000000000119283746556473');

COMMIT;