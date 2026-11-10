-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/10/2026 às 01:09
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `barrefertas`
--
CREATE DATABASE IF NOT EXISTS `barrefertas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `barrefertas`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ofertas`
--

CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `descricao` varchar(300) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `preco` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ofertas`
--

INSERT INTO `ofertas` (`id`, `id_usuario`, `nome`, `descricao`, `foto`, `link`, `preco`) VALUES
(7, 2, 'Papel chamex', 'Folha A4 75g', 'imagens/chamex.jpg', 'https://www.kalunga.com.br/prod/papel-sulfite-a4-75g-210mmx297mm-chamex-pt-500-fl/476102', 'R$ 35,50');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `senha` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `nome`, `senha`) VALUES
(2, 'fulano@bol.com.br', 'Fulano de Tal', '123456');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
