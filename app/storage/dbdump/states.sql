-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: usapolitics.db.9870812.hostedresource.com    Database: usapolitics
-- ------------------------------------------------------
-- Server version	5.0.96-log

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
-- Not dumping tablespaces as no INFORMATION_SCHEMA.FILES table on this server
--

--
-- Table structure for table `tbl_states`
--

DROP TABLE IF EXISTS `tbl_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_states` (
  `state_id` int(11) NOT NULL auto_increment,
  `state_title` varchar(255) NOT NULL,
  `state_description` text NOT NULL,
  `state_status` enum('pending','active','suspend','inactive') NOT NULL,
  PRIMARY KEY  (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_states`
--

LOCK TABLES `tbl_states` WRITE;
/*!40000 ALTER TABLE `tbl_states` DISABLE KEYS */;
INSERT INTO `tbl_states` VALUES (1,'Alaska','Alaska','active'),(2,'Alabama','Alabama','active'),(3,'Arkansas','Arkansas','active'),(4,'Arizona','Arizona','active'),(5,'California','California','active'),(6,'Colorado','Colorado','active'),(7,'Connecticut','Connecticut','active'),(8,'District of Columbia','District of Columbia','active'),(9,'Delaware','Delaware','active'),(10,'Florida','Florida','active'),(11,'Georgia','Georgia','active'),(12,'Hawaii','Hawaii','active'),(13,'Iowa','Iowa','active'),(14,'Idaho','Idaho','active'),(15,'Illinois','Illinois','active'),(16,'Indiana','Indiana','active'),(17,'Kansas','Kansas','active'),(18,'Kentucky','Kentucky','active'),(19,'Louisiana','Louisiana','active'),(20,'Massachusetts','Massachusetts','active'),(21,'Maryland','Maryland','active'),(22,'Maine','Maine','active'),(23,'Michigan','Michigan','active'),(24,'Minnesota','Minnesota','active'),(25,'Missouri','Missouri','active'),(26,'Mississippi','Mississippi','active'),(27,'Montana','Montana','active'),(28,'North Carolina','North Carolina','active'),(29,'North Dakota','North Dakota','active'),(30,'Nebraska','Nebraska','active'),(31,'New Hampshire','New Hampshire','active'),(32,'New Jersey','New Jersey','active'),(33,'New Mexico','New Mexico','active'),(34,'Nevada','Nevada','active'),(35,'New York','New York','active'),(36,'Ohio','Ohio','active'),(37,'Oklahoma','Oklahoma','active'),(38,'Oregon','Oregon','active'),(39,'Pennsylvania','Pennsylvania','active'),(40,'Rhode Island','Rhode Island','active'),(41,'South Carolina','South Carolina','active'),(42,'South Dakota','South Dakota','active'),(43,'Tennessee','Tennessee','active'),(44,'Texas','Texas','active'),(45,'Utah','Utah','active'),(46,'Virginia','Virginia','active'),(47,'Vermont','Vermont','active'),(48,'Washington','Washington','active'),(49,'Wisconsin','Wisconsin','active'),(50,'West Virginia','West Virginia','active'),(51,'Wyoming','Wyoming','active');
/*!40000 ALTER TABLE `tbl_states` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-08-17 22:12:16
