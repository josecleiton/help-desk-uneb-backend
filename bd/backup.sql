-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: localhost    Database: help-desk-uneb
-- ------------------------------------------------------
-- Server version	5.7.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `talteracao`
--

DROP TABLE IF EXISTS `talteracao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `talteracao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `descricao` text NOT NULL,
  `id_tecnico` varchar(20) NOT NULL,
  `id_chamado` int(11) NOT NULL,
  `id_situacao` int(11) NOT NULL,
  `id_prioridade` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `talteracao_ttecnico_login_fk` (`id_tecnico`),
  KEY `talteracao_tchamado_id_fk` (`id_chamado`),
  KEY `talteracao_tprioridade_id_fk` (`id_prioridade`),
  KEY `talteracao_tsituacao_id_fk` (`id_situacao`),
  CONSTRAINT `talteracao_tchamado_id_fk` FOREIGN KEY (`id_chamado`) REFERENCES `tchamado` (`id`),
  CONSTRAINT `talteracao_tprioridade_id_fk` FOREIGN KEY (`id_prioridade`) REFERENCES `tprioridade` (`id`),
  CONSTRAINT `talteracao_tsituacao_id_fk` FOREIGN KEY (`id_situacao`) REFERENCES `tsituacao` (`id`),
  CONSTRAINT `talteracao_ttecnico_login_fk` FOREIGN KEY (`id_tecnico`) REFERENCES `ttecnico` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `talteracao`
--

LOCK TABLES `talteracao` WRITE;
/*!40000 ALTER TABLE `talteracao` DISABLE KEYS */;
INSERT INTO `talteracao` VALUES (2,'2019-08-16','Teste alteração','test',2,1,1);
/*!40000 ALTER TABLE `talteracao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tchamado`
--

DROP TABLE IF EXISTS `tchamado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tchamado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text NOT NULL,
  `data` date NOT NULL,
  `ti` tinyint(1) NOT NULL,
  `tombo` varchar(20) NOT NULL,
  `id_tecnico` varchar(20) DEFAULT NULL,
  `id_usuario` varchar(11) NOT NULL,
  `id_setor` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tchamado_tsetor_id_fk` (`id_setor`),
  KEY `tchamado_ttecnico_login_fk` (`id_tecnico`),
  KEY `tchamado_tusuario_cpf_fk` (`id_usuario`),
  CONSTRAINT `tchamado_tsetor_id_fk` FOREIGN KEY (`id_setor`) REFERENCES `tsetor` (`id`),
  CONSTRAINT `tchamado_ttecnico_login_fk` FOREIGN KEY (`id_tecnico`) REFERENCES `ttecnico` (`login`),
  CONSTRAINT `tchamado_tusuario_cpf_fk` FOREIGN KEY (`id_usuario`) REFERENCES `tusuario` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tchamado`
--

LOCK TABLES `tchamado` WRITE;
/*!40000 ALTER TABLE `tchamado` DISABLE KEYS */;
INSERT INTO `tchamado` VALUES (2,'um chamado de teste','2019-08-16',1,'111111','test','12345678901',1),(3,'test2','2019-08-20',1,'111111','test','99999999999',1);
/*!40000 ALTER TABLE `tchamado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tcor`
--

DROP TABLE IF EXISTS `tcor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tcor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hex` varchar(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tcor_hex_uindex` (`hex`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tcor`
--

LOCK TABLES `tcor` WRITE;
/*!40000 ALTER TABLE `tcor` DISABLE KEYS */;
INSERT INTO `tcor` VALUES (1,'ffffff');
/*!40000 ALTER TABLE `tcor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tprioridade`
--

DROP TABLE IF EXISTS `tprioridade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tprioridade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tprioridade_descricao_uindex` (`descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tprioridade`
--

LOCK TABLES `tprioridade` WRITE;
/*!40000 ALTER TABLE `tprioridade` DISABLE KEYS */;
INSERT INTO `tprioridade` VALUES (1,'Alta');
/*!40000 ALTER TABLE `tprioridade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tproblema`
--

DROP TABLE IF EXISTS `tproblema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tproblema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text NOT NULL,
  `id_setor` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tproblema_tsetor_id_fk` (`id_setor`),
  CONSTRAINT `tproblema_tsetor_id_fk` FOREIGN KEY (`id_setor`) REFERENCES `tsetor` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tproblema`
--

LOCK TABLES `tproblema` WRITE;
/*!40000 ALTER TABLE `tproblema` DISABLE KEYS */;
/*!40000 ALTER TABLE `tproblema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tsetor`
--

DROP TABLE IF EXISTS `tsetor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tsetor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tsetor_email_uindex` (`email`),
  UNIQUE KEY `tsetor_nome_uindex` (`nome`),
  UNIQUE KEY `tsetor_telefone_uindex` (`telefone`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tsetor`
--

LOCK TABLES `tsetor` WRITE;
/*!40000 ALTER TABLE `tsetor` DISABLE KEYS */;
INSERT INTO `tsetor` VALUES (1,'test','71999999999','test1@test.com'),(20,'TI','373737','ti@uneb.br');
/*!40000 ALTER TABLE `tsetor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tsituacao`
--

DROP TABLE IF EXISTS `tsituacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tsituacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  `id_cor` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tsituacao_tcor_id_fk` (`id_cor`),
  CONSTRAINT `tsituacao_tcor_id_fk` FOREIGN KEY (`id_cor`) REFERENCES `tcor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tsituacao`
--

LOCK TABLES `tsituacao` WRITE;
/*!40000 ALTER TABLE `tsituacao` DISABLE KEYS */;
INSERT INTO `tsituacao` VALUES (1,'Em shokk',1);
/*!40000 ALTER TABLE `tsituacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ttecnico`
--

DROP TABLE IF EXISTS `ttecnico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ttecnico` (
  `login` varchar(20) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `id_setor` int(11) NOT NULL,
  `cargo` char(1) DEFAULT NULL,
  PRIMARY KEY (`login`),
  UNIQUE KEY `ttecnico_email_uindex` (`email`),
  KEY `ttecnico_tsetor_id_fk` (`id_setor`),
  CONSTRAINT `ttecnico_tsetor_id_fk` FOREIGN KEY (`id_setor`) REFERENCES `tsetor` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ttecnico`
--

LOCK TABLES `ttecnico` WRITE;
/*!40000 ALTER TABLE `ttecnico` DISABLE KEYS */;
INSERT INTO `ttecnico` VALUES ('test','Testando','test@test.com','71999999999',1,NULL);
/*!40000 ALTER TABLE `ttecnico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tusuario`
--

DROP TABLE IF EXISTS `tusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tusuario` (
  `cpf` varchar(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`cpf`),
  UNIQUE KEY `tuser_email_uindex` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tusuario`
--

LOCK TABLES `tusuario` WRITE;
/*!40000 ALTER TABLE `tusuario` DISABLE KEYS */;
INSERT INTO `tusuario` VALUES ('12345678901','bla@bla.com','77777777777'),('99999999999','tst@tst.com','99999999999');
/*!40000 ALTER TABLE `tusuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-03 11:16:31
