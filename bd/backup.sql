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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `talteracao`
--

LOCK TABLES `talteracao` WRITE;
/*!40000 ALTER TABLE `talteracao` DISABLE KEYS */;
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
  `id_observacao` int(11) NOT NULL,
  `id_tecnico` varchar(20) NOT NULL,
  `id_usuario` varchar(11) NOT NULL,
  `id_setor` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tchamado_tobservacao_id_fk` (`id_observacao`),
  KEY `tchamado_tsetor_id_fk` (`id_setor`),
  KEY `tchamado_ttecnico_login_fk` (`id_tecnico`),
  KEY `tchamado_tusuario_cpf_fk` (`id_usuario`),
  CONSTRAINT `tchamado_tobservacao_id_fk` FOREIGN KEY (`id_observacao`) REFERENCES `tobservacao` (`id`),
  CONSTRAINT `tchamado_tsetor_id_fk` FOREIGN KEY (`id_setor`) REFERENCES `tsetor` (`id`),
  CONSTRAINT `tchamado_ttecnico_login_fk` FOREIGN KEY (`id_tecnico`) REFERENCES `ttecnico` (`login`),
  CONSTRAINT `tchamado_tusuario_cpf_fk` FOREIGN KEY (`id_usuario`) REFERENCES `tusuario` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tchamado`
--

LOCK TABLES `tchamado` WRITE;
/*!40000 ALTER TABLE `tchamado` DISABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tcor`
--

LOCK TABLES `tcor` WRITE;
/*!40000 ALTER TABLE `tcor` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tobservacao`
--

DROP TABLE IF EXISTS `tobservacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tobservacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text NOT NULL,
  `id_tecnico` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tobservacao_ttecnico_login_fk` (`id_tecnico`),
  CONSTRAINT `tobservacao_ttecnico_login_fk` FOREIGN KEY (`id_tecnico`) REFERENCES `ttecnico` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tobservacao`
--

LOCK TABLES `tobservacao` WRITE;
/*!40000 ALTER TABLE `tobservacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `tobservacao` ENABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tprioridade`
--

LOCK TABLES `tprioridade` WRITE;
/*!40000 ALTER TABLE `tprioridade` DISABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tsetor`
--

LOCK TABLES `tsetor` WRITE;
/*!40000 ALTER TABLE `tsetor` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tsituacao`
--

LOCK TABLES `tsituacao` WRITE;
/*!40000 ALTER TABLE `tsituacao` DISABLE KEYS */;
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
  `auth_key` varchar(40) DEFAULT NULL,
  `id_setor` int(11) NOT NULL,
  PRIMARY KEY (`login`),
  KEY `ttecnico_tsetor_id_fk` (`id_setor`),
  CONSTRAINT `ttecnico_tsetor_id_fk` FOREIGN KEY (`id_setor`) REFERENCES `tsetor` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ttecnico`
--

LOCK TABLES `ttecnico` WRITE;
/*!40000 ALTER TABLE `ttecnico` DISABLE KEYS */;
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
INSERT INTO `tusuario` VALUES ('12345678901','bla@bla.com',NULL);
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

-- Dump completed on 2019-08-16  0:27:18
