DROP TABLE IF EXISTS `#__com_verplan_settings`;

CREATE TABLE `#__com_verplan_settings` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'primary key',
`name` TEXT NOT NULL COMMENT 'key',
`value` TEXT NOT NULL COMMENT 'value',
`editable` BOOL NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `#__com_verplan_settings` (
`id` ,
`name` ,
`value` ,
`editable`
)
VALUES (NULL , 'max_file_size', '2097152', '1'),
(NULL , 'allowed_filetypes', 'html,htm,gif,jpg,png,pdf,doc,odf,xls', '1');



DROP TABLE IF EXISTS `#__com_verplan_plan`;

CREATE TABLE `#__com_verplan_plan` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'primary key',
`id_upload` INT NOT NULL COMMENT 'primary key of uploads table'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_bin;



DROP TABLE IF EXISTS `#__com_verplan_columns`;

CREATE TABLE `#__com_verplan_columns` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` TEXT NOT NULL ,
`sort` INT NOT NULL DEFAULT '9999',
`show` BOOL NULL DEFAULT '0',
`type` TEXT NULL COMMENT 'wie soll sortiert werden',
`label` TEXT NULL COMMENT 'alternativer name',
`editable` BOOL NOT NULL DEFAULT '1'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_bin;

INSERT INTO `#__com_verplan_columns` (
`name` ,
`sort` ,
`show` ,
`label`,
`editable`
)
VALUES ('id','0','1','ID','1'),('timestamp','0','0','Timestamp','1'),('Geltungsdatum','0','1','Datum','1'),('Stand','0','1','Stand','1');


DROP TABLE IF EXISTS `#__com_verplan_uploads`;

CREATE TABLE `#__com_verplan_uploads` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`Geltungsdatum` TIMESTAMP NOT NULL ,
`Stand` TIMESTAMP NULL ,
`type` TEXT NOT NULL ,
`url` TEXT NULL
) ENGINE = MYISAM ;