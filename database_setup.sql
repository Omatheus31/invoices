-- Criação do Banco de Dados (Opcional, o usuário pode criar manualmente)
-- Para usar, remova o comentário da linha abaixo.
-- CREATE DATABASE IF NOT EXISTS `invoices_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- USE `invoices_db`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `birth_date` date NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Inserindo dados de exemplo na tabela `users`
-- A senha para este usuário é "senha123"
--
INSERT INTO `users` (`id`, `name`, `email`, `cpf`, `birth_date`, `password_hash`) VALUES
(1, 'João da Silva (Teste)', 'joao.silva@example.com', '111.111.111-11', '1990-01-15', '$2y$10$9.B2o.Y0gI8X0/Ie.VzL3.ftC.BAcCHcMbG5j5A/D8kM5g2vUnP8m');

-- --------------------------------------------------------

--
-- Estrutura da tabela `invoices`
--
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('Paga','Pendente','Vencida') NOT NULL DEFAULT 'Pendente',
  `barcode` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Inserindo dados de exemplo na tabela `invoices`
--
INSERT INTO `invoices` (`user_id`, `description`, `amount`, `due_date`, `status`, `barcode`) VALUES
(1, 'Fatura de Cartão de Crédito - Ref. Janeiro', '1250.75', '2025-09-20', 'Pendente', '8461000000001250750000000000000000112345678901234'),
(1, 'Seguro Residencial - Apólice 987654', '89.90', '2025-09-15', 'Pendente', '846100000000008990000000000000000198765432109876'),
(1, 'Compra Online - Amazon', '249.99', '2025-08-30', 'Paga', '846100000000024999000000000000000156473829105738'),
(1, 'Plano de Saúde - Mensalidade', '450.00', '2025-08-10', 'Vencida', '846100000000045000000000000000000119283746556473');

--
-- Adicionando Constraints (Chaves Estrangeiras)
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;