-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: localhost    Database: eureka
-- ------------------------------------------------------
-- Server version	8.0.29-0ubuntu0.20.04.3

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
-- Table structure for table `acconcepts`
--

DROP TABLE IF EXISTS `acconcepts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acconcepts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `order` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `statusc` tinyint NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acconcepts_user_created_id_foreign` (`user_created_id`),
  KEY `acconcepts_user_updated_id_foreign` (`user_updated_id`),
  KEY `acconcepts_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `acconcepts_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `acconcepts_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `acconcepts_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acconcepts`
--

LOCK TABLES `acconcepts` WRITE;
/*!40000 ALTER TABLE `acconcepts` DISABLE KEYS */;
INSERT INTO `acconcepts` VALUES (1,'Activo',NULL,'1.',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(2,'Activo Circulante',1,'1.1.',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(3,'Efectivo y Equivalentes de Efectivo',2,'1.1.1.',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(4,'Efectivo en Caja',3,'1.1.1.01.',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(5,'Caja Principal Moneda Local',4,'1.1.1.01.01.',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(6,'Caja Principal',5,'1.1.1.01.01.001',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(7,'Caja I.G.T.F CxP',5,'1.1.1.01.01.002',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(8,'Caja Chica I.G.T.F',5,'1.1.1.01.01.003',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(9,'Caja Chica',5,'1.1.1.01.01.004',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(10,'Caja de Pagos',5,'1.1.1.01.01.005',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(11,'Caja de directores',5,'1.1.1.01.01.006',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(12,'Solicitud de Pago',5,'1.1.1.01.01.010',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(13,'Transferencia de Fondos',5,'1.1.1.01.01.011',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(14,'Caja POS Banplus',5,'1.1.1.01.01.050',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(15,'Caja DOM Banplus',5,'1.1.1.01.01.051',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(16,'Caja POS Venezuela',5,'1.1.1.01.01.052',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(17,'Caja DOM Venezuela',5,'1.1.1.01.01.053',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(18,'Caja POS Tesoro',5,'1.1.1.01.01.054',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(19,'Caja DOM Tesoro',5,'1.1.1.01.01.055',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(20,'Caja DOM BICENTENARIO',5,'1.1.1.01.01.057',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(21,'Caja DOM Mercantil',5,'1.1.1.01.01.058',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(22,'Caja DOM Bco Plaza',5,'1.1.1.01.01.059',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(23,'Caja DOM Bco Activo',5,'1.1.1.01.01.060',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(24,'Caja DOM BFC',5,'1.1.1.01.01.061',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(25,'Caja principal Moneda Extranjera',4,'1.1.1.01.02.',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(26,'Caja principal MoEx',25,'1.1.1.01.02.001',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(27,'Caja Aliados MoEx',25,'1.1.1.01.02.002',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(28,'Caja Directores MoEx',25,'1.1.1.01.02.003',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(29,'Caja Traslados MoEx',25,'1.1.1.01.02.099',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(30,'Bancos Moneda Local',3,'1.1.1.02.',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(31,'Bancos Moneda Local',4,'1.1.1.02.01.',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(32,'Banco Banplus',31,'1.1.1.02.01.001',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(33,'Banco Activo',31,'1.1.1.02.01.002',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(34,'Bancaribe',31,'1.1.1.02.01.003',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(35,'Banco de Venezuela',31,'1.1.1.02.01.004',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(36,'Banco del Tesoro',31,'1.1.1.02.01.005',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(37,'Banco Bicentenario',31,'1.1.1.02.01.006',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(38,'Banco Mercantil',31,'1.1.1.02.01.007',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(39,'Banco Fondo Común',31,'1.1.1.02.01.008',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(40,'Banco de Venezuela Cta 3013',31,'1.1.1.02.01.009',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(41,'Banco Nacional de Credito',31,'1.1.1.02.01.010',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(42,'Banco Plaza Cta 6164',31,'1.1.1.02.01.013',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(43,'Bancos Moneda Extranjera',3,'1.1.1.03.',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(44,'Bancos Moneda Extranjera',4,'1.1.1.03.01.',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(45,'Facebank Puerto Rico',45,'1.1.1.03.01.001',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(46,'Banco Activo Internacional',45,'1.1.1.03.01.002',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(47,'Banplus $',45,'1.1.1.03.01.004',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(48,'Banco Fondo Común $',45,'1.1.1.03.01.006',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(49,'Banco Mercantil $',45,'1.1.1.03.01.008',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(50,'Banco Mercantil €',45,'1.1.1.03.01.010',1,1,1,'2021-02-12 00:00:00','2021-02-12 00:00:00',NULL,NULL),(51,'Banco del Sur',31,'1.1.1.02.01.014',1,1,NULL,'2021-02-18 09:48:16','2021-02-18 09:48:16',NULL,NULL),(52,'Banco del Sur $',44,'1.1.1.03.01.014',1,1,NULL,'2021-02-18 09:48:56','2021-02-18 09:48:56',NULL,NULL),(53,'Banco del Tesoro $ 0244',43,'1.1.1.03.01.024',1,1,NULL,'2021-02-24 11:39:13','2021-02-24 11:39:13',NULL,NULL),(54,'Banco Nacional de Credito $ 6718',43,'1.1.1.03.01.020',1,31,31,'2021-04-06 14:04:11','2021-04-09 11:20:05',NULL,NULL),(55,'100% Banco 5843',31,'1.1.1.02.01.020',1,22,22,'2021-04-12 15:12:42','2021-04-13 08:24:33',NULL,NULL),(56,'Mi Banco',31,'1.1.1.02.01.018',1,22,NULL,'2021-04-13 08:33:49','2021-04-13 08:33:49',NULL,NULL),(57,'Bancrecer  0168$',44,'1.1.1.03.01.028',1,22,22,'2021-04-15 12:33:08','2021-04-15 12:35:48',NULL,NULL),(58,'Bancrecer Bs.',31,'1.1.1.02.01.016',1,22,NULL,'2021-04-23 10:13:27','2021-04-23 10:13:27',NULL,NULL),(59,'Banesco Panamá $',44,'1.1.1.03.01.012',1,22,NULL,'2021-04-29 12:42:34','2021-04-29 12:42:34',NULL,NULL),(60,'CHASE ZELLE',44,'1.1.1.03.01.029',1,22,22,'2021-07-09 07:54:03','2021-07-09 09:29:10',NULL,NULL),(61,'B & BBT ZELLE',44,'1.1.1.03.01.031',1,22,22,'2021-07-09 09:30:07','2021-07-09 09:32:24',NULL,NULL),(62,'TESORO € 0245',43,'1.1.1.03.01.026',1,22,NULL,'2021-08-10 13:43:09','2021-08-10 13:43:09',NULL,NULL),(63,'Bancaribe $ Cta 3456',44,'1.1.1.03.01.036',1,22,NULL,'2021-09-20 07:30:38','2021-09-20 07:30:38',NULL,NULL),(64,'100% Banco $ Cta 0149',44,'1.1.1.03.01.005',1,31,31,'2021-10-07 15:36:26','2021-10-07 15:37:20',NULL,NULL),(65,'Venezuela$',43,'1.1.1.03.01.033',1,61,NULL,'2021-10-22 13:08:03','2021-10-22 13:08:03',NULL,NULL),(66,'BANCO PROVINCIAL BS',31,'1.1.1.02.01.021',1,61,61,'2021-10-25 13:26:12','2021-10-25 13:26:52',NULL,NULL),(67,'BANCO PLAZA BPLZ$',44,'1.1.1.03.01.038',1,21,NULL,'2021-12-01 14:08:16','2021-12-01 14:08:16',NULL,NULL),(68,'BANCRECRER - BANCR€',44,'1.1.1.03.01.040',1,21,NULL,'2021-12-07 14:25:05','2021-12-07 14:25:05',NULL,NULL),(69,'100% BANCO$ 8766 (100%$6)',44,'1.1.1.03.01.042',1,21,NULL,'2022-01-26 21:03:50','2022-01-26 21:03:50',NULL,NULL),(70,'Banco de Venezuela $ Cta 9869',44,'1.1.1.03.01.044',1,21,NULL,'2022-01-31 20:05:44','2022-01-31 20:05:44',NULL,NULL);
/*!40000 ALTER TABLE `acconcepts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aconsecutives`
--

DROP TABLE IF EXISTS `aconsecutives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aconsecutives` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fechpro` date DEFAULT NULL,
  `bank_id` bigint unsigned DEFAULT NULL,
  `contract_id` bigint unsigned DEFAULT NULL,
  `refere` bigint unsigned DEFAULT NULL,
  `is_management` tinyint(1) DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aconsecutives_user_created_id_foreign` (`user_created_id`),
  KEY `aconsecutives_contract_id_foreign` (`contract_id`) /*!80000 INVISIBLE */,
  KEY `aconsecutives_bank_id_foreign` (`bank_id`),
  CONSTRAINT `aconsecutives_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  CONSTRAINT `aconsecutives_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `aconsecutives_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aconsecutives`
--

LOCK TABLES `aconsecutives` WRITE;
/*!40000 ALTER TABLE `aconsecutives` DISABLE KEYS */;
/*!40000 ALTER TABLE `aconsecutives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adomiciliations`
--

DROP TABLE IF EXISTS `adomiciliations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adomiciliations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bank_id` bigint unsigned DEFAULT NULL,
  `file_bank` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file_response_bank` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `send_email` tinyint(1) DEFAULT NULL,
  `data_email` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('Generado','Enviado','Procesado','Cargado','Anulado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_send_id` bigint unsigned DEFAULT NULL,
  `send_at` date DEFAULT NULL,
  `user_process_id` bigint unsigned DEFAULT NULL,
  `process_at` date DEFAULT NULL,
  `user_upload_id` bigint unsigned DEFAULT NULL,
  `upload_at` date DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `adomiciliations_bank_id_foreign` (`bank_id`),
  KEY `adomiciliations_user_created_id_foreign` (`user_created_id`),
  KEY `adomiciliations_user_updated_id_foreign` (`user_updated_id`),
  KEY `adomiciliations_user_deleted_id_foreign` (`user_deleted_id`),
  KEY `adomiciliations_user_send_id_foreign` (`user_send_id`),
  KEY `adomiciliations_user_upload_id_foreign` (`user_upload_id`),
  KEY `adomiciliations_user_process_id_foreign` (`user_process_id`),
  CONSTRAINT `adomiciliations_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  CONSTRAINT `adomiciliations_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `adomiciliations_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `adomiciliations_user_process_id_foreign` FOREIGN KEY (`user_process_id`) REFERENCES `users` (`id`),
  CONSTRAINT `adomiciliations_user_send_id_foreign` FOREIGN KEY (`user_send_id`) REFERENCES `users` (`id`),
  CONSTRAINT `adomiciliations_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`),
  CONSTRAINT `adomiciliations_user_upload_id_foreign` FOREIGN KEY (`user_upload_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adomiciliations`
--

LOCK TABLES `adomiciliations` WRITE;
/*!40000 ALTER TABLE `adomiciliations` DISABLE KEYS */;
/*!40000 ALTER TABLE `adomiciliations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apn`
--

DROP TABLE IF EXISTS `apn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apn` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `operator_id` bigint unsigned NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apn_operator_id_foreign` (`operator_id`),
  KEY `apn_user_created_id_foreign` (`user_created_id`),
  KEY `apn_user_updated_id_foreign` (`user_updated_id`),
  KEY `apn_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `apn_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`),
  CONSTRAINT `apn_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `apn_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `apn_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apn`
--

LOCK TABLES `apn` WRITE;
/*!40000 ALTER TABLE `apn` DISABLE KEYS */;
INSERT INTO `apn` VALUES (1,1,'APN Credicard',1,NULL,'2021-01-28 11:10:48','2021-01-28 11:10:35',NULL,NULL),(2,2,'APN Credicard',1,NULL,'2021-01-28 11:10:48','2021-01-28 11:10:48',NULL,NULL),(3,1,'APN Mercantil',1,NULL,'2021-01-28 11:10:48','2021-01-28 11:10:48',NULL,NULL),(4,2,'APN Mercantil',1,NULL,'2021-01-28 11:10:48','2021-01-28 11:10:48',NULL,NULL);
/*!40000 ALTER TABLE `apn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_assign_id` bigint unsigned DEFAULT NULL,
  `terminal_id` bigint unsigned DEFAULT NULL,
  `simcard_id` bigint unsigned DEFAULT NULL,
  `observations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('P','A','D','C','X') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint unsigned DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assignments_user_assign_id_foreign` (`user_assign_id`),
  KEY `assignments_terminal_id_foreign` (`terminal_id`),
  KEY `assignments_simcard_id_foreign` (`simcard_id`),
  KEY `assignments_user_created_id_foreign` (`user_created_id`),
  KEY `assignments_user_updated_id_foreign` (`user_updated_id`),
  KEY `assignments_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `assignments_simcard_id_foreign` FOREIGN KEY (`simcard_id`) REFERENCES `simcards` (`id`),
  CONSTRAINT `assignments_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`),
  CONSTRAINT `assignments_user_assign_id_foreign` FOREIGN KEY (`user_assign_id`) REFERENCES `users` (`id`),
  CONSTRAINT `assignments_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `assignments_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `assignments_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments`
--

LOCK TABLES `assignments` WRITE;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atcmessages`
--

DROP TABLE IF EXISTS `atcmessages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `atcmessages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `atc_id` bigint unsigned DEFAULT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `atcmessages_atc_id_foreign` (`atc_id`),
  KEY `atcmessages_user_created_id_foreign` (`user_created_id`),
  CONSTRAINT `atcmessages_atc_id_foreign` FOREIGN KEY (`atc_id`) REFERENCES `atcs` (`id`),
  CONSTRAINT `atcmessages_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atcmessages`
--

LOCK TABLES `atcmessages` WRITE;
/*!40000 ALTER TABLE `atcmessages` DISABLE KEYS */;
/*!40000 ALTER TABLE `atcmessages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atcs`
--

DROP TABLE IF EXISTS `atcs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `atcs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `channel_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `rif` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `managementtype_id` bigint unsigned DEFAULT NULL,
  `mtypeitem_id` bigint unsigned DEFAULT NULL,
  `contract_id` bigint unsigned DEFAULT NULL,
  `observation` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observation_manager` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('G','P','F','X') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `atcs_channel_id_foreign` (`channel_id`),
  KEY `atcs_customer_id_foreign` (`customer_id`),
  KEY `atcs_managementtype_id_foreign` (`managementtype_id`),
  KEY `atcs_mtypeitem_id_foreign` (`mtypeitem_id`),
  KEY `atcs_contract_id_foreign` (`contract_id`),
  KEY `atcs_user_created_id_foreign` (`user_created_id`),
  KEY `atcs_user_updated_id_foreign` (`user_updated_id`),
  KEY `atcs_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `atcs_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `channels` (`id`),
  CONSTRAINT `atcs_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `atcs_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `atcs_managementtype_id_foreign` FOREIGN KEY (`managementtype_id`) REFERENCES `managementtypes` (`id`),
  CONSTRAINT `atcs_mtypeitem_id_foreign` FOREIGN KEY (`mtypeitem_id`) REFERENCES `mtypeitems` (`id`),
  CONSTRAINT `atcs_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `atcs_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `atcs_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atcs`
--

LOCK TABLES `atcs` WRITE;
/*!40000 ALTER TABLE `atcs` DISABLE KEYS */;
/*!40000 ALTER TABLE `atcs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bankdocuments`
--

DROP TABLE IF EXISTS `bankdocuments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bankdocuments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fechpro` date DEFAULT NULL,
  `amount_currency` double(15,2) DEFAULT NULL,
  `bank_id` bigint unsigned DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name_file` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('G','P','R') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bankdocuments_bank_id_foreign` (`bank_id`),
  KEY `bankdocuments_user_created_id_foreign` (`user_created_id`),
  KEY `bankdocuments_user_updated_id_foreign` (`user_updated_id`),
  CONSTRAINT `bankdocuments_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  CONSTRAINT `bankdocuments_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `bankdocuments_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bankdocuments`
--

LOCK TABLES `bankdocuments` WRITE;
/*!40000 ALTER TABLE `bankdocuments` DISABLE KEYS */;
/*!40000 ALTER TABLE `bankdocuments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rif` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_code` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_register` tinyint(1) DEFAULT '0',
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `banks_user_created_id_foreign` (`user_created_id`),
  KEY `banks_user_updated_id_foreign` (`user_updated_id`),
  KEY `banks_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `banks_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `banks_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `banks_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banks`
--

