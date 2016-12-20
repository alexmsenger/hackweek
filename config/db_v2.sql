SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";



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

DROP TABLE IF EXISTS `endpoint`;
CREATE TABLE IF NOT EXISTS `endpoint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(127) NOT NULL,
  `last_name` varchar(127) NOT NULL,
  `address_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `address_id` (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `endpoint_alternative`;
CREATE TABLE IF NOT EXISTS `endpoint_alternative` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_endpoint_id` int(11) NOT NULL,
  `alternative_endpoint_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `original_endpoint_id` (`original_endpoint_id`),
  KEY `alternative_endpoint` (`alternative_endpoint_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `endpoint_comment`;
CREATE TABLE IF NOT EXISTS `endpoint_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `endpoint_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `endpoint_id` (`endpoint_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pickup_endpoint_id` int(11) NOT NULL,
  `dropoff_endpoint_id` int(11) DEFAULT NULL,
  `dropoff_not_before` time DEFAULT '21:00:00',
  `dropoff_not_after` time DEFAULT '21:00:00',
  `pickup_not_before` time DEFAULT '06:00:00',
  `pickup_not_after` time DEFAULT '20:00:00',
  `complete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pickup_endpoint_id` (`pickup_endpoint_id`),
  KEY `dropoff_endpoint_id` (`dropoff_endpoint_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3456 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `endpoint`
  ADD CONSTRAINT `FK_endpoint_address` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

ALTER TABLE `endpoint_alternative`
  ADD CONSTRAINT `FK_alt_endpoint` FOREIGN KEY (`alternative_endpoint_id`) REFERENCES `endpoint` (`id`),
  ADD CONSTRAINT `FK_orig_endpoint` FOREIGN KEY (`original_endpoint_id`) REFERENCES `endpoint` (`id`);

ALTER TABLE `endpoint_comment`
  ADD CONSTRAINT `FK_comment_endpoint` FOREIGN KEY (`endpoint_id`) REFERENCES `endpoint` (`id`),
  ADD CONSTRAINT `FK_comment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

-- ALTER TABLE `order`
  -- ADD CONSTRAINT `FK_order_end_endpoint` FOREIGN KEY (`dropoff_endpoint_id`) REFERENCES `endpoint` (`id`);
  -- ADD CONSTRAINT `FK_order_start_endpoint` FOREIGN KEY (`pickup_endpoint_id`) REFERENCES `endpoint` (`id`);



INSERT INTO `address` (street,city,zip,country) VALUES ('Tamara-Danz Str. 1', 'Berlin', '12345', 'Germany');

INSERT INTO `address` (street,city,zip,country) VALUES ('Charlottenstr. 4', 'Berlin', '12354', 'Germany');

INSERT INTO `order` (pickup_endpoint_id, dropoff_endpoint_id) VALUES (1,2);
