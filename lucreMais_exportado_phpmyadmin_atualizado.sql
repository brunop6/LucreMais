-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Jul-2021 às 22:11
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lucremais`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizaEstoque` (IN `param_idEstoque` INT, IN `param_idUsuario` INT, IN `quantidadeMovimento` DOUBLE, IN `param_observacao` VARCHAR(250), IN `tipo` CHAR(1))  BEGIN
	DECLARE quantidadeAtual DOUBLE;
	
	SELECT quantidade FROM estoque WHERE id = param_idEstoque INTO @quantidadeAtual; 
	
	if tipo = "E" then
	# esse trecho insere na tabela entradaEstoque e atualiza a Estoque 
		INSERT INTO entradaestoque
			(idEstoque, idUsuario, quantidade, observacao)
		VALUES
			(param_idEstoque, param_idUsuario, quantidadeMovimento, param_observacao);	
			
		UPDATE estoque SET
			quantidade = (@quantidadeAtual + quantidadeMovimento) 
		WHERE id = param_idEstoque;
		
		SELECT TRUE AS "atualizado", "Sucesso na operação de entrada de estoque" AS "mensagem";
		
	ELSEIF tipo = "S" then
	# esse trecho insere na tabela baixaEstoque e atualiza a Estoque
		if quantidadeMovimento <= @quantidadeAtual then
			INSERT INTO baixaestoque
				(idEstoque, idUsuario, quantidade, observacao)
			VALUES
				(param_idEstoque, param_idUsuario, quantidadeMovimento, param_observacao);	
			
			UPDATE estoque SET
				quantidade = (@quantidadeAtual - quantidadeMovimento) 
			WHERE id = param_idEstoque; 
			
			SELECT TRUE AS "atualizado", "Sucesso na operação de baixa de estoque" AS "mensagem";
			
		ELSE 
		
			SELECT
				FALSE AS "atualizado", 
				"Não é possível realizar a baixa, quantidade solicitada é maior que a quantidade disponível em estoque"
				AS "mensagem";
			
		END if;	
	ELSE 
		# se não foi nem entrada e nem saída = movimento inválido
		SELECT FALSE AS "atualizado", "Tipo de movimentação inválida" AS "mensagem";
		
	END if;
	
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `baixaestoque`
--

CREATE TABLE `baixaestoque` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `idEstoque` int(10) UNSIGNED NOT NULL,
  `quantidade` double NOT NULL,
  `observacao` varchar(250) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `descricaoCategoria` varchar(250) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoriadespesa`
--

CREATE TABLE `categoriadespesa` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoriareceitafinanceiro`
--

CREATE TABLE `categoriareceitafinanceiro` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `despesa`
--

CREATE TABLE `despesa` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `idCategoriaDespesa` int(10) UNSIGNED NOT NULL,
  `custo` double NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `entradaestoque`
--

CREATE TABLE `entradaestoque` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `idEstoque` int(10) UNSIGNED NOT NULL,
  `quantidade` double NOT NULL,
  `observacao` varchar(250) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE `estoque` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `idFornecedor` int(10) UNSIGNED NOT NULL,
  `idItem` int(10) UNSIGNED NOT NULL,
  `quantidade` double NOT NULL,
  `preco` double NOT NULL,
  `lote` int(11) NOT NULL,
  `validade` varchar(50) NOT NULL,
  `statusItem` enum('0','1') DEFAULT '1' COMMENT '0 - Inativo, 1 - Ativo',
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Acionadores `estoque`
--
DELIMITER $$
CREATE TRIGGER `estoque` AFTER INSERT ON `estoque` FOR EACH ROW BEGIN
	INSERT INTO entradaestoque
		(idEstoque, idUsuario, quantidade, observacao)
	VALUES 
		(NEW.id, NEW.idUsuario, NEW.quantidade,'Entrada');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `nomeFornecedor` varchar(50) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefone` varchar(15) NOT NULL,
  `cnpj` varchar(50) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE `item` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `idCategoria` int(10) UNSIGNED NOT NULL,
  `marca` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `quantidade` double NOT NULL,
  `quantidadeMinima` double NOT NULL,
  `unidadeMedida` varchar(50) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu`
