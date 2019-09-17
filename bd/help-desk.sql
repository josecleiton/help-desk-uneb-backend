-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: localhost    Database: help-desk-uneb
-- ------------------------------------------------------
-- Server version	5.7.27-log

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
  `data` datetime NOT NULL,
  `descricao` text,
  `id_tecnico` varchar(20) DEFAULT NULL,
  `id_chamado` int(11) NOT NULL,
  `id_situacao` int(11) NOT NULL,
  `id_prioridade` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `talteracao_tprioridade_id_fk` (`id_prioridade`),
  KEY `talteracao_tsituacao_id_fk` (`id_situacao`),
  KEY `talteracao_tchamado_id_fk` (`id_chamado`),
  KEY `talteracao_ttecnico_login_fk` (`id_tecnico`),
  CONSTRAINT `talteracao_tchamado_id_fk` FOREIGN KEY (`id_chamado`) REFERENCES `tchamado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `talteracao_tprioridade_id_fk` FOREIGN KEY (`id_prioridade`) REFERENCES `tprioridade` (`id`),
  CONSTRAINT `talteracao_tsituacao_id_fk` FOREIGN KEY (`id_situacao`) REFERENCES `tsituacao` (`id`),
  CONSTRAINT `talteracao_ttecnico_login_fk` FOREIGN KEY (`id_tecnico`) REFERENCES `ttecnico` (`login`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `talteracao`
--

LOCK TABLES `talteracao` WRITE;
/*!40000 ALTER TABLE `talteracao` DISABLE KEYS */;
INSERT INTO `talteracao` VALUES (24,'2019-09-11 07:52:00','Criação do chamado.',NULL,28,1,1),(26,'2019-09-14 06:09:00','Criação do chamado.',NULL,30,1,1),(27,'2019-09-14 11:08:00','Criação do chamado.',NULL,31,1,1),(28,'2019-09-14 11:13:00','Criação do chamado.',NULL,32,1,1),(32,'2019-09-14 13:55:00','Criação do chamado.',NULL,36,1,1),(39,'2019-09-14 14:15:00','Criação do chamado.',NULL,43,1,1),(40,'2019-09-14 14:19:00','Criação do chamado.',NULL,44,1,1),(49,'2019-09-15 08:05:00',NULL,'josesilva',30,2,3),(52,'2019-09-15 08:45:00','Do técnico José da Silva para Neo do Matrix','josesilva',30,4,3),(56,'2019-09-15 09:16:00','Do setor ADM para Academica','josesilva',31,4,3),(57,'2019-09-15 09:22:00','Em atendimento por José da Silva','josesilva',31,2,1),(59,'2019-09-15 09:42:00','Chamado pendente por falta de recursos','josesilva',31,3,1),(66,'2019-09-15 09:51:31','Recursos chegaram','josesilva',31,2,1),(67,'2019-09-15 09:51:42','Chamado concluído','josesilva',31,5,1),(73,'2019-09-15 13:08:30','Transferência de ADM para Academica','josesilva',36,4,2),(74,'2019-09-15 14:54:20','Uma descrição','gerenteadm',43,2,2),(79,'2019-09-15 15:33:28','Falta muito recurso pra caramba','gerenteadm',43,3,2),(80,'2019-09-15 15:43:43','Recursos chegaram','gerenteadm',43,2,2),(81,'2019-09-15 16:02:22','Falta muito recurso vei','gerenteadm',43,3,2),(82,'2019-09-15 16:02:31','Recursos chegaram','gerenteadm',43,2,2),(84,'2019-09-15 16:22:09','Transferência de Gerente do ADM para José da Silva','gerenteadm',43,4,3),(86,'2019-09-15 19:10:21','Em atendimento por José da Silva','josesilva',43,2,3),(87,'2019-09-16 09:21:03','Alterações','gerenteadm',32,2,3),(88,'2019-09-16 09:23:00','Criação do chamado.',NULL,45,1,1),(91,'2019-09-16 09:46:34','Transferência de ADM para Academica','gerenteadm',45,4,3),(92,'2019-09-16 09:47:22','falta peça','gerenteadm',32,3,3),(93,'2019-09-16 09:47:50','Recursos chegaram','gerenteadm',32,2,3),(94,'2019-09-16 09:48:06','Chamado concluído','gerenteadm',32,5,3),(99,'2019-09-17 00:41:38','Criação do chamado.',NULL,51,1,1),(100,'2019-09-17 00:41:57','Criação do chamado.',NULL,52,1,1),(106,'2019-09-17 02:03:51','Criação do chamado.',NULL,58,1,1),(107,'2019-09-17 07:53:19','Criação do chamado.',NULL,59,1,1),(108,'2019-09-17 07:59:04','Atendido por Neo do John Wick','neomatrix',59,2,2),(109,'2019-09-17 07:59:58','Alguma ferramenta especifica','neomatrix',59,3,2),(110,'2019-09-17 08:00:27','Recursos chegaram','neomatrix',59,2,2),(111,'2019-09-17 08:03:24','Chamado concluído','neomatrix',59,5,2);
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
  `data` datetime DEFAULT NULL,
  `ti` tinyint(1) NOT NULL,
  `tombo` varchar(20) DEFAULT NULL,
  `id_tecnico` varchar(20) DEFAULT NULL,
  `id_usuario` varchar(11) NOT NULL,
  `id_setor` int(11) NOT NULL,
  `id_problema` int(11) DEFAULT NULL,
  `arquivo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tchamado_tsetor_id_fk` (`id_setor`),
  KEY `tchamado_ttecnico_login_fk` (`id_tecnico`),
  KEY `tchamado_tusuario_cpf_fk` (`id_usuario`),
  KEY `tchamado_tproblema_id_fk` (`id_problema`),
  CONSTRAINT `tchamado_tproblema_id_fk` FOREIGN KEY (`id_problema`) REFERENCES `tproblema` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tchamado_tsetor_id_fk` FOREIGN KEY (`id_setor`) REFERENCES `tsetor` (`id`),
  CONSTRAINT `tchamado_ttecnico_login_fk` FOREIGN KEY (`id_tecnico`) REFERENCES `ttecnico` (`login`),
  CONSTRAINT `tchamado_tusuario_cpf_fk` FOREIGN KEY (`id_usuario`) REFERENCES `tusuario` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tchamado`
--

LOCK TABLES `tchamado` WRITE;
/*!40000 ALTER TABLE `tchamado` DISABLE KEYS */;
INSERT INTO `tchamado` VALUES (28,'Um chamado bem importante','2019-09-11 07:52:00',0,NULL,'josesilva','05464133585',1,NULL,NULL),(30,'Que chamado incrivel','2019-09-14 06:09:00',0,NULL,'neomatrix','05464133585',21,NULL,NULL),(31,'dsadas','2019-09-14 11:08:00',0,NULL,'josesilva','99999999990',22,NULL,'1568470136_vim_logo.png'),(32,'dsadas','2019-09-14 11:13:00',0,NULL,'gerenteadm','99999999990',21,NULL,'1568470424_1486453617948-2.png'),(36,'Uma descrição importante para um chamado importante','2019-09-14 13:55:00',0,NULL,NULL,'99999999990',22,NULL,'1568480103_1552622129911.png'),(43,'Seraaaaaaaa','2019-09-14 14:15:00',0,'TOMBODAORA','josesilva','99999999990',21,NULL,'1568481326_43lab.jpg'),(44,'ESSE É DAQUELES CHAMADOS INCRIVEIS','2019-09-14 14:19:00',0,NULL,'neomatrix','99999999901',20,NULL,'1568481558_20-21.png'),(45,'Uma problema especifico especifico','2019-09-16 09:23:00',0,NULL,'gerenteacad','12345678950',22,NULL,'images/1568636580_1552627916970-0.jpg'),(51,'um outro chamaaado','2019-09-17 00:41:38',1,NULL,NULL,'99999999990',20,NULL,NULL),(52,'um outro outro chamaaado','2019-09-17 00:41:57',0,NULL,NULL,'99999999990',20,NULL,NULL),(58,'Vamoooos','2019-09-17 02:03:51',1,NULL,NULL,'99999999990',20,8,NULL),(59,'Chamado','2019-09-17 07:53:19',1,'1234567','neomatrix','99999999990',20,8,NULL);
/*!40000 ALTER TABLE `tchamado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tchamado_ti`
--

DROP TABLE IF EXISTS `tchamado_ti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tchamado_ti` (
  `software` varchar(80) NOT NULL,
  `data_utilizacao` date NOT NULL,
  `link` text NOT NULL,
  `plugins` text,
  `id_chamado` int(11) NOT NULL,
  `id_lab` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_chamado`),
  KEY `tchamado_ti_tlab_id_fk` (`id_lab`),
  CONSTRAINT `tchamado_ti_tchamado_id_fk` FOREIGN KEY (`id_chamado`) REFERENCES `tchamado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tchamado_ti_tlab_id_fk` FOREIGN KEY (`id_lab`) REFERENCES `tlab` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tchamado_ti`
--

LOCK TABLES `tchamado_ti` WRITE;
/*!40000 ALTER TABLE `tchamado_ti` DISABLE KEYS */;
INSERT INTO `tchamado_ti` VALUES ('Netbeans','2019-09-09','http://netbeans.com','php',51,1),('Corre pro abraço','2019-09-18','Correeee','corre demais',58,1),('Mysql','2019-09-18','mysql.com','dump',59,2);
/*!40000 ALTER TABLE `tchamado_ti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tlab`
--

DROP TABLE IF EXISTS `tlab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tlab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tlab`
--

LOCK TABLES `tlab` WRITE;
/*!40000 ALTER TABLE `tlab` DISABLE KEYS */;
INSERT INTO `tlab` VALUES (1,'LAMI1'),(2,'LAMI2');
/*!40000 ALTER TABLE `tlab` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tprioridade`
--

