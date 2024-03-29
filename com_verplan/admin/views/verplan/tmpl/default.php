<?php
/**
 * tempalte des admin backends
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 14-Sep-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

$document =& JFactory::getDocument();

$baseurl = JURI::base().'components/com_verplan/';

//jQuery support
$settings = $this->settings;
if ($settings['load_jquery_backend']['value'] == 'true') {
	$document->addScript($baseurl.'includes/js/jquery-1.4.2.min.js');
}

//no conflict mode für jQuery (http://docs.jquery.com/Using_jQuery_with_Other_Libraries)
$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );

//jQuery UI support
if ($settings['load_jqueryui_backend']['value'] == 'true') {
	//ACHTUNG! jQueryUI ist nicht vollständig
	$document->addScript($baseurl.'includes/js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js');
	$document->addScript($baseurl.'includes/js/jquery-ui/js/jquery.ui.datepicker-de.js');
	$document->addStylesheet($baseurl.'includes/js/jquery-ui/css/ui-darkness/jquery-ui-1.8rc2.css');
}

//stylesheets
$document->addStylesheet($baseurl.'includes/css/general.css');

//Plugins
$document->addScript($baseurl.'includes/js/plugins/jquery.timePicker.js');

//Javascript
$document->addScript($baseurl.'includes/js/hide_admin.js');
$document->addScript($baseurl.'includes/js/datepicker.js');

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

<div id="header_verplan" class="ui-helper-clearfix panel">
	<a href="<?php echo JURI::base() ?>index.php?option=com_verplan"><img alt="logo vertretungsplan" style="width: 152" src="<?php echo JURI::base();?>../components/com_verplan/includes/images/logo/logo_final_11_32.png" id="logo_verplan"/></a>
	<a href="http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Backend" target="_blank" id="help_head"><img alt="Benutzerhandbuch" src="<?php echo JURI::base();?>../components/com_verplan/includes/images/help_contents_32.png"></a>
	<p> 
		Informationen: <a href="http://code.google.com/p/verplan/">http://code.google.com/p/verplan/</a>. 
		Bitte sende Dein <a id="feedy" title="Feedbackbogen" href="http://spreadsheets.google.com/viewform?formkey=dGdDanZxa2k4RHhKbHJaS1RxT0Q2eWc6MA">Feedback</a>!
		<br>Version: <?php echo $version;?><br>
		Zur <a target="_blank" href="../index.php?option=com_verplan" target="_blank">Frontpage</a>
	</p>
	
	<br>
</div>

<form id="form_verplan" name="upload" method="post" enctype="multipart/form-data" action="index.php?option=com_verplan">
<table class="admin_table">
	<tbody>
		<tr>
			<td class="key"><label for="file">Datei</label></td>
			<td colspan="2">
				<input size="40" type="file" id="file" name="file" class="inputbox" />
			</td>
		</tr>
		<tr>
			<th colspan="3"><br>Optional</th>
		</tr>
		<tr>
			<td class="key"><label for="date">Geltungsdatum</label></td>
			<td  colspan="2">
				<input size="40" type="date" id="datepicker_date" name="date" class="inputbox" />
			</td>
		</tr>
		<tr>
			<td class="key"><label for="stand">Stand</label></td>
			<td>
				<?php 
					$time = date('H:i');						
					$date = date('Y-m-d');
				?>
				<input size="40" type="date" id="datepicker_stand" name="stand" value="<?php echo $date; ?>"/>
				<input size="40" type="time" id="datepicker_stand_time" name="stand_time" value="<?php echo $time; ?>" />
			</td>
			<!-- <td>
				<input size="40" type="stand_time" id="datepicker_stand_time" name="stand" class="inputbox" /><br>
			</td> -->
		</tr>
	</tbody>
</table>
	
<br>
<input type="submit" name="upload" class="uploadbutton" value="Abschicken" id="send" />

<!-- sollen fehler in den regulaeren ausdrücken ignoriert werden? (empfohlen) --> 
<input type="hidden" name="ignore" value="true" /> 

<!-- damit die Komponente wieder aufgerufen wird --> 
<input type="hidden" name="option" value="com_verplan" /> 
<!-- task laden (in verplanControllrupload -->
<input type="hidden" name="task" value="send" />
<input type="hidden" name="boxchecked" value="0" />
<!-- richtiger Controller --> 
<input type="hidden" name="controller" value="send" /> 
<!-- debug -->
<input type="hidden" name="debug" value="<?php echo JRequest::getVar('debug', false)?>" />

</form>


<br><br>
<a href="#clean_header" id="clean_header" class="expander plus">Datenbank bereinigen</a>
<div id="admin_clean_div" class="verschwinder">
	<br>
	<form id="form_clean" name="form_clean" method="post" enctype="multipart/form-data"	action="index.php?option=com_verplan">
	
			<label for="keep">Anzahl der Einträge, die erhalten bleiben sollen</label>
			<input type="text" name="keep" value="10" /><br>

			<input type="submit" name="clean" value="Datenbank bereinigen"/>
		
			<!-- damit die Komponente wieder aufgerufen wird --> 
			<input type="hidden" name="option" value="com_verplan" /> 
			<!-- task laden (in verplanControllrupload -->
			<input type="hidden" name="task" value="clean" />
			<input type="hidden" name="boxchecked" value="0" />
			<!-- richtiger Controller --> 
			<input type="hidden" name="controller" value="clean" /> 
			<!-- debug -->
			<input type="hidden" name="debug" value="<?php echo JRequest::getVar('debug', false)?>" />
	</form>
	<br>
</div>



<?php 
/*
//anzeige ohne template (praktisch für ajax)
$mainframe =& JFactory::getApplication('site'); 
$mainframe->close();
*/
?>