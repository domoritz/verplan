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
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_bin;

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
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'primary key',
`name` TEXT NOT NULL COMMENT 'key',
`value` TEXT NOT NULL COMMENT 'value',
`default` TEXT NOT NULL COMMENT 'default value',
`de` TEXT NOT NULL COMMENT 'description'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `#__com_verplan_settings` (
`id` ,
`name` ,
`value` ,
`default`, 
`de`
)
VALUES
('1' , 'version', '', '','nicht verändern'),
('2' , 'max_file_size', '2097152', '2097152','maximale Dateigröße'),
('3' , 'allowed_filetypes', 'html,htm,gif,jpg,png,pdf,doc,odf,xls', 'html,htm,gif,jpg,png,pdf,doc,odf,xls','erlaubte Dateitypen'),
('4' , 'pattern_stand', '/Stand:.*:[0-5][0-9]/U', '/Stand:.*:[0-5][0-9]/U','Pattern Stand'),
('5' , 'format_stand', 'd.m.Y H:i', 'd.m.Y H:i','Format Stand'),
('6' , 'pattern_date', '//div[@class=\'mon_title\']', '//div[@class=\'mon_title\']','Pattern Geltungsdatum'),
('7' , 'format_date', 'j.n.Y w', 'j.n.Y w','Format Geltungsdatum'),
('8' , 'pattern_plan', '//table[@class=\'mon_list\']', '//table[@class=\'mon_list\']','Pattern'),
('9' , 'upload_dir_comp', 'uploads', 'uploads','Verzeichnis auf dem Server in der Komponente'),
('10' , 'upload_dir', '/components/com_verplan/uploads/', '/components/com_verplan/uploads/','Verzeichnis der Vertrtungsplandateien'),
('11' , 'number_show', '5', '5','Anzahl der anzuzeigenden Daten. Daten in der Zukunft werden immer zusätztlich angezeigt.'),
('12' , 'load_jquery_frontend', 'true', 'true','jQuery laden (Frontend)'),
('13' , 'load_jquery_backend', 'true', 'true','jQuery laden (Backend)'),
('14' , 'load_jqueryui_frontend', 'true', 'true','jQueryUI laden (Frontend)'),
('15' , 'load_jqueryui_backend', 'true', 'true','jQueryUI laden (Backend)'),
('16' , 'debug', 'false', 'false','Debug Mode für JS'),
('17' , 'class_col', '(Klasse(n))', '(Klasse(n))','Spaltenname der Klassenspalte'),
('18' , 'class_name', '(Klasse(n))', '(Klasse(n))','Variablenname der Klassenspalte in JSON'),
('19' , 'notify', 'own', 'own', 'Notificationsystem: own, pnotify oder both'),
('20' , 'head_text', 'Dies ist eine Vorschauversion der neuen Vertretungsplankomponente. Weitere Informationen: <a href="http://verplan.googlecode.com" target="_blank" id="link_project" title="Projektseite">verplan.googlecode.com</a>. Bitte sende dein <a id="feedy" title="Feedbackbogen" rel="prettyPhoto[iframes]" href="http://spreadsheets.google.com/viewform?formkey=dGdDanZxa2k4RHhKbHJaS1RxT0Q2eWc6MA&iframe=true&width=90%&height=100%">Feedback</a>!', '', 'Text, der im Frontend erscheint'),
('21' , 'message_title', 'Vorabversion', '', 'Überschrift der Benachrichtigung im Frontend. Nur mit pnotify (leer lassen für keine)'),
('22' , 'message', 'Hey, du benutzt eine <strong>Vorabversion</strong>. Damit Fehler behoben werden und das Programm verbessert wird, gib bitte dein <a href="http://spreadsheets.google.com/viewform?formkey=dGdDanZxa2k4RHhKbHJaS1RxT0Q2eWc6MA>"<strong>Feedback</strong></a> ab. Jedes einzelne ist wichtig für mich. Vielen Dank und viel Spaß', '', 'Benachrichtigung');