LOCK TABLES `banks` WRITE;
/*!40000 ALTER TABLE `banks` DISABLE KEYS */;
INSERT INTO `banks` VALUES (1,'G-20009997-6','VENEZUELA','Esq. Sociedad, Avenida Universidad, Caracas, Distrito Capital','0102',0,1,36,'2021-01-28 10:56:40','2022-04-13 20:06:13',NULL,NULL),(2,'J-00072306-0','BANCO BFC','Avenida Venezuela, Caracas 1060,Distrito Capital','0151',1,1,36,'2021-01-28 10:57:09','2022-04-13 20:06:41',NULL,NULL),(3,'J-00297055-3','PLAZA','Av. Casanova, Entre calles Unión y Villaflor, Sabana Grande','0138',0,1,36,'2021-01-28 10:57:34','2022-04-13 20:06:57',NULL,NULL),(4,'J-31637417-3','BANCRECER','Av. Francisco de Miranda, Torre Bazar Bolivar, Nivel PB, Cruce con Calle Capitolio, Boleita Sur, Municipio Sucre, Estado Miranda','0168',1,1,36,'2021-01-28 10:58:05','2022-04-13 20:07:17',NULL,NULL),(5,'J-00042303-2','BANPLUS','Centro Ciudad Comercial Tamanaco, Caracas.','0174',0,1,36,'2021-01-28 10:58:36','2022-04-13 20:07:28',NULL,NULL),(6,'J-00079723-4','DEL SUR','Av. Francisco de Miranda, Torre Delta, Nivel PB, Altamira, Caracas','0157',1,1,36,'2021-01-28 10:59:03','2022-04-13 20:07:36',NULL,NULL),(7,'J-31594102-3','MI BANCO','Centro Comercial Lido, Nivel Miranda, Local M-11, Avenida Francisco de Miranda, El Rosal, Municipio Chacao, Caracas.','0169',0,1,36,'2021-01-28 10:59:32','2022-04-13 20:08:06',NULL,NULL),(8,'G-20009148-7','BICENTENARIO','Av. Francisco Solano Lopez, Residencias Solano, P.B., Sabana Grande, Caracas.','0175',0,1,36,'2021-01-28 11:00:06','2022-04-13 20:08:45',NULL,NULL),(9,'J-00002961-0','MERCANTIL','Urdaneta, esquina de Candilito a Urapal, C.C. Casa Bera, Nivel Avilanes, Local L AS-01 Parroquia Candelaria, Municipio Libertador, Caracas','0105',1,1,36,'2021-02-01 08:31:50','2022-04-13 20:07:53',NULL,NULL),(10,'G-20005187-6','TESORO','Calle Guaicaipuro, Torre Banco del Tesoro. Urb. El Rosal, Municipio Chacao, Caracas. Venezuela.','0163',0,9,36,'2021-02-09 08:02:50','2022-04-13 20:06:05',NULL,NULL),(11,'J-08006622-7','ACTIVO','Caracs Miranda','0171',0,9,36,'2021-02-09 08:06:10','2022-04-13 20:05:54',NULL,NULL),(12,'J-08500776-8','100% BANCO','1060 Avenida Francisco de Miranda, Caracas 1060, Distrito Capital','0156',0,1,36,'2021-02-11 10:16:59','2022-04-13 20:05:36',NULL,NULL),(13,'J-00002949-0','BANCARIBE','Avenida Francisco de Miranda Centro Empresarial Gaitán 1060, Caracas, Miranda, Venezuela','0114',0,1,36,'2021-07-31 11:03:24','2022-04-13 20:05:45',NULL,NULL);
/*!40000 ALTER TABLE `banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billingitems`
--

DROP TABLE IF EXISTS `billingitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `billingitems` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `billing_id` bigint unsigned DEFAULT NULL,
  `contract_id` bigint unsigned DEFAULT NULL,
  `invoice_id` bigint unsigned DEFAULT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `iva` int DEFAULT NULL,
  `free` double DEFAULT NULL,
  `amount_sim` double(15,2) DEFAULT NULL,
  `amount` double(15,2) DEFAULT NULL,
  `amount_currency` double(15,2) DEFAULT NULL,
  `terminal_id` bigint unsigned DEFAULT NULL,
  `simcard_id` bigint unsigned DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `billingitems_billing_id_foreign` (`billing_id`),
  KEY `billingitems_contract_id_foreign` (`contract_id`),
  KEY `billingitems_invoice_id_foreign` (`invoice_id`),
  KEY `billingitems_order_id_foreign` (`order_id`),
  KEY `billingitems_terminal_id_foreign` (`terminal_id`),
  KEY `billingitems_simcard_id_foreign` (`simcard_id`),
  KEY `billingitems_user_created_id_foreign` (`user_created_id`),
  KEY `billingitems_user_updated_id_foreign` (`user_updated_id`),
  KEY `billingitems_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `billingitems_billing_id_foreign` FOREIGN KEY (`billing_id`) REFERENCES `billings` (`id`),
  CONSTRAINT `billingitems_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `billingitems_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  CONSTRAINT `billingitems_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `billingitems_simcard_id_foreign` FOREIGN KEY (`simcard_id`) REFERENCES `simcards` (`id`),
  CONSTRAINT `billingitems_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`),
  CONSTRAINT `billingitems_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `billingitems_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `billingitems_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billingitems`
--

LOCK TABLES `billingitems` WRITE;
/*!40000 ALTER TABLE `billingitems` DISABLE KEYS */;
/*!40000 ALTER TABLE `billingitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billings`
--

DROP TABLE IF EXISTS `billings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `billings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fechpro` datetime DEFAULT NULL,
  `fechven` datetime DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `rif` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dicom` double(15,2) DEFAULT NULL,
  `template` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `billings_customer_id_foreign` (`customer_id`),
  KEY `billings_user_created_id_foreign` (`user_created_id`),
  KEY `billings_user_updated_id_foreign` (`user_updated_id`),
  KEY `billings_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `billings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `billings_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `billings_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `billings_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billings`
--

LOCK TABLES `billings` WRITE;
/*!40000 ALTER TABLE `billings` DISABLE KEYS */;
/*!40000 ALTER TABLE `billings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business`
--

DROP TABLE IF EXISTS `business`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rif` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `business_user_created_id_foreign` (`user_created_id`),
  KEY `business_user_updated_id_foreign` (`user_updated_id`),
  KEY `business_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `business_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `business_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `business_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business`
--

LOCK TABLES `business` WRITE;
/*!40000 ALTER TABLE `business` DISABLE KEYS */;
INSERT INTO `business` VALUES (1,'J-00000000-0','Name','0000-0000000','Address',1,NULL,'2021-01-26 13:42:37','2021-01-26 13:42:37',NULL,NULL);
/*!40000 ALTER TABLE `business` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cactivities`
--

DROP TABLE IF EXISTS `cactivities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cactivities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code_cactivity` bigint NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cactivities_user_created_id_foreign` (`user_created_id`),
  KEY `cactivities_user_updated_id_foreign` (`user_updated_id`),
  KEY `cactivities_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `cactivities_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `cactivities_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `cactivities_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=773 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cactivities`
--

LOCK TABLES `cactivities` WRITE;
/*!40000 ALTER TABLE `cactivities` DISABLE KEYS */;
INSERT INTO `cactivities` VALUES (1,1111,'Cultivo de cereales excepto arroz y para forrajes',1,1,'2021-01-27 00:23:35',NULL,NULL,NULL),(2,1112,'Cultivo de legumbres',1,1,'2021-01-28 00:23:35',NULL,NULL,NULL),(3,1113,'Cultivo de semillas oleaginosas',1,1,'2021-01-29 00:23:35',NULL,NULL,NULL),(4,1114,'Cultivo de plantas para la preparación de semillas',1,1,'2021-01-30 00:23:35',NULL,NULL,NULL),(5,1119,'Cultivo de otros cereales excepto arroz y forrajeros n.c.p.',1,1,'2021-01-31 00:23:35',NULL,NULL,NULL),(6,1120,'Cultivo de arroz',1,1,'2021-02-01 00:23:35',NULL,NULL,NULL),(7,1131,'Cultivo de raíces y tubérculos',1,1,'2021-02-02 00:23:35',NULL,NULL,NULL),(8,1132,'Cultivo de brotes, bulbos, vegetales tubérculos y cultivos similares',1,1,'2021-02-03 00:23:35',NULL,NULL,NULL),(9,1133,'Cultivo hortícola de fruto',1,1,'2021-02-04 00:23:35',NULL,NULL,NULL),(10,1134,'Cultivo de hortalizas de hoja y otras hortalizas ncp',1,1,'2021-02-05 00:23:35',NULL,NULL,NULL),(11,1140,'Cultivo de caña de azúcar',1,1,'2021-02-06 00:23:35',NULL,NULL,NULL),(12,1150,'Cultivo de tabaco',1,1,'2021-02-07 00:23:35',NULL,NULL,NULL),(13,1161,'Cultivo de algodón',1,1,'2021-02-08 00:23:35',NULL,NULL,NULL),(14,1162,'Cultivo de fibras vegetales excepto algodón',1,1,'2021-02-09 00:23:35',NULL,NULL,NULL),(15,1191,'Cultivo de plantas no perennes  para la producción de semillas y flores',1,1,'2021-02-10 00:23:35',NULL,NULL,NULL),(16,1192,'Cultivo de cereales y pastos para la alimentación animal',1,1,'2021-02-11 00:23:35',NULL,NULL,NULL),(17,1199,'Producción de cultivos no estacionales  ncp',1,1,'2021-02-12 00:23:35',NULL,NULL,NULL),(18,1220,'Cultivo de frutas tropicales',1,1,'2021-02-13 00:23:35',NULL,NULL,NULL),(19,1230,'Cultivo de cítricos',1,1,'2021-02-14 00:23:35',NULL,NULL,NULL),(20,1240,'Cultivo de frutas de pepita y hueso',1,1,'2021-02-15 00:23:35',NULL,NULL,NULL),(21,1251,'Cultivo de frutas ncp',1,1,'2021-02-16 00:23:35',NULL,NULL,NULL),(22,1252,'Cultivo de otros frutos  y nueces de árboles y arbustos',1,1,'2021-02-17 00:23:35',NULL,NULL,NULL),(23,1260,'Cultivo de frutos oleaginosos',1,1,'2021-02-18 00:23:35',NULL,NULL,NULL),(24,1271,'Cultivo de café',1,1,'2021-02-19 00:23:35',NULL,NULL,NULL),(25,1272,'Cultivo de plantas para la elaboración de bebidas excepto café',1,1,'2021-02-20 00:23:35',NULL,NULL,NULL),(26,1281,'Cultivo de especias y aromáticas',1,1,'2021-02-21 00:23:35',NULL,NULL,NULL),(27,1282,'Cultivo de plantas para la obtención de productos medicinales y farmacéuticos',1,1,'2021-02-22 00:23:35',NULL,NULL,NULL),(28,1291,'Cultivo de árboles de hule (caucho) para la obtención de látex',1,1,'2021-02-23 00:23:35',NULL,NULL,NULL),(29,1292,'Cultivo de plantas para la obtención de productos químicos y colorantes',1,1,'2021-02-24 00:23:35',NULL,NULL,NULL),(30,1299,'Producción de cultivos perennes ncp',1,1,'2021-02-25 00:23:35',NULL,NULL,NULL),(31,1300,'Propagación de plantas',1,1,'2021-02-26 00:23:35',NULL,NULL,NULL),(32,1301,'Cultivo de plantas y flores ornamentales',1,1,'2021-02-27 00:23:35',NULL,NULL,NULL),(33,1410,'Cría y engorde de ganado bovino',1,1,'2021-02-28 00:23:35',NULL,NULL,NULL),(34,1420,'Cría de caballos y otros equinos',1,1,'2021-03-01 00:23:35',NULL,NULL,NULL),(35,1440,'Cría de ovejas y cabras',1,1,'2021-03-02 00:23:35',NULL,NULL,NULL),(36,1450,'Cría de cerdos',1,1,'2021-03-03 00:23:35',NULL,NULL,NULL),(37,1460,'Cría de aves de corral y producción de huevos',1,1,'2021-03-04 00:23:35',NULL,NULL,NULL),(38,1491,'Cría de abejas apicultura para la obtención de miel y otros productos apícolas',1,1,'2021-03-05 00:23:35',NULL,NULL,NULL),(39,1492,'Cría de conejos',1,1,'2021-03-06 00:23:35',NULL,NULL,NULL),(40,1493,'Cría de iguanas y garrobos',1,1,'2021-03-07 00:23:35',NULL,NULL,NULL),(41,1494,'Cría de mariposas y otros insectos',1,1,'2021-03-08 00:23:35',NULL,NULL,NULL),(42,1499,'Cría y obtención de productos animales n.c.p.',1,1,'2021-03-09 00:23:35',NULL,NULL,NULL),(43,1500,'Cultivo de productos agrícolas en combinación con la cría de animales',1,1,'2021-03-10 00:23:35',NULL,NULL,NULL),(44,1611,'Servicios de maquinaria agrícola',1,1,'2021-03-11 00:23:35',NULL,NULL,NULL),(45,1612,'Control de plagas',1,1,'2021-03-12 00:23:35',NULL,NULL,NULL),(46,1613,'Servicios de riego',1,1,'2021-03-13 00:23:35',NULL,NULL,NULL),(47,1614,'Servicios de contratación de mano de obra para la agricultura',1,1,'2021-03-14 00:23:35',NULL,NULL,NULL),(48,1619,'Servicios agrícolas ncp',1,1,'2021-03-15 00:23:35',NULL,NULL,NULL),(49,1621,'Actividades para mejorar la reproducción, el crecimiento y el rendimiento de los animales y sus productos',1,1,'2021-03-16 00:23:35',NULL,NULL,NULL),(50,1622,'Servicios de mano de obra pecuaria',1,1,'2021-03-17 00:23:35',NULL,NULL,NULL),(51,1629,'Servicios pecuarios ncp',1,1,'2021-03-18 00:23:35',NULL,NULL,NULL),(52,1631,'Labores post cosecha de preparación de los productos agrícolas para su comercialización o para la industria',1,1,'2021-03-19 00:23:35',NULL,NULL,NULL),(53,1632,'Servicio de beneficio de café',1,1,'2021-03-20 00:23:35',NULL,NULL,NULL),(54,1633,'Servicio de beneficiado de plantas textiles (incluye el beneficiado cuando este es realizado en la misma explotación agropecuaria)',1,1,'2021-03-21 00:23:35',NULL,NULL,NULL),(55,1640,'Tratamiento de semillas para la propagación',1,1,'2021-03-22 00:23:35',NULL,NULL,NULL),(56,1700,'Caza ordinaria y mediante trampas, repoblación de animales de caza y servicios conexos',1,1,'2021-03-23 00:23:35',NULL,NULL,NULL),(57,2100,'Silvicultura y otras actividades forestales',1,1,'2021-03-24 00:23:35',NULL,NULL,NULL),(58,2200,'Extracción de madera',1,1,'2021-03-25 00:23:35',NULL,NULL,NULL),(59,2300,'Recolección de productos diferentes a la madera',1,1,'2021-03-26 00:23:35',NULL,NULL,NULL),(60,2400,'Servicios de apoyo a la silvicultura',1,1,'2021-03-27 00:23:35',NULL,NULL,NULL),(61,3110,'Pesca marítima de altura y costera',1,1,'2021-03-28 00:23:35',NULL,NULL,NULL),(62,3120,'Pesca de agua dulce',1,1,'2021-03-29 00:23:35',NULL,NULL,NULL),(63,3210,'Acuicultura marítima',1,1,'2021-03-30 00:23:35',NULL,NULL,NULL),(64,3220,'Acuicultura de agua dulce',1,1,'2021-03-31 00:23:35',NULL,NULL,NULL),(65,3300,'Servicios de apoyo a la pesca y acuicultura',1,1,'2021-04-01 00:23:35',NULL,NULL,NULL),(66,5100,'Extracción de hulla',1,1,'2021-04-02 00:23:35',NULL,NULL,NULL),(67,5200,'Extracción y aglomeración de lignito',1,1,'2021-04-03 00:23:35',NULL,NULL,NULL),(68,6100,'Extracción de petróleo crudo',1,1,'2021-04-04 00:23:35',NULL,NULL,NULL),(69,6200,'Extracción de gas natural',1,1,'2021-04-05 00:23:35',NULL,NULL,NULL),(70,7100,'Extracción de minerales  de hierro',1,1,'2021-04-06 00:23:35',NULL,NULL,NULL),(71,7210,'Extracción de minerales de uranio y torio',1,1,'2021-04-07 00:23:35',NULL,NULL,NULL),(72,7290,'Extracción de minerales metalíferos no ferrosos',1,1,'2021-04-08 00:23:35',NULL,NULL,NULL),(73,8100,'Extracción de piedra, arena y arcilla',1,1,'2021-04-09 00:23:35',NULL,NULL,NULL),(74,8910,'Extracción de minerales para la fabricación de abonos y productos químicos',1,1,'2021-04-10 00:23:35',NULL,NULL,NULL),(75,8920,'Extracción y aglomeración de turba',1,1,'2021-04-11 00:23:35',NULL,NULL,NULL),(76,8930,'Extracción de sal',1,1,'2021-04-12 00:23:35',NULL,NULL,NULL),(77,8990,'Explotación de otras minas y canteras ncp',1,1,'2021-04-13 00:23:35',NULL,NULL,NULL),(78,9100,'Actividades de apoyo a la extracción de petróleo y gas natural',1,1,'2021-04-14 00:23:35',NULL,NULL,NULL),(79,9900,'Actividades de apoyo a la explotación de minas y canteras',1,1,'2021-04-15 00:23:35',NULL,NULL,NULL),(80,10101,'Servicio de rastros y mataderos de bovinos y porcinos',1,1,'2021-04-16 00:23:35',NULL,NULL,NULL),(81,10102,'Matanza y procesamiento de bovinos y porcinos',1,1,'2021-04-17 00:23:35',NULL,NULL,NULL),(82,10103,'Matanza y procesamientos de aves de corral',1,1,'2021-04-18 00:23:35',NULL,NULL,NULL),(83,10104,'Elaboración y conservación de embutidos y tripas naturales',1,1,'2021-04-19 00:23:35',NULL,NULL,NULL),(84,10105,'Servicios de conservación y empaque de carnes',1,1,'2021-04-20 00:23:35',NULL,NULL,NULL),(85,10106,'Elaboración y conservación de grasas y aceites animales',1,1,'2021-04-21 00:23:35',NULL,NULL,NULL),(86,10107,'Servicios de molienda de carne',1,1,'2021-04-22 00:23:35',NULL,NULL,NULL),(87,10108,'Elaboración de productos de carne ncp',1,1,'2021-04-23 00:23:35',NULL,NULL,NULL),(88,10201,'Procesamiento y conservación de pescado, crustáceos y moluscos',1,1,'2021-04-24 00:23:35',NULL,NULL,NULL),(89,10209,'Fabricación de productos de pescado ncp',1,1,'2021-04-25 00:23:35',NULL,NULL,NULL),(90,10301,'Elaboración de jugos de frutas y hortalizas',1,1,'2021-04-26 00:23:35',NULL,NULL,NULL),(91,10302,'Elaboración y envase de jaleas, mermeladas y frutas deshidratadas',1,1,'2021-04-27 00:23:35',NULL,NULL,NULL),(92,10309,'Elaboración de productos de frutas y hortalizas n.c.p.',1,1,'2021-04-28 00:23:35',NULL,NULL,NULL),(93,10401,'Fabricación de aceites y grasas vegetales y animales comestibles',1,1,'2021-04-29 00:23:35',NULL,NULL,NULL),(94,10402,'Fabricación de aceites y grasas vegetales y animales no comestibles',1,1,'2021-04-30 00:23:35',NULL,NULL,NULL),(95,10409,'Servicio de maquilado de aceites',1,1,'2021-05-01 00:23:35',NULL,NULL,NULL),(96,10501,'Fabricación de productos lácteos excepto sorbetes y quesos sustitutos',1,1,'2021-05-02 00:23:35',NULL,NULL,NULL),(97,10502,'Fabricación de sorbetes y helados',1,1,'2021-05-03 00:23:35',NULL,NULL,NULL),(98,10503,'Fabricación de quesos',1,1,'2021-05-04 00:23:35',NULL,NULL,NULL),(99,10611,'Molienda de cereales',1,1,'2021-05-05 00:23:35',NULL,NULL,NULL),(100,10612,'Elaboración de cereales para el desayuno y similares',1,1,'2021-05-06 00:23:35',NULL,NULL,NULL),(101,10613,'Servicios de beneficiado de productos agrícolas ncp (excluye Beneficio de azúcar rama 1072  y beneficio de café rama 0163)',1,1,'2021-05-07 00:23:35',NULL,NULL,NULL),(102,10621,'Fabricación de almidón',1,1,'2021-05-08 00:23:35',NULL,NULL,NULL),(103,10628,'Servicio de molienda de maíz húmedo molino para nixtamal',1,1,'2021-05-09 00:23:35',NULL,NULL,NULL),(104,10711,'Elaboración de tortillas',1,1,'2021-05-10 00:23:35',NULL,NULL,NULL),(105,10712,'Fabricación de pan, galletas y barquillos',1,1,'2021-05-11 00:23:35',NULL,NULL,NULL),(106,10713,'Fabricación de repostería',1,1,'2021-05-12 00:23:35',NULL,NULL,NULL),(107,10721,'Ingenios azucareros',1,1,'2021-05-13 00:23:35',NULL,NULL,NULL),(108,10722,'Molienda de caña de azúcar para la elaboración de dulces',1,1,'2021-05-14 00:23:35',NULL,NULL,NULL),(109,10723,'Elaboración de jarabes de azúcar y otros similares',1,1,'2021-05-15 00:23:35',NULL,NULL,NULL),(110,10724,'Maquilado de azúcar de caña',1,1,'2021-05-16 00:23:35',NULL,NULL,NULL),(111,10730,'Fabricación de cacao, chocolates y  productos de confitería',1,1,'2021-05-17 00:23:35',NULL,NULL,NULL),(112,10740,'Elaboración de macarrones, fideos, y productos farináceos similares',1,1,'2021-05-18 00:23:35',NULL,NULL,NULL),(113,10750,'Elaboración de comidas y platos preparados para la reventa en locales y/o  para exportación',1,1,'2021-05-19 00:23:35',NULL,NULL,NULL),(114,10791,'Elaboración de productos de café',1,1,'2021-05-20 00:23:35',NULL,NULL,NULL),(115,10792,'Elaboración de especies, sazonadores y condimentos',1,1,'2021-05-21 00:23:35',NULL,NULL,NULL),(116,10793,'Elaboración de sopas, cremas y consomé',1,1,'2021-05-22 00:23:35',NULL,NULL,NULL),(117,10794,'Fabricación de bocadillos tostados y/o fritos',1,1,'2021-05-23 00:23:35',NULL,NULL,NULL),(118,10799,'Elaboración de productos alimenticios ncp',1,1,'2021-05-24 00:23:35',NULL,NULL,NULL),(119,10800,'Elaboración de alimentos preparados para animales',1,1,'2021-05-25 00:23:35',NULL,NULL,NULL),(120,11012,'Fabricación de aguardiente y licores',1,1,'2021-05-26 00:23:35',NULL,NULL,NULL),(121,11020,'Elaboración de vinos',1,1,'2021-05-27 00:23:35',NULL,NULL,NULL),(122,11030,'Fabricación de cerveza',1,1,'2021-05-28 00:23:35',NULL,NULL,NULL),(123,11041,'Fabricación de aguas gaseosas',1,1,'2021-05-29 00:23:35',NULL,NULL,NULL),(124,11042,'Fabricación y envasado  de agua',1,1,'2021-05-30 00:23:35',NULL,NULL,NULL),(125,11043,'Elaboración de refrescos',1,1,'2021-05-31 00:23:35',NULL,NULL,NULL),(126,11048,'Maquilado de aguas gaseosas',1,1,'2021-06-01 00:23:35',NULL,NULL,NULL),(127,11049,'Elaboración de bebidas no alcohólicas',1,1,'2021-06-02 00:23:35',NULL,NULL,NULL),(128,12000,'Elaboración de productos de tabaco',1,1,'2021-06-03 00:23:35',NULL,NULL,NULL),(129,13111,'Preparación de fibras textiles',1,1,'2021-06-04 00:23:35',NULL,NULL,NULL),(130,13112,'Fabricación de hilados',1,1,'2021-06-05 00:23:35',NULL,NULL,NULL),(131,13120,'Fabricación de telas',1,1,'2021-06-06 00:23:35',NULL,NULL,NULL),(132,13130,'Acabado de productos textiles',1,1,'2021-06-07 00:23:35',NULL,NULL,NULL),(133,13910,'Fabricación de tejidos de punto y  ganchillo',1,1,'2021-06-08 00:23:35',NULL,NULL,NULL),(134,13921,'Fabricación de productos textiles para el hogar',1,1,'2021-06-09 00:23:35',NULL,NULL,NULL),(135,13922,'Sacos, bolsas y otros artículos textiles',1,1,'2021-06-10 00:23:35',NULL,NULL,NULL),(136,13929,'Fabricación de artículos confeccionados con materiales textiles, excepto prendas de vestir n.c.p',1,1,'2021-06-11 00:23:35',NULL,NULL,NULL),(137,13930,'Fabricación de tapices y alfombras',1,1,'2021-06-12 00:23:35',NULL,NULL,NULL),(138,13941,'Fabricación de cuerdas de henequén y otras fibras naturales (lazos, pitas)',1,1,'2021-06-13 00:23:35',NULL,NULL,NULL),(139,13942,'Fabricación de redes de diversos materiales',1,1,'2021-06-14 00:23:35',NULL,NULL,NULL),(140,13948,'Maquilado de productos trenzables de cualquier material (petates, sillas, etc.)',1,1,'2021-06-15 00:23:35',NULL,NULL,NULL),(141,13991,'Fabricación de adornos, etiquetas y otros artículos para prendas de vestir',1,1,'2021-06-16 00:23:35',NULL,NULL,NULL),(142,13992,'Servicio de bordados en artículos y prendas de tela',1,1,'2021-06-17 00:23:35',NULL,NULL,NULL),(143,13999,'Fabricación de productos textiles ncp',1,1,'2021-06-18 00:23:35',NULL,NULL,NULL),(144,14101,'Fabricación de ropa  interior, para dormir y similares',1,1,'2021-06-19 00:23:35',NULL,NULL,NULL),(145,14102,'Fabricación de ropa para niños',1,1,'2021-06-20 00:23:35',NULL,NULL,NULL),(146,14103,'Fabricación de prendas de vestir para ambos sexos',1,1,'2021-06-21 00:23:35',NULL,NULL,NULL),(147,14104,'Confección de prendas a medida',1,1,'2021-06-22 00:23:35',NULL,NULL,NULL),(148,14105,'Fabricación de prendas de vestir para deportes',1,1,'2021-06-23 00:23:35',NULL,NULL,NULL),(149,14106,'Elaboración de artesanías de uso personal confeccionadas especialmente de materiales textiles',1,1,'2021-06-24 00:23:35',NULL,NULL,NULL),(150,14108,'Maquilado  de prendas de vestir, accesorios y otros',1,1,'2021-06-25 00:23:35',NULL,NULL,NULL),(151,14109,'Fabricación de prendas y accesorios de vestir n.c.p.',1,1,'2021-06-26 00:23:35',NULL,NULL,NULL),(152,14200,'Fabricación de artículos de piel',1,1,'2021-06-27 00:23:35',NULL,NULL,NULL),(153,14301,'Fabricación de calcetines, calcetas, medias (panty house) y otros similares',1,1,'2021-06-28 00:23:35',NULL,NULL,NULL),(154,14302,'Fabricación de ropa interior de tejido de punto',1,1,'2021-06-29 00:23:35',NULL,NULL,NULL),(155,14309,'Fabricación de prendas de vestir de tejido de punto ncp',1,1,'2021-06-30 00:23:35',NULL,NULL,NULL),(156,15110,'Curtido y adobo de cueros; adobo y teñido de pieles',1,1,'2021-07-01 00:23:35',NULL,NULL,NULL),(157,15121,'Fabricación de maletas, bolsos de mano y otros artículos de marroquinería',1,1,'2021-07-02 00:23:35',NULL,NULL,NULL),(158,15122,'Fabricación de monturas, accesorios y vainas talabartería',1,1,'2021-07-03 00:23:35',NULL,NULL,NULL),(159,15123,'Fabricación de artesanías principalmente de cuero natural y sintético',1,1,'2021-07-04 00:23:35',NULL,NULL,NULL),(160,15128,'Maquilado de artículos de cuero natural, sintético y de otros materiales',1,1,'2021-07-05 00:23:35',NULL,NULL,NULL),(161,15201,'Fabricación de calzado',1,1,'2021-07-06 00:23:35',NULL,NULL,NULL),(162,15202,'Fabricación de partes y accesorios de calzado',1,1,'2021-07-07 00:23:35',NULL,NULL,NULL),(163,15208,'Maquilado de calzado y partes de calzado',1,1,'2021-07-08 00:23:35',NULL,NULL,NULL),(164,16100,'Aserradero y acepilladura de madera',1,1,'2021-07-09 00:23:35',NULL,NULL,NULL),(165,16210,'Fabricación de madera laminada, terciada, enchapada y contrachapada, paneles para la construcción',1,1,'2021-07-10 00:23:35',NULL,NULL,NULL),(166,16220,'Fabricación de partes y piezas de carpintería para edificios y construcciones',1,1,'2021-07-11 00:23:35',NULL,NULL,NULL),(167,16230,'Fabricación de envases y recipientes de madera',1,1,'2021-07-12 00:23:35',NULL,NULL,NULL),(168,16292,'Fabricación de artesanías de madera, semillas,  materiales trenzables',1,1,'2021-07-13 00:23:35',NULL,NULL,NULL),(169,16299,'Fabricación de productos de madera, corcho, paja y materiales trenzables ncp',1,1,'2021-07-14 00:23:35',NULL,NULL,NULL),(170,17010,'Fabricación de pasta de madera, papel y cartón',1,1,'2021-07-15 00:23:35',NULL,NULL,NULL),(171,17020,'Fabricación de papel y cartón ondulado y envases de papel y cartón',1,1,'2021-07-16 00:23:35',NULL,NULL,NULL),(172,17091,'Fabricación de artículos de papel y cartón de uso personal y doméstico',1,1,'2021-07-17 00:23:35',NULL,NULL,NULL),(173,17092,'Fabricación de productos de papel ncp',1,1,'2021-07-18 00:23:35',NULL,NULL,NULL),(174,18110,'Impresión',1,1,'2021-07-19 00:23:35',NULL,NULL,NULL),(175,18120,'Servicios relacionados con la impresión',1,1,'2021-07-20 00:23:35',NULL,NULL,NULL),(176,18200,'Reproducción de grabaciones',1,1,'2021-07-21 00:23:35',NULL,NULL,NULL),(177,19100,'Fabricación de productos de hornos de coque',1,1,'2021-07-22 00:23:35',NULL,NULL,NULL),(178,19201,'Fabricación de combustible',1,1,'2021-07-23 00:23:35',NULL,NULL,NULL),(179,19202,'Fabricación de aceites y lubricantes',1,1,'2021-07-24 00:23:35',NULL,NULL,NULL),(180,20111,'Fabricación de materias primas para la fabricación de colorantes',1,1,'2021-07-25 00:23:35',NULL,NULL,NULL),(181,20112,'Fabricación de materiales curtientes',1,1,'2021-07-26 00:23:35',NULL,NULL,NULL),(182,20113,'Fabricación de gases industriales',1,1,'2021-07-27 00:23:35',NULL,NULL,NULL),(183,20114,'Fabricación de alcohol etílico',1,1,'2021-07-28 00:23:35',NULL,NULL,NULL),(184,20119,'Fabricación de sustancias químicas básicas',1,1,'2021-07-29 00:23:35',NULL,NULL,NULL),(185,20120,'Fabricación de abonos y fertilizantes',1,1,'2021-07-30 00:23:35',NULL,NULL,NULL),(186,20130,'Fabricación de plástico y caucho en formas primarias',1,1,'2021-07-31 00:23:35',NULL,NULL,NULL),(187,20210,'Fabricación de plaguicidas y otros productos químicos de uso agropecuario',1,1,'2021-08-01 00:23:35',NULL,NULL,NULL),(188,20220,'Fabricación de pinturas, barnices y productos de revestimiento similares; tintas de imprenta y masillas',1,1,'2021-08-02 00:23:35',NULL,NULL,NULL),(189,20231,'Fabricación de jabones, detergentes y similares para limpieza',1,1,'2021-08-03 00:23:35',NULL,NULL,NULL),(190,20232,'Fabricación de perfumes, cosméticos y productos de higiene y cuidado personal, incluyendo tintes, champú, etc.',1,1,'2021-08-04 00:23:35',NULL,NULL,NULL),(191,20291,'Fabricación de tintas y colores para escribir y pintar; fabricación de cintas para impresoras',1,1,'2021-08-05 00:23:35',NULL,NULL,NULL),(192,20292,'Fabricación de productos pirotécnicos, explosivos y municiones',1,1,'2021-08-06 00:23:35',NULL,NULL,NULL),(193,20299,'Fabricación de productos químicos n.c.p.',1,1,'2021-08-07 00:23:35',NULL,NULL,NULL),(194,20300,'Fabricación de fibras artificiales',1,1,'2021-08-08 00:23:35',NULL,NULL,NULL),(195,21001,'Manufactura de productos farmacéuticos, sustancias químicas y productos botánicos',1,1,'2021-08-09 00:23:35',NULL,NULL,NULL),(196,21008,'Maquilado de medicamentos',1,1,'2021-08-10 00:23:35',NULL,NULL,NULL),(197,22110,'Fabricación de cubiertas y cámaras; renovación y recauchutado de cubiertas',1,1,'2021-08-11 00:23:35',NULL,NULL,NULL),(198,22190,'Fabricación de otros productos de caucho',1,1,'2021-08-12 00:23:35',NULL,NULL,NULL),(199,22201,'Fabricación de envases plásticos',1,1,'2021-08-13 00:23:35',NULL,NULL,NULL),(200,22202,'Fabricación de productos plásticos para uso personal o doméstico',1,1,'2021-08-14 00:23:35',NULL,NULL,NULL),(201,22208,'Maquila de plásticos',1,1,'2021-08-15 00:23:35',NULL,NULL,NULL),(202,22209,'Fabricación de productos plásticos n.c.p.',1,1,'2021-08-16 00:23:35',NULL,NULL,NULL),(203,23101,'Fabricación de vidrio',1,1,'2021-08-17 00:23:35',NULL,NULL,NULL),(204,23102,'Fabricación de recipientes y envases de vidrio',1,1,'2021-08-18 00:23:35',NULL,NULL,NULL),(205,23108,'Servicio de maquilado',1,1,'2021-08-19 00:23:35',NULL,NULL,NULL),(206,23109,'Fabricación de productos de vidrio ncp',1,1,'2021-08-20 00:23:35',NULL,NULL,NULL),(207,23910,'Fabricación de productos refractarios',1,1,'2021-08-21 00:23:35',NULL,NULL,NULL),(208,23920,'Fabricación de productos de arcilla para la construcción',1,1,'2021-08-22 00:23:35',NULL,NULL,NULL),(209,23931,'Fabricación de productos de cerámica y porcelana no refractaria',1,1,'2021-08-23 00:23:35',NULL,NULL,NULL),(210,23932,'Fabricación de productos de cerámica y porcelana ncp',1,1,'2021-08-24 00:23:35',NULL,NULL,NULL),(211,23940,'Fabricación de cemento, cal y yeso',1,1,'2021-08-25 00:23:35',NULL,NULL,NULL),(212,23950,'Fabricación de artículos de hormigón, cemento y yeso',1,1,'2021-08-26 00:23:35',NULL,NULL,NULL),(213,23960,'Corte, tallado y acabado de la piedra',1,1,'2021-08-27 00:23:35',NULL,NULL,NULL),(214,23990,'Fabricación de productos minerales no metálicos ncp',1,1,'2021-08-28 00:23:35',NULL,NULL,NULL),(215,24100,'Industrias básicas de hierro y acero',1,1,'2021-08-29 00:23:35',NULL,NULL,NULL),(216,24200,'Fabricación de productos primarios de metales preciosos y metales no ferrosos',1,1,'2021-08-30 00:23:35',NULL,NULL,NULL),(217,24310,'Fundición de hierro y acero',1,1,'2021-08-31 00:23:35',NULL,NULL,NULL),(218,24320,'Fundición de metales no ferrosos',1,1,'2021-09-01 00:23:35',NULL,NULL,NULL),(219,25111,'Fabricación de productos metálicos para uso estructural',1,1,'2021-09-02 00:23:35',NULL,NULL,NULL),(220,25118,'Servicio de maquila para la fabricación de estructuras metálicas',1,1,'2021-09-03 00:23:35',NULL,NULL,NULL),(221,25120,'Fabricación de tanques, depósitos y recipientes de metal',1,1,'2021-09-04 00:23:35',NULL,NULL,NULL),(222,25130,'Fabricación de generadores de vapor, excepto calderas de agua caliente  para calefacción central',1,1,'2021-09-05 00:23:35',NULL,NULL,NULL),(223,25200,'Fabricación de armas y municiones',1,1,'2021-09-06 00:23:35',NULL,NULL,NULL),(224,25910,'Forjado, prensado, estampado y laminado de metales; pulvimetalurgia',1,1,'2021-09-07 00:23:35',NULL,NULL,NULL),(225,25920,'Tratamiento y revestimiento de metales',1,1,'2021-09-08 00:23:35',NULL,NULL,NULL),(226,25930,'Fabricación de artículos de cuchillería, herramientas de mano y artículos de ferretería',1,1,'2021-09-09 00:23:35',NULL,NULL,NULL),(227,25991,'Fabricación de envases y artículos conexos de metal',1,1,'2021-09-10 00:23:35',NULL,NULL,NULL),(228,25992,'Fabricación de artículos metálicos de uso personal y/o doméstico',1,1,'2021-09-11 00:23:35',NULL,NULL,NULL),(229,25999,'Fabricación de productos elaborados de metal ncp',1,1,'2021-09-12 00:23:35',NULL,NULL,NULL),(230,26100,'Fabricación de componentes electrónicos',1,1,'2021-09-13 00:23:35',NULL,NULL,NULL),(231,26200,'Fabricación de computadoras y equipo conexo',1,1,'2021-09-14 00:23:35',NULL,NULL,NULL),(232,26300,'Fabricación de equipo de comunicaciones',1,1,'2021-09-15 00:23:35',NULL,NULL,NULL),(233,26400,'Fabricación de aparatos  electrónicos de consumo para audio, video radio y televisión',1,1,'2021-09-16 00:23:35',NULL,NULL,NULL),(234,26510,'Fabricación de instrumentos y aparatos para medir, verificar, ensayar, navegar y de control de procesos industriales',1,1,'2021-09-17 00:23:35',NULL,NULL,NULL),(235,26520,'Fabricación de relojes y piezas de relojes',1,1,'2021-09-18 00:23:35',NULL,NULL,NULL),(236,26600,'Fabricación de equipo médico de irradiación y equipo electrónico de uso médico y terapéutico',1,1,'2021-09-19 00:23:35',NULL,NULL,NULL),(237,26700,'Fabricación de instrumentos de óptica y equipo fotográfico',1,1,'2021-09-20 00:23:35',NULL,NULL,NULL),(238,26800,'Fabricación de medios magnéticos y ópticos',1,1,'2021-09-21 00:23:35',NULL,NULL,NULL),(239,27100,'Fabricación de motores, generadores , transformadores eléctricos, aparatos de distribución y control de electricidad',1,1,'2021-09-22 00:23:35',NULL,NULL,NULL),(240,27200,'Fabricación de pilas, baterías y acumuladores',1,1,'2021-09-23 00:23:35',NULL,NULL,NULL),(241,27310,'Fabricación de cables de fibra óptica',1,1,'2021-09-24 00:23:35',NULL,NULL,NULL),(242,27320,'Fabricación de otros  hilos y cables eléctricos',1,1,'2021-09-25 00:23:35',NULL,NULL,NULL),(243,27330,'Fabricación de dispositivos de cableados',1,1,'2021-09-26 00:23:35',NULL,NULL,NULL),(244,27400,'Fabricación de equipo eléctrico de iluminación',1,1,'2021-09-27 00:23:35',NULL,NULL,NULL),(245,27500,'Fabricación de aparatos de uso doméstico',1,1,'2021-09-28 00:23:35',NULL,NULL,NULL),(246,27900,'Fabricación de otros tipos de equipo eléctrico',1,1,'2021-09-29 00:23:35',NULL,NULL,NULL),(247,28110,'Fabricación de motores y turbinas, excepto motores para aeronaves, vehículos automotores y motocicletas',1,1,'2021-09-30 00:23:35',NULL,NULL,NULL),(248,28120,'Fabricación de equipo hidráulico',1,1,'2021-10-01 00:23:35',NULL,NULL,NULL),(249,28130,'Fabricación de otras bombas, compresores, grifos y válvulas',1,1,'2021-10-02 00:23:35',NULL,NULL,NULL),(250,28140,'Fabricación de cojinetes, engranajes, trenes de engranajes y piezas de transmisión',1,1,'2021-10-03 00:23:35',NULL,NULL,NULL),(251,28150,'Fabricación de hornos y quemadores',1,1,'2021-10-04 00:23:35',NULL,NULL,NULL),(252,28160,'Fabricación de equipo de elevación y manipulación',1,1,'2021-10-05 00:23:35',NULL,NULL,NULL),(253,28170,'Fabricación de maquinaria y equipo de oficina',1,1,'2021-10-06 00:23:35',NULL,NULL,NULL),(254,28180,'Fabricación de herramientas manuales',1,1,'2021-10-07 00:23:35',NULL,NULL,NULL),(255,28190,'Fabricación de otros tipos de maquinaria de uso general',1,1,'2021-10-08 00:23:35',NULL,NULL,NULL),(256,28210,'Fabricación de maquinaria agropecuaria y forestal',1,1,'2021-10-09 00:23:35',NULL,NULL,NULL),(257,28220,'Fabricación de máquinas para conformar metales y maquinaria herramienta',1,1,'2021-10-10 00:23:35',NULL,NULL,NULL),(258,28230,'Fabricación de maquinaria metalúrgica',1,1,'2021-10-11 00:23:35',NULL,NULL,NULL),(259,28240,'Fabricación de maquinaria para la explotación de minas y canteras y para obras de construcción',1,1,'2021-10-12 00:23:35',NULL,NULL,NULL),(260,28250,'Fabricación de maquinaria para la elaboración de alimentos, bebidas y tabaco',1,1,'2021-10-13 00:23:35',NULL,NULL,NULL),(261,28260,'Fabricación de maquinaria para la elaboración de productos textiles, prendas de vestir y cueros',1,1,'2021-10-14 00:23:35',NULL,NULL,NULL),(262,28291,'Fabricación de máquinas para imprenta',1,1,'2021-10-15 00:23:35',NULL,NULL,NULL),(263,28299,'Fabricación de maquinaria de uso especial ncp',1,1,'2021-10-16 00:23:35',NULL,NULL,NULL),(264,29100,'Fabricación vehículos automotores',1,1,'2021-10-17 00:23:35',NULL,NULL,NULL),(265,29200,'Fabricación de carrocerías para vehículos automotores; fabricación de remolques y semiremolques',1,1,'2021-10-18 00:23:35',NULL,NULL,NULL),(266,29300,'Fabricación de partes, piezas y accesorios para vehículos automotores',1,1,'2021-10-19 00:23:35',NULL,NULL,NULL),(267,30110,'Fabricación de buques',1,1,'2021-10-20 00:23:35',NULL,NULL,NULL),(268,30120,'Construcción y reparación de embarcaciones de recreo',1,1,'2021-10-21 00:23:35',NULL,NULL,NULL),(269,30200,'Fabricación de locomotoras y de material rodante',1,1,'2021-10-22 00:23:35',NULL,NULL,NULL),(270,30300,'Fabricación de aeronaves y naves espaciales',1,1,'2021-10-23 00:23:35',NULL,NULL,NULL),(271,30400,'Fabricación de vehículos militares de combate',1,1,'2021-10-24 00:23:35',NULL,NULL,NULL),(272,30910,'Fabricación de motocicletas',1,1,'2021-10-25 00:23:35',NULL,NULL,NULL),(273,30920,'Fabricación de bicicletas y sillones de ruedas para inválidos',1,1,'2021-10-26 00:23:35',NULL,NULL,NULL),(274,30990,'Fabricación de equipo de transporte ncp',1,1,'2021-10-27 00:23:35',NULL,NULL,NULL),(275,31001,'Fabricación de colchones y somier',1,1,'2021-10-28 00:23:35',NULL,NULL,NULL),(276,31002,'Fabricación de muebles y otros productos de madera a medida',1,1,'2021-10-29 00:23:35',NULL,NULL,NULL),(277,31008,'Servicios de maquilado de muebles',1,1,'2021-10-30 00:23:35',NULL,NULL,NULL),(278,31009,'Fabricación de muebles ncp',1,1,'2021-10-31 00:23:35',NULL,NULL,NULL),(279,32110,'Fabricación de joyas platerías y joyerías',1,1,'2021-11-01 00:23:35',NULL,NULL,NULL),(280,32120,'Fabricación de joyas de imitación (fantasía) y artículos conexos',1,1,'2021-11-02 00:23:35',NULL,NULL,NULL),(281,32200,'Fabricación de instrumentos musicales',1,1,'2021-11-03 00:23:35',NULL,NULL,NULL),(282,32301,'Fabricación de artículos de deporte',1,1,'2021-11-04 00:23:35',NULL,NULL,NULL),(283,32308,'Servicio de maquila de productos deportivos',1,1,'2021-11-05 00:23:35',NULL,NULL,NULL),(284,32401,'Fabricación de juegos de mesa y de salón',1,1,'2021-11-06 00:23:35',NULL,NULL,NULL),(285,32402,'Servicio de maquilado de juguetes y juegos',1,1,'2021-11-07 00:23:35',NULL,NULL,NULL),(286,32409,'Fabricación de juegos y juguetes n.c.p.',1,1,'2021-11-08 00:23:35',NULL,NULL,NULL),(287,32500,'Fabricación de instrumentos y materiales médicos y odontológicos',1,1,'2021-11-09 00:23:35',NULL,NULL,NULL),(288,32901,'Fabricación de lápices, bolígrafos, sellos y artículos de librería en general',1,1,'2021-11-10 00:23:35',NULL,NULL,NULL),(289,32902,'Fabricación de escobas, cepillos, pinceles y similares',1,1,'2021-11-11 00:23:35',NULL,NULL,NULL),(290,32903,'Fabricación de artesanías de materiales diversos',1,1,'2021-11-12 00:23:35',NULL,NULL,NULL),(291,32904,'Fabricación de artículos de uso personal y domésticos n.c.p.',1,1,'2021-11-13 00:23:35',NULL,NULL,NULL),(292,32905,'Fabricación de accesorios para las confecciones y la marroquinería n.c.p.',1,1,'2021-11-14 00:23:35',NULL,NULL,NULL),(293,32908,'Servicios de maquila ncp',1,1,'2021-11-15 00:23:35',NULL,NULL,NULL),(294,32909,'Fabricación de productos manufacturados n.c.p.',1,1,'2021-11-16 00:23:35',NULL,NULL,NULL),(295,33110,'Reparación y mantenimiento de productos elaborados de metal',1,1,'2021-11-17 00:23:35',NULL,NULL,NULL),(296,33120,'Reparación y mantenimiento de maquinaria',1,1,'2021-11-18 00:23:35',NULL,NULL,NULL),(297,33130,'Reparación y mantenimiento de equipo electrónico y óptico',1,1,'2021-11-19 00:23:35',NULL,NULL,NULL),(298,33140,'Reparación y mantenimiento  de equipo eléctrico',1,1,'2021-11-20 00:23:35',NULL,NULL,NULL),(299,33150,'Reparación y mantenimiento de equipo de transporte, excepto vehículos automotores',1,1,'2021-11-21 00:23:35',NULL,NULL,NULL),(300,33190,'Reparación y mantenimiento de equipos n.c.p.',1,1,'2021-11-22 00:23:35',NULL,NULL,NULL),(301,33200,'Instalación de maquinaria y equipo industrial',1,1,'2021-11-23 00:23:35',NULL,NULL,NULL),(302,35101,'Generación de energía eléctrica',1,1,'2021-11-24 00:23:35',NULL,NULL,NULL),(303,35102,'Transmisión de energía eléctrica',1,1,'2021-11-25 00:23:35',NULL,NULL,NULL),(304,35103,'Distribución de energía eléctrica',1,1,'2021-11-26 00:23:35',NULL,NULL,NULL),(305,35200,'Fabricación de gas, distribución de combustibles gaseosos por tuberías',1,1,'2021-11-27 00:23:35',NULL,NULL,NULL),(306,35300,'Suministro de vapor y agua caliente',1,1,'2021-11-28 00:23:35',NULL,NULL,NULL),(307,36000,'Captación, tratamiento y suministro de agua',1,1,'2021-11-29 00:23:35',NULL,NULL,NULL),(308,37000,'Evacuación de aguas residuales (alcantarillado)',1,1,'2021-11-30 00:23:35',NULL,NULL,NULL),(309,38110,'Recolección y transporte de desechos sólidos proveniente de hogares y  sector urbano',1,1,'2021-12-01 00:23:35',NULL,NULL,NULL),(310,38120,'Recolección de desechos peligrosos',1,1,'2021-12-02 00:23:35',NULL,NULL,NULL),(311,38210,'Tratamiento y eliminación de desechos inicuos',1,1,'2021-12-03 00:23:35',NULL,NULL,NULL),(312,38220,'Tratamiento y eliminación de desechos peligrosos',1,1,'2021-12-04 00:23:35',NULL,NULL,NULL),(313,38301,'Reciclaje de desperdicios y desechos textiles',1,1,'2021-12-05 00:23:35',NULL,NULL,NULL),(314,38302,'Reciclaje de desperdicios y desechos de plástico y caucho',1,1,'2021-12-06 00:23:35',NULL,NULL,NULL),(315,38303,'Reciclaje de desperdicios y desechos de vidrio',1,1,'2021-12-07 00:23:35',NULL,NULL,NULL),(316,38304,'Reciclaje de desperdicios y desechos de papel y cartón',1,1,'2021-12-08 00:23:35',NULL,NULL,NULL),(317,38305,'Reciclaje de desperdicios y desechos metálicos',1,1,'2021-12-09 00:23:35',NULL,NULL,NULL),(318,38309,'Reciclaje de desperdicios y desechos no metálicos  n.c.p.',1,1,'2021-12-10 00:23:35',NULL,NULL,NULL),(319,39000,'Actividades de Saneamiento y otros Servicios de Gestión de Desechos',1,1,'2021-12-11 00:23:35',NULL,NULL,NULL),(320,41001,'Construcción de edificios residenciales',1,1,'2021-12-12 00:23:35',NULL,NULL,NULL),(321,41002,'Construcción de edificios no residenciales',1,1,'2021-12-13 00:23:35',NULL,NULL,NULL),(322,42100,'Construcción de carreteras, calles y caminos',1,1,'2021-12-14 00:23:35',NULL,NULL,NULL),(323,42200,'Construcción de proyectos de servicio público',1,1,'2021-12-15 00:23:35',NULL,NULL,NULL),(324,42900,'Construcción de obras de ingeniería civil n.c.p.',1,1,'2021-12-16 00:23:35',NULL,NULL,NULL),(325,43110,'Demolición',1,1,'2021-12-17 00:23:35',NULL,NULL,NULL),(326,43120,'Preparación de terreno',1,1,'2021-12-18 00:23:35',NULL,NULL,NULL),(327,43210,'Instalaciones eléctricas',1,1,'2021-12-19 00:23:35',NULL,NULL,NULL),(328,43220,'Instalación de fontanería, calefacción y aire acondicionado',1,1,'2021-12-20 00:23:35',NULL,NULL,NULL),(329,43290,'Otras instalaciones para obras de construcción',1,1,'2021-12-21 00:23:35',NULL,NULL,NULL),(330,43300,'Terminación y acabado de edificios',1,1,'2021-12-22 00:23:35',NULL,NULL,NULL),(331,43900,'Otras actividades especializadas de construcción',1,1,'2021-12-23 00:23:35',NULL,NULL,NULL),(332,43901,'Fabricación de techos y materiales diversos',1,1,'2021-12-24 00:23:35',NULL,NULL,NULL),(333,45100,'Venta de vehículos automotores',1,1,'2021-12-25 00:23:35',NULL,NULL,NULL),(334,45201,'Reparación mecánica de vehículos automotores',1,1,'2021-12-26 00:23:35',NULL,NULL,NULL),(335,45202,'Reparaciones eléctricas del automotor y recarga de baterías',1,1,'2021-12-27 00:23:35',NULL,NULL,NULL),(336,45203,'Enderezado y pintura de vehículos automotores',1,1,'2021-12-28 00:23:35',NULL,NULL,NULL),(337,45204,'Reparaciones de radiadores, escapes y silenciadores',1,1,'2021-12-29 00:23:35',NULL,NULL,NULL),(338,45205,'Reparación y reconstrucción de vías, stop y otros artículos de fibra de vidrio',1,1,'2021-12-30 00:23:35',NULL,NULL,NULL),(339,45206,'Reparación de llantas de vehículos automotores',1,1,'2021-12-31 00:23:35',NULL,NULL,NULL),(340,45207,'Polarizado de vehículos (mediante la adhesión de papel especial a los vidrios)',1,1,'2022-01-01 00:23:35',NULL,NULL,NULL),(341,45208,'Lavado y pasteado de vehículos (carwash)',1,1,'2022-01-02 00:23:35',NULL,NULL,NULL),(342,45209,'Reparaciones de vehículos n.c.p.',1,1,'2022-01-03 00:23:35',NULL,NULL,NULL),(343,45211,'Remolque de vehículos automotores',1,1,'2022-01-04 00:23:35',NULL,NULL,NULL),(344,45301,'Venta de partes, piezas y accesorios nuevos para vehículos automotores',1,1,'2022-01-05 00:23:35',NULL,NULL,NULL),(345,45302,'Venta de partes, piezas y accesorios usados para vehículos automotores',1,1,'2022-01-06 00:23:35',NULL,NULL,NULL),(346,45401,'Venta de motocicletas',1,1,'2022-01-07 00:23:35',NULL,NULL,NULL),(347,45402,'Venta de repuestos, piezas y accesorios de motocicletas',1,1,'2022-01-08 00:23:35',NULL,NULL,NULL),(348,45403,'Mantenimiento y reparación  de motocicletas',1,1,'2022-01-09 00:23:35',NULL,NULL,NULL),(349,46100,'Venta al por mayor a cambio de retribución o por contrata',1,1,'2022-01-10 00:23:35',NULL,NULL,NULL),(350,46201,'Venta al por mayor de materias primas agrícolas',1,1,'2022-01-11 00:23:35',NULL,NULL,NULL),(351,46202,'Venta al por mayor de productos de la silvicultura',1,1,'2022-01-12 00:23:35',NULL,NULL,NULL),(352,46203,'Venta al por mayor de productos pecuarios y de granja',1,1,'2022-01-13 00:23:35',NULL,NULL,NULL),(353,46211,'Venta de productos para uso agropecuario',1,1,'2022-01-14 00:23:35',NULL,NULL,NULL),(354,46291,'Venta al por mayor de granos básicos (cereales, leguminosas)',1,1,'2022-01-15 00:23:35',NULL,NULL,NULL),(355,46292,'Venta  al por mayor de semillas mejoradas para cultivo',1,1,'2022-01-16 00:23:35',NULL,NULL,NULL),(356,46293,'Venta  al por mayor de café oro y uva',1,1,'2022-01-17 00:23:35',NULL,NULL,NULL),(357,46294,'Venta  al por mayor de caña de azúcar',1,1,'2022-01-18 00:23:35',NULL,NULL,NULL),(358,46295,'Venta al por mayor de flores, plantas  y otros productos naturales',1,1,'2022-01-19 00:23:35',NULL,NULL,NULL),(359,46296,'Venta al por mayor de productos agrícolas',1,1,'2022-01-20 00:23:35',NULL,NULL,NULL),(360,46297,'Venta  al por mayor de ganado bovino (vivo)',1,1,'2022-01-21 00:23:35',NULL,NULL,NULL),(361,46298,'Venta al por mayor de animales porcinos, ovinos, caprino, canículas, apícolas, avícolas vivos',1,1,'2022-01-22 00:23:35',NULL,NULL,NULL),(362,46299,'Venta de otras especies vivas del reino animal',1,1,'2022-01-23 00:23:35',NULL,NULL,NULL),(363,46301,'Venta al por mayor de alimentos',1,1,'2022-01-24 00:23:35',NULL,NULL,NULL),(364,46302,'Venta al por mayor de bebidas',1,1,'2022-01-25 00:23:35',NULL,NULL,NULL),(365,46303,'Venta al por mayor de tabaco',1,1,'2022-01-26 00:23:35',NULL,NULL,NULL),(366,46371,'Venta al por mayor de frutas, hortalizas (verduras), legumbres y tubérculos',1,1,'2022-01-27 00:23:35',NULL,NULL,NULL),(367,46372,'Venta al por mayor de pollos, gallinas destazadas, pavos y otras aves',1,1,'2022-01-28 00:23:35',NULL,NULL,NULL),(368,46373,'Venta al por mayor de carne bovina y porcina, productos de carne y embutidos',1,1,'2022-01-29 00:23:35',NULL,NULL,NULL),(369,46374,'Venta  al por mayor de huevos',1,1,'2022-01-30 00:23:35',NULL,NULL,NULL),(370,46375,'Venta al por mayor de productos lácteos',1,1,'2022-01-31 00:23:35',NULL,NULL,NULL),(371,46376,'Venta al por mayor de productos farináceos de panadería (pan dulce, cakes, respostería, etc.)',1,1,'2022-02-01 00:23:35',NULL,NULL,NULL),(372,46377,'Venta al por mayor de pastas alimenticas, aceites y grasas comestibles vegetal y animal',1,1,'2022-02-02 00:23:35',NULL,NULL,NULL),(373,46378,'Venta al por mayor de sal comestible',1,1,'2022-02-03 00:23:35',NULL,NULL,NULL),(374,46379,'Venta al por mayor de azúcar',1,1,'2022-02-04 00:23:35',NULL,NULL,NULL),(375,46391,'Venta al por mayor de abarrotes (vinos, licores, productos alimenticios envasados, etc.)',1,1,'2022-02-05 00:23:35',NULL,NULL,NULL),(376,46392,'Venta al por mayor de aguas gaseosas',1,1,'2022-02-06 00:23:35',NULL,NULL,NULL),(377,46393,'Venta al por mayor de agua purificada',1,1,'2022-02-07 00:23:35',NULL,NULL,NULL),(378,46394,'Venta al por mayor de refrescos y otras bebidas, líquidas o en polvo',1,1,'2022-02-08 00:23:35',NULL,NULL,NULL),(379,46395,'Venta al por mayor de cerveza y licores',1,1,'2022-02-09 00:23:35',NULL,NULL,NULL),(380,46396,'Venta al por mayor de hielo',1,1,'2022-02-10 00:23:35',NULL,NULL,NULL),(381,46411,'Venta al por mayor de hilados, tejidos y productos textiles de mercería',1,1,'2022-02-11 00:23:35',NULL,NULL,NULL),(382,46412,'Venta al por mayor de artículos textiles excepto confecciones para el hogar',1,1,'2022-02-12 00:23:35',NULL,NULL,NULL),(383,46413,'Venta al por mayor de confecciones textiles para el hogar',1,1,'2022-02-13 00:23:35',NULL,NULL,NULL),(384,46414,'Venta al por mayor de prendas de vestir y accesorios de vestir',1,1,'2022-02-14 00:23:35',NULL,NULL,NULL),(385,46415,'Venta al por mayor de ropa usada',1,1,'2022-02-15 00:23:35',NULL,NULL,NULL),(386,46416,'Venta al por mayor de calzado',1,1,'2022-02-16 00:23:35',NULL,NULL,NULL),(387,46417,'Venta al por mayor de artículos de marroquinería y talabartería',1,1,'2022-02-17 00:23:35',NULL,NULL,NULL),(388,46418,'Venta al por mayor de artículos de peletería',1,1,'2022-02-18 00:23:35',NULL,NULL,NULL),(389,46419,'Venta al por mayor de otros artículos textiles n.c.p.',1,1,'2022-02-19 00:23:35',NULL,NULL,NULL),(390,46471,'Venta al por mayor de instrumentos musicales',1,1,'2022-02-20 00:23:35',NULL,NULL,NULL),(391,46472,'Venta al por mayor de colchones, almohadas, cojines, etc.',1,1,'2022-02-21 00:23:35',NULL,NULL,NULL),(392,46473,'Venta al por mayor de artículos de aluminio para el hogar y para otros usos',1,1,'2022-02-22 00:23:35',NULL,NULL,NULL),(393,46474,'Venta al por mayor de depósitos y otros artículos plásticos para el hogar y otros usos, incluyendo los desechables de durapax  y no desechables',1,1,'2022-02-23 00:23:35',NULL,NULL,NULL),(394,46475,'Venta al por mayor de cámaras fotográficas, accesorios y materiales',1,1,'2022-02-24 00:23:35',NULL,NULL,NULL),(395,46482,'Venta al por mayor de medicamentos, artículos y otros productos de uso veterinario',1,1,'2022-02-25 00:23:35',NULL,NULL,NULL),(396,46483,'Venta al por mayor de productos y artículos de belleza  y de  uso personal',1,1,'2022-02-26 00:23:35',NULL,NULL,NULL),(397,46484,'Venta de produtos farmacéuticos y medicinales',1,1,'2022-02-27 00:23:35',NULL,NULL,NULL),(398,46491,'Venta al por mayor de productos medicinales, cosméticos, perfumería y productos de limpieza',1,1,'2022-02-28 00:23:35',NULL,NULL,NULL),(399,46492,'Venta al por mayor de relojes y artículos de joyería',1,1,'2022-03-01 00:23:35',NULL,NULL,NULL),(400,46493,'Venta al por mayor de electrodomésticos y artículos del hogar excepto bazar;  artículos de iluminación',1,1,'2022-03-02 00:23:35',NULL,NULL,NULL),(401,46494,'Venta al por mayor de artículos de bazar y similares',1,1,'2022-03-03 00:23:35',NULL,NULL,NULL),(402,46495,'Venta al por mayor de artículos de óptica',1,1,'2022-03-04 00:23:35',NULL,NULL,NULL),(403,46496,'Venta al por mayor de revistas, periódicos, libros, artículos de librería y artículos de papel y cartón en general',1,1,'2022-03-05 00:23:35',NULL,NULL,NULL),(404,46497,'Venta de artículos deportivos, juguetes y rodados',1,1,'2022-03-06 00:23:35',NULL,NULL,NULL),(405,46498,'Venta al por mayor de productos usados para el hogar o el uso personal',1,1,'2022-03-07 00:23:35',NULL,NULL,NULL),(406,46499,'Venta al por mayor de enseres domésticos y de uso personal n.c.p.',1,1,'2022-03-08 00:23:35',NULL,NULL,NULL),(407,46500,'Venta al por mayor de bicicletas, partes, accesorios y otros',1,1,'2022-03-09 00:23:35',NULL,NULL,NULL),(408,46510,'Venta al por mayor de computadoras, equipo periférico y programas informáticos',1,1,'2022-03-10 00:23:35',NULL,NULL,NULL),(409,46520,'Venta al por mayor de equipos de comunicación',1,1,'2022-03-11 00:23:35',NULL,NULL,NULL),(410,46530,'Venta al por mayor de maquinaria y equipo agropecuario, accesorios, partes y suministros',1,1,'2022-03-12 00:23:35',NULL,NULL,NULL),(411,46590,'Venta de equipos e instrumentos de uso profesional y cientÍfico y aparatos de medida y control',1,1,'2022-03-13 00:23:35',NULL,NULL,NULL),(412,46591,'Venta al por mayor de maquinaria equipo, accesorios y materiales para la industria de la madera y  sus  productos',1,1,'2022-03-14 00:23:35',NULL,NULL,NULL),(413,46592,'Venta al por mayor de maquinaria,  equipo, accesorios y materiales para las industria gráfica y del papel, cartón y productos de papel y cartón',1,1,'2022-03-15 00:23:35',NULL,NULL,NULL),(414,46593,'Venta al por mayor de maquinaria, equipo, accesorios y materiales para la  industria de  productos químicos, plástico y caucho',1,1,'2022-03-16 00:23:35',NULL,NULL,NULL),(415,46594,'Venta al por mayor de maquinaria, equipo, accesorios y materiales para la industria metálica y de sus productos',1,1,'2022-03-17 00:23:35',NULL,NULL,NULL),(416,46595,'Venta al por mayor de equipamiento para uso médico, odontológico, veterinario y servicios conexos',1,1,'2022-03-18 00:23:35',NULL,NULL,NULL),(417,46596,'Venta al por mayor de maquinaria, equipo, accesorios y partes para la industria de la alimentación',1,1,'2022-03-19 00:23:35',NULL,NULL,NULL),(418,46597,'Venta al por mayor de maquinaria, equipo, accesorios y partes para la industria textil, confecciones y cuero',1,1,'2022-03-20 00:23:35',NULL,NULL,NULL),(419,46598,'Venta al por mayor de maquinaria, equipo y accesorios para la construcción y explotación de minas y canteras',1,1,'2022-03-21 00:23:35',NULL,NULL,NULL),(420,46599,'Venta al por mayor de otro tipo de maquinaria y equipo con sus accesorios y partes',1,1,'2022-03-22 00:23:35',NULL,NULL,NULL),(421,46610,'Venta al por mayor  de otros combustibles sólidos, líquidos, gaseosos y de productos conexos',1,1,'2022-03-23 00:23:35',NULL,NULL,NULL),(422,46612,'Venta al por mayor de combustibles para automotores, aviones, barcos, maquinaria  y otros',1,1,'2022-03-24 00:23:35',NULL,NULL,NULL),(423,46613,'Venta al por mayor de lubricantes, grasas y  otros aceites para automotores, maquinaria  industrial, etc.',1,1,'2022-03-25 00:23:35',NULL,NULL,NULL),(424,46614,'Venta al por mayor de gas propano',1,1,'2022-03-26 00:23:35',NULL,NULL,NULL),(425,46615,'Venta al  por mayor de leña y carbón',1,1,'2022-03-27 00:23:35',NULL,NULL,NULL),(426,46620,'Venta al por mayor de metales y minerales metalíferos',1,1,'2022-03-28 00:23:35',NULL,NULL,NULL),(427,46631,'Venta al por mayor de puertas, ventanas, vitrinas y similares',1,1,'2022-03-29 00:23:35',NULL,NULL,NULL),(428,46632,'Venta al por mayor de artículos de ferretería y pinturerías',1,1,'2022-03-30 00:23:35',NULL,NULL,NULL),(429,46633,'Vidrierías',1,1,'2022-03-31 00:23:35',NULL,NULL,NULL),(430,46634,'Venta al por mayor de maderas',1,1,'2022-04-01 00:23:35',NULL,NULL,NULL),(431,46639,'Venta al por mayor de materiales para la construcción n.c.p.',1,1,'2022-04-02 00:23:35',NULL,NULL,NULL),(432,46691,'Venta al por mayor de sal industrial sin yodar',1,1,'2022-04-03 00:23:35',NULL,NULL,NULL),(433,46692,'Venta al por mayor de productos intermedios y desechos de origen textil',1,1,'2022-04-04 00:23:35',NULL,NULL,NULL),(434,46693,'Venta al por mayor de productos intermedios y desechos de origen metálico',1,1,'2022-04-05 00:23:35',NULL,NULL,NULL),(435,46694,'Venta al por mayor de productos intermedios y desechos de papel y cartón',1,1,'2022-04-06 00:23:35',NULL,NULL,NULL),(436,46695,'Venta al por mayor fertilizantes, abonos, agroquímicos y productos similares',1,1,'2022-04-07 00:23:35',NULL,NULL,NULL),(437,46696,'Venta al por mayor de productos intermedios y desechos de origen plástico',1,1,'2022-04-08 00:23:35',NULL,NULL,NULL),(438,46697,'Venta al por mayor de tintas para imprenta, productos curtientes y materias y productos colorantes',1,1,'2022-04-09 00:23:35',NULL,NULL,NULL),(439,46698,'Venta de productos intermedios y desechos de origen químico y de caucho',1,1,'2022-04-10 00:23:35',NULL,NULL,NULL),(440,46699,'Venta al por mayor de productos intermedios y desechos ncp',1,1,'2022-04-11 00:23:35',NULL,NULL,NULL),(441,46701,'Venta de algodón en oro',1,1,'2022-04-12 00:23:35',NULL,NULL,NULL),(442,46900,'Venta al por mayor de otros productos',1,1,'2022-04-13 00:23:35',NULL,NULL,NULL),(443,46901,'Venta al por mayor de cohetes y otros productos pirotécnicos',1,1,'2022-04-14 00:23:35',NULL,NULL,NULL),(444,46902,'Venta al por mayor de articulos diversos para consumo humano',1,1,'2022-04-15 00:23:35',NULL,NULL,NULL),(445,46903,'Venta al por mayor de armas de fuego, municiones y accesorios',1,1,'2022-04-16 00:23:35',NULL,NULL,NULL),(446,46904,'Venta al por mayor de toldos y tiendas de campaña de cualquier material',1,1,'2022-04-17 00:23:35',NULL,NULL,NULL),(447,46905,'Venta al por mayor de exhibidores publicitarios y rótulos',1,1,'2022-04-18 00:23:35',NULL,NULL,NULL),(448,46906,'Venta al por mayor de artículos promociónales  diversos',1,1,'2022-04-19 00:23:35',NULL,NULL,NULL),(449,47111,'Venta en supermercados',1,1,'2022-04-20 00:23:35',NULL,NULL,NULL),(450,47112,'Venta en tiendas de articulos de primera necesidad',1,1,'2022-04-21 00:23:35',NULL,NULL,NULL),(451,47119,'Almacenes (venta de diversos artículos)',1,1,'2022-04-22 00:23:35',NULL,NULL,NULL),(452,47190,'Venta al por menor de otros productos en comercios no especializados',1,1,'2022-04-23 00:23:35',NULL,NULL,NULL),(453,47199,'Venta de establecimientos no especializados con surtido compuesto principalmente de alimentos, bebidas y tabaco',1,1,'2022-04-24 00:23:35',NULL,NULL,NULL),(454,47211,'Venta al por menor  de frutas y hortalizas',1,1,'2022-04-25 00:23:35',NULL,NULL,NULL),(455,47212,'Venta al por menor de carnes, embutidos y productos de granja',1,1,'2022-04-26 00:23:35',NULL,NULL,NULL),(456,47213,'Venta al por menor de pescado y mariscos',1,1,'2022-04-27 00:23:35',NULL,NULL,NULL),(457,47214,'Venta al por menor de productos  lácteos',1,1,'2022-04-28 00:23:35',NULL,NULL,NULL),(458,47215,'Venta al por menor de productos de panadería, repostería y galletas',1,1,'2022-04-29 00:23:35',NULL,NULL,NULL),(459,47216,'Venta al por menor de huevos',1,1,'2022-04-30 00:23:35',NULL,NULL,NULL),(460,47217,'Venta al por menor de carnes y productos cárnicos',1,1,'2022-05-01 00:23:35',NULL,NULL,NULL),(461,47218,'Venta al por menor  de granos básicos y otros',1,1,'2022-05-02 00:23:35',NULL,NULL,NULL),(462,47219,'Venta al por menor de alimentos n.c.p.',1,1,'2022-05-03 00:23:35',NULL,NULL,NULL),(463,47221,'Venta al por menor de hielo',1,1,'2022-05-04 00:23:35',NULL,NULL,NULL),(464,47223,'Venta de bebidas no alcohólicas, para su consumo fuera del establecimiento',1,1,'2022-05-05 00:23:35',NULL,NULL,NULL),(465,47224,'Venta de bebidas alcohólicas, para su consumo fuera del establecimiento',1,1,'2022-05-06 00:23:35',NULL,NULL,NULL),(466,47225,'Venta de bebidas alcohólicas para su consumo dentro del establecimiento',1,1,'2022-05-07 00:23:35',NULL,NULL,NULL),(467,47230,'Venta al por menor de tabaco',1,1,'2022-05-08 00:23:35',NULL,NULL,NULL),(468,47300,'Venta de combustibles, lubricantes y otros (gasolineras)',1,1,'2022-05-09 00:23:35',NULL,NULL,NULL),(469,47411,'Venta al por menor de computadoras y equipo periférico',1,1,'2022-05-10 00:23:35',NULL,NULL,NULL),(470,47412,'Venta de equipo y accesorios de telecomunicación',1,1,'2022-05-11 00:23:35',NULL,NULL,NULL),(471,47420,'Venta al por menor de equipo de audio y video',1,1,'2022-05-12 00:23:35',NULL,NULL,NULL),(472,47510,'Venta al por menor de hilados, tejidos y productos textiles de mercería; confecciones para el hogar y textiles n.c.p.',1,1,'2022-05-13 00:23:35',NULL,NULL,NULL),(473,47521,'Venta al por menor de productos de madera',1,1,'2022-05-14 00:23:35',NULL,NULL,NULL),(474,47522,'Venta al por menor de artículos de ferretería',1,1,'2022-05-15 00:23:35',NULL,NULL,NULL),(475,47523,'Venta al por menor de productos de pinturerías',1,1,'2022-05-16 00:23:35',NULL,NULL,NULL),(476,47524,'Venta al por menor en vidrierías',1,1,'2022-05-17 00:23:35',NULL,NULL,NULL),(477,47529,'Venta al por menor de materiales de construcción y artículos conexos',1,1,'2022-05-18 00:23:35',NULL,NULL,NULL),(478,47530,'Venta al por menor de tapices, alfombras y revestimientos de paredes y pisos en comercios  especializados',1,1,'2022-05-19 00:23:35',NULL,NULL,NULL),(479,47591,'Venta al por menor de muebles',1,1,'2022-05-20 00:23:35',NULL,NULL,NULL),(480,47592,'Venta al por menor de artículos de bazar',1,1,'2022-05-21 00:23:35',NULL,NULL,NULL),(481,47593,'Venta al por menor de aparatos electrodomésticos, repuestos y accesorios',1,1,'2022-05-22 00:23:35',NULL,NULL,NULL),(482,47594,'Venta al por menor de artículos eléctricos y de iluminación',1,1,'2022-05-23 00:23:35',NULL,NULL,NULL),(483,47598,'Venta al por menor de instrumentos musicales',1,1,'2022-05-24 00:23:35',NULL,NULL,NULL),(484,47610,'Venta al por menor de libros, periódicos y artículos de papelería en comercios especializados',1,1,'2022-05-25 00:23:35',NULL,NULL,NULL),(485,47620,'Venta al por menor de discos láser, cassettes, cintas de video y otros',1,1,'2022-05-26 00:23:35',NULL,NULL,NULL),(486,47630,'Venta al por menor de productos y equipos de deporte',1,1,'2022-05-27 00:23:35',NULL,NULL,NULL),(487,47631,'Venta al por menor de bicicletas, accesorios y repuestos',1,1,'2022-05-28 00:23:35',NULL,NULL,NULL),(488,47640,'Venta al por menor de juegos y juguetes  en comercios especializados',1,1,'2022-05-29 00:23:35',NULL,NULL,NULL),(489,47711,'Venta al por menor de prendas de vestir y accesorios de vestir',1,1,'2022-05-30 00:23:35',NULL,NULL,NULL),(490,47712,'Venta al por menor de calzado',1,1,'2022-05-31 00:23:35',NULL,NULL,NULL),(491,47713,'Venta al por menor de artículos de peletería, marroquinería y talabartería',1,1,'2022-06-01 00:23:35',NULL,NULL,NULL),(492,47721,'Venta al por menor de medicamentos farmacéuticos y otros materiales y artículos de uso médico, odontológico y veterinario',1,1,'2022-06-02 00:23:35',NULL,NULL,NULL),(493,47722,'Venta al por menor de productos cosméticos y de tocador',1,1,'2022-06-03 00:23:35',NULL,NULL,NULL),(494,47731,'Venta al por menor de productos de joyería, bisutería, óptica, relojería',1,1,'2022-06-04 00:23:35',NULL,NULL,NULL),(495,47732,'Venta al por menor de plantas, semillas, animales y artículos conexos',1,1,'2022-06-05 00:23:35',NULL,NULL,NULL),(496,47733,'Venta al por menor de combustibles de uso doméstico (gas propano y gas licuado)',1,1,'2022-06-06 00:23:35',NULL,NULL,NULL),(497,47734,'Venta al por menor de artesanías, artículos cerámicos y recuerdos en general',1,1,'2022-06-07 00:23:35',NULL,NULL,NULL),(498,47735,'Venta al por menor de ataúdes, lápidas y cruces, trofeos, artículos religiosos en general',1,1,'2022-06-08 00:23:35',NULL,NULL,NULL),(499,47736,'Venta al por menor de armas de fuego, municiones y accesorios',1,1,'2022-06-09 00:23:35',NULL,NULL,NULL),(500,47737,'Venta al por menor de artículos de cohetería y pirotécnicos',1,1,'2022-06-10 00:23:35',NULL,NULL,NULL),(501,47738,'Venta al por menor de artículos desechables de uso personal y doméstico (servilletas, papel higiénico, pañales, toallas sanitarias, etc.)',1,1,'2022-06-11 00:23:35',NULL,NULL,NULL),(502,47739,'Venta al por menor de otros productos  n.c.p.',1,1,'2022-06-12 00:23:35',NULL,NULL,NULL),(503,47741,'Venta al por menor de artículos usados',1,1,'2022-06-13 00:23:35',NULL,NULL,NULL),(504,47742,'Venta al por menor de textiles y confecciones usados',1,1,'2022-06-14 00:23:35',NULL,NULL,NULL),(505,47743,'Venta al por menor de libros, revistas, papel y cartón usados',1,1,'2022-06-15 00:23:35',NULL,NULL,NULL),(506,47749,'Venta al por menor de productos usados n.c.p.',1,1,'2022-06-16 00:23:35',NULL,NULL,NULL),(507,47811,'Venta al por menor de frutas, verduras y hortalizas',1,1,'2022-06-17 00:23:35',NULL,NULL,NULL),(508,47812,'Venta al por menor de carnes, embutidos y productos de granja',1,1,'2022-06-18 00:23:35',NULL,NULL,NULL),(509,47814,'Venta al por menor de productos lácteos',1,1,'2022-06-19 00:23:35',NULL,NULL,NULL),(510,47815,'Venta al por menor de productos de panadería, galletas y similares',1,1,'2022-06-20 00:23:35',NULL,NULL,NULL),(511,47816,'Venta al por menor de bebidas',1,1,'2022-06-21 00:23:35',NULL,NULL,NULL),(512,47818,'Venta al por menor en tiendas de mercado y puestos',1,1,'2022-06-22 00:23:35',NULL,NULL,NULL),(513,47821,'Venta al por menor de hilados, tejidos y productos textiles de mercería en puestos de mercados y ferias',1,1,'2022-06-23 00:23:35',NULL,NULL,NULL),(514,47822,'Venta al por menor de artículos textiles excepto confecciones para el hogar en puestos de mercados y ferias',1,1,'2022-06-24 00:23:35',NULL,NULL,NULL),(515,47823,'Venta al por menor de confecciones textiles para el hogar en puestos de mercados y ferias',1,1,'2022-06-25 00:23:35',NULL,NULL,NULL),(516,47824,'Venta al por menor de prendas de vestir, accesorios de vestir y similares en puestos de mercados y ferias',1,1,'2022-06-26 00:23:35',NULL,NULL,NULL),(517,47825,'Venta al por menor de ropa usada',1,1,'2022-06-27 00:23:35',NULL,NULL,NULL),(518,47826,'Venta al por menor de calzado, artículos de marroquinería y talabartería en puestos de mercados y ferias',1,1,'2022-06-28 00:23:35',NULL,NULL,NULL),(519,47827,'Venta al por menor de artículos de marroquinería y talabartería en puestos de mercados y ferias',1,1,'2022-06-29 00:23:35',NULL,NULL,NULL),(520,47829,'Venta al por menor de artículos textiles ncp en puestos de mercados y ferias',1,1,'2022-06-30 00:23:35',NULL,NULL,NULL),(521,47891,'Venta al por menor de animales, flores y productos conexos en puestos de feria y mercados',1,1,'2022-07-01 00:23:35',NULL,NULL,NULL),(522,47892,'Venta al por menor de productos medicinales, cosméticos, de tocador y de limpieza en puestos de ferias y mercados',1,1,'2022-07-02 00:23:35',NULL,NULL,NULL),(523,47893,'Venta al por menor de artículos de bazar en puestos de ferias y mercados',1,1,'2022-07-03 00:23:35',NULL,NULL,NULL),(524,47894,'Venta al por menor de artículos de papel, envases, libros, revistas y conexos en puestos de feria y mercados',1,1,'2022-07-04 00:23:35',NULL,NULL,NULL),(525,47895,'Venta al por menor de materiales de construcción, electrodomésticos, accesorios para autos y similares en puestos de feria y mercados',1,1,'2022-07-05 00:23:35',NULL,NULL,NULL),(526,47896,'Venta al por menor de equipos accesorios para las comunicaciones en puestos de feria y mercados',1,1,'2022-07-06 00:23:35',NULL,NULL,NULL),(527,47899,'Venta al por menor en puestos de ferias y mercados n.c.p.',1,1,'2022-07-07 00:23:35',NULL,NULL,NULL),(528,47910,'Venta al por menor por correo o Internet',1,1,'2022-07-08 00:23:35',NULL,NULL,NULL),(529,47990,'Otros tipos de venta al por menor no realizada, en almacenes, puestos de venta o mercado',1,1,'2022-07-09 00:23:35',NULL,NULL,NULL),(530,49110,'Transporte interurbano de pasajeros  por ferrocarril',1,1,'2022-07-10 00:23:35',NULL,NULL,NULL),(531,49120,'Transporte de carga por ferrocarril',1,1,'2022-07-11 00:23:35',NULL,NULL,NULL),(532,49211,'Transporte de pasajeros urbanos e interurbano mediante buses',1,1,'2022-07-12 00:23:35',NULL,NULL,NULL),(533,49212,'Transporte de pasajeros interdepartamental mediante microbuses',1,1,'2022-07-13 00:23:35',NULL,NULL,NULL),(534,49213,'Transporte de pasajeros urbanos e interurbano mediante microbuses',1,1,'2022-07-14 00:23:35',NULL,NULL,NULL),(535,49214,'Transporte de pasajeros interdepartamental mediante buses',1,1,'2022-07-15 00:23:35',NULL,NULL,NULL),(536,49221,'Transporte internacional de pasajeros',1,1,'2022-07-16 00:23:35',NULL,NULL,NULL),(537,49222,'Transporte de pasajeros mediante taxis y autos con chofer',1,1,'2022-07-17 00:23:35',NULL,NULL,NULL),(538,49223,'Transporte escolar',1,1,'2022-07-18 00:23:35',NULL,NULL,NULL),(539,49225,'Transporte de pasajeros para excursiones',1,1,'2022-07-19 00:23:35',NULL,NULL,NULL),(540,49226,'Servicios de transporte de personal',1,1,'2022-07-20 00:23:35',NULL,NULL,NULL),(541,49229,'Transporte de pasajeros por vía terrestre ncp',1,1,'2022-07-21 00:23:35',NULL,NULL,NULL),(542,49231,'Transporte de carga urbano',1,1,'2022-07-22 00:23:35',NULL,NULL,NULL),(543,49232,'Transporte nacional de carga',1,1,'2022-07-23 00:23:35',NULL,NULL,NULL),(544,49233,'Transporte de carga  internacional',1,1,'2022-07-24 00:23:35',NULL,NULL,NULL),(545,49234,'Servicios de  mudanza',1,1,'2022-07-25 00:23:35',NULL,NULL,NULL),(546,49235,'Alquiler de vehículos de carga con conductor',1,1,'2022-07-26 00:23:35',NULL,NULL,NULL),(547,49300,'Transporte por oleoducto o gasoducto',1,1,'2022-07-27 00:23:35',NULL,NULL,NULL),(548,50110,'Transporte de pasajeros marítimo y de cabotaje',1,1,'2022-07-28 00:23:35',NULL,NULL,NULL),(549,50120,'Transporte de carga marítimo y de cabotaje',1,1,'2022-07-29 00:23:35',NULL,NULL,NULL),(550,50211,'Transporte de pasajeros por vías de navegación interiores',1,1,'2022-07-30 00:23:35',NULL,NULL,NULL),(551,50212,'Alquiler de equipo de transporte de pasajeros por vías de navegación interior con conductor',1,1,'2022-07-31 00:23:35',NULL,NULL,NULL),(552,50220,'Transporte de carga por vías de navegación interiores',1,1,'2022-08-01 00:23:35',NULL,NULL,NULL),(553,51100,'Transporte aéreo de pasajeros',1,1,'2022-08-02 00:23:35',NULL,NULL,NULL),(554,51201,'Transporte de carga por vía aérea',1,1,'2022-08-03 00:23:35',NULL,NULL,NULL),(555,51202,'Alquiler de equipo de aerotransporte  con operadores para el propósito de transportar carga',1,1,'2022-08-04 00:23:35',NULL,NULL,NULL),(556,52101,'Alquiler de instalaciones de almacenamiento en zonas francas',1,1,'2022-08-05 00:23:35',NULL,NULL,NULL),(557,52102,'Alquiler de silos para conservación y almacenamiento de granos',1,1,'2022-08-06 00:23:35',NULL,NULL,NULL),(558,52103,'Alquiler de instalaciones con refrigeración para almacenamiento y conservación de alimentos y otros productos',1,1,'2022-08-07 00:23:35',NULL,NULL,NULL),(559,52109,'Alquiler de bodegas para almacenamiento y depósito n.c.p.',1,1,'2022-08-08 00:23:35',NULL,NULL,NULL),(560,52211,'Servicio de garaje y estacionamiento',1,1,'2022-08-09 00:23:35',NULL,NULL,NULL),(561,52212,'Servicios de terminales para el transporte por vía terrestre',1,1,'2022-08-10 00:23:35',NULL,NULL,NULL),(562,52219,'Servicios para el transporte por vía terrestre n.c.p.',1,1,'2022-08-11 00:23:35',NULL,NULL,NULL),(563,52220,'Servicios para el transporte acuático',1,1,'2022-08-12 00:23:35',NULL,NULL,NULL),(564,52230,'Servicios para el transporte aéreo',1,1,'2022-08-13 00:23:35',NULL,NULL,NULL),(565,52240,'Manipulación de carga',1,1,'2022-08-14 00:23:35',NULL,NULL,NULL),(566,52290,'Servicios para el transporte ncp',1,1,'2022-08-15 00:23:35',NULL,NULL,NULL),(567,52291,'Agencias de tramitaciones aduanales',1,1,'2022-08-16 00:23:35',NULL,NULL,NULL),(568,53100,'Servicios de  correo nacional',1,1,'2022-08-17 00:23:35',NULL,NULL,NULL),(569,53200,'Actividades de correo distintas a las actividades postales nacionales',1,1,'2022-08-18 00:23:35',NULL,NULL,NULL),(570,55101,'Actividades de alojamiento para estancias cortas',1,1,'2022-08-19 00:23:35',NULL,NULL,NULL),(571,55102,'Hoteles',1,1,'2022-08-20 00:23:35',NULL,NULL,NULL),(572,55200,'Actividades de campamentos, parques de vehículos de recreo y parques de caravanas',1,1,'2022-08-21 00:23:35',NULL,NULL,NULL),(573,55900,'Alojamiento n.c.p.',1,1,'2022-08-22 00:23:35',NULL,NULL,NULL),(574,56101,'Restaurantes',1,1,'2022-08-23 00:23:35',NULL,NULL,NULL),(575,56106,'Pupusería',1,1,'2022-08-24 00:23:35',NULL,NULL,NULL),(576,56107,'Actividades varias de restaurantes',1,1,'2022-08-25 00:23:35',NULL,NULL,NULL),(577,56108,'Comedores',1,1,'2022-08-26 00:23:35',NULL,NULL,NULL),(578,56109,'Merenderos ambulantes',1,1,'2022-08-27 00:23:35',NULL,NULL,NULL),(579,56210,'Preparación de comida para eventos especiales',1,1,'2022-08-28 00:23:35',NULL,NULL,NULL),(580,56291,'Servicios de provisión de comidas por contrato',1,1,'2022-08-29 00:23:35',NULL,NULL,NULL),(581,56292,'Servicios de concesión de cafetines y chalet en empresas e instituciones',1,1,'2022-08-30 00:23:35',NULL,NULL,NULL),(582,56299,'Servicios de preparación de comidas ncp',1,1,'2022-08-31 00:23:35',NULL,NULL,NULL),(583,56301,'Servicio de expendio de bebidas en salones y bares',1,1,'2022-09-01 00:23:35',NULL,NULL,NULL),(584,56302,'Servicio de expendio de bebidas en puestos callejeros, mercados y ferias',1,1,'2022-09-02 00:23:35',NULL,NULL,NULL),(585,58110,'Edición de libros, folletos, partituras y otras ediciones distintas a estas',1,1,'2022-09-03 00:23:35',NULL,NULL,NULL),(586,58120,'Edición de directorios y listas de correos',1,1,'2022-09-04 00:23:35',NULL,NULL,NULL),(587,58130,'Edición de periódicos, revistas y otras publicaciones periódicas',1,1,'2022-09-05 00:23:35',NULL,NULL,NULL),(588,58190,'Otras actividades de edición',1,1,'2022-09-06 00:23:35',NULL,NULL,NULL),(589,58200,'Edición de programas informáticos (software)',1,1,'2022-09-07 00:23:35',NULL,NULL,NULL),(590,59110,'Actividades de producción cinematográfica',1,1,'2022-09-08 00:23:35',NULL,NULL,NULL),(591,59120,'Actividades de post producción de películas, videos y programas  de televisión',1,1,'2022-09-09 00:23:35',NULL,NULL,NULL),(592,59130,'Actividades de distribución de películas cinematográficas, videos y programas de televisión',1,1,'2022-09-10 00:23:35',NULL,NULL,NULL),(593,59140,'Actividades de exhibición de películas cinematográficas y cintas de vídeo',1,1,'2022-09-11 00:23:35',NULL,NULL,NULL),(594,59200,'Actividades de edición y grabación de música',1,1,'2022-09-12 00:23:35',NULL,NULL,NULL),(595,60100,'Servicios de difusiones de radio',1,1,'2022-09-13 00:23:35',NULL,NULL,NULL),(596,60201,'Actividades de programación y difusión de televisión abierta',1,1,'2022-09-14 00:23:35',NULL,NULL,NULL),(597,60202,'Actividades de suscripción y difusión de televisión por cable y/o suscripción',1,1,'2022-09-15 00:23:35',NULL,NULL,NULL),(598,60299,'Servicios de televisión, incluye televisión por cable',1,1,'2022-09-16 00:23:35',NULL,NULL,NULL),(599,60900,'Programación y transmisión de radio y televisión',1,1,'2022-09-17 00:23:35',NULL,NULL,NULL),(600,61101,'Servicio de telefonía',1,1,'2022-09-18 00:23:35',NULL,NULL,NULL),(601,61102,'Servicio de Internet ',1,1,'2022-09-19 00:23:35',NULL,NULL,NULL),(602,61103,'Servicio de telefonía fija',1,1,'2022-09-20 00:23:35',NULL,NULL,NULL),(603,61109,'Servicio de Internet n.c.p.',1,1,'2022-09-21 00:23:35',NULL,NULL,NULL),(604,61201,'Servicios de telefonía celular',1,1,'2022-09-22 00:23:35',NULL,NULL,NULL),(605,61202,'Servicios de Internet inalámbrico',1,1,'2022-09-23 00:23:35',NULL,NULL,NULL),(606,61209,'Servicios de telecomunicaciones inalámbrico n.c.p.',1,1,'2022-09-24 00:23:35',NULL,NULL,NULL),(607,61301,'Telecomunicaciones satelitales',1,1,'2022-09-25 00:23:35',NULL,NULL,NULL),(608,61309,'Comunicación vía satélite n.c.p.',1,1,'2022-09-26 00:23:35',NULL,NULL,NULL),(609,61900,'Actividades de telecomunicación n.c.p.',1,1,'2022-09-27 00:23:35',NULL,NULL,NULL),(610,62010,'Programación Informática',1,1,'2022-09-28 00:23:35',NULL,NULL,NULL),(611,62020,'Consultorias y gestión de servicios informáticos',1,1,'2022-09-29 00:23:35',NULL,NULL,NULL),(612,62090,'Otras actividades de tecnología de información y servicios de computadora',1,1,'2022-09-30 00:23:35',NULL,NULL,NULL),(613,63110,'Procesamiento de datos y actividades relacionadas',1,1,'2022-10-01 00:23:35',NULL,NULL,NULL),(614,63120,'Portales WEB',1,1,'2022-10-02 00:23:35',NULL,NULL,NULL),(615,63910,'Servicios de Agencias de Noticias',1,1,'2022-10-03 00:23:35',NULL,NULL,NULL),(616,63990,'Otros servicios de información  n.c.p.',1,1,'2022-10-04 00:23:35',NULL,NULL,NULL),(617,64110,'Servicios provistos por el Banco Central de El salvador',1,1,'2022-10-05 00:23:35',NULL,NULL,NULL),(618,64190,'Bancos',1,1,'2022-10-06 00:23:35',NULL,NULL,NULL),(619,64192,'Entidades dedicadas al envío de remesas',1,1,'2022-10-07 00:23:35',NULL,NULL,NULL),(620,64199,'Otras entidades financieras',1,1,'2022-10-08 00:23:35',NULL,NULL,NULL),(621,64200,'Actividades de sociedades de cartera',1,1,'2022-10-09 00:23:35',NULL,NULL,NULL),(622,64300,'Fideicomisos, fondos y otras fuentes de financiamiento',1,1,'2022-10-10 00:23:35',NULL,NULL,NULL),(623,64910,'Arrendamiento financieros',1,1,'2022-10-11 00:23:35',NULL,NULL,NULL),(624,64920,'Asociaciones cooperativas de ahorro y crédito dedicadas a la intermediación financiera',1,1,'2022-10-12 00:23:35',NULL,NULL,NULL),(625,64921,'Instituciones emisoras de tarjetas de crédito y otros',1,1,'2022-10-13 00:23:35',NULL,NULL,NULL),(626,64922,'Tipos de crédito ncp',1,1,'2022-10-14 00:23:35',NULL,NULL,NULL),(627,64928,'Prestamistas y casas de empeño',1,1,'2022-10-15 00:23:35',NULL,NULL,NULL),(628,64990,'Actividades de servicios financieros, excepto la financiación de planes de seguros y de pensiones n.c.p.',1,1,'2022-10-16 00:23:35',NULL,NULL,NULL),(629,65110,'Planes de seguros de vida',1,1,'2022-10-17 00:23:35',NULL,NULL,NULL),(630,65120,'Planes de seguro excepto de vida',1,1,'2022-10-18 00:23:35',NULL,NULL,NULL),(631,65199,'Seguros generales de todo tipo',1,1,'2022-10-19 00:23:35',NULL,NULL,NULL),(632,65200,'Planes se seguro',1,1,'2022-10-20 00:23:35',NULL,NULL,NULL),(633,65300,'Planes de pensiones',1,1,'2022-10-21 00:23:35',NULL,NULL,NULL),(634,66110,'Administración de mercados financieros (Bolsa de Valores)',1,1,'2022-10-22 00:23:35',NULL,NULL,NULL),(635,66120,'Actividades bursátiles (Corredores de Bolsa)',1,1,'2022-10-23 00:23:35',NULL,NULL,NULL),(636,66190,'Actividades auxiliares de la intermediación financiera ncp',1,1,'2022-10-24 00:23:35',NULL,NULL,NULL),(637,66210,'Evaluación de riesgos y daños',1,1,'2022-10-25 00:23:35',NULL,NULL,NULL),(638,66220,'Actividades de agentes y corredores de seguros',1,1,'2022-10-26 00:23:35',NULL,NULL,NULL),(639,66290,'Otras actividades auxiliares de seguros y fondos de pensiones',1,1,'2022-10-27 00:23:35',NULL,NULL,NULL),(640,66300,'Actividades de administración de fondos',1,1,'2022-10-28 00:23:35',NULL,NULL,NULL),(641,68101,'Servicio de alquiler y venta de lotes en cementerios',1,1,'2022-10-29 00:23:35',NULL,NULL,NULL),(642,68109,'Actividades inmobiliarias realizadas con bienes propios o arrendados n.c.p.',1,1,'2022-10-30 00:23:35',NULL,NULL,NULL),(643,68200,'Actividades Inmobiliarias Realizadas a Cambio de una Retribución o por Contrata',1,1,'2022-10-31 00:23:35',NULL,NULL,NULL),(644,69100,'Actividades jurídicas',1,1,'2022-11-01 00:23:35',NULL,NULL,NULL),(645,69200,'Actividades de contabilidad, teneduría de libros y auditoría; asesoramiento en materia de impuestos',1,1,'2022-11-02 00:23:35',NULL,NULL,NULL),(646,70100,'Actividades de oficinas centrales de sociedades de cartera',1,1,'2022-11-03 00:23:35',NULL,NULL,NULL),(647,70200,'Actividades de consultoria en gestión empresarial',1,1,'2022-11-04 00:23:35',NULL,NULL,NULL),(648,71101,'Servicios de arquitectura y planificación urbana y servicios conexos',1,1,'2022-11-05 00:23:35',NULL,NULL,NULL),(649,71102,'Servicios de ingeniería',1,1,'2022-11-06 00:23:35',NULL,NULL,NULL),(650,71103,'Servicios de agrimensura, topografía, cartografía, prospección y geofísica y servicios conexos',1,1,'2022-11-07 00:23:35',NULL,NULL,NULL),(651,71200,'Ensayos y análisis técnicos',1,1,'2022-11-08 00:23:35',NULL,NULL,NULL),(652,72100,'Investigaciones y desarrollo experimental en el campo de las ciencias naturales y la ingeniería',1,1,'2022-11-09 00:23:35',NULL,NULL,NULL),(653,72199,'Investigaciones científicas',1,1,'2022-11-10 00:23:35',NULL,NULL,NULL),(654,72200,'Investigaciones y desarrollo experimental en el campo de las ciencias sociales y las humanidades científica y desarrollo',1,1,'2022-11-11 00:23:35',NULL,NULL,NULL),(655,73100,'Publicidad',1,1,'2022-11-12 00:23:35',NULL,NULL,NULL),(656,73200,'Investigación de mercados y realización de encuestas de opinión pública',1,1,'2022-11-13 00:23:35',NULL,NULL,NULL),(657,74100,'Actividades de diseño especializado',1,1,'2022-11-14 00:23:35',NULL,NULL,NULL),(658,74200,'Actividades de fotografía',1,1,'2022-11-15 00:23:35',NULL,NULL,NULL),(659,74900,'Servicios profesionales y científicos ncp',1,1,'2022-11-16 00:23:35',NULL,NULL,NULL),(660,75000,'Actividades veterinarias',1,1,'2022-11-17 00:23:35',NULL,NULL,NULL),(661,77101,'Alquiler de equipo de transporte terrestre',1,1,'2022-11-18 00:23:35',NULL,NULL,NULL),(662,77102,'Alquiler de equipo de transporte acuático',1,1,'2022-11-19 00:23:35',NULL,NULL,NULL),(663,77103,'Alquiler de equipo de transporte  por vía aérea',1,1,'2022-11-20 00:23:35',NULL,NULL,NULL),(664,77210,'Alquiler y arrendamiento de equipo de recreo y deportivo',1,1,'2022-11-21 00:23:35',NULL,NULL,NULL),(665,77220,'Alquiler de cintas de video y discos',1,1,'2022-11-22 00:23:35',NULL,NULL,NULL),(666,77290,'Alquiler de otros efectos personales y enseres domésticos',1,1,'2022-11-23 00:23:35',NULL,NULL,NULL),(667,77300,'Alquiler de maquinaria y equipo',1,1,'2022-11-24 00:23:35',NULL,NULL,NULL),(668,77400,'Arrendamiento de productos de propiedad intelectual',1,1,'2022-11-25 00:23:35',NULL,NULL,NULL),(669,78100,'Obtención y dotación de personal',1,1,'2022-11-26 00:23:35',NULL,NULL,NULL),(670,78200,'Actividades de las agencias de trabajo temporal',1,1,'2022-11-27 00:23:35',NULL,NULL,NULL),(671,78300,'Dotación de recursos humanos y gestión; gestión de las funciones de recursos humanos',1,1,'2022-11-28 00:23:35',NULL,NULL,NULL),(672,79110,'Actividades de agencias de viajes y organizadores de viajes; actividades de asistencia a turistas',1,1,'2022-11-29 00:23:35',NULL,NULL,NULL),(673,79120,'Actividades de los operadores turísticos',1,1,'2022-11-30 00:23:35',NULL,NULL,NULL),(674,79900,'Otros servicios de reservas y actividades relacionadas',1,1,'2022-12-01 00:23:35',NULL,NULL,NULL),(675,80100,'Servicios de seguridad privados',1,1,'2022-12-02 00:23:35',NULL,NULL,NULL),(676,80201,'Actividades de servicios de sistemas de seguridad',1,1,'2022-12-03 00:23:35',NULL,NULL,NULL),(677,80202,'Actividades para la prestación de sistemas de seguridad',1,1,'2022-12-04 00:23:35',NULL,NULL,NULL),(678,80300,'Actividades de investigación',1,1,'2022-12-05 00:23:35',NULL,NULL,NULL),(679,81100,'Actividades combinadas de mantenimiento de edificios e instalaciones',1,1,'2022-12-06 00:23:35',NULL,NULL,NULL),(680,81210,'Limpieza general de edificios',1,1,'2022-12-07 00:23:35',NULL,NULL,NULL),(681,81290,'Otras actividades combinadas de mantenimiento de edificios e instalaciones ncp',1,1,'2022-12-08 00:23:35',NULL,NULL,NULL),(682,81300,'Servicio de jardinería',1,1,'2022-12-09 00:23:35',NULL,NULL,NULL),(683,82110,'Servicios administrativos de oficinas',1,1,'2022-12-10 00:23:35',NULL,NULL,NULL),(684,82190,'Servicio de fotocopiado y similares, excepto en imprentas',1,1,'2022-12-11 00:23:35',NULL,NULL,NULL),(685,82200,'Actividades de las centrales de llamadas (call center)',1,1,'2022-12-12 00:23:35',NULL,NULL,NULL),(686,82300,'Organización de convenciones y ferias de negocios',1,1,'2022-12-13 00:23:35',NULL,NULL,NULL),(687,82910,'Actividades de agencias de cobro y oficinas de crédito',1,1,'2022-12-14 00:23:35',NULL,NULL,NULL),(688,82921,'Servicios de envase y empaque de productos alimenticios',1,1,'2022-12-15 00:23:35',NULL,NULL,NULL),(689,82922,'Servicios de envase y empaque de productos medicinales',1,1,'2022-12-16 00:23:35',NULL,NULL,NULL),(690,82929,'Servicio de envase y empaque ncp',1,1,'2022-12-17 00:23:35',NULL,NULL,NULL),(691,82990,'Actividades de apoyo empresariales ncp',1,1,'2022-12-18 00:23:35',NULL,NULL,NULL),(692,84110,'Actividades de la Administración Pública en general',1,1,'2022-12-19 00:23:35',NULL,NULL,NULL),(693,84111,'Alcaldías Municipales',1,1,'2022-12-20 00:23:35',NULL,NULL,NULL),(694,84120,'Regulación de las actividades de prestación de servicios sanitarios, educativos, culturales y otros servicios sociales, excepto seguridad social',1,1,'2022-12-21 00:23:35',NULL,NULL,NULL),(695,84130,'Regulación y facilitación de la actividad económica',1,1,'2022-12-22 00:23:35',NULL,NULL,NULL),(696,84210,'Actividades de administración y funcionamiento del Ministerio de Relaciones Exteriores',1,1,'2022-12-23 00:23:35',NULL,NULL,NULL),(697,84220,'Actividades de defensa',1,1,'2022-12-24 00:23:35',NULL,NULL,NULL),(698,84230,'Actividades de mantenimiento del orden público y de seguridad',1,1,'2022-12-25 00:23:35',NULL,NULL,NULL),(699,84300,'Actividades de planes de seguridad social de afiliación obligatoria',1,1,'2022-12-26 00:23:35',NULL,NULL,NULL),(700,85101,'Guardería educativa',1,1,'2022-12-27 00:23:35',NULL,NULL,NULL),(701,85102,'Enseñanza preescolar o parvularia',1,1,'2022-12-28 00:23:35',NULL,NULL,NULL),(702,85103,'Enseñanza primaria',1,1,'2022-12-29 00:23:35',NULL,NULL,NULL),(703,85104,'Servicio de educación preescolar y primaria integrada',1,1,'2022-12-30 00:23:35',NULL,NULL,NULL),(704,85211,'Enseñanza secundaria tercer ciclo (7°, 8° y 9° )',1,1,'2022-12-31 00:23:35',NULL,NULL,NULL),(705,85212,'Enseñanza secundaria  de formación general  bachillerato',1,1,'2023-01-01 00:23:35',NULL,NULL,NULL),(706,85221,'Enseñanza secundaria de formación técnica y profesional',1,1,'2023-01-02 00:23:35',NULL,NULL,NULL),(707,85222,'Enseñanza secundaria de formación técnica y profesional integrada con enseñanza primaria',1,1,'2023-01-03 00:23:35',NULL,NULL,NULL),(708,85301,'Enseñanza superior universitaria',1,1,'2023-01-04 00:23:35',NULL,NULL,NULL),(709,85302,'Enseñanza superior no universitaria',1,1,'2023-01-05 00:23:35',NULL,NULL,NULL),(710,85303,'Enseñanza superior integrada a educación secundaria y/o primaria',1,1,'2023-01-06 00:23:35',NULL,NULL,NULL),(711,85410,'Educación deportiva y recreativa',1,1,'2023-01-07 00:23:35',NULL,NULL,NULL),(712,85420,'Educación cultural',1,1,'2023-01-08 00:23:35',NULL,NULL,NULL),(713,85490,'Otros tipos de enseñanza n.c.p.',1,1,'2023-01-09 00:23:35',NULL,NULL,NULL),(714,85499,'Enseñanza formal',1,1,'2023-01-10 00:23:35',NULL,NULL,NULL),(715,85500,'Servicios de apoyo a la enseñanza',1,1,'2023-01-11 00:23:35',NULL,NULL,NULL),(716,86100,'Actividades de hospitales',1,1,'2023-01-12 00:23:35',NULL,NULL,NULL),(717,86201,'Clínicas médicas',1,1,'2023-01-13 00:23:35',NULL,NULL,NULL),(718,86202,'Servicios de Odontología',1,1,'2023-01-14 00:23:35',NULL,NULL,NULL),(719,86203,'Servicios médicos',1,1,'2023-01-15 00:23:35',NULL,NULL,NULL),(720,86901,'Servicios de análisis y estudios de diagnóstico',1,1,'2023-01-16 00:23:35',NULL,NULL,NULL),(721,86902,'Actividades de atención de la salud humana',1,1,'2023-01-17 00:23:35',NULL,NULL,NULL),(722,86909,'Otros Servicio relacionados con la salud ncp',1,1,'2023-01-18 00:23:35',NULL,NULL,NULL),(723,87100,'Residencias de ancianos con atención de enfermería',1,1,'2023-01-19 00:23:35',NULL,NULL,NULL),(724,87200,'Instituciones dedicadas al tratamiento del retraso mental, problemas de salud mental y el uso indebido de sustancias nocivas',1,1,'2023-01-20 00:23:35',NULL,NULL,NULL),(725,87300,'Instituciones dedicadas al cuidado de ancianos y discapacitados',1,1,'2023-01-21 00:23:35',NULL,NULL,NULL),(726,87900,'Actividades de asistencia a niños y jóvenes',1,1,'2023-01-22 00:23:35',NULL,NULL,NULL),(727,87901,'Otras actividades de atención en instituciones',1,1,'2023-01-23 00:23:35',NULL,NULL,NULL),(728,88100,'Actividades de asistencia sociales sin alojamiento para ancianos y discapacitados',1,1,'2023-01-24 00:23:35',NULL,NULL,NULL),(729,88900,'servicios sociales sin alojamiento ncp',1,1,'2023-01-25 00:23:35',NULL,NULL,NULL),(730,90000,'Actividades creativas artísticas y de esparcimiento',1,1,'2023-01-26 00:23:35',NULL,NULL,NULL),(731,91010,'Actividades de bibliotecas y archivos',1,1,'2023-01-27 00:23:35',NULL,NULL,NULL),(732,91020,'Actividades de museos y preservación de lugares y edificios históricos',1,1,'2023-01-28 00:23:35',NULL,NULL,NULL),(733,91030,'Actividades de jardínes botánicos, zoológicos y de reservas naturales',1,1,'2023-01-29 00:23:35',NULL,NULL,NULL),(734,92000,'Actividades de juegos y apuestas',1,1,'2023-01-30 00:23:35',NULL,NULL,NULL),(735,93110,'Gestión de instalaciones deportivas',1,1,'2023-01-31 00:23:35',NULL,NULL,NULL),(736,93120,'Actividades de clubes deportivos',1,1,'2023-02-01 00:23:35',NULL,NULL,NULL),(737,93190,'Otras actividades deportivas',1,1,'2023-02-02 00:23:35',NULL,NULL,NULL),(738,93210,'Actividades de parques de atracciones y parques temáticos',1,1,'2023-02-03 00:23:35',NULL,NULL,NULL),(739,93291,'Discotecas y salas de baile',1,1,'2023-02-04 00:23:35',NULL,NULL,NULL),(740,93298,'Centros vacacionales',1,1,'2023-02-05 00:23:35',NULL,NULL,NULL),(741,93299,'Actividades de esparcimiento ncp',1,1,'2023-02-06 00:23:35',NULL,NULL,NULL),(742,94110,'Actividades de organizaciones empresariales y de empleadores',1,1,'2023-02-07 00:23:35',NULL,NULL,NULL),(743,94120,'Actividades de organizaciones profesionales',1,1,'2023-02-08 00:23:35',NULL,NULL,NULL),(744,94200,'Actividades de sindicatos',1,1,'2023-02-09 00:23:35',NULL,NULL,NULL),(745,94910,'Actividades de organizaciones religiosas',1,1,'2023-02-10 00:23:35',NULL,NULL,NULL),(746,94920,'Actividades de organizaciones políticas',1,1,'2023-02-11 00:23:35',NULL,NULL,NULL),(747,94990,'Actividades de asociaciones n.c.p.',1,1,'2023-02-12 00:23:35',NULL,NULL,NULL),(748,95110,'Reparación de computadoras y equipo periférico',1,1,'2023-02-13 00:23:35',NULL,NULL,NULL),(749,95120,'Reparación de equipo de comunicación',1,1,'2023-02-14 00:23:35',NULL,NULL,NULL),(750,95210,'Reparación de aparatos electrónicos de consumo',1,1,'2023-02-15 00:23:35',NULL,NULL,NULL),(751,95220,'Reparación de aparatos doméstico y equipo de hogar y jardín',1,1,'2023-02-16 00:23:35',NULL,NULL,NULL),(752,95230,'Reparación de calzado y artículos de cuero',1,1,'2023-02-17 00:23:35',NULL,NULL,NULL),(753,95240,'Reparación de muebles y accesorios para el hogar',1,1,'2023-02-18 00:23:35',NULL,NULL,NULL),(754,95291,'Reparación de Instrumentos musicales',1,1,'2023-02-19 00:23:35',NULL,NULL,NULL),(755,95292,'Servicios de cerrajería y copiado de llaves',1,1,'2023-02-20 00:23:35',NULL,NULL,NULL),(756,95293,'Reparación de joyas y relojes',1,1,'2023-02-21 00:23:35',NULL,NULL,NULL),(757,95294,'Reparación de bicicletas, sillas de ruedas y rodados n.c.p.',1,1,'2023-02-22 00:23:35',NULL,NULL,NULL),(758,95299,'Reparaciones de enseres personales n.c.p.',1,1,'2023-02-23 00:23:35',NULL,NULL,NULL),(759,96010,'Lavado y limpieza de prendas de tela y de piel, incluso la limpieza en seco',1,1,'2023-02-24 00:23:35',NULL,NULL,NULL),(760,96020,'Peluquería y otros tratamientos de belleza',1,1,'2023-02-25 00:23:35',NULL,NULL,NULL),(761,96030,'Pompas fúnebres y actividades conexas',1,1,'2023-02-26 00:23:35',NULL,NULL,NULL),(762,96091,'Servicios de sauna y otros servicios para la estética corporal n.c.p.',1,1,'2023-02-27 00:23:35',NULL,NULL,NULL),(763,96092,'Servicios n.c.p.',1,1,'2023-02-28 00:23:35',NULL,NULL,NULL),(764,97000,'Actividad de los hogares en calidad de empleadores de personal doméstico',1,1,'2023-03-01 00:23:35',NULL,NULL,NULL),(765,98100,'Actividades indiferenciadas de producción de bienes de los hogares privados para uso propio',1,1,'2023-03-02 00:23:35',NULL,NULL,NULL),(766,98200,'Actividades indiferenciadas de producción de servicios de los hogares privados para uso propio',1,1,'2023-03-03 00:23:35',NULL,NULL,NULL),(767,99000,'Actividades de organizaciones y órganos extraterritoriales',1,1,'2023-03-04 00:23:35',NULL,NULL,NULL),(768,10001,'Empleados',1,1,'2023-03-05 00:23:35',NULL,NULL,NULL),(769,10002,'Jubilado',1,1,'2023-03-06 00:23:35',NULL,NULL,NULL),(770,10003,'Estudiante',1,1,'2023-03-07 00:23:35',NULL,NULL,NULL),(771,10004,'Desempleado',1,1,'2023-03-08 00:23:35',NULL,NULL,NULL),(772,10005,'Otros',1,1,'2023-03-09 00:23:35',NULL,NULL,NULL);
/*!40000 ALTER TABLE `cactivities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `channels`
--

DROP TABLE IF EXISTS `channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `channels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `channels_user_created_id_foreign` (`user_created_id`),
  KEY `channels_user_updated_id_foreign` (`user_updated_id`),
  KEY `channels_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `channels_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `channels_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `channels_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channels`
--

LOCK TABLES `channels` WRITE;
/*!40000 ALTER TABLE `channels` DISABLE KEYS */;
INSERT INTO `channels` VALUES (1,'Chat',1,'2021-08-13 16:30:51',NULL,'2021-08-13 16:30:51',NULL,NULL),(2,'Email',1,'2021-08-13 16:30:56',NULL,'2021-08-13 16:30:56',NULL,NULL),(3,'Llamada',1,'2021-08-13 16:31:11',NULL,'2021-08-13 16:31:11',NULL,NULL),(4,'WhatsApp',1,'2021-08-13 16:31:24',NULL,'2021-08-13 16:31:24',NULL,NULL),(5,'Redes Sociales',1,'2021-08-13 16:31:35',NULL,'2021-08-13 16:31:35',NULL,NULL),(6,'Canal Interno',1,'2021-08-13 16:31:42',NULL,'2021-08-13 16:31:42',NULL,NULL),(7,'Directivo',1,'2021-08-13 16:32:12',NULL,'2021-08-13 16:32:12',NULL,NULL),(8,'Área IT',1,'2021-08-13 16:32:35',NULL,'2021-08-13 16:32:35',NULL,NULL),(9,'Front',36,'2022-02-23 14:34:24',NULL,'2022-02-23 14:34:24',NULL,NULL);
/*!40000 ALTER TABLE `channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `state_id` bigint unsigned NOT NULL,
  `abrev` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `capital` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_state_id_foreign` (`state_id`),
  CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=525 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,1,NULL,'Maroa',0),(2,1,NULL,'Puerto Ayacucho',0),(3,1,NULL,'San Fernando de Atabapo',0),(4,2,NULL,'Anaco',0),(5,2,NULL,'Aragua de Barcelona',0),(6,2,NULL,'Barcelona',0),(7,2,NULL,'Boca de Uchire',0),(8,2,NULL,'Cantaura',0),(9,2,NULL,'Clarines',0),(10,2,NULL,'El Chaparro',0),(11,2,NULL,'El Pao Anzoátegui',0),(12,2,NULL,'El Tigre',0),(13,2,NULL,'El Tigrito',0),(14,2,NULL,'Guanape',0),(15,2,NULL,'Guanta',0),(16,2,NULL,'Lechería',0),(17,2,NULL,'Onoto',0),(18,2,NULL,'Pariaguán',0),(19,2,NULL,'Píritu',0),(20,2,NULL,'Puerto La Cruz',0),(21,2,NULL,'Puerto Píritu',0),(22,2,NULL,'Sabana de Uchire',0),(23,2,NULL,'San Mateo Anzoátegui',0),(24,2,NULL,'San Pablo Anzoátegui',0),(25,2,NULL,'San Tomé',0),(26,2,NULL,'Santa Ana de Anzoátegui',0),(27,2,NULL,'Santa Fe Anzoátegui',0),(28,2,NULL,'Santa Rosa',0),(29,2,NULL,'Soledad',0),(30,2,NULL,'Urica',0),(31,2,NULL,'Valle de Guanape',0),(43,3,NULL,'Achaguas',0),(44,3,NULL,'Biruaca',0),(45,3,NULL,'Bruzual',0),(46,3,NULL,'El Amparo',0),(47,3,NULL,'El Nula',0),(48,3,NULL,'Elorza',0),(49,3,NULL,'Guasdualito',0),(50,3,NULL,'Mantecal',0),(51,3,NULL,'Puerto Páez',0),(52,3,NULL,'San Fernando de Apure',0),(53,3,NULL,'San Juan de Payara',0),(54,4,NULL,'Barbacoas',0),(55,4,NULL,'Cagua',0),(56,4,NULL,'Camatagua',0),(58,4,NULL,'Choroní',0),(59,4,NULL,'Colonia Tovar',0),(60,4,NULL,'El Consejo',0),(61,4,NULL,'La Victoria',0),(62,4,NULL,'Las Tejerías',0),(63,4,NULL,'Magdaleno',0),(64,4,NULL,'Maracay',0),(65,4,NULL,'Ocumare de La Costa',0),(66,4,NULL,'Palo Negro',0),(67,4,NULL,'San Casimiro',0),(68,4,NULL,'San Mateo',0),(69,4,NULL,'San Sebastián',0),(70,4,NULL,'Santa Cruz de Aragua',0),(71,4,NULL,'Tocorón',0),(72,4,NULL,'Turmero',0),(73,4,NULL,'Villa de Cura',0),(74,4,NULL,'Zuata',0),(75,5,NULL,'Barinas',0),(76,5,NULL,'Barinitas',0),(77,5,NULL,'Barrancas',0),(78,5,NULL,'Calderas',0),(79,5,NULL,'Capitanejo',0),(80,5,NULL,'Ciudad Bolivia',0),(81,5,NULL,'El Cantón',0),(82,5,NULL,'Las Veguitas',0),(83,5,NULL,'Libertad de Barinas',0),(84,5,NULL,'Sabaneta',0),(85,5,NULL,'Santa Bárbara de Barinas',0),(86,5,NULL,'Socopó',0),(87,6,NULL,'Caicara del Orinoco',0),(88,6,NULL,'Canaima',0),(89,6,NULL,'Ciudad Bolívar',0),(90,6,NULL,'Ciudad Piar',0),(91,6,NULL,'El Callao',0),(92,6,NULL,'El Dorado',0),(93,6,NULL,'El Manteco',0),(94,6,NULL,'El Palmar',0),(95,6,NULL,'El Pao',0),(96,6,NULL,'Guasipati',0),(97,6,NULL,'Guri',0),(98,6,NULL,'La Paragua',0),(99,6,NULL,'Matanzas',0),(100,6,NULL,'Puerto Ordaz',0),(101,6,NULL,'San Félix',0),(102,6,NULL,'Santa Elena de Uairén',0),(103,6,NULL,'Tumeremo',0),(104,6,NULL,'Unare',0),(105,6,NULL,'Upata',0),(106,7,NULL,'Bejuma',0),(107,7,NULL,'Belén',0),(108,7,NULL,'Campo de Carabobo',0),(109,7,NULL,'Canoabo',0),(110,7,NULL,'Central Tacarigua',0),(111,7,NULL,'Chirgua',0),(112,7,NULL,'Ciudad Alianza',0),(113,7,NULL,'El Palito',0),(114,7,NULL,'Guacara',0),(115,7,NULL,'Guigue',0),(116,7,NULL,'Las Trincheras',0),(117,7,NULL,'Los Guayos',0),(118,7,NULL,'Mariara',0),(119,7,NULL,'Miranda',0),(120,7,NULL,'Montalbán',0),(121,7,NULL,'Morón',0),(122,7,NULL,'Naguanagua',0),(123,7,NULL,'Puerto Cabello',0),(124,7,NULL,'San Joaquín',0),(125,7,NULL,'Tocuyito',0),(126,7,NULL,'Urama',0),(127,7,NULL,'Valencia',0),(128,7,NULL,'Vigirimita',0),(129,8,NULL,'Aguirre',0),(130,8,NULL,'Apartaderos Cojedes',0),(131,8,NULL,'Arismendi',0),(132,8,NULL,'Camuriquito',0),(133,8,NULL,'El Baúl',0),(134,8,NULL,'El Limón',0),(135,8,NULL,'El Pao Cojedes',0),(136,8,NULL,'El Socorro',0),(137,8,NULL,'La Aguadita',0),(138,8,NULL,'Las Vegas',0),(139,8,NULL,'Libertad de Cojedes',0),(140,8,NULL,'Mapuey',0),(141,8,NULL,'Piñedo',0),(142,8,NULL,'Samancito',0),(143,8,NULL,'San Carlos',0),(144,8,NULL,'Sucre',0),(145,8,NULL,'Tinaco',0),(146,8,NULL,'Tinaquillo',0),(147,8,NULL,'Vallecito',0),(148,9,NULL,'Tucupita',0),(149,24,NULL,'Caracas',0),(150,24,NULL,'El Junquito',0),(151,10,NULL,'Adícora',0),(152,10,NULL,'Boca de Aroa',0),(153,10,NULL,'Cabure',0),(154,10,NULL,'Capadare',0),(155,10,NULL,'Capatárida',0),(156,10,NULL,'Chichiriviche',0),(157,10,NULL,'Churuguara',0),(158,10,NULL,'Coro',0),(159,10,NULL,'Cumarebo',0),(160,10,NULL,'Dabajuro',0),(161,10,NULL,'Judibana',0),(162,10,NULL,'La Cruz de Taratara',0),(163,10,NULL,'La Vela de Coro',0),(164,10,NULL,'Los Taques',0),(165,10,NULL,'Maparari',0),(166,10,NULL,'Mene de Mauroa',0),(167,10,NULL,'Mirimire',0),(168,10,NULL,'Pedregal',0),(169,10,NULL,'Píritu Falcón',0),(170,10,NULL,'Pueblo Nuevo Falcón',0),(171,10,NULL,'Puerto Cumarebo',0),(172,10,NULL,'Punta Cardón',0),(173,10,NULL,'Punto Fijo',0),(174,10,NULL,'San Juan de Los Cayos',0),(175,10,NULL,'San Luis',0),(176,10,NULL,'Santa Ana Falcón',0),(177,10,NULL,'Santa Cruz De Bucaral',0),(178,10,NULL,'Tocopero',0),(179,10,NULL,'Tocuyo de La Costa',0),(180,10,NULL,'Tucacas',0),(181,10,NULL,'Yaracal',0),(182,11,NULL,'Altagracia de Orituco',0),(183,11,NULL,'Cabruta',0),(184,11,NULL,'Calabozo',0),(185,11,NULL,'Camaguán',0),(196,11,NULL,'Chaguaramas Guárico',0),(197,11,NULL,'El Socorro',0),(198,11,NULL,'El Sombrero',0),(199,11,NULL,'Las Mercedes de Los Llanos',0),(200,11,NULL,'Lezama',0),(201,11,NULL,'Onoto',0),(202,11,NULL,'Ortíz',0),(203,11,NULL,'San José de Guaribe',0),(204,11,NULL,'San Juan de Los Morros',0),(205,11,NULL,'San Rafael de Laya',0),(206,11,NULL,'Santa María de Ipire',0),(207,11,NULL,'Tucupido',0),(208,11,NULL,'Valle de La Pascua',0),(209,11,NULL,'Zaraza',0),(210,12,NULL,'Aguada Grande',0),(211,12,NULL,'Atarigua',0),(212,12,NULL,'Barquisimeto',0),(213,12,NULL,'Bobare',0),(214,12,NULL,'Cabudare',0),(215,12,NULL,'Carora',0),(216,12,NULL,'Cubiro',0),(217,12,NULL,'Cují',0),(218,12,NULL,'Duaca',0),(219,12,NULL,'El Manzano',0),(220,12,NULL,'El Tocuyo',0),(221,12,NULL,'Guaríco',0),(222,12,NULL,'Humocaro Alto',0),(223,12,NULL,'Humocaro Bajo',0),(224,12,NULL,'La Miel',0),(225,12,NULL,'Moroturo',0),(226,12,NULL,'Quíbor',0),(227,12,NULL,'Río Claro',0),(228,12,NULL,'Sanare',0),(229,12,NULL,'Santa Inés',0),(230,12,NULL,'Sarare',0),(231,12,NULL,'Siquisique',0),(232,12,NULL,'Tintorero',0),(233,13,NULL,'Apartaderos Mérida',0),(234,13,NULL,'Arapuey',0),(235,13,NULL,'Bailadores',0),(236,13,NULL,'Caja Seca',0),(237,13,NULL,'Canaguá',0),(238,13,NULL,'Chachopo',0),(239,13,NULL,'Chiguara',0),(240,13,NULL,'Ejido',0),(241,13,NULL,'El Vigía',0),(242,13,NULL,'La Azulita',0),(243,13,NULL,'La Playa',0),(244,13,NULL,'Lagunillas Mérida',0),(245,13,NULL,'Mérida',0),(246,13,NULL,'Mesa de Bolívar',0),(247,13,NULL,'Mucuchíes',0),(248,13,NULL,'Mucujepe',0),(249,13,NULL,'Mucuruba',0),(250,13,NULL,'Nueva Bolivia',0),(251,13,NULL,'Palmarito',0),(252,13,NULL,'Pueblo Llano',0),(253,13,NULL,'Santa Cruz de Mora',0),(254,13,NULL,'Santa Elena de Arenales',0),(255,13,NULL,'Santo Domingo',0),(256,13,NULL,'Tabáy',0),(257,13,NULL,'Timotes',0),(258,13,NULL,'Torondoy',0),(259,13,NULL,'Tovar',0),(260,13,NULL,'Tucani',0),(261,13,NULL,'Zea',0),(262,14,NULL,'Araguita',0),(263,14,NULL,'Carrizal',0),(264,14,NULL,'Caucagua',0),(265,14,NULL,'Chaguaramas Miranda',0),(266,14,NULL,'Charallave',0),(267,14,NULL,'Chirimena',0),(268,14,NULL,'Chuspa',0),(269,14,NULL,'Cúa',0),(270,14,NULL,'Cupira',0),(271,14,NULL,'Curiepe',0),(272,14,NULL,'El Guapo',0),(273,14,NULL,'El Jarillo',0),(274,14,NULL,'Filas de Mariche',0),(275,14,NULL,'Guarenas',0),(276,14,NULL,'Guatire',0),(277,14,NULL,'Higuerote',0),(278,14,NULL,'Los Anaucos',0),(279,14,NULL,'Los Teques',0),(280,14,NULL,'Ocumare del Tuy',0),(281,14,NULL,'Panaquire',0),(282,14,NULL,'Paracotos',0),(283,14,NULL,'Río Chico',0),(284,14,NULL,'San Antonio de Los Altos',0),(285,14,NULL,'San Diego de Los Altos',0),(286,14,NULL,'San Fernando del Guapo',0),(287,14,NULL,'San Francisco de Yare',0),(288,14,NULL,'San José de Los Altos',0),(289,14,NULL,'San José de Río Chico',0),(290,14,NULL,'San Pedro de Los Altos',0),(291,14,NULL,'Santa Lucía',0),(292,14,NULL,'Santa Teresa',0),(293,14,NULL,'Tacarigua de La Laguna',0),(294,14,NULL,'Tacarigua de Mamporal',0),(295,14,NULL,'Tácata',0),(296,14,NULL,'Turumo',0),(297,15,NULL,'Aguasay',0),(298,15,NULL,'Aragua de Maturín',0),(299,15,NULL,'Barrancas del Orinoco',0),(300,15,NULL,'Caicara de Maturín',0),(301,15,NULL,'Caripe',0),(302,15,NULL,'Caripito',0),(303,15,NULL,'Chaguaramal',0),(305,15,NULL,'Chaguaramas Monagas',0),(307,15,NULL,'El Furrial',0),(308,15,NULL,'El Tejero',0),(309,15,NULL,'Jusepín',0),(310,15,NULL,'La Toscana',0),(311,15,NULL,'Maturín',0),(312,15,NULL,'Miraflores',0),(313,15,NULL,'Punta de Mata',0),(314,15,NULL,'Quiriquire',0),(315,15,NULL,'San Antonio de Maturín',0),(316,15,NULL,'San Vicente Monagas',0),(317,15,NULL,'Santa Bárbara',0),(318,15,NULL,'Temblador',0),(319,15,NULL,'Teresen',0),(320,15,NULL,'Uracoa',0),(321,16,NULL,'Altagracia',0),(322,16,NULL,'Boca de Pozo',0),(323,16,NULL,'Boca de Río',0),(324,16,NULL,'El Espinal',0),(325,16,NULL,'El Valle del Espíritu Santo',0),(326,16,NULL,'El Yaque',0),(327,16,NULL,'Juangriego',0),(328,16,NULL,'La Asunción',0),(329,16,NULL,'La Guardia',0),(330,16,NULL,'Pampatar',0),(331,16,NULL,'Porlamar',0),(332,16,NULL,'Puerto Fermín',0),(333,16,NULL,'Punta de Piedras',0),(334,16,NULL,'San Francisco de Macanao',0),(335,16,NULL,'San Juan Bautista',0),(336,16,NULL,'San Pedro de Coche',0),(337,16,NULL,'Santa Ana de Nueva Esparta',0),(338,16,NULL,'Villa Rosa',0),(339,17,NULL,'Acarigua',0),(340,17,NULL,'Agua Blanca',0),(341,17,NULL,'Araure',0),(342,17,NULL,'Biscucuy',0),(343,17,NULL,'Boconoito',0),(344,17,NULL,'Campo Elías',0),(345,17,NULL,'Chabasquén',0),(346,17,NULL,'Guanare',0),(347,17,NULL,'Guanarito',0),(348,17,NULL,'La Aparición',0),(349,17,NULL,'La Misión',0),(350,17,NULL,'Mesa de Cavacas',0),(351,17,NULL,'Ospino',0),(352,17,NULL,'Papelón',0),(353,17,NULL,'Payara',0),(354,17,NULL,'Pimpinela',0),(355,17,NULL,'Píritu de Portuguesa',0),(356,17,NULL,'San Rafael de Onoto',0),(357,17,NULL,'Santa Rosalía',0),(358,17,NULL,'Turén',0),(359,18,NULL,'Altos de Sucre',0),(360,18,NULL,'Araya',0),(361,18,NULL,'Cariaco',0),(362,18,NULL,'Carúpano',0),(363,18,NULL,'Casanay',0),(364,18,NULL,'Cumaná',0),(365,18,NULL,'Cumanacoa',0),(366,18,NULL,'El Morro Puerto Santo',0),(367,18,NULL,'El Pilar',0),(368,18,NULL,'El Poblado',0),(369,18,NULL,'Guaca',0),(370,18,NULL,'Guiria',0),(371,18,NULL,'Irapa',0),(372,18,NULL,'Manicuare',0),(373,18,NULL,'Mariguitar',0),(374,18,NULL,'Río Caribe',0),(375,18,NULL,'San Antonio del Golfo',0),(376,18,NULL,'San José de Aerocuar',0),(377,18,NULL,'San Vicente de Sucre',0),(378,18,NULL,'Santa Fe de Sucre',0),(379,18,NULL,'Tunapuy',0),(380,18,NULL,'Yaguaraparo',0),(381,18,NULL,'Yoco',0),(382,19,NULL,'Abejales',0),(383,19,NULL,'Borota',0),(384,19,NULL,'Bramon',0),(385,19,NULL,'Capacho',0),(386,19,NULL,'Colón',0),(387,19,NULL,'Coloncito',0),(388,19,NULL,'Cordero',0),(389,19,NULL,'El Cobre',0),(390,19,NULL,'El Pinal',0),(391,19,NULL,'Independencia',0),(392,19,NULL,'La Fría',0),(393,19,NULL,'La Grita',0),(394,19,NULL,'La Pedrera',0),(395,19,NULL,'La Tendida',0),(396,19,NULL,'Las Delicias',0),(397,19,NULL,'Las Hernández',0),(398,19,NULL,'Lobatera',0),(399,19,NULL,'Michelena',0),(400,19,NULL,'Palmira',0),(401,19,NULL,'Pregonero',0),(402,19,NULL,'Queniquea',0),(403,19,NULL,'Rubio',0),(404,19,NULL,'San Antonio del Tachira',0),(405,19,NULL,'San Cristobal',0),(406,19,NULL,'San José de Bolívar',0),(407,19,NULL,'San Josecito',0),(408,19,NULL,'San Pedro del Río',0),(409,19,NULL,'Santa Ana Táchira',0),(410,19,NULL,'Seboruco',0),(411,19,NULL,'Táriba',0),(412,19,NULL,'Umuquena',0),(413,19,NULL,'Ureña',0),(414,20,NULL,'Batatal',0),(415,20,NULL,'Betijoque',0),(416,20,NULL,'Boconó',0),(417,20,NULL,'Carache',0),(418,20,NULL,'Chejende',0),(419,20,NULL,'Cuicas',0),(420,20,NULL,'El Dividive',0),(421,20,NULL,'El Jaguito',0),(422,20,NULL,'Escuque',0),(423,20,NULL,'Isnotú',0),(424,20,NULL,'Jajó',0),(425,20,NULL,'La Ceiba',0),(426,20,NULL,'La Concepción de Trujllo',0),(427,20,NULL,'La Mesa de Esnujaque',0),(428,20,NULL,'La Puerta',0),(429,20,NULL,'La Quebrada',0),(430,20,NULL,'Mendoza Fría',0),(431,20,NULL,'Meseta de Chimpire',0),(432,20,NULL,'Monay',0),(433,20,NULL,'Motatán',0),(434,20,NULL,'Pampán',0),(435,20,NULL,'Pampanito',0),(436,20,NULL,'Sabana de Mendoza',0),(437,20,NULL,'San Lázaro',0),(438,20,NULL,'Santa Ana de Trujillo',0),(439,20,NULL,'Tostós',0),(440,20,NULL,'Trujillo',0),(441,20,NULL,'Valera',0),(442,21,NULL,'Carayaca',0),(443,21,NULL,'Litoral',0),(444,25,NULL,'Archipiélago Los Roques',0),(445,22,NULL,'Aroa',0),(446,22,NULL,'Boraure',0),(447,22,NULL,'Campo Elías de Yaracuy',0),(448,22,NULL,'Chivacoa',0),(449,22,NULL,'Cocorote',0),(450,22,NULL,'Farriar',0),(451,22,NULL,'Guama',0),(452,22,NULL,'Marín',0),(453,22,NULL,'Nirgua',0),(454,22,NULL,'Sabana de Parra',0),(455,22,NULL,'Salom',0),(456,22,NULL,'San Felipe',0),(457,22,NULL,'San Pablo de Yaracuy',0),(458,22,NULL,'Urachiche',0),(459,22,NULL,'Yaritagua',0),(460,22,NULL,'Yumare',0),(461,23,NULL,'Bachaquero',0),(462,23,NULL,'Bobures',0),(463,23,NULL,'Cabimas',0),(464,23,NULL,'Campo Concepción',0),(465,23,NULL,'Campo Mara',0),(466,23,NULL,'Campo Rojo',0),(467,23,NULL,'Carrasquero',0),(468,23,NULL,'Casigua',0),(469,23,NULL,'Chiquinquirá',0),(470,23,NULL,'Ciudad Ojeda',0),(471,23,NULL,'El Batey',0),(472,23,NULL,'El Carmelo',0),(473,23,NULL,'El Chivo',0),(474,23,NULL,'El Guayabo',0),(475,23,NULL,'El Mene',0),(476,23,NULL,'El Venado',0),(477,23,NULL,'Encontrados',0),(478,23,NULL,'Gibraltar',0),(479,23,NULL,'Isla de Toas',0),(480,23,NULL,'La Concepción del Zulia',0),(481,23,NULL,'La Paz',0),(482,23,NULL,'La Sierrita',0),(483,23,NULL,'Lagunillas del Zulia',0),(484,23,NULL,'Las Piedras de Perijá',0),(485,23,NULL,'Los Cortijos',0),(486,23,NULL,'Machiques',0),(487,23,NULL,'Maracaibo',0),(488,23,NULL,'Mene Grande',0),(489,23,NULL,'Palmarejo',0),(490,23,NULL,'Paraguaipoa',0),(491,23,NULL,'Potrerito',0),(492,23,NULL,'Pueblo Nuevo del Zulia',0),(493,23,NULL,'Puertos de Altagracia',0),(494,23,NULL,'Punta Gorda',0),(495,23,NULL,'Sabaneta de Palma',0),(496,23,NULL,'San Francisco',0),(497,23,NULL,'San José de Perijá',0),(498,23,NULL,'San Rafael del Moján',0),(499,23,NULL,'San Timoteo',0),(500,23,NULL,'Santa Bárbara Del Zulia',0),(501,23,NULL,'Santa Cruz de Mara',0),(502,23,NULL,'Santa Cruz del Zulia',0),(503,23,NULL,'Santa Rita',0),(504,23,NULL,'Sinamaica',0),(505,23,NULL,'Tamare',0),(506,23,NULL,'Tía Juana',0),(507,23,NULL,'Villa del Rosario',0),(508,21,NULL,'La Guaira',0),(509,21,NULL,'Catia La Mar',0),(510,21,NULL,'Macuto',0),(511,21,NULL,'Naiguatá',0),(512,25,NULL,'Archipiélago Los Monjes',0),(513,25,NULL,'Isla La Tortuga y Cayos adyace',0),(514,25,NULL,'Isla La Sola',0),(515,25,NULL,'Islas Los Testigos',0),(516,25,NULL,'Islas Los Frailes',0),(517,25,NULL,'Isla La Orchila',0),(518,25,NULL,'Archipiélago Las Aves',0),(519,25,NULL,'Isla de Aves',0),(520,25,NULL,'Isla La Blanquilla',0),(521,25,NULL,'Isla de Patos',0),(522,25,NULL,'Islas Los Hermanos',0),(523,6,NULL,'Bolívar',0),(524,6,NULL,'Guayana',0);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collections`
--

DROP TABLE IF EXISTS `collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint unsigned NOT NULL,
  `invoiceitem_id` bigint unsigned DEFAULT NULL,
  `fechpro` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipnot` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `acconcept_id` bigint unsigned NOT NULL,
  `refere` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `dicom` double(15,2) NOT NULL,
  `amount_currency` double(15,2) NOT NULL,
  `amount` double(15,2) NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `collections_invoice_id_foreign` (`invoice_id`),
  KEY `collections_acconcept_id_foreign` (`acconcept_id`),
  KEY `collections_currency_id_foreign` (`currency_id`),
  KEY `collections_user_created_id_foreign` (`user_created_id`),
  KEY `collections_user_updated_id_foreign` (`user_updated_id`),
  KEY `collections_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `collections_acconcept_id_foreign` FOREIGN KEY (`acconcept_id`) REFERENCES `acconcepts` (`id`),
  CONSTRAINT `collections_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `collections_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  CONSTRAINT `collections_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `collections_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `collections_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collections`
--

LOCK TABLES `collections` WRITE;
/*!40000 ALTER TABLE `collections` DISABLE KEYS */;
/*!40000 ALTER TABLE `collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comissions`
--

DROP TABLE IF EXISTS `comissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type_conditions` enum('Tarifa','Porcentaje') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `range_ini1` int NOT NULL,
  `range_fin1` int NOT NULL,
  `value1` int NOT NULL,
  `range_ini2` int DEFAULT NULL,
  `range_fin2` int DEFAULT NULL,
  `value2` int DEFAULT NULL,
  `range_ini3` int DEFAULT NULL,
  `range_fin3` int DEFAULT NULL,
  `value3` int DEFAULT NULL,
  `range_ini4` int DEFAULT NULL,
  `range_fin4` int DEFAULT NULL,
  `value4` int DEFAULT NULL,
  `range_ini5` int DEFAULT NULL,
  `range_fin5` int DEFAULT NULL,
  `value5` int DEFAULT NULL,
  `amount_max` int DEFAULT NULL,
  `value_max` int DEFAULT NULL,
  `status` enum('Activo','Inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comissions_user_created_id_foreign` (`user_created_id`),
  KEY `comissions_user_updated_id_foreign` (`user_updated_id`),
  KEY `comissions_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `comissions_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `comissions_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `comissions_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comissions`
--

LOCK TABLES `comissions` WRITE;
/*!40000 ALTER TABLE `comissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `comissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` bigint unsigned DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `typecompany_id` bigint unsigned DEFAULT NULL,
  `is_wholesaler` tinyint(1) DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `companies_business_id_foreign` (`business_id`),
  KEY `companies_typecompany_id_foreign` (`typecompany_id`),
  KEY `companies_user_created_id_foreign` (`user_created_id`),
  KEY `companies_user_updated_id_foreign` (`user_updated_id`),
  KEY `companies_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `companies_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`),
  CONSTRAINT `companies_typecompany_id_foreign` FOREIGN KEY (`typecompany_id`) REFERENCES `typecompanies` (`id`),
  CONSTRAINT `companies_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `companies_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `companies_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,1,'Warehouse',1,0,1,NULL,'2021-01-26 13:43:24','2021-01-26 13:43:24',NULL,NULL);
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `concepts`
--

DROP TABLE IF EXISTS `concepts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `concepts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `abrev` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `concepts_user_created_id_foreign` (`user_created_id`),
  KEY `concepts_user_updated_id_foreign` (`user_updated_id`),
  KEY `concepts_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `concepts_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `concepts_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `concepts_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `concepts`
--

LOCK TABLES `concepts` WRITE;
/*!40000 ALTER TABLE `concepts` DISABLE KEYS */;
INSERT INTO `concepts` VALUES (1,'Ventas','Ventas',1,NULL,'2021-02-09 15:59:27','2021-02-09 15:59:27',NULL,NULL),(2,'Serv','Servicios Transaccionales',1,NULL,'2021-04-15 09:43:17','2021-04-15 09:43:19',NULL,NULL);
/*!40000 ALTER TABLE `concepts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consecutives`
--

DROP TABLE IF EXISTS `consecutives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consecutives` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fechpro` date DEFAULT NULL,
  `bank_id` bigint unsigned DEFAULT NULL,
  `invoice_id` bigint unsigned DEFAULT NULL,
  `consecutive` bigint unsigned DEFAULT NULL,
  `is_management` tinyint(1) DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consecutives_user_created_id_foreign` (`user_created_id`),
  KEY `consecutives_invoice_id_foreign` (`invoice_id`),
  KEY `consecutives_bank_id_foreign` (`bank_id`),
  CONSTRAINT `consecutives_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `consecutives_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  CONSTRAINT `consecutives_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consecutives`
--

LOCK TABLES `consecutives` WRITE;
/*!40000 ALTER TABLE `consecutives` DISABLE KEYS */;
/*!40000 ALTER TABLE `consecutives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultants`
--

DROP TABLE IF EXISTS `consultants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consultants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `document_number` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rif` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Activo','Inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consultants_user_id_foreign` (`user_id`),
  KEY `consultants_user_created_id_foreign` (`user_created_id`),
  KEY `consultants_user_updated_id_foreign` (`user_updated_id`),
  KEY `consultants_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `consultants_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `consultants_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `consultants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `consultants_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultants`
--

LOCK TABLES `consultants` WRITE;
/*!40000 ALTER TABLE `consultants` DISABLE KEYS */;
INSERT INTO `consultants` VALUES (1,1,'J-00000000','J-00000000-0','name','lastname','email@email.com','observation','zone','0000-0000000','Activo',1,1,'2021-02-08 08:51:04','2021-08-24 12:49:45',NULL,NULL);
/*!40000 ALTER TABLE `consultants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contracts`
--

DROP TABLE IF EXISTS `contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contracts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `type_dcustomer` enum('commerce','multicommerce','nodom') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dcustomer_id` bigint unsigned NOT NULL,
  `dcustomer_multiple` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint unsigned NOT NULL,
  `modelterminal_id` bigint unsigned NOT NULL,
  `terminal_id` bigint unsigned DEFAULT NULL,
  `valid_simcard` tinyint(1) DEFAULT NULL,
  `operator_id` bigint unsigned DEFAULT NULL,
  `simcard_id` bigint unsigned DEFAULT NULL,
  `term_id` bigint unsigned DEFAULT NULL,
  `nropos` int DEFAULT NULL,
  `observation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` bigint unsigned DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `file_document` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('Pendiente','Activo','Soporte','Cancelado','Suspendido','Anulado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reactive_date` datetime DEFAULT NULL,
  `consultant_id` bigint unsigned DEFAULT NULL,
  `is_delivery` tinyint(1) DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `is_affiliate` tinyint(1) DEFAULT NULL,
  `affiliate_date` datetime DEFAULT NULL,
  `delivery_process` tinyint(1) DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_posted_id` bigint unsigned DEFAULT NULL,
  `posted_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contracts_customer_id_foreign` (`customer_id`),
  KEY `contracts_dcustomer_id_foreign` (`dcustomer_id`),
  KEY `contracts_company_id_foreign` (`company_id`),
  KEY `contracts_modelterminal_id_foreign` (`modelterminal_id`),
  KEY `contracts_terminal_id_foreign` (`terminal_id`),
  KEY `contracts_operator_id_foreign` (`operator_id`),
  KEY `contracts_simcard_id_foreign` (`simcard_id`),
  KEY `contracts_term_id_foreign` (`term_id`),
  KEY `contracts_currency_id_foreign` (`currency_id`),
  KEY `contracts_consultant_id_foreign` (`consultant_id`),
  KEY `contracts_user_created_id_foreign` (`user_created_id`),
  KEY `contracts_user_updated_id_foreign` (`user_updated_id`),
  KEY `contracts_user_posted_id_foreign` (`user_posted_id`),
  KEY `contracts_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `contracts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `contracts_consultant_id_foreign` FOREIGN KEY (`consultant_id`) REFERENCES `consultants` (`id`),
  CONSTRAINT `contracts_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `contracts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `contracts_dcustomer_id_foreign` FOREIGN KEY (`dcustomer_id`) REFERENCES `dcustomers` (`id`),
  CONSTRAINT `contracts_modelterminal_id_foreign` FOREIGN KEY (`modelterminal_id`) REFERENCES `modelterminal` (`id`),
  CONSTRAINT `contracts_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`),
  CONSTRAINT `contracts_simcard_id_foreign` FOREIGN KEY (`simcard_id`) REFERENCES `simcards` (`id`),
  CONSTRAINT `contracts_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`),
  CONSTRAINT `contracts_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`),
  CONSTRAINT `contracts_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `contracts_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `contracts_user_posted_id_foreign` FOREIGN KEY (`user_posted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `contracts_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contracts`
--

LOCK TABLES `contracts` WRITE;
/*!40000 ALTER TABLE `contracts` DISABLE KEYS */;

