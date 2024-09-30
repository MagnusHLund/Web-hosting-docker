/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping database structure for MagZilla
CREATE DATABASE IF NOT EXISTS `MagZilla` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `MagZilla`;

-- Dumping structure for table MagZilla.Services
CREATE TABLE IF NOT EXISTS `Services` (
  `service_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_owner_user_id` int(10) unsigned NOT NULL,
  `service_name` varchar(60) NOT NULL,
  `git_clone_url` varchar(163) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 CHECK (`is_active` BETWEEN 0 AND 1),
  PRIMARY KEY (`service_id`),
  UNIQUE KEY `Unique_service_name` (`service_name`,`service_owner_user_id`),
  KEY `FK_Services_Users` (`service_owner_user_id`),
  CONSTRAINT `FK_Services_Users` FOREIGN KEY (`service_owner_user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table MagZilla.ServiceTypes
CREATE TABLE IF NOT EXISTS `ServiceTypes` (
  `service_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` int(10) unsigned NOT NULL,
  `type` varchar(15) NOT NULL,
  `startup_location` varchar(256) NOT NULL,
  `env_location` varchar(256) DEFAULT NULL,
  `port` smallint(5) unsigned DEFAULT NULL CHECK (`port` between 3000 and 4000),
  PRIMARY KEY (`service_type_id`),
  UNIQUE KEY `Unique_port` (`port`),
  KEY `FK_ServiceTypes_Services` (`service_id`),
  CONSTRAINT `FK_ServiceTypes_Services` FOREIGN KEY (`service_id`) REFERENCES `Services` (`service_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table MagZilla.Settings
CREATE TABLE IF NOT EXISTS `Settings` (
  `settings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `dark_mode` tinyint(1) NOT NULL CHECK (`dark_mode` BETWEEN 0 AND 1),
  `language` varchar(5) NOT NULL DEFAULT "en_US",
  PRIMARY KEY (`settings_id`),
  KEY `FK_Settings_Users` (`user_id`),
  CONSTRAINT `FK_Settings_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table MagZilla.UserRoles
CREATE TABLE IF NOT EXISTS `UserRoles` (
  `user_roles_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0 CHECK (`is_admin` BETWEEN 0 AND 1),
  `is_active` tinyint(1) NOT NULL DEFAULT 1 CHECK (`is_admin` BETWEEN 0 AND 1),
  PRIMARY KEY (`user_roles_id`),
  KEY `FK_UserRoles_Users` (`user_id`),
  CONSTRAINT `FK_UserRoles_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table MagZilla.Users
CREATE TABLE IF NOT EXISTS `Users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY (`user_name`),
  UNIQUE KEY `Unique_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table MagZilla.UserServiceMappings
CREATE TABLE IF NOT EXISTS `UserServiceMappings` (
  `user_services_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `service_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_services_id`),
  KEY `FK_UserServiceMappings_Users` (`user_id`),
  KEY `FK_UserServiceMappings_Services` (`service_id`),
  CONSTRAINT `FK_UserServiceMappings_Services` FOREIGN KEY (`service_id`) REFERENCES `Services` (`service_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_UserServiceMappings_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
