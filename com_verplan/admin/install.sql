/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 19-Sep-2009
 */

DROP TABLE IF EXISTS `#__com_verplan_settings`;

CREATE TABLE `#__com_verplan_settings` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'primary key',
`name` TEXT NOT NULL COMMENT 'key',
`value` TEXT NOT NULL COMMENT 'value',
`default` TEXT NOT NULL COMMENT 'default value'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `#__com_verplan_settings` (
`id` ,
`name` ,
`value` ,
`default` 
)
VALUES 
(NULL , 'max_file_size', '2097152', '2097152'),
(NULL , 'allowed_filetypes', 'html,htm,gif,jpg,png,pdf,doc,odf,xls', 'html,htm,gif,jpg,png,pdf,doc,odf,xls'),
(NULL , 'pattern_stand', '/Stand:.*:[0-5][0-9]/U', '/Stand:.*:[0-5][0-9]/U'),
(NULL , 'format_stand', 'd.m.Y H:i', 'd.m.Y H:i'),
(NULL , 'pattern_date', '//div[@class=\'mon_title\']', '//div[@class=\'mon_title\']'),
(NULL , 'format_date', 'j.n.Y w', 'j.n.Y w'),
(NULL , 'pattern_plan', '//table[@class=\'mon_list\']', '//table[@class=\'mon_list\']'),
(NULL , 'upload_dir_comp', 'uploads', 'uploads'),
(NULL , 'upload_dir', '/components/com_verplan/uploads/', '/components/com_verplan/uploads/'),
(NULL , 'number_show', '3', '3');





//DROP TABLE IF EXISTS `#__com_verplan_plan`;

CREATE TABLE `#__com_verplan_plan` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'primary key',
`id_upload` INT NOT NULL COMMENT 'primary key of uploads table'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_bin;



//DROP TABLE IF EXISTS `#__com_verplan_columns`;

CREATE TABLE `#__com_verplan_columns` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` TEXT NOT NULL ,
`ordering` INT NOT NULL comment 'sortierung',
`published` BOOL NULL DEFAULT '0',
`label` TEXT NULL COMMENT 'alternativer name'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_bin;

INSERT INTO `#__com_verplan_columns` (
`name` ,
`ordering` ,
`published` ,
`label`
)
VALUES ('id','1','1','ID'),('timestamp','2','0','Timestamp'),('Geltungsdatum','3','1','Datum'),('Stand','4','1','Stand');


//DROP TABLE IF EXISTS `#__com_verplan_uploads`;

CREATE TABLE `#__com_verplan_uploads` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`Geltungsdatum` TIMESTAMP NOT NULL ,
`Stand` TIMESTAMP NULL ,
`type` TEXT NOT NULL ,
`url` TEXT NULL
) ENGINE = MYISAM ;