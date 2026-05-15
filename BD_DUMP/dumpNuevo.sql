-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: finishline_db
-- ------------------------------------------------------
-- Server version	8.0.45

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Autenticacion`
--

DROP TABLE IF EXISTS `Autenticacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Autenticacion` (
  `id_autenticacion` int NOT NULL AUTO_INCREMENT,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id_autenticacion`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Autenticacion`
--

LOCK TABLES `Autenticacion` WRITE;
/*!40000 ALTER TABLE `Autenticacion` DISABLE KEYS */;
INSERT INTO `Autenticacion` VALUES (1,'$2y$10$5DFyRDE.6696z6vlum1e7O6g91tOullTcrqxQGTZ1va4Jtvn9qe12'),(2,'$2y$10$9z.se8UMs58HjmU0vPEUwu74enFXfqIc2KafcXRZ0rvXvitTO546u'),(3,'$2y$10$xA6uFNljJmafeK5HHnySZO4fw6sgs1VS.FUtI3jHttZ6FChN12ZHm'),(4,'$2y$10$5DFyRDE.6696z6vlum1e7O6g91tOullTcrqxQGTZ1va4Jtvn9qe12'),(5,'$2y$10$ZnRePg33ZPd8748kUxmereTrVhVVfX3XOOxYXli7pfc8v6azrgqbu');
/*!40000 ALTER TABLE `Autenticacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Nota_X_Ticket`
--

DROP TABLE IF EXISTS `Nota_X_Ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Nota_X_Ticket` (
  `id_nota` int NOT NULL AUTO_INCREMENT,
  `id_ticket` int NOT NULL,
  `id_usuario` int NOT NULL,
  `nota` text NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_nota`),
  KEY `id_ticket` (`id_ticket`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `Nota_X_Ticket_ibfk_1` FOREIGN KEY (`id_ticket`) REFERENCES `Ticket` (`id_ticket`) ON DELETE CASCADE,
  CONSTRAINT `Nota_X_Ticket_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Nota_X_Ticket`
--

LOCK TABLES `Nota_X_Ticket` WRITE;
/*!40000 ALTER TABLE `Nota_X_Ticket` DISABLE KEYS */;
INSERT INTO `Nota_X_Ticket` VALUES (1,39,1,'esta lijado','2026-05-12 22:06:28'),(2,47,1,'Esta en preparacion','2026-05-12 22:15:41'),(3,47,1,'esta emprimado','2026-05-12 22:21:17'),(4,47,1,'Esta Pintado','2026-05-12 22:21:26'),(5,47,1,'Esta secado','2026-05-12 22:21:32');
/*!40000 ALTER TABLE `Nota_X_Ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Respuesta_x_solicitud`
--

DROP TABLE IF EXISTS `Respuesta_x_solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Respuesta_x_solicitud` (
  `id_respuesta` int NOT NULL AUTO_INCREMENT,
  `id_solicitud` int NOT NULL,
  `respuesta` text NOT NULL,
  `fecha_respuesta` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_respuesta`),
  KEY `fk_rxs_solicitud` (`id_solicitud`),
  CONSTRAINT `fk_rxs_solicitud` FOREIGN KEY (`id_solicitud`) REFERENCES `Solicitudes` (`id_solicitud`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Respuesta_x_solicitud`
--

LOCK TABLES `Respuesta_x_solicitud` WRITE;
/*!40000 ALTER TABLE `Respuesta_x_solicitud` DISABLE KEYS */;
INSERT INTO `Respuesta_x_solicitud` VALUES (1,1,'fffffffffff','2026-05-15 17:25:10'),(2,1,'hyhyhyhyh','2026-05-15 17:33:40');
/*!40000 ALTER TABLE `Respuesta_x_solicitud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Respuesta_x_ticket`
--

DROP TABLE IF EXISTS `Respuesta_x_ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Respuesta_x_ticket` (
  `id_respuesta` int NOT NULL AUTO_INCREMENT,
  `id_ticket` int NOT NULL,
  `respuesta` text NOT NULL,
  `fecha_respuesta` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_respuesta`),
  KEY `fk_rxt_ticket` (`id_ticket`),
  CONSTRAINT `fk_rxt_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `Ticket` (`id_ticket`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Respuesta_x_ticket`
--

LOCK TABLES `Respuesta_x_ticket` WRITE;
/*!40000 ALTER TABLE `Respuesta_x_ticket` DISABLE KEYS */;
INSERT INTO `Respuesta_x_ticket` VALUES (1,47,'123 probando','2026-05-15 16:38:13'),(2,47,'Hola que tal , sigues ahi?','2026-05-15 16:39:02');
/*!40000 ALTER TABLE `Respuesta_x_ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Servicios`
--

DROP TABLE IF EXISTS `Servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Servicios` (
  `id_servicio` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text,
  `disponible` tinyint(1) DEFAULT '1',
  `categoria_vehiculo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Servicios`
--

LOCK TABLES `Servicios` WRITE;
/*!40000 ALTER TABLE `Servicios` DISABLE KEYS */;
INSERT INTO `Servicios` VALUES (4,'Lijado Superficial + Pintado Entero','Lijado completo de carrocería, imprimación y pintado bicapa con barniz UV.',1,'Todos'),(5,'Chapa + Pintura','Reparación de golpes y deformaciones en carrocería con pintado de acabado.',1,'Todos'),(6,'Pulido Profesional','Eliminación de micro-arañazos y recuperación del brillo original de la pintura.',1,'Todos'),(7,'Micro-Reparación + Pintado Selectivo','Reparación localizada por piezas con igualación exacta del color original.',1,'Todos'),(8,'Restauración de Llantas','Reparación de arañazos y oxidación en llantas con pintura y barniz protector.',1,'Todos');
/*!40000 ALTER TABLE `Servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Solicitudes`
--

DROP TABLE IF EXISTS `Solicitudes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Solicitudes` (
  `id_solicitud` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `asunto` varchar(100) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('pendiente','en_proceso','respondida') DEFAULT 'pendiente',
  PRIMARY KEY (`id_solicitud`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Solicitudes`
--

LOCK TABLES `Solicitudes` WRITE;
/*!40000 ALTER TABLE `Solicitudes` DISABLE KEYS */;
INSERT INTO `Solicitudes` VALUES (1,'henry','henrycf97@gmail.com','tecnico','vhrtrthtrhtrhrt','2026-05-05 13:49:57','pendiente'),(2,'henry','henrycf97@gmail.com','tecnico','vhrtrthtrhtrhrtbfgb','2026-05-05 13:50:43','pendiente'),(3,'henry','e@gf.com','tecnico','fffffffffffffffff','2026-05-05 13:53:14','pendiente'),(4,'loco','e@gf.com','tecnico','fffffffffffffffff','2026-05-05 13:56:21','pendiente'),(5,'henry','e@gf.com','tecnico','hhhhhhhhhhh','2026-05-05 14:08:54','pendiente'),(6,'fefe','henrycf97@gmail.com','tecnico','ffffffffffffff','2026-05-05 14:09:13','pendiente'),(7,'topo','topo@gm.conm','tecnico','topotafdefefe','2026-05-05 14:13:37','pendiente'),(8,'topo','topo@gm.conm','tecnico','veevev9o90p0','2026-05-06 18:28:05','pendiente'),(9,'fefe','topo@gm.conm','tecnico','fefefefefefefef','2026-05-08 14:16:27','pendiente'),(10,'fefe','topo@gm.conm','tecnico','fefefefefefefef','2026-05-08 14:16:47','pendiente'),(11,'fefe','topo@gm.conm','tecnico','fefefefefefefef','2026-05-08 14:16:56','pendiente'),(12,'fefe','topo@gm.conm','tecnico','fefefefefefefef','2026-05-08 14:17:02','pendiente'),(13,'fefe','henrycf97@gmail.com','tecnico','12fefefefefe','2026-05-08 19:50:10','pendiente'),(14,'henry','henrycf97@gmail.com','tecnico','ddddddddddddddddddddddd','2026-05-12 21:36:04','pendiente');
/*!40000 ALTER TABLE `Solicitudes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ticket`
--

DROP TABLE IF EXISTS `Ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Ticket` (
  `id_ticket` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `id_servicio` int DEFAULT NULL,
  `descripcion` text,
  `matricula` varchar(20) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `presupuesto` decimal(10,2) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'pendiente',
  `fecha_cita` datetime DEFAULT NULL,
  `modelo_auto` varchar(20) DEFAULT NULL,
  `id_empleado` int DEFAULT NULL,
  `descripcion_trabajo` text,
  PRIMARY KEY (`id_ticket`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_servicio` (`id_servicio`),
  KEY `Ticket_ibfk_3` (`id_empleado`),
  CONSTRAINT `fk_ticket_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `Usuario` (`id_usuario`),
  CONSTRAINT `Ticket_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`),
  CONSTRAINT `Ticket_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `Servicios` (`id_servicio`),
  CONSTRAINT `Ticket_ibfk_3` FOREIGN KEY (`id_empleado`) REFERENCES `Usuario` (`id_usuario`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ticket`
--

LOCK TABLES `Ticket` WRITE;
/*!40000 ALTER TABLE `Ticket` DISABLE KEYS */;
INSERT INTO `Ticket` VALUES (1,1,4,'fefe',NULL,'2026-05-01',NULL,NULL,'pendiente',NULL,'fefe',NULL,NULL),(2,1,5,'fefefe',NULL,'2026-05-01',NULL,NULL,'pendiente',NULL,'ferfefe',NULL,NULL),(3,1,5,'dwdw',NULL,'2026-05-01',NULL,NULL,'pendiente',NULL,'dwd',NULL,NULL),(4,1,5,'dwdw',NULL,'2026-05-01',NULL,NULL,'pendiente',NULL,'dwd',NULL,NULL),(5,1,5,'dwdw',NULL,'2026-05-01',NULL,NULL,'pendiente',NULL,'dwd',NULL,NULL),(6,1,4,'ewfwe',NULL,'2026-05-01',NULL,NULL,'pendiente',NULL,'123',NULL,NULL),(7,1,5,'fefefefefe',NULL,'2026-05-01',NULL,NULL,'pendiente',NULL,'rggreg',NULL,NULL),(8,1,5,'fefefefefe',NULL,'2026-05-02',NULL,NULL,'pendiente',NULL,'rggreg',NULL,NULL),(9,1,4,'fefefefefefefefefe',NULL,'2026-05-02',NULL,NULL,'pendiente',NULL,'fefe',NULL,NULL),(10,1,6,'fefef',NULL,'2026-05-02',NULL,NULL,'pendiente',NULL,'dwdw',NULL,NULL),(11,1,6,'dwdw',NULL,'2026-05-02',NULL,NULL,'pendiente',NULL,'dwdw',NULL,NULL),(12,1,5,'fefe',NULL,'2026-05-02',NULL,NULL,'pendiente',NULL,'fefeffefef',NULL,NULL),(13,1,4,'fefef',NULL,'2026-05-02',NULL,NULL,'pendiente',NULL,'dwdw',NULL,NULL),(14,1,4,'dede',NULL,'2026-05-03',NULL,NULL,'pendiente',NULL,'focus',NULL,NULL),(15,1,6,'fefe',NULL,'2026-05-03',NULL,NULL,'pendiente',NULL,'topo',NULL,NULL),(16,1,5,'+6+3',NULL,'2026-05-03',NULL,NULL,'pendiente',NULL,'dwdw',NULL,NULL),(17,1,6,'dede',NULL,'2026-05-03',NULL,NULL,'pendiente',NULL,'rggreg',NULL,NULL),(18,1,5,'dwdwd',NULL,'2026-05-03',NULL,NULL,'pendiente',NULL,'dwdw',NULL,NULL),(19,1,4,'fefef',NULL,'2026-05-03',NULL,NULL,'pendiente',NULL,'fefe',NULL,NULL),(20,1,4,'dwdw',NULL,'2026-05-03',NULL,NULL,'pendiente',NULL,'dwdwdw',NULL,NULL),(21,1,4,'fefe',NULL,'2026-05-03',NULL,NULL,'pendiente',NULL,'defe',NULL,NULL),(22,1,4,'dwd',NULL,'2026-05-03',NULL,NULL,'pendiente',NULL,'dwd',NULL,NULL),(23,1,5,'fef',NULL,'2026-05-03',NULL,NULL,'pendiente',NULL,'fef',NULL,NULL),(24,1,5,'dwd',NULL,'2026-05-03',NULL,NULL,'pendiente',NULL,'dwdw',NULL,NULL),(25,1,4,'Una aleta mal','1581FLT','2026-05-04',NULL,NULL,'pendiente',NULL,'ford focus',NULL,NULL),(26,1,5,'1221','21212','2026-05-04',NULL,NULL,'pendiente',NULL,'ford focus',NULL,NULL),(27,1,4,'egege','gegege','2026-05-04',NULL,NULL,'pendiente',NULL,'fgfegeg',NULL,NULL),(28,1,4,'egege','gegege','2026-05-04',NULL,NULL,'pendiente',NULL,'fgfegeg',NULL,NULL),(29,1,4,'egege','gegege','2026-05-04',NULL,NULL,'pendiente',NULL,'fgfegeg',NULL,NULL),(30,1,4,'egege','gegege','2026-05-04',NULL,NULL,'pendiente',NULL,'fgfegeg',NULL,NULL),(31,1,4,'egege','gegege','2026-05-04',NULL,NULL,'pendiente',NULL,'fgfegeg',NULL,NULL),(32,1,5,'vdvdv','vdvdv','2026-05-04',NULL,NULL,'pendiente',NULL,'sdvdvd',NULL,NULL),(33,1,4,'ddd','ddd','2026-05-04',NULL,NULL,'pendiente',NULL,'dd',NULL,NULL),(34,1,5,'vdvd','vdvdvdvdv','2026-05-04',NULL,NULL,'pendiente',NULL,'ddv',NULL,NULL),(35,1,4,'561564','68955648','2026-05-04',NULL,NULL,'pendiente',NULL,'dwd',NULL,NULL),(36,1,4,'561564','68955648','2026-05-04',NULL,NULL,'pendiente',NULL,'dwd',NULL,NULL),(37,1,6,'dsadsa','dsad','2026-05-04',NULL,NULL,'pendiente',NULL,'dd',NULL,NULL),(38,1,4,'fefef','effef','2026-05-04',NULL,NULL,'pendiente',NULL,'ffff',NULL,NULL),(39,1,4,'fefefe','fefefe','2026-05-05',NULL,123123.00,'en proceso',NULL,'fefe',1,'12312312'),(40,1,4,'fefe','fefe','2026-05-05',NULL,NULL,'pendiente',NULL,'eeee',NULL,NULL),(41,1,4,'rgrg','grgr','2026-05-05',NULL,232.00,'cancelado',NULL,'ggrg',4,'Hola , después de analizar las fotos y los daños a reparar se valora toda la mano de obra .'),(42,1,4,'Paragolpes por pintar','1581FLT','2026-05-05',NULL,324234.00,'en proceso',NULL,'ford focus',4,'efe'),(45,2,4,'Prueba desde Postman','1234ABC','2026-05-09',NULL,34.00,'en proceso',NULL,'bmw Serie3',4,'grgr'),(47,5,4,'dddd','ddddddd','2026-05-12',NULL,3434.00,'completado',NULL,'dddd',1,'Hola que tal , sigues ahi?');
/*!40000 ALTER TABLE `Ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuario`
--

DROP TABLE IF EXISTS `Usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `id_autenticacion` int DEFAULT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Correo` varchar(150) NOT NULL,
  `Rol` varchar(50) DEFAULT 'cliente',
  PRIMARY KEY (`id_usuario`),
  KEY `id_autenticacion` (`id_autenticacion`),
  CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`id_autenticacion`) REFERENCES `Autenticacion` (`id_autenticacion`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuario`
--

LOCK TABLES `Usuario` WRITE;
/*!40000 ALTER TABLE `Usuario` DISABLE KEYS */;
INSERT INTO `Usuario` VALUES (1,1,'Henry','Cantoral','12345678','henry@test.com','empleado'),(2,2,'Pope','cito','12358','pope@e.com','empleado'),(3,3,'proyecto','daw','12','pro@e.daw','cliente'),(4,4,'Admin','Principal','652955253','finishlineheesni@gmail.com','admin'),(5,5,'Henry','Cantoral','652955253','henrycf97@gmail.com','cliente');
/*!40000 ALTER TABLE `Usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documento_x_tickets`
--

DROP TABLE IF EXISTS `documento_x_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documento_x_tickets` (
  `id_documento` int NOT NULL,
  `id_ticket` int NOT NULL,
  PRIMARY KEY (`id_documento`,`id_ticket`),
  KEY `id_ticket` (`id_ticket`),
  CONSTRAINT `documento_x_tickets_ibfk_1` FOREIGN KEY (`id_documento`) REFERENCES `documentos` (`id_documento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `documento_x_tickets_ibfk_2` FOREIGN KEY (`id_ticket`) REFERENCES `Ticket` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento_x_tickets`
--

LOCK TABLES `documento_x_tickets` WRITE;
/*!40000 ALTER TABLE `documento_x_tickets` DISABLE KEYS */;
INSERT INTO `documento_x_tickets` VALUES (13,15),(14,15),(15,16),(16,16),(17,17),(18,17),(19,18),(20,19),(21,19),(22,20),(23,20),(24,21),(25,21),(26,21),(27,22),(28,23),(29,24),(30,25),(31,25),(32,26),(33,27),(34,28),(35,29),(36,30),(37,31),(38,32),(39,33),(40,34),(41,36),(42,36),(43,36),(44,37),(45,37),(46,37),(47,37),(48,38),(49,39),(50,40),(51,41),(52,42);
/*!40000 ALTER TABLE `documento_x_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentos`
--

DROP TABLE IF EXISTS `documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentos` (
  `id_documento` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `ruta` varchar(255) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentos`
--

LOCK TABLES `documentos` WRITE;
/*!40000 ALTER TABLE `documentos` DISABLE KEYS */;
INSERT INTO `documentos` VALUES (13,'Proceso.jpg','image/jpeg','/uploads/tickets/15/foto_69f77e74dbd7c.jpg','2026-05-03 16:57:24'),(14,'Pulido1.jpeg','image/jpeg','/uploads/tickets/15/foto_69f77e74e77a6.jpeg','2026-05-03 16:57:24'),(15,'Pulido1.jpeg','image/jpeg','/uploads/tickets/16/foto_69f7815a4168f.jpeg','2026-05-03 17:09:46'),(16,'Pulido2.jpeg','image/jpeg','/uploads/tickets/16/foto_69f7815a48f6f.jpeg','2026-05-03 17:09:46'),(17,'Pulido1.jpeg','image/jpeg','/uploads/tickets/17/foto_69f785111fe4b.jpeg','2026-05-03 17:25:37'),(18,'Pulido2.jpeg','image/jpeg','/uploads/tickets/17/foto_69f78511236ca.jpeg','2026-05-03 17:25:37'),(19,'Pulido2.jpeg','image/jpeg','/uploads/tickets/18/foto_69f7855e0fa41.jpeg','2026-05-03 17:26:54'),(20,'Pulido1.jpeg','image/jpeg','/uploads/tickets/19/foto_69f785a8cba02.jpeg','2026-05-03 17:28:08'),(21,'Pulido2.jpeg','image/jpeg','/uploads/tickets/19/foto_69f785a8d0b69.jpeg','2026-05-03 17:28:08'),(22,'Pulido1.jpeg','image/jpeg','/uploads/tickets/20/foto_69f785eb7790e.jpeg','2026-05-03 17:29:15'),(23,'Pulido2.jpeg','image/jpeg','/uploads/tickets/20/foto_69f785eb7e622.jpeg','2026-05-03 17:29:15'),(24,'Lijado.jpg','image/jpeg','/uploads/tickets/21/foto_69f785fda4a36.jpg','2026-05-03 17:29:33'),(25,'Proceso.jpg','image/jpeg','/uploads/tickets/21/foto_69f785fdb05f5.jpg','2026-05-03 17:29:33'),(26,'Pulido1.jpeg','image/jpeg','/uploads/tickets/21/foto_69f785fdb9fc9.jpeg','2026-05-03 17:29:33'),(27,'Pulido2.jpeg','image/jpeg','/uploads/tickets/22/foto_69f786778af1c.jpeg','2026-05-03 17:31:35'),(28,'Pulido2.jpeg','image/jpeg','/uploads/tickets/23/foto_69f786d71106d.jpeg','2026-05-03 17:33:11'),(29,'Proceso.jpg','image/jpeg','/uploads/tickets/24/foto_69f78705421b4.jpg','2026-05-03 17:33:57'),(30,'Proceso.jpg','image/jpeg','/uploads/tickets/25/foto_69f887b5dbe4e.jpg','2026-05-04 11:49:09'),(31,'Pulido1.jpeg','image/jpeg','/uploads/tickets/25/foto_69f887b5ecc07.jpeg','2026-05-04 11:49:09'),(32,'Lijado.jpg','image/jpeg','/uploads/tickets/26/foto_69f8b5733ec62.jpg','2026-05-04 15:04:19'),(33,'Pintor.jpeg','image/jpeg','/uploads/tickets/27/foto_69f8b8df24f17.jpeg','2026-05-04 15:18:55'),(34,'Pintor.jpeg','image/jpeg','/uploads/tickets/28/foto_69f8b937e2c2a.jpeg','2026-05-04 15:20:23'),(35,'Pintor.jpeg','image/jpeg','/uploads/tickets/29/foto_69f8b96121617.jpeg','2026-05-04 15:21:05'),(36,'Pintor.jpeg','image/jpeg','/uploads/tickets/30/foto_69f8b971a718b.jpeg','2026-05-04 15:21:21'),(37,'Pintor.jpeg','image/jpeg','/uploads/tickets/31/foto_69f8b9c149282.jpeg','2026-05-04 15:22:41'),(38,'Cabina_Pintura.jpg','image/jpeg','/uploads/tickets/32/foto_69f8b9e725059.jpg','2026-05-04 15:23:19'),(39,'Cabina_Pintura.jpg','image/jpeg','/uploads/tickets/33/foto_69f8ba2b45826.jpg','2026-05-04 15:24:27'),(40,'Lijado.jpg','image/jpeg','/uploads/tickets/34/foto_69f8bb2f061c8.jpg','2026-05-04 15:28:47'),(41,'Pintor.jpeg','image/jpeg','/uploads/tickets/36/foto_69f8c05102e2f.jpeg','2026-05-04 15:50:41'),(42,'Preparacion.jpg','image/jpeg','/uploads/tickets/36/foto_69f8c0510cb45.jpg','2026-05-04 15:50:41'),(43,'Proceso.jpg','image/jpeg','/uploads/tickets/36/foto_69f8c051127b9.jpg','2026-05-04 15:50:41'),(44,'Pintor.jpeg','image/jpeg','/uploads/tickets/37/foto_69f8c0a5e1288.jpeg','2026-05-04 15:52:05'),(45,'Preparacion.jpg','image/jpeg','/uploads/tickets/37/foto_69f8c0a5e68c9.jpg','2026-05-04 15:52:05'),(46,'Proceso.jpg','image/jpeg','/uploads/tickets/37/foto_69f8c0a5eaa1e.jpg','2026-05-04 15:52:05'),(47,'Pulido1.jpeg','image/jpeg','/uploads/tickets/37/foto_69f8c0a6003f2.jpeg','2026-05-04 15:52:06'),(48,'Cabina_Pintura.jpg','image/jpeg','/uploads/tickets/38/foto_69f90e2042dbb.jpg','2026-05-04 21:22:40'),(49,'Cabina_Pintura.jpg','image/jpeg','/uploads/tickets/39/foto_69f9a1a0d7798.jpg','2026-05-05 07:52:00'),(50,'Pintor.jpeg','image/jpeg','/uploads/tickets/40/foto_69f9a279bc12b.jpeg','2026-05-05 07:55:37'),(51,'Lijado.jpg','image/jpeg','/uploads/tickets/41/foto_69f9a5c46cac9.jpg','2026-05-05 08:09:40'),(52,'Proceso.jpg','image/jpeg','/uploads/tickets/42/foto_69fa5cf9e3bb4.jpg','2026-05-05 21:11:24'),(53,'Cabina_Pintura.jpg','image/jpeg','/uploads/tickets/46/foto_6a039dcfa0370.jpg','2026-05-12 21:38:23'),(54,'Lijado.jpg','image/jpeg','/uploads/tickets/46/foto_6a039dcfaab72.jpg','2026-05-12 21:38:23');
/*!40000 ALTER TABLE `documentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset`
--

DROP TABLE IF EXISTS `password_reset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `token` varchar(64) NOT NULL,
  `expira_en` datetime NOT NULL,
  `creado_en` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset`
--

LOCK TABLES `password_reset` WRITE;
/*!40000 ALTER TABLE `password_reset` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_notas`
--

DROP TABLE IF EXISTS `ticket_notas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_notas` (
  `id_nota` int NOT NULL AUTO_INCREMENT,
  `id_ticket` int NOT NULL,
  `id_usuario` int NOT NULL,
  `nota` text NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_nota`),
  KEY `fk_nota_ticket` (`id_ticket`),
  KEY `fk_nota_usuario` (`id_usuario`),
  CONSTRAINT `fk_nota_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `Ticket` (`id_ticket`) ON DELETE CASCADE,
  CONSTRAINT `fk_nota_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_notas`
--

LOCK TABLES `ticket_notas` WRITE;
/*!40000 ALTER TABLE `ticket_notas` DISABLE KEYS */;
INSERT INTO `ticket_notas` VALUES (1,39,1,'esta en proceso de lijado','2026-05-12 21:58:55');
/*!40000 ALTER TABLE `ticket_notas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'finishline_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-15 21:08:17
