-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.7.16-0ubuntu0.16.04.1 - (Ubuntu)
-- SE du serveur:                Linux
-- HeidiSQL Version:             9.4.0.5130
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour CSMCaen
DROP DATABASE IF EXISTS `CSMCaen`;
CREATE DATABASE IF NOT EXISTS `CSMCaen` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `CSMCaen`;

-- Export de la structure de la table CSMCaen. Post
DROP TABLE IF EXISTS `Post`;
CREATE TABLE IF NOT EXISTS `Post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `team` varchar(50) NOT NULL,
  `negative` double DEFAULT NULL,
  `neutral` double DEFAULT NULL,
  `positive` double DEFAULT NULL,
  `sentiment` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=925 DEFAULT CHARSET=utf8mb4;

-- Export de la structure de la table CSMCaen. Team
DROP TABLE IF EXISTS `Team`;
CREATE TABLE IF NOT EXISTS `Team` (
  `id` varchar(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Export de données de la table CSMCaen.Team : ~20 rows (environ)
DELETE FROM `Team`;
/*!40000 ALTER TABLE `Team` DISABLE KEYS */;
INSERT INTO `Team` (`id`, `name`) VALUES
	('ASM', 'Monaco'),
	('ASNL', 'AS Nancy'),
	('ASSE', 'Saint-Etienne'),
	('DFCO', 'Dijon FCO'),
	('EAG', 'Guingamp'),
	('FCGB', 'Bordeaux'),
	('FCL', 'Lorient'),
	('FCM', 'FC Metz'),
	('FCN', 'Nantes'),
	('LOSC', 'Lille'),
	('MHSC', 'Montpellier'),
	('OGCN', 'Nice'),
	('OL', 'Lyon'),
	('OM', 'Marseille'),
	('PSG', 'Paris SG'),
	('SCB', 'Bastia'),
	('SCO', 'Angers'),
	('SMC', 'SM Caen'),
	('SRFC', 'Rennes'),
	('TFC', 'Toulouse');
/*!40000 ALTER TABLE `Team` ENABLE KEYS */;

-- Export de la structure de la table CSMCaen. Tweet
DROP TABLE IF EXISTS `Tweet`;
CREATE TABLE IF NOT EXISTS `Tweet` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `team` varchar(50) NOT NULL,
  `negative` double DEFAULT NULL,
  `neutral` double DEFAULT NULL,
  `positive` double DEFAULT NULL,
  `sentiment` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=274 DEFAULT CHARSET=utf8mb4;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
