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
CREATE DATABASE IF NOT EXISTS `CSMCaen` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `CSMCaen`;

-- Export de la structure de la table CSMCaen. Match
DROP TABLE IF EXISTS `Match`;
CREATE TABLE IF NOT EXISTS `Match` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `team` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table CSMCaen. Post
DROP TABLE IF EXISTS `Post`;
CREATE TABLE IF NOT EXISTS `Post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `content` text NOT NULL,
  `match` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Post_Match` (`match`),
  CONSTRAINT `FK_Post_Match` FOREIGN KEY (`match`) REFERENCES `Match` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table CSMCaen. Tweet
DROP TABLE IF EXISTS `Tweet`;
CREATE TABLE IF NOT EXISTS `Tweet` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `username` text NOT NULL,
  `date` date NOT NULL,
  `match` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Tweet_Match` (`match`),
  CONSTRAINT `FK_Tweet_Match` FOREIGN KEY (`match`) REFERENCES `Match` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
