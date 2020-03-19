/*
SQLyog Community Edition- MySQL GUI v8.05 
MySQL - 5.7.22-log : Database - healtharctest
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`healtharctest` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `healtharctest`;

/*Table structure for table `billingcodemaster` */

DROP TABLE IF EXISTS `billingcodemaster`;

CREATE TABLE `billingcodemaster` (
  `billing_code_id` int(11) NOT NULL AUTO_INCREMENT,
  `billing_code` varchar(64) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`billing_code_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `billingcodemaster` */

insert  into `billingcodemaster`(`billing_code_id`,`billing_code`,`is_active`,`created_dttm`,`created_by`,`modified_dttm`,`modified_by`) values (1,'99454',1,NULL,NULL,NULL,NULL),(2,'99457',1,NULL,NULL,NULL,NULL);

/*Table structure for table `conditionmaster` */

DROP TABLE IF EXISTS `conditionmaster`;

CREATE TABLE `conditionmaster` (
  `condition_id` int(11) NOT NULL AUTO_INCREMENT,
  `condition_name` varchar(64) DEFAULT NULL,
  `condition_abbreviation` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`condition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `conditionmaster` */

insert  into `conditionmaster`(`condition_id`,`condition_name`,`condition_abbreviation`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`) values (1,'CHF','CHF',1,NULL,NULL,NULL,NULL),(2,'Asthma/COPD','COPD',1,NULL,NULL,NULL,NULL),(3,'Diabetes','DIA',1,NULL,NULL,NULL,NULL),(4,'Hypertension','HTN',1,NULL,NULL,NULL,NULL);

/*Table structure for table `devicemaster` */

DROP TABLE IF EXISTS `devicemaster`;

CREATE TABLE `devicemaster` (
  `device_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_manufacturer` varchar(64) DEFAULT NULL,
  `device_model` varchar(64) DEFAULT NULL,
  `device_name` varchar(64) DEFAULT NULL,
  `device_image_url` varchar(256) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`device_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='This is a master table to store all the wearable & health devices supported by HealthNode platform';

/*Data for the table `devicemaster` */

insert  into `devicemaster`(`device_id`,`device_manufacturer`,`device_model`,`device_name`,`device_image_url`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`) values (1,'A&D Medical','UA-651BLE','Blood Pressure Monitor - Arm',NULL,1,NULL,NULL,NULL,NULL),(2,'A&D Medical','UB-1100BLE','Blood Pressure Monitor - Wrist',NULL,1,NULL,NULL,NULL,NULL),(3,'ACCU-CHEK','Guide','Glucose Checker',NULL,1,NULL,NULL,NULL,NULL),(4,'A&D Medical','UC-352BLE','Weighting Machine',NULL,1,NULL,NULL,NULL,NULL),(5,'Pulse Oximeter','Pulse Oximeter','Pulse Oximeter',NULL,1,NULL,NULL,NULL,NULL);

/*Table structure for table `devicevitalmap` */

DROP TABLE IF EXISTS `devicevitalmap`;

CREATE TABLE `devicevitalmap` (
  `device_vital_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) DEFAULT NULL,
  `vital_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`device_vital_id`),
  KEY `fk_deviceConditionMap_deviceid_idx` (`device_id`),
  KEY `fk_ deviceVitalMap p_conditionid_idx` (`vital_id`),
  CONSTRAINT `fk_ deviceVitalMap p_conditionid` FOREIGN KEY (`vital_id`) REFERENCES `vitalmaster` (`vital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ deviceVitalMap_deviceid` FOREIGN KEY (`device_id`) REFERENCES `devicemaster` (`device_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `devicevitalmap` */

insert  into `devicevitalmap`(`device_vital_id`,`device_id`,`vital_id`,`is_active`,`created_dttm`,`created_by`,`modified_dttm`,`modified_by`) values (1,1,1,1,'2020-02-28 12:44:55',0,'2020-02-28 12:44:55',0),(2,2,1,1,'2020-02-28 12:44:55',0,'2020-02-28 12:44:55',0),(3,1,2,1,'2020-02-28 12:44:55',0,'2020-02-28 12:44:55',0),(4,2,2,1,'2020-02-28 12:44:55',0,'2020-02-28 12:44:55',0),(5,5,2,1,'2020-02-28 12:44:55',0,'2020-02-28 12:44:55',0),(6,4,3,1,'2020-02-28 12:44:55',0,'2020-02-28 12:44:55',0),(7,5,4,1,'2020-02-28 12:44:55',0,'2020-02-28 12:44:55',0),(8,3,5,1,'2020-02-28 12:44:55',0,'2020-02-28 12:44:55',0);

/*Table structure for table `devicevitals` */

DROP TABLE IF EXISTS `devicevitals`;

CREATE TABLE `devicevitals` (
  `devicevital_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) DEFAULT NULL,
  `vital_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`devicevital_id`),
  KEY `fk_deviceVitals_deviceid_idx` (`device_id`),
  KEY `fk_deviceVitals_vitalid_idx` (`vital_id`),
  CONSTRAINT `fk_deviceVitals_deviceid` FOREIGN KEY (`device_id`) REFERENCES `devicemaster` (`device_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_deviceVitals_vitalid` FOREIGN KEY (`vital_id`) REFERENCES `vitalmaster` (`vital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `devicevitals` */

/*Table structure for table `hospitallocations` */

DROP TABLE IF EXISTS `hospitallocations`;

CREATE TABLE `hospitallocations` (
  `hospital_location_id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_id` int(11) DEFAULT NULL,
  `location_name` varchar(64) DEFAULT NULL,
  `add_line1` varchar(64) DEFAULT NULL,
  `add_line2` varchar(64) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `statecode` varchar(2) DEFAULT NULL,
  `zipcode` varchar(16) DEFAULT NULL,
  `phone_no` varchar(16) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`hospital_location_id`),
  KEY `fk_hospitalLocations_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_hospitalLocations_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `hospitallocations` */

insert  into `hospitallocations`(`hospital_location_id`,`hospital_id`,`location_name`,`add_line1`,`add_line2`,`city`,`statecode`,`zipcode`,`phone_no`,`is_active`,`created_dttm`,`created_by`,`modified_dttm`,`modified_by`) values (1,1,'Bill de Blasio','50 Hudson Yard',NULL,'New York',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,1,'Albany','1 Wall Street',NULL,'California',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,2,'Hudson',NULL,NULL,'Chicago',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,3,'Georgia',NULL,NULL,'Guam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,25,'Main Branch	','1 Wall Street	',NULL,'New York',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,26,'Main Branch','100 Summit Ave',NULL,'Montvale','NJ','07645',NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `hospitals` */

DROP TABLE IF EXISTS `hospitals`;

CREATE TABLE `hospitals` (
  `hospital_id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_name` varchar(64) DEFAULT NULL,
  `phone_no` varchar(16) DEFAULT NULL,
  `logo_url` varchar(512) DEFAULT NULL,
  `contact_name` varchar(128) DEFAULT NULL,
  `contact_phone` varchar(16) DEFAULT NULL,
  `sub_domain` varchar(64) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`hospital_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `hospitals` */

insert  into `hospitals`(`hospital_id`,`hospital_name`,`phone_no`,`logo_url`,`contact_name`,`contact_phone`,`sub_domain`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`) values (1,'Dev1Hospital','1111111111',NULL,'Dev1Hospital',NULL,'dev1.healtharc.io',1,NULL,NULL,NULL,NULL),(2,'Dev2Hospital','2222222222',NULL,'Dev2Hospital',NULL,'dev2.healtharc.io',NULL,NULL,NULL,NULL,NULL),(3,'Dev3Hospital','3333333333',NULL,'Dev3Hospital',NULL,'dev13.healtharc.io',NULL,NULL,NULL,NULL,NULL),(4,'Dev4Hospital','4444444444',NULL,'Dev4Hospital',NULL,'dev4.healtharc.io',1,NULL,NULL,NULL,NULL),(5,'sasas','2121212121','2020-02-28_08-00-07banner.jpg',NULL,NULL,'sasas.com',1,'2020-02-28 08:00:07','2020-02-28 08:00:07',NULL,NULL),(6,'Sahil','1212121212',NULL,NULL,NULL,'sahil.com',1,'2020-02-28 09:39:28','2020-02-28 09:39:28',NULL,NULL),(7,'Sahil','111111111',NULL,NULL,NULL,'sahil.com',1,'2020-02-28 09:42:34','2020-02-28 09:42:34',NULL,NULL),(8,'asasa','1212121212',NULL,NULL,NULL,'sdsd.com',1,'2020-02-28 09:47:19','2020-02-28 09:47:19',NULL,NULL),(9,'ssss','1111111111',NULL,NULL,NULL,'sahil.com',1,'2020-02-28 09:52:53','2020-02-28 09:52:53',NULL,NULL),(10,'ssss','111111',NULL,NULL,NULL,'sss.com',1,'2020-02-28 09:54:37','2020-02-28 09:54:37',NULL,NULL),(11,'sas','1212121212',NULL,NULL,NULL,'a.com',1,'2020-02-28 10:04:43','2020-02-28 10:04:43',NULL,NULL),(12,'sasas','1212121',NULL,NULL,NULL,'asasas',1,'2020-02-28 10:06:46','2020-02-28 10:06:46',NULL,NULL),(13,'sasa','1212121212',NULL,NULL,NULL,'2121.com',1,'2020-02-28 10:11:38','2020-02-28 10:11:38',NULL,NULL),(14,'ssas','212121212',NULL,NULL,NULL,'asas.com',1,'2020-02-28 10:12:42','2020-02-28 10:12:42',NULL,NULL),(15,'Sahil','1111111111',NULL,NULL,NULL,'sahil.com',1,'2020-02-28 10:16:38','2020-02-28 10:16:38',NULL,NULL),(16,'Sahil','1111111111',NULL,NULL,NULL,'sahil.com',1,'2020-02-28 10:23:36','2020-02-28 10:23:36',NULL,NULL),(17,'sss','121212',NULL,NULL,NULL,'sasa.com',1,'2020-02-28 10:32:16','2020-02-28 10:32:16',NULL,NULL),(18,'sas','1111',NULL,NULL,NULL,'sas',1,'2020-02-28 10:34:06','2020-02-28 10:34:06',NULL,NULL),(19,'sss','12212',NULL,NULL,NULL,'sasas',1,'2020-02-28 10:38:34','2020-02-28 10:38:34',NULL,NULL),(20,'sss','1211111',NULL,NULL,NULL,'232323',1,'2020-02-28 11:46:45','2020-02-28 11:46:45',NULL,NULL),(21,'ddd','1212',NULL,NULL,NULL,'22222',1,'2020-02-28 11:47:38','2020-02-28 11:47:38',NULL,NULL),(22,'ssss','21212',NULL,NULL,NULL,'eewe',1,'2020-02-28 11:48:11','2020-02-28 11:48:11',NULL,NULL),(23,'Sahil','1212121',NULL,NULL,NULL,'dev11.healtharc.io',1,'2020-02-28 11:56:59','2020-02-28 11:56:59',NULL,NULL),(24,'','',NULL,NULL,NULL,'',1,'2020-02-28 12:44:03','2020-02-28 12:44:03',NULL,NULL),(25,'unikove','7011677780','2020-02-28_12-45-19th.jpg',NULL,NULL,'http://dev3.healtharc.io/',1,'2020-02-28 12:45:19','2020-02-28 12:45:19',NULL,NULL),(26,'Mount Sinai','2019511687','2020-02-28_13-15-48mountsinai.png',NULL,NULL,'mountsinai.healtharc.io',1,'2020-02-28 13:15:48','2020-02-28 13:15:48',NULL,NULL);

/*Table structure for table `hospitaltemplatealerts` */

DROP TABLE IF EXISTS `hospitaltemplatealerts`;

CREATE TABLE `hospitaltemplatealerts` (
  `hospital_template_alert_id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_id` int(11) DEFAULT NULL,
  `vital_id` int(11) DEFAULT NULL,
  `warning_min` double DEFAULT NULL,
  `warning_max` double DEFAULT NULL,
  `emergency_min` double DEFAULT NULL,
  `emergency_max` double DEFAULT NULL,
  `normal_min` double DEFAULT NULL,
  `normal_max` double DEFAULT NULL,
  `intervention_notes` varchar(1024) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`hospital_template_alert_id`),
  KEY `fk_hospitalTemplateAlerts_hospitalid_idx` (`hospital_id`),
  KEY `fk_hospitalTemplateAlerts_vitalid_idx` (`vital_id`),
  CONSTRAINT `fk_hospitalTemplateAlerts_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_hospitalTemplateAlerts_vitalid` FOREIGN KEY (`vital_id`) REFERENCES `vitalmaster` (`vital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `hospitaltemplatealerts` */

insert  into `hospitaltemplatealerts`(`hospital_template_alert_id`,`hospital_id`,`vital_id`,`warning_min`,`warning_max`,`emergency_min`,`emergency_max`,`normal_min`,`normal_max`,`intervention_notes`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`) values (1,1,1,90,140,80,150,110,130,'test',1,'2020-02-18 10:10:21',NULL,1,NULL),(2,1,2,60,100,50,110,70,90,'',1,'2020-02-18 10:10:22',NULL,1,NULL),(3,1,3,50,80,40,90,60,70,'test Pulse',1,'2020-02-18 10:10:22',NULL,1,NULL),(4,1,4,50,65,45,70,55,60,'test Weight',1,'2020-02-18 10:10:22',NULL,1,NULL),(5,1,5,40,70,30,80,50,60,'test SpO2',1,'2020-02-18 10:10:22',NULL,1,NULL),(6,1,6,80,150,75,180,100,120,'test Glucose',1,'2020-03-03 04:38:55',NULL,1,NULL),(7,26,1,79,121,40,170,80,120,'BP notes',1,'2020-03-13 23:45:43',NULL,26,NULL),(8,26,2,59,81,40,100,60,80,'',1,'2020-03-13 23:45:43',NULL,26,NULL),(9,26,3,49,91,30,130,50,90,'Pulse notes',1,'2020-03-13 23:45:43',NULL,26,NULL),(10,26,4,90,300,70,400,100,200,'weight notes',1,'2020-03-13 23:45:43',NULL,26,NULL),(11,26,5,85,98,70,99,90,97,'spo2 notes',1,'2020-03-13 23:45:43',NULL,26,NULL),(12,26,6,49,150,20,200,50,130,'glucose notes',1,'2020-03-13 23:45:43',NULL,26,NULL);

/*Table structure for table `hospitaluserlogins` */

DROP TABLE IF EXISTS `hospitaluserlogins`;

CREATE TABLE `hospitaluserlogins` (
  `hospital_user_login_id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_user_id` int(11) DEFAULT NULL,
  `login_dttm` datetime DEFAULT NULL,
  `logout_dttm` datetime DEFAULT NULL,
  `ip_address` varchar(16) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`hospital_user_login_id`),
  KEY `fk_userLoginLog_userid_idx` (`hospital_user_id`),
  KEY `fk_hospitalUserLogins_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_hospitalUserLogins_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_hospitalUserLogins_userid` FOREIGN KEY (`hospital_user_id`) REFERENCES `hospitalusers` (`hospital_user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `hospitaluserlogins` */

/*Table structure for table `hospitalusers` */

DROP TABLE IF EXISTS `hospitalusers`;

CREATE TABLE `hospitalusers` (
  `hospital_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(64) DEFAULT NULL,
  `lname` varchar(64) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone_code` varchar(8) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `hospital_location_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `is_password_changed` int(11) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`hospital_user_id`),
  KEY `fk_hospitalUsers_roleid_idx` (`role_id`),
  KEY `fk_hospitalUsers_hospitalid_idx` (`hospital_id`),
  KEY `fk_hospitalUsers_hospitallicationid_idx` (`hospital_location_id`),
  CONSTRAINT `fk_hospitalUsers_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_hospitalUsers_hospitallicationid` FOREIGN KEY (`hospital_location_id`) REFERENCES `hospitallocations` (`hospital_location_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_hospitalUsers_roleid` FOREIGN KEY (`role_id`) REFERENCES `rolemaster` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

/*Data for the table `hospitalusers` */

insert  into `hospitalusers`(`hospital_user_id`,`fname`,`lname`,`email`,`phone_code`,`phone`,`hospital_location_id`,`role_id`,`hospital_id`,`password`,`is_active`,`is_password_changed`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`) values (1,'Hospital1',NULL,'hospitaladmin1@gmail.com','+91','1111111111',1,1,1,NULL,1,1,NULL,NULL,NULL,NULL),(2,'Hospital2',NULL,'hospitaladmin2@gmail.com','+91','2222222222',2,1,2,NULL,1,1,NULL,NULL,NULL,NULL),(3,'Hospital3',NULL,'hospitaladmin3@gmail.com','+91','3333333333',1,1,3,NULL,1,1,NULL,NULL,NULL,NULL),(4,'Sahil','Ranjan','sahilranjan45@gmail.com','+91','9729676439',1,1,1,NULL,1,1,'2020-02-18 08:22:38','2020-02-18 08:22:38',1,1),(5,'Sharda','kumari','sharda@unikove.com','+91','2323232323',1,1,1,NULL,1,1,'2020-02-18 09:47:07','2020-02-18 09:47:07',4,4),(6,'sushil','kumar','sushil@mailinator.com','+91','7011677780',1,2,1,NULL,1,0,'2020-02-18 10:11:24','2020-02-18 10:11:24',5,5),(7,'sahil','ranjan','sahil@mailinator.com','+91','7011677780',2,3,1,NULL,1,0,'2020-02-18 10:12:49','2020-02-18 10:12:49',5,5),(8,'subodh','pant','subodh@mailinator.com','+91','7529972809',1,4,1,'',1,0,'2020-02-18 10:13:56','2020-02-18 10:13:56',5,5),(9,'Hospital4','Testing','sudeepbath@gmail.com','+1','2019511687',5,1,4,NULL,1,NULL,NULL,NULL,NULL,NULL),(10,'Sahil','Ranjan','sahil@unikove.com','+91','1212121212',1,1,1,'KDRWJUg6NlFgLTMwYApgCg==',1,1,'2020-02-20 13:50:18','2020-02-28 08:10:57',4,10),(11,'sharda kumari\'','jha','kumari@mailinator.com','+91','7011677780',1,1,1,NULL,1,0,'2020-02-24 06:48:23','2020-02-24 06:50:26',5,5),(12,'sasas','sasas','sass@sasa.com','+1','2121212121',1,1,5,'KD0kVFE4NUlILiIwYApgCg==',1,0,'2020-02-28 08:00:07','2020-02-28 08:00:07',NULL,NULL),(26,'sss','sss','sahilranjan025@gmail.com','+1','12212',1,1,19,'KC1GVEQxJkklOENgYApgCg==',1,0,'2020-02-28 10:38:34','2020-02-28 10:38:34',NULL,NULL),(27,'sss','sss','sahilranjan@gmail.com','+1','1211111',1,1,20,'KDRFRU8+Q0VKKkM4YApgCg==',1,0,'2020-02-28 11:46:45','2020-02-28 11:46:45',NULL,NULL),(28,'ddd','ddd','sahilranjan045@gmail.com','+1','1212',1,1,21,'KC1WQEEyMzEoPkYkYApgCg==',1,0,'2020-02-28 11:47:38','2020-02-28 11:47:38',NULL,NULL),(29,'ssss','ssss','sahilranjan45@gmail.com','+1','21212',1,1,22,'KCw1QFI+REVTPjIsYApgCg==',1,0,'2020-02-28 11:48:11','2020-02-28 11:48:11',NULL,NULL),(30,'Sahil','Sahil','sahilranjan05@gmail.com','+1','1212121',1,1,23,'KDRWJUg6NlFgLTMwYApgCg==',1,1,'2020-02-28 11:56:59','2020-02-28 11:56:59',NULL,NULL),(31,'','','','','',1,1,24,'KzEmNUY4NzVMPSRgUSxDLGAKYAo=',1,0,'2020-02-28 12:44:03','2020-02-28 12:44:03',NULL,NULL),(32,'unikove','unikove','shardachy14@gmail.com','+1','7011677780',1,1,25,'KzU2WUk6Vl1WOTRgUSxDLGAKYAo=',1,1,'2020-02-28 12:45:19','2020-02-28 12:45:19',NULL,NULL),(33,'shivanshuaaa','kumar','shivanshu@unikove.com','+91','7011677780',5,2,25,'KzU2WUk6Vl1WOTRgUSxDLGAKYAo=',1,1,'2020-02-28 12:52:30','2020-02-28 12:57:16',32,33),(34,'sharda two','jha','sharda@mailinator.com','+91','7011677780',5,1,25,'KzEmNUY4NzVMPSRgUSxDLGAKYAo=',1,0,'2020-02-28 12:59:34','2020-02-28 13:00:52',33,33),(35,'Sudeep','Bath','sudeep@healthnode.us','+1','3432423432',6,1,26,'KTRXNUQ5NjVQLDMoRApgCg==',1,1,'2020-02-28 13:15:48','2020-03-12 03:12:04',NULL,35),(37,'Nurse ','Second Testing','healtharcdev@gmail.com','+1','2019667928',6,3,26,'KTRXNUQ5NjVQLDMoRApgCg==',1,1,'2020-02-28 16:42:04','2020-02-28 16:42:04',35,35),(38,'Sudeep','Doctor','sudeep77@gmail.com','+1','2019511687',6,2,26,'KTRXNUQ5NjVQLDMoRApgCg==',0,1,'2020-03-12 03:05:33','2020-03-12 03:05:33',35,35);

/*Table structure for table `measurefrequencymaster` */

DROP TABLE IF EXISTS `measurefrequencymaster`;

CREATE TABLE `measurefrequencymaster` (
  `measure_frequency_id` int(11) NOT NULL,
  `vital_id` int(11) DEFAULT NULL,
  `sort_order` tinyint(2) DEFAULT NULL,
  `measure_time` varchar(8) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`measure_frequency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `measurefrequencymaster` */

insert  into `measurefrequencymaster`(`measure_frequency_id`,`vital_id`,`sort_order`,`measure_time`,`is_active`,`created_dttm`,`created_by`,`modified_dttm`,`modified_by`) values (1,1,1,'08:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(2,1,2,'12:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(3,1,3,'20:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(4,2,1,'08:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(5,2,2,'12:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(6,2,3,'20:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(7,3,1,'08:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(8,3,2,'12:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(9,3,3,'20:00',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(10,4,1,'08:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(11,4,2,'12:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(12,4,3,'20:15',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(13,5,1,'08:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(14,5,2,'12:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(15,5,3,'21:00',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(16,6,1,'08:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(17,6,2,'12:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1),(18,6,3,'17:30',1,'2020-02-18 12:08:51',1,'2020-02-18 12:08:51',1);

/*Table structure for table `patientappointmentrequests` */

DROP TABLE IF EXISTS `patientappointmentrequests`;

CREATE TABLE `patientappointmentrequests` (
  `patient_appointment_request_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `request_dttm` datetime DEFAULT NULL,
  `appointment_type` tinyint(1) DEFAULT NULL COMMENT '1 - Call\\n2 - Visit\\n3 - Video',
  `is_completed` tinyint(1) DEFAULT NULL COMMENT '0 - No\n1 - Yes',
  `attended_by` int(11) DEFAULT NULL,
  `attended_dttm` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_appointment_request_id`),
  KEY `fk_patientAppointmentRequests_patientid_idx` (`patient_id`),
  KEY `fk_patientAppointmentRequests_attendedby_idx` (`attended_by`),
  KEY `fk_patientAppointmentRequests_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_patientAppointmentRequests_attendedby` FOREIGN KEY (`attended_by`) REFERENCES `hospitalusers` (`hospital_user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientAppointmentRequests_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientAppointmentRequests_patientid` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `patientappointmentrequests` */

insert  into `patientappointmentrequests`(`patient_appointment_request_id`,`patient_id`,`request_dttm`,`appointment_type`,`is_completed`,`attended_by`,`attended_dttm`,`is_active`,`created_dttm`,`created_by`,`modified_dttm`,`modified_by`,`hospital_id`) values (1,1,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,1,NULL,2,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,1,NULL,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,1,'2020-03-13 14:34:51',1,0,7,NULL,1,'2020-03-13 14:34:51',1,'2020-03-13 14:34:51',1,1),(5,1,'2020-03-13 15:05:44',1,0,7,NULL,1,'2020-03-13 15:29:21',1,'2020-03-13 15:29:21',1,1),(6,2,'2020-03-13 15:05:44',1,0,7,NULL,1,'2020-03-13 15:55:03',2,'2020-03-13 15:55:03',2,1),(7,2,'2020-03-13 15:05:44',2,0,7,NULL,1,'2020-03-13 16:12:24',2,'2020-03-13 16:12:24',2,1),(8,1,'2020-03-14 07:16:00',1,0,7,NULL,1,'2020-03-14 07:16:09',1,'2020-03-14 07:16:09',1,1),(9,1,'2020-03-14 07:18:59',1,0,7,NULL,1,'2020-03-14 07:19:06',1,'2020-03-14 07:19:06',1,1),(10,1,'2020-03-14 07:23:03',1,0,7,NULL,1,'2020-03-14 07:23:05',1,'2020-03-14 07:23:05',1,1),(11,1,'2020-03-16 05:21:32',1,0,7,NULL,1,'2020-03-16 05:21:33',1,'2020-03-16 05:21:33',1,1),(12,1,'2020-03-16 05:22:03',2,0,7,NULL,1,'2020-03-16 05:22:11',1,'2020-03-16 05:22:11',1,1),(13,1,'2020-03-16 05:23:38',1,0,7,NULL,1,'2020-03-16 05:23:39',1,'2020-03-16 05:23:39',1,1),(14,1,'2020-03-16 05:27:57',1,0,7,NULL,1,'2020-03-16 05:27:58',1,'2020-03-16 05:27:58',1,1),(15,1,'2020-03-16 05:28:25',2,0,7,NULL,1,'2020-03-16 05:28:25',1,'2020-03-16 05:28:25',1,1),(16,1,'2020-03-16 05:55:07',1,0,7,NULL,1,'2020-03-16 05:55:25',1,'2020-03-16 05:55:25',1,1),(17,1,'2020-03-16 05:55:46',1,0,7,NULL,1,'2020-03-16 05:55:57',1,'2020-03-16 05:55:57',1,1);

/*Table structure for table `patientbilling` */

DROP TABLE IF EXISTS `patientbilling`;

CREATE TABLE `patientbilling` (
  `patient_billing_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `month_year` datetime DEFAULT NULL,
  `billing_eligible` tinyint(1) DEFAULT NULL,
  `billing_code_id` int(11) DEFAULT NULL,
  `time_spent` int(11) DEFAULT NULL,
  `no_of_readings` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_billing_id`),
  KEY `fk_patientBilling_patientid_idx` (`patient_id`),
  KEY `fk_patientBilling_billingcodeid_idx` (`billing_code_id`),
  KEY `fk_patientBilling_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_patientBilling_billingcodeid` FOREIGN KEY (`billing_code_id`) REFERENCES `billingcodemaster` (`billing_code_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientBilling_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientBilling_patientid` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `patientbilling` */

insert  into `patientbilling`(`patient_billing_id`,`patient_id`,`month_year`,`billing_eligible`,`billing_code_id`,`time_spent`,`no_of_readings`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`,`hospital_id`) values (1,6,'2020-03-04 09:37:30',NULL,NULL,3,6,1,'2020-03-04 09:37:30','2020-03-04 09:37:30',10,10,1),(2,7,'2020-03-04 10:03:48',1,1,29,5,1,'2020-03-04 10:03:48','2020-03-04 10:03:48',10,10,1),(3,1,'2020-03-04 11:25:33',0,NULL,4,3,1,'2020-03-04 11:25:33','2020-03-04 11:25:33',10,10,1);

/*Table structure for table `patientbillingdetails` */

DROP TABLE IF EXISTS `patientbillingdetails`;

CREATE TABLE `patientbillingdetails` (
  `patient_billing_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `hospital_user_id` int(11) DEFAULT NULL,
  `time_spent` int(11) DEFAULT NULL,
  `recorded_dttm` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_billing_details_id`),
  KEY `fk_patientBillingDetails_patientid_idx` (`patient_id`),
  KEY `fk_patientBillingDetails_hospitaluserod_idx` (`hospital_user_id`),
  KEY `fk_patientBillingDetails_hospitalis_idx` (`hospital_id`),
  CONSTRAINT `fk_patientBillingDetails_hospitalis` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientBillingDetails_hospitaluserod` FOREIGN KEY (`hospital_user_id`) REFERENCES `hospitalusers` (`hospital_user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientBillingDetails_patientid` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `patientbillingdetails` */

insert  into `patientbillingdetails`(`patient_billing_details_id`,`patient_id`,`hospital_user_id`,`time_spent`,`recorded_dttm`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`,`hospital_id`) values (1,6,10,15,'2020-03-04 09:37:28',1,'2020-03-04 09:37:28','2020-03-04 09:37:28',10,10,1),(2,8,10,17,'2020-03-04 09:52:15',1,'2020-03-04 09:52:15','2020-03-04 09:52:15',10,10,1),(3,6,10,3,'2020-03-04 09:59:21',1,'2020-03-04 09:59:21','2020-03-04 09:59:21',10,10,1),(4,6,10,12,'2020-03-04 10:01:01',1,'2020-03-04 10:01:01','2020-03-04 10:01:01',10,10,1),(5,6,10,3,'2020-03-04 10:01:54',1,'2020-03-04 10:01:54','2020-03-04 10:01:54',10,10,1),(6,6,10,5,'2020-03-04 10:02:41',1,'2020-03-04 10:02:41','2020-03-04 10:02:41',10,10,1),(7,7,10,9,'2020-03-04 10:03:46',1,'2020-03-04 10:03:46','2020-03-04 10:03:46',10,10,1),(8,7,10,1,'2020-03-04 10:10:58',1,'2020-03-04 10:10:58','2020-03-04 10:10:58',10,10,1),(9,7,10,16,'2020-03-04 10:11:48',1,'2020-03-04 10:11:48','2020-03-04 10:11:48',10,10,1),(10,7,10,2,'2020-03-04 10:25:05',1,'2020-03-04 10:25:05','2020-03-04 10:25:05',10,10,1),(11,6,10,5,'2020-03-04 10:26:12',1,'2020-03-04 10:26:12','2020-03-04 10:26:12',10,10,1),(12,1,10,2,'2020-03-04 11:25:22',1,'2020-03-04 11:25:22','2020-03-04 11:25:22',10,10,1),(13,1,10,1,'2020-03-11 14:28:30',1,'2020-03-11 14:28:30','2020-03-11 14:28:30',10,10,1),(14,1,10,1,'2020-03-11 14:32:53',1,'2020-03-11 14:32:53','2020-03-11 14:32:53',10,10,1),(15,7,10,1,'2020-03-11 14:33:59',1,'2020-03-11 14:33:59','2020-03-11 14:33:59',10,10,1);

/*Table structure for table `patientcaregivers` */

DROP TABLE IF EXISTS `patientcaregivers`;

CREATE TABLE `patientcaregivers` (
  `patient_caregiver_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `fname` varchar(64) DEFAULT NULL,
  `lname` varchar(64) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone_code` varchar(8) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_caregiver_id`),
  KEY `fk_ patientCaregivers_patientid_idx` (`patient_id`),
  KEY `fk_patientCaregivers_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_ patientCaregivers_patientid` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientCaregivers_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `patientcaregivers` */

insert  into `patientcaregivers`(`patient_caregiver_id`,`patient_id`,`fname`,`lname`,`email`,`phone_code`,`phone`,`is_primary`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`,`hospital_id`) values (1,1,'sharda','jha','sharda@unikove.com','+1','1234567890',1,1,'2020-03-04 06:00:54','2020-03-04 06:00:54',5,5,1),(2,2,'Ram','Sharma','ramsharma@gmail.com','+1','8447262126',1,1,'2020-03-06 15:36:25','2020-03-06 15:36:25',10,10,1),(3,3,'harpreet','testing','testing@testing.com','+1','1223432432',1,1,'2020-03-10 04:17:28','2020-03-10 04:17:28',37,37,26),(4,4,'sudeep','testing','testing@testing.com','+1','3242342343',1,1,'2020-02-28 21:42:56','2020-02-28 21:42:56',37,37,26),(6,6,'sharda','jha','sharda@mailinator.com','+1','7011677780',1,1,'2020-03-04 07:36:15','2020-03-04 07:36:15',5,5,1),(7,7,'sharda','kumari','sharda@unikove.com','+1','7011677780',1,1,'2020-03-12 06:24:36','2020-03-12 06:24:36',5,5,1),(8,8,'shardaa','jha','sharda@mailoinator.com','+1','1234567890',1,1,'2020-03-06 11:39:29','2020-03-06 11:39:29',5,5,1),(9,9,'sharda','jha','sharda@unikove.com','+91','7011677780',1,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(10,10,'neha','jha','neha@mailinator.com','+91','7011677780',1,1,'2020-03-06 11:59:02','2020-03-06 11:59:02',5,5,1),(11,11,'neha','jha','jha@malinator.com','+1','7011677780',1,1,'2020-03-06 12:13:17','2020-03-06 12:13:17',5,5,1),(12,12,'neha','jha','neha@mailinator.com','+91','7011677780',1,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(13,13,'neha','jha','neha@mailinator.com','+91','7011677780',1,1,'2020-03-06 12:30:00','2020-03-06 12:30:00',5,5,1),(14,14,'adsfr','ghgjh','fjhghjkuh@gmail.com','+91','1236547895',1,1,'2020-03-06 12:36:16','2020-03-06 12:36:16',5,5,1),(15,15,'Ratan','Pandey','ratan@unikove.com','+1','7905158966',1,1,'2020-03-06 13:45:45','2020-03-06 13:45:45',10,10,1),(17,17,'vimlesh','jha','sfdg@gmail.com','+91','7529972809',1,1,'2020-03-11 08:06:03','2020-03-11 08:06:03',5,5,1),(18,18,'testing','testing','testing2@testingios.com','+1','2342343242',1,1,'2020-03-13 20:12:44','2020-03-13 20:12:44',37,37,26),(19,18,'sdfsd','sfd','sfsdsdf@sdfs.com','+1','2342343243',1,1,'2020-03-13 20:12:44','2020-03-13 20:12:44',37,37,26),(29,28,'sharda','jha','sharda@unikove.com','+1','7894561235',1,1,'2020-03-13 10:15:11','2020-03-13 10:15:11',5,5,1),(30,29,'sharda','jha','sharda@unikove.com','+91','7011677780',1,1,'2020-03-13 10:26:33','2020-03-13 10:26:33',5,5,1),(31,30,'fsdf','sfd','sdfs@fsds.com','+1','2342342423',1,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26);

/*Table structure for table `patientconditions` */

DROP TABLE IF EXISTS `patientconditions`;

CREATE TABLE `patientconditions` (
  `patient_condition_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `condition_id` int(11) DEFAULT NULL,
  `measure_frequency` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_condition_id`),
  KEY `fk_patientConditions_patientid_idx` (`patient_id`),
  KEY `fk_patientConditions_conditionid_idx` (`condition_id`),
  KEY `fk_patientConditions_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_patientConditions_conditionid` FOREIGN KEY (`condition_id`) REFERENCES `conditionmaster` (`condition_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientConditions_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientConditions_patientid` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;

/*Data for the table `patientconditions` */

insert  into `patientconditions`(`patient_condition_id`,`patient_id`,`condition_id`,`measure_frequency`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`,`hospital_id`) values (2,2,1,NULL,1,'2020-02-18 12:08:51','2020-02-18 12:08:51',4,4,1),(3,2,2,NULL,1,'2020-02-18 12:08:51','2020-02-18 12:08:51',4,4,1),(4,2,3,NULL,1,'2020-02-18 12:08:51','2020-02-18 12:08:51',4,4,1),(5,2,4,NULL,1,'2020-02-18 12:08:51','2020-02-18 12:08:51',4,4,1),(58,1,1,NULL,1,'2020-02-25 07:01:22','2020-02-25 07:01:22',10,10,1),(59,1,2,NULL,1,'2020-02-25 07:01:22','2020-02-25 07:01:22',10,10,1),(60,1,3,NULL,1,'2020-02-25 07:01:22','2020-02-25 07:01:22',10,10,1),(61,1,4,NULL,1,'2020-02-25 07:01:22','2020-02-25 07:01:22',10,10,1),(62,3,1,NULL,1,'2020-02-28 16:54:56','2020-02-28 16:54:56',37,37,26),(63,4,1,NULL,1,'2020-02-28 21:42:56','2020-02-28 21:42:56',37,37,26),(65,6,1,NULL,1,'2020-03-03 05:33:16','2020-03-03 05:33:16',5,5,1),(66,6,3,NULL,1,'2020-03-03 05:33:16','2020-03-03 05:33:16',5,5,1),(67,7,1,NULL,1,'2020-03-03 10:51:23','2020-03-03 10:51:23',5,5,1),(68,8,1,NULL,1,'2020-03-04 07:33:17','2020-03-04 07:33:17',5,5,1),(69,8,3,NULL,1,'2020-03-04 07:33:17','2020-03-04 07:33:17',5,5,1),(70,9,1,NULL,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(71,9,3,NULL,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(72,10,1,NULL,1,'2020-03-06 11:59:02','2020-03-06 11:59:02',5,5,1),(73,10,2,NULL,1,'2020-03-06 11:59:02','2020-03-06 11:59:02',5,5,1),(74,11,1,NULL,1,'2020-03-06 12:13:16','2020-03-06 12:13:16',5,5,1),(75,11,2,NULL,1,'2020-03-06 12:13:16','2020-03-06 12:13:16',5,5,1),(76,11,3,NULL,1,'2020-03-06 12:13:16','2020-03-06 12:13:16',5,5,1),(77,12,1,NULL,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(78,12,2,NULL,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(79,12,3,NULL,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(82,14,1,NULL,1,'2020-03-06 12:36:16','2020-03-06 12:36:16',5,5,1),(83,14,2,NULL,1,'2020-03-06 12:36:16','2020-03-06 12:36:16',5,5,1),(84,15,1,NULL,1,'2020-03-06 12:39:43','2020-03-06 12:39:43',10,10,1),(85,15,3,NULL,1,'2020-03-06 12:39:43','2020-03-06 12:39:43',10,10,1),(86,15,4,NULL,1,'2020-03-06 12:39:43','2020-03-06 12:39:43',10,10,1),(88,17,1,NULL,1,'2020-03-11 08:06:03','2020-03-11 08:06:03',5,5,1),(89,18,1,NULL,1,'2020-03-12 03:32:18','2020-03-12 03:32:18',35,35,26),(90,18,2,NULL,1,'2020-03-12 03:32:18','2020-03-12 03:32:18',35,35,26),(91,18,3,NULL,1,'2020-03-12 03:32:18','2020-03-12 03:32:18',35,35,26),(92,18,4,NULL,1,'2020-03-12 03:32:18','2020-03-12 03:32:18',35,35,26),(108,28,1,NULL,1,'2020-03-13 07:36:45','2020-03-13 07:36:45',5,5,1),(109,28,2,NULL,1,'2020-03-13 07:36:45','2020-03-13 07:36:45',5,5,1),(110,29,2,NULL,1,'2020-03-13 10:26:32','2020-03-13 10:26:32',5,5,1),(111,30,1,NULL,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26),(112,30,3,NULL,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26),(113,30,4,NULL,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26);

/*Table structure for table `patientdevices` */

DROP TABLE IF EXISTS `patientdevices`;

CREATE TABLE `patientdevices` (
  `patient_device_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `procured_by` int(1) DEFAULT NULL,
  `serial_no` varchar(64) DEFAULT NULL,
  `is_paired` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_device_id`),
  KEY `fk_wearableDeviceInfo_userProfile_idx` (`patient_id`),
  KEY `fk_wearableDeviceInfo_deviceid_idx` (`device_id`),
  KEY `fk_patientDevices_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_patientDevices_deviceid` FOREIGN KEY (`device_id`) REFERENCES `devicemaster` (`device_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientDevices_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientDevices_patientid` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1 COMMENT='This table will store the list of health and wearable devices of the user';

/*Data for the table `patientdevices` */

insert  into `patientdevices`(`patient_device_id`,`patient_id`,`device_id`,`procured_by`,`serial_no`,`is_paired`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`,`hospital_id`) values (2,2,1,1,'111',1,1,'2020-02-18 12:08:51','2020-02-18 12:08:51',4,4,1),(3,2,2,1,'222',1,0,'2020-02-18 12:08:51','2020-02-18 12:08:51',4,4,1),(4,2,3,1,'333',1,0,'2020-02-18 12:08:51','2020-02-18 12:08:51',4,4,1),(5,2,4,1,'444',1,1,'2020-02-18 12:08:51','2020-02-18 12:08:51',4,4,1),(6,2,5,1,'555',1,1,'2020-02-18 12:08:51','2020-02-18 12:08:51',4,4,1),(16,1,1,1,'123',1,1,'2020-02-25 07:01:22','2020-02-25 07:01:22',10,10,1),(17,1,2,1,'111',1,0,'2020-02-25 07:01:22','2020-02-25 07:01:22',10,10,1),(18,1,4,1,'222',NULL,1,'2020-02-25 07:01:22','2020-02-25 07:01:22',10,10,1),(19,1,5,1,'333',1,1,'2020-02-25 07:01:22','2020-02-25 07:01:22',10,10,1),(20,1,3,1,'12121',NULL,1,'2020-02-26 05:49:48','2020-02-26 05:49:48',10,10,1),(21,3,1,1,'Serial1234',NULL,1,'2020-02-28 16:54:56','2020-02-28 16:54:56',37,37,26),(22,4,1,1,'Device214',NULL,1,'2020-02-28 21:42:56','2020-02-28 21:42:56',37,37,26),(24,6,1,1,'123',NULL,1,'2020-03-03 05:33:16','2020-03-03 05:33:16',5,5,1),(25,6,4,1,'123',NULL,1,'2020-03-03 05:33:16','2020-03-03 05:33:16',5,5,1),(26,6,5,1,'123',NULL,1,'2020-03-03 05:33:16','2020-03-03 05:33:16',5,5,1),(27,7,1,1,'123',NULL,1,'2020-03-03 10:51:23','2020-03-03 10:51:23',5,5,1),(28,7,4,1,'123',NULL,1,'2020-03-03 10:51:23','2020-03-03 10:51:23',5,5,1),(29,7,5,1,'123',NULL,1,'2020-03-03 10:51:23','2020-03-03 10:51:23',5,5,1),(30,8,5,1,'',NULL,1,'2020-03-04 07:33:17','2020-03-04 07:33:17',5,5,1),(31,9,1,1,'12',NULL,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(32,9,3,1,'12',NULL,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(33,9,4,1,'12',NULL,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(34,9,5,1,'12',NULL,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(35,8,1,1,'123',NULL,1,'2020-03-06 11:39:29','2020-03-06 11:39:29',5,5,1),(36,8,2,1,'123',NULL,1,'2020-03-06 11:39:29','2020-03-06 11:39:29',5,5,1),(37,10,1,1,'123',NULL,1,'2020-03-06 11:59:02','2020-03-06 11:59:02',5,5,1),(38,10,4,1,'123',NULL,1,'2020-03-06 11:59:02','2020-03-06 11:59:02',5,5,1),(39,10,5,1,'123',NULL,1,'2020-03-06 11:59:02','2020-03-06 11:59:02',5,5,1),(40,11,1,1,'125',NULL,1,'2020-03-06 12:13:17','2020-03-06 12:13:17',5,5,1),(41,11,4,1,'12',NULL,1,'2020-03-06 12:13:17','2020-03-06 12:13:17',5,5,1),(42,11,5,1,'123',NULL,1,'2020-03-06 12:13:17','2020-03-06 12:13:17',5,5,1),(43,12,1,1,'123',NULL,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(44,12,4,1,'123',NULL,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(45,12,5,1,'123',NULL,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(46,13,1,1,'123',NULL,1,'2020-03-06 12:30:00','2020-03-06 12:30:00',5,5,1),(47,13,4,1,'123',NULL,1,'2020-03-06 12:30:00','2020-03-06 12:30:00',5,5,1),(48,13,5,1,'123',NULL,1,'2020-03-06 12:30:00','2020-03-06 12:30:00',5,5,1),(49,14,1,1,'123',NULL,1,'2020-03-06 12:36:16','2020-03-06 12:36:16',5,5,1),(50,14,4,1,'123',NULL,1,'2020-03-06 12:36:16','2020-03-06 12:36:16',5,5,1),(51,14,5,1,'123',NULL,1,'2020-03-06 12:36:16','2020-03-06 12:36:16',5,5,1),(52,15,1,3,'',NULL,1,'2020-03-06 12:39:43','2020-03-06 12:39:43',10,10,1),(53,15,4,3,'',NULL,1,'2020-03-06 12:39:43','2020-03-06 12:39:43',10,10,1),(54,15,5,3,'',1,1,'2020-03-06 12:39:43','2020-03-06 12:39:43',10,10,1),(55,16,1,1,'fsfsd2332',NULL,1,'2020-03-10 03:36:59','2020-03-10 03:36:59',37,37,26),(56,17,1,1,'jhjh',NULL,1,'2020-03-11 08:06:03','2020-03-11 08:06:03',5,5,1),(57,17,4,1,'fghh',NULL,1,'2020-03-11 08:06:03','2020-03-11 08:06:03',5,5,1),(58,17,5,1,'bvn',NULL,1,'2020-03-11 08:06:03','2020-03-11 08:06:03',5,5,1),(59,18,1,1,'',NULL,1,'2020-03-12 03:32:18','2020-03-12 03:32:18',35,35,26),(60,18,4,1,'',NULL,1,'2020-03-12 03:32:18','2020-03-12 03:32:18',35,35,26),(61,18,5,1,'',NULL,1,'2020-03-12 03:32:18','2020-03-12 03:32:18',35,35,26),(86,28,4,1,'12',NULL,1,'2020-03-13 07:36:45','2020-03-13 07:36:45',5,5,1),(87,28,5,1,'12',NULL,1,'2020-03-13 07:36:45','2020-03-13 07:36:45',5,5,1),(88,28,1,1,'',NULL,1,'2020-03-13 10:15:11','2020-03-13 10:15:11',5,5,1),(89,29,1,1,'414',NULL,1,'2020-03-13 10:26:33','2020-03-13 10:26:33',5,5,1),(90,29,4,1,'7474',NULL,1,'2020-03-13 10:26:33','2020-03-13 10:26:33',5,5,1),(91,29,5,1,'747',NULL,1,'2020-03-13 10:26:33','2020-03-13 10:26:33',5,5,1),(94,30,1,1,'sdf23432',NULL,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26),(95,30,4,1,'ds23432',NULL,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26),(96,30,5,1,'sfsd23423',NULL,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26);

/*Table structure for table `patientfeedback` */

DROP TABLE IF EXISTS `patientfeedback`;

CREATE TABLE `patientfeedback` (
  `patient_feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `feedback_text` varchar(300) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `is_active` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  PRIMARY KEY (`patient_feedback_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `patientfeedback` */

insert  into `patientfeedback`(`patient_feedback_id`,`patient_id`,`feedback_text`,`hospital_id`,`is_active`,`created_by`,`created_dttm`,`modified_by`,`modified_dttm`) values (1,1,'fsgdfgdf',1,1,1,'2020-03-13 13:43:30',1,'2020-03-13 13:43:31'),(2,2,'fsgdfgdf',1,1,2,'2020-03-13 15:55:16',2,'2020-03-13 15:55:16'),(3,2,'poiuytrd',1,1,2,'2020-03-13 16:13:51',2,'2020-03-13 16:13:51'),(4,1,'Good ',1,1,1,'2020-03-14 05:12:01',1,'2020-03-14 05:12:01'),(5,1,'Very good ',1,1,1,'2020-03-14 05:13:45',1,'2020-03-14 05:13:45'),(6,1,'Test',1,1,1,'2020-03-16 05:25:37',1,'2020-03-16 05:25:37'),(7,2,'fsgdfgdf',1,1,2,'2020-03-16 07:14:26',2,'2020-03-16 07:14:26');

/*Table structure for table `patientnotes` */

DROP TABLE IF EXISTS `patientnotes`;

CREATE TABLE `patientnotes` (
  `patient_note_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `notes` varchar(512) DEFAULT NULL,
  `recorded_dttm` datetime DEFAULT NULL,
  `hospital_user_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_note_id`),
  KEY `fk_patientNotes_patientid_idx` (`patient_id`),
  KEY `fk_patientNotes_hospitaluserid_idx` (`hospital_user_id`),
  KEY `fk_patientNotes_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_patientNotes_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientNotes_hospitaluserid` FOREIGN KEY (`hospital_user_id`) REFERENCES `hospitalusers` (`hospital_user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientNotes_patientid` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

/*Data for the table `patientnotes` */

insert  into `patientnotes`(`patient_note_id`,`patient_id`,`notes`,`recorded_dttm`,`hospital_user_id`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`,`hospital_id`) values (1,1,'Test Data from Ratan Pandey','2020-02-24 04:57:08',5,1,'2020-02-24 04:57:08',NULL,1,NULL,1),(2,2,'Add notes','2020-02-27 19:18:44',10,1,'2020-02-27 19:18:44',NULL,1,NULL,1),(3,1,'','2020-03-02 11:56:51',10,1,'2020-03-02 11:56:51','2020-03-02 11:56:51',10,10,1),(10,8,'test','2020-03-04 08:02:06',5,1,'2020-03-04 08:02:06',NULL,1,NULL,1),(11,8,'test','2020-03-04 08:02:19',5,1,'2020-03-04 08:02:19',NULL,1,NULL,1),(12,8,'test','2020-03-04 08:07:37',5,1,'2020-03-04 08:07:37',NULL,1,NULL,1),(13,8,'test','2020-03-04 08:07:39',5,1,'2020-03-04 08:07:39',NULL,1,NULL,1),(15,8,'ffff','2020-03-04 09:52:09',10,1,'2020-03-04 09:52:09','2020-03-04 09:52:09',10,10,1),(16,1,'zzzzzzzznotes','2020-03-04 15:23:45',10,1,'2020-03-04 15:23:45',NULL,1,NULL,1),(17,6,'dddd','2020-03-04 09:59:17',10,1,'2020-03-04 09:59:17','2020-03-04 09:59:17',10,10,1),(18,6,'dddddddddd','2020-03-04 10:00:57',10,1,'2020-03-04 10:00:57','2020-03-04 10:00:57',10,10,1),(19,6,'fdfdfdfdfdfas vadsd','2020-03-04 10:01:51',10,1,'2020-03-04 10:01:51','2020-03-04 10:01:51',10,10,1),(20,6,'fdfdf dfdfd','2020-03-04 10:02:39',10,1,'2020-03-04 10:02:39','2020-03-04 10:02:39',10,10,1),(25,6,'d s sd sd sd sddsd','2020-03-04 10:26:11',10,1,'2020-03-04 10:26:11','2020-03-04 10:26:11',10,10,1),(26,3,'adding notes\n','2020-03-10 04:17:47',37,1,'2020-03-10 04:17:47',NULL,26,NULL,26),(27,1,'test','2020-03-11 06:17:24',5,1,'2020-03-11 06:17:24',NULL,1,NULL,1),(28,2,'test','2020-03-11 07:26:15',5,1,'2020-03-11 07:26:15',NULL,1,NULL,1),(29,1,'test','2020-03-11 14:28:30',10,1,'2020-03-11 14:28:30','2020-03-11 14:28:30',10,10,1),(30,1,'testing by Vim','2020-03-11 14:32:53',10,1,'2020-03-11 14:32:53','2020-03-11 14:32:53',10,10,1),(31,7,'jkhk','2020-03-11 14:33:59',10,1,'2020-03-11 14:33:59','2020-03-11 14:33:59',10,10,1),(32,7,'test','2020-03-13 11:00:40',10,1,'2020-03-13 11:00:40',NULL,1,NULL,1),(33,18,'add notes','2020-03-13 20:04:17',37,1,'2020-03-13 20:04:17',NULL,26,NULL,26);

/*Table structure for table `patientnotifications` */

DROP TABLE IF EXISTS `patientnotifications`;

CREATE TABLE `patientnotifications` (
  `patient_notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `vital_id` int(11) DEFAULT NULL,
  `vital_value` double DEFAULT NULL,
  `recorded_dttm` datetime DEFAULT NULL,
  `notification_type` tinyint(1) DEFAULT NULL COMMENT '1 - Warning\n2 - Emergency',
  `notification_message` varchar(512) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_notification_id`),
  KEY `fk_patientNotifications_patientid_idx` (`patient_id`),
  KEY `fk_patientNotifications_vitalid_idx` (`vital_id`),
  KEY `fk_patientNotifications_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_patientNotifications_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientNotifications_patientid` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientNotifications_vitalid` FOREIGN KEY (`vital_id`) REFERENCES `vitalmaster` (`vital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This table will store all the notifications sent out to the users. The table records all details at the time of the notification including the vitals, location, battery level. The table also records the calling details in case of emergencies';

/*Data for the table `patientnotifications` */

/*Table structure for table `patientnursedoctor` */

DROP TABLE IF EXISTS `patientnursedoctor`;

CREATE TABLE `patientnursedoctor` (
  `patient_nurse_doctor_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `nurse_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `start_dttm` datetime DEFAULT NULL,
  `end_dttm` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_nurse_doctor_id`),
  KEY `fk_patientNurseDoctor_patientid_idx` (`patient_id`),
  KEY `fk_patientNurseDoctor_nurseid_idx` (`nurse_id`),
  KEY `fk_patientNurseDoctor_doctorid_idx` (`doctor_id`),
  KEY `fk_patientNurseDoctor_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_patientNurseDoctor_doctorid` FOREIGN KEY (`doctor_id`) REFERENCES `hospitalusers` (`hospital_user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientNurseDoctor_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientNurseDoctor_nurseid` FOREIGN KEY (`nurse_id`) REFERENCES `hospitalusers` (`hospital_user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientNurseDoctor_patientid` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

/*Data for the table `patientnursedoctor` */

insert  into `patientnursedoctor`(`patient_nurse_doctor_id`,`patient_id`,`nurse_id`,`doctor_id`,`start_dttm`,`end_dttm`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`,`hospital_id`) values (1,1,7,NULL,NULL,NULL,1,'2020-03-04 06:00:54','2020-03-04 06:00:54',5,5,1),(2,2,7,NULL,NULL,NULL,1,'2020-03-06 15:36:26','2020-03-06 15:36:26',10,10,1),(3,3,37,NULL,NULL,NULL,1,'2020-03-10 04:17:28','2020-03-10 04:17:28',37,37,26),(4,4,37,NULL,NULL,NULL,1,'2020-02-28 21:42:56','2020-02-28 21:42:56',37,37,26),(6,6,7,6,NULL,NULL,1,'2020-03-04 07:36:15','2020-03-04 07:36:15',5,5,1),(7,7,7,NULL,NULL,NULL,1,'2020-03-12 06:24:36','2020-03-12 06:24:36',5,5,1),(8,8,7,NULL,NULL,NULL,1,'2020-03-06 11:39:29','2020-03-06 11:39:29',5,5,1),(9,9,7,NULL,NULL,NULL,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(10,10,7,NULL,NULL,NULL,1,'2020-03-06 11:59:02','2020-03-06 11:59:02',5,5,1),(11,11,7,NULL,NULL,NULL,1,'2020-03-06 12:13:17','2020-03-06 12:13:17',5,5,1),(12,12,7,NULL,NULL,NULL,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(13,13,7,NULL,NULL,NULL,1,'2020-03-06 12:30:00','2020-03-06 12:30:00',5,5,1),(14,14,7,NULL,NULL,NULL,1,'2020-03-06 12:36:16','2020-03-06 12:36:16',5,5,1),(15,15,7,NULL,NULL,NULL,1,'2020-03-06 13:45:45','2020-03-06 13:45:45',10,10,1),(16,16,37,NULL,NULL,NULL,1,'2020-03-10 03:36:59','2020-03-10 03:36:59',37,37,26),(17,17,7,NULL,NULL,NULL,1,'2020-03-11 08:06:03','2020-03-11 08:06:03',5,5,1),(18,18,37,NULL,NULL,NULL,1,'2020-03-13 20:12:44','2020-03-13 20:12:44',37,37,26),(28,28,7,NULL,NULL,NULL,1,'2020-03-13 10:15:11','2020-03-13 10:15:11',5,5,1),(29,29,7,NULL,NULL,NULL,1,'2020-03-13 10:26:33','2020-03-13 10:26:33',5,5,1),(30,30,37,NULL,NULL,NULL,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26);

/*Table structure for table `patientreminders` */

DROP TABLE IF EXISTS `patientreminders`;

CREATE TABLE `patientreminders` (
  `patient_reminder_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `hospital_user_id` int(11) DEFAULT NULL,
  `reminder_date` date DEFAULT NULL,
  `reminder_time` time DEFAULT NULL,
  `reminder_notes` varchar(512) DEFAULT NULL,
  `is_complete` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_reminder_id`),
  KEY `fk_patientReminders_patient_id_idx` (`patient_id`),
  KEY `fk_patientReminders_hospitaluserod_idx` (`hospital_user_id`),
  KEY `fk_patientReminders_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_patientReminders_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientReminders_hospitaluserod` FOREIGN KEY (`hospital_user_id`) REFERENCES `hospitalusers` (`hospital_user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientReminders_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `patientreminders` */

insert  into `patientreminders`(`patient_reminder_id`,`patient_id`,`hospital_user_id`,`reminder_date`,`reminder_time`,`reminder_notes`,`is_complete`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`,`hospital_id`) values (1,6,10,'2020-03-10','16:00:00','Reminder Notes',0,NULL,'2020-03-04 09:37:27','2020-03-04 09:37:27',10,10,1),(2,8,10,'2020-03-05','13:00:00','bbbb',0,1,'2020-03-04 09:52:13','2020-03-04 09:52:13',10,10,1),(3,6,10,'2020-03-10','14:00:00','jhjhj',0,1,'2020-03-04 09:59:19','2020-03-04 09:59:19',10,10,1),(4,6,10,'2020-03-19','16:00:00','llllllllll',0,1,'2020-03-04 10:00:59','2020-03-04 10:00:59',10,10,1),(5,6,10,'2020-03-25','18:00:00','gv asdcas asdad',0,1,'2020-03-04 10:01:53','2020-03-04 10:01:53',10,10,1),(6,6,10,'2020-03-10','17:00:00','fd fdf df df',0,1,'2020-03-04 10:02:41','2020-03-04 10:02:41',10,10,1),(7,7,10,'2020-03-06','12:00:00','gg fg fdg ',0,1,'2020-03-04 10:03:44','2020-03-04 10:03:44',10,10,1),(8,7,10,'2020-04-08','12:00:00','cx x cx xc x cx cx  xc ',0,1,'2020-03-04 10:10:57','2020-03-04 10:10:57',10,10,1),(9,7,10,'2020-03-02','16:00:00','fg fg hfg fgh fg hfgh',0,1,'2020-03-04 10:11:47','2020-03-04 10:11:47',10,10,1),(10,1,10,'2020-03-12','12:00:00','testing reminder',0,1,'2020-03-11 14:28:30','2020-03-11 14:28:30',10,10,1),(11,1,10,'2020-03-13','12:00:00','Remonder tetsing By vimlesh',0,1,'2020-03-11 14:32:53','2020-03-11 14:32:53',10,10,1),(12,7,10,'2020-03-13','12:00:00','reminder',0,1,'2020-03-11 14:33:59','2020-03-11 14:33:59',10,10,1);

/*Table structure for table `patients` */

DROP TABLE IF EXISTS `patients`;

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL AUTO_INCREMENT,
  `mrn_no` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `fname` varchar(64) DEFAULT NULL,
  `mname` varchar(64) DEFAULT NULL,
  `lname` varchar(64) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `mobile_code` varchar(8) DEFAULT NULL,
  `mobile` varchar(16) DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL COMMENT '1 - Male, 2 - Female, 3 - Other, 4 - Unknown',
  `dob` date DEFAULT NULL,
  `image_url` varchar(256) DEFAULT NULL,
  `payer_type` int(1) DEFAULT NULL,
  `payer_details` varchar(512) DEFAULT NULL,
  `is_monitored` tinyint(1) DEFAULT NULL,
  `monitoring_start` datetime DEFAULT NULL,
  `monitoring_end` datetime DEFAULT NULL,
  `code` varchar(6) DEFAULT NULL,
  `code_expiry` datetime DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `mobile_token` varchar(256) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `measure_frequency_total` varchar(16) DEFAULT NULL,
  `patient_data` text,
  `patientappointmentrequests_data` text,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_id`),
  KEY `fk_patients_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_patients_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COMMENT='This table will have all the patients in the HealthArc system. The table stores the profile details of the patient';

/*Data for the table `patients` */

insert  into `patients`(`patient_id`,`mrn_no`,`fname`,`mname`,`lname`,`email`,`mobile_code`,`mobile`,`gender`,`dob`,`image_url`,`payer_type`,`payer_details`,`is_monitored`,`monitoring_start`,`monitoring_end`,`code`,`code_expiry`,`password`,`mobile_token`,`hospital_id`,`measure_frequency_total`,`patient_data`,`patientappointmentrequests_data`,`is_active`,`created_dttm`,`created_by`,`modified_by`) values (1,'123','Sushil','balhblah','einstein','aabv@yahoo.com','+91','9637590624',1,'1985-10-10','hospital_id_1/patient_id_1/profileImg1584340502.png',1,'test is test',1,'2020-03-08 00:00:00','2020-03-20 00:00:00','J37NYL','2020-02-19 10:16:31','c1898d8c52dde8fac9951d0ea67d19c58ea44798e4a0bcd1a502483080ed4c636907b2e7ff2b86c6afa2aa641dab27c7173eae2b7c41a524f3dfcc0cd6f2dca4','',1,'10','{\"vital_id\":[\"3\",\"4\",\"2\",\"1\",\"5\",\"6\"],\"vital_value\":[\"75\",\"90\",\"110\",\"130\",\"100\",\"90\"],\"vital_value_type\":[\"3\",\"3\",\"3\",\"1\",\"3\",\"1\"],\"vitalIDTotal\":\"94\"}','{\"patient_id\":\"1\",\"patient_appointment_request_id\":\"17\",\"appointment_type\":\"1\",\"is_completed\":\"0\"}',1,'2020-03-04 06:00:54',5,5),(2,'1234','Santosh','','Sharma','santosh23587@gmial.com','+91','12345678',1,'1987-05-23',NULL,1,'Info',1,'2020-03-02 00:00:00','2020-03-05 00:00:00','HA35TK','2020-02-27 10:00:42','eb974e37852e862817684379223158fc0c124182da76f4f85ab19b828488e3085db31e4395cde841f4e1e3752bedeaf0409e698a139788933e3fdddab5bd0529','',1,'11','{\"vital_id\":[\"1\",\"2\"],\"vital_value\":[\"110\",\"100\"],\"vital_value_type\":[\"1\",\"2\"],\"vitalIDTotal\":\"3\"}','{\"patient_id\":\"2\",\"patient_appointment_request_id\":\"7\",\"appointment_type\":\"2\",\"is_completed\":\"0\"}',1,'2020-03-06 15:36:25',10,10),(3,'testing123','Sudeep','Sss','Patient','sudeep777@gmail.com','+1','2019511111',1,'1980-01-01',NULL,1,'Dummy Aetna',0,'2020-02-28 00:00:00','2021-01-31 00:00:00','JQSEB1','2020-03-04 01:37:13','13948f555f3fb3e0f5e0728888232600f60b440ee988f630abb719db10c4ef159c1dec68993b91aca536a08c548bee42d4b6d02183a57c91ae9d717a3220a1d5','',26,'6',NULL,NULL,1,'2020-03-10 04:17:28',37,37),(4,'Testing2','Harpreet','S','Testing','preitii@gmail.com','+1','2019667928',2,'1981-01-01',NULL,1,'zdfs',1,'2020-02-28 00:00:00',NULL,'815V3J','2020-02-29 21:42:56','2e005c0fc59501e550ea9396bbc6538ca0156dd7c5d98dbb75b3477ee0a8d4f823370cdf195d2ed072fc491bf540cc59528f74d11823362b3539d6e2974dac34','',26,'6',NULL,NULL,0,'2020-02-28 21:42:56',37,37),(6,'123','neha','','jha','sharda1@unikove.com','+91','7051677780',2,'1993-10-05',NULL,1,'test',1,'2020-03-03 00:00:00','2020-03-26 00:00:00','TOG5SM','2020-03-04 05:33:16','1892511fc34c2d3533b6352b7655cad4d7680a4fbde35fb9d1186fcce183a9176396e69ec4b5180ebfc85cb5909ec5d2ba1d36a583290ace46d2b8a2248347af','',1,'15',NULL,NULL,0,'2020-03-04 07:36:15',5,5),(7,'123','Santosh','balhblah','Kumar','aabv@yahoo.com','+91','9268710331',1,'1989-10-10',NULL,1,'test',1,'2020-03-03 00:00:00','2020-03-17 00:00:00','0AK4BE','2020-03-14 07:56:36','eb974e37852e862817684379223158fc0c124182da76f4f85ab19b828488e3085db31e4395cde841f4e1e3752bedeaf0409e698a139788933e3fdddab5bd0529','12344543424323244354',1,'15','{\"vital_id\":[\"3\",\"2\",\"1\",\"5\",\"4\"],\"vital_value\":[\"400\",\"500\",\"100\",\"100\",\"70\"],\"vital_value_type\":[\"3\",\"3\",\"1\",\"3\",\"3\"],\"vitalIDTotal\":\"62\"}',NULL,1,'2020-03-12 06:24:36',5,5),(8,'Test','Test','balgergehblah','egrge','sharda@mailinator.com','+91','7529972809',1,'1993-01-11',NULL,1,'test',1,'2020-03-04 00:00:00','2020-03-20 00:00:00','0LCEGO','2020-03-05 07:33:17','c6ee9e33cf5c6715a1d148fd73f7318884b41adcb916021e2bc0e800a5c5dd97f5142178f6ae88c8fdd98e1afb0ce4c8d2c54b5f37b30b7da1997bb33b0b8a31','',1,'3',NULL,NULL,1,'2020-03-06 11:39:29',5,5),(9,'12','Ashish','','kumar','shardachy14@mailinator.com','+91','9045147729',1,'1989-10-10',NULL,1,'test',1,'2020-03-04 00:00:00','2020-03-28 00:00:00','X9JVWH','2020-03-05 19:11:42','6f02f7ba1b72a80eece536cac21806e7478262b35afa02c1ec719ab263e49b375b8787424b4bc14bee56dd3a54f6176c544fa20843f1b50cf8e8156cbdac658d','',1,'15',NULL,NULL,0,'2020-03-04 19:11:42',5,5),(10,'123','sharda','','jha','sharda@y3nikove.com','+91','70154677788',2,'1994-03-14',NULL,1,'test',1,'2020-03-06 00:00:00','2020-03-19 00:00:00','R57H0Q','2020-03-07 11:59:02','1892511fc34c2d3533b6352b7655cad4d7680a4fbde35fb9d1186fcce183a9176396e69ec4b5180ebfc85cb5909ec5d2ba1d36a583290ace46d2b8a2248347af','',1,'15',NULL,NULL,0,'2020-03-06 11:59:02',5,5),(11,'Vimlesh','vimlesh','','yadav','sharda7@unikove.com','+91','7011877787',2,'3199-09-14',NULL,1,'test',1,'2020-03-06 00:00:00','2020-03-31 00:00:00','D6CZL9','2020-03-07 12:13:16','4f19dd67e79dcb7140dfe1e364e03e07fc51f22f6002f31624fb0b273fe0867f0b57b6dfb24cfd0ce2e62cefc4b75ea6391718485264098ee57b2a0b664a81bc','',1,'14',NULL,NULL,0,'2020-03-06 12:13:16',5,5),(12,'123','manohar','','chy','ramjee@gmail.com','+91','7011677680',2,'1994-03-14',NULL,1,'test',1,'2020-03-06 00:00:00','2020-03-26 00:00:00','03XS82','2020-03-07 12:21:38','1892511fc34c2d3533b6352b7655cad4d7680a4fbde35fb9d1186fcce183a9176396e69ec4b5180ebfc85cb5909ec5d2ba1d36a583290ace46d2b8a2248347af','',1,'15',NULL,NULL,0,'2020-03-06 12:21:38',5,5),(13,'123','Shivanshu','','kumar','shivanshu@unikove.com','+91','9650221365',1,'1997-10-10',NULL,1,'test',1,'2020-03-06 00:00:00','2020-03-26 00:00:00','GT7ZBJ','2020-03-07 12:30:00','088b1424bafee498b580a63bd33a6a9f3c7b2b5458c1d456ccb4c28634f134e60dd8f7956f296fdb5b2262c18b53f34a4153e52b16f7573738d992fb1c434e24','',1,'15',NULL,NULL,0,'2020-03-06 12:30:00',5,5),(14,'123','shivanshu','','kumar','shivanshu1@unikove.com','+91','9650221367',1,'1998-10-10',NULL,1,'test',1,'2020-03-06 00:00:00','2020-03-27 00:00:00','FPCYZU','2020-03-07 12:36:16','f60b8389480b41cdbe44a76232344a34e743238f0dd1e2efb514be430bebec422d963a33f5fc2e2b4f1afd041bb34ad97efc33f5294b81ce56f67e42ff5bc103','',1,'15','{\"vital_id\":[\"3\",\"2\",\"1\"],\"vital_value\":[\"96\",\"80\",\"120\"],\"vital_value_type\":[\"3\",\"1\",\"1\"],\"vitalIDTotal\":\"6\"}',NULL,1,'2020-03-06 12:36:16',5,5),(15,'12345','Jasmeet','Singh','Batra','jasmeetbatra@gmail.com','+91','9811150401',1,'1975-09-25',NULL,1,'Payer Details description',1,'2020-03-06 00:00:00','2020-08-28 00:00:00','3NYSIP','2020-03-07 12:42:35','4e38d3732530dbe9a89b1ac847b244a9dc9e4c26480350ac6023a22cd5b34ed877f33b4419e22cc12d742559999bfcdd3a371db8611a934e090f273eef708e19','',1,'15','{\"vital_id\":[\"2\",\"3\",\"5\",\"1\"],\"vital_value\":[\"88\",\"59\",\"212\",\"1118\"],\"vital_value_type\":[\"1\",\"1\",\"3\",\"3\"],\"vitalIDTotal\":\"11\"}',NULL,1,'2020-03-06 13:45:45',10,10),(16,'testingiosbuild','sudeep','','bath','sudeepbath@gmail.com','+1','2019667928',1,'1980-01-01',NULL,1,'rsfds sdf s',1,'2020-03-09 00:00:00','2020-05-31 00:00:00','7TNV36','2020-03-11 03:36:59','d17fd56b3b2b913cf40cdf7bf3c004b941ba94c78b4db71a8898015e010c889f687e79b0f1ee98132baa21965dc74a58d8a7b36563343aee2a777ae36b00a2e6','',26,'6',NULL,NULL,0,'2020-03-10 03:36:59',37,37),(17,'789','mona','','jha','shardachy14@gmail.com','+91','7011677470',2,'1994-03-14',NULL,1,'test',1,'2020-03-11 00:00:00','2020-03-31 00:00:00','PY754Z','2020-03-12 08:06:02','c0def7d6491cd486fb16fb368ad721a657f9fc02f5c0c28c88917cd65065b2127772f4f24485ce435cb76e4f92fe196482207c7bb6236e086018796e09e5e6ea','',1,'15',NULL,NULL,0,'2020-03-11 08:06:02',5,5),(18,'testingios','sudeep','','android build','sudeep77@gmail.com','+1','2019511687',1,'1990-11-03',NULL,1,'dfdfsfs',1,'2020-03-11 00:00:00','2020-10-31 00:00:00','03MOPR','2020-03-13 03:32:18','d17fd56b3b2b913cf40cdf7bf3c004b941ba94c78b4db71a8898015e010c889f687e79b0f1ee98132baa21965dc74a58d8a7b36563343aee2a777ae36b00a2e6','',26,NULL,NULL,NULL,0,'2020-03-13 20:12:44',37,37),(28,'123','Ram','','jee','ramjee12@unikove.com','+91','7011677780',1,'1985-10-10',NULL,1,'test',1,'2020-03-13 00:00:00','2020-03-31 00:00:00','YMS5U4','2020-03-14 07:36:44','8c816c86df0a0ce65e0366b3d8beb68da16c25fad2010f449c4eaf49f7414f540e55628bab6b5716d9136d0c3854e1c2263d8b93f0cbebf1bd7c4848ec383280','',1,NULL,'{\"vital_id\":[\"5\",\"1\",\"2\",\"3\",\"4\"],\"vital_value\":[\"60\",\"80\",\"120\",\"90\",\"100\"],\"vital_value_type\":[\"1\",\"3\",\"3\",\"3\",\"3\"],\"vitalIDTotal\":\"11\"}',NULL,1,'2020-03-13 10:15:11',5,5),(29,'75','Dharmendra','','sir','dharmendra@unikove.com','+91','9540992309',1,'1985-10-11',NULL,1,'test',1,'2020-03-13 00:00:00','2020-03-31 00:00:00','J3T4DQ','2020-03-14 10:26:32','0ac4884188e979268c3f77a0f35dc30f513d46d7b8f44a6eb40794d8dbc344a8f637038553e441ff146b94aa5c4aa713d489b1b7586ef320219de0d6591b5b05','12344543424323244354',1,NULL,NULL,NULL,1,'2020-03-13 10:26:32',5,5),(30,'android build 0313','sudeep','android',' build test','sudeep@healthnode.us','+1','2018885488',1,'1990-01-01',NULL,1,'sdfdsf ',1,'2020-03-13 00:00:00','2020-09-30 00:00:00','OFQE9A','2020-03-14 23:58:44','d17fd56b3b2b913cf40cdf7bf3c004b941ba94c78b4db71a8898015e010c889f687e79b0f1ee98132baa21965dc74a58d8a7b36563343aee2a777ae36b00a2e6','12344543424323244354',26,NULL,NULL,NULL,1,'2020-03-13 23:58:44',35,35);

/*Table structure for table `patientvitaldata` */

DROP TABLE IF EXISTS `patientvitaldata`;

CREATE TABLE `patientvitaldata` (
  `patient_vital_data_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `patient_device_id` int(11) DEFAULT NULL,
  `vital_id` int(11) DEFAULT NULL,
  `vital_value` double DEFAULT NULL,
  `recorded_dttm` datetime DEFAULT NULL,
  `vital_value_type` tinyint(1) DEFAULT NULL COMMENT '1 - Normal\n2 - Warning\n3 - Emergency',
  `vital_value_multiple` longtext,
  `vital_recorded_type` int(11) DEFAULT NULL COMMENT '1=Automatic, 2=Manual',
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_vital_data_id`),
  KEY `fk_userActivityDataDaySummary_userid_idx` (`patient_id`),
  KEY `fk_userActivityDataDaySummary_activityid_idx` (`vital_id`),
  KEY `fk_userActivityDataDaySummary_werabledeviceid_idx` (`patient_device_id`),
  KEY `fk_patientVitalData_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_patientVitalData_deviceid` FOREIGN KEY (`patient_device_id`) REFERENCES `patientdevices` (`patient_device_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientVitalData_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientVitalData_patientid` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientVitalData_vitalid` FOREIGN KEY (`vital_id`) REFERENCES `vitalmaster` (`vital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=274 DEFAULT CHARSET=latin1 COMMENT='This table stores “Activity” summary for each user. Activity would include steps, calories, flights climbed, stand hours';

/*Data for the table `patientvitaldata` */

insert  into `patientvitaldata`(`patient_vital_data_id`,`patient_id`,`hospital_id`,`patient_device_id`,`vital_id`,`vital_value`,`recorded_dttm`,`vital_value_type`,`vital_value_multiple`,`vital_recorded_type`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`) values (1,2,1,2,1,110,'2020-01-19 07:27:11',1,NULL,2,1,'2020-03-06 10:15:05','2020-03-06 10:15:05',2,2),(2,2,1,5,2,80,'2020-01-19 07:27:11',1,NULL,2,1,'2020-03-06 10:15:05','2020-03-06 10:15:05',2,2),(3,2,1,6,2,100,'2020-01-19 07:27:11',2,NULL,1,1,'2020-03-06 10:15:05','2020-03-06 10:15:05',2,2),(4,2,1,2,1,110,'2020-01-19 07:27:11',1,NULL,2,1,'2020-03-06 10:32:17','2020-03-06 10:32:17',2,2),(5,2,1,5,2,80,'2020-01-19 07:27:11',1,NULL,2,1,'2020-03-06 10:32:17','2020-03-06 10:32:17',2,2),(6,2,1,6,2,100,'2020-01-19 07:27:11',2,NULL,1,1,'2020-03-06 10:32:17','2020-03-06 10:32:17',2,2),(7,2,1,2,1,110,'2020-01-19 07:27:11',1,NULL,2,1,'2020-03-06 10:32:32','2020-03-06 10:32:32',2,2),(8,1,1,2,2,110,'2020-03-06 11:24:35',3,NULL,2,1,'2020-03-06 10:33:06','2020-03-06 10:33:06',1,1),(10,15,1,2,1,110,'2020-03-07 14:01:47',1,NULL,2,1,'2020-03-06 10:35:48','2020-03-06 10:35:48',15,15),(11,15,1,5,2,80,'2020-03-07 14:01:47',1,NULL,2,1,'2020-03-06 10:35:48','2020-03-06 10:35:48',15,15),(12,15,1,6,2,100,'2020-03-07 14:01:46',2,NULL,1,1,'2020-03-06 10:35:48','2020-03-06 10:35:48',15,15),(13,3,1,2,1,110,'2020-01-19 07:27:11',0,NULL,2,1,'2020-03-06 10:36:53','2020-03-06 10:36:53',3,3),(14,3,1,5,2,80,'2020-01-19 07:27:11',0,NULL,2,1,'2020-03-06 10:36:53','2020-03-06 10:36:53',3,3),(15,3,1,6,2,100,'2020-01-19 07:27:11',0,NULL,1,1,'2020-03-06 10:36:53','2020-03-06 10:36:53',3,3),(16,7,1,2,1,110,'2020-01-19 07:27:11',1,NULL,2,1,'2020-03-06 10:42:16','2020-03-06 10:42:16',7,7),(17,7,1,5,2,80,'2020-01-19 07:27:11',2,NULL,2,1,'2020-03-06 10:42:16','2020-03-06 10:42:16',7,7),(18,7,1,6,2,100,'2020-01-19 07:27:11',1,NULL,1,1,'2020-03-06 10:42:16','2020-03-06 10:42:16',7,7),(19,7,1,2,2,110,'2020-01-19 07:27:11',1,NULL,2,1,'2020-03-06 10:45:07','2020-03-06 10:45:07',7,7),(20,7,1,2,1,120,'2020-03-06 10:46:25',1,NULL,2,1,'2020-03-06 10:46:40','2020-03-06 10:46:40',7,7),(21,7,1,2,2,100,'2020-03-06 10:46:25',1,NULL,2,1,'2020-03-06 10:46:40','2020-03-06 10:46:40',7,7),(22,7,1,2,3,90,'2020-03-03 10:46:25',3,NULL,2,1,'2020-03-06 10:46:40','2020-03-06 10:46:40',7,7),(23,1,1,2,4,100,'2020-03-06 11:36:29',2,NULL,2,1,'2020-03-06 11:36:29','2020-03-06 11:36:29',1,1),(24,1,1,3,3,90,'2020-03-06 11:38:12',2,NULL,2,1,'2020-03-06 11:38:12','2020-03-06 11:38:12',1,1),(25,7,1,2,1,120,'2020-03-06 12:14:07',1,NULL,2,1,'2020-03-06 12:14:21','2020-03-06 12:14:21',7,7),(26,7,1,2,2,100,'2020-03-06 12:14:07',1,NULL,2,1,'2020-03-06 12:14:21','2020-03-06 12:14:21',7,7),(27,7,1,2,3,90,'2020-03-04 12:14:07',3,NULL,2,1,'2020-03-06 12:14:21','2020-03-06 12:14:21',7,7),(28,14,1,2,1,120,'2020-03-06 13:29:27',1,NULL,2,1,'2020-03-06 13:29:28','2020-03-06 13:29:28',14,14),(29,14,1,2,2,80,'2020-03-06 13:29:27',1,NULL,2,1,'2020-03-06 13:29:28','2020-03-06 13:29:28',14,14),(30,14,1,2,3,99,'2020-03-06 13:29:27',3,NULL,2,1,'2020-03-06 13:29:28','2020-03-06 13:29:28',14,14),(31,14,1,2,1,120,'2020-03-06 13:29:27',1,NULL,2,1,'2020-03-06 13:29:50','2020-03-06 13:29:50',14,14),(32,14,1,2,2,80,'2020-03-06 13:29:27',1,NULL,2,1,'2020-03-06 13:29:50','2020-03-06 13:29:50',14,14),(33,14,1,2,3,99,'2020-03-06 13:29:27',3,NULL,2,1,'2020-03-06 13:29:50','2020-03-06 13:29:50',14,14),(34,14,1,2,1,120,'2020-03-06 13:29:49',1,NULL,2,1,'2020-03-06 13:29:50','2020-03-06 13:29:50',14,14),(35,14,1,2,2,80,'2020-03-06 13:29:49',1,NULL,2,1,'2020-03-06 13:29:50','2020-03-06 13:29:50',14,14),(36,14,1,2,3,96,'2020-03-06 13:29:49',3,NULL,2,1,'2020-03-06 13:29:50','2020-03-06 13:29:50',14,14),(37,15,1,2,1,140,'2020-03-06 13:47:39',2,NULL,2,1,'2020-03-06 13:48:00','2020-03-06 13:48:00',15,15),(38,15,1,2,2,80,'2020-03-06 13:47:39',1,NULL,2,1,'2020-03-06 13:48:00','2020-03-06 13:48:00',15,15),(39,15,1,2,3,72,'2020-03-06 13:47:39',1,NULL,2,1,'2020-03-06 13:48:00','2020-03-06 13:48:00',15,15),(40,7,1,2,1,100,'2020-03-06 13:57:04',1,NULL,2,1,'2020-03-06 13:57:17','2020-03-06 13:57:17',7,7),(41,7,1,2,2,90,'2020-03-06 13:57:04',1,NULL,2,1,'2020-03-06 13:57:17','2020-03-06 13:57:17',7,7),(42,7,1,2,3,70,'2020-03-05 13:57:04',1,NULL,2,1,'2020-03-06 13:57:17','2020-03-06 13:57:17',7,7),(43,7,1,6,5,50,'2020-03-06 13:57:44',1,NULL,2,1,'2020-03-06 13:57:57','2020-03-06 13:57:57',7,7),(44,7,1,6,3,50,'2020-03-05 13:57:44',2,NULL,2,1,'2020-03-06 13:57:57','2020-03-06 13:57:57',7,7),(45,15,1,54,1,1118,'2020-03-06 14:01:46',3,NULL,1,1,'2020-03-06 14:02:22','2020-03-06 14:02:22',15,15),(46,15,1,54,1,1118,'2020-03-06 14:01:46',3,NULL,1,1,'2020-03-06 14:02:22','2020-03-06 14:02:22',15,15),(47,15,1,54,2,88,'2020-03-06 14:01:46',1,NULL,1,1,'2020-03-06 14:02:22','2020-03-06 14:02:22',15,15),(48,15,1,54,2,88,'2020-03-06 14:01:46',1,NULL,1,1,'2020-03-06 14:02:22','2020-03-06 14:02:22',15,15),(49,15,1,54,1,1118,'2020-03-06 14:01:46',3,NULL,1,1,'2020-03-06 14:02:22','2020-03-06 14:02:22',15,15),(50,15,1,54,2,88,'2020-03-06 14:01:46',1,NULL,1,1,'2020-03-06 14:02:22','2020-03-06 14:02:22',15,15),(51,15,1,54,3,60,'2020-03-06 14:01:46',1,NULL,1,1,'2020-03-06 14:02:22','2020-03-06 14:02:22',15,15),(52,15,1,54,3,60,'2020-03-06 14:01:46',1,NULL,1,1,'2020-03-06 14:02:22','2020-03-06 14:02:22',15,15),(53,15,1,54,3,60,'2020-03-06 14:01:46',1,NULL,1,1,'2020-03-06 14:02:22','2020-03-06 14:02:22',15,15),(54,15,1,54,5,212,'2020-03-06 14:04:54',3,NULL,1,1,'2020-03-06 14:04:55','2020-03-06 14:04:55',15,15),(55,15,1,54,3,59,'2020-03-06 14:04:48',1,NULL,1,1,'2020-03-06 14:04:55','2020-03-06 14:04:55',15,15),(56,7,1,2,1,100,'2020-03-06 14:16:57',1,NULL,2,1,'2020-03-06 14:17:11','2020-03-06 14:17:11',7,7),(57,7,1,2,2,200,'2020-03-06 14:16:57',3,NULL,2,1,'2020-03-06 14:17:11','2020-03-06 14:17:11',7,7),(58,7,1,2,3,100,'2020-03-04 14:16:57',3,NULL,2,1,'2020-03-06 14:17:11','2020-03-06 14:17:11',7,7),(59,7,1,2,1,100,'2020-03-06 14:16:57',1,NULL,2,1,'2020-03-06 14:17:30','2020-03-06 14:17:30',7,7),(60,7,1,2,2,200,'2020-03-06 14:16:57',3,NULL,2,1,'2020-03-06 14:17:30','2020-03-06 14:17:30',7,7),(61,7,1,2,3,100,'2020-03-06 14:16:57',3,NULL,2,1,'2020-03-06 14:17:30','2020-03-06 14:17:30',7,7),(62,7,1,2,1,50,'2020-03-06 14:17:16',3,NULL,2,1,'2020-03-06 14:17:30','2020-03-06 14:17:30',7,7),(63,7,1,2,2,50,'2020-03-06 14:17:16',3,NULL,2,1,'2020-03-06 14:17:30','2020-03-06 14:17:30',7,7),(64,7,1,2,3,50,'2020-03-06 14:17:16',2,NULL,2,1,'2020-03-06 14:17:30','2020-03-06 14:17:30',7,7),(65,7,1,2,1,100,'2020-03-06 14:16:57',1,NULL,2,1,'2020-03-06 14:18:25','2020-03-06 14:18:25',7,7),(66,7,1,2,2,200,'2020-03-06 14:16:57',3,NULL,2,1,'2020-03-06 14:18:25','2020-03-06 14:18:25',7,7),(67,7,1,2,3,100,'2020-03-06 14:16:57',3,NULL,2,1,'2020-03-06 14:18:25','2020-03-06 14:18:25',7,7),(68,7,1,2,1,50,'2020-03-06 14:17:16',3,NULL,2,1,'2020-03-06 14:18:25','2020-03-06 14:18:25',7,7),(69,7,1,2,2,50,'2020-03-06 14:17:16',3,NULL,2,1,'2020-03-06 14:18:25','2020-03-06 14:18:25',7,7),(70,7,1,2,3,50,'2020-03-06 14:17:16',2,NULL,2,1,'2020-03-06 14:18:25','2020-03-06 14:18:25',7,7),(71,7,1,6,5,98,'2020-03-06 14:18:11',3,NULL,2,1,'2020-03-06 14:18:25','2020-03-06 14:18:25',7,7),(72,7,1,6,3,100,'2020-03-06 14:18:11',3,NULL,2,1,'2020-03-06 14:18:25','2020-03-06 14:18:25',7,7),(73,7,1,2,1,300,'2020-03-06 14:21:43',3,NULL,2,1,'2020-03-06 14:21:57','2020-03-06 14:21:57',7,7),(74,7,1,2,2,200,'2020-03-06 14:21:43',3,NULL,2,1,'2020-03-06 14:21:57','2020-03-06 14:21:57',7,7),(75,7,1,2,3,400,'2020-03-06 14:21:43',3,NULL,2,1,'2020-03-06 14:21:57','2020-03-06 14:21:57',7,7),(76,7,1,2,1,100,'2020-03-06 16:18:24',1,NULL,2,1,'2020-03-06 16:18:37','2020-03-06 16:18:37',7,7),(77,7,1,2,2,200,'2020-03-06 16:18:24',3,NULL,2,1,'2020-03-06 16:18:37','2020-03-06 16:18:37',7,7),(78,7,1,2,3,50,'2020-03-06 16:18:24',2,NULL,2,1,'2020-03-06 16:18:37','2020-03-06 16:18:37',7,7),(79,7,1,2,1,100,'2020-03-06 16:18:24',1,NULL,2,1,'2020-03-06 16:18:49','2020-03-06 16:18:49',7,7),(80,7,1,2,2,200,'2020-03-06 16:18:24',3,NULL,2,1,'2020-03-06 16:18:49','2020-03-06 16:18:49',7,7),(81,7,1,2,3,50,'2020-03-06 16:18:24',2,NULL,2,1,'2020-03-06 16:18:49','2020-03-06 16:18:49',7,7),(82,7,1,2,1,60,'2020-03-06 16:18:36',3,NULL,2,1,'2020-03-06 16:18:49','2020-03-06 16:18:49',7,7),(83,7,1,2,2,40,'2020-03-06 16:18:36',3,NULL,2,1,'2020-03-06 16:18:49','2020-03-06 16:18:49',7,7),(84,7,1,2,3,30,'2020-03-06 16:18:36',3,NULL,2,1,'2020-03-06 16:18:49','2020-03-06 16:18:49',7,7),(85,7,1,2,1,100,'2020-03-06 16:18:24',1,NULL,2,1,'2020-03-06 16:19:07','2020-03-06 16:19:07',7,7),(86,7,1,2,2,200,'2020-03-06 16:18:24',3,NULL,2,1,'2020-03-06 16:19:07','2020-03-06 16:19:07',7,7),(87,7,1,2,3,50,'2020-03-06 16:18:24',2,NULL,2,1,'2020-03-06 16:19:07','2020-03-06 16:19:07',7,7),(88,7,1,2,1,60,'2020-03-06 16:18:36',3,NULL,2,1,'2020-03-06 16:19:07','2020-03-06 16:19:07',7,7),(89,7,1,2,2,40,'2020-03-06 16:18:36',3,NULL,2,1,'2020-03-06 16:19:07','2020-03-06 16:19:07',7,7),(90,7,1,2,3,30,'2020-03-06 16:18:36',3,NULL,2,1,'2020-03-06 16:19:07','2020-03-06 16:19:07',7,7),(91,7,1,2,1,700,'2020-03-06 16:18:54',3,NULL,2,1,'2020-03-06 16:19:07','2020-03-06 16:19:07',7,7),(92,7,1,2,2,600,'2020-03-06 16:18:54',3,NULL,2,1,'2020-03-06 16:19:07','2020-03-06 16:19:07',7,7),(93,7,1,2,3,200,'2020-03-06 16:18:54',3,NULL,2,1,'2020-03-06 16:19:07','2020-03-06 16:19:07',7,7),(94,1,1,18,5,98,'2020-03-06 12:28:03',2,NULL,2,1,'2020-03-06 16:28:09','2020-03-06 16:28:09',1,1),(95,1,1,18,3,80,'2020-03-06 12:28:03',3,NULL,2,1,'2020-03-06 16:28:09','2020-03-06 16:28:09',1,1),(96,1,1,18,5,100,'2020-03-06 12:28:39',3,NULL,2,1,'2020-03-06 16:28:44','2020-03-06 16:28:44',1,1),(97,1,1,18,3,90,'2020-03-06 12:28:39',3,NULL,2,1,'2020-03-06 16:28:44','2020-03-06 16:28:44',1,1),(98,1,1,18,5,97,'2020-03-06 12:29:16',2,NULL,2,1,'2020-03-06 16:29:21','2020-03-06 16:29:21',1,1),(99,1,1,18,3,90,'2020-03-06 12:29:16',3,NULL,2,1,'2020-03-06 16:29:21','2020-03-06 16:29:21',1,1),(100,1,1,18,5,90,'2020-03-06 12:32:06',2,NULL,2,1,'2020-03-06 16:32:12','2020-03-06 16:32:12',1,1),(101,1,1,18,3,70,'2020-03-06 12:32:06',3,NULL,2,1,'2020-03-06 16:32:12','2020-03-06 16:32:12',1,1),(102,1,1,18,5,97,'2020-03-06 12:38:46',2,NULL,2,1,'2020-03-06 16:38:52','2020-03-06 16:38:52',1,1),(103,1,1,18,3,90,'2020-03-06 12:38:46',3,NULL,2,1,'2020-03-06 16:38:52','2020-03-06 16:38:52',1,1),(104,1,1,18,5,70,'2020-03-06 12:53:09',1,NULL,2,1,'2020-03-06 16:53:22','2020-03-06 16:53:22',1,1),(105,1,1,18,3,90,'2020-03-06 12:53:09',3,NULL,2,1,'2020-03-06 16:53:22','2020-03-06 16:53:22',1,1),(106,1,1,18,5,70,'2020-03-06 13:22:18',1,NULL,2,1,'2020-03-06 17:22:24','2020-03-06 17:22:24',1,1),(107,1,1,18,3,70,'2020-03-06 13:22:18',3,NULL,2,1,'2020-03-06 17:22:24','2020-03-06 17:22:24',1,1),(108,1,1,18,5,100,'2020-03-06 13:22:32',3,NULL,2,1,'2020-03-06 17:22:37','2020-03-06 17:22:37',1,1),(109,1,1,18,3,90,'2020-03-06 13:22:32',3,NULL,2,1,'2020-03-06 17:22:37','2020-03-06 17:22:37',1,1),(110,7,1,2,1,500,'2020-03-06 17:22:31',3,NULL,2,1,'2020-03-06 17:22:44','2020-03-06 17:22:44',7,7),(111,7,1,2,2,600,'2020-03-06 17:22:31',3,NULL,2,1,'2020-03-06 17:22:44','2020-03-06 17:22:44',7,7),(112,7,1,2,3,40,'2020-03-06 17:22:31',3,NULL,2,1,'2020-03-06 17:22:44','2020-03-06 17:22:44',7,7),(113,1,1,18,5,100,'2020-03-06 13:22:57',3,NULL,2,1,'2020-03-06 17:23:02','2020-03-06 17:23:02',1,1),(114,1,1,18,3,80,'2020-03-06 13:22:57',3,NULL,2,1,'2020-03-06 17:23:02','2020-03-06 17:23:02',1,1),(115,1,1,18,5,70,'2020-03-06 13:23:20',1,NULL,2,1,'2020-03-06 17:23:25','2020-03-06 17:23:25',1,1),(116,1,1,18,3,100,'2020-03-06 13:23:20',3,NULL,2,1,'2020-03-06 17:23:25','2020-03-06 17:23:25',1,1),(117,1,1,18,5,97,'2020-03-06 13:33:42',2,NULL,2,1,'2020-03-06 17:33:48','2020-03-06 17:33:48',1,1),(118,1,1,18,3,80,'2020-03-06 13:33:42',3,NULL,2,1,'2020-03-06 17:33:48','2020-03-06 17:33:48',1,1),(119,1,1,18,5,100,'2020-03-06 13:37:53',3,NULL,2,1,'2020-03-06 17:37:59','2020-03-06 17:37:59',1,1),(120,1,1,18,3,120,'2020-03-06 13:37:53',3,NULL,2,1,'2020-03-06 17:37:59','2020-03-06 17:37:59',1,1),(121,1,1,18,5,30,'2020-03-06 13:41:43',3,NULL,2,1,'2020-03-06 17:41:49','2020-03-06 17:41:49',1,1),(122,1,1,18,3,40,'2020-03-06 13:41:43',3,NULL,2,1,'2020-03-06 17:41:49','2020-03-06 17:41:49',1,1),(123,1,1,18,4,70,'2020-03-06 13:41:59',2,NULL,2,1,'2020-03-06 17:42:04','2020-03-06 17:42:04',1,1),(124,1,1,18,1,130,'2020-03-06 13:42:22',1,NULL,2,1,'2020-03-06 17:42:27','2020-03-06 17:42:27',1,1),(125,1,1,18,2,120,'2020-03-06 13:42:22',3,NULL,2,1,'2020-03-06 17:42:27','2020-03-06 17:42:27',1,1),(126,1,1,18,3,100,'2020-03-06 13:42:22',3,NULL,2,1,'2020-03-06 17:42:27','2020-03-06 17:42:27',1,1),(127,1,1,18,1,140,'2020-03-06 13:43:25',2,NULL,2,1,'2020-03-06 17:43:30','2020-03-06 17:43:30',1,1),(128,1,1,18,2,100,'2020-03-06 13:43:25',2,NULL,2,1,'2020-03-06 17:43:30','2020-03-06 17:43:30',1,1),(129,1,1,18,3,80,'2020-03-06 13:43:25',3,NULL,2,1,'2020-03-06 17:43:30','2020-03-06 17:43:30',1,1),(130,1,1,18,4,70,'2020-03-06 13:43:47',2,NULL,2,1,'2020-03-06 17:43:52','2020-03-06 17:43:52',1,1),(131,1,1,18,4,90,'2020-03-06 13:43:55',3,NULL,2,1,'2020-03-06 17:44:00','2020-03-06 17:44:00',1,1),(132,1,1,18,1,150,'2020-03-06 13:44:11',3,NULL,2,1,'2020-03-06 17:44:16','2020-03-06 17:44:16',1,1),(133,1,1,18,2,130,'2020-03-06 13:44:11',3,NULL,2,1,'2020-03-06 17:44:16','2020-03-06 17:44:16',1,1),(134,1,1,18,3,100,'2020-03-06 13:44:11',3,NULL,2,1,'2020-03-06 17:44:16','2020-03-06 17:44:16',1,1),(135,1,1,18,1,150,'2020-03-06 13:45:10',3,NULL,2,1,'2020-03-06 17:45:16','2020-03-06 17:45:16',1,1),(136,1,1,18,2,120,'2020-03-06 13:45:10',3,NULL,2,1,'2020-03-06 17:45:16','2020-03-06 17:45:16',1,1),(137,1,1,18,3,10,'2020-03-06 13:45:10',3,NULL,2,1,'2020-03-06 17:45:16','2020-03-06 17:45:16',1,1),(138,1,1,18,1,90,'2020-03-06 13:48:15',2,NULL,2,1,'2020-03-06 17:48:21','2020-03-06 17:48:21',1,1),(139,1,1,18,2,90,'2020-03-06 13:48:15',1,NULL,2,1,'2020-03-06 17:48:21','2020-03-06 17:48:21',1,1),(140,1,1,18,3,90,'2020-03-06 13:48:15',3,NULL,2,1,'2020-03-06 17:48:21','2020-03-06 17:48:21',1,1),(141,1,1,18,5,800,'2020-03-06 13:48:42',3,NULL,2,1,'2020-03-06 17:48:47','2020-03-06 17:48:47',1,1),(142,1,1,18,3,800,'2020-03-06 13:48:42',3,NULL,2,1,'2020-03-06 17:48:47','2020-03-06 17:48:47',1,1),(143,1,1,18,1,90,'2020-03-06 13:51:03',2,NULL,2,1,'2020-03-06 17:51:41','2020-03-06 17:51:41',1,1),(144,1,1,18,2,120,'2020-03-06 13:51:03',3,NULL,2,1,'2020-03-06 17:51:41','2020-03-06 17:51:41',1,1),(145,1,1,18,3,130,'2020-03-06 13:51:03',3,NULL,2,1,'2020-03-06 17:51:41','2020-03-06 17:51:41',1,1),(146,1,1,18,1,50,'2020-03-06 14:06:07',3,NULL,2,1,'2020-03-06 18:06:13','2020-03-06 18:06:13',1,1),(147,1,1,18,2,50,'2020-03-06 14:06:07',3,NULL,2,1,'2020-03-06 18:06:13','2020-03-06 18:06:13',1,1),(148,1,1,18,3,50,'2020-03-06 14:06:07',2,NULL,2,1,'2020-03-06 18:06:13','2020-03-06 18:06:13',1,1),(149,1,1,19,5,212,'2020-03-06 07:21:14',3,NULL,1,1,'2020-03-07 07:21:32','2020-03-07 07:21:32',1,1),(150,1,1,19,3,83,'2020-03-06 07:20:59',3,NULL,1,1,'2020-03-07 07:21:32','2020-03-07 07:21:32',1,1),(151,1,1,16,1,122,'2020-03-06 07:23:13',1,NULL,1,1,'2020-03-07 07:24:02','2020-03-07 07:24:02',1,1),(152,1,1,19,1,122,'2020-03-06 07:21:40',1,NULL,1,1,'2020-03-07 07:24:02','2020-03-07 07:24:02',1,1),(153,1,1,19,2,91,'2020-03-06 07:21:40',1,NULL,1,1,'2020-03-07 07:24:02','2020-03-07 07:24:02',1,1),(154,1,1,16,2,91,'2020-03-06 07:23:13',1,NULL,1,1,'2020-03-07 07:24:02','2020-03-07 07:24:02',1,1),(155,1,1,19,3,82,'2020-03-06 07:21:40',3,NULL,1,1,'2020-03-07 07:24:02','2020-03-07 07:24:02',1,1),(156,1,1,16,3,82,'2020-03-06 07:23:13',3,NULL,1,1,'2020-03-07 07:24:02','2020-03-07 07:24:02',1,1),(157,1,1,19,1,122,'2020-03-06 07:21:20',1,NULL,1,1,'2020-03-07 07:24:02','2020-03-07 07:24:02',1,1),(158,1,1,19,2,91,'2020-03-06 07:21:20',1,NULL,1,1,'2020-03-07 07:24:02','2020-03-07 07:24:02',1,1),(159,1,1,19,3,82,'2020-03-06 07:21:20',3,NULL,1,1,'2020-03-07 07:24:02','2020-03-07 07:24:02',1,1),(160,1,1,16,4,80,'2020-03-06 07:25:01',3,NULL,2,1,'2020-03-07 07:25:18','2020-03-07 07:25:18',1,1),(161,1,1,16,4,120,'2020-03-06 07:44:50',3,NULL,2,1,'2020-03-07 07:45:08','2020-03-07 07:45:08',1,1),(162,1,1,16,4,80,'2020-03-06 07:45:56',3,NULL,2,1,'2020-03-07 07:46:13','2020-03-07 07:46:13',1,1),(163,1,1,16,4,90,'2020-03-06 07:47:25',3,NULL,2,1,'2020-03-07 07:47:46','2020-03-07 07:47:46',1,1),(164,1,1,16,4,95,'2020-03-06 07:48:17',3,NULL,2,1,'2020-03-07 07:48:38','2020-03-07 07:48:38',1,1),(165,1,1,16,4,70,'2020-03-06 07:49:51',2,NULL,2,1,'2020-03-07 07:50:12','2020-03-07 07:50:12',1,1),(166,1,1,16,4,60,'2020-03-06 07:50:03',1,NULL,2,1,'2020-03-07 07:50:21','2020-03-07 07:50:21',1,1),(167,1,1,16,4,75,'2020-03-06 07:50:15',2,NULL,2,1,'2020-03-07 07:50:32','2020-03-07 07:50:32',1,1),(168,1,1,16,5,90,'2020-03-06 07:52:09',2,NULL,2,1,'2020-03-07 07:52:27','2020-03-07 07:52:27',1,1),(169,1,1,16,3,80,'2020-03-06 07:52:09',3,NULL,2,1,'2020-03-07 07:52:27','2020-03-07 07:52:27',1,1),(170,1,1,16,4,120,'2020-03-06 07:52:27',3,NULL,2,1,'2020-03-07 07:52:44','2020-03-07 07:52:44',1,1),(171,1,1,16,1,90,'2020-03-06 07:52:52',2,NULL,2,1,'2020-03-07 07:53:09','2020-03-07 07:53:09',1,1),(172,1,1,16,2,80,'2020-03-06 07:52:52',1,NULL,2,1,'2020-03-07 07:53:09','2020-03-07 07:53:09',1,1),(173,1,1,16,3,100,'2020-03-06 07:52:52',3,NULL,2,1,'2020-03-07 07:53:09','2020-03-07 07:53:09',1,1),(174,1,1,19,1,120,'2020-03-06 11:27:52',1,NULL,2,1,'2020-03-07 11:31:34','2020-03-07 11:31:34',1,1),(175,1,1,19,2,80,'2020-03-06 11:27:52',1,NULL,2,1,'2020-03-07 11:31:34','2020-03-07 11:31:34',1,1),(176,1,1,19,3,90,'2020-03-06 11:27:52',3,NULL,2,1,'2020-03-07 11:31:34','2020-03-07 11:31:34',1,1),(177,1,1,19,1,90,'2020-03-06 11:32:49',2,NULL,2,1,'2020-03-07 11:33:13','2020-03-07 11:33:13',1,1),(178,1,1,19,2,80,'2020-03-06 11:32:49',1,NULL,2,1,'2020-03-07 11:33:13','2020-03-07 11:33:13',1,1),(179,1,1,19,3,70,'2020-03-06 11:32:49',3,NULL,2,1,'2020-03-07 11:33:13','2020-03-07 11:33:13',1,1),(180,1,1,19,6,90,'2020-03-06 11:34:05',1,NULL,2,1,'2020-03-07 11:34:34','2020-03-07 11:34:34',1,1),(181,1,1,19,3,90,'2020-03-06 11:35:38',3,NULL,2,1,'2020-03-07 11:35:56','2020-03-07 11:35:56',1,1),(182,1,1,19,1,120,'2020-03-06 11:38:08',1,NULL,2,1,'2020-03-07 11:39:18','2020-03-07 11:39:18',1,1),(183,1,1,19,2,100,'2020-03-06 11:38:08',2,NULL,2,1,'2020-03-07 11:39:18','2020-03-07 11:39:18',1,1),(184,1,1,19,3,90,'2020-03-06 11:38:08',3,NULL,2,1,'2020-03-07 11:39:18','2020-03-07 11:39:18',1,1),(185,1,1,19,5,90,'2020-03-06 11:39:20',2,NULL,2,1,'2020-03-07 11:39:37','2020-03-07 11:39:37',1,1),(186,1,1,19,3,90,'2020-03-06 11:39:20',3,NULL,2,1,'2020-03-07 11:39:37','2020-03-07 11:39:37',1,1),(187,1,1,19,4,120,'2020-03-06 12:02:42',3,NULL,2,1,'2020-03-07 12:03:00','2020-03-07 12:03:00',1,1),(188,1,1,19,4,130,'2020-03-06 12:03:01',3,NULL,2,1,'2020-03-07 12:03:18','2020-03-07 12:03:18',1,1),(189,1,1,19,5,100,'2020-03-06 13:14:23',3,NULL,2,1,'2020-03-07 13:14:41','2020-03-07 13:14:41',1,1),(190,1,1,19,3,90,'2020-03-06 13:14:23',3,NULL,2,1,'2020-03-07 13:14:41','2020-03-07 13:14:41',1,1),(191,1,1,19,3,80,'2020-03-06 13:14:53',3,NULL,2,1,'2020-03-07 13:15:10','2020-03-07 13:15:10',1,1),(192,1,1,19,1,125,'2020-03-06 13:18:24',1,NULL,2,1,'2020-03-07 13:18:42','2020-03-07 13:18:42',1,1),(193,1,1,19,2,120,'2020-03-06 13:18:24',3,NULL,2,1,'2020-03-07 13:18:42','2020-03-07 13:18:42',1,1),(194,1,1,19,3,30,'2020-03-06 13:18:24',3,NULL,2,1,'2020-03-07 13:18:42','2020-03-07 13:18:42',1,1),(195,1,1,19,4,50,'2020-03-06 13:47:02',1,NULL,2,1,'2020-03-07 13:47:44','2020-03-07 13:47:44',1,1),(196,1,1,19,1,125,'2020-03-07 13:58:46',1,NULL,2,1,'2020-03-08 13:59:02','2020-03-08 13:59:02',1,1),(197,1,1,19,2,120,'2020-03-07 13:58:46',3,NULL,2,1,'2020-03-08 13:59:02','2020-03-08 13:59:02',1,1),(198,1,1,19,3,90,'2020-03-07 13:58:46',3,NULL,2,1,'2020-03-08 13:59:02','2020-03-08 13:59:02',1,1),(199,1,1,19,1,130,'2020-03-07 13:59:14',1,NULL,2,1,'2020-03-08 13:59:29','2020-03-08 13:59:29',1,1),(200,1,1,19,2,110,'2020-03-07 13:59:14',3,NULL,2,1,'2020-03-08 13:59:29','2020-03-08 13:59:29',1,1),(201,1,1,19,3,90,'2020-03-07 13:59:14',3,NULL,2,1,'2020-03-08 13:59:29','2020-03-08 13:59:29',1,1),(202,1,1,19,4,90,'2020-03-07 14:15:44',3,NULL,2,1,'2020-03-08 14:16:02','2020-03-08 14:16:02',1,1),(203,1,1,19,4,90,'2020-03-08 16:34:25',3,NULL,2,1,'2020-03-09 16:34:40','2020-03-09 16:34:40',1,1),(205,7,1,6,5,100,'2020-03-13 05:32:51',3,NULL,2,1,'2020-03-13 05:33:13','2020-03-13 05:33:13',7,7),(206,7,1,6,3,90,'2020-03-13 05:32:51',3,NULL,2,1,'2020-03-13 05:33:13','2020-03-13 05:33:13',7,7),(213,7,1,2,1,80,'2020-03-13 05:54:24',3,NULL,2,1,'2020-03-13 05:54:26','2020-03-13 05:54:26',7,7),(214,7,1,2,2,120,'2020-03-13 05:54:24',3,NULL,2,1,'2020-03-13 05:54:26','2020-03-13 05:54:26',7,7),(215,7,1,2,3,90,'2020-03-13 05:54:24',3,NULL,2,1,'2020-03-13 05:54:26','2020-03-13 05:54:26',7,7),(216,7,1,6,5,10,'2020-03-13 05:57:57',3,NULL,2,1,'2020-03-13 05:57:59','2020-03-13 05:57:59',7,7),(217,7,1,6,3,95,'2020-03-13 05:57:57',3,NULL,2,1,'2020-03-13 05:57:59','2020-03-13 05:57:59',7,7),(218,7,1,27,1,80,'2020-03-13 06:27:51',3,NULL,2,1,'2020-03-13 06:28:28','2020-03-13 06:28:28',7,7),(219,7,1,27,2,120,'2020-03-13 06:27:51',3,NULL,2,1,'2020-03-13 06:28:28','2020-03-13 06:28:28',7,7),(220,7,1,27,3,99,'2020-03-13 06:27:51',3,NULL,2,1,'2020-03-13 06:28:28','2020-03-13 06:28:28',7,7),(221,7,1,28,4,85,'2020-03-13 07:21:28',3,NULL,2,1,'2020-03-13 07:22:04','2020-03-13 07:22:04',7,7),(222,7,1,28,4,85,'2020-03-13 07:21:28',3,NULL,2,1,'2020-03-13 07:23:18','2020-03-13 07:23:18',7,7),(223,7,1,29,5,50,'2020-03-13 07:22:43',1,NULL,2,1,'2020-03-13 07:23:18','2020-03-13 07:23:18',7,7),(224,7,1,29,3,99,'2020-03-13 07:22:43',3,NULL,2,1,'2020-03-13 07:23:18','2020-03-13 07:23:18',7,7),(225,28,1,87,5,60,'2020-03-13 07:44:41',1,NULL,2,1,'2020-03-13 07:45:17','2020-03-13 07:45:17',28,28),(226,28,1,87,3,90,'2020-03-13 07:44:41',3,NULL,2,1,'2020-03-13 07:45:17','2020-03-13 07:45:17',28,28),(227,7,1,27,1,100,'2020-03-13 11:22:32',1,NULL,2,1,'2020-03-13 11:22:48','2020-03-13 11:22:48',7,7),(228,7,1,27,2,65,'2020-03-13 11:22:32',1,NULL,2,1,'2020-03-13 11:22:48','2020-03-13 11:22:48',7,7),(229,7,1,27,3,72,'2020-03-13 11:22:32',1,NULL,2,1,'2020-03-13 11:22:48','2020-03-13 11:22:48',7,7),(230,1,1,16,3,72,'2020-03-13 12:06:47',3,NULL,2,1,'2020-03-13 12:07:02','2020-03-13 12:07:02',1,1),(231,1,1,16,3,75,'2020-03-13 12:07:25',3,NULL,2,1,'2020-03-13 12:07:38','2020-03-13 12:07:38',1,1),(232,7,1,27,1,120,'2020-03-13 13:57:00',1,NULL,2,1,'2020-03-13 13:57:37','2020-03-13 13:57:37',7,7),(233,7,1,27,2,100,'2020-03-13 13:57:00',2,NULL,2,1,'2020-03-13 13:57:37','2020-03-13 13:57:37',7,7),(234,7,1,27,3,90,'2020-03-13 13:57:00',3,NULL,2,1,'2020-03-13 13:57:37','2020-03-13 13:57:37',7,7),(235,7,1,27,1,100,'2020-03-13 14:48:29',1,NULL,2,1,'2020-03-13 14:49:05','2020-03-13 14:49:05',7,7),(236,7,1,27,2,90,'2020-03-13 14:48:29',1,NULL,2,1,'2020-03-13 14:49:05','2020-03-13 14:49:05',7,7),(237,7,1,27,3,80,'2020-03-13 14:48:29',2,NULL,2,1,'2020-03-13 14:49:05','2020-03-13 14:49:05',7,7),(238,7,1,27,1,100,'2020-03-13 14:48:29',1,NULL,2,1,'2020-03-13 14:49:47','2020-03-13 14:49:47',7,7),(239,7,1,27,2,90,'2020-03-13 14:48:29',1,NULL,2,1,'2020-03-13 14:49:47','2020-03-13 14:49:47',7,7),(240,7,1,27,3,80,'2020-03-13 14:48:29',2,NULL,2,1,'2020-03-13 14:49:47','2020-03-13 14:49:47',7,7),(241,7,1,28,4,70,'2020-03-13 14:49:11',3,NULL,2,1,'2020-03-13 14:49:47','2020-03-13 14:49:47',7,7),(242,7,1,29,5,100,'2020-03-13 16:52:44',3,NULL,2,1,'2020-03-13 16:53:20','2020-03-13 16:53:20',7,7),(243,7,1,29,3,50,'2020-03-13 16:52:44',2,NULL,2,1,'2020-03-13 16:53:20','2020-03-13 16:53:20',7,7),(244,30,26,94,1,120,'2020-03-14 00:28:33',1,NULL,2,1,'2020-03-14 00:31:07','2020-03-14 00:31:07',30,30),(245,30,26,94,2,80,'2020-03-14 00:28:33',1,NULL,2,1,'2020-03-14 00:31:07','2020-03-14 00:31:07',30,30),(246,30,26,94,3,80,'2020-03-14 00:28:33',1,NULL,2,1,'2020-03-14 00:31:07','2020-03-14 00:31:07',30,30),(247,30,26,94,1,120,'2020-03-14 00:28:33',1,NULL,2,1,'2020-03-14 00:32:15','2020-03-14 00:32:15',30,30),(248,30,26,94,2,80,'2020-03-14 00:28:33',1,NULL,2,1,'2020-03-14 00:32:15','2020-03-14 00:32:15',30,30),(249,30,26,94,3,80,'2020-03-14 00:28:33',1,NULL,2,1,'2020-03-14 00:32:15','2020-03-14 00:32:15',30,30),(250,30,26,96,5,93,'2020-03-14 00:29:40',1,NULL,2,1,'2020-03-14 00:32:15','2020-03-14 00:32:15',30,30),(251,30,26,96,3,90,'2020-03-14 00:29:40',1,NULL,2,1,'2020-03-14 00:32:15','2020-03-14 00:32:15',30,30),(252,30,26,94,1,120,'2020-03-14 00:30:40',1,NULL,2,1,'2020-03-14 00:33:14','2020-03-14 00:33:14',30,30),(253,30,26,94,2,80,'2020-03-14 00:30:40',1,NULL,2,1,'2020-03-14 00:33:14','2020-03-14 00:33:14',30,30),(254,30,26,94,3,80,'2020-03-14 00:30:40',1,NULL,2,1,'2020-03-14 00:33:14','2020-03-14 00:33:14',30,30),(255,28,1,88,1,120,'2020-03-16 04:48:32',1,NULL,2,1,'2020-03-16 04:48:34','2020-03-16 04:48:34',28,28),(256,28,1,88,2,80,'2020-03-16 04:48:32',1,NULL,2,1,'2020-03-16 04:48:34','2020-03-16 04:48:34',28,28),(257,28,1,88,3,90,'2020-03-16 04:48:32',3,NULL,2,1,'2020-03-16 04:48:34','2020-03-16 04:48:34',28,28),(258,28,1,88,1,120,'2020-03-16 04:48:32',1,NULL,2,1,'2020-03-16 04:48:59','2020-03-16 04:48:59',28,28),(259,28,1,88,2,80,'2020-03-16 04:48:32',1,NULL,2,1,'2020-03-16 04:48:59','2020-03-16 04:48:59',28,28),(260,28,1,88,3,90,'2020-03-16 04:48:32',3,NULL,2,1,'2020-03-16 04:48:59','2020-03-16 04:48:59',28,28),(261,28,1,88,1,80,'2020-03-16 04:48:58',3,NULL,2,1,'2020-03-16 04:48:59','2020-03-16 04:48:59',28,28),(262,28,1,88,2,120,'2020-03-16 04:48:58',3,NULL,2,1,'2020-03-16 04:48:59','2020-03-16 04:48:59',28,28),(263,28,1,88,3,90,'2020-03-16 04:48:58',3,NULL,2,1,'2020-03-16 04:48:59','2020-03-16 04:48:59',28,28),(264,28,1,86,4,100,'2020-03-16 04:51:49',3,NULL,2,1,'2020-03-16 04:51:50','2020-03-16 04:51:50',28,28),(265,7,1,27,1,100,'2020-03-16 05:22:04',1,NULL,2,1,'2020-03-16 05:22:45','2020-03-16 05:22:45',7,7),(266,7,1,27,2,500,'2020-03-16 05:22:04',3,NULL,2,1,'2020-03-16 05:22:45','2020-03-16 05:22:45',7,7),(267,7,1,27,3,400,'2020-03-16 05:22:04',3,NULL,2,1,'2020-03-16 05:22:45','2020-03-16 05:22:45',7,7),(268,28,1,86,4,100,'2020-03-16 05:29:12',3,NULL,2,1,'2020-03-16 05:29:51','2020-03-16 05:29:51',28,28),(269,28,1,86,4,100,'2020-03-16 06:02:19',3,NULL,2,1,'2020-03-16 06:02:58','2020-03-16 06:02:58',28,28),(270,1,1,19,5,212,'2020-03-16 07:00:21',3,NULL,1,1,'2020-03-16 07:00:32','2020-03-16 07:00:32',1,1),(271,1,1,19,3,90,'2020-03-16 07:00:00',3,NULL,1,1,'2020-03-16 07:00:32','2020-03-16 07:00:32',1,1),(272,28,1,86,4,50,'2020-03-16 07:40:57',2,NULL,2,1,'2020-03-16 07:41:37','2020-03-16 07:41:37',28,28),(273,28,1,86,4,19,'2020-03-16 07:46:25',3,NULL,2,1,'2020-03-16 07:47:05','2020-03-16 07:47:05',28,28);

/*Table structure for table `patientvitalsettings` */

DROP TABLE IF EXISTS `patientvitalsettings`;

CREATE TABLE `patientvitalsettings` (
  `patient_alert_setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `vital_id` int(11) DEFAULT NULL,
  `warning_min` double DEFAULT NULL,
  `warning_max` double DEFAULT NULL,
  `emergency_min` double DEFAULT NULL,
  `emergency_max` double DEFAULT NULL,
  `normal_min` double DEFAULT NULL,
  `normal_max` double DEFAULT NULL,
  `intervention_notes` varchar(1024) DEFAULT NULL,
  `measure_frequency` int(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`patient_alert_setting_id`),
  KEY `fk_userAlertSettings_userid_idx` (`patient_id`),
  KEY `fk_userAlertSettings_vitalid_idx` (`vital_id`),
  KEY `fk_patientAlertSettings_hospitalid_idx` (`hospital_id`),
  CONSTRAINT `fk_patientVitalSettings_hospitalid` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientVitalSettings_userid` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patientVitalSettings_vitalid` FOREIGN KEY (`vital_id`) REFERENCES `vitalmaster` (`vital_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=442 DEFAULT CHARSET=latin1 COMMENT='This table will store the alert settings for a user. Users can put in the minimum and maximum valid range for each vital and the alert/warning notifications would be triggered based on these values';

/*Data for the table `patientvitalsettings` */

insert  into `patientvitalsettings`(`patient_alert_setting_id`,`patient_id`,`vital_id`,`warning_min`,`warning_max`,`emergency_min`,`emergency_max`,`normal_min`,`normal_max`,`intervention_notes`,`measure_frequency`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`,`hospital_id`) values (209,4,1,140,120,180,140,80,120,'Notes',3,1,'2020-02-28 21:42:56','2020-02-28 21:42:56',37,37,26),(210,4,2,60,50,50,40,60,80,'Notes',3,1,'2020-02-28 21:42:56','2020-02-28 21:42:56',37,37,26),(241,1,1,90,140,80,150,110,130,'test',2,1,'2020-03-04 06:00:54','2020-03-04 06:00:54',5,5,1),(242,1,2,60,100,50,110,70,90,'test',2,1,'2020-03-04 06:00:54','2020-03-04 06:00:54',5,5,1),(243,1,3,50,65,45,70,55,60,'test',1,1,'2020-03-04 06:00:54','2020-03-04 06:00:54',5,5,1),(244,1,4,40,70,30,80,50,60,'test',3,1,'2020-03-04 06:00:54','2020-03-04 06:00:54',5,5,1),(245,1,5,50,90,40,100,60,80,'test',1,1,'2020-03-04 06:00:54','2020-03-04 06:00:54',5,5,1),(246,1,6,80,150,75,180,100,120,'test Glucose',1,1,'2020-03-04 06:00:54','2020-03-04 06:00:54',5,5,1),(262,6,1,90,140,80,150,110,130,'test',3,1,'2020-03-04 07:36:15','2020-03-04 07:36:15',5,5,1),(263,6,2,60,100,50,110,70,90,'test',3,1,'2020-03-04 07:36:15','2020-03-04 07:36:15',5,5,1),(264,6,3,50,65,45,70,55,60,'test',3,1,'2020-03-04 07:36:15','2020-03-04 07:36:15',5,5,1),(265,6,4,40,70,30,80,50,60,'test',3,1,'2020-03-04 07:36:15','2020-03-04 07:36:15',5,5,1),(266,6,5,40,70,30,80,50,60,'test SpO2',3,1,'2020-03-04 07:36:15','2020-03-04 07:36:15',5,5,1),(270,9,1,90,140,80,150,110,130,'test',3,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(271,9,2,NULL,NULL,NULL,NULL,NULL,NULL,'test',3,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(272,9,3,50,80,40,90,60,70,'test Pulse',3,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(273,9,4,50,65,45,70,55,60,'test Weight',3,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(274,9,5,40,70,30,80,50,60,'test SpO2',3,1,'2020-03-04 19:11:42','2020-03-04 19:11:42',5,5,1),(290,8,5,40,70,30,80,50,NULL,'test SpO2',3,1,'2020-03-06 11:39:29','2020-03-06 11:39:29',5,5,1),(291,10,1,90,140,80,150,110,130,'test',3,1,'2020-03-06 11:59:02','2020-03-06 11:59:02',5,5,1),(292,10,2,60,100,50,120,70,90,'test',3,1,'2020-03-06 11:59:02','2020-03-06 11:59:02',5,5,1),(293,10,3,50,80,40,90,60,70,'test Pulse',3,1,'2020-03-06 11:59:02','2020-03-06 11:59:02',5,5,1),(294,10,4,50,65,45,70,55,60,'test Weight',3,1,'2020-03-06 11:59:02','2020-03-06 11:59:02',5,5,1),(295,10,5,40,70,30,80,50,60,'test SpO2',3,1,'2020-03-06 11:59:02','2020-03-06 11:59:02',5,5,1),(296,11,1,90,140,80,150,110,130,'test',3,1,'2020-03-06 12:13:16','2020-03-06 12:13:16',5,5,1),(297,11,2,60,100,50,110,70,90,'test',3,1,'2020-03-06 12:13:16','2020-03-06 12:13:16',5,5,1),(298,11,3,50,80,40,90,60,70,'test Pulse',3,1,'2020-03-06 12:13:16','2020-03-06 12:13:16',5,5,1),(299,11,4,50,65,45,70,55,60,'test Weight',3,1,'2020-03-06 12:13:16','2020-03-06 12:13:16',5,5,1),(300,11,5,40,70,30,80,50,60,'test SpO2',2,1,'2020-03-06 12:13:16','2020-03-06 12:13:16',5,5,1),(301,12,1,90,140,80,150,110,130,'test',3,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(302,12,2,70,100,60,120,80,90,'test',3,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(303,12,3,50,80,40,90,60,70,'test Pulse',3,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(304,12,4,50,65,45,70,55,60,'test Weight',3,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(305,12,5,40,70,30,80,50,60,'test SpO2',3,1,'2020-03-06 12:21:38','2020-03-06 12:21:38',5,5,1),(306,13,1,90,140,80,150,110,130,'test',3,1,'2020-03-06 12:30:00','2020-03-06 12:30:00',5,5,1),(307,13,2,70,100,60,110,80,90,'test',3,1,'2020-03-06 12:30:00','2020-03-06 12:30:00',5,5,1),(308,13,3,50,80,40,90,60,70,'test Pulse',3,1,'2020-03-06 12:30:00','2020-03-06 12:30:00',5,5,1),(309,13,4,50,65,45,70,55,60,'test Weight',3,1,'2020-03-06 12:30:00','2020-03-06 12:30:00',5,5,1),(310,13,5,40,70,30,80,50,60,'test SpO2',3,1,'2020-03-06 12:30:00','2020-03-06 12:30:00',5,5,1),(311,14,1,90,140,80,150,110,130,'test',3,1,'2020-03-06 12:36:16','2020-03-06 12:36:16',5,5,1),(312,14,2,50,100,40,110,60,90,'test',3,1,'2020-03-06 12:36:16','2020-03-06 12:36:16',5,5,1),(313,14,3,50,80,40,90,60,70,'test Pulse',3,1,'2020-03-06 12:36:16','2020-03-06 12:36:16',5,5,1),(314,14,4,50,65,45,70,55,60,'test Weight',3,1,'2020-03-06 12:36:16','2020-03-06 12:36:16',5,5,1),(315,14,5,40,70,30,80,50,60,'test SpO2',3,1,'2020-03-06 12:36:16','2020-03-06 12:36:16',5,5,1),(324,15,1,90,140,80,150,110,130,'test',3,1,'2020-03-06 13:45:45','2020-03-06 13:45:45',10,10,1),(325,15,2,70,100,60,110,70,100,'test',3,1,'2020-03-06 13:45:45','2020-03-06 13:45:45',10,10,1),(326,15,3,50,80,40,90,50,80,'Test intervention notes',3,1,'2020-03-06 13:45:45','2020-03-06 13:45:45',10,10,1),(327,15,4,50,250,40,300,50,250,'',3,1,'2020-03-06 13:45:45','2020-03-06 13:45:45',10,10,1),(328,15,5,40,70,30,80,50,60,'test SpO2',3,1,'2020-03-06 13:45:45','2020-03-06 13:45:45',10,10,1),(333,2,1,90,140,80,150,110,130,'test',3,1,'2020-03-06 15:36:25','2020-03-06 15:36:25',10,10,1),(334,2,2,60,100,50,110,70,90,'test',3,1,'2020-03-06 15:36:25','2020-03-06 15:36:25',10,10,1),(335,2,4,40,70,30,80,50,60,'test',3,1,'2020-03-06 15:36:25','2020-03-06 15:36:25',10,10,1),(336,2,5,50,90,40,100,60,80,'test',2,1,'2020-03-06 15:36:25','2020-03-06 15:36:25',10,10,1),(339,16,1,140,120,200,140,80,120,'',3,1,'2020-03-10 03:36:59','2020-03-10 03:36:59',37,37,26),(340,16,2,60,50,50,40,60,80,'',3,1,'2020-03-10 03:36:59','2020-03-10 03:36:59',37,37,26),(341,3,1,120,140,140,180,80,120,'As soon as issue is found, please call up the Provider',3,1,'2020-03-10 04:17:28','2020-03-10 04:17:28',37,37,26),(342,3,2,50,60,40,50,60,80,'As soon as issue is found, please call up the Provider',3,1,'2020-03-10 04:17:28','2020-03-10 04:17:28',37,37,26),(352,17,1,90,140,80,150,110,130,'test',3,1,'2020-03-11 08:06:03','2020-03-11 08:06:03',5,5,1),(353,17,2,60,100,50,110,NULL,90,'test',3,1,'2020-03-11 08:06:03','2020-03-11 08:06:03',5,5,1),(354,17,3,50,80,40,90,60,70,'test Pulse',3,1,'2020-03-11 08:06:03','2020-03-11 08:06:03',5,5,1),(355,17,4,50,65,45,70,55,60,'test Weight',3,1,'2020-03-11 08:06:03','2020-03-11 08:06:03',5,5,1),(356,17,5,40,70,30,80,50,60,'test SpO2',3,1,'2020-03-11 08:06:03','2020-03-11 08:06:03',5,5,1),(362,7,1,90,140,80,150,110,130,'test',3,1,'2020-03-12 06:24:36','2020-03-12 06:24:36',5,5,1),(363,7,2,60,100,50,110,70,90,'test',3,1,'2020-03-12 06:24:36','2020-03-12 06:24:36',5,5,1),(364,7,3,50,80,40,90,60,70,'test Pulse',3,1,'2020-03-12 06:24:36','2020-03-12 06:24:36',5,5,1),(365,7,4,50,65,45,70,55,60,'test Weight',3,1,'2020-03-12 06:24:36','2020-03-12 06:24:36',5,5,1),(366,7,5,40,70,30,80,50,60,'test SpO2',3,1,'2020-03-12 06:24:36','2020-03-12 06:24:36',5,5,1),(413,28,1,90,140,80,150,110,130,'test',2,1,'2020-03-13 10:15:11','2020-03-13 10:15:11',5,5,1),(414,28,2,70,90,60,100,75,85,'test',2,1,'2020-03-13 10:15:11','2020-03-13 10:15:11',5,5,1),(415,28,3,50,80,40,90,60,70,'test Pulse',3,1,'2020-03-13 10:15:11','2020-03-13 10:15:11',5,5,1),(416,28,4,50,65,45,70,55,60,'test Weight',3,1,'2020-03-13 10:15:11','2020-03-13 10:15:11',5,5,1),(417,28,5,40,70,30,80,50,60,'test SpO2',3,1,'2020-03-13 10:15:11','2020-03-13 10:15:11',5,5,1),(418,29,1,90,140,80,150,110,130,'test',3,1,'2020-03-13 10:26:33','2020-03-13 10:26:33',5,5,1),(419,29,2,70,90,60,100,75,85,'test',3,1,'2020-03-13 10:26:33','2020-03-13 10:26:33',5,5,1),(420,29,3,50,80,40,90,60,70,'test Pulse',3,1,'2020-03-13 10:26:33','2020-03-13 10:26:33',5,5,1),(421,29,4,50,65,45,70,55,60,'test Weight',3,1,'2020-03-13 10:26:33','2020-03-13 10:26:33',5,5,1),(422,29,5,40,70,30,80,50,60,'test SpO2',3,1,'2020-03-13 10:26:33','2020-03-13 10:26:33',5,5,1),(428,18,1,140,120,200,140,80,120,'notes 1',2,1,'2020-03-13 20:12:44','2020-03-13 20:12:44',37,37,26),(429,18,2,60,50,50,40,60,80,'notes 1',2,1,'2020-03-13 20:12:44','2020-03-13 20:12:44',37,37,26),(430,18,3,120,180,180,220,60,100,'notes pulse',3,1,'2020-03-13 20:12:44','2020-03-13 20:12:44',37,37,26),(431,18,4,120,130,130,150,80,120,'wieght notes',1,1,'2020-03-13 20:12:44','2020-03-13 20:12:44',37,37,26),(432,18,5,85,95,50,85,95,100,'spo2 notes',NULL,1,'2020-03-13 20:12:44','2020-03-13 20:12:44',37,37,26),(437,30,1,79,121,40,170,80,120,'BP notes',3,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26),(438,30,2,59,81,49,120,60,80,'BP notes',3,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26),(439,30,3,49,91,30,130,50,90,'Pulse notes',2,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26),(440,30,4,90,300,70,400,100,200,'weight notes',1,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26),(441,30,5,85,98,70,99,90,97,'spo2 notes',1,1,'2020-03-13 23:58:44','2020-03-13 23:58:44',35,35,26);

/*Table structure for table `rolemaster` */

DROP TABLE IF EXISTS `rolemaster`;

CREATE TABLE `rolemaster` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(64) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `rolemaster` */

insert  into `rolemaster`(`role_id`,`role_name`,`is_admin`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`) values (1,'Admin',1,1,NULL,NULL,NULL,NULL),(2,'Doctor',1,1,NULL,NULL,NULL,NULL),(3,'Nurse',1,1,NULL,NULL,NULL,NULL),(4,'Billing',1,1,NULL,NULL,NULL,NULL);

/*Table structure for table `rolepermissions` */

DROP TABLE IF EXISTS `rolepermissions`;

CREATE TABLE `rolepermissions` (
  `role_permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `module_name` varchar(64) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`role_permission_id`),
  KEY `fk_rolePermissions_roleid_idx` (`role_id`),
  CONSTRAINT `fk_rolePermissions_roleid` FOREIGN KEY (`role_id`) REFERENCES `rolemaster` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `rolepermissions` */

insert  into `rolepermissions`(`role_permission_id`,`role_id`,`module_name`,`is_active`,`created_dttm`,`created_by`,`modified_dttm`,`modified_by`) values (1,1,'Dashboard',1,NULL,NULL,NULL,NULL),(2,1,'Inbox',1,NULL,NULL,NULL,NULL),(3,1,'Patient Management',1,NULL,NULL,NULL,NULL),(4,1,'Administration',1,NULL,NULL,NULL,NULL),(5,2,'Dashboard',1,NULL,NULL,NULL,NULL),(6,2,'Inbox',1,NULL,NULL,NULL,NULL),(7,2,'Patient Management',1,NULL,NULL,NULL,NULL),(8,3,'Dashboard',1,NULL,NULL,NULL,NULL),(9,3,'Inbox',1,NULL,NULL,NULL,NULL),(10,3,'Patient Management',1,NULL,NULL,NULL,NULL),(11,4,'Patient Management',1,NULL,NULL,NULL,NULL);

/*Table structure for table `vitalmaster` */

DROP TABLE IF EXISTS `vitalmaster`;

CREATE TABLE `vitalmaster` (
  `vital_id` int(11) NOT NULL AUTO_INCREMENT,
  `vital_name` varchar(64) DEFAULT NULL,
  `vital_desc` varchar(256) DEFAULT NULL,
  `vital_display_order` smallint(6) DEFAULT NULL COMMENT 'The app would show the vitals in this order on the app',
  `vital_min_default` double DEFAULT NULL COMMENT 'Default minimum value for triggering alert/warnings',
  `vital_max_default` double DEFAULT NULL COMMENT 'Default maximum value for triggering alert/warnings',
  `vital_unit` varchar(64) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL,
  `modified_dttm` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`vital_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='This is a master table with all the vitals available in the HealthNode platform.';

/*Data for the table `vitalmaster` */

insert  into `vitalmaster`(`vital_id`,`vital_name`,`vital_desc`,`vital_display_order`,`vital_min_default`,`vital_max_default`,`vital_unit`,`is_active`,`created_dttm`,`modified_dttm`,`created_by`,`modified_by`) values (1,'Blood Pressure','Blood Pressure systolic',1,30,260,'mmHG',1,'2020-02-28 12:44:55','2020-02-28 12:44:55',0,0),(2,'Blood Pressure','Blood Pressure diastolic',2,30,260,'mmHG',1,'2020-02-28 12:44:55','2020-02-28 12:44:55',0,0),(3,'Pulse','Pulse',3,18,321,'bpm',1,'2020-02-28 12:44:55','2020-02-28 12:44:55',0,0),(4,'Weight','Weight',4,10,700,'Lbs ',1,'2020-02-28 12:44:55','2020-02-28 12:44:55',0,0),(5,'SpO2','SpO2',5,0,100,'%',1,'2020-02-28 12:44:55','2020-02-28 12:44:55',0,0),(6,'Glucose','Glucose',6,10,300,'mg/dL',1,'2020-02-28 12:44:55','2020-02-28 12:44:55',0,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
