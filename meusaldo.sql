-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Ago-2026 às 22:47
-- Versão do servidor: 8.0.29
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `meusaldo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `anuncios`
--

CREATE TABLE `anuncios` (
  `idAnuncio` int NOT NULL,
  `Usuarios_idUsuario` int NOT NULL,
  `nomeProduto` varchar(30) NOT NULL,
  `estoqueProduto` int NOT NULL,
  `categoriaAnuncio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `valorCustoAnuncio` decimal(10,2) NOT NULL,
  `valorAnuncio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `anuncios`
--

INSERT INTO `anuncios` (`idAnuncio`, `Usuarios_idUsuario`, `nomeProduto`, `estoqueProduto`, `categoriaAnuncio`, `valorCustoAnuncio`, `valorAnuncio`) VALUES
(1, 1, 'brownie', 5, 'Alimentos', '15.00', '10.00'),
(2, 1, 'Mouse Gameer', 2, 'Eletrônicos', '30.00', '50.00'),
(3, 3, 'Brownie com leite ninho', 20, 'Alimentos', '5.00', '10.00'),
(4, 3, 'Celular', 1, 'Eletrônicos', '500.00', '750.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int NOT NULL,
  `nomeUsuario` varchar(100) NOT NULL,
  `emailUsuario` varchar(100) NOT NULL,
  `senhaUsuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `confirmarSenhaUsuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nomeUsuario`, `emailUsuario`, `senhaUsuario`, `confirmarSenhaUsuario`) VALUES
(1, 'joao', 'joao@gmail.com', '12345', '12345'),
(2, 'joao', 'joao123@gmail.com', '123456', '123456'),
(3, 'rafael', 'rafael@gmail.com', '1234', '1234'),
(51, 'GABRIEL', 'gabriel@gmail.com', '12345', '12345');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`idAnuncio`),
  ADD KEY `Usuarios_idUsuario` (`Usuarios_idUsuario`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `idAnuncio` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `anuncios`
--
ALTER TABLE `anuncios`
  ADD CONSTRAINT `Usuarios_idUsuario` FOREIGN KEY (`Usuarios_idUsuario`) REFERENCES `usuarios` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