/*!40000 ALTER TABLE `contracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `csupports`
--

DROP TABLE IF EXISTS `csupports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `csupports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contract_id` bigint unsigned DEFAULT NULL,
  `type_support` enum('invoice','customer','contract') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observation_response` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('G','F','X') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `csupports_contract_id_foreign` (`contract_id`),
  KEY `csupports_user_created_id_foreign` (`user_created_id`),
  KEY `csupports_user_updated_id_foreign` (`user_updated_id`),
  KEY `csupports_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `csupports_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `csupports_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `csupports_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `csupports_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `csupports`
--

LOCK TABLES `csupports` WRITE;
/*!40000 ALTER TABLE `csupports` DISABLE KEYS */;
/*!40000 ALTER TABLE `csupports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currencies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `abrev` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `currencies_user_created_id_foreign` (`user_created_id`),
  KEY `currencies_user_updated_id_foreign` (`user_updated_id`),
  KEY `currencies_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `currencies_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `currencies_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `currencies_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1,'Bs.','Bolivares',1,NULL,'2021-01-26 13:00:38','2021-01-26 13:00:38',NULL,NULL),(2,'USD','Dolar',1,NULL,'2021-01-26 13:00:49','2021-01-26 13:00:49',NULL,NULL),(3,'USD/BS','Mixto',1,NULL,'2021-03-04 08:58:58','2021-03-04 08:59:47',1,'2021-03-04 08:59:47');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencyvalues`
--

DROP TABLE IF EXISTS `currencyvalues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currencyvalues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date_value` date NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `currencyvalues_currency_id_foreign` (`currency_id`),
  KEY `currencyvalues_user_created_id_foreign` (`user_created_id`),
  KEY `currencyvalues_user_updated_id_foreign` (`user_updated_id`),
  KEY `currencyvalues_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `currencyvalues_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `currencyvalues_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `currencyvalues_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `currencyvalues_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencyvalues`
--

LOCK TABLES `currencyvalues` WRITE;
/*!40000 ALTER TABLE `currencyvalues` DISABLE KEYS */;

