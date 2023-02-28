-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 28-Fev-2023 às 17:20
-- Versão do servidor: 8.0.32-0ubuntu0.22.04.2
-- versão do PHP: 8.1.2-1ubuntu2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dcweventos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int NOT NULL,
  `nome` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `local` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `data` date NOT NULL,
  `vagas` int NOT NULL,
  `ativo` int NOT NULL DEFAULT '1',
  `imagem` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `eventos`
--

INSERT INTO `eventos` (`id`, `nome`, `local`, `data`, `vagas`, `ativo`, `imagem`, `last_update`) VALUES
(4, 'Rampa de Valadares', 'Gaia', '2022-12-14', 11, 1, 'serra.jpg', '2023-01-22 22:19:11'),
(5, 'Rampa de Gondomar', 'Porto', '2023-03-23', 12, 1, 'mapa_serra.png', '2023-01-22 22:26:15'),
(23, 'Travessia Lisboa - Serra de Grândola', 'Serra de Grândola', '2022-07-06', 1, 1, '0-serra-grandola.jpg', '2023-01-22 22:34:21'),
(30, 'teste', 'teste', '2023-03-01', 0, 1, '63fe291a5768b4.93105094.jpeg', '2023-02-28 16:17:30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tipo` int NOT NULL DEFAULT '0',
  `ativo` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `registration_date`, `tipo`, `ativo`) VALUES
(9, 'admin', 'admin@gmail.com', 'admin', '2023-01-22 19:31:52', 1, 1),
(14, 'manuel', 'manuel@mail', '1', '2022-12-04 03:48:59', 0, 1),
(15, 'André', 'andre@gmail.com', '123', '2022-12-04 03:51:06', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_eventos`
--

CREATE TABLE `users_eventos` (
  `id` int NOT NULL,
  `id_evento` int NOT NULL,
  `id_user` int NOT NULL,
  `ativo` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users_eventos`
--

INSERT INTO `users_eventos` (`id`, `id_evento`, `id_user`, `ativo`) VALUES
(8, 5, 9, 0),
(10, 5, 9, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users_eventos`
--
ALTER TABLE `users_eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_evento` (`id_evento`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `users_eventos`
--
ALTER TABLE `users_eventos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `users_eventos`
--
ALTER TABLE `users_eventos`
  ADD CONSTRAINT `users_eventos_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_eventos_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
