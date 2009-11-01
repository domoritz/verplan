<?php
/**
 * template inc einstellungen
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-Oct-2009
 */
?>

<h3 id="settings_header" class="expander plus">Einstellungen<span id="ajax_indicator_1">loading...</span></h3>
<div id="admin_settings_div">

<dl id="system-message" class="ajaxresmess_1">
	<dt class="message">Message</dt>
	<dd class="message message fade">
	<ul>
		<li id="ajaxresponse_1"></li>
	</ul>
	</dd>
</dl>

<?php 
	//get settings
	$settings = $this->settings;
?>

<form name="settings_form" id="settings_form" method="post" enctype="multipart/form-data" action="index.php?option=com_verplan">
	
	<table class="admin_table">
		<tbody>
			<tr>
				<th colspan="3"><br>Uploads</th>
			</tr>
			<tr>
				<td class="key"><label for="intitle">maximale Dateigröße</label></td>
				<td>
				<!-- maximale Dateigröße --> 
				<input size="40" type="text" name="max_file_size" value="<?php echo $settings['max_file_size'][value];?>" /></td>
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
	
</div>

