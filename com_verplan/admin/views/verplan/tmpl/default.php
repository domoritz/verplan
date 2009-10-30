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
$document->addScript('components/com_verplan/includes/js/jquery.datepicker.js');

//Plugins
/*http://milesich.com/timepicker/*/
$document->addScript('components/com_verplan/includes/js/plugins/timepicker.js');
/*http://stackoverflow.com/questions/1028409/jquery-datepicker-and-timepicker-for-same-input-field-to-popup-one-after-another*/
//$document->addScript('components/com_verplan/includes/js/plugins/ui.datetimepicker.js');
/*http://haineault.com/media/jquery/ui-timepickr/page/*/
//$document->addScript('components/com_verplan/includes/js/plugins/km.timepicker.js');

/*http://haineault.com/media/jquery/ui-timepickr/page/*/
$document->addScript('components/com_verplan/includes/js/plugins/jquery.timepickr.js');
$document->addStylesheet('components/com_verplan/includes/css/ui.timepickr.css');
?>

<h1>Vertretungsplan</h1>

<p><?php echo $this->description?></p>

<p><?php echo $this->link; ?></p>

<h2>Upload</h2>

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
	
	<!-- anzeige ohne template (praktisch für ajax) -->
	<!--<input type="hidden" name="tmpl" value="component" />-->
		
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

</form>

<br><br>

<h3 id="options_header" class="expander plus">Optionen/Einstellungen</h3>