--

CREATE TABLE `menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `menu`
--

INSERT INTO `menu` (`id`, `descricao`, `dataCadastro`, `dataAtualizacao`) VALUES
(1, 'Estoque', '2021-06-19 18:10:08', '2021-06-19 18:10:08'),
(2, 'Fornecedores', '2021-06-19 18:10:08', '2021-06-19 18:10:08'),
(3, 'Itens', '2021-06-19 18:10:08', '2021-06-19 18:10:08'),
(4, 'Receitas', '2021-06-19 18:10:08', '2021-06-19 18:10:08'),
(5, 'Financeiro', '2021-06-29 11:26:48', '2021-06-29 11:26:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel`
--

CREATE TABLE `nivel` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivelusuario`
--

CREATE TABLE `nivelusuario` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `idNivel` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissao`
--

CREATE TABLE `permissao` (
  `id` int(10) UNSIGNED NOT NULL,
  `idNivel` int(10) UNSIGNED NOT NULL,
  `idMenu` int(10) UNSIGNED NOT NULL,
  `inserir` enum('0','1') DEFAULT '1' COMMENT '0 - Não, 1 - Sim',
  `editar` enum('0','1') DEFAULT '1' COMMENT '0 - Não, 1 - Sim',
  `excluir` enum('0','1') DEFAULT '1' COMMENT '0 - Não, 1 - Sim'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita`
--

CREATE TABLE `receita` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `receitafinaceiro`
--

CREATE TABLE `receitafinaceiro` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `idCategoriareceitaFinanceiro` int(10) UNSIGNED NOT NULL,
  `valor` double NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `receitaitem`
--

CREATE TABLE `receitaitem` (
  `id` int(10) UNSIGNED NOT NULL,
  `idReceita` int(10) UNSIGNED NOT NULL,
  `idItem` int(10) UNSIGNED NOT NULL,
  `quantidade` double NOT NULL,
  `unidadeMedida` varchar(50) NOT NULL DEFAULT '',
  `custo` double NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `admin` enum('0','1') DEFAULT '1' COMMENT '0 - Não , 1 - Sim',
  `id` int(10) UNSIGNED NOT NULL,
  `nomeUsuario` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `baixaestoque`
--
ALTER TABLE `baixaestoque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `baixaEstoque_ibfk_1` (`idUsuario`),
  ADD KEY `baixaEstoque_ibfk_2` (`idEstoque`);

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_ibfk_1` (`idUsuario`);

--
-- Índices para tabela `categoriadespesa`
--
ALTER TABLE `categoriadespesa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoriaDespesa_ibfk_1` (`idUsuario`);

--
-- Índices para tabela `categoriareceitafinanceiro`
--
ALTER TABLE `categoriareceitafinanceiro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoriaReceitafinanceiro_ibfk_1` (`idUsuario`);

--
-- Índices para tabela `despesa`
--
ALTER TABLE `despesa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `despesa_ibfk_1` (`idUsuario`),
  ADD KEY `despesa_ibfk_2` (`idCategoriaDespesa`);

--
-- Índices para tabela `entradaestoque`
--
ALTER TABLE `entradaestoque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entradaEstoque_ibfk_1` (`idUsuario`),
  ADD KEY `entradaEstoque_ibfk_2` (`idEstoque`);

--
-- Índices para tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estoque_ibfk_1` (`idUsuario`),
  ADD KEY `estoque_ibfk_2` (`idFornecedor`),
  ADD KEY `estoque_ibfk_3` (`idItem`);

--
-- Índices para tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_nomeFornecedor` (`nomeFornecedor`),
  ADD UNIQUE KEY `unique_cnpj` (`cnpj`),
  ADD KEY `fornecedor_ibfk_1` (`idUsuario`);

--
-- Índices para tabela `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_ibfk_1` (`idUsuario`),
  ADD KEY `item_ibfk_3` (`idCategoria`);

--
-- Índices para tabela `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `nivelusuario`
--
ALTER TABLE `nivelusuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nivelUsuario_ibfk_1` (`idUsuario`),
  ADD KEY `nivelUsuario_ibfk_2` (`idNivel`);

--
-- Índices para tabela `permissao`
--
ALTER TABLE `permissao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissao_ibfk_1` (`idNivel`),
  ADD KEY `permissao_ibfk_2` (`idMenu`);

--
-- Índices para tabela `receita`
--
ALTER TABLE `receita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receita_ibfk_1` (`idUsuario`);

--
-- Índices para tabela `receitafinaceiro`
--
ALTER TABLE `receitafinaceiro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receitaFinanceiro_ibfk_1` (`idUsuario`),
  ADD KEY `receitaFinanceiro_ibfk_2` (`idCategoriareceitaFinanceiro`);

--
-- Índices para tabela `receitaitem`
--
ALTER TABLE `receitaitem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receitaItem_ibfk_1` (`idReceita`),
  ADD KEY `receitaItem_ibfk_2` (`idItem`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_nomeUsuario` (`nomeUsuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `baixaestoque`
--
ALTER TABLE `baixaestoque`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categoriadespesa`
--
ALTER TABLE `categoriadespesa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categoriareceitafinanceiro`
--
ALTER TABLE `categoriareceitafinanceiro`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `despesa`
--
ALTER TABLE `despesa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `entradaestoque`
--
ALTER TABLE `entradaestoque`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `item`
--
ALTER TABLE `item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `nivel`
--
ALTER TABLE `nivel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `nivelusuario`
--
ALTER TABLE `nivelusuario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `permissao`
--
ALTER TABLE `permissao`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `receita`
--
ALTER TABLE `receita`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `receitafinaceiro`
--
ALTER TABLE `receitafinaceiro`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `receitaitem`
--
ALTER TABLE `receitaitem`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `baixaestoque`
--
ALTER TABLE `baixaestoque`
  ADD CONSTRAINT `baixaEstoque_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `baixaEstoque_ibfk_2` FOREIGN KEY (`idEstoque`) REFERENCES `estoque` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `categoriadespesa`
--
ALTER TABLE `categoriadespesa`
  ADD CONSTRAINT `categoriaDespesa_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `categoriareceitafinanceiro`
--
ALTER TABLE `categoriareceitafinanceiro`
  ADD CONSTRAINT `categoriaReceitafinanceiro_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `despesa`
--
ALTER TABLE `despesa`
  ADD CONSTRAINT `despesa_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `despesa_ibfk_2` FOREIGN KEY (`idCategoriaDespesa`) REFERENCES `categoriadespesa` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `entradaestoque`
--
ALTER TABLE `entradaestoque`
  ADD CONSTRAINT `entradaEstoque_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `entradaEstoque_ibfk_2` FOREIGN KEY (`idEstoque`) REFERENCES `estoque` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `estoque_ibfk_2` FOREIGN KEY (`idFornecedor`) REFERENCES `fornecedor` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `estoque_ibfk_3` FOREIGN KEY (`idItem`) REFERENCES `item` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD CONSTRAINT `fornecedor_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_3` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `nivelusuario`
--
ALTER TABLE `nivelusuario`
  ADD CONSTRAINT `nivelUsuario_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nivelUsuario_ibfk_2` FOREIGN KEY (`idNivel`) REFERENCES `nivel` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `permissao`
--
ALTER TABLE `permissao`
  ADD CONSTRAINT `permissao_ibfk_1` FOREIGN KEY (`idNivel`) REFERENCES `nivel` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `permissao_ibfk_2` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `receita`
--
ALTER TABLE `receita`
  ADD CONSTRAINT `receita_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `receitafinaceiro`
--
ALTER TABLE `receitafinaceiro`
  ADD CONSTRAINT `receitaFinanceiro_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `receitaFinanceiro_ibfk_2` FOREIGN KEY (`idCategoriareceitaFinanceiro`) REFERENCES `categoriareceitafinanceiro` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `receitaitem`
--
ALTER TABLE `receitaitem`
  ADD CONSTRAINT `receitaItem_ibfk_1` FOREIGN KEY (`idReceita`) REFERENCES `receita` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `receitaItem_ibfk_2` FOREIGN KEY (`idItem`) REFERENCES `item` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
