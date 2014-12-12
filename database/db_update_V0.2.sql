ALTER TABLE `tb_book` ADD `cover_url` TEXT NULL DEFAULT NULL ;
ALTER TABLE `tb_book` ADD `description` LONGTEXT NULL DEFAULT NULL AFTER `title`;
ALTER TABLE `tb_book` CHANGE `num_pages` `year_publication` INT(11) NULL DEFAULT NULL;