-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: edc_db
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `province`
--

-- DROP TABLE IF EXISTS `province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
-- CREATE TABLE `province` (
--   `id` int unsigned NOT NULL AUTO_INCREMENT,
--   `province_name` varchar(255) DEFAULT NULL,
--   `status` int DEFAULT NULL,
--   PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `province`
--

LOCK TABLES `province` WRITE;
/*!40000 ALTER TABLE `province` DISABLE KEYS */;
INSERT INTO `province` VALUES (1,'ACEH',1),(2,'SUMATERA UTARA',1),(3,'SUMATERA BARAT',1),(4,'RIAU',1),(5,'JAMBI',1),(6,'SUMATERA SELATAN',1),(7,'BENGKULU',1),(8,'LAMPUNG',1),(9,'KEPULAUAN BANGKA BELITUNG',1),(10,'KEPULAUAN RIAU',1),(11,'DKI JAKARTA',1),(12,'JAWA BARAT',1),(13,'JAWA TENGAH',1),(14,'DI YOGYAKARTA',1),(15,'JAWA TIMUR',1),(16,'BANTEN',1),(17,'BALI',1),(18,'NUSA TENGGARA BARAT',1),(19,'NUSA TENGGARA TIMUR',1),(20,'KALIMANTAN BARAT',1),(21,'KALIMANTAN TENGAH',1),(22,'KALIMANTAN SELATAN',1),(23,'KALIMANTAN TIMUR',1),(24,'KALIMANTAN UTARA',1),(25,'SULAWESI UTARA',1),(26,'SULAWESI TENGAH',1),(27,'SULAWESI SELATAN',1),(28,'SULAWESI TENGGARA',1),(29,'GORONTALO',1),(30,'SULAWESI BARAT',1),(31,'MALUKU',1),(32,'MALUKU UTARA',1),(33,'PAPUA',1),(34,'PAPUA BARAT',1);
/*!40000 ALTER TABLE `province` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-02 16:01:53
