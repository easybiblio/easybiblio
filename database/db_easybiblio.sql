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
 `id` int(10) unsigned NOT NULL,
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
