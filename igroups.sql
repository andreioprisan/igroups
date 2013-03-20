# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 205.186.140.227 (MySQL 5.1.52)
# Database: ig_vbx_dev
# Generation Time: 2012-02-01 13:07:50 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table annotation_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `annotation_types`;

CREATE TABLE `annotation_types` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `description` varchar(32) NOT NULL,
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `annotation_types_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `annotation_types` WRITE;
/*!40000 ALTER TABLE `annotation_types` DISABLE KEYS */;

INSERT INTO `annotation_types` (`id`, `description`, `tenant_id`)
VALUES
	(1,'called',1),
	(2,'read',1),
	(3,'noted',1),
	(4,'changed',1),
	(5,'labeled',1),
	(6,'sms',1);

/*!40000 ALTER TABLE `annotation_types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table annotations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `annotations`;

CREATE TABLE `annotations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `annotation_type` tinyint(4) NOT NULL,
  `message_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `annotation_type_message_id` (`annotation_type`,`message_id`,`created`),
  KEY `created` (`created`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `annotations_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `annotations` WRITE;
/*!40000 ALTER TABLE `annotations` DISABLE KEYS */;

INSERT INTO `annotations` (`id`, `annotation_type`, `message_id`, `user_id`, `description`, `created`, `tenant_id`)
VALUES
	(1,4,3,1,'Set ticket status to closed','2012-01-09 06:23:19',1),
	(2,4,4,1,'Set ticket status to pending','2012-01-09 20:49:21',1),
	(3,4,4,1,'Set ticket status to pending','2012-01-09 22:38:15',1),
	(4,4,4,1,'Set ticket status to open','2012-01-09 22:38:30',1),
	(5,4,4,1,'Set ticket status to pending','2012-01-09 23:07:40',1),
	(6,4,3,1,'Set ticket status to pending','2012-01-09 23:07:58',1);

/*!40000 ALTER TABLE `annotations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table audio_files
# ------------------------------------------------------------

DROP TABLE IF EXISTS `audio_files`;

CREATE TABLE `audio_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `recording_call_sid` varchar(100) DEFAULT NULL,
  `tag` varchar(100) DEFAULT NULL,
  `cancelled` tinyint(4) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `url` (`url`),
  KEY `recording_call_sid` (`recording_call_sid`),
  KEY `tag` (`tag`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `audio_files_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table auth_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_types`;

CREATE TABLE `auth_types` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `auth_types_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `auth_types` WRITE;
/*!40000 ALTER TABLE `auth_types` DISABLE KEYS */;

INSERT INTO `auth_types` (`id`, `description`, `tenant_id`)
VALUES
	(1,'openvbx',1),
	(2,'google',1);

/*!40000 ALTER TABLE `auth_types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table billing_cards
# ------------------------------------------------------------

DROP TABLE IF EXISTS `billing_cards`;

CREATE TABLE `billing_cards` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `stripeCustomerID` varchar(25) DEFAULT NULL,
  `address_line1` varchar(100) DEFAULT NULL,
  `address_zip` varchar(12) DEFAULT NULL,
  `country` varchar(5) NOT NULL DEFAULT 'US',
  `exp_month` varchar(2) DEFAULT NULL,
  `exp_year` varchar(4) DEFAULT NULL,
  `last4` varchar(4) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `address_line1_check` tinyint(1) NOT NULL DEFAULT '0',
  `address_zip_check` tinyint(1) NOT NULL DEFAULT '0',
  `cvc_check` tinyint(1) NOT NULL DEFAULT '0',
  `created` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


# Dump of table billing_charges
# ------------------------------------------------------------

DROP TABLE IF EXISTS `billing_charges`;

CREATE TABLE `billing_charges` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `stripeChargeID` varchar(25) DEFAULT NULL,
  `stripeCustomerID` varchar(25) DEFAULT NULL,
  `currency` varchar(5) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `fee` int(11) DEFAULT NULL,
  `net` int(11) DEFAULT NULL,
  `live` tinyint(1) NOT NULL DEFAULT '0',
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `refunded` tinyint(1) NOT NULL DEFAULT '0',
  `created` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


# Dump of table billing_customers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `billing_customers`;

CREATE TABLE `billing_customers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) DEFAULT NULL,
  `stripeCustomerID` varchar(25) DEFAULT NULL,
  `cardID` int(11) DEFAULT NULL,
  `livemode` tinyint(1) DEFAULT NULL,
  `created` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dump of table cache
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL DEFAULT '',
  `group` varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `tenant_id` int(11) NOT NULL,
  PRIMARY KEY (`key`(80),`group`(80),`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;

INSERT INTO `cache` (`key`, `group`, `value`, `tenant_id`)
VALUES
	('account-type','VBX_Accounts','a:2:{s:4:\"data\";s:4:\"Full\";s:7:\"expires\";i:1328079695;}',1),
	('countries','VBX_Incoming_numbers','a:2:{s:4:\"data\";a:19:{s:2:\"AT\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"AT\";s:7:\"country\";s:7:\"Austria\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/AT.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/AT/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/AT/TollFree.json\";}s:4:\"code\";s:2:\"43\";s:6:\"search\";s:7:\"+43 (*)\";}s:2:\"BE\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"BE\";s:7:\"country\";s:7:\"Belgium\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/BE.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/BE/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/BE/TollFree.json\";}s:4:\"code\";s:2:\"32\";s:6:\"search\";s:7:\"+32 (*)\";}s:2:\"BG\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"BG\";s:7:\"country\";s:8:\"Bulgaria\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/BG.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/BG/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/BG/TollFree.json\";}s:4:\"code\";s:3:\"359\";s:6:\"search\";s:8:\"+359 (*)\";}s:2:\"CA\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"CA\";s:7:\"country\";s:6:\"Canada\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/CA.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/CA/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/CA/TollFree.json\";}s:4:\"code\";s:1:\"1\";s:6:\"search\";s:6:\"+1 (*)\";}s:2:\"CH\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"CH\";s:7:\"country\";s:11:\"Switzerland\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/CH.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/CH/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/CH/TollFree.json\";}s:4:\"code\";s:2:\"41\";s:6:\"search\";s:7:\"+41 (*)\";}s:2:\"CZ\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"CZ\";s:7:\"country\";s:14:\"Czech Republic\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/CZ.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/CZ/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/CZ/TollFree.json\";}s:4:\"code\";s:3:\"420\";s:6:\"search\";s:8:\"+420 (*)\";}s:2:\"DK\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"DK\";s:7:\"country\";s:7:\"Denmark\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/DK.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/DK/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/DK/TollFree.json\";}s:4:\"code\";s:2:\"45\";s:6:\"search\";s:7:\"+45 (*)\";}s:2:\"FI\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"FI\";s:7:\"country\";s:7:\"Finland\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/FI.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/FI/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/FI/TollFree.json\";}s:4:\"code\";s:3:\"358\";s:6:\"search\";s:8:\"+358 (*)\";}s:2:\"FR\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"FR\";s:7:\"country\";s:6:\"France\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/FR.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/FR/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/FR/TollFree.json\";}s:4:\"code\";s:2:\"33\";s:6:\"search\";s:7:\"+33 (*)\";}s:2:\"GB\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"GB\";s:7:\"country\";s:14:\"United Kingdom\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/GB.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/GB/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/GB/TollFree.json\";}s:4:\"code\";s:2:\"44\";s:6:\"search\";s:7:\"+44 (*)\";}s:2:\"GR\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"GR\";s:7:\"country\";s:6:\"Greece\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/GR.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/GR/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/GR/TollFree.json\";}s:4:\"code\";s:2:\"30\";s:6:\"search\";s:7:\"+30 (*)\";}s:2:\"HU\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"HU\";s:7:\"country\";s:7:\"Hungary\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/HU.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/HU/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/HU/TollFree.json\";}s:4:\"code\";s:2:\"36\";s:6:\"search\";s:7:\"+36 (*)\";}s:2:\"IE\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"IE\";s:7:\"country\";s:7:\"Ireland\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/IE.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/IE/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/IE/TollFree.json\";}s:4:\"code\";s:3:\"353\";s:6:\"search\";s:8:\"+353 (*)\";}s:2:\"IT\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"IT\";s:7:\"country\";s:5:\"Italy\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/IT.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/IT/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/IT/TollFree.json\";}s:4:\"code\";s:2:\"39\";s:6:\"search\";s:7:\"+39 (*)\";}s:2:\"PL\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"PL\";s:7:\"country\";s:6:\"Poland\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/PL.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/PL/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/PL/TollFree.json\";}s:4:\"code\";s:2:\"48\";s:6:\"search\";s:7:\"+48 (*)\";}s:2:\"PT\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"PT\";s:7:\"country\";s:8:\"Portugal\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/PT.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/PT/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/PT/TollFree.json\";}s:4:\"code\";s:3:\"351\";s:6:\"search\";s:8:\"+351 (*)\";}s:2:\"RO\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"RO\";s:7:\"country\";s:7:\"Romania\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/RO.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/RO/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/RO/TollFree.json\";}s:4:\"code\";s:2:\"40\";s:6:\"search\";s:7:\"+40 (*)\";}s:2:\"SE\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"SE\";s:7:\"country\";s:6:\"Sweden\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/SE.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/SE/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/SE/TollFree.json\";}s:4:\"code\";s:2:\"46\";s:6:\"search\";s:7:\"+46 (*)\";}s:2:\"US\";O:8:\"stdClass\":6:{s:12:\"country_code\";s:2:\"US\";s:7:\"country\";s:13:\"United States\";s:3:\"uri\";s:85:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/US.json\";s:16:\"subresource_uris\";O:8:\"stdClass\":2:{s:5:\"local\";s:91:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/US/Local.json\";s:9:\"toll_free\";s:94:\"/2010-04-01/Accounts/replaceme/AvailablePhoneNumbers/US/TollFree.json\";}s:4:\"code\";s:1:\"1\";s:6:\"search\";s:6:\"+1 (*)\";}}s:7:\"expires\";i:1326646830;}',1),
	('incoming-numbers','VBX_Incoming_numbers','a:2:{s:4:\"data\";a:16:{i:0;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PN43f4dccd522d4a39b5630fc4951cdc80\";s:4:\"name\";s:14:\"(617) 396-7613\";s:5:\"phone\";s:14:\"(617) 396-7613\";s:12:\"phone_number\";s:12:\"+16173967613\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://igrou.ps.dev/twiml/start/voice/0\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:38:\"https://igrou.ps.dev/twiml/start/sms/0\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}i:1;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PNbbd3acc9787a49dea532010e2b865898\";s:4:\"name\";s:14:\"(617) 600-7512\";s:5:\"phone\";s:14:\"(617) 600-7512\";s:12:\"phone_number\";s:12:\"+16176007512\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://igrou.ps.dev/twiml/start/voice/0\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:38:\"https://igrou.ps.dev/twiml/start/sms/0\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}i:2;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PN27ec81a751c64a3c99a3e3592c9a73fa\";s:4:\"name\";s:14:\"(617) 945-8127\";s:5:\"phone\";s:14:\"(617) 945-8127\";s:12:\"phone_number\";s:12:\"+16179458127\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://igrou.ps.dev/twiml/start/voice/0\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:38:\"https://igrou.ps.dev/twiml/start/sms/0\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}i:3;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PN84907ad3cf7f40f9a7011ce0557fb44b\";s:4:\"name\";s:14:\"(617) 945-8028\";s:5:\"phone\";s:14:\"(617) 945-8028\";s:12:\"phone_number\";s:12:\"+16179458028\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://igrou.ps.dev/twiml/start/voice/0\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:38:\"https://igrou.ps.dev/twiml/start/sms/0\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}i:4;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PNf842e99143e940ee80360766fa0184bd\";s:4:\"name\";s:14:\"(617) 600-6730\";s:5:\"phone\";s:14:\"(617) 600-6730\";s:12:\"phone_number\";s:12:\"+16176006730\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://igrou.ps.dev/twiml/start/voice/0\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:38:\"https://igrou.ps.dev/twiml/start/sms/0\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}i:5;O:8:\"stdClass\":14:{s:7:\"flow_id\";i:7;s:2:\"id\";s:34:\"PN0046264bc46a4dc981b8d6e14cb27bcd\";s:4:\"name\";s:14:\"(888) 420-0006\";s:5:\"phone\";s:14:\"(888) 420-0006\";s:12:\"phone_number\";s:12:\"+18884200006\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:43:\"https://athena.igrou.ps/twiml/start/voice/7\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:0:\"\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:0;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:1;}i:6;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PNef6ffff55639413b8a2a7e34353356ea\";s:4:\"name\";s:14:\"(617) 446-3108\";s:5:\"phone\";s:14:\"(617) 446-3108\";s:12:\"phone_number\";s:12:\"+16174463108\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://igrou.ps.dev/twiml/start/voice/8\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:38:\"https://igrou.ps.dev/twiml/start/sms/8\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}i:7;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PN2a08080d860e487a9fe4de139f168647\";s:4:\"name\";s:14:\"(617) 379-6721\";s:5:\"phone\";s:14:\"(617) 379-6721\";s:12:\"phone_number\";s:12:\"+16173796721\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://igrou.ps.dev/twiml/start/voice/0\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:38:\"https://igrou.ps.dev/twiml/start/sms/0\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}i:8;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PN675a402563fa421b87af68dcfbe3dccb\";s:4:\"name\";s:14:\"(866) 576-2227\";s:5:\"phone\";s:14:\"(866) 576-2227\";s:12:\"phone_number\";s:12:\"+18665762227\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://igrou.ps.dev/twiml/start/voice/0\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:38:\"https://igrou.ps.dev/twiml/start/sms/0\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:0;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}i:9;O:8:\"stdClass\":14:{s:7:\"flow_id\";i:7;s:2:\"id\";s:34:\"PN38bdb1c1490e4f0781d6c5f23139ce61\";s:4:\"name\";s:14:\"(617) 500-0773\";s:5:\"phone\";s:14:\"(617) 500-0773\";s:12:\"phone_number\";s:12:\"+16175000773\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:43:\"https://athena.igrou.ps/twiml/start/voice/7\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:33:\"https://athena.igrou.ps/twiml/sms\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:1;}i:10;O:8:\"stdClass\":14:{s:7:\"flow_id\";i:7;s:2:\"id\";s:34:\"PN688a877e214b45a8a4ebf428ea3cd931\";s:4:\"name\";s:14:\"(617) 500-0771\";s:5:\"phone\";s:14:\"(617) 500-0771\";s:12:\"phone_number\";s:12:\"+16175000771\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:43:\"https://athena.igrou.ps/twiml/start/voice/7\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:33:\"https://athena.igrou.ps/twiml/sms\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:1;}i:11;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PNed1a403b39de4d76ae5f29d607b5fc81\";s:4:\"name\";s:14:\"(646) 480-6976\";s:5:\"phone\";s:14:\"(646) 480-6976\";s:12:\"phone_number\";s:12:\"+16464806976\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://www.igrou.ps/twiml/start/voice/7\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:38:\"https://www.igrou.ps/twiml/start/sms/7\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}i:12;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PNebef0a5e46994b54a929c1f6c6d7350b\";s:4:\"name\";s:14:\"(866) 786-1478\";s:5:\"phone\";s:14:\"(866) 786-1478\";s:12:\"phone_number\";s:12:\"+18667861478\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://www.igrou.ps/twiml/start/voice/7\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:0:\"\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:0;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}i:13;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PN286247cdc3ee43abbd76ab5aa1d03277\";s:4:\"name\";s:14:\"(617) 418-1670\";s:5:\"phone\";s:14:\"(617) 418-1670\";s:12:\"phone_number\";s:12:\"+16174181670\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://www.igrou.ps/twiml/start/voice/7\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:38:\"https://www.igrou.ps/twiml/start/sms/7\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}i:14;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PN487084bfdc404124a1a79af66f5ac552\";s:4:\"name\";s:14:\"(850) 937-7131\";s:5:\"phone\";s:14:\"(850) 937-7131\";s:12:\"phone_number\";s:12:\"+18509377131\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://www.igrou.ps/twiml/start/voice/7\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:38:\"https://www.igrou.ps/twiml/start/sms/7\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}i:15;O:8:\"stdClass\":14:{s:7:\"flow_id\";N;s:2:\"id\";s:34:\"PNd9834097adb4426caf7f93d22aa40fb4\";s:4:\"name\";s:14:\"(661) 347-2844\";s:5:\"phone\";s:14:\"(661) 347-2844\";s:12:\"phone_number\";s:12:\"+16613472844\";s:3:\"pin\";N;s:7:\"sandbox\";b:0;s:3:\"url\";s:40:\"https://www.igrou.ps/twiml/start/voice/7\";s:6:\"method\";s:4:\"POST\";s:6:\"smsUrl\";s:38:\"https://www.igrou.ps/twiml/start/sms/7\";s:9:\"smsMethod\";s:4:\"POST\";s:12:\"capabilities\";O:8:\"stdClass\":2:{s:5:\"voice\";b:1;s:3:\"sms\";b:1;}s:19:\"voiceApplicationSid\";s:0:\"\";s:9:\"installed\";b:0;}}s:7:\"expires\";i:1328066144;}',1);

/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table charges
# ------------------------------------------------------------

DROP TABLE IF EXISTS `charges`;

CREATE TABLE `charges` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) DEFAULT NULL,
  `chargeType` enum('debit','credit') DEFAULT NULL,
  `itemType` enum('voicecall','sms','localnumber','tollfreenumber','transcription','voicemail','creditcard') DEFAULT NULL,
  `itemReference` varchar(150) DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dump of table flow_store
# ------------------------------------------------------------

DROP TABLE IF EXISTS `flow_store`;

CREATE TABLE `flow_store` (
  `key` varchar(255) NOT NULL,
  `value` text,
  `flow_id` int(11) NOT NULL,
  `tenant_id` bigint(20) NOT NULL,
  UNIQUE KEY `key_flow` (`key`,`flow_id`),
  KEY `key` (`key`,`flow_id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `flow_store_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table flows
# ------------------------------------------------------------

DROP TABLE IF EXISTS `flows`;

CREATE TABLE `flows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `data` text,
  `sms_data` text,
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`tenant_id`),
  KEY `user_id` (`user_id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `flows_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `flows_ibfk_2` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `flows` WRITE;
/*!40000 ALTER TABLE `flows` DISABLE KEYS */;

INSERT INTO `flows` (`id`, `name`, `user_id`, `created`, `updated`, `data`, `sms_data`, `tenant_id`)
VALUES
	(6,'sms flow 1',1,NULL,NULL,'{\"start\":{\"name\":\"Call Start\",\"data\":{\"next\":\"start/72d801\"},\"id\":\"start\",\"type\":\"standard---start\"},\"72d801\":{\"name\":\"Menu\",\"data\":{\"prompt_say\":\"asdfasdfas dfas dasdf\",\"prompt_play\":\"\",\"prompt_mode\":\"say\",\"prompt_tag\":\"global\",\"prompt_caller_id\":\"+16174181670\",\"number\":[\"1\",\"1\"],\"library\":[\"\",\"\"],\"keys[]\":[\"1\",\"2\",\"3\",\"4\"],\"choices[]\":[\"start/72d801/295c9e\",\"start/72d801/addb1e\",\"start/72d801/89cd45\",\"start/72d801/c7280e\"],\"repeat-count\":\"4\",\"next\":\"\",\"invalid-option_say\":\"\",\"invalid-option_play\":\"\",\"invalid-option_mode\":\"\",\"invalid-option_tag\":\"global\",\"invalid-option_caller_id\":\"+16174181670\"},\"id\":\"72d801\",\"type\":\"menu---menu\"},\"addb1e\":{\"name\":\"Google Analytics\",\"data\":{\"account\":\"\",\"url\":\"\",\"title\":\"\",\"next\":\"\"},\"id\":\"addb1e\",\"type\":\"googleanalyticstracker---track\"},\"295c9e\":{\"name\":\"Conference\",\"data\":{\"moderator_id\":\"2\",\"moderator_type\":\"group\",\"wait-url\":\"http://twimlets.com/holdmusic?Bucket=com.twilio.music.classical\",\"conf-id\":\"conf_4f0a4c97e64c5\"},\"id\":\"295c9e\",\"type\":\"standard---conference\"},\"89cd45\":{\"name\":\"New Text\",\"data\":{\"number\":\"(850) 937-7131\",\"recipient\":\"\",\"sms\":\"Use %caller% to substitute the caller\'s number or %number% for the number called\",\"next\":\"start/72d801/89cd45/c253fe\"},\"id\":\"89cd45\",\"type\":\"outbound---text\"},\"c253fe\":{\"name\":\"New Call\",\"data\":{\"number\":\"(850) 937-7131\",\"flow\":\"6\",\"recipient\":\"2110001111\",\"next\":\"\"},\"id\":\"c253fe\",\"type\":\"outbound---call\"},\"c7280e\":{\"name\":\"Voicemail\",\"data\":{\"prompt_say\":\"\",\"prompt_play\":\"\",\"prompt_mode\":\"\",\"prompt_tag\":\"global\",\"prompt_caller_id\":\"+16174181670\",\"number\":\"1\",\"library\":\"\",\"permissions_id\":\"1\",\"permissions_type\":\"group\"},\"id\":\"c7280e\",\"type\":\"standard---voicemail\"}}','{\"start\":{\"name\":\"Message Received\",\"data\":{\"next\":\"start/4f47f2\"},\"id\":\"start\",\"type\":\"standard---start\"},\"4f47f2\":{\"name\":\"Timing\",\"data\":{\"range_0_from\":\"\",\"range_0_to\":\"\",\"range_1_from\":\"\",\"range_1_to\":\"\",\"range_2_from\":\"\",\"range_2_to\":\"\",\"range_3_from\":\"\",\"range_3_to\":\"\",\"range_4_from\":\"\",\"range_4_to\":\"\",\"range_5_from\":\"\",\"range_5_to\":\"\",\"range_6_from\":\"\",\"range_6_to\":\"\",\"open\":\"\",\"closed\":\"\"},\"id\":\"4f47f2\",\"type\":\"timing---timing\"}}',1),
	(7,'Flow #2',1,NULL,NULL,'{\"start\":{\"name\":\"Call Start\",\"data\":{\"next\":\"start/727561\"},\"id\":\"start\",\"type\":\"standard---start\"},\"727561\":{\"name\":\"Menu\",\"data\":{\"prompt_say\":\"Thank you for calling iGroups, incorporated. For Sales, press 1. For Technical Support, press 2. For General Inquiries, press 3. For Legal, Press 4. For Payments, press 5. For immediate assistance, press 0, and the next available representative will be right with you. Thank you!\",\"prompt_play\":\"\",\"prompt_mode\":\"say\",\"prompt_tag\":\"global\",\"prompt_caller_id\":\"+18884200006\",\"number\":[\"(212) 300-5446\",\"(212) 300-5446\"],\"library\":[\"\",\"\"],\"keys[]\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"0\",\"20\"],\"choices[]\":[\"start/727561/a662c5\",\"start/727561/a5bb9a\",\"start/727561/15b392\",\"start/727561/215134\",\"start/727561/9f17ac\",\"start/727561/92f08a\",\"start/727561/30a972\"],\"repeat-count\":\"3\",\"next\":\"start/727561/2ccc5f\",\"invalid-option_say\":\"We are sorry, but we could not recognize your entry. Please try again.\",\"invalid-option_play\":\"\",\"invalid-option_mode\":\"say\",\"invalid-option_tag\":\"global\",\"invalid-option_caller_id\":\"+18884200006\"},\"id\":\"727561\",\"type\":\"menu---menu\"},\"2ccc5f\":{\"name\":\"Voicemail\",\"data\":{\"prompt_say\":\"Leave a voicemail!\",\"prompt_play\":\"\",\"prompt_mode\":\"say\",\"prompt_tag\":\"global\",\"prompt_caller_id\":\"+18884200006\",\"number\":\"(212) 300-5446\",\"library\":\"\",\"permissions_id\":\"1\",\"permissions_type\":\"user\"},\"id\":\"2ccc5f\",\"type\":\"standard---voicemail\"},\"a662c5\":{\"name\":\"Dial\",\"data\":{\"dial-whom-selector\":\"user-or-group\",\"dial-whom-user-or-group_id\":\"1\",\"dial-whom-user-or-group_type\":\"group\",\"dial-whom-number\":\"\",\"callerId\":\"+18884200006\",\"no-answer-action\":\"voicemail\",\"no-answer-group-voicemail_say\":\"Please leave a voicemail for the Sales Group after the tone. Thank you.\",\"no-answer-group-voicemail_play\":\"\",\"no-answer-group-voicemail_mode\":\"say\",\"no-answer-group-voicemail_tag\":\"global\",\"no-answer-group-voicemail_caller_id\":\"+18884200006\",\"number\":\"(212) 300-5446\",\"library\":\"\",\"no-answer-redirect\":\"\",\"no-answer-redirect-number\":\"\",\"version\":\"3\"},\"id\":\"a662c5\",\"type\":\"standard---dial\"},\"a5bb9a\":{\"name\":\"Dial\",\"data\":{\"dial-whom-selector\":\"user-or-group\",\"dial-whom-user-or-group_id\":\"2\",\"dial-whom-user-or-group_type\":\"group\",\"dial-whom-number\":\"\",\"callerId\":\"\",\"no-answer-action\":\"voicemail\",\"no-answer-group-voicemail_say\":\"Please leave us a voicemail after the tone. Thank you.\",\"no-answer-group-voicemail_play\":\"\",\"no-answer-group-voicemail_mode\":\"say\",\"no-answer-group-voicemail_tag\":\"global\",\"no-answer-group-voicemail_caller_id\":\"+18884200006\",\"number\":\"(212) 300-5446\",\"library\":\"\",\"no-answer-redirect\":\"\",\"no-answer-redirect-number\":\"\",\"version\":\"3\"},\"id\":\"a5bb9a\",\"type\":\"standard---dial\"},\"15b392\":{\"name\":\"Dial\",\"data\":{\"dial-whom-selector\":\"user-or-group\",\"dial-whom-user-or-group_id\":\"3\",\"dial-whom-user-or-group_type\":\"group\",\"dial-whom-number\":\"\",\"callerId\":\"\",\"no-answer-action\":\"voicemail\",\"no-answer-group-voicemail_say\":\"Please leave us a voicemail after the tone. Thank you.\",\"no-answer-group-voicemail_play\":\"\",\"no-answer-group-voicemail_mode\":\"say\",\"no-answer-group-voicemail_tag\":\"global\",\"no-answer-group-voicemail_caller_id\":\"+18884200006\",\"number\":\"(212) 300-5446\",\"library\":\"\",\"no-answer-redirect\":\"\",\"no-answer-redirect-number\":\"\",\"version\":\"3\"},\"id\":\"15b392\",\"type\":\"standard---dial\"},\"215134\":{\"name\":\"Dial\",\"data\":{\"dial-whom-selector\":\"user-or-group\",\"dial-whom-user-or-group_id\":\"4\",\"dial-whom-user-or-group_type\":\"group\",\"dial-whom-number\":\"\",\"callerId\":\"\",\"no-answer-action\":\"voicemail\",\"no-answer-group-voicemail_say\":\"Please leave us a voicemail after the tone. Thank you.\",\"no-answer-group-voicemail_play\":\"\",\"no-answer-group-voicemail_mode\":\"say\",\"no-answer-group-voicemail_tag\":\"global\",\"no-answer-group-voicemail_caller_id\":\"+18884200006\",\"number\":\"(212) 300-5446\",\"library\":\"\",\"no-answer-redirect\":\"\",\"no-answer-redirect-number\":\"\",\"version\":\"3\"},\"id\":\"215134\",\"type\":\"standard---dial\"},\"9f17ac\":{\"name\":\"Dial\",\"data\":{\"dial-whom-selector\":\"user-or-group\",\"dial-whom-user-or-group_id\":\"5\",\"dial-whom-user-or-group_type\":\"group\",\"dial-whom-number\":\"\",\"callerId\":\"\",\"no-answer-action\":\"voicemail\",\"no-answer-group-voicemail_say\":\"Please leave us a voicemail after the tone. Thank you.\",\"no-answer-group-voicemail_play\":\"\",\"no-answer-group-voicemail_mode\":\"say\",\"no-answer-group-voicemail_tag\":\"global\",\"no-answer-group-voicemail_caller_id\":\"+18884200006\",\"number\":\"(212) 300-5446\",\"library\":\"\",\"no-answer-redirect\":\"\",\"no-answer-redirect-number\":\"\",\"version\":\"3\"},\"id\":\"9f17ac\",\"type\":\"standard---dial\"},\"92f08a\":{\"name\":\"Dial\",\"data\":{\"dial-whom-user-or-group_id\":\"1\",\"dial-whom-user-or-group_type\":\"user\",\"dial-whom-selector\":\"number\",\"dial-whom-number\":\"2123005446\",\"callerId\":\"\",\"no-answer-action\":\"voicemail\",\"no-answer-group-voicemail_say\":\"\",\"no-answer-group-voicemail_play\":\"\",\"no-answer-group-voicemail_mode\":\"\",\"no-answer-group-voicemail_tag\":\"global\",\"no-answer-group-voicemail_caller_id\":\"+18884200006\",\"number\":\"(212) 300-5446\",\"library\":\"\",\"no-answer-redirect\":\"\",\"no-answer-redirect-number\":\"start/727561/92f08a/419a4d\",\"version\":\"3\"},\"id\":\"92f08a\",\"type\":\"standard---dial\"},\"419a4d\":{\"name\":\"Voicemail\",\"data\":{\"prompt_say\":\"\",\"prompt_play\":\"\",\"prompt_mode\":\"\",\"prompt_tag\":\"global\",\"prompt_caller_id\":\"+18884200006\",\"number\":\"(212) 300-5446\",\"library\":\"\",\"permissions_id\":\"1\",\"permissions_type\":\"user\"},\"id\":\"419a4d\",\"type\":\"standard---voicemail\"},\"30a972\":{\"name\":\"Conference\",\"data\":{\"moderator_id\":\"\",\"moderator_type\":\"\",\"wait-url\":\"http://twimlets.com/holdmusic?Bucket=com.twilio.music.classical\",\"conf-id\":\"conf_4f281c56991ab\"},\"id\":\"30a972\",\"type\":\"standard---conference\"}}',NULL,1);

/*!40000 ALTER TABLE `flows` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table group_annotations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `group_annotations`;

CREATE TABLE `group_annotations` (
  `group_id` int(11) NOT NULL,
  `annotation_id` bigint(20) NOT NULL,
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`group_id`,`annotation_id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `group_annotations_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table group_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `group_messages`;

CREATE TABLE `group_messages` (
  `group_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`group_id`,`message_id`),
  KEY `tenant_id` (`tenant_id`),
  KEY `message_id` (`message_id`),
  CONSTRAINT `group_messages_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  CONSTRAINT `group_messages_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`),
  CONSTRAINT `group_messages_ibfk_3` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `group_messages` WRITE;
/*!40000 ALTER TABLE `group_messages` DISABLE KEYS */;

INSERT INTO `group_messages` (`group_id`, `message_id`, `tenant_id`)
VALUES
	(1,7,1),
	(2,6,1);

/*!40000 ALTER TABLE `group_messages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`id`, `name`, `is_active`, `tenant_id`)
VALUES
	(1,'Sales',1,1),
	(2,'Technical Support',1,1),
	(3,'General Inquiries',1,1),
	(4,'Legal',1,1),
	(5,'Payments',1,1);

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups_users`;

CREATE TABLE `groups_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tenant_id` bigint(20) NOT NULL,
  `order` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `tenant_id` (`tenant_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `groups_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `groups_users_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  CONSTRAINT `groups_users_ibfk_3` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `groups_users` WRITE;
/*!40000 ALTER TABLE `groups_users` DISABLE KEYS */;

INSERT INTO `groups_users` (`id`, `group_id`, `user_id`, `tenant_id`, `order`)
VALUES
	(2,2,1,1,1),
	(4,1,1,1,1),
	(5,1,2,1,2),
	(6,2,2,1,2),
	(7,3,2,1,1),
	(8,3,1,1,2),
	(9,4,1,1,1),
	(10,5,1,1,1);

/*!40000 ALTER TABLE `groups_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `read` datetime DEFAULT NULL,
  `call_sid` varchar(40) DEFAULT NULL,
  `caller` varchar(20) DEFAULT NULL,
  `called` varchar(20) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `content_url` varchar(255) DEFAULT NULL,
  `content_text` varchar(5000) DEFAULT NULL,
  `notes` varchar(5000) DEFAULT NULL,
  `size` smallint(6) DEFAULT NULL,
  `assigned_to` bigint(20) DEFAULT NULL,
  `archived` tinyint(4) NOT NULL DEFAULT '0',
  `ticket_status` enum('open','closed','pending') NOT NULL DEFAULT 'open',
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `call_sid` (`call_sid`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dump of table numbers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `numbers`;

CREATE TABLE `numbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `value` text NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `sms` tinyint(1) DEFAULT '0',
  `sequence` smallint(6) DEFAULT NULL,
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `numbers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `numbers_ibfk_2` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `numbers` WRITE;
/*!40000 ALTER TABLE `numbers` DISABLE KEYS */;

INSERT INTO `numbers` (`id`, `user_id`, `name`, `value`, `is_active`, `sms`, `sequence`, `tenant_id`)
VALUES
	(1,1,'Primary Device1','+12120000000',1,1,NULL,1),
	(2,3,'Primary Device2','+12120000000',1,1,NULL,1);

/*!40000 ALTER TABLE `numbers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table outbound_queue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `outbound_queue`;

CREATE TABLE `outbound_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant` bigint(20) NOT NULL,
  `number` varchar(15) NOT NULL,
  `type` varchar(4) NOT NULL,
  `time` int(11) NOT NULL,
  `callerId` varchar(15) NOT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `tenant` (`tenant`,`type`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `outbound_queue` WRITE;
/*!40000 ALTER TABLE `outbound_queue` DISABLE KEYS */;

INSERT INTO `outbound_queue` (`id`, `tenant`, `number`, `type`, `time`, `callerId`, `data`)
VALUES
	(10,1,'+12120000000','call',1325998800,'+18509377131','{\"id\":\"6\",\"name\":\"new flow\"}'),
	(9,1,'+12123330000','call',1327986000,'+18509377131','{\"id\":\"1\",\"name\":\"test\"}');

/*!40000 ALTER TABLE `outbound_queue` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phone_numbers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phone_numbers`;

CREATE TABLE `phone_numbers` (
  `tenant_id` int(11) unsigned NOT NULL,
  `number` varchar(25) DEFAULT NULL,
  `status` enum('active','suspended','deleted') NOT NULL DEFAULT 'active',
  `addedon` datetime DEFAULT NULL,
  `lastmodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phone_numbers` WRITE;
/*!40000 ALTER TABLE `phone_numbers` DISABLE KEYS */;

INSERT INTO `phone_numbers` (`tenant_id`, `number`, `status`, `addedon`, `lastmodified`)
VALUES
	(1,'+18884200006','active',NULL,'2012-01-14 12:18:31'),
	(1,'+16175000773','active',NULL,'2012-01-14 12:18:40'),
	(1,'+16175000771','active',NULL,'2012-01-14 12:18:42');

/*!40000 ALTER TABLE `phone_numbers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phone_plans
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phone_plans`;

CREATE TABLE `phone_plans` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phone_resources
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phone_resources`;

CREATE TABLE `phone_resources` (
  `tenant_id` int(11) NOT NULL,
  `phonenumbers` int(11) DEFAULT NULL,
  `minutes_allocated` int(11) DEFAULT NULL,
  `minutes_available` int(11) DEFAULT NULL,
  `tfminutes_allocated` int(11) DEFAULT NULL,
  `tfminutes_available` int(11) DEFAULT NULL,
  `sms_allocated` int(11) DEFAULT NULL,
  `sms_available` int(11) DEFAULT NULL,
  `balance` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phone_resources` WRITE;
/*!40000 ALTER TABLE `phone_resources` DISABLE KEYS */;

INSERT INTO `phone_resources` (`tenant_id`, `phonenumbers`, `minutes_allocated`, `minutes_available`, `tfminutes_allocated`, `tfminutes_available`, `sms_allocated`, `sms_available`, `balance`)
VALUES
	(1,5,0,542,0,92,0,200,7.96);

/*!40000 ALTER TABLE `phone_resources` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table plugin_store
# ------------------------------------------------------------

DROP TABLE IF EXISTS `plugin_store`;

CREATE TABLE `plugin_store` (
  `key` varchar(255) NOT NULL,
  `value` text,
  `plugin_id` varchar(34) NOT NULL,
  `tenant_id` bigint(20) NOT NULL,
  UNIQUE KEY `key_plugin` (`key`,`plugin_id`,`tenant_id`),
  KEY `key` (`key`,`plugin_id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `plugin_store_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table polls
# ------------------------------------------------------------

DROP TABLE IF EXISTS `polls`;

CREATE TABLE `polls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `tenant` (`tenant`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `polls` WRITE;
/*!40000 ALTER TABLE `polls` DISABLE KEYS */;

INSERT INTO `polls` (`id`, `tenant`, `name`, `data`)
VALUES
	(7,1,'new poll','[\"a\",\"b\",\"c\"]'),
	(8,1,'poll2','[\"yes\",\"no\"]');

/*!40000 ALTER TABLE `polls` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table polls_responses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `polls_responses`;

CREATE TABLE `polls_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll` int(11) NOT NULL,
  `value` varchar(15) NOT NULL,
  `response` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `poll` (`poll`,`value`,`response`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table rest_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rest_access`;

CREATE TABLE `rest_access` (
  `key` varchar(32) NOT NULL,
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `rest_access_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `rest_access` WRITE;
/*!40000 ALTER TABLE `rest_access` DISABLE KEYS */;

INSERT INTO `rest_access` (`key`, `locked`, `created`, `user_id`, `tenant_id`)
VALUES
	('19aeceaaa97cb66028131d53bfb06e48',1,'2012-01-14 19:40:45',1,1),
	('8ea8af503c97f38ba97c1f873fc06a7f',1,'2012-01-14 18:42:29',1,1),
	('916b1f04f565b4e40a1b044018ef41b6',0,'2012-01-14 19:40:45',1,1),
	('f101d6ade3977837e3bbfaee736863c8',0,'2012-01-14 18:42:29',1,1);

/*!40000 ALTER TABLE `rest_access` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint(20) NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `tenant_id` (`tenant_id`,`name`),
  CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `tenant_id`, `name`, `value`)
VALUES
	(1,1,'dash_rss',''),
	(2,1,'theme',''),
	(3,1,'iphone_theme',''),
	(4,1,'enable_sandbox_number','0'),
	(5,1,'twilio_endpoint','https://api.twilio.com/2010-04-01'),
	(6,1,'recording_host','encrypted.igrou.ps'),
	(7,1,'transcriptions','1'),
	(8,1,'voice','woman'),
	(9,1,'voice_language','en-gb'),
	(10,1,'numbers_country','US'),
	(11,1,'gravatars','0'),
	(12,1,'connect_application_sid',''),
	(13,1,'dial_timeout','60'),
	(14,1,'email_notifications_voice','1'),
	(15,1,'email_notifications_sms','1'),
	(16,1,'twilio_sid','replaceme'),
	(17,1,'twilio_token','replaceme'),
	(18,1,'from_email','phone@igrou.ps'),
	(19,1,'trial_number','(415) 599-2671'),
	(20,1,'schema-version','70'),
	(21,1,'rewrite_enabled','1'),
	(22,1,'application_sid','replaceme'),
	(23,1,'server_time_zone','America/New_York');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table subscribers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subscribers`;

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list` int(11) NOT NULL,
  `value` varchar(15) NOT NULL,
  `joined` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `list` (`list`,`value`,`joined`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `subscribers` WRITE;
/*!40000 ALTER TABLE `subscribers` DISABLE KEYS */;

INSERT INTO `subscribers` (`id`, `list`, `value`, `joined`)
VALUES
	(1,1,'+12123330000',1326055048),
	(3,1,'+13433433333',1326055147),
	(4,1,'+13433433332',1326055147);

/*!40000 ALTER TABLE `subscribers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table subscribers_lists
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subscribers_lists`;

CREATE TABLE `subscribers_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tenant` (`tenant`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `subscribers_lists` WRITE;
/*!40000 ALTER TABLE `subscribers_lists` DISABLE KEYS */;

INSERT INTO `subscribers_lists` (`id`, `tenant`, `name`)
VALUES
	(1,1,'new list here');

/*!40000 ALTER TABLE `subscribers_lists` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tenants
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tenants`;

CREATE TABLE `tenants` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url_prefix` varchar(255) NOT NULL,
  `local_prefix` varchar(1000) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `url_prefix` (`url_prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;

INSERT INTO `tenants` (`id`, `name`, `url_prefix`, `local_prefix`, `active`, `type`)
VALUES
	(1,'default','','',1,0);

/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tracker_calls
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tracker_calls`;

CREATE TABLE `tracker_calls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `AccountSid` varchar(128) DEFAULT NULL,
  `ApplicationSid` varchar(128) DEFAULT NULL,
  `CallStatus` varchar(20) DEFAULT NULL,
  `Direction` varchar(20) DEFAULT NULL,
  `Duration` int(8) DEFAULT NULL,
  `CallDuration` int(8) DEFAULT NULL,
  `CallSid` varchar(128) DEFAULT NULL,
  `Called` varchar(32) DEFAULT NULL,
  `CalledCity` varchar(50) DEFAULT NULL,
  `CalledState` varchar(50) DEFAULT NULL,
  `CalledZip` varchar(50) DEFAULT NULL,
  `CalledCountry` varchar(50) DEFAULT NULL,
  `Caller` varchar(32) DEFAULT NULL,
  `CallerCity` varchar(50) DEFAULT NULL,
  `CallerState` varchar(50) DEFAULT NULL,
  `CallerZip` varchar(50) DEFAULT NULL,
  `CallerCountry` varchar(50) DEFAULT NULL,
  `To` varchar(32) DEFAULT NULL,
  `ToCity` varchar(50) DEFAULT NULL,
  `ToState` varchar(50) DEFAULT NULL,
  `ToZip` varchar(50) DEFAULT NULL,
  `ToCountry` varchar(50) DEFAULT NULL,
  `From` varchar(32) DEFAULT NULL,
  `FromCity` varchar(50) DEFAULT NULL,
  `FromState` varchar(50) DEFAULT NULL,
  `FromZip` varchar(50) DEFAULT NULL,
  `FromCountry` varchar(50) DEFAULT NULL,
  `ErrorCode` int(5) DEFAULT NULL,
  `ErrorUrl` varchar(1000) DEFAULT NULL,
  `ErrorMessage` varchar(500) DEFAULT NULL,
  `IsError` varchar(10) DEFAULT NULL,
  `Price` varchar(5) DEFAULT NULL,
  `EndTime` varchar(50) DEFAULT NULL,
  `StartTime` varchar(50) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `LastUpdated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `RecordingUrl` varchar(512) DEFAULT NULL,
  `RecordingDuration` int(5) DEFAULT NULL,
  `RecordingSid` varchar(128) DEFAULT NULL,
  `Digits` varchar(100) DEFAULT NULL,
  `DialCallDuration` int(5) DEFAULT NULL,
  `vbxsite` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `AccountSid` (`AccountSid`),
  KEY `ApplicationSid` (`ApplicationSid`),
  KEY `Direction` (`Direction`),
  KEY `Duration` (`Duration`),
  KEY `Called` (`Called`),
  KEY `Caller` (`Caller`),
  KEY `To` (`To`),
  KEY `From` (`From`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tracker_calls` WRITE;
/*!40000 ALTER TABLE `tracker_calls` DISABLE KEYS */;

INSERT INTO `tracker_calls` (`id`, `AccountSid`, `ApplicationSid`, `CallStatus`, `Direction`, `Duration`, `CallDuration`, `CallSid`, `Called`, `CalledCity`, `CalledState`, `CalledZip`, `CalledCountry`, `Caller`, `CallerCity`, `CallerState`, `CallerZip`, `CallerCountry`, `To`, `ToCity`, `ToState`, `ToZip`, `ToCountry`, `From`, `FromCity`, `FromState`, `FromZip`, `FromCountry`, `ErrorCode`, `ErrorUrl`, `ErrorMessage`, `IsError`, `Price`, `EndTime`, `StartTime`, `Date`, `LastUpdated`, `RecordingUrl`, `RecordingDuration`, `RecordingSid`, `Digits`, `DialCallDuration`, `vbxsite`)
VALUES
	(1,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAdf07e753ce4fdd0d161557ad4f37b47f','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:09:46','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(2,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAdf07e753ce4fdd0d161557ad4f37b47f','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:09:46','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(3,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CAdf07e753ce4fdd0d161557ad4f37b47f','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:09:58','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(4,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA76d8bdb76e8b6213018481c5c6418f58','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:10:27','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(5,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA76d8bdb76e8b6213018481c5c6418f58','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:10:27','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(6,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CA76d8bdb76e8b6213018481c5c6418f58','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:10:38','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(7,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA2ff95b97f64d8dc4d77e662c08270308','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:12:27','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(8,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA2ff95b97f64d8dc4d77e662c08270308','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:12:27','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(9,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CA2ff95b97f64d8dc4d77e662c08270308','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:12:37','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(10,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA5d05cb89a054f1969ad12c39df7147ad','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:14:14','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(11,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA5d05cb89a054f1969ad12c39df7147ad','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:14:14','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(12,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAebc385066a4dc09c006b43891ed40237','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:21:55','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(13,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAebc385066a4dc09c006b43891ed40237','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:21:56','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(14,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA2ed16862b183eaf476397e699a480c9a','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:39:58','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(15,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA2ed16862b183eaf476397e699a480c9a','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-08 23:39:58','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(16,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAc9770ce506c0514e68c945b596acc940','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 00:05:29','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(17,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAc9770ce506c0514e68c945b596acc940','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 00:05:29','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(18,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAfc36aa54c59b1a950f5cfba4d1cf3285','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 00:09:50','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(19,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAfc36aa54c59b1a950f5cfba4d1cf3285','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 00:09:50','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(20,'replaceme','APfe73358520fb4b8e9b31cdb23dbf8ddb','completed','inbound',1,4,'CA41d3a707e610c6bd5908473c214af4c1','+18884200006',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'+18884200006',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 00:28:01','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(21,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAadb15f5f8089952c65410e20a05ac15f','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 00:28:43','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(22,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAadb15f5f8089952c65410e20a05ac15f','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 00:28:43','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(23,'replaceme','APfe73358520fb4b8e9b31cdb23dbf8ddb','completed','inbound',1,4,'CA0f5c8c9e702498c0a30e26c5993228d2','+18884200006',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'+18884200006',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 00:30:36','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(24,'replaceme','APfe73358520fb4b8e9b31cdb23dbf8ddb','completed','inbound',1,5,'CA13c25403d3e3ef58011b92b7c8adce4b','+18884200006',NULL,NULL,NULL,NULL,'client:twilioUI',NULL,NULL,NULL,NULL,'+18884200006',NULL,NULL,NULL,NULL,'client:twilioUI',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 00:33:17','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(25,'replaceme','APfe73358520fb4b8e9b31cdb23dbf8ddb','completed','inbound',1,6,'CA8dfc1c0f9eae8020ac91d4ed8bf85d8d','+18884200006',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'+18884200006',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 00:34:01','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(26,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAbf37fa7f29703f7ef9af21bfaa081450','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:11:04','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(27,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAbf37fa7f29703f7ef9af21bfaa081450','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:11:06','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(28,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA13c6c0b5a7e01a35a3342938843eb4b5','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:13:02','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(29,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA13c6c0b5a7e01a35a3342938843eb4b5','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:13:03','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(30,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CA13c6c0b5a7e01a35a3342938843eb4b5','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:13:10','2012-01-14 12:41:04','http://api.twilio.com/2010-04-01/Accounts/replaceme/Recordings/REc6b3b724ef1f30d53b95eb7ff31a20da',3,'REc6b3b724ef1f30d53b95eb7ff31a20da','5',NULL,NULL),
	(31,'replaceme','APfe73358520fb4b8e9b31cdb23dbf8ddb','completed','inbound',1,3,'CA05989593271c7503f3ea1726495c4b1d','+18884200006',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'+18884200006',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:17:35','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(32,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA957b24f7733f9f9a76c5dd84f8e44b68','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:20:05','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(33,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA957b24f7733f9f9a76c5dd84f8e44b68','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:20:05','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(34,'replaceme',NULL,'completed','inbound',1,5,'CA957b24f7733f9f9a76c5dd84f8e44b68','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:20:10','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(35,'replaceme',NULL,'completed','inbound',1,7,'CA7e81d7736b95de0b352b99bd3014f690','+18884200006','CANTONMENT','FL','32514','US','+16174181670','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:32:14','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(36,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAbad3d7b6e84ea36312ef21037116ed90','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:47:21','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(37,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAbad3d7b6e84ea36312ef21037116ed90','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:47:21','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(38,'replaceme',NULL,'completed','inbound',NULL,NULL,'CAbad3d7b6e84ea36312ef21037116ed90','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:47:28','2012-01-14 12:41:04','http://api.twilio.com/2010-04-01/Accounts/replaceme/Recordings/RE8f1c9a960051d1b08232d5abd3ebd76b',3,'RE8f1c9a960051d1b08232d5abd3ebd76b','hangup',NULL,NULL),
	(39,'replaceme',NULL,'completed','inbound',1,7,'CAbad3d7b6e84ea36312ef21037116ed90','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:47:28','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(40,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA1fe49d8952d1e74aa723d7c965cfdecb','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:48:51','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(41,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA1fe49d8952d1e74aa723d7c965cfdecb','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:48:51','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(42,'replaceme',NULL,'completed','inbound',1,5,'CA1fe49d8952d1e74aa723d7c965cfdecb','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:48:56','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(43,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA17369591c10af67e95b95db5f6d13a69','+18884200006','CANTONMENT','FL','32514','US','+16174181670','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:51:21','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(44,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA17369591c10af67e95b95db5f6d13a69','+18884200006','CANTONMENT','FL','32514','US','+16174181670','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:51:21','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(45,'replaceme',NULL,'completed','inbound',1,6,'CA17369591c10af67e95b95db5f6d13a69','+18884200006','CANTONMENT','FL','32514','US','+16174181670','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:51:28','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(46,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA9e823df66a337c5f40e1d1f91a2c8818','+18884200006','CANTONMENT','FL','32514','US','+16174181670','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:55:20','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(47,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA9e823df66a337c5f40e1d1f91a2c8818','+18884200006','CANTONMENT','FL','32514','US','+16174181670','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:55:20','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(48,'replaceme',NULL,'completed','inbound',1,6,'CA9e823df66a337c5f40e1d1f91a2c8818','+18884200006','CANTONMENT','FL','32514','US','+16174181670','NEW YORK','NY','10279','US','+18884200006','CANTONMENT','FL','32514','US','+16174181670','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 01:55:26','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(49,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA10119cd8bdb4c1740ea9b6039e91bb3d','+18884200006','','','','US','+13066423065','ASSINIBOIA','SK','S0H 2R0','CA','+18884200006','','','','US','+13066423065','ASSINIBOIA','SK','S0H 2R0','CA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 15:03:44','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(50,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA10119cd8bdb4c1740ea9b6039e91bb3d','+18884200006','','','','US','+13066423065','ASSINIBOIA','SK','S0H 2R0','CA','+18884200006','','','','US','+13066423065','ASSINIBOIA','SK','S0H 2R0','CA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 15:03:44','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(51,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA10119cd8bdb4c1740ea9b6039e91bb3d','+18884200006','','','','US','+13066423065','ASSINIBOIA','SK','S0H 2R0','CA','+18884200006','','','','US','+13066423065','ASSINIBOIA','SK','S0H 2R0','CA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 15:04:23','2012-01-14 12:41:04','http://api.twilio.com/2010-04-01/Accounts/replaceme/Recordings/RE21778697c382d33b35a308a5cae3ba45',35,'RE21778697c382d33b35a308a5cae3ba45','hangup',NULL,NULL),
	(52,'replaceme',NULL,'completed','inbound',1,39,'CA10119cd8bdb4c1740ea9b6039e91bb3d','+18884200006','','','','US','+13066423065','ASSINIBOIA','SK','S0H 2R0','CA','+18884200006','','','','US','+13066423065','ASSINIBOIA','SK','S0H 2R0','CA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-09 15:04:23','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(53,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAa72156c12f725121174abf51345a93b4','+18884200006','CANTONMENT','FL','32514','US','+17024107076','LAS VEGAS','NV','89101','US','+18884200006','CANTONMENT','FL','32514','US','+17024107076','LAS VEGAS','NV','89101','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-10 12:07:10','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(54,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAa72156c12f725121174abf51345a93b4','+18884200006','CANTONMENT','FL','32514','US','+17024107076','LAS VEGAS','NV','89101','US','+18884200006','CANTONMENT','FL','32514','US','+17024107076','LAS VEGAS','NV','89101','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-10 12:07:10','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(55,'replaceme',NULL,'completed','inbound',1,4,'CAa72156c12f725121174abf51345a93b4','+18884200006','CANTONMENT','FL','32514','US','+17024107076','LAS VEGAS','NV','89101','US','+18884200006','CANTONMENT','FL','32514','US','+17024107076','LAS VEGAS','NV','89101','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-10 12:07:14','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(56,'replaceme','APfe73358520fb4b8e9b31cdb23dbf8ddb','completed','inbound',1,5,'CAb0a34a612f12926c1473e84621bd6739','+18884200006',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'+18884200006',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-10 15:19:59','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(57,'replaceme','APfe73358520fb4b8e9b31cdb23dbf8ddb','completed','inbound',1,4,'CA3ceb15b14d94ca17116f7dc1d6328bb9','+18884200006',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'+18884200006',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-10 15:21:59','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(58,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAe2ae24a73af4a5c240b37b443541fb07','+18884200006','CANTONMENT','FL','32514','US','+17024107076','LAS VEGAS','NV','89101','US','+18884200006','CANTONMENT','FL','32514','US','+17024107076','LAS VEGAS','NV','89101','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-10 19:46:34','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(59,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAe2ae24a73af4a5c240b37b443541fb07','+18884200006','CANTONMENT','FL','32514','US','+17024107076','LAS VEGAS','NV','89101','US','+18884200006','CANTONMENT','FL','32514','US','+17024107076','LAS VEGAS','NV','89101','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-10 19:46:34','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,NULL),
	(60,'replaceme',NULL,'completed','inbound',1,4,'CAe2ae24a73af4a5c240b37b443541fb07','+18884200006','CANTONMENT','FL','32514','US','+17024107076','LAS VEGAS','NV','89101','US','+18884200006','CANTONMENT','FL','32514','US','+17024107076','LAS VEGAS','NV','89101','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-10 19:46:40','2012-01-14 12:41:04',NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(61,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA17b3e2816834794b0b7149525a073110','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 13:29:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(62,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA17b3e2816834794b0b7149525a073110','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 13:29:34',NULL,NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(63,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA7823a1930bef3557faa9f4eb3391d20c','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 13:29:35',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(64,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA7823a1930bef3557faa9f4eb3391d20c','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 13:29:35',NULL,NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(65,'replaceme','replaceme','completed','inbound',1,22,'CA227240f68cf2b4b469c539ab7b84f74d','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 13:42:52',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(66,'replaceme','replaceme','completed','inbound',1,11,'CAa9d75f2dd5c2c3297665a90c2be2d1ff','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 14:40:57',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(67,'replaceme','replaceme','completed','inbound',1,5,'CA7e9c8a2f3842683feee0bfffb08adc74','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 14:49:25',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(68,'replaceme','replaceme','completed','inbound',1,3,'CAec25de636169051efd6a25a22802a63d','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 14:49:46',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(69,'replaceme','replaceme','completed','inbound',1,5,'CAd2f14c5ca4b6551728d122c7bc66f34f','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 14:51:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(70,'replaceme','replaceme','completed','inbound',1,6,'CA5255aabd6e3123d1188c22a487fdb17a','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 14:54:41',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(71,'replaceme','replaceme','completed','inbound',1,5,'CAbb1f846a2105b1bc71f9634db21ace32','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 14:59:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(72,'replaceme','replaceme','completed','inbound',1,5,'CA403d390cbec0efcfe337f2d184476056','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:00:29',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(73,'replaceme','replaceme','completed','inbound',1,6,'CAeafcdd6436d0d64e6c7571dd80e018fe','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:11:09',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(74,'replaceme','replaceme','completed','inbound',1,5,'CAa4dc9008296a53767d0b3d57c96ebc8f','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:12:31',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(75,'replaceme','replaceme','completed','inbound',1,5,'CAb860a9701d75452c38ae992bcac0d612','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:18:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(76,'replaceme','replaceme','completed','inbound',1,5,'CAbdfbcdc941c90172120725099cf65cd8','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:21:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(77,'replaceme','replaceme','completed','inbound',1,5,'CAfed6cc27f2ee8ec0d758f339bcb62684','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:22:35',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(78,'replaceme','replaceme','completed','inbound',1,5,'CA5ef34be045d703818f89402e287e9325','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:23:31',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(79,'replaceme','replaceme','completed','inbound',1,5,'CA4b3a4f7478a3149ff511a10aed6403be','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:24:11',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(80,'replaceme','replaceme','completed','inbound',1,6,'CA9df7000dff60b5fff1f686d5aa05229b','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:38:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(81,'replaceme','replaceme','completed','inbound',1,5,'CAbad0ae0d154fdf8e32624bd9575bc1b4','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:43:31',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(82,'replaceme','replaceme','completed','inbound',1,6,'CA252bf04adfe8f8c0c094ca8cd966e130','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:46:41',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(83,'replaceme','replaceme','completed','inbound',1,6,'CAe441a54ea17fcaf3f8baf610ab43445b','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:47:04',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(84,'replaceme','replaceme','completed','inbound',1,6,'CA1c891cf92c8f321ba98bd968a35f40c0','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:54:57',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(85,'replaceme','replaceme','completed','inbound',1,5,'CA3a1981e02e7e86ca31d70cb183bd8031','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:57:10',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(86,'replaceme','replaceme','completed','inbound',1,6,'CA7cb971705f1174c0665439007be298cd','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 15:59:16',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(87,'replaceme','replaceme','completed','inbound',1,6,'CA082f126efeade3da382b39d5f823004d','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 16:02:53',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(88,'replaceme','replaceme','completed','inbound',1,5,'CA6265f79a4e19e2e95326380ae70f4371','',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 16:51:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(89,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAd800a391b86b464ea4a6d0253a12aee5','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:45:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(90,'replaceme',NULL,'completed','inbound',NULL,NULL,'CAd800a391b86b464ea4a6d0253a12aee5','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:45:24',NULL,NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(91,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA5635bfe36b09a7217d575f067b897fb3','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:48:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(92,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA5635bfe36b09a7217d575f067b897fb3','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:48:53',NULL,NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(93,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA662b5de5e1f1cb8c5f54443ae0a7f701','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:49:11',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(94,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA662b5de5e1f1cb8c5f54443ae0a7f701','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:49:13',NULL,NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(95,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAed7a14c4782bca3a3a108fc308dafc72','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:51:18',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(96,'replaceme',NULL,'completed','inbound',NULL,NULL,'CAed7a14c4782bca3a3a108fc308dafc72','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:51:21',NULL,NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(97,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAac3c2ccfa079beb0ad49fe0d7a33db74','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:54:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(98,'replaceme',NULL,'completed','inbound',NULL,NULL,'CAac3c2ccfa079beb0ad49fe0d7a33db74','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:54:16',NULL,NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(99,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA62edcfe9587306d9d7015915907b7a0c','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:55:14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(100,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA62edcfe9587306d9d7015915907b7a0c','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:55:14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(101,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA62edcfe9587306d9d7015915907b7a0c','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:55:19',NULL,NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(102,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA49017b695a7d04129efd20252d384fa6','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:56:41',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(103,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA49017b695a7d04129efd20252d384fa6','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:56:42',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(104,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA49017b695a7d04129efd20252d384fa6','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:56:50',NULL,NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(105,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAddd47ff5b6bac7b51a0e707174bdd1de','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:58:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(106,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAddd47ff5b6bac7b51a0e707174bdd1de','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:58:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(107,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CAddd47ff5b6bac7b51a0e707174bdd1de','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:59:29',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(108,'replaceme',NULL,'completed','inbound',NULL,NULL,'CAddd47ff5b6bac7b51a0e707174bdd1de','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:59:36',NULL,'http://api.twilio.com/2010-04-01/Accounts/replaceme/Recordings/REe88ec19825a1f27e3c8a9a24881cd4c9',4,'REe88ec19825a1f27e3c8a9a24881cd4c9','hangup',NULL,NULL),
	(109,'replaceme',NULL,'completed','inbound',NULL,NULL,'CAddd47ff5b6bac7b51a0e707174bdd1de','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 17:59:36',NULL,NULL,NULL,NULL,NULL,NULL,'twiml/vbx_tracker'),
	(110,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA71b9ca81b5efc567e2761e945eb1522d','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:08:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(111,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA71b9ca81b5efc567e2761e945eb1522d','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:08:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(112,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA71b9ca81b5efc567e2761e945eb1522d','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:08:08',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(113,'replaceme',NULL,'completed','inbound',1,7,'CA71b9ca81b5efc567e2761e945eb1522d','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:08:08',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(114,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAc9255a1e1a7fb866baefcb0c2a0ee6da','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:09:07',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(115,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAc9255a1e1a7fb866baefcb0c2a0ee6da','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:09:09',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(116,'replaceme',NULL,'completed','inbound',NULL,NULL,'CAc9255a1e1a7fb866baefcb0c2a0ee6da','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:09:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(117,'replaceme',NULL,'completed','inbound',1,4,'CAc9255a1e1a7fb866baefcb0c2a0ee6da','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:09:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(118,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAed8662868f1ee3447ccdfb189488602b','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:17:27',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(119,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAed8662868f1ee3447ccdfb189488602b','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:17:27',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(120,'replaceme',NULL,'completed','inbound',NULL,NULL,'CAed8662868f1ee3447ccdfb189488602b','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:17:32',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(121,'replaceme',NULL,'completed','inbound',1,4,'CAed8662868f1ee3447ccdfb189488602b','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:17:32',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(122,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA9fc7e90e656c0208d1d29453ec7e26ce','+16175000771','CAMBRIDGE','MA','02141','US','+12120000000','NEW YORK','NY','10279','US','+16175000771','CAMBRIDGE','MA','02141','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:19:10',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(123,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA9fc7e90e656c0208d1d29453ec7e26ce','+16175000771','CAMBRIDGE','MA','02141','US','+12120000000','NEW YORK','NY','10279','US','+16175000771','CAMBRIDGE','MA','02141','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:19:10',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(124,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA9fc7e90e656c0208d1d29453ec7e26ce','+16175000771','CAMBRIDGE','MA','02141','US','+12120000000','NEW YORK','NY','10279','US','+16175000771','CAMBRIDGE','MA','02141','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:19:17',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(125,'replaceme',NULL,'completed','inbound',1,7,'CA9fc7e90e656c0208d1d29453ec7e26ce','+16175000771','CAMBRIDGE','MA','02141','US','+12120000000','NEW YORK','NY','10279','US','+16175000771','CAMBRIDGE','MA','02141','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:19:17',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(126,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA3aa2e16d800e5ee89479bf61475a0226','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:19:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(127,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA3aa2e16d800e5ee89479bf61475a0226','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:19:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(128,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA3aa2e16d800e5ee89479bf61475a0226','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:19:46',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(129,'replaceme',NULL,'completed','inbound',1,12,'CA3aa2e16d800e5ee89479bf61475a0226','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:19:46',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(130,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAcd1cc23d3ad8f12549891d21ff089629','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:23:37',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(131,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAcd1cc23d3ad8f12549891d21ff089629','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:23:37',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(132,'replaceme',NULL,'completed','inbound',NULL,NULL,'CAcd1cc23d3ad8f12549891d21ff089629','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:23:45',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(133,'replaceme',NULL,'completed','inbound',1,8,'CAcd1cc23d3ad8f12549891d21ff089629','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:23:45',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(134,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAe4b07c066b554e329a2d04de34344915','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:28:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(135,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAe4b07c066b554e329a2d04de34344915','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:28:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(136,'replaceme',NULL,'completed','inbound',NULL,NULL,'CAe4b07c066b554e329a2d04de34344915','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:28:27',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(137,'replaceme',NULL,'completed','inbound',1,4,'CAe4b07c066b554e329a2d04de34344915','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 18:28:27',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(138,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA6baf67125d9c2575239fe38db992c053','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 22:17:47',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(139,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA6baf67125d9c2575239fe38db992c053','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 22:17:47',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(140,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA6baf67125d9c2575239fe38db992c053','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 22:17:52',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(141,'replaceme',NULL,'completed','inbound',1,5,'CA6baf67125d9c2575239fe38db992c053','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-14 22:17:53',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(142,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAdef57d5dbe5d00bdc6184e26ac3238ca','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-15 11:00:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(143,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAdef57d5dbe5d00bdc6184e26ac3238ca','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-15 11:00:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(144,'replaceme',NULL,'completed','inbound',NULL,NULL,'CAdef57d5dbe5d00bdc6184e26ac3238ca','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-15 11:00:49',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(145,'replaceme',NULL,'completed','inbound',1,5,'CAdef57d5dbe5d00bdc6184e26ac3238ca','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-15 11:00:49',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(146,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA607329471d5b9bf6ded376a058f85cef','+18884200006','','','','US','+16462497698','NEW YORK','NY','10028','US','+18884200006','','','','US','+16462497698','NEW YORK','NY','10028','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-25 14:54:54',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(147,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA607329471d5b9bf6ded376a058f85cef','+18884200006','','','','US','+16462497698','NEW YORK','NY','10028','US','+18884200006','','','','US','+16462497698','NEW YORK','NY','10028','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-25 14:54:54',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(148,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CA607329471d5b9bf6ded376a058f85cef','+18884200006','','','','US','+16462497698','NEW YORK','NY','10028','US','+18884200006','','','','US','+16462497698','NEW YORK','NY','10028','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-25 14:55:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(149,'replaceme',NULL,'completed','inbound',1,48,'CA607329471d5b9bf6ded376a058f85cef','+18884200006','','','','US','+16462497698','NEW YORK','NY','10028','US','+18884200006','','','','US','+16462497698','NEW YORK','NY','10028','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-25 14:55:42',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(150,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAc7ac2e1f9322d0e3879bc474b8e55eb5','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 11:57:31',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(151,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CAc7ac2e1f9322d0e3879bc474b8e55eb5','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 11:57:32',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(152,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CAc7ac2e1f9322d0e3879bc474b8e55eb5','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 11:58:06',NULL,NULL,NULL,NULL,'0',NULL,NULL),
	(153,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CAc7ac2e1f9322d0e3879bc474b8e55eb5','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 11:58:06',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(154,'replaceme',NULL,'completed','inbound',2,64,'CAc7ac2e1f9322d0e3879bc474b8e55eb5','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 11:58:36',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(155,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA8fa0f0fb6f2a83db6f8d30d40d6fee87','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 11:58:40',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(156,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA8fa0f0fb6f2a83db6f8d30d40d6fee87','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 11:58:40',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(157,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CA8fa0f0fb6f2a83db6f8d30d40d6fee87','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 11:58:51',NULL,NULL,NULL,NULL,'2',NULL,NULL),
	(158,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CA8fa0f0fb6f2a83db6f8d30d40d6fee87','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 11:58:51',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(159,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA8fa0f0fb6f2a83db6f8d30d40d6fee87','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 11:58:59',NULL,'http://api.twilio.com/2010-04-01/Accounts/replaceme/Recordings/RE3d0f27a93d00665374aa1b0a0b45fff5',4,'RE3d0f27a93d00665374aa1b0a0b45fff5','hangup',NULL,NULL),
	(160,'replaceme',NULL,'completed','inbound',1,19,'CA8fa0f0fb6f2a83db6f8d30d40d6fee87','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 11:58:59',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(161,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA60ef0b7d6b2e40545c951146bebc2ea0','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 12:14:05',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(162,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA60ef0b7d6b2e40545c951146bebc2ea0','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 12:14:06',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(163,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CA60ef0b7d6b2e40545c951146bebc2ea0','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 12:14:17',NULL,NULL,NULL,NULL,'2',NULL,NULL),
	(164,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CA60ef0b7d6b2e40545c951146bebc2ea0','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 12:14:17',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(165,'replaceme',NULL,'completed','inbound',1,21,'CA60ef0b7d6b2e40545c951146bebc2ea0','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US','+18884200006','','','','US','+17813702700','CAMBRIDGE','MA','02494','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 12:14:27',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(166,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA96685103bf1045bfdb197b00f334fed7','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 21:17:15',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(167,'replaceme',NULL,'ringing','inbound',NULL,NULL,'CA96685103bf1045bfdb197b00f334fed7','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 21:17:15',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(168,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CA96685103bf1045bfdb197b00f334fed7','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 21:18:40',NULL,NULL,NULL,NULL,'1',NULL,NULL),
	(169,'replaceme',NULL,'in-progress','inbound',NULL,NULL,'CA96685103bf1045bfdb197b00f334fed7','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 21:18:41',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(170,'replaceme',NULL,'completed','inbound',NULL,NULL,'CA96685103bf1045bfdb197b00f334fed7','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 21:19:05',NULL,'http://api.twilio.com/2010-04-01/Accounts/replaceme/Recordings/RE363ef5a035a7dca82150107cbaf44960',3,'RE363ef5a035a7dca82150107cbaf44960','hangup',NULL,NULL),
	(171,'replaceme',NULL,'completed','inbound',2,110,'CA96685103bf1045bfdb197b00f334fed7','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US','+18884200006','','','','US','+12120000000','NEW YORK','NY','10279','US',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 21:19:05',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(172,'replaceme',NULL,'in-progress','outbound-api',NULL,NULL,'CA046593722f1d4d719d77fd0b8039e6e6','client:1',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,'client:1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2012-01-31 21:21:16',NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `tracker_calls` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tracker_sms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tracker_sms`;

CREATE TABLE `tracker_sms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `AccountSid` varchar(128) DEFAULT NULL,
  `ApplicationSid` varchar(128) DEFAULT NULL,
  `SmsSid` varchar(128) DEFAULT NULL,
  `SmsMessageSid` varchar(128) DEFAULT NULL,
  `SmsStatus` varchar(20) DEFAULT NULL,
  `Direction` varchar(20) DEFAULT NULL,
  `Body` varchar(5000) DEFAULT NULL,
  `To` varchar(32) DEFAULT NULL,
  `ToCity` varchar(50) DEFAULT NULL,
  `ToState` varchar(50) DEFAULT NULL,
  `ToZip` varchar(50) DEFAULT NULL,
  `ToCountry` varchar(50) DEFAULT NULL,
  `From` varchar(32) DEFAULT NULL,
  `FromCity` varchar(50) DEFAULT NULL,
  `FromState` varchar(50) DEFAULT NULL,
  `FromZip` varchar(50) DEFAULT NULL,
  `FromCountry` varchar(50) DEFAULT NULL,
  `ErrorCode` int(5) DEFAULT NULL,
  `ErrorUrl` varchar(1000) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `LastUpdated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `vbxsite` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `AccountSid` (`AccountSid`),
  KEY `SmsSid` (`SmsSid`),
  KEY `ApplicationSid` (`ApplicationSid`),
  KEY `SmsMessageSid` (`SmsMessageSid`),
  KEY `To` (`To`),
  KEY `From` (`From`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user_annotations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_annotations`;

CREATE TABLE `user_annotations` (
  `user_id` int(11) NOT NULL,
  `annotation_id` bigint(20) NOT NULL,
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`user_id`,`annotation_id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `user_annotations_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_messages`;

CREATE TABLE `user_messages` (
  `user_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `tenant_id` bigint(20) NOT NULL,
  PRIMARY KEY (`user_id`,`message_id`),
  KEY `tenant_id` (`tenant_id`),
  KEY `message_id` (`message_id`),
  CONSTRAINT `user_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `user_messages_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`),
  CONSTRAINT `user_messages_ibfk_3` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_messages` WRITE;
/*!40000 ALTER TABLE `user_messages` DISABLE KEYS */;

INSERT INTO `user_messages` (`user_id`, `message_id`, `tenant_id`)
VALUES
	(1,3,1),
	(1,4,1),
	(1,5,1);

/*!40000 ALTER TABLE `user_messages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_settings`;

CREATE TABLE `user_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` text,
  `tenant_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_key` (`user_id`,`key`),
  KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_settings` WRITE;
/*!40000 ALTER TABLE `user_settings` DISABLE KEYS */;

INSERT INTO `user_settings` (`id`, `user_id`, `key`, `value`, `tenant_id`)
VALUES
	(3,1,'online','1',1),
	(4,1,'last_login','2012-02-01 02:15:43',1),
	(5,1,'last_seen','2012-02-01 02:25:22',1),
	(6,1,'browserphone_caller_id','(888) 420-0006',1),
	(7,1,'browserphone_call_using','browser',1),
	(8,2,'online','9',1),
	(9,2,'last_login','2012-01-08 15:27:30',1),
	(10,2,'last_seen','2012-01-08 16:12:17',1),
	(11,3,'online','9',1);

/*!40000 ALTER TABLE `user_settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_admin` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `invite_code` varchar(32) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `pin` varchar(40) DEFAULT NULL,
  `notification` varchar(20) DEFAULT NULL,
  `auth_type` tinyint(4) NOT NULL DEFAULT '1',
  `voicemail` text NOT NULL,
  `tenant_id` bigint(20) NOT NULL,
  `twilioaccount` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`,`tenant_id`),
  KEY `tenant_id` (`tenant_id`),
  KEY `auth_type` (`auth_type`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`auth_type`) REFERENCES `auth_types` (`id`),
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `is_admin`, `is_active`, `first_name`, `last_name`, `password`, `invite_code`, `email`, `pin`, `notification`, `auth_type`, `voicemail`, `tenant_id`, `twilioaccount`)
VALUES
	(1,1,1,'John','Smith','$2a$08$yMTxlT0DgRdj/O8kXi2z7eqXOgJBz3mDyMvbpenNFI9lJAI54kUZO','JDJhJDA4JHNadE5MdHIw','beta@igrou.ps',NULL,NULL,1,'Please leave a message after the beep.',1,'askjdfu32hgweuskhfasdf'),
	(2,0,0,'John','Smith','$2a$08$OrACzY6CB0pGocjt67VlCe.zyRHv6ncH/ZCtCA2ga5wBJa3GxJcrO','JDJhJDA4JDRCSFBBT21y','beta2@igrou.ps',NULL,NULL,1,'Please leave a message after the beep.',1,NULL),
	(3,1,1,'John','Smith',NULL,'JDJhJDA4JEQ3OE9GR2c2','test@dasgsdf.com',NULL,NULL,1,'',1,NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
