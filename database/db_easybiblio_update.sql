SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET names utf8;

ALTER TABLE TB_BOOK ADD `lost` TINYINT(1) NOT NULL DEFAULT 0;
ALTER TABLE TB_BOOK ADD `lost_by_username` VARCHAR(30) NULL;
ALTER TABLE TB_BOOK ADD `lost_timestamp` DATETIME NULL;
ALTER TABLE TB_ABOUT ADD `site_max_lent_books` TINYINT(1) NOT NULL DEFAULT 2;
ALTER TABLE TB_PERSON ADD `active` BOOLEAN DEFAULT false;

---
--- Table 'tb_audit'
---
CREATE TABLE IF NOT EXISTS `tb_audit` (
  `id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(30) NULL,
  `timestamp` DATETIME NULL,
  `operation` VARCHAR(30) NULL,
  `details` LONGTEXT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB DEFAULT CHARSET=latin1;