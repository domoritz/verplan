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
`label` TEXT NULL COMMENT 'alternativer name',
`description` TEXT NULL
) ENGINE = MYISAM CHARACTER SET utf8;

INSERT IGNORE `#__com_verplan_columns` (
`id` ,
`name` ,
`ordering` ,
`published` ,
`label`,
`description`
)
VALUES 
('1', 'id','1','1','ID','Fortlaufende Nummer'),
('2','timestamp','2','0','Timestamp','Zeit, wann der Plan eingestellt wurde'),
('3','Geltungsdatum','3','0','Datum','Datum, für das die Vertretungen gelten'),
('4','Stand','4','0','Stand','Zu diesem Zeitpunkt wurde der Vertretungsplan erstellt. In der Zwischenzeit könnte sich schon etwas geändert haben. ');



--
-- Tabelle mit Einstellungen
--

-- DROP TABLE IF EXISTS `#__com_verplan_settings`;

CREATE TABLE IF NOT EXISTS `#__com_verplan_settings` (
`id` INT NOT NULL AUTO_INCREMENT ,
`name` VARCHAR( 255 ) NOT NULL ,
`value` TEXT NOT NULL ,
`default` TEXT NULL ,
`de` TEXT NULL COMMENT 'description',
PRIMARY KEY ( `name` ) ,
UNIQUE (
`id`
)
) ENGINE = MYISAM CHARACTER SET utf8; 

INSERT IGNORE INTO `#__com_verplan_settings` (
`id`,
`name`,
`value`,
`default`, 
`de`
)
VALUES
('1', 'version', '', '','nicht verändern');

INSERT IGNORE INTO `#__com_verplan_settings` (
`name`,
`value`,
`default`, 
`de`
)
VALUES
('max_file_size', '2097152', '2097152','maximale Dateigröße'),
('allowed_filetypes', 'html,htm,gif,jpg,png,pdf,doc,odf,xls,txt', 'html,htm,gif,jpg,png,pdf,doc,odf,xls,txt','erlaubte Dateitypen'),
('pattern_stand', '/Stand:.*:[0-5][0-9]/msU', '/Stand:.*:[0-5][0-9]/msU','Pattern Stand'),
('format_stand', 'd.m.Y H:i', 'd.m.Y H:i','Format Stand'),
('pattern_date', '//div[@class=\'mon_title\']', '//div[@class=\'mon_title\']','Pattern Geltungsdatum'),
('format_date', 'j.n.Y w', 'j.n.Y w','Format Geltungsdatum'),
('pattern_plan', '//table[@class=\'mon_list\']', '//table[@class=\'mon_list\']','Pattern'),
('upload_dir_comp', '/components/com_verplan/uploads/', '/components/com_verplan/uploads/','Verzeichnis für den Upload (in Administrator)'),
('upload_dir', '/components/com_verplan/uploads/', '/components/com_verplan/uploads/','Verzeichnis der Vertretungsplandateien (in Administrator)'),
('keep_files', 'false', 'false','Dateien nach dem Parsen behalten'),
('number_show', '5', '5','Anzahl der anzuzeigenden Daten. Daten in der Zukunft werden immer zusätztlich angezeigt.'),
('public', 'true', 'true', 'Setze die Option auf false, wenn Gäste den Vertretungsplan nicht sehen dürfen'),
('load_jquery_frontend', 'true', 'true','jQuery laden (Frontend)'),
('load_jquery_backend', 'true', 'true','jQuery laden (Backend)'),
('load_jqueryui_frontend', 'true', 'true','jQueryUI laden (Frontend)'),
('load_jqueryui_backend', 'true', 'true','jQueryUI laden (Backend)'),
('class_col', 'Klasse(n)', 'Klasse(n)','Spaltenname der Klassenspalte'),
('class_name', 'Klasse(n)', 'Klasse(n)','Variablenname der Klassenspalte in JSON'),
('init_sort', '[[0,0]]', '[[0,0]]','Anfangssortierung (<a href="http://tablesorter.com/docs/example-option-sort-list.html">http://tablesorter.com/docs/example-option-sort-list.html</a>)'),
('notify', 'pnotify', 'pnotify', 'Notificationsystem: own, pnotify, both oder none'),
('head_text', 'Das hier ist die Betaversion der neuen Vertretungsplankomponente. Weitere Informationen: <a href="http://verplan.googlecode.com" target="_blank" id="link_project" title="Projektseite">verplan.googlecode.com</a>. Bitte sende dein <a id="feedy" title="Feedbackbogen" rel="prettyPhoto[iframes]" href="http://spreadsheets.google.com/viewform?formkey=dGdDanZxa2k4RHhKbHJaS1RxT0Q2eWc6MA&iframe=true&width=90%&height=100%">Feedback</a>!', '', 'Text, der im Frontend erscheint'),
('message_title', 'Betaversion', '', 'Überschrift der Benachrichtigung im Frontend. Nur mit pnotify (leer lassen für keine)'),
('message', 'Hey, du benutzt eine <strong>Betaversion</strong>. Das Programm steht kurz vor der Veröffentlichung. Bitte gib dein <a href="http://spreadsheets.google.com/viewform?formkey=dGdDanZxa2k4RHhKbHJaS1RxT0Q2eWc6MA" target="_blank"><strong>Feedback</strong></a> ab und <a href="https://spreadsheets.google.com/viewform?formkey=dEZkMjkzNVN6Nk1NQUJoZXNkTEJNamc6MA" target="_blank">melde Fehler</a>!<br> Vielen Dank und viel Spaß', '', 'Benachrichtigung');
