



SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

-- -----------------------------------------------------
-- Table `company`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `company` (
  `company_id` INT NOT NULL ,
  `name` VARCHAR(150) NULL ,
  PRIMARY KEY (`company_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `locations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `locations` (
  `location_id` INT NOT NULL ,
  `location_name` VARCHAR(50) NULL ,
  `address1` VARCHAR(45) NULL ,
  `address2` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `state` VARCHAR(2) NULL ,
  `zip` VARCHAR(12) NULL ,
  `phone` VARCHAR(20) NULL ,
  `url` VARCHAR(255) NULL ,
  `owner_name` VARCHAR(45) NULL ,
  `owner_email` VARCHAR(255) NULL ,
  `owner_phone` VARCHAR(20) NULL ,
  `owner_ext` VARCHAR(45) NULL ,
  `billing_type` ENUM('charge','invoice') NULL ,
  PRIMARY KEY (`location_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `company_locations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `company_locations` (
  `location_id` INT NOT NULL ,
  `company_id` INT NOT NULL ,
  PRIMARY KEY (`location_id`, `company_id`) ,
  INDEX `fk_locations_company` (`company_id` ASC) ,
  INDEX `fk_locations` (`location_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `roles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(32) NULL ,
  `description` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `uniq_name` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `logins` INT(10) NOT NULL DEFAULT 0 ,
  `last_login` INT(10) UNSIGNED NULL ,
  `username` VARCHAR(32) NOT NULL ,
  `email` VARCHAR(127) NOT NULL ,
  `password` VARCHAR(64) NOT NULL ,
  `firstname` VARCHAR(45) NULL ,
  `lastname` VARCHAR(45) NULL ,
  `phone` VARCHAR(20) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `uniq_username` (`username` ASC) ,
  UNIQUE INDEX `uniq_email` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `roles_users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `roles_users` (
  `user_id` INT UNSIGNED NOT NULL ,
  `role_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`user_id`, `role_id`) ,
  INDEX `fk_role_id` (`role_id` ASC) ,
  INDEX `fk_user_id` (`user_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_tokens`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_tokens` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT UNSIGNED NOT NULL ,
  `user_agent` VARCHAR(40) NOT NULL ,
  `token` VARCHAR(40) NOT NULL ,
  `type` VARCHAR(100) NOT NULL ,
  `created` INT(10) UNSIGNED NOT NULL ,
  `expires` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `uniq_token` (`token` ASC) ,
  INDEX `fk_user_tokens` (`user_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `company_users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `company_users` (
  `company_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  PRIMARY KEY (`company_id`, `user_id`) ,
  INDEX `fk_user` (`user_id` ASC) ,
  INDEX `fk_comany` (`company_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `location_users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `location_users` (
  `location_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  PRIMARY KEY (`location_id`, `user_id`) ,
  INDEX `fk_location_users_locations` (`location_id` ASC) ,
  INDEX `fk_location_users_users` (`user_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `alerts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `alerts` (
  `alert_id` INT NOT NULL AUTO_INCREMENT ,
  `location_id` INT NOT NULL ,
  `type` VARCHAR(12) NOT NULL ,
  `criteria` TEXT NOT NULL COMMENT 'only typed text to work with custom keyword entries\n' ,
  `use_default` BOOLEAN NOT NULL ,
  PRIMARY KEY (`alert_id`) ,
  INDEX `fk_alerts_locations` (`location_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emails`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `emails` (
  `email_id` INT NOT NULL ,
  `email` VARCHAR(200) NULL ,
  `location_id` INT(11) NOT NULL ,
  PRIMARY KEY (`email_id`, `location_id`) ,
  INDEX `fk_emails_locations` (`location_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `alert_emails`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `alert_emails` (
  `alert_id` INT NOT NULL ,
  `emails_id` INT NOT NULL ,
  PRIMARY KEY (`alert_id`, `emails_id`) ,
  INDEX `fk_alert_emails_alerts` (`alert_id` ASC) ,
  INDEX `fk_alert_emails_emails` (`emails_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `newsletters`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `newsletters` (
  `email_id` INT NOT NULL ,
  `location_id` INT NOT NULL ,
  PRIMARY KEY (`email_id`, `location_id`) ,
  INDEX `fk_newsletters_emails` (`email_id` ASC, `location_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `location_settings`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `location_settings` (
  `id` INT NOT NULL COMMENT 'competitor,newsletter,facebook_oauth_token,twitter_search,twitter_account,filter_search,gblog_search,youtube_search' ,
  `type` VARCHAR(45) NOT NULL COMMENT 'competitor,newsletter,facebook_oauth_token,twitter_search,twitter_account,filter_search,gblog_search,youtube_search' ,
  `value` VARCHAR(225) NULL ,
  `location_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `location_id`) ,
  INDEX `fk_location_settings_locations` (`location_id` ASC) ,
  INDEX `idx_setting_type` (`type` ASC))
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;