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

<h2>Upload</h2>

<dl id="system-message" class="ajaxresmess_0">
		<dt class="message">Message</dt>
		<dd class="message message fade">
		<ul>
			<li id="ajaxresponse_0"></li>
		</ul>
		</dd>
	</dl>

<!-- bitte auf post lassen, da es sonst probleme mit doppelten "option" werten gibt-->
<form id="form_verplan" name="upload" method="post" enctype="multipart/form-data"	action="index.php?option=com_verplan">
	
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
					<input size="40" type="text" id="datepicker_date" name="date" class="inputbox" />
				</td>
			</tr>
			<tr>
				<td class="key"><label for="stand">Stand</label></td>
				<td>
					<input size="40" type="text" id="datepicker_stand" name="stand" />
					<input size="40" type="text" id="datepicker_stand_time" name="stand_time" />
				</td>
				<!-- <td>
					<input size="40" type="stand_time" id="datepicker_stand_time" name="stand" class="inputbox" /><br>
				</td> -->
			</tr>
		</tbody>
	</table>
	
	<br>
	<input type="submit" name="upload" class="uploadbutton" value="Abschicken" id="send" />
	
	<h3 id="options_header" class="expander plus">Optionen</h3>
	<div id="admin_options_div">
		<table class="admin_table">
		<tbody>
			<!-- anzeige ohne template (praktisch für ajax) -->
			<!--<input type="hidden" name="tmpl" value="component" />-->
			
			<tr>
			<!-- soll das ergebnis ohne template angezeigt werden? (für ajax)-->
			<td><label for="ajax">ajax </label></td>
			<td><select id="select_ajax" name="ajax">
				<option>true</option>
				<option>false</option>
			</select></td>
			<!-- <input type="hidden" name="ajax" value="false" /> -->
			</tr>
			
			<tr>
			<!-- soll das ergebnis ohne template angezeigt werden? (für ajax)-->
			<td><label for="debug">debug </label></td>
			<td><select id="select_debug" name="debug">
				<option>false</option>
				<option>true</option>
			</select>
			</tr></td>
				
			<!-- sollen fehler in den regulaeren ausdrücken ignoriert werden? (empfohlen) --> 
			<input type="hidden" name="ignore" value="true" /> 
		
			<!-- damit die Komponente wieder aufgerufen wird --> 
			<input type="hidden" name="option" value="com_verplan" /> 
			<!-- task laden (in verplanControllrupload -->
			<input type="hidden" name="task" value="send" />
			<input type="hidden" name="boxchecked" value="0" />
			<!-- richtiger Controller --> 
			<input type="hidden" name="controller" value="send" /> 
			<!-- die user ID (unnötig) -->
			<input type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
		</tbody>
		</table>
	</div>

</form>

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