# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.36)
# Database: qui_event_db
# Generation Time: 2022-03-04 12:59:38 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `venue_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `schedule` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Public, 2-Private',
  `audience_capacity` int(30) NOT NULL,
  `free_capacity` int(30) NOT NULL,
  `payment_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Free,payable',
  `amount` double NOT NULL DEFAULT '0',
  `banner` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `completed` tinyint(1) DEFAULT '0' COMMENT '0=Not Completed,1=Completed',
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;

INSERT INTO `events` (`id`, `venue_id`, `name`, `description`, `schedule`, `type`, `audience_capacity`, `free_capacity`, `payment_type`, `amount`, `banner`, `created_at`, `completed`, `user_id`)
VALUES
	(13,5,'Event One','Event is going to be awesome','01/01/2022',0,5000,5000,0,900,'1646167369.jpeg','2022-03-01 23:42:49',1,NULL),
	(14,5,'Event Two','Party of the year','03/03/2022',0,500,500,1,0,'1646167456.jpeg','2022-03-01 23:44:16',0,NULL),
	(15,6,'Private Fundraising','Election Campaign','04/09/2022',1,5000,5000,0,5000,'1646167548.jpeg','2022-03-01 23:45:48',0,4),
	(16,6,'Thomas Birthday','I need a party thrown for my 3yrs old baby girl. She likes Frozen so if it can be themed, the cake, ballons and setup would appreciate.,\r\nCapacity: 700,\r\nPayment: Free,\r\nAmount: 0,\r\nEvent Type: Public','03/05/2022',0,700,700,1,0,'1646397412.jpeg','2022-03-04 15:36:52',0,6);

/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `value` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `setting_type` tinyint(1) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `setting_type`, `icon`)
VALUES
	(1,'phone','0720863269','2022-02-20 16:53:25',1,'fas fa-phone'),
	(2,'email','quioccassions@gmail.com','2022-02-20 16:54:14',1,'fas fa-envelope'),
	(3,'location','Wayaki way, Nairobi, Kenya','2022-02-20 16:54:37',1,'fas fa-map-marker-alt'),
	(4,'facebook','https://www.facebook.com/','2022-02-20 16:55:03',2,'fab fa-facebook-f'),
	(5,'twitter','https://www.twitter.com/','2022-02-20 16:55:09',2,'fab fa-twitter'),
	(6,'instagram','https://www.instagram.com/','2022-02-20 16:55:15',2,'fab fa-instagram'),
	(7,'linkedin','https://www.linkedin.com/feed/','2022-02-20 16:55:32',2,'fab fa-linkedin-in');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_booking
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_booking`;

CREATE TABLE `user_booking` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `event_id` int(30) DEFAULT NULL,
  `venue_id` int(30) DEFAULT NULL,
  `capacity` int(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-for verification,1=confirmed,2=canceled',
  `type` varchar(100) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_booking` WRITE;
/*!40000 ALTER TABLE `user_booking` DISABLE KEYS */;

INSERT INTO `user_booking` (`id`, `name`, `email`, `contact`, `event_id`, `venue_id`, `capacity`, `status`, `type`, `notes`, `created_at`)
VALUES
	(23,'Patrick Jane','patrickjane@gmail.com','254723456789',14,NULL,50,2,'event',NULL,'2022-03-01 23:51:35'),
	(24,'Dully lully','dullylully@gmail.com','254789898989',14,NULL,50,1,'event','Update dully status','2022-03-01 23:52:29'),
	(25,'Mageto Dennis','magetodennis@gmail.com','254712211222',NULL,6,45,2,'venue',NULL,'2022-03-01 23:53:21'),
	(26,'Kuzmenko Gym','kuzmenkogym@gmail.com','254745545545',13,NULL,30,0,'event',NULL,'2022-03-01 23:54:38'),
	(27,'Van Pell','vanpell@gmail.com','254734343434',NULL,6,33,1,'venue','Caller approved all the estimates laid down','2022-03-01 23:55:10'),
	(28,'Harry Thomas','harrytom@gmail.com','25476127531232',NULL,5,23,0,'venue',NULL,'2022-03-04 00:25:37');

/*!40000 ALTER TABLE `user_booking` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_requests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_requests`;

CREATE TABLE `user_requests` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `user_id` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-for verification,1=confirmed,2=canceled',
  `notes` varchar(255) DEFAULT NULL,
  `schedule_date` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_requests` WRITE;
/*!40000 ALTER TABLE `user_requests` DISABLE KEYS */;

INSERT INTO `user_requests` (`id`, `user_id`, `description`, `status`, `notes`, `schedule_date`, `created_at`)
VALUES
	(2,'6','I need a party thrown for my 3yrs old baby girl. She likes Frozen so if it can be themed, the cake, ballons and setup would appreciate., <br>Capacity: 700, <br>Payment: Free, <br>Amount: 0, <br>Event Type: Public',1,'The event is confirmed','03/05/2022','2022-03-04 12:30:21'),
	(3,'4','Want a private concert, <br>Capacity: 100, <br>Payment: Free, <br>Amount: 900, <br>Event Type: Public',0,NULL,'03/17/2022','2022-03-04 15:44:29');

/*!40000 ALTER TABLE `user_requests` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `created_at`)
VALUES
	(1,'James Porter','jamesporter@gmail.com','$2y$10$imnFoUom1omJkmihNSWAgOic9zxTWYXVn54/aRXRyIW0eFKp1wEGS','2022-01-30 02:37:29'),
	(3,'Admin Qui','admin@gmail.com','$2y$10$ekEzItzkWzomXCp97/VDFeg42NQuM28ydQefLVQGh/.IGwGGXW0aq','2022-02-13 17:10:26'),
	(4,'John Doe','johndoe@gmail.com','$2y$10$hDZkBmldQiy526W8X/vx.OCo50Wt3L1zTotYZjx0sPw/sPb4ROW1y','2022-03-02 01:54:16'),
	(5,'Tommy','tommylee@gmail.com','$2y$10$jW5XYL0HjbQKOoGlf/Wp4.YXImkxk4JCosk7if97SIWAJNiJEfULq','2022-03-04 00:09:11'),
	(6,'Thomas','Thomas@gmail.com','$2y$10$hDZkBmldQiy526W8X/vx.OCo50Wt3L1zTotYZjx0sPw/sPb4ROW1y','2022-03-04 11:18:43');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table venues
# ------------------------------------------------------------

DROP TABLE IF EXISTS `venues`;

CREATE TABLE `venues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `rate` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `venues` WRITE;
/*!40000 ALTER TABLE `venues` DISABLE KEYS */;

INSERT INTO `venues` (`id`, `name`, `address`, `description`, `rate`, `image`, `created_at`)
VALUES
	(5,'Venue One','Venue One Address','Venue One Address, Venue One Address',1000,'1646167123.jpeg','2022-03-01 23:38:43'),
	(6,'Venue Two','Venue Two Address','Venue Two Address, Venue Two Address',1500,'1646167151.jpeg','2022-03-01 23:39:11');

/*!40000 ALTER TABLE `venues` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
