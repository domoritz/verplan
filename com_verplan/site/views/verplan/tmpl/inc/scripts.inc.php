<?php
/**
 * in dieser php datei stehen alle includes für alle
 * css stylesheets und javascriptdateien
 *
 * die reihenfolge ist oft wichtig, da einige scrite von
 * anderen abhängen
 * 
 * diese datei wird in das template includiert
 * 
 * es gibt die Möglichkeit, ansatt der einzelnen scripte (eigene js)
 * nur eine einzige komprimierte (yui komprimiert) laden zu lassen
 * um die ladezeiten zu minimieren
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 07-Dec-2009
 */


$document =& JFactory::getDocument();

//haupturl für includes
//$baseurl = JURI::root(true).'/components/com_verplan/';
$baseurl = JURI::base().'components/com_verplan/';

/*
 * stylesheets
 */
$document->addStylesheet($baseurl.'includes/css/general.css');
$document->addStylesheet($baseurl.'includes/css/table.css');
//$document->addStylesheet($baseurl.'includes/css/jquery.kiketable.colsizable.css');
$document->addStylesheet($baseurl.'includes/css/ui.selectmenu.css');
$document->addStylesheet($baseurl.'includes/css/prettyPhoto.css');
$document->addStylesheet($baseurl.'includes/css/jquery.pnotify.black.css');
$document->addStylesheet($baseurl.'includes/css/jquery.clearableTextField.css');

$document->addStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/themes/ui-darkness/jquery-ui.css');

/*
 * scripts
 */

//$document->addScript('http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js');


//jQuery hinzufügen
if ($this->load_jquery == 'true') {
	$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js');
}

//no conflict mode für jQuery (http://docs.jquery.com/Using_jQuery_with_Other_Libraries)
$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );

if ($this->load_jqueryui == 'true') {
	$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/jquery-ui.min.js');
}


//plugins
$document->addScript($baseurl.'includes/js/plugins/jquery.history.min.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.cookie.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.tablesorter.min.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.uitablefilter.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.colorize-2.0.0.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.qtip-1.0.0-rc3.min.js');
$document->addScript($baseurl.'includes/js/plugins/ui.selectmenu.js');
$document->addScript($baseurl.'includes/js/plugins/themeswitchertool.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.prettyPhoto.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.pnotify.min.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.clearableTextField.js');

$min = false;

//eigene scripts

//einstellungen laden (ist ein extra view)
$document->addScript(JURI::root().'?option=com_verplan&view=settings&format=js');
	
if (!$min) {
	//debug
	$document->addScript($baseurl.'includes/js/debug.js');

	//andere scripts
	$document->addScript($baseurl.'includes/js/filters.js');
	$document->addScript($baseurl.'includes/js/tableplugins.js');
	$document->addScript($baseurl.'includes/js/hide_options.js');
	$document->addScript($baseurl.'includes/js/boxes.js');
	$document->addScript($baseurl.'includes/js/general.js');
	$document->addScript($baseurl.'includes/js/ajaxjson.js'); //ajax nach general, da hash
	$document->addScript($baseurl.'includes/js/ajaxeffects.js');
	$document->addScript($baseurl.'includes/js/ui.js'); //ui muss nach general, da select in general gesetzt
	$document->addScript($baseurl.'includes/js/tooltips.js');
} else {
	$document->addScript($baseurl.'includes/js/final-min.js');
}