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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerts`
--

LOCK TABLES `alerts` WRITE;
/*!40000 ALTER TABLE `alerts` DISABLE KEYS */;
INSERT INTO `alerts` VALUES (1,1,'grapevine','aggravate, aggravated, angry, annoy, annoyed, argue, attack, attacked, awful, bad, badgered, belittle, belittled, bitch, bitched, boring, bother, bothered, bullied, bully, cheat, cheated, clueless, conn, conned, cowardly, crap, crappy, criticized, criticized, damage, damaged, defective, defiant, degrade, degraded, dehumanized, demean, demeaned, despicable, dirty, disagreeable, disappointed, disappointing, discriminate, discriminated, dishonest, dislike, disliked, disrespect, disrespected, dumb, egotistical, embarrass, embarrassed, fake, frustrated, furious, harass, harassed, hateful, horrible, ill-temper, ill-tempered, incompetent, infuriate, infuriated, insult, insulted, irritate, irritated, lied, mad, mean, mistreat, mistreated, offend, offended, phony, pissed, ridiculous, rude, sarcastic',0),(2,8,'grapevine','aggravate, aggravated, angry, annoy, annoyed, argue, attack, attacked, awful, bad, badgered, belittle, belittled, bitch, bitched, boring, bother, bothered, bullied, bully, cheat, cheated, clueless, conn, conned, cowardly, crap, crappy, criticized, criticized, damage, damaged, defective, defiant, degrade, degraded, dehumanized, demean, demeaned, despicable, dirty, disagreeable, disappointed, disappointing, discriminate, discriminated, dishonest, dislike, disliked, disrespect, disrespected, dumb, egotistical, embarrass, embarrassed, fake, frustrated, furious, harass, harassed, hateful, horrible, ill-temper, ill-tempered, incompetent, infuriate, infuriated, insult, insulted, irritate, irritated, lied, mad, mean, mistreat, mistreated, offend, offended, phony, pissed, ridiculous, rude, sarcastic',0),(3,15,'grapevine','aggravate, aggravated, angry, annoy, annoyed, argue, attack, attacked, awful, bad, badgered, belittle, belittled, bitch, bitched, boring, bother, bothered, bullied, bully, cheat, cheated, clueless, conn, conned, cowardly, crap, crappy, criticized, criticized, damage, damaged, defective, defiant, degrade, degraded, dehumanized, demean, demeaned, despicable, dirty, disagreeable, disappointed, disappointing, discriminate, discriminated, dishonest, dislike, disliked, disrespect, disrespected, dumb, egotistical, embarrass, embarrassed, fake, frustrated, furious, harass, harassed, hateful, horrible, ill-temper, ill-tempered, incompetent, infuriate, infuriated, insult, insulted, irritate, irritated, lied, mad, mean, mistreat, mistreated, offend, offended, phony, pissed, ridiculous, rude, sarcastic',0),(4,22,'grapevine','aggravate, aggravated, angry, annoy, annoyed, argue, attack, attacked, awful, bad, badgered, belittle, belittled, bitch, bitched, boring, bother, bothered, bullied, bully, cheat, cheated, clueless, conn, conned, cowardly, crap, crappy, criticized, criticized, damage, damaged, defective, defiant, degrade, degraded, dehumanized, demean, demeaned, despicable, dirty, disagreeable, disappointed, disappointing, discriminate, discriminated, dishonest, dislike, disliked, disrespect, disrespected, dumb, egotistical, embarrass, embarrassed, fake, frustrated, furious, harass, harassed, hateful, horrible, ill-temper, ill-tempered, incompetent, infuriate, infuriated, insult, insulted, irritate, irritated, lied, mad, mean, mistreat, mistreated, offend, offended, phony, pissed, ridiculous, rude, sarcastic',0);
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
INSERT INTO `box_settings` VALUES ('review_breakdown-4',22,'box-review-sites',0,'box-container active box-container-left hide','review_breakdown'),('review_breakdown-5',22,'box-tags-analysis',0,'box-container active box-container-right hide','review_breakdown'),('review_breakdown-7',22,'box-recent-reviews',0,'box-container active ignore hide','review_breakdown'),('competition-4',22,'box-competition-comparision',0,'box-container active ui-droppable','competition'),('competition-6',22,'box-competition-score',0,'box-container active hide','competition'),('competition-7',22,'box-competition-distribution',0,'box-container active hide','competition'),('competition-8',22,'box-competition-review-inbox',0,'box-container active ignore hide','competition'),('_alerts_alert-0',22,'box-recent-reviews',0,'box-container active ui-droppable','_alerts_alert'),('dashboard-4',22,'box-ogsi',0,'box-container active hide','dashboard'),('dashboard-5',22,'box-competition-score',0,'box-container active ui-droppable','dashboard'),('dashboard-6',22,'box-recent-reviews',0,'box-container active ui-droppable box-dropable','dashboard'),('dashboard-4',1,'box-ogsi',0,'box-container active hide','dashboard'),('dashboard-5',1,'box-recent-reviews',0,'box-container active hide','dashboard'),('dashboard-6',1,'box-competition-score',0,'box-container active hide','dashboard'),('_alerts_alert-0',1,'box-recent-reviews',0,'box-container active hide','_alerts_alert'),('_alerts_todo-0',22,'box-recent-reviews',0,'box-container active hide','_alerts_todo'),('review_breakdown-4',1,'box-review-sites',0,'box-container active box-container-left hide','review_breakdown'),('review_breakdown-5',1,'box-tags-analysis',0,'box-container active box-container-right hide','review_breakdown'),('review_breakdown-7',1,'box-recent-reviews',0,'box-container active ignore hide','review_breakdown'),('competition-4',1,'box-competition-comparision',0,'box-container active hide','competition'),('competition-6',1,'box-competition-score',0,'box-container active hide','competition'),('competition-7',1,'box-competition-distribution',0,'box-container active hide','competition'),('competition-8',1,'box-competition-review-inbox',0,'box-container active ignore hide','competition');
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
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'Best Chevrolet',''),(2,'Banner Chevrolet',''),(3,'Bryan Chevrolet',''),(4,'Levis Chevrolet Cadillac',''),(5,'Hood Northlake Chevrolet',''),(6,'Ross Downing Chevrolet',''),(7,'Rainbow Chevrolet',''),(8,'Lion & Rose British Restaurant & Pub -- Broadway',''),(9,'Mad Dogs British Pub‎',''),(10,'Fox and Hound',''),(11,'Durty Nelly\'s Irish Pub‎',''),(12,'Waxy Oconnors Irish Pub‎',''),(13,'The Hangar‎',''),(14,'Broadway 50 50‎',''),(25,'River Enterprises LLC','info-river@pickgrapevine.com');
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
INSERT INTO `companies_locations` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10),(11,11),(12,12),(13,13),(14,14),(22,25),(29,25);
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
INSERT INTO `companies_users` VALUES (1,1,0),(8,3,0),(15,4,0),(25,8,0),(25,9,0),(25,10,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emails`
--

