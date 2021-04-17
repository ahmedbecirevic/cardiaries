/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 8.0.23 : Database - cardiaries
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cardiaries` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `cardiaries`;

/*Table structure for table `accounts` */

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5094 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `cars` */

DROP TABLE IF EXISTS `cars`;

CREATE TABLE `cars` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `model_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_of_production` year NOT NULL,
  `mileage` double NOT NULL,
  `num_of_doors` int NOT NULL,
  `manufacturer_id` int unsigned NOT NULL,
  `engine_power_kw` double NOT NULL,
  `fuel` varchar(128) COLLATE utf8_bin NOT NULL,
  `vin` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_vin` (`vin`),
  KEY `cars_manu_fk` (`manufacturer_id`),
  CONSTRAINT `cars_manu_fk` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `cities` */

DROP TABLE IF EXISTS `cities`;

CREATE TABLE `cities` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `counties` */

DROP TABLE IF EXISTS `counties`;

CREATE TABLE `counties` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_bin NOT NULL,
  `city_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city_county_fk` (`city_id`),
  CONSTRAINT `city_county_fk` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `images` */

DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `image_format` varchar(8) COLLATE utf8_bin NOT NULL,
  `is_profile` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `users_img_fk` (`user_id`),
  CONSTRAINT `users_img_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `manufacturers` */

DROP TABLE IF EXISTS `manufacturers`;

CREATE TABLE `manufacturers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `body` text COLLATE utf8_bin NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int unsigned NOT NULL,
  `image_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_posts_fk` (`user_id`),
  KEY `images_posts_fk` (`image_id`),
  CONSTRAINT `images_posts_fk` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  CONSTRAINT `users_posts_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(512) COLLATE utf8_bin NOT NULL,
  `email` varchar(1024) COLLATE utf8_bin NOT NULL,
  `password` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `first_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `account_id` int unsigned NOT NULL,
  `status` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT 'PENDING',
  `role` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'REGULAR',
  `created_at` timestamp NOT NULL,
  `token` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `token_created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_email` (`email`),
  UNIQUE KEY `uq_username` (`username`),
  KEY `account_user_fk` (`account_id`),
  CONSTRAINT `account_user_fk` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
