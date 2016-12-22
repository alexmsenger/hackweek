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
  `country` varchar(127) NOT NULL DEFAULT 'Germany',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `address` (`id`, `street`, `adendum`, `zip`, `city`, `country`) VALUES
(1, 'Tamara-Danz Str. 1', NULL, '12345', 'Berlin', 'Germany'),
(2, 'Charlottenstr. 4', NULL, '12354', 'Berlin', 'Germany'),
(3, 'Tamara-Danz-Str. 1', NULL, '12345', 'Berlin', 'Germany');

DROP TABLE IF EXISTS `endpoint`;
CREATE TABLE IF NOT EXISTS `endpoint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `endpoint_type_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `address_id` (`address_id`),
  KEY `endpoint_type_id` (`endpoint_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `endpoint` (`id`, `name`, `endpoint_type_id`, `address_id`) VALUES
(1, 'BTD', 1, 1),
(2, 'BCS', 1, 2),
(3, 'BSR', 1, 3);

DROP TABLE IF EXISTS `endpoint_alternative`;
CREATE TABLE IF NOT EXISTS `endpoint_alternative` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_endpoint_id` int(11) NOT NULL,
  `alternative_endpoint_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `original_endpoint_id` (`original_endpoint_id`),
  KEY `alternative_endpoint` (`alternative_endpoint_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `endpoint_alternative` (`id`, `original_endpoint_id`, `alternative_endpoint_id`) VALUES
(1, 1, 3);

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

DROP TABLE IF EXISTS `endpoint_type`;
CREATE TABLE IF NOT EXISTS `endpoint_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `endpoint_type` (`id`, `name`) VALUES
(1, 'Office'),
(3, 'Spätkauf'),
(4, 'Tankstelle'),
(5, 'Neighbor');

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weight` int(6) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `depth` int(4) NOT NULL,
  `route_id` int(11) NOT NULL,
  `dropoff_not_before` time DEFAULT '21:00:00',
  `dropoff_not_after` time DEFAULT '21:00:00',
  `pickup_not_before` time DEFAULT '06:00:00',
  `pickup_not_after` time DEFAULT '20:00:00',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `complete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `route_id` (`route_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=3457 DEFAULT CHARSET=utf8;

INSERT INTO `order` (`id`, `weight`, `width`, `height`, `depth`, `route_id`, `dropoff_not_before`, `dropoff_not_after`, `pickup_not_before`, `pickup_not_after`, `created_by`, `created_at`, `complete`) VALUES
(3456, 500, 0, 0, 0, 1, '21:00:00', '21:00:00', '06:00:00', '20:00:00', 1, '2016-12-20 18:00:00', 0);

INSERT INTO `order` (`id`, `weight`, `width`, `height`, `depth`, `route_id`, `dropoff_not_before`, `dropoff_not_after`, `pickup_not_before`, `pickup_not_after`, `created_by`, `created_at`, `complete`) VALUES
(3457, 700, 100, 150, 120, 1, '21:00:00', '21:00:00', '06:00:00', '20:00:00', 2, '2016-12-21 09:00', 0);

DROP TABLE IF EXISTS `route`;
CREATE TABLE IF NOT EXISTS `route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pickup_endpoint_id` int(11) NOT NULL,
  `dropoff_endpoint_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pickup_endpoint_id` (`pickup_endpoint_id`),
  KEY `dropoff_endpoint_id` (`dropoff_endpoint_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `route` (`id`, `pickup_endpoint_id`, `dropoff_endpoint_id`) VALUES
(1, 2, 1);

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `name`) VALUES
(1, 'Alex'),
(2, 'Edi');


ALTER TABLE `endpoint`
  ADD CONSTRAINT `FK_endpoint_type` FOREIGN KEY (`endpoint_type_id`) REFERENCES `endpoint_type` (`id`),
  ADD CONSTRAINT `FK_endpoint_address` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

ALTER TABLE `endpoint_alternative`
  ADD CONSTRAINT `FK_alt_endpoint` FOREIGN KEY (`alternative_endpoint_id`) REFERENCES `endpoint` (`id`),
  ADD CONSTRAINT `FK_orig_endpoint` FOREIGN KEY (`original_endpoint_id`) REFERENCES `endpoint` (`id`);

ALTER TABLE `endpoint_comment`
  ADD CONSTRAINT `FK_comment_endpoint` FOREIGN KEY (`endpoint_id`) REFERENCES `endpoint` (`id`),
  ADD CONSTRAINT `FK_comment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `order`
  ADD CONSTRAINT `FK_order_creator` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_order_route` FOREIGN KEY (`route_id`) REFERENCES `route` (`id`);

ALTER TABLE `route`
  ADD CONSTRAINT `FK_route_dropoff_endpoint` FOREIGN KEY (`dropoff_endpoint_id`) REFERENCES `endpoint` (`id`),
  ADD CONSTRAINT `FK_route_pickup_endpoint` FOREIGN KEY (`pickup_endpoint_id`) REFERENCES `endpoint` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
