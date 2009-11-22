<?php
/**
 * tempalte des admin backends
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 14-Sep-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

$document =& JFactory::getDocument();

//jQuery support
$settings = $this->settings;
if ($settings['load_jquery'][value] == 'true') {
	$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js');
}

$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/jquery-ui.min.js');
$document->addScript('http://jqueryui.com/ui/i18n/ui.datepicker-de.js');

//stylesheets
$document->addStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-darkness/jquery-ui.css');
$document->addStylesheet('components/com_verplan/includes/css/general.css');

//no conflict mode für jQuery (http://docs.jquery.com/Using_jQuery_with_Other_Libraries)
//$document->addCustomTag( '<script type="text/javascript">var jQuery = jQuery.noConflict();</script>' );

//Javascript
$document->addScript('components/com_verplan/includes/js/hide_admin.js');
$document->addScript('components/com_verplan/includes/js/form.js');
$document->addScript('components/com_verplan/includes/js/jquery.datepicker.js');
$document->addScript('components/com_verplan/includes/js/tables.js');

//Plugins
/*http://milesich.com/timepicker/*/
$document->addScript('components/com_verplan/includes/js/plugins/timepicker.js');
/*http://stackoverflow.com/questions/1028409/jquery-datepicker-and-timepicker-for-same-input-field-to-popup-one-after-another*/
//$document->addScript('components/com_verplan/includes/js/plugins/ui.datetimepicker.js');
/*http://haineault.com/media/jquery/ui-timepickr/page/*/
//$document->addScript('components/com_verplan/includes/js/plugins/km.timepicker.js');
$document->addScript('components/com_verplan/includes/js/plugins/jquery.form.js');
$document->addScript('components/com_verplan/includes/js/plugins/jquery.tablesorter.js');

/*http://haineault.com/media/jquery/ui-timepickr/page/*/
$document->addScript('components/com_verplan/includes/js/plugins/jquery.timepickr.js');
$document->addStylesheet('components/com_verplan/includes/css/ui.timepickr.css');
?>


<?php 

//JToolBarHelper::preferences( 'com_verplan' );

?>

<?php 
//get settings
$settings = $this->settings;
//get version
$version = $settings[version]['default'];
?>

<div>
	<img alt="logo vertretungsplan" src="<?php echo JURI::base();?>../components/com_verplan/includes/images/logo_preview_32.png" id="logo_verplan"/>
	<p style="">
		Dies ist eine Vorschauversion der neuen Vertretungsplankomponente. 
		Weitere Informationen: <a href="http://code.google.com/p/verplan/">http://code.google.com/p/verplan/</a>. 
		Bitte sende dein <a id="feedy" title="Feedbackbogen" rel="prettyPhoto[iframes]" href="http://spreadsheets.google.com/viewform?formkey=dGdDanZxa2k4RHhKbHJaS1RxT0Q2eWc6MA">Feedback</a>!
		Version: <?php echo $version;?>
	</p>
	<br>
</div>

<p><?php echo $this->description?></p>

<p><?php echo $this->link; ?></p>

<?php require_once('inc/upload.php');?>

<?php require_once('inc/settings.php');?>

<?php require_once('inc/columns.php');?>

<?php require_once('inc/about.php');?>


<?php 
/*
 * Update der versionsnummer, falls diese nicht bei der isntallation erkannt wurde
 */

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
?>


<?php 
/*
//anzeige ohne template (praktisch für ajax)
$mainframe =& JFactory::getApplication('site'); 
$mainframe->close();
*/
?>