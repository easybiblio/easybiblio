SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET names utf8;

DROP DATABASE IF EXISTS easybiblio;
CREATE DATABASE easybiblio DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE easybiblio;

--
-- Table structure for table `tb_book`
--

CREATE TABLE `tb_book` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `code` varchar(45) NOT NULL,
 `title` varchar(100) NOT NULL,
 `description` LONGTEXT NULL DEFAULT NULL,
 `author` varchar(100) DEFAULT NULL,
 `coauthor` varchar(100) DEFAULT NULL,
 `editor` varchar(100) DEFAULT NULL,
 `language` varchar(2) DEFAULT NULL,
 `year_publication` int(11) DEFAULT NULL,
 `category_id` int(11) DEFAULT NULL,
 `type_id` int(11) DEFAULT NULL,
 `date_creation` datetime DEFAULT NULL,
 `notes` longtext,
 `cover_url` TEXT NULL DEFAULT NULL,
 `lost` TINYINT(1) NULL DEFAULT 0,
 `lost_by_username` VARCHAR(30) NULL,
 `lost_timestamp` DATETIME NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `id_UNIQUE` (`id`),
 UNIQUE KEY `code_UNIQUE` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(45) DEFAULT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Example data for `tb_category`
--

INSERT INTO `tb_category` (`id`, `name`) VALUES
(1, 'Category 1'),
(2, 'Category 2'),
(3, 'Category 3');

-- --------------------------------------------------------

--
-- Table structure for table `tb_language`
--

CREATE TABLE `tb_language` (
 `language` varchar(2) NOT NULL,
 `language_name` varchar(45) NOT NULL,
 PRIMARY KEY (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Example data for 'tb_language'`
--

INSERT INTO `tb_language` (`language`, `language_name`) VALUES
('en', 'English'),
('fr', 'Français'),
('nl', 'Nederlands'),
('pt', 'Português'),
('xx', '---------');

-- --------------------------------------------------------

--
-- Table structure for table `tb_lend`
--

CREATE TABLE `tb_lend` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `book_id` int(11) NOT NULL,
 `person_id` int(11) NOT NULL,
 `date_lend` date NOT NULL,
 `date_return` date DEFAULT NULL,
 `notes` longtext,
 `date_creation` datetime DEFAULT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `id_UNIQUE` (`id`),
 KEY `book_idx` (`book_id`),
 KEY `person_idx` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_person`
--

CREATE TABLE `tb_person` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(120) NOT NULL,
 `address` varchar(120) DEFAULT NULL,
 `zipcode` varchar(10) DEFAULT NULL,
 `city` varchar(45) DEFAULT NULL,
 `phone1` varchar(45) DEFAULT NULL,
 `phone2` varchar(45) DEFAULT NULL,
 `email` varchar(100) DEFAULT NULL,
 `notes` longtext,
 `active` BOOLEAN DEFAULT false,
 `date_creation` datetime DEFAULT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `id_UNIQUE` (`id`),
 UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for table `tb_lend`
--
ALTER TABLE `tb_lend`
 ADD CONSTRAINT `book` FOREIGN KEY (`book_id`) REFERENCES `tb_book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
 ADD CONSTRAINT `person` FOREIGN KEY (`person_id`) REFERENCES `tb_person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;



CREATE TABLE `tb_type` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(45) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Example data for table `tb_type`
--

INSERT INTO `tb_type` (`id`, `name`) VALUES
(1, 'Book'),
(2, 'DVD'),
(3, 'CD');


CREATE TABLE `tb_user` (
  `username` VARCHAR(30) NOT NULL,
  `fullname` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  `salt` VARCHAR(64) NOT NULL,
  `usertype` INT NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `logincode` INT DEFAULT 0,
  `timestamp_logincode` datetime DEFAULT NULL,
  PRIMARY KEY (`username`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
ENGINE = InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tb_user` (`username`, `fullname`, `password`, `salt`, `usertype`) VALUES
('admin', 'Administrator', 'b4761e9dbfbbeb7d8b1abd80e2d4f904e902c6fa4c51bcc15759db80f1f60ecc', '3d358272ff5243ccf464a3cb62b7e69c9abd9a8b0fe31cfb18689a2751149c43', 9),
('operator', 'Operator', 'a23d60f965c0309d5a84102968138e10b844ec6853776763ae9f5aa543d4b67a', 'e228a4aca6adb7e20b7e0cc19287e673d93ed82e11d2e2ca91c0435c7141ff43', 7);


--
-- Table 'tb_about'
--
CREATE TABLE `tb_about` (
  `site_shortname` VARCHAR(30) NULL,
  `site_longname` VARCHAR(120) NULL,
  `site_meta_description` VARCHAR(200) NULL,
  `site_meta_keywords` VARCHAR(200) NULL,
  `site_logo_url` TEXT NULL,
  `site_welcome` LONGTEXT NULL,
  `site_max_lent_books` TINYINT(1) NOT NULL DEFAULT 2)
ENGINE = InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tb_about`(`site_shortname`, `site_longname`, `site_meta_description`, `site_meta_keywords`, `site_logo_url`, `site_welcome`) VALUES ('EasyBiblio','EasyBiblio - A Book Lending System made easy.','EasyBiblio - A Book Lending System made easy.','easybiblio',null,'<h1>Welcome to EasyBiblio Installation</h1>Put here custom information about your library (address, opening hours, rules for renting books, etc).');

--
-- Table 'tb_audit'
--
CREATE TABLE IF NOT EXISTS `tb_audit` (
  `id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(30) NULL,
  `timestamp` DATETIME NULL,
  `operation` VARCHAR(30) NULL,
  `details` LONGTEXT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB DEFAULT CHARSET=latin1;
