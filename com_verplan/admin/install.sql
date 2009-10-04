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
`Geltungsdatum` TIMESTAMP NOT NULL,
`Stand` TIMESTAMP NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_bin;



DROP TABLE IF EXISTS `#__com_verplan_columns`;

CREATE TABLE `#__com_verplan_columns` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` TEXT NOT NULL ,
`order_number` INT NOT NULL DEFAULT '9999',
`show` BOOL NULL DEFAULT '0',
`sort_order` INT NULL ,
`alternative_name` TEXT NULL,
`editable` BOOL NOT NULL DEFAULT '1'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_bin;

INSERT INTO `#__com_verplan_columns` (
`name` ,
`order_number` ,
`show` ,
`alternative_name`,
`editable`
)
VALUES ('Geltungsdatum','0','1','Datum','1'),('Stand','0','1','Stand','1');
