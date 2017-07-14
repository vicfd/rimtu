/*
SQLyog Community v12.2.5 (32 bit)
MySQL - 10.0.29-MariaDB-0ubuntu0.16.04.1 : Database - upload
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`upload` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `upload`;

/*Table structure for table `clients` */

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `client_id` int(10) NOT NULL AUTO_INCREMENT,
  `client_username` varchar(20) DEFAULT NULL,
  `client_password` varchar(200) DEFAULT NULL,
  `client_email` varchar(200) DEFAULT NULL,
  `client_ip` varchar(15) DEFAULT NULL,
  `client_file_size_upload` double DEFAULT '0',
  `client_level` int(1) DEFAULT '1',
  `client_date_registered` datetime DEFAULT NULL,
  `client_date_last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `clients` */

insert  into `clients`(`client_id`,`client_username`,`client_password`,`client_email`,`client_ip`,`client_file_size_upload`,`client_level`,`client_date_registered`,`client_date_last_login`) values 
(1,'vicfd','d2317c74bcff9da99210d41722908fc2219d91f8','a','77.208.59.23',-176652,3,'2012-05-26 08:25:06','2017-07-14 01:50:16'),
(0,'anonimo','069d17d40e60a5f4fcd26ab6ad76bb8987669e2c','a','a',16434734,1,'2012-06-09 02:32:39','2013-08-29 08:46:18');

/*Table structure for table `clients_type` */

DROP TABLE IF EXISTS `clients_type`;

CREATE TABLE `clients_type` (
  `client_type_level` int(11) NOT NULL,
  `client_type_size` varchar(10) NOT NULL,
  `client_type_space` float NOT NULL,
  `client_type_text` varchar(10) NOT NULL,
  `client_type_extension` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `clients_type` */

insert  into `clients_type`(`client_type_level`,`client_type_size`,`client_type_space`,`client_type_text`,`client_type_extension`) values 
(0,'50MB',104858000,'100 mb','*.jpg; *.jpeg; *.gif; *.png; *.bmp'),
(1,'200MB',5368710000,'5 gb','*.jpg; *.jpeg; *.gif; *.png; *.bmp'),
(2,'2000MB',53687100000,'50 gb','*.jpg; *.jpeg; *.gif; *.png; *.bmp'),
(3,'4000MB',107374000000,'100 gb','*.*');

/*Table structure for table `files` */

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `file_id` int(10) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(10) NOT NULL,
  `file_folder_id` varchar(200) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `file_ftp` varchar(200) NOT NULL,
  `file_extension` varchar(3) NOT NULL,
  `file_size` int(10) NOT NULL,
  `file_ip_upload` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `file_view` int(10) DEFAULT '0',
  `file_download` int(10) DEFAULT '0',
  `file_date_upload` datetime NOT NULL,
  `file_date_expire` datetime NOT NULL,
  `file_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `files` */

/*Table structure for table `files_report` */

DROP TABLE IF EXISTS `files_report`;

CREATE TABLE `files_report` (
  `report_id` int(10) NOT NULL AUTO_INCREMENT,
  `file_id` int(10) DEFAULT NULL,
  `report_email` varchar(200) DEFAULT NULL,
  `report_reason` varchar(100) DEFAULT NULL,
  `report_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `files_report` */

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` double NOT NULL AUTO_INCREMENT,
  `text` varchar(30) DEFAULT NULL,
  `href` varchar(100) DEFAULT NULL,
  `position` int(3) DEFAULT NULL,
  `rank` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `menu` */

insert  into `menu`(`id`,`text`,`href`,`position`,`rank`) values 
(2,'Panel de Usuario','panel',5,1),
(3,'Registrarse','register',6,0),
(4,'Identificarse','login',7,0),
(5,'Desconectar','disconnect',8,1),
(6,'Admin','admin',3,3),
(7,'Optimizar','optimize',4,3);

/*Table structure for table `temps` */

DROP TABLE IF EXISTS `temps`;

CREATE TABLE `temps` (
  `temp_id` int(10) NOT NULL AUTO_INCREMENT,
  `temp_code` varchar(200) DEFAULT NULL,
  `temp_type` double DEFAULT NULL,
  `temp_username` varchar(20) DEFAULT NULL,
  `temp_password` varchar(200) DEFAULT NULL,
  `temp_email` varchar(200) DEFAULT NULL,
  `temp_ip` varchar(15) DEFAULT NULL,
  `temp_date_registered` datetime DEFAULT NULL,
  `temp_date_expire` datetime DEFAULT NULL,
  `temp_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`temp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `temps` */

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `e_removeAnonimo` */

/*!50106 DROP EVENT IF EXISTS `e_removeAnonimo`*/;

DELIMITER $$

/*!50106 CREATE DEFINER=`vicfd`@`%` EVENT `e_removeAnonimo` ON SCHEDULE EVERY 1 DAY STARTS '2016-10-14 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO TRUNCATE TABLE anonimo */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
