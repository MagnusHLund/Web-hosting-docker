CREATE DATABASE IF NOT EXISTS `MagZilla`
USE `MagZilla`;

CREATE TABLE IF NOT EXISTS `Users` (
  `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(30) NOT NULL,
  `email` VARCHAR(320) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `salt` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `Unique_email` (`email`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `Services` (
  `service_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_owner_user_id` INT(10) UNSIGNED NOT NULL,
  `service_name` VARCHAR(60) NOT NULL,
  `git_clone_url` VARCHAR(163) DEFAULT NULL,
  `is_active` BOOLEAN NOT NULL,
  PRIMARY KEY (`service_id`),
  UNIQUE KEY `Unique_service_name` (`service_name`, `service_owner_user_id`),
  KEY `FK_Services_Users` (`service_owner_user_id`),
  CONSTRAINT `FK_Services_Users` FOREIGN KEY (`service_owner_user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `ServiceTypes` (
  `service_type_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_id` INT(10) UNSIGNED NOT NULL,
  `type` VARCHAR(15) NOT NULL,
  `startup_location` VARCHAR(256) NOT NULL,
  `env_location` VARCHAR(256) DEFAULT NULL,
  `port` SMALLINT(5) UNSIGNED DEFAULT NULL CHECK (`port` BETWEEN 3000 AND 4000),
  PRIMARY KEY (`service_type_id`),
  UNIQUE KEY `Unique_port` (`port`),
  KEY `FK_ServiceTypes_Services` (`service_id`),
  CONSTRAINT `FK_ServiceTypes_Services` FOREIGN KEY (`service_id`) REFERENCES `Services` (`service_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `Settings` (
  `settings_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `dark_mode` BOOLEAN NOT NULL,
  `language` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`settings_id`),
  KEY `FK_Settings_Users` (`user_id`),
  CONSTRAINT `FK_Settings_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `UserRoles` (
  `user_roles_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `is_admin` BOOLEAN NOT NULL DEFAULT 0,
  `is_active` BOOLEAN NOT NULL DEFAULT 1,
  PRIMARY KEY (`user_roles_id`),
  KEY `FK_UserRoles_Users` (`user_id`),
  CONSTRAINT `FK_UserRoles_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `UserServiceMappings` (
  `user_services_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `service_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_services_id`),
  KEY `FK_UserServiceMappings_Users` (`user_id`),
  KEY `FK_UserServiceMappings_Services` (`service_id`),
  CONSTRAINT `FK_UserServiceMappings_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_UserServiceMappings_Services` FOREIGN KEY (`service_id`) REFERENCES `Services` (`service_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
