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
VALUES (NULL , 'max_file_size', '2097152', '1'),
(NULL , 'allowed_filetypes', 'html,htm,gif,jpg,png,pdf,doc,odf,xls', '1');



DROP TABLE IF EXISTS `#__com_verplan_plan`;

CREATE TABLE `#__com_verplan_plan` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'primary key',
`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'creation time',
`date` TIMESTAMP NOT NULL,
`stand` TIMESTAMP NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_bin;


DROP TABLE IF EXISTS `#__com_verplan_head`;

CREATE TABLE `#__com_verplan_head` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` TEXT NOT NULL ,
`show` BOOL NOT NULL DEFAULT '0',
`sort_order` INT NOT NULL ,
`alternative_name` INT NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_bin;
