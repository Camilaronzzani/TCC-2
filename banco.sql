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
  `data_cadastro` date DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_clientes`
--

LOCK TABLES `tb_clientes` WRITE;
/*!40000 ALTER TABLE `tb_clientes` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_estoque`
--

LOCK TABLES `tb_estoque` WRITE;
/*!40000 ALTER TABLE `tb_estoque` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_estoque` ENABLE KEYS */;
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
  `imagem` TEXT DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_produtos`
--

LOCK TABLES `tb_produtos` WRITE;
/*!40000 ALTER TABLE `tb_produtos` DISABLE KEYS */;
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
  `id_cliente` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco_total` decimal(10,2) DEFAULT NULL,
  `data_venda` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_venda`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_produto` (`id_produto`),
  CONSTRAINT `tb_vendas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tb_clientes` (`id_cliente`),
  CONSTRAINT `tb_vendas_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `tb_produtos` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_vendas`
--

LOCK TABLES `tb_vendas` WRITE;
/*!40000 ALTER TABLE `tb_vendas` DISABLE KEYS */;
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


-- Dump completed on 2024-09-28 20:19:26