/*!40000 ALTER TABLE `currencyvalues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `foreign_id` bigint unsigned DEFAULT NULL,
  `company_id` bigint unsigned DEFAULT NULL,
  `rif` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_cont` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` int DEFAULT NULL,
  `business_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cactivity_id` bigint unsigned DEFAULT NULL,
  `state_id` bigint unsigned DEFAULT NULL,
  `city_id` bigint unsigned DEFAULT NULL,
  `municipality` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fiscal` tinyint(1) DEFAULT NULL,
  `state_fiscal_id` bigint unsigned DEFAULT NULL,
  `city_fiscal_id` bigint unsigned DEFAULT NULL,
  `municipality_fiscal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_fiscal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code_fiscal` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_register` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comercial_register` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_register` datetime DEFAULT NULL,
  `number_register` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `took_register` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clause_register` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_document` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_cactivity_id_foreign` (`cactivity_id`),
  KEY `customers_company_id_foreign` (`company_id`),
  KEY `customers_state_id_foreign` (`state_id`),
  KEY `customers_city_id_foreign` (`city_id`),
  KEY `customers_state_fiscal_id_foreign` (`state_fiscal_id`),
  KEY `customers_city_fiscal_id_foreign` (`city_fiscal_id`),
  KEY `customers_user_created_id_foreign` (`user_created_id`),
  KEY `customers_user_updated_id_foreign` (`user_updated_id`),
  KEY `customers_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `customers_cactivity_id_foreign` FOREIGN KEY (`cactivity_id`) REFERENCES `cactivities` (`id`),
  CONSTRAINT `customers_city_fiscal_id_foreign` FOREIGN KEY (`city_fiscal_id`) REFERENCES `cities` (`id`),
  CONSTRAINT `customers_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  CONSTRAINT `customers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `customers_state_fiscal_id_foreign` FOREIGN KEY (`state_fiscal_id`) REFERENCES `states` (`id`),
  CONSTRAINT `customers_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  CONSTRAINT `customers_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `customers_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `customers_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dcustomers`
--

DROP TABLE IF EXISTS `dcustomers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dcustomers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `rif` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `multicommerce` tinyint(1) DEFAULT NULL,
  `bank_id` bigint unsigned NOT NULL,
  `affiliate_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_account` enum('Corriente','Ahorro') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid_bank` tinyint(1) DEFAULT '0',
  `personal_signature` tinyint(1) DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dcustomers_customer_id_foreign` (`customer_id`),
  KEY `dcustomers_bank_id_foreign` (`bank_id`),
  KEY `dcustomers_user_created_id_foreign` (`user_created_id`),
  KEY `dcustomers_user_updated_id_foreign` (`user_updated_id`),
  KEY `dcustomers_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `dcustomers_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  CONSTRAINT `dcustomers_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `dcustomers_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `dcustomers_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `dcustomers_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dcustomers`
--

LOCK TABLES `dcustomers` WRITE;
/*!40000 ALTER TABLE `dcustomers` DISABLE KEYS */;

