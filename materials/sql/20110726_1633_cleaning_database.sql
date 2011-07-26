-- Database structure - latest version
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

DROP TABLE IF EXISTS `alerts`;
CREATE TABLE IF NOT EXISTS `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `type` varchar(12) NOT NULL,
  `criteria` text NOT NULL COMMENT 'only typed text to work with custom keyword entries\n',
  `use_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_alerts_locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `alerts_emails`;
CREATE TABLE IF NOT EXISTS `alerts_emails` (
  `alert_id` int(11) NOT NULL,
  `email_id` int(11) NOT NULL,
  PRIMARY KEY (`alert_id`,`email_id`),
  KEY `fk_alert_emails_alerts` (`alert_id`),
  KEY `fk_alert_emails_emails` (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `companies_users`;
CREATE TABLE IF NOT EXISTS `companies_users` (
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level` tinyint(3) unsigned NOT NULL COMMENT '0 - owner, 1 - admin, 2 - read only',
  PRIMARY KEY (`company_id`,`user_id`),
  KEY `fk_user` (`user_id`),
  KEY `fk_comany` (`company_id`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `emails`;
CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(200) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_emails_locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL COMMENT 'ID of the company',
  `location_name` varchar(50) DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `locations_users`;
CREATE TABLE IF NOT EXISTS `locations_users` (
  `location_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level` tinyint(3) unsigned NOT NULL COMMENT '0 - owner, 1 - admin, 2 - read only',
  PRIMARY KEY (`location_id`,`user_id`),
  KEY `fk_location_users_locations` (`location_id`),
  KEY `fk_location_users_users` (`user_id`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `location_settings`;
CREATE TABLE IF NOT EXISTS `location_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL COMMENT 'competitor,newsletter,facebook_oauth_token,twitter_search,twitter_account,filter_search,gblog_search,youtube_search',
  `value` varchar(225) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`location_id`),
  KEY `fk_location_settings_locations` (`location_id`),
  KEY `idx_setting_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `newsletters`;
CREATE TABLE IF NOT EXISTS `newsletters` (
  `email_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`email_id`,`location_id`),
  KEY `fk_newsletters_emails` (`email_id`,`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `roles_users`;
CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_tokens`;
CREATE TABLE IF NOT EXISTS `user_tokens` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Default user
INSERT INTO `users` (`logins`, `last_login`, `username`, `email`, `password`, `firstname`, `lastname`, `phone`) VALUES
(0, NULL, 'tomasz.jaskowski', 'tomasz.jaskowski@polcode.com', '7f0e85b86469a1cd4c8ccf22c5ad65b7ad094521', 'Tomasz', 'Jaskowski', '+48 661696776');

-- Default company
INSERT INTO `companies` (`name`) VALUES ('GrapeVine Testing Company');

-- Default location
INSERT INTO `locations` (`company_id`, `location_name`, `address1`, `address2`, `city`, `state`, `zip`, `phone`, `url`, `owner_name`, `owner_email`, `owner_phone`, `owner_ext`, `billing_type`) VALUES ('1', 'GrapeVine Testing Location', 'Broadway', NULL, 'New York City', 'NY', NULL, NULL, 'http://www.grapevinebeta.com/', 'GV Owner', 'GV Email', 'GV Phone', NULL, 'charge');

-- Owner level access for default user to the default location
INSERT INTO `locations_users` (`location_id`, `user_id`, `level`) VALUES ('1', '1', '0');
