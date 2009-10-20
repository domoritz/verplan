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
$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js');
$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/jquery-ui.min.js');
$document->addStylesheet('components/com_verplan/includes/css/general.css');

//no conflict mode für jQuery (http://docs.jquery.com/Using_jQuery_with_Other_Libraries)
$document->addCustomTag( '<script type="text/javascript">var jQuery = jQuery.noConflict();</script>' );

//Javascript
$document->addScript('components/com_verplan/includes/js/hide_admin.js');

?>

<h1>Vertretungsplan</h1>

<p><?php echo $this->description?></p>

<p><?php echo $this->link; ?></p>

<h2>Upload</h2>

<!-- bitte auf post lassen, da es sonst probleme mit doppelten "option" werten gibt-->
<form name="upload" method="post" enctype="multipart/form-data"	action="index.php?option=com_verplan">
	
	<input size="40" type="file" id="file" name="file" />
	<input type="submit" name="upload" class="uploadbutton" value="Abschicken" />
	
	<!-- anzeige ohne template (praktisch für ajax) -->
	<!--<input type="hidden" name="tmpl" value="component" />-->
		
	<!-- sollen fehler in den regulaeren ausdrücken ignoriert werden? (empfohlen) --> 
	<input type="hidden" name="ignore" value="true" /> 

	<!-- damit die Komponente wieder aufgerufen wird --> 
	<input type="hidden" name="option" value="com_verplan" /> 
	<!-- task laden (in verplanControllrupload -->
	<input type="hidden" name="task" value="upload" /> 
	<input type="hidden" name="boxchecked" value="0" /> 
	<!-- richtiger Controller --> 
	<input type="hidden" name="controller" value="upload" /> 
	<!-- die user ID (unnötig) -->
	<input type="hidden" name="id" value="<?php echo $this->user->id; ?>" />

</form>

<br><br>

<h3 id="options_header" class="expander plus">Optionen/Einstellungen</h3>

<div id="admin_settings_div">
	<?php 
		//get settings
		$settings = $this->settings;
	?>
	
	<form name="settings" method="get" enctype="multipart/form-data" action="index.php?option=com_verplan">
		
		<table class="admin_table">
			<tbody>
				<tr>
					<td class="key"><label for="intitle">maximale Dateigröße (read only)</label></td>
					<td><!-- maximale Dateigröße --> <input size="40" type="text"
						name="max_file_size" value="<?php echo $settings['max_file_size'];?>" /></td>
				</tr>
				<tr>
					<td class="key"><label for="intitle">erlaubte Dateitypen</label></td>
					<td><!-- Dateityp --> <input size="40" type="text"
						name="allowed_filetypes" value="<?php echo $settings['allowed_filetypes'];?>" /></td>
				</tr>
			</tbody>
		</table>
		<input type="submit" name="settings" class="settingsbutton" value="Speichern" />
	
		<!-- damit die Komponente wieder aufgerufen wird --> 
		<input type="hidden" name="option" value="com_verplan" /> 
		<!-- task laden (in verplanControllrsave_settings -->
		<input type="hidden" name="task" value="SetSettings" /> 
		<input type="hidden" name="boxchecked" value="0" /> 
		<!-- richtiger Controller -->
		<input type="hidden" name="controller" value="SetSettings" /> 
		<!-- die user ID (unnötig) -->
		<input type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
	</form>
	<br>
</div>

<h3 id="about_header" class="expander plus">About</h3>

<div id="about_div">
	<p>Komponente zum Einstellen des Vertretungsplanes auf die Website des MCG (http://www.marie-curie-gymnasium-dallgow.de/).</p>
	<ul>
		<li>Lizenz: <a href="http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL">GNU/GPL</a></li>
		<li>Autor: <a href="http://www.dmoritz.bplaced.net">Dominik Moritz</a></li>
		<li>Code: <a href="http://code.google.com/p/verplan/">http://code.google.com/p/verplan/</a></li>
	</ul>
	<p>Verwendete Bibliotheken/Programme/Grafiken</p>
	<ul>
		<li><a href="http://jquery.com/">jQuery</a></li>
		<li><a href="http://plugins.jquery.com/">diverse jQuery Plugins</a></li>
		<li><a href="http://jacksleight.com/old/code">JS Extractor</a></li>
		<li><a href="http://www.oxygen-icons.org/">Icons aus dem Oxygen Package</a></li>
		<li><a href="http://www.preloaders.net">Ajax Indikatoren</a></li>
	</ul>
	<p>Systemvoraussetzungen</p>
	<ul>
		<li>PHP >= 5.3.0</li>
	</ul>
</div>

<?php 
/*
//anzeige ohne template (praktisch für ajax)
$mainframe =& JFactory::getApplication('site'); 
$mainframe->close();
*/
?>
