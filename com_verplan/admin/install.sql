/**
 * Installations SQL Script. Es werden nur die Tabellen ereugt, 
 * die nicht vorhanden sind und alte bleiben erhalten
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 19-Sep-2009
 */

--
-- Tabelle mit den Daten des vertretungsplanes
--


-- DROP TABLE IF EXISTS `#__com_verplan_plan`;

CREATE TABLE IF NOT EXISTS `#__com_verplan_plan` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'primary key',
`id_upload` INT NOT NULL COMMENT 'primary key of uploads table'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_bin;


--
-- Tabelle mit den Uploads
--

-- DROP TABLE IF EXISTS `#__com_verplan_uploads`;

CREATE TABLE IF NOT EXISTS `#__com_verplan_uploads` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`Geltungsdatum` TIMESTAMP NOT NULL ,
`Stand` TIMESTAMP NULL ,
`type` TEXT NOT NULL ,
`url` TEXT NULL
) ENGINE = MYISAM ;



--
-- Tabelle mit den Spalten der vertretungsplantabelle
--

-- DROP TABLE IF EXISTS `#__com_verplan_columns`;

CREATE TABLE IF NOT EXISTS `#__com_verplan_columns` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` TEXT NOT NULL ,
`ordering` INT NOT NULL comment 'sortierung',
`published` BOOL NULL DEFAULT '0',
`label` TEXT NULL COMMENT 'alternativer name'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_bin;

INSERT IGNORE `#__com_verplan_columns` (
`id` ,
`name` ,
`ordering` ,
`published` ,
`label`
)
VALUES 
('1', 'id','1','1','ID'),
('2','timestamp','2','0','Timestamp'),
('3','Geltungsdatum','3','1','Datum'),
('4','Stand','4','1','Stand');



--
-- Tabelle mit Einstellungen
--

-- DROP TABLE IF EXISTS `#__com_verplan_settings`;

CREATE TABLE IF NOT EXISTS `#__com_verplan_settings` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'primary key',
`name` TEXT NOT NULL COMMENT 'key',
`value` TEXT NOT NULL COMMENT 'value',
`default` TEXT NOT NULL COMMENT 'default value'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `#__com_verplan_settings` (
`id` ,
`name` ,
`value` ,
`default` 
)
VALUES 
('1' , 'max_file_size', '2097152', '2097152'),
('2' , 'allowed_filetypes', 'html,htm,gif,jpg,png,pdf,doc,odf,xls', 'html,htm,gif,jpg,png,pdf,doc,odf,xls'),
('3' , 'pattern_stand', '/Stand:.*:[0-5][0-9]/U', '/Stand:.*:[0-5][0-9]/U'),
('4' , 'format_stand', 'd.m.Y H:i', 'd.m.Y H:i'),
('5' , 'pattern_date', '//div[@class=\'mon_title\']', '//div[@class=\'mon_title\']'),
('6' , 'format_date', 'j.n.Y w', 'j.n.Y w'),
('7' , 'pattern_plan', '//table[@class=\'mon_list\']', '//table[@class=\'mon_list\']'),
('8' , 'upload_dir_comp', 'uploads', 'uploads'),
('9' , 'upload_dir', '/components/com_verplan/uploads/', '/components/com_verplan/uploads/'),
('10' , 'number_show', '3', '3'),
('11' , 'load_jquery', 'true', 'true');