/*!40000 ALTER TABLE `dcustomers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domiciliations`
--

DROP TABLE IF EXISTS `domiciliations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `domiciliations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bank_id` bigint unsigned DEFAULT NULL,
  `amount_currency_old` double(15,2) DEFAULT NULL,
  `amount_currency` double(15,2) DEFAULT NULL,
  `type_management` enum('Diario','Masivo','Morosidad') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_ini` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `file_bank` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file_response_bank` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `send_email` tinyint(1) DEFAULT NULL,
  `data_email` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date_operation` datetime DEFAULT NULL,
  `status` enum('Generado','Enviado','Procesando','Procesado','Cargado','Anulado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_send_id` bigint unsigned DEFAULT NULL,
  `send_at` datetime DEFAULT NULL,
  `user_upload_id` bigint unsigned DEFAULT NULL,
  `upload_at` datetime DEFAULT NULL,
  `user_process_id` bigint unsigned DEFAULT NULL,
  `process_at` datetime DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `total_processed` int DEFAULT NULL,
  `total_pending` int DEFAULT NULL,
  `total_amount_pending` double(15,2) DEFAULT NULL,
  `total_amount_processed` double(15,2) DEFAULT NULL,
  `total_amount_register` double(15,2) DEFAULT NULL,
  `total_register` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `domiciliations_bank_id_foreign` (`bank_id`),
  KEY `domiciliations_user_created_id_foreign` (`user_created_id`),
  KEY `domiciliations_user_updated_id_foreign` (`user_updated_id`),
  KEY `domiciliations_user_deleted_id_foreign` (`user_deleted_id`),
  KEY `domiciliations_user_send_id_foreign` (`user_send_id`),
  KEY `domiciliations_user_process_id_foreign` (`user_process_id`),
  CONSTRAINT `domiciliations_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  CONSTRAINT `domiciliations_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `domiciliations_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `domiciliations_user_process_id_foreign` FOREIGN KEY (`user_process_id`) REFERENCES `users` (`id`),
  CONSTRAINT `domiciliations_user_send_id_foreign` FOREIGN KEY (`user_send_id`) REFERENCES `users` (`id`),
  CONSTRAINT `domiciliations_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domiciliations`
--

LOCK TABLES `domiciliations` WRITE;
/*!40000 ALTER TABLE `domiciliations` DISABLE KEYS */;
/*!40000 ALTER TABLE `domiciliations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forecasts`
--

DROP TABLE IF EXISTS `forecasts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forecasts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contract_id` bigint unsigned DEFAULT NULL,
  `receipt_journey` int DEFAULT NULL,
  `bank_id` bigint unsigned DEFAULT NULL,
  `refere` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechpro` datetime DEFAULT NULL,
  `tipcta` enum('C','A') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `concept_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `rif` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nrocta` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nropos` int DEFAULT NULL,
  `tipnot` enum('Efectivo','Parcial','Deposito','Transferencia','Postpago','Convenio','DTE','Estandar','Financiamiento','Comodato','Banplus','Cero') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `type_sale` enum('basic','journey','discount') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` bigint unsigned DEFAULT NULL,
  `amount` double(15,2) DEFAULT NULL,
  `free` double(15,2) DEFAULT NULL,
  `amount_currency` double(15,2) DEFAULT NULL,
  `frec_invoice` enum('D','Q','M') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quota` int DEFAULT NULL,
  `lote` int DEFAULT NULL,
  `conceptc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `conciliation_doc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('G','C','R','P','X') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `forecasts_bank_id_foreign` (`bank_id`),
  KEY `forecasts_concept_id_foreign` (`concept_id`),
  KEY `forecasts_customer_id_foreign` (`customer_id`),
  KEY `forecasts_contract_id_foreign` (`contract_id`),
  KEY `forecasts_currency_id_foreign` (`currency_id`),
  KEY `forecasts_user_created_id_foreign` (`user_created_id`),
  KEY `forecasts_user_updated_id_foreign` (`user_updated_id`),
  KEY `forecasts_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `forecasts_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  CONSTRAINT `forecasts_concept_id_foreign` FOREIGN KEY (`concept_id`) REFERENCES `concepts` (`id`),
  CONSTRAINT `forecasts_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `forecasts_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `forecasts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `forecasts_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `forecasts_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `forecasts_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forecasts`
--

LOCK TABLES `forecasts` WRITE;
/*!40000 ALTER TABLE `forecasts` DISABLE KEYS */;
/*!40000 ALTER TABLE `forecasts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoiceitems`
--

DROP TABLE IF EXISTS `invoiceitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoiceitems` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint unsigned DEFAULT NULL,
  `invoiceitem_id` bigint unsigned DEFAULT NULL,
  `fechpro` date DEFAULT NULL,
  `currency_id` bigint unsigned DEFAULT NULL,
  `item` int DEFAULT NULL,
  `concept` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(15,2) DEFAULT NULL,
  `amount_currency` double(15,2) DEFAULT NULL,
  `date_expire` date DEFAULT NULL,
  `status` enum('G','C','R','P','X') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoiceitems_invoice_id_foreign` (`invoice_id`),
  KEY `invoiceitems_currency_id_foreign` (`currency_id`),
  KEY `invoiceitems_user_created_id_foreign` (`user_created_id`),
  KEY `invoiceitems_user_updated_id_foreign` (`user_updated_id`),
  KEY `invoiceitems_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `invoiceitems_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `invoiceitems_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  CONSTRAINT `invoiceitems_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `invoiceitems_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `invoiceitems_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoiceitems`
--

LOCK TABLES `invoiceitems` WRITE;
/*!40000 ALTER TABLE `invoiceitems` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoiceitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contract_id` bigint unsigned DEFAULT NULL,
  `receipt_journey` int DEFAULT NULL,
  `bank_id` bigint unsigned DEFAULT NULL,
  `refere` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fechpro` datetime DEFAULT NULL,
  `tipcta` enum('C','A') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `concept_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `rif` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nrocta` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nropos` int DEFAULT NULL,
  `tipnot` enum('Efectivo','Deposito','Transferencia','DTE','Custodia','Postpago','Estandar') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `type_sale` enum('basic') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` bigint unsigned DEFAULT NULL,
  `amount` double(15,2) DEFAULT NULL,
  `free` double(15,2) DEFAULT NULL,
  `amount_currency` double(15,2) DEFAULT NULL,
  `frec_invoice` enum('D','Q','M') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quota` int DEFAULT NULL,
  `lote` int DEFAULT NULL,
  `conceptc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `conciliation_doc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('G','P','C','R','E','N','X') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoices_bank_id_foreign` (`bank_id`),
  KEY `invoices_concept_id_foreign` (`concept_id`),
  KEY `invoices_customer_id_foreign` (`customer_id`),
  KEY `invoices_contract_id_foreign` (`contract_id`),
  KEY `invoices_currency_id_foreign` (`currency_id`),
  KEY `invoices_user_created_id_foreign` (`user_created_id`),
  KEY `invoices_user_updated_id_foreign` (`user_updated_id`),
  KEY `invoices_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `invoices_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  CONSTRAINT `invoices_concept_id_foreign` FOREIGN KEY (`concept_id`) REFERENCES `concepts` (`id`),
  CONSTRAINT `invoices_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `invoices_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `invoices_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `invoices_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `invoices_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;

/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `managementtypes`
--

DROP TABLE IF EXISTS `managementtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `managementtypes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `managementtypes_user_created_id_foreign` (`user_created_id`),
  KEY `managementtypes_user_updated_id_foreign` (`user_updated_id`),
  KEY `managementtypes_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `managementtypes_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `managementtypes_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `managementtypes_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `managementtypes`
--

LOCK TABLES `managementtypes` WRITE;
/*!40000 ALTER TABLE `managementtypes` DISABLE KEYS */;
INSERT INTO `managementtypes` VALUES (1,'internal','Gestión ATC',1,'2021-08-13 16:15:35',NULL,'2021-08-13 16:15:35',NULL,NULL),(2,'supports','Gestión Servicio Técnico',1,'2021-08-13 16:15:59',NULL,'2021-08-13 16:15:59',NULL,NULL),(3,'invoices','Gestión Cobranzas',1,'2022-02-23 14:34:42',36,'2022-02-23 14:34:42',NULL,NULL),(4,'developer','Gestión Soporte Bancario -  Eureka',1,'2021-08-13 21:34:28',1,'2021-08-13 16:34:28',NULL,NULL),(5,'sales','Gestión Ventas',1,'2021-08-13 16:19:47',NULL,'2021-08-13 16:19:47',NULL,NULL),(6,'operations','Gestión Operaciones',1,'2021-11-22 20:51:47',31,'2021-11-22 20:51:47',NULL,NULL);
/*!40000 ALTER TABLE `managementtypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marks`
--

DROP TABLE IF EXISTS `marks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `marks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `marks_user_created_id_foreign` (`user_created_id`),
  KEY `marks_user_updated_id_foreign` (`user_updated_id`),
  KEY `marks_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `marks_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `marks_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `marks_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marks`
--

LOCK TABLES `marks` WRITE;
/*!40000 ALTER TABLE `marks` DISABLE KEYS */;
INSERT INTO `marks` VALUES (1,'Nexgo',1,NULL,'2021-01-26 13:06:16','2021-01-26 13:06:16',NULL,NULL),(2,'FlexiPOS',1,NULL,'2021-01-26 13:06:50','2021-01-26 13:06:50',NULL,NULL),(3,'Ingenico',1,NULL,'2021-01-26 13:06:56','2021-01-26 13:06:56',NULL,NULL),(4,'TECHPOS',1,22,'2021-03-11 15:07:49','2021-06-01 13:04:05',NULL,NULL),(5,'TopWise',31,1,'2021-03-19 13:29:10','2021-03-26 15:34:28',NULL,NULL),(6,'Techpos',NULL,NULL,NULL,NULL,NULL,NULL),(7,'SUNMI',22,NULL,'2021-09-10 10:58:41','2021-09-10 10:58:41',NULL,NULL),(8,'WisarPos',21,NULL,'2021-10-11 19:22:23','2021-10-11 19:22:23',NULL,NULL);
/*!40000 ALTER TABLE `marks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modelterminal`
--

DROP TABLE IF EXISTS `modelterminal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modelterminal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mark_id` bigint unsigned NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modelterminal_mark_id_foreign` (`mark_id`),
  KEY `modelterminal_user_created_id_foreign` (`user_created_id`),
  KEY `modelterminal_user_updated_id_foreign` (`user_updated_id`),
  KEY `modelterminal_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `modelterminal_mark_id_foreign` FOREIGN KEY (`mark_id`) REFERENCES `marks` (`id`),
  CONSTRAINT `modelterminal_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `modelterminal_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `modelterminal_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modelterminal`
--

LOCK TABLES `modelterminal` WRITE;
/*!40000 ALTER TABLE `modelterminal` DISABLE KEYS */;
INSERT INTO `modelterminal` VALUES (1,1,'K300 - Wireless POS Terminal',0,1,NULL,'2021-01-28 11:07:57','2021-01-28 11:07:57',NULL,NULL);
/*!40000 ALTER TABLE `modelterminal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Modules\\Users\\Models\\User',1),(2,'App\\Modules\\Users\\Models\\User',2),(2,'App\\Modules\\Users\\Models\\User',3),(24,'App\\Modules\\Users\\Models\\User',4),(3,'App\\Modules\\Users\\Models\\User',5),(2,'App\\Modules\\Users\\Models\\User',6),(2,'App\\Modules\\Users\\Models\\User',7),(2,'App\\Modules\\Users\\Models\\User',8),(2,'App\\Modules\\Users\\Models\\User',9),(2,'App\\Modules\\Users\\Models\\User',10),(2,'App\\Modules\\Users\\Models\\User',11),(2,'App\\Modules\\Users\\Models\\User',12),(2,'App\\Modules\\Users\\Models\\User',13),(2,'App\\Modules\\Users\\Models\\User',14),(2,'App\\Modules\\Users\\Models\\User',15),(2,'App\\Modules\\Users\\Models\\User',16),(2,'App\\Modules\\Users\\Models\\User',17),(2,'App\\Modules\\Users\\Models\\User',18),(2,'App\\Modules\\Users\\Models\\User',19),(5,'App\\Modules\\Users\\Models\\User',20),(1,'App\\Modules\\Users\\Models\\User',21),(8,'App\\Modules\\Users\\Models\\User',22),(6,'App\\Modules\\Users\\Models\\User',23),(2,'App\\Modules\\Users\\Models\\User',24),(24,'App\\Modules\\Users\\Models\\User',25),(8,'App\\Modules\\Users\\Models\\User',26),(2,'App\\Modules\\Users\\Models\\User',27),(1,'App\\Modules\\Users\\Models\\User',28),(1,'App\\Modules\\Users\\Models\\User',29),(19,'App\\Modules\\Users\\Models\\User',30),(1,'App\\Modules\\Users\\Models\\User',31),(8,'App\\Modules\\Users\\Models\\User',32),(3,'App\\Modules\\Users\\Models\\User',33),(9,'App\\Modules\\Users\\Models\\User',34),(2,'App\\Modules\\Users\\Models\\User',35),(1,'App\\Modules\\Users\\Models\\User',36),(2,'App\\Modules\\Users\\Models\\User',37),(2,'App\\Modules\\Users\\Models\\User',38),(3,'App\\Modules\\Users\\Models\\User',39),(1,'App\\Modules\\Users\\Models\\User',40),(3,'App\\Modules\\Users\\Models\\User',41),(1,'App\\Modules\\Users\\Models\\User',42),(2,'App\\Modules\\Users\\Models\\User',43),(10,'App\\Modules\\Users\\Models\\User',44),(2,'App\\Modules\\Users\\Models\\User',45),(1,'App\\Modules\\Users\\Models\\User',46),(1,'App\\Modules\\Users\\Models\\User',47),(8,'App\\Modules\\Users\\Models\\User',48),(10,'App\\Modules\\Users\\Models\\User',49),(2,'App\\Modules\\Users\\Models\\User',50),(2,'App\\Modules\\Users\\Models\\User',51),(2,'App\\Modules\\Users\\Models\\User',52),(2,'App\\Modules\\Users\\Models\\User',53),(2,'App\\Modules\\Users\\Models\\User',54),(2,'App\\Modules\\Users\\Models\\User',55),(2,'App\\Modules\\Users\\Models\\User',56),(2,'App\\Modules\\Users\\Models\\User',57),(2,'App\\Modules\\Users\\Models\\User',58),(2,'App\\Modules\\Users\\Models\\User',59),(2,'App\\Modules\\Users\\Models\\User',60),(1,'App\\Modules\\Users\\Models\\User',61),(2,'App\\Modules\\Users\\Models\\User',62),(2,'App\\Modules\\Users\\Models\\User',63),(2,'App\\Modules\\Users\\Models\\User',64),(2,'App\\Modules\\Users\\Models\\User',65),(2,'App\\Modules\\Users\\Models\\User',66),(2,'App\\Modules\\Users\\Models\\User',67),(2,'App\\Modules\\Users\\Models\\User',68),(2,'App\\Modules\\Users\\Models\\User',69),(2,'App\\Modules\\Users\\Models\\User',70),(2,'App\\Modules\\Users\\Models\\User',71),(2,'App\\Modules\\Users\\Models\\User',72),(2,'App\\Modules\\Users\\Models\\User',73),(2,'App\\Modules\\Users\\Models\\User',74),(2,'App\\Modules\\Users\\Models\\User',75),(2,'App\\Modules\\Users\\Models\\User',76),(2,'App\\Modules\\Users\\Models\\User',77),(24,'App\\Modules\\Users\\Models\\User',78),(1,'App\\Modules\\Users\\Models\\User',79),(2,'App\\Modules\\Users\\Models\\User',80),(2,'App\\Modules\\Users\\Models\\User',81),(7,'App\\Modules\\Users\\Models\\User',82),(2,'App\\Modules\\Users\\Models\\User',83),(12,'App\\Modules\\Users\\Models\\User',84),(11,'App\\Modules\\Users\\Models\\User',85),(2,'App\\Modules\\Users\\Models\\User',86),(2,'App\\Modules\\Users\\Models\\User',87),(2,'App\\Modules\\Users\\Models\\User',88),(2,'App\\Modules\\Users\\Models\\User',89),(2,'App\\Modules\\Users\\Models\\User',90),(2,'App\\Modules\\Users\\Models\\User',91),(2,'App\\Modules\\Users\\Models\\User',92),(2,'App\\Modules\\Users\\Models\\User',93),(2,'App\\Modules\\Users\\Models\\User',94),(2,'App\\Modules\\Users\\Models\\User',95),(2,'App\\Modules\\Users\\Models\\User',96),(2,'App\\Modules\\Users\\Models\\User',97),(1,'App\\Modules\\Users\\Models\\User',98),(6,'App\\Modules\\Users\\Models\\User',99),(2,'App\\Modules\\Users\\Models\\User',100),(8,'App\\Modules\\Users\\Models\\User',101),(13,'App\\Modules\\Users\\Models\\User',102),(8,'App\\Modules\\Users\\Models\\User',103),(11,'App\\Modules\\Users\\Models\\User',104),(2,'App\\Modules\\Users\\Models\\User',105),(24,'App\\Modules\\Users\\Models\\User',106),(2,'App\\Modules\\Users\\Models\\User',107),(2,'App\\Modules\\Users\\Models\\User',108),(8,'App\\Modules\\Users\\Models\\User',109),(7,'App\\Modules\\Users\\Models\\User',110),(12,'App\\Modules\\Users\\Models\\User',111),(21,'App\\Modules\\Users\\Models\\User',112),(20,'App\\Modules\\Users\\Models\\User',113),(2,'App\\Modules\\Users\\Models\\User',114),(2,'App\\Modules\\Users\\Models\\User',115),(2,'App\\Modules\\Users\\Models\\User',116),(2,'App\\Modules\\Users\\Models\\User',117),(2,'App\\Modules\\Users\\Models\\User',118),(8,'App\\Modules\\Users\\Models\\User',119),(1,'App\\Modules\\Users\\Models\\User',120),(11,'App\\Modules\\Users\\Models\\User',121),(8,'App\\Modules\\Users\\Models\\User',122),(2,'App\\Modules\\Users\\Models\\User',123),(2,'App\\Modules\\Users\\Models\\User',124),(5,'App\\Modules\\Users\\Models\\User',125),(7,'App\\Modules\\Users\\Models\\User',126),(14,'App\\Modules\\Users\\Models\\User',127),(1,'App\\Modules\\Users\\Models\\User',128),(2,'App\\Modules\\Users\\Models\\User',129),(2,'App\\Modules\\Users\\Models\\User',130),(2,'App\\Modules\\Users\\Models\\User',131),(12,'App\\Modules\\Users\\Models\\User',132),(2,'App\\Modules\\Users\\Models\\User',133),(2,'App\\Modules\\Users\\Models\\User',134),(2,'App\\Modules\\Users\\Models\\User',135),(2,'App\\Modules\\Users\\Models\\User',136),(21,'App\\Modules\\Users\\Models\\User',137),(21,'App\\Modules\\Users\\Models\\User',138),(3,'App\\Modules\\Users\\Models\\User',139),(21,'App\\Modules\\Users\\Models\\User',140),(11,'App\\Modules\\Users\\Models\\User',141),(8,'App\\Modules\\Users\\Models\\User',142),(2,'App\\Modules\\Users\\Models\\User',143),(11,'App\\Modules\\Users\\Models\\User',144),(11,'App\\Modules\\Users\\Models\\User',145),(11,'App\\Modules\\Users\\Models\\User',146),(1,'App\\Modules\\Users\\Models\\User',147),(1,'App\\Modules\\Users\\Models\\User',148),(3,'App\\Modules\\Users\\Models\\User',149),(3,'App\\Modules\\Users\\Models\\User',150),(25,'App\\Modules\\Users\\Models\\User',151),(26,'App\\Modules\\Users\\Models\\User',152),(11,'App\\Modules\\Users\\Models\\User',153),(1,'App\\Modules\\Users\\Models\\User',155),(2,'App\\Modules\\Users\\Models\\User',156),(11,'App\\Modules\\Users\\Models\\User',157),(3,'App\\Modules\\Users\\Models\\User',158),(2,'App\\Modules\\Users\\Models\\User',159),(2,'App\\Modules\\Users\\Models\\User',160),(2,'App\\Modules\\Users\\Models\\User',161),(2,'App\\Modules\\Users\\Models\\User',162),(2,'App\\Modules\\Users\\Models\\User',163),(2,'App\\Modules\\Users\\Models\\User',164),(2,'App\\Modules\\Users\\Models\\User',165),(2,'App\\Modules\\Users\\Models\\User',166),(2,'App\\Modules\\Users\\Models\\User',167),(2,'App\\Modules\\Users\\Models\\User',168),(2,'App\\Modules\\Users\\Models\\User',169),(2,'App\\Modules\\Users\\Models\\User',170),(2,'App\\Modules\\Users\\Models\\User',171),(2,'App\\Modules\\Users\\Models\\User',172),(2,'App\\Modules\\Users\\Models\\User',173),(2,'App\\Modules\\Users\\Models\\User',174),(2,'App\\Modules\\Users\\Models\\User',175),(2,'App\\Modules\\Users\\Models\\User',176),(2,'App\\Modules\\Users\\Models\\User',177),(2,'App\\Modules\\Users\\Models\\User',178),(2,'App\\Modules\\Users\\Models\\User',179),(2,'App\\Modules\\Users\\Models\\User',180),(2,'App\\Modules\\Users\\Models\\User',181),(2,'App\\Modules\\Users\\Models\\User',182),(2,'App\\Modules\\Users\\Models\\User',183),(2,'App\\Modules\\Users\\Models\\User',184),(2,'App\\Modules\\Users\\Models\\User',185),(2,'App\\Modules\\Users\\Models\\User',186),(2,'App\\Modules\\Users\\Models\\User',187),(2,'App\\Modules\\Users\\Models\\User',188),(2,'App\\Modules\\Users\\Models\\User',189),(2,'App\\Modules\\Users\\Models\\User',190),(2,'App\\Modules\\Users\\Models\\User',191),(2,'App\\Modules\\Users\\Models\\User',192),(2,'App\\Modules\\Users\\Models\\User',193),(2,'App\\Modules\\Users\\Models\\User',194),(2,'App\\Modules\\Users\\Models\\User',195),(2,'App\\Modules\\Users\\Models\\User',196),(2,'App\\Modules\\Users\\Models\\User',197),(2,'App\\Modules\\Users\\Models\\User',198),(2,'App\\Modules\\Users\\Models\\User',199),(2,'App\\Modules\\Users\\Models\\User',200),(2,'App\\Modules\\Users\\Models\\User',201),(2,'App\\Modules\\Users\\Models\\User',202),(2,'App\\Modules\\Users\\Models\\User',203),(2,'App\\Modules\\Users\\Models\\User',204),(2,'App\\Modules\\Users\\Models\\User',205),(2,'App\\Modules\\Users\\Models\\User',206),(2,'App\\Modules\\Users\\Models\\User',207),(2,'App\\Modules\\Users\\Models\\User',208),(2,'App\\Modules\\Users\\Models\\User',209),(2,'App\\Modules\\Users\\Models\\User',210),(2,'App\\Modules\\Users\\Models\\User',211),(2,'App\\Modules\\Users\\Models\\User',212),(2,'App\\Modules\\Users\\Models\\User',213),(2,'App\\Modules\\Users\\Models\\User',214),(2,'App\\Modules\\Users\\Models\\User',215),(2,'App\\Modules\\Users\\Models\\User',216),(2,'App\\Modules\\Users\\Models\\User',217),(2,'App\\Modules\\Users\\Models\\User',218),(2,'App\\Modules\\Users\\Models\\User',219),(2,'App\\Modules\\Users\\Models\\User',220),(2,'App\\Modules\\Users\\Models\\User',221),(2,'App\\Modules\\Users\\Models\\User',222),(2,'App\\Modules\\Users\\Models\\User',223),(2,'App\\Modules\\Users\\Models\\User',224),(2,'App\\Modules\\Users\\Models\\User',225),(2,'App\\Modules\\Users\\Models\\User',226),(2,'App\\Modules\\Users\\Models\\User',227),(2,'App\\Modules\\Users\\Models\\User',228),(2,'App\\Modules\\Users\\Models\\User',229),(2,'App\\Modules\\Users\\Models\\User',230),(2,'App\\Modules\\Users\\Models\\User',231),(2,'App\\Modules\\Users\\Models\\User',232),(2,'App\\Modules\\Users\\Models\\User',233),(11,'App\\Modules\\Users\\Models\\User',234),(2,'App\\Modules\\Users\\Models\\User',235),(2,'App\\Modules\\Users\\Models\\User',236),(2,'App\\Modules\\Users\\Models\\User',237),(11,'App\\Modules\\Users\\Models\\User',238),(21,'App\\Modules\\Users\\Models\\User',239),(2,'App\\Modules\\Users\\Models\\User',240),(2,'App\\Modules\\Users\\Models\\User',241),(2,'App\\Modules\\Users\\Models\\User',242),(23,'App\\Modules\\Users\\Models\\User',243),(3,'App\\Modules\\Users\\Models\\User',244);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mtypeitems`
--

DROP TABLE IF EXISTS `mtypeitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mtypeitems` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `managementtype_id` bigint unsigned DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mtypeitems_managementtype_id_foreign` (`managementtype_id`),
  KEY `mtypeitems_user_created_id_foreign` (`user_created_id`),
  KEY `mtypeitems_user_updated_id_foreign` (`user_updated_id`),
  KEY `mtypeitems_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `mtypeitems_managementtype_id_foreign` FOREIGN KEY (`managementtype_id`) REFERENCES `managementtypes` (`id`),
  CONSTRAINT `mtypeitems_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `mtypeitems_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `mtypeitems_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mtypeitems`
--

LOCK TABLES `mtypeitems` WRITE;
/*!40000 ALTER TABLE `mtypeitems` DISABLE KEYS */;
INSERT INTO `mtypeitems` VALUES (1,4,'Requerimiento A Banco',1,'2021-08-13 16:20:30',NULL,'2021-08-13 16:20:30',NULL,NULL),(2,4,'Certificación (Actualización en Módulo)',1,'2021-08-13 21:23:15',1,'2021-08-13 16:23:15',NULL,NULL),(3,4,'Reporte (Error  en Módulo)',1,'2021-08-13 21:23:28',1,'2021-08-13 16:23:28',NULL,NULL),(4,2,'Falla de comunicación',1,'2021-09-24 16:13:36',NULL,'2021-09-24 16:13:36',NULL,NULL),(5,2,'Falla T1',1,'2021-09-24 16:13:49',NULL,'2021-09-24 16:13:49',NULL,NULL),(6,2,'Error de aplicativo',1,'2021-09-24 16:14:09',NULL,'2021-09-24 16:14:09',NULL,NULL),(7,2,'No lee tarjeta',1,'2021-09-24 16:14:23',NULL,'2021-09-24 16:14:23',NULL,NULL),(8,2,'No funciona',1,'2021-09-24 16:14:38',NULL,'2021-09-24 16:14:38',NULL,NULL),(9,2,'No carga',1,'2021-09-24 16:14:46',NULL,'2021-09-24 16:14:46',NULL,NULL),(10,2,'Otro',1,'2021-09-24 16:15:00',NULL,'2021-09-24 16:15:00',NULL,NULL),(11,6,'Nuevas Ventas',1,'2022-02-23 14:35:17',1,'2022-02-23 14:35:17',36,'2022-02-23 14:35:17'),(12,6,'Servicio Tecnico',1,'2022-03-08 15:07:11',NULL,'2022-03-08 15:07:11',36,'2022-03-08 15:07:11'),(13,5,'Solicitud de información venta nueva',1,'2021-11-01 16:20:36',1,'2021-11-01 15:20:36',NULL,NULL),(14,3,'Desvinculaciones',1,'2021-11-01 15:07:23',NULL,'2021-11-01 15:07:23',NULL,NULL),(15,3,'Cambio de Banco',1,'2021-11-01 15:07:46',NULL,'2021-11-01 15:07:46',NULL,NULL),(16,3,'Traspasos',1,'2021-11-01 15:08:05',NULL,'2021-11-01 15:08:05',NULL,NULL),(17,6,'Estatus Envios',1,'2022-02-23 14:35:03',36,'2022-02-23 14:35:03',NULL,NULL),(18,6,'Programación de Equipos',1,'2022-03-07 13:23:26',36,'2022-03-07 13:23:26',NULL,NULL),(19,5,'código de afiliación',1,'2021-11-03 14:28:40',NULL,'2021-11-03 14:28:40',NULL,NULL),(20,5,'numero de cuenta',1,'2021-11-03 14:28:52',NULL,'2021-11-03 14:28:52',NULL,NULL),(21,3,'Reclamo Por Cobro',1,'2021-11-04 13:39:28',NULL,'2021-11-04 13:39:28',NULL,NULL),(22,3,'Dudas de Cobranzas',36,'2021-11-08 14:49:59',NULL,'2021-11-08 14:49:59',NULL,NULL),(23,3,'Cambio de Plan',36,'2022-02-23 14:37:02',NULL,'2022-02-23 14:37:02',NULL,NULL),(24,3,'Deuda por Taller',36,'2022-02-23 14:37:40',NULL,'2022-02-23 14:37:40',NULL,NULL),(25,6,'Estatus del Equipo',36,'2022-02-23 14:39:16',NULL,'2022-02-23 14:39:16',NULL,NULL),(26,2,'Comercio Invalido',36,'2022-02-23 16:29:13',NULL,'2022-02-23 16:29:13',NULL,NULL),(27,3,'Reactivación',36,'2022-02-23 16:53:08',NULL,'2022-02-23 16:53:08',NULL,NULL),(28,3,'Robo o Hurto del Equipo',36,'2022-03-07 14:13:51',NULL,'2022-03-07 14:13:51',NULL,NULL),(29,3,'Cambio de Razón Social',36,'2022-03-07 15:23:18',NULL,'2022-03-07 15:23:18',NULL,NULL),(30,5,'Otros',36,'2022-03-11 18:43:12',NULL,'2022-03-11 18:43:12',NULL,NULL);
/*!40000 ALTER TABLE `mtypeitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operations`
--

DROP TABLE IF EXISTS `operations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `operations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type_service` enum('basico','masivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_operation` enum('exoneracion','debito','credito','reverso','activacion','negociacion') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file_operation` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `operations_user_created_id_foreign` (`user_created_id`),
  KEY `operations_user_updated_id_foreign` (`user_updated_id`),
  KEY `operations_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `operations_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `operations_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `operations_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operations`
--

LOCK TABLES `operations` WRITE;
/*!40000 ALTER TABLE `operations` DISABLE KEYS */;
/*!40000 ALTER TABLE `operations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operators`
--

DROP TABLE IF EXISTS `operators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `operators` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_simcard` tinyint(1) DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `operators_user_created_id_foreign` (`user_created_id`),
  KEY `operators_user_updated_id_foreign` (`user_updated_id`),
  KEY `operators_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `operators_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `operators_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `operators_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operators`
--

LOCK TABLES `operators` WRITE;
/*!40000 ALTER TABLE `operators` DISABLE KEYS */;
INSERT INTO `operators` VALUES (1,'Digitel',NULL,1,1,NULL,NULL,NULL,NULL,NULL),(2,'Movistar',NULL,1,1,NULL,NULL,NULL,NULL,NULL),(3,'Lan',NULL,0,1,1,NULL,NULL,NULL,NULL),(4,'Dialup',NULL,0,1,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `operators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operterminals`
--

DROP TABLE IF EXISTS `operterminals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `operterminals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contract_id` bigint unsigned DEFAULT NULL,
  `type_operation` enum('activacion','suspension','cambio') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_service` enum('temporal','definitivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `term_id` bigint unsigned DEFAULT NULL,
  `fechpro` date DEFAULT NULL,
  `date_inactive` date DEFAULT NULL,
  `date_reactive` date DEFAULT NULL,
  `serial_terminal` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `term_name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('Pendiente','Finalizado','Anulado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `operterminals_contract_id_foreign` (`contract_id`),
  KEY `operterminals_term_id_foreign` (`term_id`),
  KEY `operterminals_user_created_id_foreign` (`user_created_id`),
  KEY `operterminals_user_updated_id_foreign` (`user_updated_id`),
  KEY `operterminals_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `operterminals_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `operterminals_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`),
  CONSTRAINT `operterminals_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `operterminals_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `operterminals_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operterminals`
--

LOCK TABLES `operterminals` WRITE;
/*!40000 ALTER TABLE `operterminals` DISABLE KEYS */;
/*!40000 ALTER TABLE `operterminals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contract_id` bigint unsigned NOT NULL,
  `invoice_id` bigint unsigned DEFAULT NULL,
  `observ_credicard` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observ_programmer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type_posted` enum('Presencial','Courier') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_send` date DEFAULT NULL,
  `number_control` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observ_posted` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `credicard` tinyint(1) DEFAULT NULL,
  `status` enum('P','PF','A','C','D','F','SF','S','X') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `canceledOrder_id` bigint unsigned DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `programmer_user_id` bigint unsigned DEFAULT NULL,
  `programmer_at` datetime DEFAULT NULL,
  `programmer_finish_at` datetime DEFAULT NULL,
  `receive_store_id` bigint unsigned DEFAULT NULL,
  `receive_store_at` datetime DEFAULT NULL,
  `billing_user_id` bigint unsigned DEFAULT NULL,
  `billing_at` datetime DEFAULT NULL,
  `assign_office_id` bigint unsigned DEFAULT NULL,
  `assign_office_at` datetime DEFAULT NULL,
  `posted_user_id` bigint unsigned DEFAULT NULL,
  `posted_at` datetime DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_contract_id_foreign` (`contract_id`),
  KEY `orders_invoice_id_foreign` (`invoice_id`),
  KEY `orders_canceledorder_id_foreign` (`canceledOrder_id`),
  KEY `orders_user_created_id_foreign` (`user_created_id`),
  KEY `orders_user_updated_id_foreign` (`user_updated_id`),
  KEY `orders_programmer_user_id_foreign` (`programmer_user_id`),
  KEY `orders_receive_store_id_foreign` (`receive_store_id`),
  KEY `orders_billing_user_id_foreign` (`billing_user_id`),
  KEY `orders_assign_office_id_foreign` (`assign_office_id`),
  KEY `orders_posted_user_id_foreign` (`posted_user_id`),
  KEY `orders_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `orders_assign_office_id_foreign` FOREIGN KEY (`assign_office_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_billing_user_id_foreign` FOREIGN KEY (`billing_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_canceledorder_id_foreign` FOREIGN KEY (`canceledOrder_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `orders_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  CONSTRAINT `orders_posted_user_id_foreign` FOREIGN KEY (`posted_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_programmer_user_id_foreign` FOREIGN KEY (`programmer_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_receive_store_id_foreign` FOREIGN KEY (`receive_store_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;

/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payers`
--

DROP TABLE IF EXISTS `payers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bank_id` bigint unsigned DEFAULT NULL,
  `type_file` enum('domiciliation','affiliate') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consecutive` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payers_bank_id_foreign` (`bank_id`),
  KEY `payers_user_created_id_foreign` (`user_created_id`),
  KEY `payers_user_updated_id_foreign` (`user_updated_id`),
  KEY `payers_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `payers_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  CONSTRAINT `payers_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `payers_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `payers_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payers`
--

LOCK TABLES `payers` WRITE;
/*!40000 ALTER TABLE `payers` DISABLE KEYS */;
INSERT INTO `payers` VALUES (1,6,'domiciliation','690114',1,1,1,'2021-08-17 03:17:46','2021-11-24 12:17:02',NULL,NULL),(2,4,'domiciliation','698710',1,1,1,'2021-08-17 03:19:19','2021-11-23 21:01:53',NULL,NULL),(3,4,'affiliate','36443',1,1,1,'2021-08-25 16:08:18','2022-04-13 14:20:03',NULL,NULL),(4,6,'affiliate','1764',1,1,1,'2021-09-14 08:06:24','2022-04-13 15:43:56',NULL,NULL);
/*!40000 ALTER TABLE `payers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'users.index','web','2021-01-26 05:16:56','2021-01-26 05:57:49','Usuarios'),(2,'users.create','web','2021-01-26 05:17:16','2021-01-26 05:58:07','Crear Usuario'),(3,'users.edit','web','2021-01-26 05:17:41','2021-01-26 05:58:17','Actualizar Usuario'),(4,'users.destroy','web','2021-01-26 05:17:57','2021-01-26 05:58:30','Suspender Usuario'),(5,'roles.index','web','2021-01-26 05:18:41','2021-01-26 06:07:52','Perfiles'),(6,'roles.create','web','2021-01-26 05:18:49','2021-01-26 06:08:29','Crear Perfíl'),(7,'roles.edit','web','2021-01-26 05:18:56','2021-01-26 06:08:14','Actualizar Perfíl'),(8,'roles.destroy','web','2021-01-26 05:19:29','2021-01-26 06:09:16','Eliminar Perfíl'),(9,'permissions.index','web','2021-01-26 05:19:45','2021-01-26 06:09:01','Permisos'),(10,'permissions.create','web','2021-01-26 05:19:56','2021-01-26 06:09:36','Crear Permiso'),(11,'permissions.edit','web','2021-01-26 05:20:06','2021-01-26 06:09:28','Actualizar Permiso'),(12,'permissions.destroy','web','2021-01-26 05:20:21','2021-01-26 06:10:03','Eliminar Preafiliación'),(13,'preafiliations.index','web','2021-01-26 05:20:38','2021-01-26 06:09:48','Preafiliación'),(14,'preafiliations.create','web','2021-01-26 05:20:45','2021-01-26 06:20:26','Crear Preafiliación'),(15,'preafiliations.edit','web','2021-01-26 05:20:53','2021-01-26 06:20:09','Actualizar Preafiliación'),(16,'preafiliations.destroy','web','2021-01-26 05:21:00','2021-01-26 06:20:38','Eliminar Preafiliación'),(17,'customers.index','web','2021-01-26 13:46:38','2021-01-26 13:46:38','Clientes'),(18,'customers.create','web','2021-01-26 13:47:01','2021-01-26 13:47:01','Crear Cliente'),(19,'customers.edit','web','2021-01-26 13:47:41','2021-01-26 13:47:41','Actualizar Cliente'),(20,'customers.destroy','web','2021-01-26 13:48:00','2021-01-26 13:48:00','Suspender Cliente'),(21,'rcustomer.index','web','2021-01-26 13:48:31','2021-05-20 15:44:13','Representante Legal'),(22,'rcustomer.create','web','2021-01-26 13:49:09','2021-05-20 15:43:55','Crear Representa Legal'),(23,'rcustomer.edit','web','2021-01-26 13:49:24','2021-05-20 15:43:45','Actualizar Representa Legal'),(24,'rcustomer.destroy','web','2021-01-26 13:49:40','2021-05-20 15:44:04','Eliminar Representa Legal'),(25,'dcustomer.index','web','2021-01-26 13:53:41','2021-05-20 15:42:59','Afiliación Bancaria'),(26,'dcustomer.create','web','2021-01-26 13:54:25','2021-05-20 15:43:10','Crear Afiliación Bancaria'),(27,'dcustomer.edit','web','2021-01-26 13:54:54','2021-05-20 15:42:49','Actualizar Afiliación Bancaria'),(28,'dcustomer.destroy','web','2021-01-26 13:55:37','2021-05-20 15:43:24','Eliminar Afiliación Bancaria'),(29,'sales.index','web','2021-01-26 13:56:08','2021-01-26 13:56:08','Ventas'),(30,'sales.create','web','2021-01-26 13:56:28','2021-01-26 13:56:28','Crear Venta'),(31,'sales.edit','web','2021-01-26 13:56:43','2021-01-26 13:56:43','Actualizar Ventas'),(32,'sales.destroy','web','2021-01-26 13:57:02','2021-01-26 13:57:02','Eliminar Ventas'),(33,'invoices.index','web','2021-01-26 13:57:19','2021-01-26 13:57:19','Conciliación'),(34,'invoices.create','web','2021-01-26 13:57:48','2021-01-26 13:57:48','Crear Cobro'),(35,'invoices.edit','web','2021-01-26 13:58:07','2021-01-26 13:58:07','Actualizar Cobro'),(36,'invoices.destroy','web','2021-01-26 13:58:22','2021-01-26 13:58:22','Eliminar Cobro'),(37,'collections.index','web','2021-02-10 10:15:33','2021-02-10 10:15:33','Listar Pago'),(38,'collections.create','web','2021-02-10 10:15:46','2021-02-10 10:15:46','Crear Pago'),(39,'collections.edit','web','2021-02-10 10:15:57','2021-02-10 10:15:57','Actualizar Pago'),(40,'collections.destroy','web','2021-02-10 10:16:10','2021-02-10 10:16:10','Eliminar Pago'),(41,'orders.index','web','2021-02-12 12:23:01','2021-02-12 12:23:01','Listar Ordenes de Servicio'),(42,'orders.create','web','2021-02-12 12:23:20','2021-02-12 12:23:20','Crear Orden de Servicio'),(43,'orders.edit','web','2021-02-12 12:23:34','2021-02-12 12:23:34','Actualizar Orden de Servicio'),(44,'orders.destroy','web','2021-02-12 12:23:50','2021-02-12 12:23:50','Eliminar Orden de Servicio'),(45,'terminals.index','web','2021-02-22 08:42:21','2021-02-22 08:42:21','Equipos'),(46,'terminals.create','web','2021-02-22 08:42:43','2021-02-22 08:42:43','Registrar Equipo'),(47,'terminals.edit','web','2021-02-22 08:43:04','2021-02-22 08:43:04','Actualizar Equipo'),(48,'terminals.destroy','web','2021-02-22 08:44:07','2021-02-22 08:44:07','Eliminar Equipo'),(49,'simcards.index','web','2021-02-22 08:45:19','2021-02-22 08:45:19','Simcards'),(50,'simcards.create','web','2021-02-22 08:45:39','2021-02-22 08:45:39','Registrar Simcard'),(51,'simcards.edit','web','2021-02-22 08:45:54','2021-02-22 08:45:54','Actualizar Simcard'),(52,'simcards.destroy','web','2021-02-22 08:48:20','2021-02-22 08:48:20','Eliminar Simcard'),(53,'assignments.index','web','2021-02-22 08:49:15','2021-02-22 08:49:15','Asignación'),(54,'assignments.create','web','2021-02-22 08:49:41','2021-02-22 08:49:41','Registrar Asignación'),(55,'assignments.edit','web','2021-02-22 08:49:59','2021-02-22 08:49:59','Actualizar Asignación'),(56,'assignments.destroy','web','2021-02-22 08:50:12','2021-02-22 08:50:12','Eliminar Asignación'),(57,'offices.index','web','2021-02-26 09:13:57','2021-02-26 09:13:57','Despacho'),(58,'offices.create','web','2021-02-26 09:14:29','2021-02-26 09:14:29','Generar Entrega Despacho'),(59,'offices.edit','web','2021-02-26 09:15:06','2021-02-26 09:15:06','Actualizar Entrega Despacho'),(60,'offices.destroy','web','2021-02-26 09:15:45','2021-02-26 09:15:45','Suspender Entrega Despacho'),(61,'csupports.index','web','2021-02-26 09:22:35','2021-02-26 09:22:35','Soporte Administrativo'),(62,'csupports.create','web','2021-02-26 09:23:00','2021-02-26 09:23:00','Crear Soporte Administrativo'),(63,'csupports.edit','web','2021-02-26 09:42:22','2021-02-26 09:42:22','Actualizar Soporte Administrativo'),(64,'csupports.destroy','web','2021-02-26 09:42:49','2021-02-26 09:42:49','Eliminar Soporte Administrativo'),(65,'supportservice.index','web','2021-03-12 07:14:40','2021-10-13 00:53:37','Soporte Servicios - Ventas'),(66,'dashboard.index','web','2021-04-13 12:35:31','2021-04-13 12:37:02','Dashboard Administrativo'),(67,'documents.index','web','2021-04-22 07:15:58','2021-04-22 07:15:58','Validación de Documentos'),(68,'documents.edit','web','2021-04-22 07:16:29','2021-04-22 07:16:36','Procesar documentos'),(69,'services.index','web','2021-04-22 07:17:42','2021-04-22 07:17:42','Cobranza'),(70,'services.create','web','2021-04-22 07:18:03','2021-04-22 07:18:05','Generar Cobranza'),(71,'services.edit','web','2021-04-22 07:18:48','2021-04-22 07:18:48','Carga Resultados'),(72,'services.destroy','web','2021-04-22 07:19:09','2021-04-22 07:19:09','Anular Cobranza'),(73,'currencyvalues.index','web','2021-05-24 11:11:37','2021-05-24 11:11:37','Valor Divisa'),(74,'currencyvalues.create','web','2021-05-24 11:12:15','2021-05-24 11:12:15','Registrar Valor Divisa'),(75,'currencyvalues.edit','web','2021-05-24 11:12:40','2021-05-24 11:12:40','Actualizar Valor Divisa'),(76,'currencyvalues.destroy','web','2021-05-24 11:12:59','2021-05-24 11:12:59','Eliminar Valor Divisa'),(77,'acconcepts.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Conceptos Contables'),(78,'acconcepts.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Registrar Concepto Contable'),(79,'acconcepts.edit','web','2021-05-25 10:45:59','2021-05-25 10:46:01','Actualizar Concepto Contable'),(80,'acconcepts.destroy','web','2021-05-25 10:46:29','2021-05-25 10:46:34','Eliminar Concepto Contable'),(81,'typecompanies.index','web','2021-05-25 10:46:29','2021-05-25 10:46:29','Tipo Almacén'),(82,'typecompanies.create','web','2021-05-25 10:46:29','2021-05-25 10:46:29','Registrar Tipo Almacén'),(83,'typecompanies.edit','web','2021-05-25 10:46:29','2021-05-25 10:46:29','Actualizar Tipo Almacén'),(84,'typecompanies.destroy','web','2021-05-25 10:46:29','2021-05-25 10:46:29','Eliminar Tipo Almacén'),(85,'company.index','web','2021-05-25 10:46:29','2021-05-25 10:46:29','Almacén'),(86,'company.create','web','2021-05-25 10:46:29','2021-05-25 10:46:29','Crear Almacén'),(87,'company.edit','web','2021-05-25 10:46:29','2021-05-25 10:46:29','Actualizar Almacén'),(88,'company.destroy','web','2021-05-25 10:46:29','2021-05-25 10:46:29','Eliminar Almacén'),(89,'banks.index','web','2021-05-25 10:46:29','2021-05-25 10:46:29','Bancos'),(90,'banks.create','web','2021-05-25 10:46:29','2021-05-25 10:46:29','Crear Banco'),(91,'banks.edit','web','2021-05-25 10:53:03','2021-05-25 10:53:09','Actualizar Banco'),(92,'banks.destroy','web','2021-05-25 10:53:06','2021-05-25 10:53:11','Eliminar Banco'),(93,'marks.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Marca'),(94,'marks.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Marca'),(95,'marks.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Marca'),(96,'marks.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Marca'),(97,'concept.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Conceptos Ventas'),(98,'concept.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Concepto Venta'),(99,'concept.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Concepto Venta'),(100,'concept.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Concepto Venta'),(101,'operators.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Operador'),(102,'operators.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Operador'),(103,'operators.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Operador'),(104,'operators.destroy','web','2021-04-29 11:33:08','2021-10-12 16:18:00','Eliminar Operador'),(105,'apn.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','APN'),(106,'apn.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear APN'),(107,'apn.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar APN'),(108,'apn.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar APN'),(109,'comissions.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Comisión Paquete'),(110,'comissions.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Registrar Paquete'),(111,'comissions.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Paquete'),(112,'comissions.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Paquete'),(113,'mterminal.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Modelo Equipo'),(114,'mterminal.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Modelo Equipo'),(115,'mterminal.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Modelo Equipo'),(116,'mterminal.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Modelo Equipo'),(117,'terms.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Plan Servicios'),(118,'terms.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Plan Servicio'),(119,'terms.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Plan Servicio'),(120,'terms.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Plan Servicio'),(121,'consultants.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Aliados Comerciales'),(122,'consultants.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Aliado Comercial'),(123,'consultants.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Aliado Comercial'),(124,'consultants.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Aliado Comercial'),(125,'currencies.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Divisas'),(126,'currencies.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Divisa'),(127,'currencies.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Divisa'),(128,'currencies.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Divisa'),(129,'terminalvalues.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Precios Equipos'),(130,'terminalvalues.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Precio Equipo'),(131,'terminalvalues.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Precio Equipo'),(132,'terminalvalues.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Precio Equipo'),(133,'pmethods.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Métodos Pago'),(134,'pmethods.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Método Pago'),(135,'pmethods.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualiza Método Pago'),(136,'pmethods.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Método Pago'),(137,'business.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Empresas'),(138,'business.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Empresa'),(139,'business.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Empresa'),(140,'business.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Empresa'),(141,'tipifications.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Tipificaciones'),(142,'tipifications.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Tipificacíón'),(143,'tipifications.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Tipíficación'),(144,'tipifications.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Tipificación'),(145,'zonerole.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Perfiles sin Zona'),(146,'zonerole.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Perfíl sin Zona'),(147,'zonerole.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Perfíl sin Zona'),(148,'zonerole.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Perfíl sin Zona'),(149,'cactivities.index','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actividades Comerciales'),(150,'cactivities.create','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Crear Actividad Comercial'),(151,'cactivities.edit','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Actualizar Actividad Comercial'),(152,'cactivities.destroy','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Eliminar Activida Comercial'),(153,'reports.index','web','2021-04-22 07:19:53','2021-04-22 07:19:53','Reportes'),(154,'reports.sales','web','2021-04-22 07:20:13','2021-04-22 07:20:15','Reporte Venta'),(155,'reports.preafiliation','web','2021-04-22 07:20:50','2021-04-22 07:20:52','Reporte Preafiliación'),(156,'reports.customer','web','2021-04-22 07:21:21','2021-04-22 07:21:23','Reporte Clientes'),(157,'reports.programmer','web','2021-04-22 07:22:05','2021-04-22 07:22:07','Reporte Programador'),(158,'reports.store','web','2021-04-22 07:22:45','2021-04-22 07:22:47','Reporte Almacén'),(159,'reports.office','web','2021-04-22 07:23:11','2021-04-22 07:23:13','Reporte Despacho'),(160,'reports.collection','web','2021-04-29 11:32:41','2021-04-29 11:32:41','Reporte Pagos'),(161,'reports.currencyvalue','web','2021-04-29 11:33:08','2021-04-29 11:33:08','Reporte Tasa Cambio'),(162,'reports.operation','web','2021-10-26 12:23:56','2021-10-26 12:23:56','Operaciones Diarias'),(163,'reports.service','web','2021-10-26 12:23:56','2021-10-26 12:23:56','Cartera Financiera'),(164,'reports.atc','web','2021-12-01 08:19:00','2021-12-01 08:19:00','Reporte Gestión ATC'),(165,'reports.businesssale','web','2021-10-06 05:43:07','2021-10-06 05:43:07','Reporte Analisis Financiero'),(166,'domiciliations.index','web','2021-10-06 05:44:02','2021-10-06 05:44:02','Domiciliación'),(167,'domiciliations.create','web','2021-10-06 05:44:24','2021-10-06 05:44:24','Registrar Domiciliación'),(168,'domiciliations.edit','web','2021-10-06 05:44:45','2021-10-06 05:44:45','Procesar Domiciliación'),(169,'domiciliations.destroy','web','2021-10-12 15:30:41','2021-10-12 16:11:54','Anular Domiciliación'),(170,'serviceSupport.invoice','web','2021-10-12 16:08:21','2021-10-12 16:25:45','Administrativos Cobros'),(171,'serviceSupport.contract','web','2021-10-12 16:25:55','2021-10-12 16:25:55','Administrativos Contratos'),(172,'serviceSupport.index','web','2021-10-13 13:57:52','2021-10-13 14:30:16','Administrativos'),(173,'atc.index','web','2021-10-13 13:59:12','2021-10-13 14:01:39','Atención al Cliente'),(174,'atcs.index','web','2021-10-13 14:04:13','2021-10-13 14:31:17','Opciones ATC'),(175,'atcs.create','web','2021-10-13 14:06:45','2021-10-13 14:06:45','Crear Tickets'),(176,'atcs.edit','web','2021-10-13 14:07:04','2021-10-13 14:31:30','Editar Tickets'),(177,'atcs.view','web','2021-10-13 14:08:44','2021-10-13 14:08:44','Ver Tickets'),(178,'atcs.management','web','2021-10-13 14:09:10','2021-10-13 14:09:10','Administrar Tickets'),(179,'atcs.destroy','web','2021-10-13 14:10:34','2021-10-13 14:31:37','Eliminar Tickets'),(180,'atcs.support','web','2021-10-13 14:26:09','2021-10-13 14:31:22','Gestión Soporte Tecnico'),(181,'atcs.sale','web','2021-10-13 14:26:09','2021-10-13 14:31:22','Gestión Ventas'),(182,'atcs.internal','web','2021-10-13 14:26:09','2021-10-13 14:31:22','Gestión Canales'),(183,'atcs.atc','web','2021-10-13 14:26:09','2021-10-13 14:31:22','Dashboard ATC'),(184,'atcs.invoice','web','2021-10-20 07:56:00','2021-10-13 14:31:22','Gestión Cobranza'),(185,'atcmessages.index','web','2021-10-20 08:10:00','2021-10-13 14:31:22','Mensajes ATC'),(186,'statements.index','web','2021-10-21 13:52:00','2021-10-21 13:52:00','Cartera Gestión Telefónica'),(187,'operations.index','web','2021-10-21 13:52:32','2021-10-21 13:52:32','Gestión Cobranza Servicios'),(188,'operations.create','web','2021-10-21 13:52:51','2021-10-21 13:52:51','Crear Cobranza Servicios'),(189,'operations.masive','web','2021-10-26 12:23:56','2021-10-26 12:23:56','Cobranza Servicio Masivo'),(190,'rcollections.index','web','2021-10-26 12:23:56','2021-10-26 12:23:56','Historial ISG Pagos'),(191,'operterminals.report','web','2021-10-22 19:14:44','2021-10-22 19:14:44','Operaciones - Movimientos Terminales'),(192,'operterminals.index','web','2021-10-23 03:15:22','2021-10-23 03:15:22','Dashboard Gestión Terminales'),(193,'operterminals.create','web','2021-11-16 20:08:00','2021-11-16 20:08:00','Crear Gestión Terminal'),(194,'operterminals.edit','web','2021-11-08 17:35:00','2021-11-08 17:35:00','Editar Gestión Terminal'),(195,'operterminals.destroy','web','2021-11-08 17:35:00','2021-11-08 17:35:00','Anular Gestión Terminal'),(196,'adomiciliations.index','web','2021-11-08 17:35:00','2021-11-08 17:35:00','Afiliaciones'),(197,'adomiciliations.create','web','2021-11-08 17:35:00','2021-11-08 17:35:00','Crear Afiliaciones'),(198,'adomiciliations.edit','web','2021-11-08 17:35:00','2021-11-08 17:35:00','Editar Afiliaciones'),(199,'adomiciliations.destroy','web','2022-02-21 19:04:18','2022-02-21 19:04:18','Anular Afiliaciones');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmethods`
--

DROP TABLE IF EXISTS `pmethods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pmethods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pmethods_user_created_id_foreign` (`user_created_id`),
  KEY `pmethods_user_updated_id_foreign` (`user_updated_id`),
  KEY `pmethods_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `pmethods_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `pmethods_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `pmethods_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmethods`
--

LOCK TABLES `pmethods` WRITE;
/*!40000 ALTER TABLE `pmethods` DISABLE KEYS */;
INSERT INTO `pmethods` VALUES (1,'Efectivo','Efectivo',1,NULL,'2021-01-27 00:34:20','2021-01-27 00:34:20',NULL,NULL),(2,'Transferencia','Transferencia',1,NULL,'2021-01-27 00:34:41','2021-01-27 00:34:41',NULL,NULL),(3,'Deposito','Depósito',1,NULL,'2021-01-27 00:34:57','2021-01-28 11:06:51',1,'2021-01-28 11:06:51'),(4,'DTE','Deposito | Transferencia | Efectivo',1,NULL,'2021-01-27 00:35:33','2021-01-27 00:35:33',NULL,NULL),(5,'Custodia','Cuenta Custodia',1,NULL,'2021-01-28 11:06:45','2021-01-28 11:06:45',NULL,NULL),(6,'Deposito','Deposito',1,1,'2021-02-11 10:14:20','2021-02-19 19:12:33',NULL,NULL),(7,'Postpago','Postpago',1,1,'2021-02-11 10:15:12','2021-02-19 18:59:00',NULL,NULL);
/*!40000 ALTER TABLE `pmethods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preafiliations`
--

DROP TABLE IF EXISTS `preafiliations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preafiliations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rif` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint unsigned DEFAULT NULL,
  `is_customer` tinyint(1) DEFAULT NULL,
  `data_customer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `document_rif` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_rif` tinyint(1) DEFAULT NULL,
  `data_rcustomer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `data_mercantil` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `document_mercantil` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_mercantil` tinyint(1) DEFAULT NULL,
  `data_bank` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `document_bank` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_bank` tinyint(1) DEFAULT NULL,
  `autorization_bank` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_auth_bank` tinyint(1) DEFAULT NULL,
  `data_contract` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `data_payment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_payment` tinyint(1) DEFAULT NULL,
  `document_payment` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observation_initial` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observations_sale` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('Procesado','Cargado','Anulado','Vencido') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `consultant_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `preafiliations_company_id_foreign` (`company_id`),
  KEY `preafiliations_user_created_id_foreign` (`user_created_id`),
  KEY `preafiliations_user_updated_id_foreign` (`user_updated_id`),
  KEY `preafiliations_user_deleted_id_foreign` (`user_deleted_id`),
  KEY `preafiliations_consultant_id_foreign` (`consultant_id`),
  CONSTRAINT `preafiliations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `preafiliations_consultant_id_foreign` FOREIGN KEY (`consultant_id`) REFERENCES `consultants` (`id`),
  CONSTRAINT `preafiliations_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `preafiliations_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `preafiliations_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preafiliations`
--

LOCK TABLES `preafiliations` WRITE;
/*!40000 ALTER TABLE `preafiliations` DISABLE KEYS */;
/*!40000 ALTER TABLE `preafiliations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `raffiliates`
--

DROP TABLE IF EXISTS `raffiliates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `raffiliates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fechpro` date DEFAULT NULL,
  `contract_id` bigint unsigned DEFAULT NULL,
  `dcustomer_id` bigint unsigned DEFAULT NULL,
  `bank_id` bigint unsigned DEFAULT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observation_response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('Generado','Actualizado','Afiliado','Desactivado','Procesado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `raffiliates_user_created_id_foreign` (`user_created_id`),
  KEY `raffiliates_contract_id_foreign` (`contract_id`),
  KEY `raffiliates_dcustomer_id_foreign` (`dcustomer_id`),
  KEY `raffiliates_bank_id_foreign` (`bank_id`),
  CONSTRAINT `raffiliates_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  CONSTRAINT `raffiliates_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `raffiliates_dcustomer_id_foreign` FOREIGN KEY (`dcustomer_id`) REFERENCES `dcustomers` (`id`),
  CONSTRAINT `raffiliates_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `raffiliates`
--

LOCK TABLES `raffiliates` WRITE;
/*!40000 ALTER TABLE `raffiliates` DISABLE KEYS */;
/*!40000 ALTER TABLE `raffiliates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rcollections`
--

DROP TABLE IF EXISTS `rcollections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rcollections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fechpro` date NOT NULL,
  `refere` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bankdocument_id` bigint unsigned DEFAULT NULL,
  `bank_id` bigint unsigned DEFAULT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('X','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rcollections_user_created_id_foreign` (`user_created_id`),
  KEY `rcollections_bankdocument_id_foreign` (`bankdocument_id`),
  CONSTRAINT `rcollections_bankdocument_id_foreign` FOREIGN KEY (`bankdocument_id`) REFERENCES `bankdocuments` (`id`),
  CONSTRAINT `rcollections_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rcollections`
--

LOCK TABLES `rcollections` WRITE;
/*!40000 ALTER TABLE `rcollections` DISABLE KEYS */;
/*!40000 ALTER TABLE `rcollections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rcustomers`
--

DROP TABLE IF EXISTS `rcustomers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rcustomers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `document` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jobtitle` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_document` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rcustomers_customer_id_foreign` (`customer_id`),
  KEY `rcustomers_user_created_id_foreign` (`user_created_id`),
  KEY `rcustomers_user_updated_id_foreign` (`user_updated_id`),
  KEY `rcustomers_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `rcustomers_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `rcustomers_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `rcustomers_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `rcustomers_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rcustomers`
--

LOCK TABLES `rcustomers` WRITE;
/*!40000 ALTER TABLE `rcustomers` DISABLE KEYS */;

/*!40000 ALTER TABLE `rcustomers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(83,1),(84,1),(85,1),(86,1),(87,1),(88,1),(89,1),(90,1),(91,1),(92,1),(93,1),(94,1),(95,1),(96,1),(97,1),(98,1),(99,1),(100,1),(101,1),(102,1),(103,1),(104,1),(105,1),(106,1),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(113,1),(114,1),(115,1),(116,1),(117,1),(118,1),(119,1),(120,1),(121,1),(122,1),(123,1),(124,1),(125,1),(126,1),(127,1),(128,1),(129,1),(130,1),(131,1),(132,1),(133,1),(134,1),(135,1),(136,1),(137,1),(138,1),(139,1),(140,1),(141,1),(142,1),(143,1),(144,1),(145,1),(146,1),(147,1),(148,1),(149,1),(150,1),(151,1),(152,1),(153,1),(154,1),(155,1),(156,1),(157,1),(158,1),(159,1),(160,1),(161,1),(162,1),(163,1),(166,1),(167,1),(168,1),(169,1),(170,1),(171,1),(172,1),(173,1),(174,1),(175,1),(176,1),(177,1),(178,1),(179,1),(180,1),(181,1),(182,1),(183,1),(184,1),(185,1),(186,1),(187,1),(188,1),(189,1),(190,1),(191,1),(192,1),(193,1),(13,2),(14,2),(17,2),(21,2),(22,2),(25,2),(26,2),(29,2),(30,2),(153,2),(154,2),(155,2),(156,2),(157,2),(17,3),(21,3),(25,3),(41,3),(43,3),(61,3),(153,3),(154,3),(155,3),(156,3),(157,3),(158,3),(159,3),(160,3),(161,3),(173,3),(174,3),(175,3),(176,3),(177,3),(178,3),(180,3),(181,3),(182,3),(183,3),(184,3),(185,3),(13,4),(14,4),(17,4),(18,4),(21,4),(22,4),(25,4),(26,4),(29,4),(30,4),(17,5),(19,5),(21,5),(22,5),(23,5),(25,5),(27,5),(29,5),(31,5),(67,5),(68,5),(153,5),(154,5),(155,5),(156,5),(161,5),(13,6),(14,6),(17,6),(21,6),(22,6),(25,6),(26,6),(29,6),(30,6),(65,6),(153,6),(154,6),(155,6),(156,6),(161,6),(173,6),(174,6),(175,6),(176,6),(177,6),(178,6),(179,6),(180,6),(181,6),(182,6),(183,6),(184,6),(185,6),(13,7),(14,7),(15,7),(17,7),(21,7),(22,7),(23,7),(25,7),(26,7),(27,7),(29,7),(30,7),(31,7),(65,7),(66,7),(73,7),(74,7),(75,7),(129,7),(130,7),(131,7),(153,7),(154,7),(155,7),(156,7),(159,7),(161,7),(164,7),(170,7),(172,7),(173,7),(174,7),(175,7),(176,7),(177,7),(178,7),(179,7),(180,7),(181,7),(182,7),(183,7),(184,7),(185,7),(17,8),(19,8),(21,8),(25,8),(33,8),(34,8),(35,8),(37,8),(38,8),(39,8),(65,8),(66,8),(73,8),(74,8),(129,8),(130,8),(153,8),(154,8),(155,8),(156,8),(160,8),(173,8),(174,8),(175,8),(176,8),(177,8),(178,8),(179,8),(180,8),(181,8),(182,8),(183,8),(184,8),(185,8),(17,9),(21,9),(25,9),(45,9),(46,9),(47,9),(49,9),(50,9),(51,9),(53,9),(54,9),(55,9),(81,9),(82,9),(83,9),(85,9),(86,9),(87,9),(93,9),(94,9),(95,9),(101,9),(102,9),(103,9),(113,9),(114,9),(115,9),(153,9),(154,9),(156,9),(158,9),(173,9),(174,9),(175,9),(176,9),(177,9),(178,9),(179,9),(180,9),(181,9),(182,9),(183,9),(184,9),(185,9),(17,10),(21,10),(25,10),(41,10),(57,10),(58,10),(59,10),(153,10),(154,10),(155,10),(156,10),(157,10),(158,10),(159,10),(17,11),(21,11),(25,11),(173,11),(174,11),(175,11),(176,11),(177,11),(178,11),(179,11),(180,11),(181,11),(182,11),(183,11),(184,11),(185,11),(17,12),(21,12),(25,12),(27,12),(67,12),(68,12),(69,12),(70,12),(71,12),(72,12),(153,12),(154,12),(155,12),(156,12),(162,12),(163,12),(166,12),(167,12),(168,12),(169,12),(173,12),(174,12),(175,12),(176,12),(177,12),(178,12),(179,12),(180,12),(181,12),(182,12),(183,12),(184,12),(185,12),(186,12),(187,12),(188,12),(189,12),(190,12),(191,12),(192,12),(193,12),(194,12),(195,12),(196,12),(197,12),(198,12),(17,13),(21,13),(25,13),(33,13),(34,13),(35,13),(36,13),(37,13),(38,13),(39,13),(40,13),(66,13),(73,13),(74,13),(77,13),(78,13),(79,13),(129,13),(130,13),(153,13),(154,13),(155,13),(156,13),(160,13),(161,13),(170,13),(172,13),(173,13),(174,13),(175,13),(176,13),(177,13),(178,13),(179,13),(180,13),(181,13),(182,13),(183,13),(184,13),(185,13),(153,14),(154,14),(155,14),(156,14),(157,14),(158,14),(159,14),(160,14),(161,14),(162,14),(163,14),(164,14),(1,17),(2,17),(3,17),(4,17),(5,17),(6,17),(7,17),(8,17),(9,17),(10,17),(11,17),(12,17),(13,17),(14,17),(15,17),(16,17),(17,17),(18,17),(19,17),(20,17),(21,17),(22,17),(23,17),(24,17),(25,17),(26,17),(27,17),(28,17),(29,17),(30,17),(31,17),(32,17),(33,17),(34,17),(35,17),(36,17),(37,17),(38,17),(39,17),(40,17),(41,17),(42,17),(43,17),(44,17),(45,17),(46,17),(47,17),(48,17),(49,17),(50,17),(51,17),(52,17),(53,17),(54,17),(55,17),(56,17),(57,17),(58,17),(59,17),(60,17),(61,17),(62,17),(63,17),(64,17),(65,17),(66,17),(67,17),(68,17),(69,17),(70,17),(71,17),(72,17),(73,17),(74,17),(75,17),(76,17),(77,17),(78,17),(79,17),(80,17),(81,17),(82,17),(83,17),(84,17),(85,17),(86,17),(87,17),(88,17),(89,17),(90,17),(91,17),(92,17),(93,17),(94,17),(95,17),(96,17),(97,17),(98,17),(99,17),(100,17),(101,17),(102,17),(103,17),(104,17),(105,17),(106,17),(107,17),(108,17),(109,17),(110,17),(111,17),(112,17),(113,17),(114,17),(115,17),(116,17),(117,17),(118,17),(119,17),(120,17),(121,17),(122,17),(123,17),(124,17),(125,17),(126,17),(127,17),(128,17),(129,17),(130,17),(131,17),(132,17),(133,17),(134,17),(135,17),(136,17),(137,17),(138,17),(139,17),(140,17),(141,17),(142,17),(143,17),(144,17),(145,17),(146,17),(147,17),(148,17),(149,17),(150,17),(151,17),(152,17),(183,17),(13,18),(14,18),(15,18),(17,18),(21,18),(22,18),(23,18),(25,18),(26,18),(27,18),(29,18),(30,18),(31,18),(41,18),(42,18),(43,18),(63,18),(64,18),(71,18),(72,18),(127,18),(128,18),(129,18),(151,18),(152,18),(13,19),(14,19),(17,19),(21,19),(22,19),(23,19),(25,19),(26,19),(29,19),(30,19),(41,19),(57,19),(58,19),(59,19),(63,19),(153,19),(154,19),(155,19),(156,19),(159,19),(173,19),(174,19),(175,19),(176,19),(177,19),(178,19),(179,19),(180,19),(181,19),(182,19),(183,19),(184,19),(185,19),(17,20),(21,20),(25,20),(69,20),(70,20),(71,20),(72,20),(153,20),(154,20),(156,20),(166,20),(167,20),(168,20),(173,20),(174,20),(175,20),(176,20),(177,20),(178,20),(179,20),(180,20),(181,20),(182,20),(183,20),(184,20),(185,20),(186,20),(187,20),(188,20),(189,20),(190,20),(191,20),(192,20),(193,20),(196,20),(197,20),(198,20),(17,21),(21,21),(25,21),(69,21),(70,21),(71,21),(72,21),(153,21),(154,21),(156,21),(173,21),(174,21),(175,21),(176,21),(177,21),(178,21),(179,21),(180,21),(181,21),(182,21),(183,21),(184,21),(185,21),(186,21),(187,21),(188,21),(189,21),(190,21),(191,21),(192,21),(193,21),(17,22),(21,22),(25,22),(69,22),(153,22),(154,22),(156,22),(173,22),(174,22),(175,22),(176,22),(177,22),(178,22),(179,22),(180,22),(181,22),(182,22),(183,22),(184,22),(185,22),(186,22),(190,22),(17,23),(19,23),(21,23),(23,23),(25,23),(27,23),(173,23),(174,23),(175,23),(176,23),(177,23),(178,23),(179,23),(180,23),(181,23),(182,23),(183,23),(184,23),(185,23),(13,24),(14,24),(15,24),(17,24),(21,24),(23,24),(25,24),(26,24),(27,24),(29,24),(30,24),(65,24),(66,24),(73,24),(74,24),(129,24),(130,24),(153,24),(154,24),(155,24),(156,24),(173,24),(174,24),(175,24),(177,24),(183,24),(185,24),(17,25),(21,25),(25,25),(27,25),(41,25),(42,25),(43,25),(45,25),(46,25),(47,25),(49,25),(50,25),(51,25),(53,25),(54,25),(55,25),(85,25),(87,25),(153,25),(154,25),(155,25),(156,25),(157,25),(158,25),(159,25),(173,25),(174,25),(175,25),(176,25),(177,25),(185,25),(17,26),(19,26),(21,26),(25,26),(29,26),(153,26),(154,26),(155,26),(156,26),(157,26),(158,26),(159,26),(160,26),(161,26),(162,26),(164,26),(173,26),(174,26),(175,26),(176,26),(177,26),(178,26),(179,26),(180,26),(181,26),(182,26),(183,26),(184,26),(185,26);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'superadmin','web','2021-01-26 12:44:01','2021-01-26 14:14:43','Super Administrador'),(2,'preafiliation','web','2021-01-26 12:59:46','2021-01-26 14:12:00','Preafiliación'),(3,'programmer','web','2021-01-26 12:59:59','2021-01-26 12:59:59','Programación'),(4,'sales','web','2021-01-26 14:12:43','2021-01-26 14:12:43','Ventas'),(5,'document','web','2021-02-08 08:31:43','2021-02-08 08:31:43','Documento'),(6,'assistant','web','2021-02-08 08:43:24','2021-02-08 08:43:24','Asistente de Aliado'),(7,'sales.coordinator','web','2021-02-08 14:20:58','2021-02-08 14:20:58','Coordinador de Ventas'),(8,'collections','web','2021-02-08 14:31:51','2021-02-08 14:31:51','Conciliación'),(9,'store','web','2021-02-22 08:57:15','2021-02-22 08:57:15','Almacén'),(10,'office','web','2021-02-26 09:17:14','2021-02-26 09:17:14','Despacho'),(11,'Atencion al Cliente','web','2021-04-14 15:41:49','2021-04-14 15:41:49','atc'),(12,'coordinator.collection','web','2021-04-28 08:58:36','2021-10-25 12:31:27','Cordinador de Cobranzas'),(13,'finance','web','2021-05-10 08:45:34','2021-10-27 15:35:06','Finanzas'),(14,'Reporteria','web','2021-09-28 12:32:39','2021-09-28 12:32:39','Reporteria'),(17,'testp','web','2021-10-12 13:48:10','2021-10-12 13:48:10','prueba'),(18,'sales.assistant.multiuse','web','2021-10-13 14:16:43','2021-10-13 17:56:14','Asistente de ventas Multiuso'),(19,'preafiliation.office','web','2021-10-19 18:12:25','2021-10-19 18:12:25','Preafiliacion y despacho'),(20,'collection','web','2021-10-25 12:33:45','2021-10-25 12:33:45','Analista de Cobranza'),(21,'analyst.collection','web','2021-10-25 12:48:41','2021-10-25 12:48:41','Analista sr Cobranza'),(22,'atc.collection','web','2021-10-25 13:00:06','2021-10-25 13:00:06','ATC Cobranza'),(23,'reception.atc','web','2021-11-02 13:54:51','2021-11-02 13:54:51','Atc Recepción'),(24,'sales.coordinator.assistant','web','2021-11-04 21:42:11','2021-11-04 21:48:44','Cordinador de Aliados'),(25,'programmer.store','web','2021-11-08 19:33:27','2021-11-08 19:33:27','Coordinador de Operaciones'),(26,'atc.coordinator','web','2022-03-09 19:06:39','2022-03-09 19:06:39','Coordinador de Atc');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `simcards`
--

DROP TABLE IF EXISTS `simcards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `simcards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `operator_id` bigint unsigned NOT NULL,
  `apn_id` bigint unsigned DEFAULT NULL,
  `number_mobile` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_sim` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Disponible','Asignado','Entregado','Desactivado','Inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_assignated_id` bigint unsigned DEFAULT NULL,
  `assignated_at` timestamp NULL DEFAULT NULL,
  `user_posted_id` bigint unsigned DEFAULT NULL,
  `posted_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `simcards_company_id_foreign` (`company_id`),
  KEY `simcards_operator_id_foreign` (`operator_id`),
  KEY `simcards_apn_id_foreign` (`apn_id`),
  KEY `simcards_user_created_id_foreign` (`user_created_id`),
  KEY `simcards_user_updated_id_foreign` (`user_updated_id`),
  KEY `simcards_user_assignated_id_foreign` (`user_assignated_id`),
  KEY `simcards_user_posted_id_foreign` (`user_posted_id`),
  KEY `simcards_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `simcards_apn_id_foreign` FOREIGN KEY (`apn_id`) REFERENCES `apn` (`id`),
  CONSTRAINT `simcards_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `simcards_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`),
  CONSTRAINT `simcards_user_assignated_id_foreign` FOREIGN KEY (`user_assignated_id`) REFERENCES `users` (`id`),
  CONSTRAINT `simcards_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `simcards_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `simcards_user_posted_id_foreign` FOREIGN KEY (`user_posted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `simcards_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `simcards`
--

LOCK TABLES `simcards` WRITE;
/*!40000 ALTER TABLE `simcards` DISABLE KEYS */;
/*!40000 ALTER TABLE `simcards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `states` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `abrev` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,NULL,'Amazonas'),(2,NULL,'Anzoátegui'),(3,NULL,'Apure'),(4,NULL,'Aragua'),(5,NULL,'Barinas'),(6,NULL,'Bolívar'),(7,NULL,'Carabobo'),(8,NULL,'Cojedes'),(9,NULL,'Delta Amacuro'),(10,NULL,'Falcón'),(11,NULL,'Guárico'),(12,NULL,'Lara'),(13,NULL,'Mérida'),(14,NULL,'Miranda'),(15,NULL,'Monagas'),(16,NULL,'Nueva Esparta'),(17,NULL,'Portuguesa'),(18,NULL,'Sucre'),(19,NULL,'Táchira'),(20,NULL,'Trujillo'),(21,NULL,'Vargas'),(22,NULL,'Yaracuy'),(23,NULL,'Zulia'),(24,NULL,'Distrito Capital'),(25,NULL,'Dependencias Federales');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supports`
--

DROP TABLE IF EXISTS `supports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contract_id` bigint unsigned DEFAULT NULL,
  `type_support` enum('Garantia','Mantenimiento') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_ini` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `observation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observation_technical` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tipification_id` bigint unsigned DEFAULT NULL,
  `observation_manager` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observation_response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `terminal_id` bigint unsigned DEFAULT NULL,
  `terminal_new_id` bigint unsigned DEFAULT NULL,
  `observation_delivery` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `data_invoice` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `delivery` enum('Presencial','Courier') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('G','T','M','F','C','X') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_invoice` enum('S','ST','T','G') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `procedure_support` enum('Autorizado','Cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_technical_id` bigint unsigned DEFAULT NULL,
  `technical_at` timestamp NULL DEFAULT NULL,
  `user_manager_id` bigint unsigned DEFAULT NULL,
  `manager_at` date DEFAULT NULL,
  `user_finalized_id` bigint unsigned DEFAULT NULL,
  `finalized_at` date DEFAULT NULL,
  `user_delivery_id` bigint unsigned DEFAULT NULL,
  `delivery_at` date DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supports_contract_id_foreign` (`contract_id`),
  KEY `supports_tipification_id_foreign` (`tipification_id`),
  KEY `supports_terminal_id_foreign` (`terminal_id`),
  KEY `supports_terminal_new_id_foreign` (`terminal_new_id`),
  KEY `supports_user_technical_id_foreign` (`user_technical_id`),
  KEY `supports_user_manager_id_foreign` (`user_manager_id`),
  KEY `supports_user_finalized_id_foreign` (`user_finalized_id`),
  KEY `supports_user_delivery_id_foreign` (`user_delivery_id`),
  KEY `supports_user_created_id_foreign` (`user_created_id`),
  KEY `supports_user_updated_id_foreign` (`user_updated_id`),
  KEY `supports_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `supports_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `supports_terminal_id_foreign` FOREIGN KEY (`terminal_id`) REFERENCES `terminals` (`id`),
  CONSTRAINT `supports_terminal_new_id_foreign` FOREIGN KEY (`terminal_new_id`) REFERENCES `terminals` (`id`),
  CONSTRAINT `supports_tipification_id_foreign` FOREIGN KEY (`tipification_id`) REFERENCES `tipifications` (`id`),
  CONSTRAINT `supports_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `supports_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `supports_user_delivery_id_foreign` FOREIGN KEY (`user_delivery_id`) REFERENCES `users` (`id`),
  CONSTRAINT `supports_user_finalized_id_foreign` FOREIGN KEY (`user_finalized_id`) REFERENCES `users` (`id`),
  CONSTRAINT `supports_user_manager_id_foreign` FOREIGN KEY (`user_manager_id`) REFERENCES `users` (`id`),
  CONSTRAINT `supports_user_technical_id_foreign` FOREIGN KEY (`user_technical_id`) REFERENCES `users` (`id`),
  CONSTRAINT `supports_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supports`
--

LOCK TABLES `supports` WRITE;
/*!40000 ALTER TABLE `supports` DISABLE KEYS */;
/*!40000 ALTER TABLE `supports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terminals`
--

DROP TABLE IF EXISTS `terminals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `terminals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `modelterminal_id` bigint unsigned NOT NULL,
  `fechpro` datetime DEFAULT NULL,
  `serial` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `imei` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device` varchar(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_assignated_id` bigint unsigned DEFAULT NULL,
  `assignated_at` datetime DEFAULT NULL,
  `status` enum('Disponible','Asignado','Credicard','Entregado','Desactivado','SinLlave') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_posted_id` bigint unsigned DEFAULT NULL,
  `posted_at` datetime DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `terminals_company_id_foreign` (`company_id`),
  KEY `terminals_modelterminal_id_foreign` (`modelterminal_id`),
  KEY `terminals_user_created_id_foreign` (`user_created_id`),
  KEY `terminals_user_updated_id_foreign` (`user_updated_id`),
  KEY `terminals_user_assignated_id_foreign` (`user_assignated_id`),
  KEY `terminals_user_posted_id_foreign` (`user_posted_id`),
  KEY `terminals_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `terminals_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `terminals_modelterminal_id_foreign` FOREIGN KEY (`modelterminal_id`) REFERENCES `modelterminal` (`id`),
  CONSTRAINT `terminals_user_assignated_id_foreign` FOREIGN KEY (`user_assignated_id`) REFERENCES `users` (`id`),
  CONSTRAINT `terminals_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `terminals_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `terminals_user_posted_id_foreign` FOREIGN KEY (`user_posted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `terminals_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terminals`
--

LOCK TABLES `terminals` WRITE;
/*!40000 ALTER TABLE `terminals` DISABLE KEYS */;

/*!40000 ALTER TABLE `terminals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terminalvalues`
--

DROP TABLE IF EXISTS `terminalvalues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `terminalvalues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date_value` date NOT NULL,
  `modelterminal_id` bigint unsigned NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `amount_currency` decimal(15,2) NOT NULL,
  `amount_local` decimal(15,2) NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `terminalvalues_modelterminal_id_foreign` (`modelterminal_id`),
  KEY `terminalvalues_currency_id_foreign` (`currency_id`),
  KEY `terminalvalues_user_created_id_foreign` (`user_created_id`),
  KEY `terminalvalues_user_updated_id_foreign` (`user_updated_id`),
  KEY `terminalvalues_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `terminalvalues_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `terminalvalues_modelterminal_id_foreign` FOREIGN KEY (`modelterminal_id`) REFERENCES `modelterminal` (`id`),
  CONSTRAINT `terminalvalues_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `terminalvalues_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `terminalvalues_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terminalvalues`
--

LOCK TABLES `terminalvalues` WRITE;
/*!40000 ALTER TABLE `terminalvalues` DISABLE KEYS */;

/*!40000 ALTER TABLE `terminalvalues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terms`
--

DROP TABLE IF EXISTS `terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `terms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `abrev` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type_conditions` enum('Tarifa','Porcentaje','Mixto') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_conditions1` enum('Fijo','Rango') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `comission_flatrate` double(11,2) DEFAULT NULL,
  `comission_percentage` double(2,2) DEFAULT NULL,
  `comission_min` int DEFAULT NULL,
  `comission_id` bigint unsigned DEFAULT NULL,
  `amount_min` int DEFAULT NULL,
  `amount_max` int DEFAULT NULL,
  `prepaid` int DEFAULT NULL,
  `type_invoice` enum('D','M','Q','S') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Activo','Inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `terms_abrev_unique` (`abrev`),
  KEY `terms_currency_id_foreign` (`currency_id`),
  KEY `terms_comission_id_foreign` (`comission_id`),
  KEY `terms_user_created_id_foreign` (`user_created_id`),
  KEY `terms_user_updated_id_foreign` (`user_updated_id`),
  KEY `terms_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `terms_comission_id_foreign` FOREIGN KEY (`comission_id`) REFERENCES `comissions` (`id`),
  CONSTRAINT `terms_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `terms_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `terms_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `terms_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terms`
--

LOCK TABLES `terms` WRITE;
/*!40000 ALTER TABLE `terms` DISABLE KEYS */;
INSERT INTO `terms` VALUES (1,'abrev','description','observations','typ_conditions','typ_conditions1',1,1.00,NULL,NULL,NULL,NULL,NULL,0,'D','Activo',1,NULL,'2021-01-28 11:03:22','2021-01-28 11:04:04',1,'2021-01-28 11:04:04');
/*!40000 ALTER TABLE `terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipifications`
--

DROP TABLE IF EXISTS `tipifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipifications_user_created_id_foreign` (`user_created_id`),
  KEY `tipifications_user_updated_id_foreign` (`user_updated_id`),
  KEY `tipifications_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `tipifications_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `tipifications_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `tipifications_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipifications`
--

LOCK TABLES `tipifications` WRITE;
/*!40000 ALTER TABLE `tipifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typecompanies`
--

DROP TABLE IF EXISTS `typecompanies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `typecompanies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `typecompanies_user_created_id_foreign` (`user_created_id`),
  KEY `typecompanies_user_updated_id_foreign` (`user_updated_id`),
  KEY `typecompanies_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `typecompanies_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `typecompanies_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `typecompanies_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typecompanies`
--

LOCK TABLES `typecompanies` WRITE;
/*!40000 ALTER TABLE `typecompanies` DISABLE KEYS */;
INSERT INTO `typecompanies` VALUES (1,'Principal',1,NULL,'2021-01-26 13:05:05','2021-01-26 13:05:05',NULL,NULL),(2,'Control Interno',1,NULL,'2021-03-11 15:05:43','2021-03-11 15:05:43',NULL,NULL),(3,'Oficina Comercial',1,1,'2021-04-07 08:26:38','2021-04-07 08:27:15',NULL,NULL),(4,'Aliados',1,1,'2021-04-07 08:26:45','2021-04-07 08:27:22',NULL,NULL);
/*!40000 ALTER TABLE `typecompanies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `document` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jobtitle` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('Activo','Inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `company_id` bigint unsigned DEFAULT NULL,
  `banklist` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'V-00000000','Super','Administrador','Super Administrador','superadmin@tritech.local','$2y$10$S5bmVoudptN9SYDkYWa31ux51Bc84AjT9b2VtRt6kEBa00IyHc7vq',NULL,'swQWLIPXSd4MQWK3Mpv3oSZU0GJxFF9YQs9vzDdTKNKMqdxaTYd4zZ6YykYr',NULL,'2021-04-06 11:39:04','Activo',NULL,NULL,NULL),(2,'V-22438686','Jorge','Thomas','Lead Developer','jthomas@tritech.com','$2y$10$5rhp2yE/R.1COUCpTCWJPuBKTmtuGqaNh0Gf6yls9RT42fLYNkqRq',NULL,'ghhb7r5rDvxuhbKLqgmGp9m15FMnkMTT0CVs89NGGYRC0ixZPJ8rUY9YnUu9','2021-02-10 14:43:50','2021-04-06 11:47:53','Activo',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `websockets_statistics_entries`
--

DROP TABLE IF EXISTS `websockets_statistics_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `websockets_statistics_entries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int NOT NULL,
  `websocket_message_count` int NOT NULL,
  `api_message_count` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `websockets_statistics_entries`
--

LOCK TABLES `websockets_statistics_entries` WRITE;
/*!40000 ALTER TABLE `websockets_statistics_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `websockets_statistics_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zone_role`
--

DROP TABLE IF EXISTS `zone_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zone_role` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned DEFAULT NULL,
  `user_created_id` bigint unsigned DEFAULT NULL,
  `user_updated_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_deleted_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zone_role_role_id_foreign` (`role_id`),
  KEY `zone_role_user_created_id_foreign` (`user_created_id`),
  KEY `zone_role_user_updated_id_foreign` (`user_updated_id`),
  KEY `zone_role_user_deleted_id_foreign` (`user_deleted_id`),
  CONSTRAINT `zone_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `zone_role_user_created_id_foreign` FOREIGN KEY (`user_created_id`) REFERENCES `users` (`id`),
  CONSTRAINT `zone_role_user_deleted_id_foreign` FOREIGN KEY (`user_deleted_id`) REFERENCES `users` (`id`),
  CONSTRAINT `zone_role_user_updated_id_foreign` FOREIGN KEY (`user_updated_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zone_role`
--

LOCK TABLES `zone_role` WRITE;
/*!40000 ALTER TABLE `zone_role` DISABLE KEYS */;
INSERT INTO `zone_role` VALUES (1,1,1,1,'2021-01-26 12:48:02','2021-01-26 12:48:04',NULL,NULL);
/*!40000 ALTER TABLE `zone_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-23 12:52:24
