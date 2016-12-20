SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `zalando` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `zalando`;

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(127) NOT NULL,
  `adendum` varchar(255) DEFAULT NULL,
  `zip` char(5) NOT NULL,
  `city` varchar(127) NOT NULL,
  `country` varchar(127) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `recipient`;
CREATE TABLE IF NOT EXISTS `recipient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(127) NOT NULL,
  `last_name` varchar(127) NOT NULL,
  `address_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `address_id` (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `recipient_alternative`;
CREATE TABLE IF NOT EXISTS `recipient_alternative` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_address_id` int(11) NOT NULL,
  `alternative_recipient_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `original_address_id` (`original_address_id`),
  KEY `alternative_recipient` (`alternative_recipient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `recipient_comment`;
CREATE TABLE IF NOT EXISTS `recipient_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recipient_id` (`recipient_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `route`;
CREATE TABLE IF NOT EXISTS `route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_address_id` int(11) NOT NULL,
  `destination_address_id` int(11) DEFAULT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `dropoff_not_before` time DEFAULT '21:00:00',
  `dropoff_not_after` time DEFAULT '21:00:00',
  `pickup_not_before` time DEFAULT '06:00:00',
  `pickup_not_after` time DEFAULT '20:00:00',
  `complete` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `start_address_id` (`start_address_id`),
  KEY `recipient_id` (`recipient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3456 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `recipient`
  ADD CONSTRAINT `FK_recipient_address` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

ALTER TABLE `recipient_alternative`
  ADD CONSTRAINT `FK_alt_recipient` FOREIGN KEY (`alternative_recipient_id`) REFERENCES `recipient` (`id`),
  ADD CONSTRAINT `FK_orig_address` FOREIGN KEY (`original_address_id`) REFERENCES `address` (`id`);

ALTER TABLE `recipient_comment`
  ADD CONSTRAINT `FK_comment_recipient` FOREIGN KEY (`recipient_id`) REFERENCES `recipient` (`id`),
  ADD CONSTRAINT `FK_comment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `route`
  ADD CONSTRAINT `FK_order_recipient` FOREIGN KEY (`recipient_id`) REFERENCES `recipient` (`id`),
  ADD CONSTRAINT `FK_start_address` FOREIGN KEY (`start_address_id`) REFERENCES `address` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
