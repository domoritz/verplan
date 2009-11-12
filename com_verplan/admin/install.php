<?php
/**
 * Installationsdatei. diese datei wird bei der installation/deinstallation ausgeführt.
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 06-Sep-2009
 */

defined('_JEXEC') or die('Restricted access');


/**
 * Diese Funktion wird beim Installieren ausgeführt
 * @return unknown_type
 */
function com_install() {
	?>
<h1>Installation der Vertretungsplan Webapplication</h1>
<p>Falls die Komponente schon einmal installiert war, wurden die alten
Daten (bis auf die Einstellungen, diese wurden auf den Ursprungszustand
zurückgesetzt) übernommen. Sollte es zu Fehlern bei der Installation
gekommen sein, entferne bitte alle Tabellen mit, die mit
'#__com_verplan' beginnen aus der Datenbank und versuche die
Instrallation danach erneut.</p>
	<?php
	//http://docs.joomla.org/JDatabase
	$db =& JFactory::getDBO();
	//echo "Database prefix is : " . $db->getPrefix();
	?>

<p>Um alle Daten aus Der Datenbank zu löschen, führe dieses SQL-Script
aus:</p>
<pre>
DROP TABLE IF EXISTS `<?php echo $db->getPrefix();?>com_verplan_settings`;
DROP TABLE IF EXISTS `<?php echo $db->getPrefix();?>com_verplan_plan`;
DROP TABLE IF EXISTS `<?php echo $db->getPrefix();?>com_verplan_uploads`;
DROP TABLE IF EXISTS `<?php echo $db->getPrefix();?>com_verplan_columns`;
</pre>

	<?php
}

/**
 * Diese Funktion wird beim Denstallieren ausgeführt
 * @return unknown_type
 */
function com_uninstall() {
	echo '<h1>Und tschüss</h1>';
	?>
<p>Du hast dich entschlossen, die Komponente com_verplan zu entfernen.
Bei der Installation wurden jedoch die Einträge in der Datenbank nicht
gelöscht, damit du sie bei einer erneuten Installation nicht noch einmal
eintragen musst. Solltest du diese Daten entfernen wollen, musst du nur
alle Tabellem, die mit '#__com_verplan' beginnen aus der Datenbak
entfernen.</p>

	<?php
	//http://docs.joomla.org/JDatabase
	$db =& JFactory::getDBO();
	//echo "Database prefix is : " . $db->getPrefix();
	?>

<p>Um alle Daten aus Der Datenbank zu löschen, führe dieses SQL-Script
aus:</p>
<pre>
DROP TABLE IF EXISTS `<?php echo $db->getPrefix();?>com_verplan_settings`;
DROP TABLE IF EXISTS `<?php echo $db->getPrefix();?>com_verplan_plan`;
DROP TABLE IF EXISTS `<?php echo $db->getPrefix();?>com_verplan_uploads`;
DROP TABLE IF EXISTS `<?php echo $db->getPrefix();?>com_verplan_columns`;
</pre>


	<?php
}
