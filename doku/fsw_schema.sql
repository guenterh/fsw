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


USE `histsem`;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fsw_kolloquium`
--

DROP TABLE IF EXISTS `fsw_kolloquium`;
CREATE TABLE IF NOT EXISTS `fsw_kolloquium` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_kolloquium` bigint(20) NOT NULL,
  `titel` varchar(65000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fsw_kolloquium_veranstaltung`
--
-- mit Manuela genauer anschauen!
-- es fehlt noch
-- Personenbeschreibung, Personenlink, Nachname / Vorname getrennt, Institution, Institutionenlink, Beschriebung (hier ist im Moment die ganze Struktur eingetragen)
-- weiterhin sollte noch die Möglichkeit gegeben werden, mehere Personen als Vortragende auftreten zu lassen
-- neu könnte die Möglochkeit geschaffen werden, Personen mit link auf das Profil auf die Webseite zu setzen.

DROP TABLE IF EXISTS `fsw_kolloquium_veranstaltung`;
CREATE TABLE IF NOT EXISTS `fsw_kolloquium_veranstaltung` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_kolloquium` bigint(20) NOT NULL,
  `datum` date NOT NULL,
  `personenname` varchar(65000) NOT NULL,
  `beschreibung` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------


DROP TABLE IF EXISTS `fsw_personen_extended`;
CREATE TABLE `fsw_personen_extended` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pers_id` int(11) NOT NULL,
  `profilURL` varchar(500) DEFAULT NULL,
  `fullname` varchar(500) DEFAULT NULL COMMENT 'only for better reading',

  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='FSW table: to store extended values related to persons ';



DROP TABLE IF EXISTS `fsw_zora_author`;
CREATE TABLE IF NOT EXISTS `fsw_zora_author` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fid_personen` bigint(20) NOT NULL COMMENT 'foreign key fsw_personen_extended (id)',
  `pers_id` bigint(20) DEFAULT NULL COMMENT 'only for better reading',
  `zora_name` varchar(500)  NOT NULL,
  `zora_name_customized` varchar(500)  DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fid_personen` (`fid_personen`),
  KEY `zora_name` (`zora_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



-- Tabellenstruktur für Tabelle `fsw_zora_relations_author_doc`
--  Relationentabelle zwischen Zoraautoren und Zoradokumenten

DROP TABLE IF EXISTS `fsw_relation_zora_author_zora_doc`;
CREATE TABLE IF NOT EXISTS `fsw_relation_zora_author_zora_doc` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fid_zora_author` bigint(20) NOT NULL COMMENT 'foreign key fsw_zora_author (id)',
  `fid_zora_doc` bigint(20) NOT NULL COMMENT 'foreign key fsw_zora_doc (id)',
  `zora_name` varchar(500)  DEFAULT NULL COMMENT 'only for better reading',
  `oai_identifier` varchar(100)  DEFAULT NULL COMMENT 'only for better reading',
  `zora_rolle` varchar(40)  NOT NULL COMMENT 'creator or contributor',
  PRIMARY KEY (`id`),
  KEY `oai_identifier` (`oai_identifier`),
  KEY `zorarolle` (`zora_rolle`),
  KEY `fid_personen` (`fid_zora_author`),
  KEY `fid_zora_doc` (`fid_zora_doc`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `typOAI`
--

DROP TABLE IF EXISTS `fsw_zora_doctype`;
CREATE TABLE IF NOT EXISTS `fsw_zora_doctype` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `oai_identifier` varchar(100) NOT NULL,
  `oai_recordtyp` varchar(100) NOT NULL,
  `typform` varchar(10)  NOT NULL COMMENT 'typ or subtyp',
  PRIMARY KEY (`id`),
  KEY `oaiidentier` (`oai_identifier`,`oai_recordtyp`),
  KEY `typform` (`typform`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;