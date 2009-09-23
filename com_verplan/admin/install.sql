DROP TABLE IF EXISTS `#__com_verplan_settings`;

CREATE TABLE `#__com_verplan_settings` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'primary key',
`key` TEXT NOT NULL COMMENT 'name of option',
`value` TEXT NOT NULL COMMENT 'value',
`editable` BOOL NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 
INSERT INTO `#__com_verplan_settings` (
`id` ,
`key` ,
`value` ,
`editable`
)
VALUES (NULL , 'max_file_size', '2000', '1'),
(NULL , 'allowed_filetypes', 'html,htm,gif,jpg,png,pdf', '1');