LOCK TABLES `tprioridade` WRITE;
/*!40000 ALTER TABLE `tprioridade` DISABLE KEYS */;
INSERT INTO `tprioridade` VALUES (3,'Alta'),(1,'Baixa'),(2,'Media'),(4,'Urgente');
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
  CONSTRAINT `tproblema_tsetor_id_fk` FOREIGN KEY (`id_setor`) REFERENCES `tsetor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tproblema`
--

LOCK TABLES `tproblema` WRITE;
/*!40000 ALTER TABLE `tproblema` DISABLE KEYS */;
INSERT INTO `tproblema` VALUES (7,'um problema adm',21),(8,'Módulo de Instalação',20),(9,'Testando problema',20),(10,'Novo problema',20),(11,'tela quebrou',20),(12,'teste novo',20);
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tsetor`
--

LOCK TABLES `tsetor` WRITE;
/*!40000 ALTER TABLE `tsetor` DISABLE KEYS */;
INSERT INTO `tsetor` VALUES (1,'prograd','71999999999','pesquisa2@uneb.br'),(20,'TI','373737','ti@uneb.br'),(21,'ADM','36363636','adm@uneb.br'),(22,'Academica','38383838','academica@uneb.br'),(23,'Comunicação','7133050505','comunicacao@uneb.br'),(24,'Financeiro','7133020202','financeiro@uneb.br'),(25,'RH','7133030303','rh@uneb.br');
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
  `cor` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tsituacao`
