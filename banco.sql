-- MariaDB dump 10.19  Distrib 10.7.8-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tcc-2
-- ------------------------------------------------------
-- Server version	10.7.8-MariaDB-1:10.7.8+maria~ubu2004

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_brindes`
--

DROP TABLE IF EXISTS `tb_brindes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_brindes` (
  `id_brinde` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `data_brindes` date DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `preco` decimal(11,2) DEFAULT NULL,
  `desconto` decimal(3,2) DEFAULT NULL,
  PRIMARY KEY (`id_brinde`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_brindes`
--

LOCK TABLES `tb_brindes` WRITE;
/*!40000 ALTER TABLE `tb_brindes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_brindes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_clientes`
--

DROP TABLE IF EXISTS `tb_clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `id_brinde` int(11) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `email` (`email`),
  KEY `id_brinde` (`id_brinde`),
  CONSTRAINT `tb_clientes_ibfk_1` FOREIGN KEY (`id_brinde`) REFERENCES `tb_brindes` (`id_brinde`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_clientes`
--

LOCK TABLES `tb_clientes` WRITE;
/*!40000 ALTER TABLE `tb_clientes` DISABLE KEYS */;
INSERT INTO `tb_clientes` VALUES
(1,'teste','nelson@gmail.com','123',NULL,'$2y$10$.n7L48EJFg0DaxC/7HIc8eYWVqTDXfCASf.6sCqT5BY5WflOXZNke',NULL,'2024-10-25');
/*!40000 ALTER TABLE `tb_clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_estoque`
--

DROP TABLE IF EXISTS `tb_estoque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_estoque` (
  `id_estoque` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `tipo_movimentacao` enum('entrada','saida') DEFAULT NULL,
  `data_movimentacao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_estoque`),
  KEY `id_produto` (`id_produto`),
  CONSTRAINT `tb_estoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `tb_produtos` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_estoque`
--

LOCK TABLES `tb_estoque` WRITE;
/*!40000 ALTER TABLE `tb_estoque` DISABLE KEYS */;
INSERT INTO `tb_estoque` VALUES
(1,1,66,'entrada','2024-10-25 15:17:28'),
(2,2,66,'entrada','2024-10-25 15:17:31'),
(3,3,66,'entrada','2024-10-25 15:17:34');
/*!40000 ALTER TABLE `tb_estoque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_itens_vendas`
--

DROP TABLE IF EXISTS `tb_itens_vendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_itens_vendas` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `id_venda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_item`),
  KEY `id_venda` (`id_venda`),
  KEY `id_produto` (`id_produto`),
  CONSTRAINT `tb_itens_vendas_ibfk_1` FOREIGN KEY (`id_venda`) REFERENCES `tb_vendas` (`id_venda`) ON DELETE CASCADE,
  CONSTRAINT `tb_itens_vendas_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `tb_produtos` (`id_produto`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_itens_vendas`
--

LOCK TABLES `tb_itens_vendas` WRITE;
/*!40000 ALTER TABLE `tb_itens_vendas` DISABLE KEYS */;
INSERT INTO `tb_itens_vendas` VALUES
(1,3,1,1,31.00),
(2,3,2,1,31.00);
/*!40000 ALTER TABLE `tb_itens_vendas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_produtos`
--

DROP TABLE IF EXISTS `tb_produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_produtos` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `tamanho` varchar(10) DEFAULT NULL,
  `cor` varchar(30) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `imagem` text DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_produtos`
--

LOCK TABLES `tb_produtos` WRITE;
/*!40000 ALTER TABLE `tb_produtos` DISABLE KEYS */;
INSERT INTO `tb_produtos` VALUES
(1,'In incididunt est n','Blanditiis eaque sit',31.00,'12','Minim sit a sunt dol','Adidas','img_671bb68841d8f.jpg','2024-10-25'),
(2,'In incididunt est n','Blanditiis eaque sit',31.00,'12','Minim sit a sunt dol','Adidas','img_671bb68becc99.jpg','2024-10-25'),
(3,'In incididunt est n','Blanditiis eaque sit',31.00,'12','Minim sit a sunt dol','Adidas','img_671bb68e5bac7.jpg','2024-10-25');
/*!40000 ALTER TABLE `tb_produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_vendas`
--

DROP TABLE IF EXISTS `tb_vendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_vendas` (
  `id_venda` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `cep` varchar(20) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `data_venda` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_venda`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `tb_vendas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tb_clientes` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_vendas`
--

LOCK TABLES `tb_vendas` WRITE;
/*!40000 ALTER TABLE `tb_vendas` DISABLE KEYS */;
INSERT INTO `tb_vendas` VALUES
(3,1,'Odit eum quod quisqu','Amet ipsam laborum','Consectetur possimu','Laboriosam laboris ','Aut vero commodi bla','2024-10-25 15:56:34');
/*!40000 ALTER TABLE `tb_vendas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tcc-2'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-25 15:58:15
