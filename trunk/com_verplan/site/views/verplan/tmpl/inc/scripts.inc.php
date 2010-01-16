<?php
/**
 * in dieser php datei stehen alle includes für alle
 * css stylesheets und javascriptdateien
 *
 * die reihenfolge ist oft wichtig, da einige scrite von
 * anderen abhängen
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 07-Dec-2009
 */


$document =& JFactory::getDocument();

//haupturl für includes
//$baseurl = JURI::root(true).'/components/com_verplan/';
$baseurl = JURI::base().'components/com_verplan/';

/*
 * css
 */
$document->addStylesheet($baseurl.'includes/css/general.css');
$document->addStylesheet($baseurl.'includes/css/table.css');
$document->addStylesheet($baseurl.'includes/css/jquery.kiketable.colsizable.css');
$document->addStylesheet($baseurl.'includes/css/ui.selectmenu.css');
$document->addStylesheet($baseurl.'includes/css/prettyPhoto.css');
$document->addStylesheet($baseurl.'includes/css/jquery.pnotify.default.css');
$document->addStylesheet($baseurl.'includes/css/jquery.clearableTextField.css');

$document->addStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/themes/ui-darkness/jquery-ui.css');

/*
 * scripts
 */

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
$document->addScript($baseurl.'includes/js/plugins/jquery.tablesorter.min.js');
//$document->addScript($baseurl.'includes/js/plugins/jquery.columnfilters.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.uitablefilter.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.colorize-2.0.0.js');
//$document->addScript($baseurl.'includes/js/plugins/jquery.kiketable.colsizable-1.1.js');
//$document->addScript($baseurl.'includes/js/plugins/jquery.event.drag-1.4.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.qtip-1.0.0-rc3.js');
$document->addScript($baseurl.'includes/js/plugins/ui.selectmenu.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.history.js');
$document->addScript($baseurl.'includes/js/plugins/themeswitchertool.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.prettyPhoto.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.pnotify.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.clearableTextField.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.cookie.js');

//$document->addScript('http://www.google.com/jsapi');
//$document->addScript($baseurl.'includes/js/googletable.js');
//$document->addCustomTag( "<script type=\"text/javascript\">google.load('visualization', '1', {packages: ['table']});</script>" );
//$document->addScript($baseurl.'includes/dataTables-1.5/media/js/jQuery.dataTables.js');

$min = false;

//einstellungen
$document->addScript($baseurl.'includes/js/ajax.js.php?url='.JURI::root());
$document->addScript($baseurl.'includes/js/settings.js');

//schripts, die php beinhalten
$document->addScript($baseurl.'includes/js/ajax.js.php?url='.JURI::root());
/*$document->addScript($baseurl.'includes/js/colname.js.php?col='.$this->classname);
$document->addScript($baseurl.'includes/js/varname.js.php?var='.$this->varname);
$document->addScript($baseurl.'includes/js/debug.js.php?debug='.$this->debugmode);
$document->addScript($baseurl.'includes/js/notify.js.php?notify='.$this->notify);
//$document->addScript($baseurl.'includes/js/message.js.php?message='.$this->message.'&message_title='.$this->message_title);
*/

if ($min) {
	$document->addScript($baseurl.'includes/js/final-min.js');
}

//eigene scripts
if (!$min) {
	$document->addScript($baseurl.'includes/js/filters.js');
	$document->addScript($baseurl.'includes/js/tableplugins.js');
	$document->addScript($baseurl.'includes/js/hide_options.js');
	$document->addScript($baseurl.'includes/js/boxes.js');
	$document->addScript($baseurl.'includes/js/general.js');
	$document->addScript($baseurl.'includes/js/ajaxjson.js'); //ajax nach gereral, da hash
	$document->addScript($baseurl.'includes/js/ajaxeffects.js');
	$document->addScript($baseurl.'includes/js/ui.js'); //ui muss nach general, da select in general gesetzt
	$document->addScript($baseurl.'includes/js/tooltips.js');
}