LOCK TABLES `emails` WRITE;
/*!40000 ALTER TABLE `emails` DISABLE KEYS */;
INSERT INTO `emails` VALUES (1,'richard@pickgrapevine.com',22);
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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location_settings`
--

LOCK TABLES `location_settings` WRITE;
/*!40000 ALTER TABLE `location_settings` DISABLE KEYS */;
INSERT INTO `location_settings` VALUES (1,'competitor','2',1),(2,'competitor','3',1),(3,'competitor','4',1),(4,'competitor','5',1),(5,'competitor','6',1),(6,'competitor','7',1),(16,'facebook_oauth_token','224929787553573|a880de56e5807b8c913688f3.1-680530433|240572177308|pQ7Td4UMKoESHp7jtZi_oHa2kp0',1),(17,'facebook_page_id','240572177308',1),(18,'facebook_page_name','BEST Chevrolet',1),(19,'twitter_oauth_token_secret','4xdK43XTnfsTeeJXv0nS8N7X02tR3umiMrfhOp4o',1),(20,'twitter_oauth_token','102803822-5S3hNIOOPxdMR2xryKIMre5YVI9OEsEjI92DFFyo',1),(21,'twitter_account','BESTChevrolet',1),(22,'competitor','9',8),(23,'competitor','10',8),(24,'competitor','11',8),(25,'competitor','12',8),(26,'competitor','13',8),(27,'competitor','14',8),(34,'competitor','23',22),(35,'competitor','24',22),(36,'competitor','25',22),(37,'competitor','26',22),(38,'competitor','27',22),(39,'competitor','28',22),(40,'competitor','30',29),(41,'competitor','31',29),(42,'competitor','32',29),(43,'competitor','33',29),(44,'competitor','34',29),(45,'competitor','35',29),(49,'facebook_oauth_token','AAADMkowWJyUBALO75WrRiOrL5kZASf18tZBvlZBM1t4kEuT9TE2cxALsFTER4eYivFasoYIT6aoCRB1OfveHO0eDFn3DgtyGR4gtErBs6yNoI9fYcwX',22),(50,'facebook_page_id','225509304157435',22),(51,'facebook_page_name','Adamczewski inc.',22);
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
  `send_out_alerts` tinyint(1) NOT NULL,
  `billable_email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `idx_location_email` (`owner_email`),
  KEY `billable_email` (`billable_email`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,0,'Best Chevrolet','2600 Veterans Blvd','','Kenner','LA','70062','5044689817',NULL,NULL,'cklotz@bestchevrolet.com','5044712329',NULL,'','pro','automotive',0,'cklotz@bestchevrolet.com'),(2,0,'Banner Chevrolet','5950 Chef Menteur Highway','','New Orleans','LA','70126',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','automotive',0,'dummy@grapevinebeta.com'),(3,0,'Bryan Chevrolet','8213 Airline Dr.','','Metairie','LA','70003',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','automotive',0,'dummy@grapevinebeta.com'),(4,0,'Levis Chevrolet Cadillac','316 Howze Beach Rd.','','Slidell','LA','70461',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','automotive',0,'dummy@grapevinebeta.com'),(5,0,'Hood Northlake Chevrolet','69020 N Hy 190','','Covington','LA','70433',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','automotive',0,'dummy@grapevinebeta.com'),(6,0,'Ross Downing Chevrolet','600 South Morrison Boulevard','','Hammond','LA','70403',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','automotive',0,'dummy@grapevinebeta.com'),(7,0,'Rainbow Chevrolet','2020 W Airline Hwy','','LaPlace','LA','70068',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','automotive',0,'dummy@grapevinebeta.com'),(8,0,'Lion & Rose British Restaurant & Pub -- Broadway','5148 Broadway Street','','San Antonio','TX','78209','2100000000',NULL,NULL,'test@pickgrapevine.com','2100000000',NULL,NULL,'pro','restaurant',0,'test@pickgrapevine.com'),(9,0,'Mad Dogs British Pub‎','123 Losoya Street','','San Antonio','tx','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,'dummy@grapevinebeta.com'),(10,0,'Fox and Hound','12651 Vance Jackson Rd # 110','','San Antonio','Tx','78230',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,'dummy@grapevinebeta.com'),(11,0,'Durty Nelly\'s Irish Pub‎','200 South Alamo Street','','San Antonio','tx','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,'dummy@grapevinebeta.com'),(12,0,'Waxy Oconnors Irish Pub‎','234 River Walk Street','','San Antonio','tx','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,'dummy@grapevinebeta.com'),(13,0,'The Hangar‎','8203 Broadway Street','','San Antonio','tx','78209',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,'dummy@grapevinebeta.com'),(14,0,'Broadway 50 50‎','5050 Broadway Street','','San Antonio','tx','78209',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,'dummy@grapevinebeta.com'),(22,25,'Boudro\'s On The Riverwalk',NULL,'','San Antonio','TX','78205','1111111111',NULL,NULL,'randy@boudros.com','1111111111',NULL,'','pro','restaurant',0,'info-river@pickgrapevine.com'),(23,0,'Bohanan\'s Prime Steaks-Seafood','219 East Houston St # 275','','San Antonio','TX','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,''),(24,0,'Little Rhein Steak House','231 South Alamo Street','','San Antonio','TX','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,''),(25,0,'Lone Star Cafe','237 Losoya Street','','San Antonio','TX','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,''),(26,0,'Luke - San Antonio River Walk','175 East Houston Street','','San Antonio','TX','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,''),(27,0,'Biga Riverwalk Restaurant','203 South St Marys Street','','San Antonio','TX','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,''),(28,0,'Texas de Brazil San Antonio','313 East Houston Street','','San Antonio','TX','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,''),(29,25,'Zinc Bistro & Wine Bar',NULL,'','San Antonio','TX','78205','2102242900',NULL,NULL,'randy-1@boudros.com','2102242900',NULL,'','','restaurant',0,'info-river@pickgrapevine.com'),(30,0,'20nine Restaurant & Wine Bar','255 E. Basse Rd. Ste 940','','San Antonio','TX','78209',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,''),(31,0,'Max\'s Wine Dive','340 East Basse Road #101','','San Antonio','TX','78209',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,''),(32,0,'BIN 555 Restaurant & Wine Bar','555 West Bitters Road','','San Antonio','TX','78216',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,''),(33,0,'Silo Elevated Cuisine','434 N SL, 1604 W','','San Antonio','TX','78258',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,''),(34,0,'SoHo Wine & Martini Bar','214 W Crockett','','San Antonio','TX','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,''),(35,0,'Esquire Tavern','155 East Commerce Street','','San Antonio','TX','78205',NULL,NULL,'dummy user','dummy@grapevinebeta.com',NULL,NULL,'','','restaurant',0,'');
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
INSERT INTO `locations_users` VALUES (1,1,0),(2,2,0),(3,2,0),(4,2,0),(5,2,0),(6,2,0),(7,2,0),(8,3,0),(9,2,0),(10,2,0),(11,2,0),(12,2,0),(13,2,0),(14,2,0),(22,9,0),(29,10,0),(22,12,1),(29,11,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'login','standard role for users able to login'),(2,'location_owner','Main user account of the location'),(3,'company_owner','Main user account of the company');
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
INSERT INTO `roles_users` VALUES (1,1),(3,1),(4,1),(8,1),(9,1),(10,1),(11,1),(12,1),(9,2),(10,2),(8,3);
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
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_tokens`
--

LOCK TABLES `user_tokens` WRITE;
/*!40000 ALTER TABLE `user_tokens` DISABLE KEYS */;
INSERT INTO `user_tokens` VALUES (83,8,'0e510d3d20a21e5d2f80c934fbf8697359d6ffe6','a088a62d07be268f08583ed54be182e27a9abafd','',0,1319611997),(84,8,'f23fc063a48f3485d8ee49919a8ad941b1778a8d','a645b0a611f9d9fbe680eb95bc4ad3e8340bdbbe','',0,1320136642),(85,8,'bb91cf96397c5b43f3be005148b681b607e1b3cc','d3e0e71b85f7d1c6e2efc1f3a0723cd65bca762e','',0,1320265327),(86,1,'aa0ce7d953461cd658e8255d7c7d481fc5a36acd','93a4f89600469df418e11d928a806847e1555b1d','',0,1320402839),(89,8,'f7f3c54489bbbc85b777f84acee079e9989386a4','df2b7ef0be3838ce43744175fb89b6d018d134d5','',0,1320468203),(90,8,'bb91cf96397c5b43f3be005148b681b607e1b3cc','5ba3a7591f34af98d0c8914a17a293e0fb91f626','',0,1320472987),(92,1,'62489b7d1c16b9486aac7c08e866083dda6f9806','77abd676b7cbce3a14f32aeb1f24292ba5e2312b','',0,1320508775),(94,8,'dda3735ade73e505ca0084618251923588d45468','6ccef1795688dfeb8968cba05f4f0eead5c3530c','',0,1320522862);
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,75,1319313153,'cklotz','cklotz@bestchevrolet.com','49e55f6eaf9d8a3f2120ba01fbcc9a5b26a14a15','Chris','Klotz','5044712329'),(2,0,NULL,'grapevine','dummy@grapevinebeta.com','560f787306cbddcf728f65e0dccc5796d2adfa13','dummy','user','1111111111'),(3,11,1315841819,'lionrose','test@pickgrapevine.com','6af234d98097d58bae34d0205fead1ce5177790d','Lion','Rose','2100000000'),(8,69,1319345071,'riverenterprises','info-river@pickgrapevine.com','d847cfa612d2790c18beb92c43c4dfc030c603a8','Randy','Mathews','2102241313'),(9,0,NULL,'randy','randy@boudros.com','7d3871ac531176ab69865518fb793fe00fdb7416','Randy','Mathews','1111111111'),(10,0,NULL,'randyzinc','randy-1@boudros.com','227403cc45023e7c6ab210f8e92eb54995b74b09','Randy','Mathews','2102242900'),(11,0,NULL,'zinc.bistro','test.zinc@wp.pl','0dcd069d7f3eb1b2bdd2fc87291d78b54c8e621b','zinc','bistro','12345678'),(12,0,NULL,'test.boudro','boudro.test@wp.pl','0dcd069d7f3eb1b2bdd2fc87291d78b54c8e621b','boudro','riverwalk','12345678');
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

-- Dump completed on 2011-10-24  7:32:32