<div id="admin_settings_div">
	<?php 
		//get settings
		$settings = $this->settings;
	?>
	
	<form name="settings" method="post" enctype="multipart/form-data" action="index.php?option=com_verplan">
		
		<table class="admin_table">
			<tbody>
				<tr>
					<th colspan="3"><br>Uploads</th>
				</tr>
				<tr>
					<td class="key"><label for="intitle">maximale Dateigröße</label></td>
					<td><!-- maximale Dateigröße --> <input size="40" type="text"
						name="max_file_size" value="<?php echo $settings['max_file_size'][value];?>" /></td>
					<td class="def_td"><?php echo $settings['max_file_size']['default'];?></td>
				</tr>
				<tr>
					<td class="key"><label for="intitle">erlaubte Dateitypen</label></td>
					<td><!-- Dateityp --> <input size="40" type="text"
						name="allowed_filetypes" value="<?php echo $settings['allowed_filetypes'][value];?>" /></td>
					<td class="def_td"><?php echo $settings['allowed_filetypes']['default'];?></td>
				</tr>
				
				
				<tr>
					<th colspan="3"><br>Stand</th>
				</tr>
				<tr>
					<td class="key"><label for="intitle">Pattern Stand</label></td>
					<td><!-- Dateityp --> <input size="40" type="text"
						name="pattern_stand" value="<?php echo $settings['pattern_stand'][value];?>" /></td>
					<td class="def_td"><?php echo $settings['pattern_stand']['default'];?></td>
				</tr>
				
				<tr>
					<td class="key"><label for="intitle">Format Stand</label></td>
					<td><!-- Dateityp --> <input size="40" type="text"
						name="format_stand" value="<?php echo $settings['format_stand'][value];?>" /></td>
					<td class="def_td"><?php echo $settings['format_stand']['default'];?></td>
				</tr>
				
				
				<tr>
					<th colspan="3"><br>Geltungsdatum</th>
				</tr>
				<tr>
					<td class="key"><label for="intitle">Pattern Datum</label></td>
					<td><!-- Dateityp --> <input size="40" type="text"
						name="pattern_date" value="<?php echo $settings['pattern_date'][value];?>" /></td>
					<td class="def_td"><?php echo $settings['pattern_date']['default'];?></td>
				</tr>
				
				<tr>
					<td class="key"><label for="intitle">Format Datum</label></td>
					<td><!-- Dateityp --> <input size="40" type="text"
						name="format_date" value="<?php echo $settings['format_date'][value];?>" /></td>
					<td class="def_td"><?php echo $settings['format_date']['default'];?></td>
				</tr>
				
				<tr>
					<th colspan="3"><br>Plantabelle</th>
				</tr>
				<tr>
					<td class="key"><label for="intitle">Pattern Plantabelle</label></td>
					<td><!-- Dateityp --> <input size="40" type="text"
						name="pattern_plan" value="<?php echo $settings['pattern_plan'][value];?>" /></td>
					<td class="def_td"><?php echo $settings['pattern_plan']['default'];?></td>
				</tr>
				
				<tr>
					<th colspan="3"><br>verzeichnisse</th>
				</tr>
				<tr>
					<td class="key"><label for="intitle">Verzeichnis auf dem Server in der Komponente</label></td>
					<td><!-- Dateityp --> <input size="40" type="text"
						name="upload_dir_comp" value="<?php echo $settings['upload_dir_comp'][value];?>" /></td>
					<td class="def_td"><?php echo $settings['upload_dir_comp']['default'];?></td>
				</tr>
				
				<tr>
					<td class="key"><label for="intitle">Verzeichnis der Vertrtungsplandateien</label></td>
					<td><!-- Dateityp --> <input size="40" type="text"
						name="upload_dir" value="<?php echo $settings['upload_dir'][value];?>" /></td>
					<td class="def_td"><?php echo $settings['upload_dir']['default'];?></td>
				</tr>
			</tbody>
		</table>
		<input type="submit" name="settings" class="settingsbutton" value="Speichern" />
	
		<!-- damit die Komponente wieder aufgerufen wird --> 
		<input type="hidden" name="option" value="com_verplan" /> 
		<!-- task laden (in verplanControllrsave_settings -->
		<input type="hidden" name="task" value="setSettings" /> 
		<input type="hidden" name="boxchecked" value="0" /> 
		<!-- richtiger Controller -->
		<input type="hidden" name="controller" value="settings" /> 
		<!-- die user ID (unnötig) -->
		<input type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
	</form>
	<br>
	
	
	<?php 
		//get settings
		$columns = $this->columns;
	?>
	
	<form name="columns" method="post" enctype="multipart/form-data" action="index.php?option=com_verplan">		
		<table class="admin_table" id="columns_table">
			<tbody>
				<?php 
				echo "<tr>";
				//reset heißt ersten eintrag
				foreach (reset($columns) as $heads => $value) {
					echo "<th>";
					echo $heads;
					echo "</th>";
				}
				echo "</tr>";
				?>
				<?php 
				foreach ($columns as $id => $subarray) {
					echo "<tr>";
					foreach ($subarray as $heads => $value) {
						echo "<td>";
						
						switch ($heads) {
						    case 'published':
						        echo "<select>";
						        for ($i = 0; $i < 2; $i++) {
						        	echo "<option";
						        	echo ($i == $value ? " selected=\"selected\"" : "");
						        	echo ">$i</option>";
						        }
						        echo "</select>";
						        break;
						    case ($heads == 'label' || $heads == 'name' || $heads == 'type'):
						        echo '<input type="text" value="'.$value.'"></input>';
						        break;
						    default:
						        echo $value;
						        break;
						}
						
						echo "</td>";
					}
					echo "</tr>";
				}
				?>
				
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php //var_dump($columns);?>
			</tbody>
		</table>
		<input type="submit" name="columns" class="columnsbutton" value="Speichern" />
	
		<!-- damit die Komponente wieder aufgerufen wird --> 
		<input type="hidden" name="option" value="com_verplan" /> 
		<!-- task laden (in verplanControllrsave_settings -->
		<input type="hidden" name="task" value="setColumns" /> 
		<input type="hidden" name="boxchecked" value="0" /> 
		<!-- richtiger Controller -->
		<input type="hidden" name="controller" value="columns" /> 
		<!-- die user ID (unnötig) -->
		<input type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
	</form>
	
	
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