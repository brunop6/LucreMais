-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.18-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para lucremais
CREATE DATABASE IF NOT EXISTS `lucremais` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `lucremais`;

-- Copiando estrutura para tabela lucremais.baixaestoque
CREATE TABLE IF NOT EXISTS `baixaestoque` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `idEstoque` int(10) unsigned NOT NULL,
  `quantidade` double NOT NULL,
  `observacao` varchar(250) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `baixaEstoque_ibfk_1` (`idUsuario`),
  KEY `baixaEstoque_ibfk_2` (`idEstoque`),
  CONSTRAINT `baixaEstoque_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `baixaEstoque_ibfk_2` FOREIGN KEY (`idEstoque`) REFERENCES `estoque` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `descricaoCategoria` varchar(250) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `categoria_ibfk_1` (`idUsuario`),
  CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.categoriadespesa
CREATE TABLE IF NOT EXISTS `categoriadespesa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `categoriaDespesa_ibfk_1` (`idUsuario`),
  CONSTRAINT `categoriaDespesa_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.categoriareceitafinanceiro
CREATE TABLE IF NOT EXISTS `categoriareceitafinanceiro` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `categoriaReceitafinanceiro_ibfk_1` (`idUsuario`),
  CONSTRAINT `categoriaReceitafinanceiro_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.despesa
CREATE TABLE IF NOT EXISTS `despesa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `idCategoriaDespesa` int(10) unsigned NOT NULL,
  `custo` double NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `despesa_ibfk_1` (`idUsuario`),
  KEY `despesa_ibfk_2` (`idCategoriaDespesa`),
  CONSTRAINT `despesa_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `despesa_ibfk_2` FOREIGN KEY (`idCategoriaDespesa`) REFERENCES `categoriadespesa` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.entradaestoque
CREATE TABLE IF NOT EXISTS `entradaestoque` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `idEstoque` int(10) unsigned NOT NULL,
  `quantidade` double NOT NULL,
  `observacao` varchar(250) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `entradaEstoque_ibfk_1` (`idUsuario`),
  KEY `entradaEstoque_ibfk_2` (`idEstoque`),
  CONSTRAINT `entradaEstoque_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `entradaEstoque_ibfk_2` FOREIGN KEY (`idEstoque`) REFERENCES `estoque` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.estoque
CREATE TABLE IF NOT EXISTS `estoque` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `idFornecedor` int(10) unsigned NOT NULL,
  `idItem` int(10) unsigned NOT NULL,
  `quantidade` double NOT NULL,
  `preco` double NOT NULL,
  `lote` int(11) NOT NULL,
  `validade` varchar(50) NOT NULL,
  `statusItem` enum('0','1') DEFAULT '1' COMMENT '0 - Inativo, 1 - Ativo',
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `estoque_ibfk_1` (`idUsuario`),
  KEY `estoque_ibfk_2` (`idFornecedor`),
  KEY `estoque_ibfk_3` (`idItem`),
  CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `estoque_ibfk_2` FOREIGN KEY (`idFornecedor`) REFERENCES `fornecedor` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `estoque_ibfk_3` FOREIGN KEY (`idItem`) REFERENCES `item` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.fornecedor
CREATE TABLE IF NOT EXISTS `fornecedor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `nomeFornecedor` varchar(50) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefone` varchar(15) NOT NULL,
  `cnpj` varchar(50) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_nomeFornecedor` (`nomeFornecedor`),
  UNIQUE KEY `unique_cnpj` (`cnpj`),
  KEY `fornecedor_ibfk_1` (`idUsuario`),
  CONSTRAINT `fornecedor_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.item
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `idCategoria` int(10) unsigned NOT NULL,
  `marca` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `quantidade` double NOT NULL,
  `quantidadeMinima` double NOT NULL,
  `unidadeMedida` varchar(50) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `item_ibfk_1` (`idUsuario`),
  KEY `item_ibfk_3` (`idCategoria`),
  CONSTRAINT `item_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `item_ibfk_3` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.nivel
CREATE TABLE IF NOT EXISTS `nivel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.nivelusuario
CREATE TABLE IF NOT EXISTS `nivelusuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `idNivel` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nivelUsuario_ibfk_1` (`idUsuario`),
  KEY `nivelUsuario_ibfk_2` (`idNivel`),
  CONSTRAINT `nivelUsuario_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `nivelUsuario_ibfk_2` FOREIGN KEY (`idNivel`) REFERENCES `nivel` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.permissao
CREATE TABLE IF NOT EXISTS `permissao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idNivel` int(10) unsigned NOT NULL,
  `idMenu` int(10) unsigned NOT NULL,
  `inserir` enum('0','1') DEFAULT '1' COMMENT '0 - Não, 1 - Sim',
  `editar` enum('0','1') DEFAULT '1' COMMENT '0 - Não, 1 - Sim',
  `excluir` enum('0','1') DEFAULT '1' COMMENT '0 - Não, 1 - Sim',
  PRIMARY KEY (`id`),
  KEY `permissao_ibfk_1` (`idNivel`),
  KEY `permissao_ibfk_2` (`idMenu`),
  CONSTRAINT `permissao_ibfk_1` FOREIGN KEY (`idNivel`) REFERENCES `nivel` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `permissao_ibfk_2` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.receita
CREATE TABLE IF NOT EXISTS `receita` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `nome` varchar(50) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `receita_ibfk_1` (`idUsuario`),
  CONSTRAINT `receita_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.receitafinaceiro
CREATE TABLE IF NOT EXISTS `receitafinaceiro` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `idCategoriareceitaFinanceiro` int(10) unsigned NOT NULL,
  `valor` double NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `receitaFinanceiro_ibfk_1` (`idUsuario`),
  KEY `receitaFinanceiro_ibfk_2` (`idCategoriareceitaFinanceiro`),
  CONSTRAINT `receitaFinanceiro_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `receitaFinanceiro_ibfk_2` FOREIGN KEY (`idCategoriareceitaFinanceiro`) REFERENCES `categoriareceitafinanceiro` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.receitaitem
CREATE TABLE IF NOT EXISTS `receitaitem` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idReceita` int(10) unsigned NOT NULL,
  `idItem` int(10) unsigned NOT NULL,
  `quantidade` double NOT NULL,
  `unidadeMedida` varchar(50) NOT NULL DEFAULT '',
  `custo` double NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `receitaItem_ibfk_1` (`idReceita`),
  KEY `receitaItem_ibfk_2` (`idItem`),
  CONSTRAINT `receitaItem_ibfk_1` FOREIGN KEY (`idReceita`) REFERENCES `receita` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `receitaItem_ibfk_2` FOREIGN KEY (`idItem`) REFERENCES `item` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela lucremais.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `admin` enum('0','1') DEFAULT '1' COMMENT '0 - Não , 1 - Sim',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomeUsuario` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `dataAtualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_nomeUsuario` (`nomeUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para procedure lucremais.atualizaEstoque
DELIMITER //
CREATE PROCEDURE `atualizaEstoque`(IN `param_idEstoque` INT, IN `param_idUsuario` INT, IN `quantidadeMovimento` DOUBLE, IN `param_observacao` VARCHAR(250), IN `tipo` CHAR(1))
BEGIN
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
	
END//
DELIMITER ;

-- Copiando estrutura para trigger lucremais.estoque
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `estoque` AFTER INSERT ON `estoque` FOR EACH ROW BEGIN
	INSERT INTO entradaestoque
		(idEstoque, idUsuario, quantidade, observacao)
	VALUES 
		(NEW.id, NEW.idUsuario, NEW.quantidade,'Entrada');
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
