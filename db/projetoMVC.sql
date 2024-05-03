-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Tempo de geração: 28/04/2024 às 23:04
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projetoMVC`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `depoimentos`
--

CREATE TABLE `depoimentos` (
  `id` int NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mensagem` text COLLATE utf8mb4_general_ci NOT NULL,
  `data` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `depoimentos`
--

INSERT INTO `depoimentos` (`id`, `nome`, `mensagem`, `data`) VALUES
(1, 'dasdasdasd', 'asdasdasda', '2024-04-19 12:12:18'),
(2, 'sdfsdf', 'fdsfsdf', '2024-04-19 15:48:20'),
(3, 'Lucas', 'Hello Word', '2024-04-19 15:57:15'),
(4, 'asdasdasd', 'asdasdasd', '2024-04-19 15:57:23'),
(5, 'Teste Teste', 'Teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste', '2024-04-20 18:24:20'),
(6, 'aaaaaaaaaa', 'aaaaaaaaaaaaaaaaa', '2024-04-20 18:24:43'),
(7, 'teste', 'teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste teste', '2024-04-20 18:27:24'),
(8, ' teste teste teste teste', ' teste teste teste teste teste teste teste teste teste teste testevv teste teste teste teste teste teste teste teste', '2024-04-20 18:27:32'),
(10, 'oi', 'oi\r\n', '2024-04-24 17:03:40'),
(11, 'Olá', 'olá mundo', '2024-04-26 21:19:14'),
(14, 'Testando admin', 'testando admin', '2024-04-27 18:16:32'),
(17, 'lucas', 'testandp\r\n', '2024-04-28 14:54:45'),
(18, 'teste', 'teste', '2024-04-28 14:57:04');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Lucas Falcão', 'lughfalcao@gmail.com', '$2y$10$u4S16fnMQUFdEN9VarRN2.mq0gbXRDGHSxmlVokC3r.LyJjCYmiYe'),
(5, 'Maria Luisa', 'maria@gmail.com', '$2y$10$PBAxaQHbjEWRIfWTdOQQm.Sy3VsTSwHqgtSTzqQ/hfLuSPZo3O2yW'),
(6, 'teste', 'teste@teste', '$2y$10$4v5w9t7xkj2o2UexJxWUsOHYXjvoXcwsa7nWtVHEfDaBKmFmiYA06');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `depoimentos`
--
ALTER TABLE `depoimentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `depoimentos`
--
ALTER TABLE `depoimentos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
