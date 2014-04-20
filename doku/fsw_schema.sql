-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 17. Apr 2014 um 15:07
-- Server Version: 5.5.35
-- PHP-Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

DROP DATABASE IF EXISTS `fswng`;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `fswng` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `fswng`;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fsw_kolloquium`
--

DROP TABLE IF EXISTS `fsw_kolloquium`;
CREATE TABLE IF NOT EXISTS `fsw_kolloquium` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titel` varchar(65000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1016 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fsw_kolloquium_veranstaltung`
--

DROP TABLE IF EXISTS `fsw_kolloquium_veranstaltung`;
CREATE TABLE IF NOT EXISTS `fsw_kolloquium_veranstaltung` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_kolloquium` bigint(20) NOT NULL,
  `datum` date NOT NULL,
  `personenname` varchar(65000) NOT NULL,
  `beschreibung` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1016 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `medien`
--

DROP TABLE IF EXISTS `fsw_medien`;
CREATE TABLE IF NOT EXISTS `fsw_medien` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mit_id_per_extended` int(11) NOT NULL,
  `sendetitel` varchar(1000) DEFAULT NULL,
  `gespraechstitel` varchar(1000) DEFAULT NULL,
  `link` varchar(1000) DEFAULT NULL,
  `icon` varchar(50) NOT NULL,
  `datum` date DEFAULT NULL,
  `medientyp` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1016 ;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fsw_cover`
--

DROP TABLE IF EXISTS `fsw_cover`;
CREATE TABLE IF NOT EXISTS `fsw_cover` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `oai_identifier` varchar(100)  NOT NULL,
  `coverlink` varchar(1000)  DEFAULT NULL,
  `frontpage` enum('frontpage','nofrontpage')  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1016 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fsw_zora_doc`
--

DROP TABLE IF EXISTS `fsw_zora_doc`;
CREATE TABLE IF NOT EXISTS `fsw_zora_doc` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `oai_identifier` varchar(100)  NOT NULL,
  `datestamp` varchar(20)  NOT NULL,
  `year` int(11) NOT NULL,
  `status` varchar(40)  NOT NULL,
  `title` varchar(255)  NOT NULL,
  `author` varchar(255)  DEFAULT NULL,
  `xmlrecord` text  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1016 ;



-- --------------------------------------------------------


DROP TABLE IF EXISTS `fsw_personen_extended`;


CREATE TABLE `fsw_personen_extended` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pers_id` int(11) NOT NULL,
  `roll_id` bigint(20) DEFAULT NULL,
  `persstatus` smallint(6) NOT NULL DEFAULT '1',
  `zora_name` varchar(500)  NOT NULL,
  `zora_name_customized` varchar(500)  DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1016 DEFAULT CHARSET=latin1 COMMENT='FSW table: to store extended values related to persons ';

--
-- Dumping data for table `FSW_Personen_Extended`
--

LOCK TABLES `fsw_personen_extended` WRITE;
/*!40000 ALTER TABLE `fsw_personen_extended` DISABLE KEYS */;
INSERT INTO `fsw_personen_extended` (`pers_id`,`persstatus`,`zora_name` ) VALUES (101,1,'Sarasin, P'),(103,1,'Tanner, J');
/*!40000 ALTER TABLE `fsw_personen_extended` ENABLE KEYS */;
UNLOCK TABLES;



-- Tabellenstruktur für Tabelle `fsw_zora_relations_author_doc`
--  Relationentabelle zwischen Zoraautoren und Zoradokumenten

DROP TABLE IF EXISTS `fsw_relation_author_zora_doc`;
CREATE TABLE IF NOT EXISTS `fsw_relation_author_zora_doc` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pers_id` bigint(20) NOT NULL,
  `oai_identifier` varchar(100)  NOT NULL,
  `zora_rolle` varchar(40)  NOT NULL,
  PRIMARY KEY (`id`),
  KEY `oai_identifier` (`oai_identifier`),
  KEY `zorarolle` (`zora_rolle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1016 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `typOAI`
--

DROP TABLE IF EXISTS `fsw_zora_doctype`;
CREATE TABLE IF NOT EXISTS `fsw_zora_doctype` (
  `oai_identifier` varchar(100) NOT NULL,
  `oai_recordtyp` varchar(100) NOT NULL,
  `typform` varchar(10)  NOT NULL COMMENT 'typ or subtyp',
  KEY `oaiidentier` (`oai_identifier`,`oai_recordtyp`),
  KEY `typform` (`typform`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;