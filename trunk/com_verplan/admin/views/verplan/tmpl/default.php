<?php
/**
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
$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js');
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

//Plugins
/*http://milesich.com/timepicker/*/
$document->addScript('components/com_verplan/includes/js/plugins/timepicker.js');
/*http://stackoverflow.com/questions/1028409/jquery-datepicker-and-timepicker-for-same-input-field-to-popup-one-after-another*/
//$document->addScript('components/com_verplan/includes/js/plugins/ui.datetimepicker.js');
/*http://haineault.com/media/jquery/ui-timepickr/page/*/
//$document->addScript('components/com_verplan/includes/js/plugins/km.timepicker.js');
$document->addScript('components/com_verplan/includes/js/plugins/jquery.form.js');

/*http://haineault.com/media/jquery/ui-timepickr/page/*/
$document->addScript('components/com_verplan/includes/js/plugins/jquery.timepickr.js');
$document->addStylesheet('components/com_verplan/includes/css/ui.timepickr.css');
?>

<h1>Vertretungsplan</h1>

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