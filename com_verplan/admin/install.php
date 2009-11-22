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

	//echo '<pre>';
	//version aus xml laden
	$path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_verplan'.DS.'com_verplan.xml';
	//echo $path;
	$dataxml = JApplicationHelper::parseXMLInstallFile($path);
	//var_dump($data);
	//echo $data[version];

	//daten für jtable
	$data = array(
		'id' => 14,
		'name' => 'version',
		'value' => $dataxml[version],
		'default' => $dataxml[version],
	);

	//var_dump($data);

	//jtable laden
	JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_verplan'.DS.'tables');
	$table = JTable::getInstance('settings', 'Table');

	//var_dump($table);

	if (!$table->save($data)){
		JError::raiseWarning( 500, $table->getError() );
	}

	//var_dump($table);
	//echo '</pre>';

	echo "<!--";
	echo JURI::base()."\n";
	echo JURI::base(true)."\n";
	echo JURI::root()."\n";
	echo JPATH_COMPONENT."\n";
	echo JPATH_BASE."\n";
	echo "-->";

	?>


<h1>Installation der Vertretungsplan Webapplication</h1>

	<?php
	//http://docs.joomla.org/JDatabase
	$db =& JFactory::getDBO();
	//echo "Database prefix is : " . $db->getPrefix();
	?>

<p>Falls die Komponente schon einmal installiert war, wurden die alten
Daten (bis auf die Einstellungen, diese wurden auf den Ursprungszustand
zurückgesetzt) übernommen. Sollte es zu Fehlern bei der Installation
gekommen sein, entferne bitte alle Tabellen mit, die mit '<?php echo $db->getPrefix();?>com_verplan'
beginnen aus der Datenbank und versuche die Instrallation danach erneut.</p>

<p>Direkt zum <a
	href="<?php echo JURI::base();?>index.php?option=com_verplan">Adminbereich</a>
</p>
<p>Direkt zum <a
	href="<?php echo JURI::root();?>index.php?option=com_verplan">Frontend</a>
</p>

<p>Wenn du alle Daten und Datenbankeinträge entfernen oder neu
installieren möchtest, solltest du kein Update durchführen, sondern die
Komponente deinstalliern und danach neu installieren. Beim
Deinstallieren werden <strong>alle</strong> Daten der Komponente
entfernt. Beim Upgrade (Neuinstallation ohne vorherige Deinstallation)
bleiben die Datenbankeinträge erhalten.</p>

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
	<?php
	//http://docs.joomla.org/JDatabase
	$db =& JFactory::getDBO();
	//echo "Database prefix is : " . $db->getPrefix();
	?>
<p>Du hast dich entschlossen, die Komponente com_verplan zu entfernen.
Dabei wurden alle Einträge aus der Datenbank und alle Dateien entfernt.
Falls du dies beim nächsten Mal nicht möchtest, solltest du eine
Instaaltion ohne vorherige Deinstallation (Upgrade) durchführen.</p>


	<?php
}
