-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: iratepolitics
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.14.04.1

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
-- Table structure for table `comment_likes`
--

DROP TABLE IF EXISTS `comment_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment_likes`
--

LOCK TABLES `comment_likes` WRITE;
/*!40000 ALTER TABLE `comment_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments_topics`
--

DROP TABLE IF EXISTS `comments_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments_topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `content` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments_topics`
--

LOCK TABLES `comments_topics` WRITE;
/*!40000 ALTER TABLE `comments_topics` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments_topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) NOT NULL,
  `followee_id` int(11) NOT NULL,
  `type` varchar(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issues`
--

DROP TABLE IF EXISTS `issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_name` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issues`
--

LOCK TABLES `issues` WRITE;
/*!40000 ALTER TABLE `issues` DISABLE KEYS */;
INSERT INTO `issues` VALUES (1,'obamacare',0,'0000-00-00 00:00:00',NULL),(2,'UN rights',0,'0000-00-00 00:00:00',NULL),(3,'syrian peace talks',0,'0000-00-00 00:00:00',NULL),(4,'global warming',0,'0000-00-00 00:00:00',NULL),(5,'fuel efficiency stan',0,'0000-00-00 00:00:00',NULL),(6,'obama stimulus',0,'0000-00-00 00:00:00',NULL),(7,'california drought',0,'0000-00-00 00:00:00',NULL),(8,'minimum wage',0,'0000-00-00 00:00:00',NULL),(9,'affirmative action',0,'0000-00-00 00:00:00',NULL),(10,'abortion',0,'0000-00-00 00:00:00',NULL),(11,'education',0,'0000-00-00 00:00:00',NULL),(12,'budget',0,'0000-00-00 00:00:00',NULL),(13,'energy',0,'0000-00-00 00:00:00',NULL),(14,'crime',0,'0000-00-00 00:00:00',NULL),(15,'environment',0,'0000-00-00 00:00:00',NULL),(16,'foreign affairs and ',0,'0000-00-00 00:00:00',NULL),(17,'healthcare',0,'0000-00-00 00:00:00',NULL),(18,'legalization of drug',0,'0000-00-00 00:00:00',NULL),(19,'immigration',0,'0000-00-00 00:00:00',NULL),(20,'civil rights',0,'0000-00-00 00:00:00',NULL),(21,'social security',0,'0000-00-00 00:00:00',NULL),(22,'guns',0,'0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issues_follows`
--

DROP TABLE IF EXISTS `issues_follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issues_follows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issues_follows`
--

LOCK TABLES `issues_follows` WRITE;
/*!40000 ALTER TABLE `issues_follows` DISABLE KEYS */;
INSERT INTO `issues_follows` VALUES (131,1,71,'2014-07-13 20:22:40','2014-07-13 20:22:40'),(132,1,72,'2014-07-13 20:28:40','2014-07-13 20:28:40'),(133,1,73,'2014-07-13 20:33:18','2014-07-13 20:33:18'),(134,10,73,'2014-07-13 20:33:18','2014-07-13 20:33:18'),(135,1,74,'2014-07-13 20:40:35','2014-07-13 20:40:35'),(136,1,75,'2014-07-13 20:44:23','2014-07-13 20:44:23'),(137,2,75,'2014-07-13 20:44:23','2014-07-13 20:44:23'),(138,6,75,'2014-07-13 20:44:23','2014-07-13 20:44:23'),(139,7,75,'2014-07-13 20:44:23','2014-07-13 20:44:23'),(140,8,75,'2014-07-13 20:44:23','2014-07-13 20:44:23'),(141,9,75,'2014-07-13 20:44:23','2014-07-13 20:44:23'),(142,14,75,'2014-07-13 20:44:23','2014-07-13 20:44:23'),(143,21,75,'2014-07-13 20:44:23','2014-07-13 20:44:23'),(144,2,76,'2014-07-14 02:59:40','2014-07-14 02:59:40'),(145,3,76,'2014-07-14 02:59:40','2014-07-14 02:59:40');
/*!40000 ALTER TABLE `issues_follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issues_news`
--

DROP TABLE IF EXISTS `issues_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issues_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issues` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issues_news`
--

LOCK TABLES `issues_news` WRITE;
/*!40000 ALTER TABLE `issues_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `issues_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issues_ratings`
--

DROP TABLE IF EXISTS `issues_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issues_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) NOT NULL,
  `politician_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issues_ratings`
--

LOCK TABLES `issues_ratings` WRITE;
/*!40000 ALTER TABLE `issues_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `issues_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `headline` varchar(60) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `source` varchar(60) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `feature_pic_url` varchar(60) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `politician_follows`
--

DROP TABLE IF EXISTS `politician_follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `politician_follows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `politician_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `politician_follows`
--

LOCK TABLES `politician_follows` WRITE;
/*!40000 ALTER TABLE `politician_follows` DISABLE KEYS */;
INSERT INTO `politician_follows` VALUES (19,3,76,'2014-07-14 12:43:41','2014-07-14 12:43:41'),(20,2,1,'2014-07-14 19:25:11','2014-07-14 19:25:11'),(21,1,76,'2014-07-15 02:06:02','2014-07-15 02:06:02');
/*!40000 ALTER TABLE `politician_follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `politicians`
--

DROP TABLE IF EXISTS `politicians`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `politicians` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `office` varchar(60) DEFAULT NULL,
  `district` varchar(60) DEFAULT NULL,
  `party` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `bio` text,
  `state` varchar(20) NOT NULL,
  `pic_url` varchar(60) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `bw_pic_url` varchar(60) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `politicians`
--

LOCK TABLES `politicians` WRITE;
/*!40000 ALTER TABLE `politicians` DISABLE KEYS */;
INSERT INTO `politicians` VALUES (1,'Nancy Pelosi','Nancy','Pelosi','Congresswoman','California\'s 12th District','Democrat','',NULL,'California','/assets/images/politicians/pelosi.jpg',0,'0000-00-00 00:00:00',NULL,'/assets/images/politicians/pelosi-bw.jpg'),(2,'Barack Obama','Barack','Obama','President','United States of America','Democrat','',NULL,'Illinois','/assets/images/politicians/obama.jpg',0,'0000-00-00 00:00:00',NULL,'/assets/images/politicians/obama-bw.jpg'),(3,'Mitt Romney','Mitt','Romney','Governor','Massachusetts','Republican','',NULL,'Massachusetts','/assets/images/politicians/romney.jpg',0,'0000-00-00 00:00:00',NULL,'/assets/images/politicians/romney-bw.jpg'),(4,'John McCain','John','McCain','Senator','Arizona','Republican','',NULL,'Arizona','/assets/images/politicians/mccain.jpg',0,'0000-00-00 00:00:00',NULL,'/assets/images/politicians/mccain-bw.jpg');
/*!40000 ALTER TABLE `politicians` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `politicians_news`
--

DROP TABLE IF EXISTS `politicians_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `politicians_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `politician_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `politicians_news`
--

LOCK TABLES `politicians_news` WRITE;
/*!40000 ALTER TABLE `politicians_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `politicians_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `politicians_ratings`
--

DROP TABLE IF EXISTS `politicians_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `politicians_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `politician_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `politicians_ratings`
--

LOCK TABLES `politicians_ratings` WRITE;
/*!40000 ALTER TABLE `politicians_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `politicians_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `politician_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratings`
--

LOCK TABLES `ratings` WRITE;
/*!40000 ALTER TABLE `ratings` DISABLE KEYS */;
INSERT INTO `ratings` VALUES (1,NULL,'2014-07-14 20:05:26','2014-07-14 20:05:26',76,1,1),(2,NULL,'2014-07-14 20:06:05','2014-07-14 20:06:05',76,1,1),(3,NULL,'2014-07-14 20:06:13','2014-07-14 20:06:13',76,1,1),(4,NULL,'2014-07-14 20:17:35','2014-07-14 20:17:35',76,1,1),(5,NULL,'2014-07-15 00:56:52','2014-07-15 00:56:52',76,4,4),(6,NULL,'2014-07-15 02:07:17','2014-07-15 02:07:17',76,1,1);
/*!40000 ALTER TABLE `ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_follows`
--

DROP TABLE IF EXISTS `user_follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_follows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `followee_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_follows`
--

LOCK TABLES `user_follows` WRITE;
/*!40000 ALTER TABLE `user_follows` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `password_temp` varchar(60) NOT NULL,
  `code` varchar(60) NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `bio` text,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `party` varchar(20) NOT NULL,
  `pic_url` varchar(100) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `birth_month` int(2) NOT NULL,
  `birth_day` int(2) NOT NULL,
  `birth_year` int(2) NOT NULL,
  `sex` varchar(2) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'quantumcas@gmail.com','quantumcas','$2y$10$7chEwOEl14F9WRkM/z.zb.kHy0jGAzjSkahrCWEGFSkzEPcbe8DU2','','DBFz4L9XsB2aJH7Ay3D9IRxqW8nGr63ifxTFtmwGkS6PzVuDUyajH0McRNtJ',1,'2014-07-08 02:28:50','2014-07-14 19:26:18','xEmVwu4r2JGuJzeYJnBxUp8O6kfH9xdCq7N0FI0f9W7pKVuV4BNoZT33VowO',NULL,'Howdy folks! Im a newly registered Texas voter whose very concerned about the direction my new home state and my country is going in and the quality and accuracy of news being pushed by mainstream media. Though my biggest concern is the economy, I try to stay abreast on a few social issues that interest me.','','','Libertarian','/assets/images/avatars/me-avatar.jpg','Austin','Texas',0,0,0,''),(2,'viq.jennings@gmail.com','ViqSoulChild','$2y$10$KSEv/Qk9mA/r8OTWPBgjpOJVfpdnrqTcKpiQnASx6wluYXqQiVVge','','L1GdaKYnJkkN8CW7p8IR2n6eb1S5G3xOkF2ZhEh6XAjPIu0Ba9mvuA8QkOQH',1,'2014-07-09 15:50:39','2014-07-09 15:51:51','PBvRWoWfJbWvBpDArVQTexLaz07NirKPp2r8I5KowuvM4vw6I0znwYgob6xf',NULL,NULL,'','','','','','',0,0,0,''),(76,'john.kenneth.williams@gmail.com','jkw','$2y$10$qP2JLtgSndDJDp4/Zs.8v.mxcyIKvGxYOVmVtPRzFk6i96Bk38Kae','','ydaftfuRUP9A8azL48KaRhChX4c1lhjENYddFuZihsELWbg657r90HbZCHUl',1,'2014-07-14 02:59:40','2014-07-14 02:59:40',NULL,NULL,NULL,'','','','','','',0,0,0,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-15  2:33:26
