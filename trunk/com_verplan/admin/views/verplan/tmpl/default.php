<?php
/**
 * @version $Id$
 * @package    verplan
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @author     Created on 14-Sep-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

$document =& JFactory::getDocument();

//jQuery support
$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js');
$document->addStylesheet('components/com_verplan/includes/general.css');

?>

<h1>Vertretungsplan</h1>

<p><?php echo $this->description?></p>

<p><?php echo $this->link; ?></p>

<h2>Upload</h2>

<!-- bitte auf post lassen, da es sonst probleme mit doppelten "option" werten gibt-->
<form name="upload" method="post" enctype="multipart/form-data"	action="index.php?option=com_verplan">
	
	<input size="40" type="file" id="file" name="file" />
	<input type="submit" name="upload" class="uploadbutton" value="Einstellen" />

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

<?php 
	//get settings
	$settings = $this->settings;
?>

<form name="settings" method="post" enctype="multipart/form-data" action="index.php?option=com_verplan">
	<h3>Optionen</h3>
	
	<table class="admin_table">
		<tbody>
			<tr>
				<td class="key"><label for="intitle">maximale Dateigröße (not supported yet)</label></td>
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
	
	<!-- sollen unwichtige fehler ignoriert werden? --> 
	<input type="hidden" name="ignore" value="false" /> 

	<!-- damit die Komponente wieder aufgerufen wird --> 
	<input type="hidden" name="option" value="com_verplan" /> 
	<!-- task laden (in verplanControllrsave_settings -->
	<input type="hidden" name="task" value="save_settings" /> 
	<input type="hidden" name="boxchecked" value="0" /> 
	<!-- richtiger Controller --> 
	<input type="hidden" name="controller" value="save_settings" /> 
	<!-- die user ID (unnötig) -->
	<input type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
</form>