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
//$document->addScript('components/com_verplan/includes/js/plugins/timepicker.js');
$document->addScript('components/com_verplan/includes/js/plugins/jquery.form.js');

/*http://haineault.com/media/jquery/ui-timepickr/page/*/
//$document->addScript('components/com_verplan/includes/js/plugins/jquery.timepickr.js');
//$document->addStylesheet('components/com_verplan/includes/css/ui.timepickr.css');

$document->addScript('components/com_verplan/includes/js/plugins/jquery.timePicker.js');

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
//anzeige ohne template (praktisch für ajax)
$mainframe =& JFactory::getApplication('site'); 
$mainframe->close();
*/
?>