--

LOCK TABLES `tsituacao` WRITE;
/*!40000 ALTER TABLE `tsituacao` DISABLE KEYS */;
INSERT INTO `tsituacao` VALUES (1,'Em Aberto','f22427'),(2,'Em Atendimento','2cccc4'),(3,'Pendente','f2ee24'),(4,'Transferido','f27624'),(5,'Concluido','52cc2c');
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
  `id_setor` int(11) DEFAULT NULL,
  `cargo` enum('A','G') DEFAULT NULL,
  `senha` varchar(100) NOT NULL,
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
INSERT INTO `ttecnico` VALUES ('adsdasd','JOSE CLEITON BORGES CORREIA','jcleitonbc@gmail.com','71988888888',20,'G','$2y$12$I9AM2RsUoZzPQYnTeMaNA.1NfayUqEg1kaYbmXpCwXEuNKxuKE1WS'),('anacat','Ana Cátia','anacat@uneb.br','7133333333',NULL,'A','$2y$12$JW8HOLiGWoqqSoVgX6u9sOyYgeULqtJYVupgl26tlk6ShzTsSsOwi'),('gerenteacad','Gerente do Academica','gerenteacad@uneb.br','71942553333',22,'G','$2y$12$Pl.zMm5bi7ZvMMhkZLeAhObCUWFTyR/LR5lqpRZ.OLpYPK0swkyWa'),('gerenteadm','Gerente do ADM','gerenteadm@uneb.br','71942553333',21,'G','$2y$12$AsDKuMq6FYMKIzECKw9Tf.Uj4AyWekQJS8NN04vRz6TjBDgh98Mya'),('josesilva','José da Silva','josedasilva@uneb.br','71987654321',21,NULL,'$2y$12$aMU8//CO3Ih6/xS9HOtoiO8oU4dx.tEO4mLRhqoMYuVPOpmEizJvO'),('neomatrix','Neo do John Wick','neojohnwick@uneb.br','71942424242',NULL,'A','$2y$12$z3JKdrzd0cv6xvD3DbpgOuy6LobUIE20NUnNK5o7SXm9OjF6wLatu'),('novotecnicocomun','Comunicativo','comtec@uneb.br','7133065902',23,'G','$2y$12$j7hlw6/ETSZWmgaJiKk8c.tlMDN17z2ZPv8ZxmOv5liEmrInK/bTe'),('tecsupimpa','Técnico Supimpa','tecsupimpa@uneb.br','71987654351',24,NULL,'$2y$12$XZhihs3kCwoZMCqi4iSrUOtWqoyOifEG3JdobgJXT5kHTt218yJx2'),('testandodenovo','Testando Again','testinging@uneb.br','71988888888',23,'G','$2y$12$3w7H1k1h2/JiIaucUJct7.2ilGlBgBbJqDJ82WHu1mu3C56RK9T0y'),('testing','Testing','teste@teste.com','71999999999',24,NULL,'$2y$12$5giLtmU3FbkmJQ1LqXuvxenxSCcY0vNMSglYjDWMbtXiHCkRVHEMq'),('umlogincriativo','Nome Criativo','novoemail@uneb.br','71988888888',20,NULL,'$2y$12$1q0XD0IBaweAFqQ2sSCETOWz4znrzx/YQSgpXb/BlmrZG2hx9dpny'),('usuariodeteste','Mariana Testando','mariana@uneb.br','71988888888',20,'G','$2y$12$jfav/xYkn19kV.vKMh9yEuY7xaiPLuhIQAzXAFprctTiJYmw0aS3C');
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
  `nome` varchar(80) NOT NULL,
  PRIMARY KEY (`cpf`),
  UNIQUE KEY `tuser_email_uindex` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tusuario`
--

LOCK TABLES `tusuario` WRITE;
/*!40000 ALTER TABLE `tusuario` DISABLE KEYS */;
INSERT INTO `tusuario` VALUES ('05464133585','outrotest@gmail.com','7133053927','José Cuck'),('12345678901','bla@bla.com','77777777777','Danilo Nascimento'),('12345678922','rita@gmail.com','71988888479','Rita Maria'),('12345678950','josecleitonbc@outlook.com','71988888888','Um novo usuário'),('12345678988','mariana@gmail.com','7187654321','Mariana Santo'),('88888888888','joao@gmail.con','89898989898','Joao da silva'),('99999999901','danilodelete@gmail.com','71981111111','Danilo Nascimento'),('99999999990','jcleitonbc@gmail.com','71981142657','JOSE CLEITON BORGES CORREIA'),('99999999999','tst@tst.com','99999999999','Cleiton Borges');
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

-- Dump completed on 2019-09-17 21:35:14
