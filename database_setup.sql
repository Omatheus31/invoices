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
-- Adicionando Constraints (Chaves Estrangeiras)
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;