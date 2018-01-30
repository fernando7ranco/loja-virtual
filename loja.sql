-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 10-Maio-2017 às 17:50
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `loja`
--
CREATE DATABASE IF NOT EXISTS `loja` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `loja`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes_produtos`
--

CREATE TABLE IF NOT EXISTS `avaliacoes_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `avaliacao` int(11) NOT NULL,
  `comentario` varchar(200) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `avaliacoes_produtos`
--

INSERT INTO `avaliacoes_produtos` (`id`, `id_cliente`, `id_produto`, `avaliacao`, `comentario`, `data`) VALUES
(1, 1, 1, 5, 'very veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryvery veryve', '2017-03-08'),
(2, 1, 1, 5, 'sdsds', '2017-03-01'),
(3, 1, 1, 2, 'rrr', '0000-00-00'),
(4, 1, 1, 2, 'sdsds', '2017-03-01'),
(5, 1, 1, 5, 'rrrr', '0000-00-00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria_produtos`
--

CREATE TABLE IF NOT EXISTS `categoria_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genero` int(11) NOT NULL,
  `nome` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `categoria_produtos`
--

INSERT INTO `categoria_produtos` (`id`, `genero`, `nome`) VALUES
(7, 1, 'PERFUMARIA'),
(8, 1, 'MAQUIAGEM E ESMALTE'),
(9, 1, 'CABELOS'),
(10, 1, 'CORPO E BANHO'),
(11, 1, 'ROSTO'),
(12, 1, 'Acessórios'),
(13, 2, 'PERFUMARIA'),
(14, 2, 'CABELOS'),
(15, 2, 'CORPO E BANHO'),
(16, 2, 'ROSTO'),
(17, 2, 'Acesso');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `rg` varchar(10) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `endereco` varchar(80) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email` varchar(80) NOT NULL,
  `senha` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `cpf`, `rg`, `cep`, `endereco`, `bairro`, `estado`, `telefone`, `email`, `senha`) VALUES
(1, 'Fernando Soares Franco', '111.111.111-11', '1111111111', '91790240', 'Beco ffff', 'Restinga', 'GO', '(21) 21212-1211', 'fernandofranco157@gmail.com', 'fernando');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pre_clientes`
--

CREATE TABLE IF NOT EXISTS `pre_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` text NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `rg` varchar(10) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `endereco` varchar(80) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email` varchar(80) NOT NULL,
  `senha` varchar(16) NOT NULL,
  `tempo` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` int(11) NOT NULL,
  `subcategoria` int(11) NOT NULL,
  `imagens` varchar(200) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `desconto` int(11) NOT NULL,
  `data_desconto` date NOT NULL,
  `parcelas` varchar(100) NOT NULL,
  `novidade` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `informacoes` varchar(400) NOT NULL,
  `avaliacoes` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `categoria`, `subcategoria`, `imagens`, `nome`, `descricao`, `valor`, `desconto`, `data_desconto`, `parcelas`, `novidade`, `quantidade`, `informacoes`, `avaliacoes`) VALUES
(1, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(2, 7, 1, 'image020170322055658.jpg/image120170322055658.jpg', 'extremo', 'extremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextre', '200.00', 50, '2017-05-02', '[["1,11","11"]]', 1, 2222, 'extremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo ex', '4/5000'),
(3, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(4, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(5, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,55","3"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(6, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(7, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(8, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(9, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(10, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(11, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(12, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(13, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(14, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(15, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(16, 7, 1, 'image020170319065531.jpg/image220170319065531.jpg/image120170319065531.jpg/image320170319065531.jpg', 'aventura', 'Egeo Dolce Woman foi inspirado no lado doce da vida!\r\nA ideia do perfumista ao desenvolver a fragrÃ¢ncia foi recriar o cheiro do algodÃ£o doce. Um aroma prazeroso e uma experiÃªncia confortÃ¡vel que todo mundo ama desde crianÃ§a.\r\nFoi adicionado um carÃ¡ter feminino pelo acorde floral e um toque divertido atravÃ©s das frutas. E ainda Ã© sexy e sofisticado graÃ§as ao fundo oriental ambarado.\r\nÃ‰ uma fragrÃ¢nciaE', '183.70', 15, '2017-04-02', '[["10,00","10"],["5,00","5"],["2,00","2"],["4,44","4"],["5,55","3"],["2,33","6"]]', 1, 100, 'Title Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTitle Ã© o Ã¡lbum de estreia da cantora norte-americana Meghan Trainor. A ediÃ§Ã£o padrÃ£o e deluxe foram lanÃ§adas na mesma data, 09 de janeiro de 2015, mundialmente. Title Ã© o Ã¡lbum de estreia daTi', '4/5000'),
(17, 7, 1, 'image020170322055658.jpg/image120170322055658.jpg', 'extremo', 'extremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextre', '200.00', 50, '2017-05-02', '[["1,11","11"]]', 1, 2222, 'extremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo extremoextremo ex', '4/5000');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_favoritos`
--

CREATE TABLE IF NOT EXISTS `produtos_favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Extraindo dados da tabela `produtos_favoritos`
--

INSERT INTO `produtos_favoritos` (`id`, `id_cliente`, `id_produto`) VALUES
(17, 1, 1),
(18, 1, 2),
(19, 1, 3),
(20, 1, 4),
(23, 1, 5),
(24, 1, 17);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sacola`
--

CREATE TABLE IF NOT EXISTS `sacola` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `sacola`
--

INSERT INTO `sacola` (`id`, `id_cliente`, `id_produto`, `quantidade`, `data`) VALUES
(3, 1, 10, 1, '2017-04-15 12:49:59'),
(4, 1, 1, 1, '2017-04-15 12:54:17'),
(5, 1, 7, 1, '2017-04-15 17:07:14');

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategoria_produtos`
--

CREATE TABLE IF NOT EXISTS `subcategoria_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subcategoria_id` (`id_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `subcategoria_produtos`
--

INSERT INTO `subcategoria_produtos` (`id`, `nome`, `id_categoria`) VALUES
(1, 'Acórdes', 7),
(2, 'Acqua Fresca', 7),
(3, 'Capricho', 7),
(4, 'Anni', 7),
(5, 'Cecita', 7),
(6, 'Coffee', 7),
(7, 'Egeo', 7),
(8, 'Elysé', 7);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `subcategoria_produtos`
--
ALTER TABLE `subcategoria_produtos`
  ADD CONSTRAINT `fk_subcategoria_id` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_produtos` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
