-- MySQL dump 10.13  Distrib 5.1.49, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: grapevine
-- ------------------------------------------------------
-- Server version	5.1.49-1ubuntu8

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
-- Table structure for table `alert_emails`
--

DROP TABLE IF EXISTS `alert_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_emails` (
  `alert_id` int(11) NOT NULL,
  `emails_id` int(11) NOT NULL,
  PRIMARY KEY (`alert_id`,`emails_id`),
  KEY `fk_alert_emails_alerts` (`alert_id`),
  KEY `fk_alert_emails_emails` (`emails_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alert_emails`
--

LOCK TABLES `alert_emails` WRITE;
/*!40000 ALTER TABLE `alert_emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `alert_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alerts`
--

DROP TABLE IF EXISTS `alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `type` varchar(12) NOT NULL,
  `criteria` text NOT NULL COMMENT 'only typed text to work with custom keyword entries\n',
  `use_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_alerts_locations` (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerts`
--

LOCK TABLES `alerts` WRITE;
/*!40000 ALTER TABLE `alerts` DISABLE KEYS */;
INSERT INTO `alerts` VALUES (1,1,'grapevine','aggravate, aggravated, angry, annoy, annoyed, argue, attack, attacked, awful, bad, badgered, belittle, belittled, bitch, bitched, boring, bother, bothered, bullied, bully, cheat, cheated, clueless, conn, conned, cowardly, crap, crappy, criticized, criticized, damage, damaged, defective, defiant, degrade, degraded, dehumanized, demean, demeaned, despicable, dirty, disagreeable, disappointed, disappointing, discriminate, discriminated, dishonest, dislike, disliked, disrespect, disrespected, dumb, egotistical, embarrass, embarrassed, fake, frustrated, furious, harass, harassed, hateful, horrible, ill-temper, ill-tempered, incompetent, infuriate, infuriated, insult, insulted, irritate, irritated, lied, mad, mean, mistreat, mistreated, offend, offended, phony, pissed, ridiculous, rude, sarcastic',0),(2,8,'grapevine','aggravate, aggravated, angry, annoy, annoyed, argue, attack, attacked, awful, bad, badgered, belittle, belittled, bitch, bitched, boring, bother, bothered, bullied, bully, cheat, cheated, clueless, conn, conned, cowardly, crap, crappy, criticized, criticized, damage, damaged, defective, defiant, degrade, degraded, dehumanized, demean, demeaned, despicable, dirty, disagreeable, disappointed, disappointing, discriminate, discriminated, dishonest, dislike, disliked, disrespect, disrespected, dumb, egotistical, embarrass, embarrassed, fake, frustrated, furious, harass, harassed, hateful, horrible, ill-temper, ill-tempered, incompetent, infuriate, infuriated, insult, insulted, irritate, irritated, lied, mad, mean, mistreat, mistreated, offend, offended, phony, pissed, ridiculous, rude, sarcastic',0);
/*!40000 ALTER TABLE `alerts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alerts_emails`
--

DROP TABLE IF EXISTS `alerts_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alerts_emails` (
  `alert_id` int(11) NOT NULL,
  `email_id` int(11) NOT NULL,
  PRIMARY KEY (`alert_id`,`email_id`),
  KEY `fk_alert_emails_alerts` (`alert_id`),
  KEY `fk_alert_emails_emails` (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerts_emails`
--

LOCK TABLES `alerts_emails` WRITE;
/*!40000 ALTER TABLE `alerts_emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `alerts_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `box_settings`
--

DROP TABLE IF EXISTS `box_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `box_settings` (
  `holder_id` varchar(100) NOT NULL COMMENT 'this option is ignored when box is pinned to dashboard',
  `location_id` int(11) NOT NULL COMMENT 'this option is to set settings for proper location and only for them',
  `box_id` varchar(100) DEFAULT NULL,
  `is_pinned` tinyint(1) NOT NULL COMMENT 'determine if box is pinned to dashboard\n',
  `box_class` varchar(100) NOT NULL COMMENT 'when box is pinned we need to append it to existing boxes so box_class is to determine which box holder we need to create',
  `section_id` varchar(50) NOT NULL COMMENT 'when holder is generated dynamically we need to have position in dom model of holder so we have index',
  PRIMARY KEY (`holder_id`,`location_id`),
  KEY `location_idx` (`location_id`),
  KEY `section_idx` (`section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `box_settings`
--

LOCK TABLES `box_settings` WRITE;
/*!40000 ALTER TABLE `box_settings` DISABLE KEYS */;
INSERT INTO `box_settings` VALUES ('dashboard-4',1,'box-ogsi',0,'box-container active hide','dashboard'),('dashboard-5',1,'box-recent-reviews',0,'box-container active hide','dashboard'),('dashboard-6',1,'box-review-sites',0,'box-container active box-container-left hide','dashboard'),('dashboard-7',1,'box-social-activity',0,'box-container active box-container-right hide','dashboard'),('social-4',1,'box-status-updates',0,'box-container active hide','social'),('social-5',1,'box-social-activity',0,'box-container active box-container-left hide','social'),('social-6',1,'box-social-reach',0,'box-container active box-container-right hide','social'),('social-8',1,'box-social-media-inbox',0,'box-container active hide','social'),('review_breakdown-4',1,'box-review-sites',0,'box-container active box-container-left hide','review_breakdown'),('review_breakdown-5',1,'box-tags-analysis',0,'box-container active box-container-right hide','review_breakdown'),('review_breakdown-7',1,'box-recent-reviews',0,'box-container active ignore hide','review_breakdown'),('competition-4',1,'box-competition-score',0,'box-container active ui-droppable','competition'),('competition-6',1,'box-competition-comparision',0,'box-container active ui-droppable','competition'),('competition-7',1,'box-competition-distribution',0,'box-container active hide','competition'),('competition-8',1,'box-competition-review-inbox',0,'box-container active ignore hide','competition');
/*!40000 ALTER TABLE `box_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'Best Chevrolet'),(2,'Banner Chevrolet'),(3,'Bryan Chevrolet'),(4,'Levis Chevrolet Cadillac'),(5,'Hood Northlake Chevrolet'),(6,'Ross Downing Chevrolet'),(7,'Rainbow Chevrolet'),(8,'Lion & Rose British Restaurant & Pub -- Broadway'),(9,'Mad Dogs British Pub‎'),(10,'Fox and Hound'),(11,'Durty Nelly\'s Irish Pub‎'),(12,'Waxy Oconnors Irish Pub‎'),(13,'The Hangar‎'),(14,'Broadway 50 50‎');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies_locations`
--

DROP TABLE IF EXISTS `companies_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies_locations` (
  `location_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`location_id`,`company_id`),
  KEY `fk_locations_company` (`company_id`),
  KEY `fk_locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies_locations`
--

LOCK TABLES `companies_locations` WRITE;
/*!40000 ALTER TABLE `companies_locations` DISABLE KEYS */;
INSERT INTO `companies_locations` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10),(11,11),(12,12),(13,13),(14,14);
/*!40000 ALTER TABLE `companies_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies_users`
--

DROP TABLE IF EXISTS `companies_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies_users` (
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level` tinyint(3) unsigned NOT NULL COMMENT '0 - owner, 1 - admin, 2 - read only',
  PRIMARY KEY (`company_id`,`user_id`),
  KEY `fk_user` (`user_id`),
  KEY `fk_comany` (`company_id`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies_users`
--

LOCK TABLES `companies_users` WRITE;
/*!40000 ALTER TABLE `companies_users` DISABLE KEYS */;
INSERT INTO `companies_users` VALUES (1,1,0),(2,1,0),(3,1,0),(4,1,0),(5,1,0),(6,1,0),(7,1,0),(8,3,0),(9,3,0),(10,3,0),(11,3,0),(12,3,0),(13,3,0),(14,3,0);
/*!40000 ALTER TABLE `companies_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_locations`
--

DROP TABLE IF EXISTS `company_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_locations` (
  `location_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`location_id`,`company_id`),
  KEY `fk_locations_company` (`company_id`),
  KEY `fk_locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_locations`
--

LOCK TABLES `company_locations` WRITE;
/*!40000 ALTER TABLE `company_locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_users`
--

DROP TABLE IF EXISTS `company_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_users` (
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`company_id`,`user_id`),
  KEY `fk_user` (`user_id`),
  KEY `fk_comany` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_users`
--

LOCK TABLES `company_users` WRITE;
/*!40000 ALTER TABLE `company_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emails`
--

DROP TABLE IF EXISTS `emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(200) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_emails_locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emails`
--

LOCK TABLES `emails` WRITE;
/*!40000 ALTER TABLE `emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location_settings`
--

DROP TABLE IF EXISTS `location_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL COMMENT 'competitor,newsletter,facebook_oauth_token,twitter_search,twitter_account,filter_search,gblog_search,youtube_search',
  `value` varchar(225) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`location_id`),
  KEY `fk_location_settings_locations` (`location_id`),
  KEY `idx_setting_type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location_settings`
--

LOCK TABLES `location_settings` WRITE;
/*!40000 ALTER TABLE `location_settings` DISABLE KEYS */;
INSERT INTO `location_settings` VALUES (1,'competitor','2',1),(2,'competitor','3',1),(3,'competitor','4',1),(4,'competitor','5',1),(5,'competitor','6',1),(6,'competitor','7',1),(16,'facebook_oauth_token','224929787553573|a880de56e5807b8c913688f3.1-680530433|240572177308|pQ7Td4UMKoESHp7jtZi_oHa2kp0',1),(17,'facebook_page_id','240572177308',1),(18,'facebook_page_name','BEST Chevrolet',1),(19,'twitter_oauth_token_secret','4xdK43XTnfsTeeJXv0nS8N7X02tR3umiMrfhOp4o',1),(20,'twitter_oauth_token','102803822-5S3hNIOOPxdMR2xryKIMre5YVI9OEsEjI92DFFyo',1),(21,'twitter_account','BESTChevrolet',1),(22,'competitor','9',8),(23,'competitor','10',8),(24,'competitor','11',8),(25,'competitor','12',8),(26,'competitor','13',8),(27,'competitor','14',8);
/*!40000 ALTER TABLE `location_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location_users`
--

DROP TABLE IF EXISTS `location_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location_users` (
  `location_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`location_id`,`user_id`),
  KEY `fk_location_users_locations` (`location_id`),
  KEY `fk_location_users_users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location_users`
--

LOCK TABLES `location_users` WRITE;
/*!40000 ALTER TABLE `location_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `location_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL COMMENT 'ID of the company',
  `name` varchar(50) DEFAULT NULL,
  `address1` varchar(45) DEFAULT NULL,
  `address2` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(12) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `owner_name` varchar(45) DEFAULT NULL,
  `owner_email` varchar(255) DEFAULT NULL,
  `owner_phone` varchar(20) DEFAULT NULL,
  `owner_ext` varchar(45) DEFAULT NULL,
  `billing_type` enum('charge','invoice') DEFAULT NULL,
  `package` enum('starter','pro') DEFAULT NULL,
  `industry` enum('automotive','hospitality','restaurant') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `idx_location_email` (`owner_email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,0,'Best Chevrolet','2600 Veterans Blvd','','Kenner','LA','70062','5044689817',NULL,NULL,'cklotz@bestchevrolet.com','5044712329',NULL,'','pro','automotive'),(2,0,'Banner Chevrolet','5950 Chef Menteur Highway','','New Orleans','LA','70126',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','automotive'),(3,0,'Bryan Chevrolet','8213 Airline Dr.','','Metairie','LA','70003',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','automotive'),(4,0,'Levis Chevrolet Cadillac','316 Howze Beach Rd.','','Slidell','LA','70461',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','automotive'),(5,0,'Hood Northlake Chevrolet','69020 N Hy 190','','Covington','LA','70433',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','automotive'),(6,0,'Ross Downing Chevrolet','600 South Morrison Boulevard','','Hammond','LA','70403',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','automotive'),(7,0,'Rainbow Chevrolet','2020 W Airline Hwy','','LaPlace','LA','70068',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','automotive'),(8,0,'Lion & Rose British Restaurant & Pub -- Broadway','5148 Broadway Street','','San Antonio','TX','78209','2100000000',NULL,NULL,'test@pickgrapevine.com','2100000000',NULL,NULL,'pro','restaurant'),(9,0,'Mad Dogs British Pub‎','123 Losoya Street','','San Antonio','tx','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant'),(10,0,'Fox and Hound','12651 Vance Jackson Rd # 110','','San Antonio','Tx','78230',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant'),(11,0,'Durty Nelly\'s Irish Pub‎','200 South Alamo Street','','San Antonio','tx','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant'),(12,0,'Waxy Oconnors Irish Pub‎','234 River Walk Street','','San Antonio','tx','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant'),(13,0,'The Hangar‎','8203 Broadway Street','','San Antonio','tx','78209',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant'),(14,0,'Broadway 50 50‎','5050 Broadway Street','','San Antonio','tx','78209',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations_users`
--

DROP TABLE IF EXISTS `locations_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations_users` (
  `location_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level` tinyint(3) unsigned NOT NULL COMMENT '0 - owner, 1 - admin, 2 - read only',
  PRIMARY KEY (`location_id`,`user_id`),
  KEY `fk_location_users_locations` (`location_id`),
  KEY `fk_location_users_users` (`user_id`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations_users`
--

LOCK TABLES `locations_users` WRITE;
/*!40000 ALTER TABLE `locations_users` DISABLE KEYS */;
INSERT INTO `locations_users` VALUES (1,1,0),(2,2,0),(3,2,0),(4,2,0),(5,2,0),(6,2,0),(7,2,0),(8,3,0),(9,2,0),(10,2,0),(11,2,0),(12,2,0),(13,2,0),(14,2,0);
/*!40000 ALTER TABLE `locations_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters` (
  `email_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`email_id`,`location_id`),
  KEY `fk_newsletters_emails` (`email_id`,`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'login','standard role for users able to login');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_users`
--

DROP TABLE IF EXISTS `roles_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_users`
--

LOCK TABLES `roles_users` WRITE;
/*!40000 ALTER TABLE `roles_users` DISABLE KEYS */;
INSERT INTO `roles_users` VALUES (1,1),(3,1);
/*!40000 ALTER TABLE `roles_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_tokens`
--

DROP TABLE IF EXISTS `user_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_tokens` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_tokens`
--

LOCK TABLES `user_tokens` WRITE;
/*!40000 ALTER TABLE `user_tokens` DISABLE KEYS */;
INSERT INTO `user_tokens` VALUES (1,1,'7bf266f22adb530d048f1dcb30782af80f650652','f2c5b2bea518fc25ada9f9b089af2007a8954b3c','',0,1315504869),(4,3,'7bf266f22adb530d048f1dcb30782af80f650652','37a6068570a9009522d3097dd825d3dbfe299a36','',0,1315511553),(7,1,'dda3735ade73e505ca0084618251923588d45468','2cd018d4b71da993b1942f705c8d5539420100f0','',0,1315521285),(8,3,'983cef817d6c1910f976f1a785c25b5947530cbb','dad82e02067664754537b422b9e7d5cfb7d670b0','',0,1315521827),(9,1,'03dce517cd527288031620f0c2addcf4c6df211e','539a25dbd4f5af4b7a5e2c99ed528ad5d6884a82','',0,1315839732),(10,1,'dda3735ade73e505ca0084618251923588d45468','bd6e44bb1624a3708420f8a74bbe166a9c030338','',0,1315967898),(11,1,'02a951bacaf90d84d5425d28ba850065db292f76','b6188f09fa9bbbe4c8a18f07f17468fc0b69fa53','',0,1315986717),(12,1,'17d43d9c883c8b6f3966be84a3cbc584b2224e92','0e7ecc3db22b45e7aac3a93b4ed6d3ef1ff19da8','',0,1315988898),(13,1,'b6ceb78682f77146efb9074f68d46f80750d4c42','bc41b16bf23a0978a54f4c134ba691d3065216e0','',0,1315998377),(14,1,'95b2b571541280418aca5b72810e3fa3919b44d3','48638d5ff0ea7bb261e5b2c34b04f64eee5a2d8a','',0,1316072539);
/*!40000 ALTER TABLE `user_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logins` int(10) NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(127) NOT NULL,
  `password` varchar(64) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,21,1314862939,'cklotz','cklotz@bestchevrolet.com','49e55f6eaf9d8a3f2120ba01fbcc9a5b26a14a15','Chris','Klotz','5044712329'),(2,0,NULL,'grapevine','dummy@grapevinebeta.com','560f787306cbddcf728f65e0dccc5796d2adfa13','dummy','user','1111111111'),(3,7,1314629849,'lionrose','test@pickgrapevine.com','6af234d98097d58bae34d0205fead1ce5177790d','Lion','Rose','2100000000');
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

-- Dump completed on 2011-09-01  7:48:48
